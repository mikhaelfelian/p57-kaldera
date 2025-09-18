<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterTfkDetailAddKeuReal extends Migration
{
	public function up()
	{
		$fields = [
			'keu_real' => [ 'type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0 ]
		];
		$this->forge->addColumn('tbl_target_fisik_keu_detail', $fields);
	}

	public function down()
	{
		$this->forge->dropColumn('tbl_target_fisik_keu_detail', 'keu_real');
	}
}


