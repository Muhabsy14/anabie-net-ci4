<?php

namespace App\Controllers\Pelanggan;

use App\Models\PengaduanModel;
use App\Models\TagihanModel;

class DashboardController extends BasePelangganController
{
    public function index()
    {
        $pelangganId = (int) session()->get('pelanggan_id');
        $tagihanAktif = model(TagihanModel::class)->getTagihanAktif($pelangganId);

        return $this->render('pelanggan/dashboard', [
            'activeMenu'   => 'dashboard',
            'title'        => 'Dashboard Pelanggan - Anabie Net',
            'tagihanAktif' => $tagihanAktif,
            'pengaduan'    => model(PengaduanModel::class)->getWithPelanggan($pelangganId),
        ]);
    }
}
