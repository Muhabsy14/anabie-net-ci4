<?php

namespace App\Models;

use CodeIgniter\Model;

class PengaduanModel extends Model
{
    protected $table            = 'pengaduan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['pelanggan_id', 'judul', 'isi', 'status', 'balasan_admin'];
    protected $useTimestamps    = true;

    public function getWithPelanggan(?int $pelangganId = null)
    {
        $builder = $this->db->table($this->table . ' pg')
            ->select('pg.*, p.kode_pelanggan, u.nama_lengkap')
            ->join('pelanggan p', 'p.id = pg.pelanggan_id')
            ->join('users u', 'u.id = p.user_id')
            ->orderBy('pg.created_at', 'DESC');

        if ($pelangganId !== null) {
            $builder->where('pg.pelanggan_id', $pelangganId);
        }

        return $builder->get()->getResultArray();
    }
}
