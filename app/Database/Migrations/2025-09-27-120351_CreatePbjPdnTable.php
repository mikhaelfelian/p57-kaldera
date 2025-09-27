<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePbjPdnTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => false,
            ],
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => false,
            ],
            'pagu_rup_tagging_pdn' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'realisasi_pdn' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'indeks' => [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'default' => 0,
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'uploaded_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addKey(['tahun', 'bulan']);
        $this->forge->createTable('tbl_pbj_pdn');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pbj_pdn');
    }
}