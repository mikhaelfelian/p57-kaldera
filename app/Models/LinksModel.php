<?php

namespace App\Models;

use CodeIgniter\Model;

class LinksModel extends Model
{
    protected $table            = 'tbl_links';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'name',
        'links',
        'keterangan',
        'status'
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation rules
    protected $validationRules = [
        'name'  => 'required|min_length[3]|max_length[150]',
        'links' => 'required|valid_url_strict',
        'status'=> 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'links' => [
            'valid_url_strict' => 'Format link harus https://domain',
        ]
    ];
}
