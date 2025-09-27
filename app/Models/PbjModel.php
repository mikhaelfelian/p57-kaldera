<?php

namespace App\Models;

use CodeIgniter\Model;

class PbjModel extends Model
{
    protected $table = 'tbl_pbj';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tahun',
        'bulan',
        'rup_tender_pagu',
        'rup_tender_realisasi',
        'rup_epurchasing_pagu',
        'rup_epurchasing_realisasi',
        'rup_nontender_pagu',
        'rup_nontender_realisasi',
        'swakelola_pagu',
        'swakelola_realisasi',
        'keterangan_tender',
        'keterangan_epurchasing',
        'keterangan_nontender',
        'keterangan_swakelola',
        'uploaded_by',
        'uploaded_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'bulan' => 'required|integer|min_length[1]|max_length[2]',
        'rup_tender_pagu' => 'permit_empty|integer',
        'rup_tender_realisasi' => 'permit_empty|integer',
        'rup_epurchasing_pagu' => 'permit_empty|integer',
        'rup_epurchasing_realisasi' => 'permit_empty|integer',
        'rup_nontender_pagu' => 'permit_empty|integer',
        'rup_nontender_realisasi' => 'permit_empty|integer',
        'swakelola_pagu' => 'permit_empty|integer',
        'swakelola_realisasi' => 'permit_empty|integer',
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
