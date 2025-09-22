<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblGenderAddMonth extends Migration
{
    public function up()
    {
        $fields = [
            'month' => [
                'type'       => 'CHAR',
                'constraint' => 2,
                'null'       => false,
                'default'    => '01',
                'after'      => 'year',
            ],
        ];
        $this->forge->addColumn('tbl_gender', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_gender', 'month');
    }
}


