<?php

namespace App\Controllers\Pelanggan;

use App\Models\PengaduanModel;

class PengaduanController extends BasePelangganController
{
    public function index()
    {
        $pelangganId = (int) session()->get('pelanggan_id');

        return $this->render('pelanggan/pengaduan/index', [
            'activeMenu' => 'pengaduan',
            'title'      => 'Ajukan Pengaduan - Anabie Net',
            'pengaduan'  => model(PengaduanModel::class)->getWithPelanggan($pelangganId),
        ]);
    }

    public function store()
    {
        if (! $this->validate([
            'judul' => 'required|min_length[5]',
            'isi'   => 'required|min_length[10]',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(PengaduanModel::class)->insert([
            'pelanggan_id' => session()->get('pelanggan_id'),
            'judul'        => $this->request->getPost('judul'),
            'isi'          => $this->request->getPost('isi'),
            'status'       => 'menunggu',
        ]);

        return redirect()->to('/pelanggan/pengaduan')->with('success', 'Pengaduan berhasil diajukan.');
    }
}
