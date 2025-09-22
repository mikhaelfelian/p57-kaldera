<?php

namespace App\Models;

use CodeIgniter\Model;

class GenderModel extends Model
{
    protected $table            = 'tbl_gender';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['year', 'month', 'uraian', 'fupload', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'year'   => 'required|integer|greater_than_equal_to[1900]|less_than_equal_to[2100]',
        'month'  => 'required|regex_match[/^(0[1-9]|1[0-2])$/]',
        'uraian' => 'required|string|min_length[3]|max_length[255]',
        'fupload'=> 'permit_empty|string|max_length[255]',
    ];
}


