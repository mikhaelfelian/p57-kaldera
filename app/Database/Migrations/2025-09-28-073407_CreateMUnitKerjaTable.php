<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMUnitKerjaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kode_unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'nama_unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kepala_unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'nip_kepala' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default' => 'Aktif',
            ],
            'keterangan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('kode_unit_kerja');
        $this->forge->addKey('status');
        $this->forge->createTable('tbl_m_unit_kerja');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_m_unit_kerja');
    }
}