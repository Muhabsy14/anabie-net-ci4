<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;

class ProfilController extends BaseAdminController
{
    public function index()
    {
        $user = model(UserModel::class)->find(session()->get('user_id'));

        return $this->render('admin/profil/index', [
            'activeMenu' => 'profil',
            'title'      => 'Profil ' . $this->roleLabel . ' - Anabie Net',
            'profil'     => $user,
        ]);
    }

    public function update()
    {
        $userId = (int) session()->get('user_id');
        $data   = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'email'        => $this->request->getPost('email'),
            'no_hp'        => $this->request->getPost('no_hp'),
        ];

        if ($password = $this->request->getPost('password')) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        model(UserModel::class)->update($userId, $data);
        session()->set('nama_lengkap', $data['nama_lengkap']);

        return $this->redirectPanel('profil', 'Profil berhasil diperbarui.');
    }
}
