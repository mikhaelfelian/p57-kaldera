<?php

namespace App\Models;

use CodeIgniter\Model;

class BanmasHibahModel extends Model
{
    protected $table = 'tbl_banmas_hibah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tahun',
        'bulan',
        'jenis_hibah',
        'nama_hibah',
        'deskripsi',
        'nilai_hibah',
        'status',
        'catatan_kendala',
        'rencana_tindak_lanjut',
        'feedback_unit_kerja',
        'file_path',
        'file_name',
        'file_path_dok',
        'file_name_dok',
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
        'jenis_hibah' => 'required|max_length[100]',
        'nama_hibah' => 'permit_empty|max_length[255]',
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
