<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class AnabieNetSeeder extends Seeder
{
    public function run()
    {
        $now = Time::now()->toDateTimeString();

        $this->db->table('users')->insertBatch([
            [
                'username'     => 'owner',
                'email'        => 'owner@anabienet.local',
                'password'     => password_hash('owner123', PASSWORD_DEFAULT),
                'role'         => 'owner',
                'nama_lengkap' => 'Owner Anabie Net',
                'no_hp'        => '081234567891',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'username'     => 'admin',
                'email'        => 'admin@anabienet.local',
                'password'     => password_hash('admin123', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'nama_lengkap' => 'Admin Utama',
                'no_hp'        => '081234567890',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'username'     => 'budi',
                'email'        => 'budi@email.com',
                'password'     => password_hash('pelanggan123', PASSWORD_DEFAULT),
                'role'         => 'pelanggan',
                'nama_lengkap' => 'Budi Santoso',
                'no_hp'        => '081298765432',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'username'     => 'siti',
                'email'        => 'siti@email.com',
                'password'     => password_hash('pelanggan123', PASSWORD_DEFAULT),
                'role'         => 'pelanggan',
                'nama_lengkap' => 'Siti Aminah',
                'no_hp'        => '081211223344',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);

        $this->db->table('paket_layanan')->insertBatch([
            [
                'nama_paket'  => 'Home Basic 20Mbps',
                'kecepatan'   => '20 Mbps',
                'harga'       => 250000,
                'deskripsi'   => 'Paket rumahan untuk browsing dan streaming ringan',
                'status'      => 'aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_paket'  => 'Home Pro 50Mbps',
                'kecepatan'   => '50 Mbps',
                'harga'       => 355000,
                'deskripsi'   => 'Paket populer untuk keluarga dan WFH',
                'status'      => 'aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'nama_paket'  => 'Business 100Mbps',
                'kecepatan'   => '100 Mbps',
                'harga'       => 550000,
                'deskripsi'   => 'Paket bisnis UMKM kecamatan Warungasem',
                'status'      => 'aktif',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ]);

        $this->db->table('pelanggan')->insertBatch([
            [
                'user_id'              => 3,
                'kode_pelanggan'       => 'ANB-102938475',
                'alamat'               => 'Jl. Raya Warungasem No. 12, Kec. Warungasem, Kab. Batang',
                'paket_id'             => 2,
                'status'               => 'aktif',
                'tanggal_berlangganan' => '2023-01-15',
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'user_id'              => 4,
                'kode_pelanggan'       => 'ANB-203847561',
                'alamat'               => 'Dukuh Krajan RT 03 RW 02, Warungasem, Batang',
                'paket_id'             => 1,
                'status'               => 'aktif',
                'tanggal_berlangganan' => '2023-06-20',
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
        ]);

        $jatuhTempo = date('Y-m-d', strtotime('+10 days'));

        $this->db->table('tagihan')->insertBatch([
            [
                'pelanggan_id'  => 1,
                'periode_bulan' => (int) date('n'),
                'periode_tahun' => (int) date('Y'),
                'jumlah'        => 355000,
                'status'        => 'belum_lunas',
                'jatuh_tempo'   => $jatuhTempo,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'pelanggan_id'  => 2,
                'periode_bulan' => (int) date('n'),
                'periode_tahun' => (int) date('Y'),
                'jumlah'        => 250000,
                'status'        => 'lunas',
                'jatuh_tempo'   => $jatuhTempo,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ]);

        $bulanLalu = (int) date('n', strtotime('-1 month'));
        $tahunLalu = (int) date('Y', strtotime('-1 month'));

        $this->db->table('tagihan')->insert([
            'pelanggan_id'  => 1,
            'periode_bulan' => $bulanLalu,
            'periode_tahun' => $tahunLalu,
            'jumlah'        => 355000,
            'status'        => 'lunas',
            'jatuh_tempo'   => date('Y-m-d', strtotime('-1 month')),
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);

        $this->db->table('pembayaran')->insertBatch([
            [
                'tagihan_id'       => 3,
                'pelanggan_id'     => 1,
                'tanggal_bayar'    => date('Y-m-d', strtotime('-5 days')),
                'jumlah'           => 355000,
                'metode'           => 'Transfer Bank',
                'keterangan'       => 'Pembayaran tagihan bulan lalu',
                'bukti_pembayaran' => null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'tagihan_id'       => 2,
                'pelanggan_id'     => 2,
                'tanggal_bayar'    => date('Y-m-d', strtotime('-2 days')),
                'jumlah'           => 250000,
                'metode'           => 'Tunai',
                'keterangan'       => 'Bayar di kantor Anabie Net',
                'bukti_pembayaran' => null,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ]);

        $this->db->table('pengaduan')->insert([
            'pelanggan_id'  => 1,
            'judul'         => 'Koneksi lambat di malam hari',
            'isi'           => 'Sejak 3 hari terakhir kecepatan turun drastis setelah pukul 20.00 WIB.',
            'status'        => 'diproses',
            'balasan_admin' => 'Tim teknis akan melakukan pengecekan node di area Warungasem.',
            'created_at'    => $now,
            'updated_at'    => $now,
        ]);
    }
}
