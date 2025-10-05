<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerifikasiFieldsToTblPbjProgres extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_pbj_progres', [
            'status_verifikasi' => [
                'type'       => 'ENUM',
                'constraint' => ['Belum Diperiksa', 'Sesuai', 'Tidak Sesuai'],
                'default'    => 'Belum Diperiksa',
                'after'      => 'keterangan'
            ],
            'catatan_tambahan' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'status_verifikasi'
            ],
            'verifikasi_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'catatan_tambahan'
            ],
            'verifikasi_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'verifikasi_by'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_pbj_progres', ['status_verifikasi', 'catatan_tambahan', 'verifikasi_by', 'verifikasi_at']);
    }
}
