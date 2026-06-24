<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'pembayaran';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'tagihan_id', 'pelanggan_id', 'tanggal_bayar', 'jumlah', 'metode', 'keterangan', 'bukti_pembayaran',
    ];
    protected $useTimestamps = true;

    public function getWithDetails(?int $pelangganId = null)
    {
        $builder = $this->db->table($this->table . ' pb')
            ->select('pb.*, p.kode_pelanggan, u.nama_lengkap, t.periode_bulan, t.periode_tahun')
            ->join('pelanggan p', 'p.id = pb.pelanggan_id')
            ->join('users u', 'u.id = p.user_id')
            ->join('tagihan t', 't.id = pb.tagihan_id', 'left')
            ->orderBy('pb.tanggal_bayar', 'DESC');

        if ($pelangganId !== null) {
            $builder->where('pb.pelanggan_id', $pelangganId);
        }

        return $builder->get()->getResultArray();
    }
}
