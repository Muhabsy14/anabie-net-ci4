<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddOwnerRoleAndBuktiPembayaran extends Migration
{
    public function up()
    {
        $this->db->query("ALTER TABLE users MODIFY role ENUM('owner','admin','pelanggan') NOT NULL");

        $fields = [
            'bukti_pembayaran' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'keterangan',
            ],
        ];
        $this->forge->addColumn('pembayaran', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('pembayaran', 'bukti_pembayaran');
        $this->db->query("ALTER TABLE users MODIFY role ENUM('admin','pelanggan') NOT NULL");
    }
}
