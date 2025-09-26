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
            // ALTER TABLE: target_fisik after bulan, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'target_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Target Fisik (%)'
            ],
            // ALTER TABLE: target_keuangan after target_fisik, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'target_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Target Keuangan (%)'
            ],
            // ALTER TABLE: realisasi_fisik after target_keuangan, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'realisasi_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Realisasi Fisik (%)'
            ],
            // ALTER TABLE: realisasi_keuangan after realisasi_fisik, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'realisasi_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Realisasi Keuangan (%)'
            ],
            // ALTER TABLE: realisasi_fisik_prov after realisasi_keuangan, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'realisasi_fisik_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Realisasi Fisik Provinsi (%)'
            ],
            // ALTER TABLE: realisasi_keuangan_prov after realisasi_fisik_prov, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'realisasi_keuangan_prov' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Realisasi Keuangan Provinsi (%)'
            ],
            // ALTER TABLE: deviasi_fisik after realisasi_keuangan_prov, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'deviasi_fisik' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
                'comment' => 'Deviasi Fisik (%) - calculated field'
            ],
            // ALTER TABLE: deviasi_keuangan after deviasi_fisik, DECIMAL(20,2) NOT NULL DEFAULT '0.00'
            'deviasi_keuangan' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'null' => false,
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