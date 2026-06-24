<?php

namespace App\Controllers\Pelanggan;

use App\Models\UserModel;

class ProfilController extends BasePelangganController
{
    public function index()
    {
        return $this->render('pelanggan/profil/index', [
            'activeMenu' => 'profil',
            'title'      => 'Profil - Anabie Net',
            'profil'     => model(UserModel::class)->find(session()->get('user_id')),
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

        return redirect()->to('/pelanggan/profil')->with('success', 'Profil berhasil diperbarui.');
    }
}
