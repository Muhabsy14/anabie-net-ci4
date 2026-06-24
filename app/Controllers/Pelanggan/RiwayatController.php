<?php

namespace App\Controllers\Pelanggan;

use App\Models\PembayaranModel;

class RiwayatController extends BasePelangganController
{
    public function index()
    {
        $pelangganId = (int) session()->get('pelanggan_id');

        return $this->render('pelanggan/riwayat/index', [
            'activeMenu' => 'riwayat',
            'title'      => 'Riwayat Pembayaran - Anabie Net',
            'riwayat'    => model(PembayaranModel::class)->getWithDetails($pelangganId),
        ]);
    }
}
