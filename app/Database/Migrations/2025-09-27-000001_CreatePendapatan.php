<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendapatan extends Migration
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
                'comment' => 'Tahun anggaran'
            ],
            'tahapan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
                'comment' => 'Tahapan APBD (penetapan, pergeseran, perubahan)'
            ],
            'retribusi_penyewaan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan'
            ],
            'retribusi_laboratorium' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium'
            ],
            'retribusi_alat' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)'
            ],
            'hasil_kerjasama' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Hasil Kerja Sama Pemanfaatan BMD'
            ],
            'penerimaan_komisi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain'
            ],
            'sewa_ruang_koperasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Sewa Ruang Koperasi'
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Total pendapatan'
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
        $this->forge->addKey(['tahun', 'tahapan'], false, true); // Unique key for tahun + tahapan
        $this->forge->createTable('tbl_pendapatan');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pendapatan');
    }
}
