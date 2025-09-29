<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDokColumnsToBanmasHibah extends Migration
{
    public function up()
    {
        $fields = [
            'file_name_dok' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_name',
            ],
            'file_path_dok' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_path',
            ],
        ];

        $this->forge->addColumn('tbl_banmas_hibah', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_banmas_hibah', ['file_name_dok', 'file_path_dok']);
    }
}


