<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblIndikatorHtl extends Migration
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
            'indikator_input_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true, // Can be null if htl data is saved before main indikator input
            ],
            'tahun' => [
                'type'       => 'INT',
                'constraint' => 4,
                'null'       => false,
            ],
            'triwulan' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => false,
            ],
            'jenis_indikator' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
            ],
            'nama_verifikator' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'hasil_tindak_lanjut_status' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum', 'Sudah'],
                'default'    => 'Belum',
            ],
            'hasil_tindak_lanjut_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'hasil_tindak_lanjut_file_name' => [
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
        $this->forge->addKey(['tahun', 'triwulan', 'jenis_indikator', 'nama_verifikator'], false, false, 'idx_htl_unique');
        $this->forge->addForeignKey('indikator_input_id', 'tbl_indikator_input', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tbl_indikator_htl');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_indikator_htl');
    }
}
