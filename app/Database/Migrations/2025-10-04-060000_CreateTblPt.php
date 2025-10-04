<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblPt extends Migration
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
                'comment' => 'Tahun data',
            ],
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
                'comment' => 'Bulan data (1-12)',
            ],
            'sektor' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'default' => 'minerba',
                'comment' => 'Sektor: minerba, gat, gatrik, ebt',
            ],
            'unit_kerja_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'ID dari tbl_m_unit_kerja',
            ],
            'unit_kerja_nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment' => 'Nama unit kerja',
            ],
            'permohonan_masuk' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Jumlah permohonan masuk',
            ],
            'masih_proses' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Jumlah yang masih proses',
            ],
            'disetujui' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Jumlah yang disetujui',
            ],
            'dikembalikan' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Jumlah yang dikembalikan',
            ],
            'ditolak' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
                'comment' => 'Jumlah yang ditolak',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Keterangan tambahan',
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
        $this->forge->addKey(['tahun', 'bulan', 'sektor', 'unit_kerja_id'], false, false, 'idx_pt_periode');
        $this->forge->addKey('sektor', false, false, 'idx_sektor');
        $this->forge->addKey('unit_kerja_id', false, false, 'idx_unit_kerja');

        $this->forge->createTable('tbl_pt');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pt');
    }
}
