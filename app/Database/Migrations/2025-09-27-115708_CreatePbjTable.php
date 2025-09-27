<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePbjTable extends Migration
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
            ],
            'bulan' => [
                'type' => 'INT',
                'constraint' => 2,
                'null' => false,
            ],
            'rup_tender_pagu' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'rup_tender_realisasi' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'rup_epurchasing_pagu' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'rup_epurchasing_realisasi' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'rup_nontender_pagu' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'rup_nontender_realisasi' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'swakelola_pagu' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'swakelola_realisasi' => [
                'type' => 'BIGINT',
                'null' => true,
                'default' => 0,
            ],
            'keterangan_tender' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan_epurchasing' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan_nontender' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'keterangan_swakelola' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'uploaded_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'uploaded_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        $this->forge->addKey(['tahun', 'bulan']);
        $this->forge->createTable('tbl_pbj');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_pbj');
    }
}