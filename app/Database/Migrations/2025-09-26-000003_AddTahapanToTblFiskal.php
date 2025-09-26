<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTahapanToTblFiskal extends Migration
{
    public function up()
    {
        $fields = [
            'tahapan' => [
                'type'       => 'ENUM',
                'constraint' => ['penetapan', 'pergeseran', 'perubahan'],
                'default'    => 'penetapan',
                'after'      => 'bulan',
                'comment'    => 'Tahapan APBD: penetapan|pergeseran|perubahan',
            ],
        ];

        $this->forge->addColumn('tbl_fiskal', $fields);

        $this->db->query('CREATE INDEX idx_master_tipe_year_month_tahapan ON tbl_fiskal (master_id, tipe, tahun, bulan, tahapan)');
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_fiskal', 'tahapan');
        $this->db->query('DROP INDEX idx_master_tipe_year_month_tahapan ON tbl_fiskal');
    }
}


