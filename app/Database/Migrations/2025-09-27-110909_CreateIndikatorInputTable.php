<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIndikatorInputTable extends Migration
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
            'triwulan' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
            ],
            'jenis_indikator' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'catatan_indikator' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rencana_tindak_lanjut' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'file_catatan_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'file_catatan_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_catatan_size' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'file_rencana_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'file_rencana_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_rencana_size' => [
                'type' => 'BIGINT',
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
        $this->forge->addKey(['tahun', 'triwulan', 'jenis_indikator']);
        $this->forge->createTable('tbl_indikator_input');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_indikator_input');
    }
}
