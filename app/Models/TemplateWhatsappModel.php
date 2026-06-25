<?php

namespace App\Models;

use CodeIgniter\Model;

class TemplateWhatsappModel extends Model
{
    protected $table            = 'template_whatsapp';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_template', 'kategori', 'isi_pesan', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama_template' => 'required|string|max_length[100]',
        'kategori'      => 'required|string|max_length[50]',
        'isi_pesan'     => 'required|string',
        'status'        => 'required|in_list[aktif,nonaktif]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Mengambil semua template yang statusnya aktif
     * 
     * @return array
     */
    public function getTemplateAktif()
    {
        return $this->where('status', 'aktif')
                    ->orderBy('nama_template', 'ASC')
                    ->findAll();
    }

    /**
     * Mengambil template berdasarkan kategori
     * 
     * @param string $kategori
     * @return array
     */
    public function getByKategori($kategori)
    {
        return $this->where('kategori', $kategori)
                    ->where('status', 'aktif')
                    ->orderBy('nama_template', 'ASC')
                    ->findAll();
    }

    /**
     * Mengambil daftar kategori unik
     * 
     * @return array
     */
    public function getKategoriUnik()
    {
        return $this->where('status', 'aktif')
                    ->distinct()
                    ->select('kategori')
                    ->orderBy('kategori', 'ASC')
                    ->findAll();
    }

    /**
     * Menghitung jumlah template berdasarkan status
     * 
     * @param string $status
     * @return int
     */
    public function countByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    /**
     * Mencari template berdasarkan nama atau kategori
     * 
     * @param string $keyword
     * @return array
     */
    public function search($keyword)
    {
        return $this->where('status', 'aktif')
                    ->groupStart()
                        ->like('nama_template', $keyword)
                        ->orLike('kategori', $keyword)
                        ->orLike('isi_pesan', $keyword)
                    ->groupEnd()
                    ->orderBy('nama_template', 'ASC')
                    ->findAll();
    }

    /**
     * Mengambil template dengan pagination
     * 
     * @param int $perPage
     * @param int $page
     * @return array
     */
    public function getPaginated($perPage = 10, $page = 1)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->paginate($perPage, 'default', $page);
    }

    /**
     * Mengambil total template
     * 
     * @return int
     */
    public function getTotalTemplate()
    {
        return $this->countAllResults();
    }

    /**
     * Mengambil total template aktif
     * 
     * @return int
     */
    public function getTotalTemplateAktif()
    {
        return $this->where('status', 'aktif')->countAllResults();
    }
}
