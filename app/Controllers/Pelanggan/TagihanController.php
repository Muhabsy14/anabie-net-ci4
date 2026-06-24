<?php

namespace App\Controllers\Pelanggan;

use App\Models\TagihanModel;

class TagihanController extends BasePelangganController
{
    public function index()
    {
        $pelangganId = (int) session()->get('pelanggan_id');

        return $this->render('pelanggan/tagihan/index', [
            'activeMenu' => 'tagihan',
            'title'      => 'Tagihan Saya - Anabie Net',
            'tagihan'    => model(TagihanModel::class)->getWithPelanggan($pelangganId),
        ]);
    }
}
