<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTfkMasterAnggaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 'type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true ],
            'tahun' => [ 'type' => 'YEAR' ],
            'tahapan' => [ 'type' => 'ENUM', 'constraint' => ['penetapan','pergeseran','perubahan'], 'default' => 'penetapan' ],
            'pegawai' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'barang_jasa' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'hibah' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'bansos' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'modal' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'total' => [ 'type' => 'DECIMAL', 'constraint' => '20,2', 'default' => '0.00' ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['tahun','tahapan']);
        $this->forge->createTable('tbl_tfk_master_anggaran');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_tfk_master_anggaran');
    }
}


