<?php

namespace App\Controllers\Admin;

use App\Models\PaketLayananModel;

class PaketController extends BaseAdminController
{
    public function index()
    {
        return $this->render('admin/paket/index', [
            'activeMenu' => 'paket',
            'title'      => 'Kelola Paket & Layanan - Anabie Net',
            'paket'      => model(PaketLayananModel::class)->findAll(),
        ]);
    }

    public function store()
    {
        if (! $this->validate([
            'nama_paket' => 'required',
            'kecepatan'  => 'required',
            'harga'      => 'required|decimal',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(PaketLayananModel::class)->insert([
            'nama_paket'  => $this->request->getPost('nama_paket'),
            'kecepatan'   => $this->request->getPost('kecepatan'),
            'harga'       => $this->request->getPost('harga'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'status'      => $this->request->getPost('status') ?? 'aktif',
        ]);

        return $this->redirectPanel('paket', 'Paket layanan ditambahkan.');
    }

    public function update(int $id)
    {
        model(PaketLayananModel::class)->update($id, [
            'nama_paket' => $this->request->getPost('nama_paket'),
            'kecepatan'  => $this->request->getPost('kecepatan'),
            'harga'      => $this->request->getPost('harga'),
            'deskripsi'  => $this->request->getPost('deskripsi'),
            'status'     => $this->request->getPost('status'),
        ]);

        return $this->redirectPanel('paket', 'Paket layanan diperbarui.');
    }

    public function delete(int $id)
    {
        model(PaketLayananModel::class)->delete($id);

        return $this->redirectPanel('paket', 'Paket dihapus.');
    }
}
