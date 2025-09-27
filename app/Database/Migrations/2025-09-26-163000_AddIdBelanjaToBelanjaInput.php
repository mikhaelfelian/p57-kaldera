<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdBelanjaToBelanjaInput extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tbl_belanja_input', [
            'id_belanja' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'id',
                'comment' => 'Foreign key to tbl_belanja_anggaran'
            ],
        ]);

        // Add foreign key constraint
        $this->forge->addForeignKey('id_belanja', 'tbl_belanja_anggaran', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('tbl_belanja_input', 'tbl_belanja_input_id_belanja_foreign');
        $this->forge->dropColumn('tbl_belanja_input', 'id_belanja');
    }
}
