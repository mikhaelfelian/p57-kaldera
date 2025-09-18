<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTfkDetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
			'master_id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true ],
			'bulan' => [ 'type' => 'VARCHAR', 'constraint' => 3 ],
			'fisik' => [ 'type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0 ],
			'keu' => [ 'type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0 ],
			'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
			'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addForeignKey('master_id', 'tbl_target_fisik_keu_master', 'id', 'CASCADE', 'CASCADE');
		$this->forge->createTable('tbl_target_fisik_keu_detail');
	}

	public function down()
	{
		$this->forge->dropTable('tbl_target_fisik_keu_detail');
	}
}


