<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RedirectResponse;

class BaseAdminController extends BaseController
{
    protected string $panelPrefix = 'admin';
    protected string $layoutView  = 'layouts/admin';
    protected string $roleLabel   = 'Administrator';

    protected function render(string $view, array $data = [])
    {
        $data['panelPrefix'] = $this->panelPrefix;
        $data['title']       = $data['title'] ?? 'Admin - Anabie Net';
        $data['activeMenu']  = $data['activeMenu'] ?? '';
        $data['user']        = [
            'nama' => session()->get('nama_lengkap'),
            'role' => $this->roleLabel,
        ];

        return view($this->layoutView, array_merge($data, [
            'content' => view($view, $data),
        ]));
    }

    protected function redirectPanel(string $path, ?string $message = null, string $type = 'success'): RedirectResponse
    {
        $url = '/' . $this->panelPrefix . '/' . ltrim($path, '/');
        $redirect = redirect()->to($url);

        return $message ? $redirect->with($type, $message) : $redirect;
    }
}
