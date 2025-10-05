<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFileFieldsToTblPbjProgres extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_pbj_progres', [
            'file_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'after'      => 'feedback_unit_kerja'
            ],
            'file_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'file_path'
            ],
            'file_size' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'file_name'
            ],
            'keterangan' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'file_size'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_pbj_progres', ['file_path', 'file_name', 'file_size', 'keterangan']);
    }
}
