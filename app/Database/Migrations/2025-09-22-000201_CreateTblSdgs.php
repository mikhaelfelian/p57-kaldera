<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblSdgs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'year' => [
                'type' => 'YEAR',
                'null' => false,
            ],
            'month' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => false,
                'default'    => '01',
            ],
            'uraian' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'fupload' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tbl_sdgs', true);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_sdgs', true);
    }
}


