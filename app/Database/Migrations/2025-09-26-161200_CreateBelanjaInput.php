<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBelanjaInput extends Migration
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
            'tahun' => [
                'type' => 'YEAR',
                'null' => false,
                'comment' => 'Year of the input data',
            ],
            'tahapan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
                'comment' => 'penetapan | pergeseran | perubahan',
            ],
            'bulan' => [
                'type' => 'TINYINT',
                'constraint' => 2,
                'null' => false,
                'comment' => 'Month number 1-12',
            ],
            'pegawai_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Pegawai - Anggaran',
            ],
            'pegawai_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Pegawai - Realisasi',
            ],
            'barang_jasa_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Barang dan Jasa - Anggaran',
            ],
            'barang_jasa_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Barang dan Jasa - Realisasi',
            ],
            'hibah_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Hibah - Anggaran',
            ],
            'hibah_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Hibah - Realisasi',
            ],
            'bansos_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Bantuan Sosial - Anggaran',
            ],
            'bansos_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Bantuan Sosial - Realisasi',
            ],
            'modal_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Modal - Anggaran',
            ],
            'modal_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Belanja Modal - Realisasi',
            ],
            'total_anggaran' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Total Anggaran',
            ],
            'total_realisasi' => [
                'type' => 'DECIMAL',
                'constraint' => '20,2',
                'default' => '0.00',
                'comment' => 'Total Realisasi',
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
        $this->forge->addUniqueKey(['tahun', 'tahapan', 'bulan'], 'idx_tahun_tahapan_bulan_unique');
        $this->forge->createTable('tbl_belanja_input');
    }

    public function down()
    {
        $this->forge->dropTable('tbl_belanja_input');
    }
}
