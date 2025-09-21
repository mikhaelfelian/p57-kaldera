<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblLinks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'links' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'https://<domain>',
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['0','1'],
                'default'    => '1',
                'comment'    => '0=nonaktif, 1=aktif',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_links', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_links', true);
    }
}
