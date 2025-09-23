<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadModel extends Model
{
    protected $table            = 'tbl_uploads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user', 'name', 'keterangan', 'file', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'id_user'    => 'required|integer',
        'name'       => 'required|string|min_length[3]|max_length[255]',
        'keterangan' => 'permit_empty|string',
        'file'       => 'permit_empty|string|max_length[255]',
    ];
}


