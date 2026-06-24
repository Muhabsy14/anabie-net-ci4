<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWhatsAppApiFieldsToNotifikasi extends Migration
{
    public function up()
    {
        $fields = [
            'metode_kirim' => [
                'type'       => 'ENUM',
                'constraint' => ['cloud_api', 'wa_me'],
                'default'    => 'wa_me',
                'after'      => 'status_kirim',
            ],
            'wa_message_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'metode_kirim',
            ],
            'api_error' => [
                'type' => 'TEXT',
                'null' => true,
                'after'=> 'wa_message_id',
            ],
        ];

        $this->forge->addColumn('notifikasi_whatsapp', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('notifikasi_whatsapp', ['metode_kirim', 'wa_message_id', 'api_error']);
    }
}
