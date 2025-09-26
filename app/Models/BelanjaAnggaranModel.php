<?php

namespace App\Models;

use CodeIgniter\Model;

class BelanjaAnggaranModel extends Model
{
    protected $table = 'tbl_belanja_anggaran';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tahun','tahapan','pegawai','barang_jasa','hibah','bansos','modal','total'
    ];
}


