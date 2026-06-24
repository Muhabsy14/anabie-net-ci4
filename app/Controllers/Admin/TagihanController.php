<?php

namespace App\Controllers\Admin;

use App\Models\PelangganModel;
use App\Models\TagihanModel;

class TagihanController extends BaseAdminController
{
    public function index()
    {
        $bulan = (int) ($this->request->getGet('bulan') ?: date('n'));
        $tahun = (int) ($this->request->getGet('tahun') ?: date('Y'));

        $tagihan = model(TagihanModel::class)->getWithPelanggan();
        helper('anabie');
        foreach ($tagihan as &$t) {
            if (! empty($t['tanggal_berlangganan'])) {
                $t['jatuh_tempo_diharapkan'] = hitung_jatuh_tempo(
                    $t['tanggal_berlangganan'],
                    (int) $t['periode_bulan'],
                    (int) $t['periode_tahun']
                );
            }
        }
        unset($t);

        return $this->render('admin/tagihan/index', [
            'activeMenu' => 'tagihan',
            'title'      => 'Kelola Tagihan - Anabie Net',
            'tagihan'    => $tagihan,
            'pelanggan'  => model(PelangganModel::class)->getWithJatuhTempo($bulan, $tahun),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
        ]);
    }

    public function store()
    {
        $pelangganId = (int) $this->request->getPost('pelanggan_id');
        $pelanggan   = model(PelangganModel::class)->getWithRelations($pelangganId);

        if (! $pelanggan) {
            return redirect()->back()->with('error', 'Pelanggan tidak ditemukan.');
        }

        $bulan = (int) ($this->request->getPost('periode_bulan') ?: date('n'));
        $tahun = (int) ($this->request->getPost('periode_tahun') ?: date('Y'));

        $exists = model(TagihanModel::class)
            ->where('pelanggan_id', $pelangganId)
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->first();

        if ($exists) {
            return redirect()->back()->with('error', 'Tagihan periode ini sudah ada.');
        }

        helper('anabie');
        $jatuhTempo = $this->request->getPost('jatuh_tempo');
        if (! $jatuhTempo && ! empty($pelanggan['tanggal_berlangganan'])) {
            $jatuhTempo = hitung_jatuh_tempo($pelanggan['tanggal_berlangganan'], $bulan, $tahun);
        }
        $jatuhTempo ??= date('Y-m-d', strtotime('+10 days'));

        model(TagihanModel::class)->insert([
            'pelanggan_id'  => $pelangganId,
            'periode_bulan' => $bulan,
            'periode_tahun' => $tahun,
            'jumlah'        => $pelanggan['harga'],
            'status'        => 'belum_lunas',
            'jatuh_tempo'   => $jatuhTempo,
        ]);

        return $this->redirectPanel(
            'tagihan',
            'Tagihan berhasil dibuat. Jatuh tempo: ' . format_tanggal_indo($jatuhTempo)
        );
    }

    public function update(int $id)
    {
        $tagihanModel = model(TagihanModel::class);
        $tagihan      = $tagihanModel->find($id);

        if (! $tagihan) {
            return redirect()->back()->with('error', 'Tagihan tidak ditemukan.');
        }

        $tagihanModel->update($id, [
            'jumlah'      => $this->request->getPost('jumlah'),
            'status'      => $this->request->getPost('status'),
            'jatuh_tempo' => $this->request->getPost('jatuh_tempo'),
        ]);

        return $this->redirectPanel('tagihan', 'Tagihan berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        model(TagihanModel::class)->delete($id);

        return $this->redirectPanel('tagihan', 'Tagihan dihapus.');
    }
}
