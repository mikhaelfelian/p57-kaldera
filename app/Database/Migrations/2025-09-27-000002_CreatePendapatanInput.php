<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePendapatanInput extends Migration
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
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => false,
                'comment' => 'Bulan (1-12)'
            ],
            'retribusi_penyewaan_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan'
            ],
            'retribusi_penyewaan_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan'
            ],
            'retribusi_laboratorium_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium'
            ],
            'retribusi_laboratorium_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium'
            ],
            'retribusi_alat_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)'
            ],
            'retribusi_alat_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)'
            ],
            'hasil_kerjasama_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Hasil Kerja Sama Pemanfaatan BMD'
            ],
            'hasil_kerjasama_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Hasil Kerja Sama Pemanfaatan BMD'
            ],
            'penerimaan_komisi_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Penerimaan Komisi, Potongan, atau Bentuk Lain'
            ],
            'penerimaan_komisi_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Penerimaan Komisi, Potongan, atau Bentuk Lain'
            ],
            'sewa_ruang_koperasi_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Target Sewa Ruang Koperasi'
            ],
            'sewa_ruang_koperasi_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Realisasi Sewa Ruang Koperasi'
            ],
            'total_target' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Total target'
            ],
            'total_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
                'comment' => 'Total realisasi'
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
        $this->forge->addKey(['tahun', 'tahapan', 'bulan'], false, true); // Unique key for tahun + tahapan + bulan
        $this->forge->createTable('tbl_pendapatan_input');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pendapatan_input');
    }
}
