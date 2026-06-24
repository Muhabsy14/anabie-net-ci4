<?php

namespace App\Controllers\Pelanggan;

use App\Controllers\BaseController;
use App\Models\PelangganModel;

class BasePelangganController extends BaseController
{
    protected ?array $pelanggan = null;

    protected function initPelanggan()
    {
        $pelangganId = session()->get('pelanggan_id');
        if ($pelangganId) {
            $this->pelanggan = model(PelangganModel::class)->getWithRelations((int) $pelangganId);
        }
    }

    protected function render(string $view, array $data = [])
    {
        $this->initPelanggan();

        $data['title']      = $data['title'] ?? 'Pelanggan - Anabie Net';
        $data['activeMenu'] = $data['activeMenu'] ?? '';
        $data['pelanggan']  = $this->pelanggan;
        $data['user']       = [
            'nama' => session()->get('nama_lengkap'),
            'kode' => session()->get('kode_pelanggan'),
        ];

        return view('layouts/pelanggan', array_merge($data, [
            'content' => view($view, $data),
        ]));
    }
}
