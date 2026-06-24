<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'username', 'email', 'password', 'role', 'nama_lengkap', 'no_hp', 'foto',
    ];
    protected $useTimestamps = true;

    public function findByLogin(string $login): ?array
    {
        return $this->groupStart()
            ->where('username', $login)
            ->orWhere('email', $login)
            ->groupEnd()
            ->first();
    }
}
