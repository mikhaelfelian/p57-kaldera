<?php

namespace App\Models;

use CodeIgniter\Model;

class PbjPdnModel extends Model
{
    protected $table = 'tbl_pbj_pdn';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tahun',
        'bulan',
        'pagu_rup_tagging_pdn',
        'realisasi_pdn',
        'indeks',
        'keterangan',
        'uploaded_by',
        'uploaded_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'bulan' => 'required|integer|min_length[1]|max_length[2]',
        'pagu_rup_tagging_pdn' => 'permit_empty|integer',
        'realisasi_pdn' => 'permit_empty|integer',
        'indeks' => 'permit_empty|decimal',
    ];

    protected $validationMessages = [
        'tahun' => [
            'required' => 'Tahun harus diisi',
            'integer' => 'Tahun harus berupa angka',
            'min_length' => 'Tahun harus 4 digit',
            'max_length' => 'Tahun harus 4 digit'
        ],
        'bulan' => [
            'required' => 'Bulan harus diisi',
            'integer' => 'Bulan harus berupa angka',
            'min_length' => 'Bulan harus 1-2 digit',
            'max_length' => 'Bulan harus 1-2 digit'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = [];
    protected $beforeUpdate = [];
    protected $beforeDelete = [];
    protected $afterInsert = [];
    protected $afterUpdate = [];
    protected $afterDelete = [];
}
