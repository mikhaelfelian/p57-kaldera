<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveJenisHibahColumn extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_banmas_hibah')) {
            $this->forge->dropColumn('tbl_banmas_hibah', 'jenis_hibah');
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_banmas_hibah')) {
            $fields = [
                'jenis_hibah' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => false,
                    'after'      => 'bulan',
                ],
            ];
            $this->forge->addColumn('tbl_banmas_hibah', $fields);
        }
    }
}
