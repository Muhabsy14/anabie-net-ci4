<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnabieNetTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'username'   => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 100],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'ENUM', 'constraint' => ['owner', 'admin', 'pelanggan']],
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 100],
            'no_hp'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'foto'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'nama_paket'           => ['type' => 'VARCHAR', 'constraint' => 100],
            'kecepatan'            => ['type' => 'VARCHAR', 'constraint' => 50],
            'harga'                => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'deskripsi'            => ['type' => 'TEXT', 'null' => true],
            'status'               => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif'], 'default' => 'aktif'],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('paket_layanan');

        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'              => ['type' => 'INT', 'unsigned' => true],
            'kode_pelanggan'       => ['type' => 'VARCHAR', 'constraint' => 20, 'unique' => true],
            'alamat'               => ['type' => 'TEXT'],
            'paket_id'             => ['type' => 'INT', 'unsigned' => true],
            'status'               => ['type' => 'ENUM', 'constraint' => ['aktif', 'nonaktif', 'suspend'], 'default' => 'aktif'],
            'tanggal_berlangganan' => ['type' => 'DATE'],
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('paket_id', 'paket_layanan', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('pelanggan');

        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pelanggan_id'  => ['type' => 'INT', 'unsigned' => true],
            'periode_bulan' => ['type' => 'TINYINT', 'unsigned' => true],
            'periode_tahun' => ['type' => 'SMALLINT', 'unsigned' => true],
            'jumlah'        => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'status'        => ['type' => 'ENUM', 'constraint' => ['belum_lunas', 'lunas'], 'default' => 'belum_lunas'],
            'jatuh_tempo'   => ['type' => 'DATE'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tagihan');

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'tagihan_id'   => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'pelanggan_id' => ['type' => 'INT', 'unsigned' => true],
            'tanggal_bayar'=> ['type' => 'DATE'],
            'jumlah'       => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'metode'       => ['type' => 'VARCHAR', 'constraint' => 50],
            'keterangan'       => ['type' => 'TEXT', 'null' => true],
            'bukti_pembayaran' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tagihan_id', 'tagihan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembayaran');

        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pelanggan_id'  => ['type' => 'INT', 'unsigned' => true],
            'judul'         => ['type' => 'VARCHAR', 'constraint' => 150],
            'isi'           => ['type' => 'TEXT'],
            'status'        => ['type' => 'ENUM', 'constraint' => ['menunggu', 'diproses', 'selesai'], 'default' => 'menunggu'],
            'balasan_admin' => ['type' => 'TEXT', 'null' => true],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pengaduan');

        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'pelanggan_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'pesan'        => ['type' => 'TEXT'],
            'status_kirim' => ['type' => 'ENUM', 'constraint' => ['terkirim', 'gagal', 'draft'], 'default' => 'terkirim'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('pelanggan_id', 'pelanggan', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('notifikasi_whatsapp');
    }

    public function down()
    {
        $this->forge->dropTable('notifikasi_whatsapp', true);
        $this->forge->dropTable('pengaduan', true);
        $this->forge->dropTable('pembayaran', true);
        $this->forge->dropTable('tagihan', true);
        $this->forge->dropTable('pelanggan', true);
        $this->forge->dropTable('paket_layanan', true);
        $this->forge->dropTable('users', true);
    }
}
