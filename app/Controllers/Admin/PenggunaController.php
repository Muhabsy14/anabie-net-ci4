<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class PenggunaController extends BaseAdminController
{
    public function index()
    {
        return $this->render('admin/pengguna/index', [
            'activeMenu' => 'admin',
            'title'      => 'Kelola Admin - Anabie Net',
            'pengguna'   => model(UserModel::class)->where('role', 'admin')->findAll(),
        ]);
    }

    public function store()
    {
        if (! $this->validate([
            'username'     => 'required|is_unique[users.username]',
            'email'        => 'required|valid_email|is_unique[users.email]',
            'password'     => 'required|min_length[6]',
            'nama_lengkap' => 'required',
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        model(UserModel::class)->insert([
            'username'     => $this->request->getPost('username'),
            'email'        => $this->request->getPost('email'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => 'admin',
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ]);

        return $this->redirectPanel('admin', 'Pengguna admin ditambahkan.');
    }

    public function update(int $id)
    {
        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ];

        if ($password = $this->request->getPost('password')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        model(UserModel::class)->update($id, $data);

        return $this->redirectPanel('admin', 'Pengguna diperbarui.');
    }

    public function delete(int $id)
    {
        if ((int) $id === (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun yang sedang login.');
        }

        model(UserModel::class)->delete($id);

        return $this->redirectPanel('admin', 'Pengguna dihapus.');
    }
}
