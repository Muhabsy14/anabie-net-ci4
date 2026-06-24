<?php

namespace App\Controllers;

use App\Models\PelangganModel;
use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {
            return $this->redirectByRole();
        }

        $loginHint = get_cookie('login_hint');

        return view('auth/login', [
            'title'     => 'Login - Anabie Net',
            'role'      => $this->request->getGet('role') ?? 'pelanggan',
            'loginHint' => $loginHint ?: old('login'),
        ]);
    }

    public function attempt()
    {
        $rules = [
            'login'    => 'required',
            'password' => 'required',
            'role'     => 'required|in_list[owner,admin,pelanggan]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $login    = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $role     = $this->request->getPost('role');

        $userModel = model(UserModel::class);
        $user      = $userModel->findByLogin($login);

        if (! $user || ! password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Username/email atau kata sandi salah.');
        }

        if ($user['role'] !== $role) {
            return redirect()->back()->withInput()->with('error', 'Akun tidak sesuai dengan tab login yang dipilih.');
        }

        $sessionData = [
            'logged_in'    => true,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'nama_lengkap' => $user['nama_lengkap'],
            'email'        => $user['email'],
            'no_hp'        => $user['no_hp'],
            'role'         => $user['role'],
        ];

        if ($user['role'] === 'pelanggan') {
            $pelanggan = model(PelangganModel::class)->findByUserId((int) $user['id']);
            if ($pelanggan) {
                $sessionData['pelanggan_id']   = $pelanggan['id'];
                $sessionData['kode_pelanggan'] = $pelanggan['kode_pelanggan'];
            }
        }

        session()->set($sessionData);

        if ($this->request->getPost('remember')) {
            set_cookie([
                'name'     => 'login_hint',
                'value'    => $user['username'],
                'expire'   => 60 * 60 * 24 * 30,
                'httponly' => true,
                'secure'   => false,
            ]);
        } else {
            delete_cookie('login_hint');
        }

        return $this->redirectByRole();
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('success', 'Anda telah keluar dari sistem.');
    }

    private function redirectByRole()
    {
        return match (session()->get('role')) {
            'owner'     => redirect()->to('/owner/dashboard'),
            'admin'     => redirect()->to('/admin/dashboard'),
            default     => redirect()->to('/pelanggan/dashboard'),
        };
    }
}
