<?php

namespace App\Models;

use CodeIgniter\Model;

class NotifikasiWhatsappModel extends Model
{
    protected $table         = 'notifikasi_whatsapp';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'pelanggan_id', 'pesan', 'status_kirim',
        'metode_kirim', 'wa_message_id', 'api_error',
    ];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    public function getRiwayat(int $limit = 20): array
    {
        return $this->db->table($this->table . ' n')
            ->select('n.*, u.nama_lengkap, p.kode_pelanggan')
            ->join('pelanggan p', 'p.id = n.pelanggan_id', 'left')
            ->join('users u', 'u.id = p.user_id', 'left')
            ->orderBy('n.created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResultArray();
    }
}
