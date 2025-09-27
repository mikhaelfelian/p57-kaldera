<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBanmasHibahTable extends Migration
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
            'jenis_hibah' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'nama_hibah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nilai_hibah' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
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
        $this->forge->addKey(['tahun', 'bulan', 'jenis_hibah']);
        $this->forge->createTable('tbl_banmas_hibah');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_banmas_hibah');
    }
}