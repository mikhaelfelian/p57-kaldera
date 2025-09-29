<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAvatarToUsers extends Migration
{
    public function up()
    {
        // Skip if users table does not exist
        if (! $this->db->tableExists('users')) {
            return;
        }

        $this->forge->addColumn('users', [
            'avatar' => [
                'type' => 'VARCHAR',
                'constraint' => 500,
                'null' => true,
                'after' => 'company'
            ]
        ]);
    }

    public function down()
    {
        if ($this->db->tableExists('users')) {
            $this->forge->dropColumn('users', 'avatar');
        }
    }
}
