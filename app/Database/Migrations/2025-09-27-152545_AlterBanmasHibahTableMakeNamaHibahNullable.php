<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterBanmasHibahTableMakeNamaHibahNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('tbl_banmas_hibah', [
            'nama_hibah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('tbl_banmas_hibah', [
            'nama_hibah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }
}
