<?php

namespace App\Models;

use CodeIgniter\Model;

class PbjProgresModel extends Model
{
    protected $table = 'tbl_pbj_progres';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tahun',
        'bulan',
        'status',
        'catatan_kendala',
        'rencana_tindak_lanjut',
        'feedback_unit_kerja',
        'uploaded_by',
        'uploaded_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'bulan' => 'required|integer|min_length[1]|max_length[2]',
        'status' => 'permit_empty|in_list[Sesuai,Tidak Sesuai,Belum Diperiksa]',
        'catatan_kendala' => 'permit_empty',
        'rencana_tindak_lanjut' => 'permit_empty',
        'feedback_unit_kerja' => 'permit_empty',
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
        ],
        'status' => [
            'in_list' => 'Status harus Sesuai, Tidak Sesuai, atau Belum Diperiksa'
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
