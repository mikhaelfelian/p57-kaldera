<?php

namespace App\Models;

use CodeIgniter\Model;

class BanmasBansosModel extends Model
{
    protected $table = 'tbl_banmas_bansos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tahun',
        'bulan',
        'jenis_bansos',
        'nama_bansos',
        'deskripsi',
        'nilai_bansos',
        'status',
        'catatan_kendala',
        'rencana_tindak_lanjut',
        'feedback_unit_kerja',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_by',
        'uploaded_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'bulan' => 'required|integer|min_length[1]|max_length[2]',
        'jenis_bansos' => 'required|max_length[100]',
        'nama_bansos' => 'required|max_length[255]',
        'nilai_bansos' => 'permit_empty|integer',
        'status' => 'permit_empty|in_list[Sesuai,Tidak Sesuai,Belum Diperiksa]',
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
        'jenis_bansos' => [
            'required' => 'Jenis bantuan sosial harus diisi',
            'max_length' => 'Jenis bantuan sosial maksimal 100 karakter'
        ],
        'nama_bansos' => [
            'required' => 'Nama bantuan sosial harus diisi',
            'max_length' => 'Nama bantuan sosial maksimal 255 karakter'
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
