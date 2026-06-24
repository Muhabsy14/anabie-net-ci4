<?php

namespace App\Controllers\Admin;

use App\Models\PengaduanModel;

class PengaduanController extends BaseAdminController
{
    public function index()
    {
        return $this->render('admin/pengaduan/index', [
            'activeMenu' => 'pengaduan',
            'title'      => 'Kelola Pengaduan - Anabie Net',
            'pengaduan'  => model(PengaduanModel::class)->getWithPelanggan(),
        ]);
    }

    public function update(int $id)
    {
        model(PengaduanModel::class)->update($id, [
            'status'        => $this->request->getPost('status'),
            'balasan_admin' => $this->request->getPost('balasan_admin'),
        ]);

        return $this->redirectPanel('pengaduan', 'Pengaduan diperbarui.');
    }
}
