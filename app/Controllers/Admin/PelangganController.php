<?php

namespace App\Controllers\Admin;

use App\Models\PaketLayananModel;
use App\Models\PelangganModel;
use App\Models\UserModel;

class PelangganController extends BaseAdminController
{
    public function index()
    {
        $bulan = (int) ($this->request->getGet('bulan') ?: date('n'));
        $tahun = (int) ($this->request->getGet('tahun') ?: date('Y'));

        return $this->render('admin/pelanggan/index', [
            'activeMenu' => 'pelanggan',
            'title'      => 'Kelola Pelanggan - Anabie Net',
            'pelanggan'  => model(PelangganModel::class)->getWithJatuhTempo($bulan, $tahun),
            'paket'      => model(PaketLayananModel::class)->where('status', 'aktif')->findAll(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_lengkap' => 'required|min_length[3]',
            'username'     => 'required|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'no_hp'        => 'required',
            'alamat'       => 'required',
            'paket_id'     => 'required|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = model(UserModel::class);
        $userId    = $userModel->insert([
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => 'pelanggan',
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ]);

        model(PelangganModel::class)->insert([
            'user_id'              => $userId,
            'kode_pelanggan'       => model(PelangganModel::class)->generateKode(),
            'alamat'               => $this->request->getPost('alamat'),
            'paket_id'             => $this->request->getPost('paket_id'),
            'status'               => $this->request->getPost('status') ?? 'aktif',
            'tanggal_berlangganan' => $this->request->getPost('tanggal_berlangganan') ?? date('Y-m-d'),
        ]);

        return $this->redirectPanel('pelanggan', 'Pelanggan berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $pelangganModel = model(PelangganModel::class);
        $pelanggan      = $pelangganModel->find($id);

        if (! $pelanggan) {
            return $this->redirectPanel('pelanggan', 'Data tidak ditemukan.', 'error');
        }

        $update = [
            'alamat'   => $this->request->getPost('alamat'),
            'paket_id' => $this->request->getPost('paket_id'),
            'status'   => $this->request->getPost('status'),
        ];
        if ($tgl = $this->request->getPost('tanggal_berlangganan')) {
            $update['tanggal_berlangganan'] = $tgl;
        }
        $pelangganModel->update($id, $update);

        model(UserModel::class)->update($pelanggan['user_id'], [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_hp'        => $this->request->getPost('no_hp'),
            'email'        => $this->request->getPost('email'),
        ]);

        return $this->redirectPanel('pelanggan', 'Data pelanggan diperbarui.');
    }

    public function delete(int $id)
    {
        $pelanggan = model(PelangganModel::class)->find($id);
        if ($pelanggan) {
            model(UserModel::class)->delete($pelanggan['user_id']);
        }

        return $this->redirectPanel('pelanggan', 'Pelanggan dihapus.');
    }
}
