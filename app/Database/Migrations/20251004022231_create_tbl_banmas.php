<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblBanmas extends Migration
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
            'tahun' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => false,
            ],
            'bulan' => [
                'type'       => 'INT',
                'constraint' => 2,
                'null'       => false,
            ],
            'nama_hibah' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nilai_hibah' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
                'default'    => 0,
            ],
            'status' => [
                // CI4 allows raw ENUM definition via type string
                'type'    => "ENUM('Sesuai','Tidak Sesuai','Belum Diperiksa')",
                'null'    => false,
                'default' => 'Belum Diperiksa',
            ],
            'tipe' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'file_path_dok' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'file_name_dok' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'file_size' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'null'       => true,
            ],
            'uploaded_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
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

        $this->forge->addKey('id', true); // primary key
        $this->forge->addKey(['tahun', 'bulan']); // index tahun_bulan_jenis_hibah

        // Create table with engine and collation attributes
        $this->forge->createTable('tbl_banmas', true, [
            'ENGINE'        => 'InnoDB',
            'DEFAULT CHARSET' => 'utf8mb4',
            'COLLATE'       => 'utf8mb4_general_ci',
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_banmas', true);
    }
}
