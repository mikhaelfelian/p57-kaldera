<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDokColumnsToBanmasBs extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('tbl_banmas_bs')) {
            $fields = [];
            $fields['file_path_dok'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'file_name'
            ];
            $fields['file_name_dok'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'file_path_dok'
            ];

            $forgeFields = [];
            $fieldsInfo = $this->db->getFieldData('tbl_banmas_bs');
            $existingCols = array_map(fn($f) => $f->name, $fieldsInfo);
            foreach ($fields as $name => $def) {
                if (!in_array($name, $existingCols, true)) {
                    $forgeFields[$name] = $def;
                }
            }
            if (!empty($forgeFields)) {
                $this->forge->addColumn('tbl_banmas_bs', $forgeFields);
            }
        }
    }

    public function down()
    {
        if ($this->db->tableExists('tbl_banmas_bs')) {
            $fieldsInfo = $this->db->getFieldData('tbl_banmas_bs');
            $existingCols = array_map(fn($f) => $f->name, $fieldsInfo);
            if (in_array('file_path_dok', $existingCols, true)) {
                $this->forge->dropColumn('tbl_banmas_bs', 'file_path_dok');
            }
            if (in_array('file_name_dok', $existingCols, true)) {
                $this->forge->dropColumn('tbl_banmas_bs', 'file_name_dok');
            }
        }
    }
}


