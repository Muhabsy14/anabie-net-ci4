<?php

namespace App\Models;

use CodeIgniter\Model;

class PaketLayananModel extends Model
{
    protected $table            = 'paket_layanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_paket', 'kecepatan', 'harga', 'deskripsi', 'status'];
    protected $useTimestamps    = true;
}
