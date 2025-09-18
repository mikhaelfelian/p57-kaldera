<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTfkMaster extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
			'nama' => [ 'type' => 'VARCHAR', 'constraint' => 150 ],
			'tahapan' => [ 'type' => 'VARCHAR', 'constraint' => 100, 'null' => true ],
			'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
			'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('tbl_target_fisik_keu_master');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_target_fisik_keu_master');
	}
}


