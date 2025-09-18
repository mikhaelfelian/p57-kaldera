<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetFisikKeuMasterModel extends Model
{
	protected $table = 'tbl_target_fisik_keu_master';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['nama', 'tahapan', 'created_at', 'updated_at'];
	protected $useTimestamps = true;
}


