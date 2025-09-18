<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblFiskal extends Migration
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
            'master_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'comment' => 'Reference to tbl_target_fisik_keu_master'
            ],
            'tipe' => [
                'type' => 'ENUM',
                'constraint' => ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10'],
                'default' => '0',
                'comment' => '0-10 enum, 1 for target fisik keuangan'
            ],
            'tahun' => [
                'type' => 'YEAR',
                'comment' => 'Year of the data'
            ],
            'bulan' => [
                'type' => 'ENUM',
                'constraint' => ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'],
                'comment' => 'Month abbreviation'
            ],
            'target_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Target Fisik (%)'
            ],
            'target_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Target Keuangan (%)'
            ],
            'realisasi_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Fisik (%)'
            ],
            'realisasi_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Keuangan (%)'
            ],
            'realisasi_fisik_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Fisik Provinsi (%)'
            ],
            'realisasi_keuangan_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Realisasi Keuangan Provinsi (%)'
            ],
            'deviasi_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Deviasi Fisik (%) - calculated field'
            ],
            'deviasi_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
                'comment' => 'Deviasi Keuangan (%) - calculated field'
            ],
            'analisa' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Analisa text'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['master_id', 'tipe', 'tahun', 'bulan'], false, 'idx_master_tipe_year_month');
        $this->forge->createTable('tbl_fiskal');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_fiskal');
    }
}