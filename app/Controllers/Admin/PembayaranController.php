<?php

namespace App\Controllers\Admin;

use App\Models\PelangganModel;
use App\Models\PembayaranModel;
use App\Models\TagihanModel;

class PembayaranController extends BaseAdminController
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

        return $this->render('admin/pembayaran/index', [
            'activeMenu'  => 'pembayaran',
            'title'       => 'Kelola Pembayaran - Anabie Net',
            'pembayaran'  => model(PembayaranModel::class)->getWithDetails(),
            'tagihan'     => $tagihan,
            'pelanggan'   => model(PelangganModel::class)->getWithJatuhTempo($bulan, $tahun),
            'bulan'       => $bulan,
            'tahun'       => $tahun,
        ]);
    }

    public function store()
    {
        $tagihanId   = (int) $this->request->getPost('tagihan_id');
        $pelangganId = (int) $this->request->getPost('pelanggan_id');
        $jumlah      = $this->request->getPost('jumlah');
        $metode      = $this->request->getPost('metode');

        $buktiPath = $this->uploadBuktiPembayaran();

        model(PembayaranModel::class)->insert([
            'tagihan_id'       => $tagihanId ?: null,
            'pelanggan_id'     => $pelangganId,
            'tanggal_bayar'    => $this->request->getPost('tanggal_bayar') ?? date('Y-m-d'),
            'jumlah'           => $jumlah,
            'metode'           => $metode,
            'keterangan'       => $this->request->getPost('keterangan'),
            'bukti_pembayaran' => $buktiPath,
        ]);

        if ($tagihanId) {
            model(TagihanModel::class)->update($tagihanId, ['status' => 'lunas']);
        }

        return $this->redirectPanel('pembayaran', 'Pembayaran berhasil dicatat.');
    }

    protected function uploadBuktiPembayaran(): ?string
    {
        $bukti = $this->request->getFile('bukti_pembayaran');

        if (! $bukti || ! $bukti->isValid() || $bukti->hasMoved()) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
        if (! in_array($bukti->getMimeType(), $allowed, true)) {
            return null;
        }

        if ($bukti->getSize() > 2 * 1024 * 1024) {
            return null;
        }

        $newName = $bukti->getRandomName();
        $bukti->move(FCPATH . 'uploads/bukti', $newName);

        return $newName;
    }
}
