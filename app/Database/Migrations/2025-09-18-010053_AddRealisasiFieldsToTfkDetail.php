<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRealisasiFieldsToTfkDetail extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_target_fisik_keu_detail', [
            'realisasi_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Fisik (%)'
            ],
            'realisasi_fisik_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Fisik Provinsi (%)'
            ],
            'realisasi_keu_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Keuangan Provinsi (%)'
            ],
            'analisa' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Analisa'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_target_fisik_keu_detail', [
            'realisasi_fisik',
            'realisasi_fisik_prov', 
            'realisasi_keu_prov',
            'analisa'
        ]);
    }
}