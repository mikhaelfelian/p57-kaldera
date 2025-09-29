<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTblSessions extends Migration
{
    public function up()
    {
        // Drop table if exists
        if ($this->db->tableExists('tbl_sessions')) {
            $this->forge->dropTable('tbl_sessions', true);
        }

        $fields = [
            'id' => [
                'type'       => 'VARCHAR',
                'constraint' => 128,
                'null'       => false,
                'collation'  => 'utf8mb4_general_ci',
            ],
            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => false,
                'collation'  => 'utf8mb4_general_ci',
            ],
            'timestamp' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
            ],
            'data' => [
                'type' => 'BLOB',
                'null' => false,
            ],
        ];

        $this->forge->addField($fields);
        $this->forge->addKey('id', true, true); // primary key, btree
        $this->forge->addKey('timestamp'); // index, btree

        $attributes = [
            'ENGINE' => 'InnoDB',
            'COMMENT' => 'Table untuk menyimpan session data',
            'COLLATE' => 'utf8mb4_general_ci',
        ];

        $this->forge->createTable('tbl_sessions', true, $attributes);
    }

    public function down()
    {
        $this->forge->dropTable('tbl_sessions', true);
    }
}

