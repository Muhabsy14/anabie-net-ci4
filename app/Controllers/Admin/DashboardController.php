<?php

namespace App\Controllers\Admin;

use App\Models\PaketLayananModel;
use App\Models\PelangganModel;
use App\Models\PembayaranModel;
use App\Models\PengaduanModel;
use App\Models\TagihanModel;

class DashboardController extends BaseAdminController
{
    public function index()
    {
        $pelangganModel  = model(PelangganModel::class);
        $tagihanModel    = model(TagihanModel::class);
        $pembayaranModel = model(PembayaranModel::class);
        $pengaduanModel  = model(PengaduanModel::class);
        $paketModel      = model(PaketLayananModel::class);

        $totalPelanggan = $pelangganModel->countAllResults();
        $pelangganAktif = $pelangganModel->where('status', 'aktif')->countAllResults();
        $tagihanPending = $tagihanModel->where('status', 'belum_lunas')->countAllResults();
        $pengaduanBaru  = $pengaduanModel->where('status', 'menunggu')->countAllResults();

        $pembayaranBulanIni = $pembayaranModel
            ->selectSum('jumlah', 'jumlah')
            ->where('MONTH(tanggal_bayar)', date('n'), false)
            ->where('YEAR(tanggal_bayar)', date('Y'), false)
            ->first();

        return $this->render('admin/dashboard', [
            'activeMenu'         => 'dashboard',
            'title'              => 'Dashboard ' . $this->roleLabel . ' - Anabie Net',
            'totalPelanggan'     => $totalPelanggan,
            'pelangganAktif'    => $pelangganAktif,
            'tagihanPending'     => $tagihanPending,
            'pengaduanBaru'      => $pengaduanBaru,
            'pendapatanBulanIni' => $pembayaranBulanIni['jumlah'] ?? 0,
            'pelangganTerbaru'   => array_slice($pelangganModel->getWithRelations(), 0, 5),
            'pengaduanTerbaru'   => array_slice($pengaduanModel->getWithPelanggan(), 0, 5),
            'totalPaket'         => $paketModel->where('status', 'aktif')->countAllResults(),
        ]);
    }
}
