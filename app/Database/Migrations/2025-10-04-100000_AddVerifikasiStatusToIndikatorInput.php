<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerifikasiStatusToIndikatorInput extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_indikator_input', [
            'status_verifikasi_bidang' => [
                'type' => 'ENUM',
                'constraint' => ['Belum Diperiksa', 'Sesuai', 'Tidak Sesuai'],
                'default' => 'Belum Diperiksa',
                'null' => false,
                'comment' => 'Status verifikasi dari bidang',
                'after' => 'rencana_tindak_lanjut'
            ],
            'tanggal_verifikasi' => [
                'type' => 'DATETIME',
                'null' => true,
                'comment' => 'Tanggal verifikasi dilakukan',
                'after' => 'status_verifikasi_bidang'
            ],
            'verifikasi_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'comment' => 'ID user yang melakukan verifikasi',
                'after' => 'tanggal_verifikasi'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_indikator_input', ['status_verifikasi_bidang', 'tanggal_verifikasi', 'verifikasi_by']);
    }
}

