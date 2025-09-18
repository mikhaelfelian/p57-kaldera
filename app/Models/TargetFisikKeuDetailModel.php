<?php

namespace App\Models;

use CodeIgniter\Model;

class TargetFisikKeuDetailModel extends Model
{
	protected $table = 'tbl_target_fisik_keu_detail';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $allowedFields = ['master_id', 'bulan', 'fisik', 'keu', 'created_at', 'updated_at'];
	protected $useTimestamps = true;
}


