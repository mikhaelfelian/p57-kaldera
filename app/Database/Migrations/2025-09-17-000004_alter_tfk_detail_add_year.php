<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTfkDetailAddYear extends Migration
{
	public function up()
	{
		$fields = [
			'tahun' => [ 'type' => 'INT', 'constraint' => 4, 'default' => (int)date('Y') ]
		];
		$this->forge->addColumn('tbl_target_fisik_keu_detail', $fields);
		$this->db->query("UPDATE tbl_target_fisik_keu_detail SET tahun = YEAR(CURDATE()) WHERE tahun IS NULL");
	}

	public function down()
	{
		$this->forge->dropColumn('tbl_target_fisik_keu_detail', 'tahun');
	}
}


