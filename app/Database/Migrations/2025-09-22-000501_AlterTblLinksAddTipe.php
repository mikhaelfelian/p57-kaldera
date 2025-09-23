<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTblLinksAddTipe extends Migration
{
    public function up()
    {
        $fields = [
            'tipe' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
                'after'      => 'links',
            ],
        ];
        $this->forge->addColumn('tbl_links', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_links', 'tipe');
    }
}


