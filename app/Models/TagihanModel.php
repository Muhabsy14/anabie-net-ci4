<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table            = 'tagihan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'pelanggan_id', 'periode_bulan', 'periode_tahun', 'jumlah', 'status', 'jatuh_tempo',
    ];
    protected $useTimestamps = true;

    public function getWithPelanggan(?int $pelangganId = null)
    {
        $builder = $this->db->table($this->table . ' t')
            ->select('t.*, p.kode_pelanggan, p.tanggal_berlangganan, u.nama_lengkap')
            ->join('pelanggan p', 'p.id = t.pelanggan_id')
            ->join('users u', 'u.id = p.user_id')
            ->orderBy('t.periode_tahun', 'DESC')
            ->orderBy('t.periode_bulan', 'DESC');

        if ($pelangganId !== null) {
            $builder->where('t.pelanggan_id', $pelangganId);
        }

        return $builder->get()->getResultArray();
    }

    public function getTagihanAktif(int $pelangganId): ?array
    {
        return $this->where('pelanggan_id', $pelangganId)
            ->where('status', 'belum_lunas')
            ->orderBy('jatuh_tempo', 'ASC')
            ->first();
    }
}
