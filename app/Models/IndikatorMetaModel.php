<?php

namespace App\Models;

use CodeIgniter\Model;

class IndikatorMetaModel extends Model
{
    protected $table = 'tbl_indikator_meta';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'jenis_indikator',
        'nama_indikator', 
        'deskripsi',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_by',
        'uploaded_at',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'jenis_indikator' => 'required|max_length[100]',
        'nama_indikator' => 'required|max_length[255]',
        'deskripsi' => 'permit_empty',
        'file_path' => 'permit_empty|max_length[500]',
        'file_name' => 'permit_empty|max_length[255]',
        'file_size' => 'permit_empty|integer',
        'uploaded_by' => 'permit_empty|integer',
        'uploaded_at' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'jenis_indikator' => [
            'required' => 'Jenis indikator harus diisi',
            'max_length' => 'Jenis indikator maksimal 100 karakter'
        ],
        'nama_indikator' => [
            'required' => 'Nama indikator harus diisi',
            'max_length' => 'Nama indikator maksimal 255 karakter'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getByJenis($jenis)
    {
        return $this->where('jenis_indikator', $jenis)->first();
    }

    public function getByUser($userId)
    {
        return $this->where('uploaded_by', $userId)->findAll();
    }

    public function getRecent($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }
}