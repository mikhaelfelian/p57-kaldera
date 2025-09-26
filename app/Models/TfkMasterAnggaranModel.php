<?php

namespace App\Models;

use CodeIgniter\Model;

class TfkMasterAnggaranModel extends Model
{
    protected $table = 'tbl_tfk_master_anggaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tahun','tahapan','pegawai','barang_jasa','hibah','bansos','modal','total'
    ];
}


