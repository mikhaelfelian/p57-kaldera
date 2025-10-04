<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OptimizeUnitKerjaTable extends Migration
{
    public function up()
    {
        // Add indexes for better performance on 2-column display
        $this->forge->addKey(['nama_unit_kerja'], false, false, 'idx_nama_unit_kerja');
        $this->forge->addKey(['status'], false, false, 'idx_status');
        $this->forge->addKey(['kode_unit_kerja'], false, false, 'idx_kode_unit_kerja');
        
        // Add composite index for search functionality
        $this->forge->addKey(['nama_unit_kerja', 'kode_unit_kerja', 'kepala_unit_kerja'], false, false, 'idx_search_fields');
        
        // Modify table to optimize for 2-column display
        $this->forge->modifyColumn('tbl_m_unit_kerja', [
            'nama_unit_kerja' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
                'comment' => 'Nama unit kerja untuk display utama'
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Alamat lengkap unit kerja'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['Aktif', 'Tidak Aktif'],
                'default' => 'Aktif',
                'comment' => 'Status unit kerja'
            ]
        ]);
    }

    public function down()
    {
        // Drop the indexes
        $this->forge->dropKey('tbl_m_unit_kerja', 'idx_nama_unit_kerja');
        $this->forge->dropKey('tbl_m_unit_kerja', 'idx_status');
        $this->forge->dropKey('tbl_m_unit_kerja', 'idx_kode_unit_kerja');
        $this->forge->dropKey('tbl_m_unit_kerja', 'idx_search_fields');
    }
}
