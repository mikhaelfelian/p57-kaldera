<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblIndikatorVerif extends Migration
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
            'indikator_input_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Foreign key to tbl_indikator_input',
            ],
            'tahun' => [
                'type' => 'INT',
                'constraint' => 4,
                'null' => false,
                'comment' => 'Tahun data',
            ],
            'triwulan' => [
                'type' => 'INT',
                'constraint' => 1,
                'null' => false,
                'comment' => 'Triwulan (1-4)',
            ],
            'jenis_indikator' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'Jenis indikator',
            ],
            'nama_verifikator' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Nama verifikator/bidang',
            ],
            'hasil_verifikasi_status' => [
                'type' => 'ENUM',
                'constraint' => ['Belum', 'Sudah'],
                'default' => 'Belum',
                'null' => false,
                'comment' => 'Status hasil verifikasi',
            ],
            'hasil_verifikasi_file' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'Path file hasil verifikasi',
            ],
            'hasil_verifikasi_file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Nama file hasil verifikasi',
            ],
            'rencana_tindak_lanjut_status' => [
                'type' => 'ENUM',
                'constraint' => ['Belum', 'Sudah'],
                'default' => 'Belum',
                'null' => false,
                'comment' => 'Status rencana tindak lanjut',
            ],
            'rencana_tindak_lanjut_file' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'comment' => 'Path file rencana tindak lanjut',
            ],
            'rencana_tindak_lanjut_file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'comment' => 'Nama file rencana tindak lanjut',
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
        $this->forge->addKey(['tahun', 'triwulan', 'jenis_indikator'], false, false, 'idx_periode');
        $this->forge->addKey('indikator_input_id', false, false, 'idx_indikator_input');
        $this->forge->createTable('tbl_indikator_verif');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_indikator_verif');
    }
}

