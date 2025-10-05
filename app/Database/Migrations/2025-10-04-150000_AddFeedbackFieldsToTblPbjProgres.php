<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFeedbackFieldsToTblPbjProgres extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_pbj_progres', [
            'feedback_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'verifikasi_at'
            ],
            'feedback_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'feedback_by'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_pbj_progres', ['feedback_by', 'feedback_at']);
    }
}
