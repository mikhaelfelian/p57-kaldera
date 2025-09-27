<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePgTable extends Migration
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
            'indikator' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => false,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Sesuai', 'Tidak Sesuai', 'Belum Diperiksa'],
                'default' => 'Belum Diperiksa',
            ],
            'catatan_kendala' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rencana_tindak_lanjut' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'feedback_unit_kerja' => [
                'type' => 'JSON',
                'null' => true,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'file_size' => [
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
        $this->forge->addKey(['tahun', 'bulan']);
        $this->forge->createTable('tbl_pg');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pg');
    }
}