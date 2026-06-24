<?php

namespace App\Models;

use CodeIgniter\Model;

class PelangganModel extends Model
{
    protected $table            = 'pelanggan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id', 'kode_pelanggan', 'alamat', 'paket_id', 'status', 'tanggal_berlangganan',
    ];
    protected $useTimestamps = true;

    public function getWithRelations(?int $id = null)
    {
        $builder = $this->db->table($this->table . ' p')
            ->select('p.*, u.nama_lengkap, u.username, u.email, u.no_hp, pl.nama_paket, pl.kecepatan, pl.harga')
            ->join('users u', 'u.id = p.user_id')
            ->join('paket_layanan pl', 'pl.id = p.paket_id');

        if ($id !== null) {
            return $builder->where('p.id', $id)->get()->getRowArray();
        }

        return $builder->orderBy('p.id', 'DESC')->get()->getResultArray();
    }

    public function findByUserId(int $userId): ?array
    {
        return $this->where('user_id', $userId)->first();
    }

    public function generateKode(): string
    {
        return 'ANB-' . strtoupper(substr(uniqid(), -9));
    }

    /**
     * @return list<array<string, mixed>>
     */
    public function getWithJatuhTempo(?int $bulan = null, ?int $tahun = null, bool $sortByDueDay = true): array
    {
        helper('anabie');

        $rows = array_map(
            static fn (array $row) => pelanggan_dengan_jatuh_tempo($row, $bulan, $tahun),
            $this->getWithRelations()
        );

        if ($sortByDueDay) {
            usort($rows, static function (array $a, array $b) {
                return ($a['hari_jatuh_tempo'] ?? 0) <=> ($b['hari_jatuh_tempo'] ?? 0);
            });
        }

        return $rows;
    }
}
