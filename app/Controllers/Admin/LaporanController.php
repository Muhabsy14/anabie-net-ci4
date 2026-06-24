<?php

namespace App\Controllers\Admin;

use App\Libraries\LaporanPdfService;
use App\Models\PembayaranModel;
use App\Models\PelangganModel;
use App\Models\TagihanModel;

class LaporanController extends BaseAdminController
{
    protected string $jenisLaporan = 'operasional';

    public function index()
    {
        $data = $this->getLaporanData();

        return $this->render('admin/laporan/index', array_merge($data, [
            'activeMenu'   => 'laporan',
            'title'        => $this->jenisLaporan === 'resmi'
                ? 'Laporan - Anabie Net'
                : 'Laporan Operasional - Anabie Net',
            'jenisLaporan' => $this->jenisLaporan,
        ]));
    }

    public function pdf()
    {
        $data = array_merge($this->getLaporanData(), [
            'jenisLaporan' => $this->jenisLaporan,
        ]);

        helper('anabie');
        $html = view('admin/laporan/pdf', $data);

        $filename = sprintf(
            'laporan-%s-anabie-net-%s-%s.pdf',
            $this->jenisLaporan,
            $data['bulan'],
            $data['tahun']
        );

        (new LaporanPdfService())->streamFromHtml($html, $filename);
    }

    protected function getLaporanData(): array
    {
        $bulan = (int) ($this->request->getGet('bulan') ?: date('n'));
        $tahun = (int) ($this->request->getGet('tahun') ?: date('Y'));

        $pembayaranModel = model(PembayaranModel::class);
        $tagihanModel    = model(TagihanModel::class);

        $pembayaran = $pembayaranModel
            ->select('pembayaran.*, u.nama_lengkap, p.kode_pelanggan')
            ->join('pelanggan p', 'p.id = pembayaran.pelanggan_id')
            ->join('users u', 'u.id = p.user_id')
            ->where('MONTH(tanggal_bayar)', $bulan, false)
            ->where('YEAR(tanggal_bayar)', $tahun, false)
            ->orderBy('tanggal_bayar', 'ASC')
            ->findAll();

        $totalPendapatan = array_sum(array_column($pembayaran, 'jumlah'));

        $tagihan = $tagihanModel
            ->where('periode_bulan', $bulan)
            ->where('periode_tahun', $tahun)
            ->findAll();

        $lunas = count(array_filter($tagihan, static fn ($t) => $t['status'] === 'lunas'));
        $belum = count(array_filter($tagihan, static fn ($t) => $t['status'] === 'belum_lunas'));

        return [
            'bulan'           => $bulan,
            'tahun'           => $tahun,
            'periodeLabel'    => nama_bulan($bulan) . ' ' . $tahun,
            'pembayaran'      => $pembayaran,
            'totalPendapatan' => $totalPendapatan,
            'totalPelanggan'  => model(PelangganModel::class)->countAllResults(),
            'tagihanLunas'    => $lunas,
            'tagihanBelum'    => $belum,
            'dicetakOleh'     => session()->get('nama_lengkap'),
            'dicetakPada'     => date('d/m/Y H:i'),
        ];
    }
}
