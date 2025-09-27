<?php

namespace App\Models;

use CodeIgniter\Model;

class IndikatorInputModel extends Model
{
    protected $table = 'tbl_indikator_input';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tahun',
        'triwulan',
        'jenis_indikator',
        'catatan_indikator',
        'rencana_tindak_lanjut',
        'file_catatan_path',
        'file_catatan_name',
        'file_catatan_size',
        'file_rencana_path',
        'file_rencana_name',
        'file_rencana_size',
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
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'triwulan' => 'required|integer|in_list[1,2,3,4]',
        'jenis_indikator' => 'required|max_length[100]',
        'catatan_indikator' => 'permit_empty',
        'rencana_tindak_lanjut' => 'permit_empty',
        'file_catatan_path' => 'permit_empty|max_length[500]',
        'file_catatan_name' => 'permit_empty|max_length[255]',
        'file_catatan_size' => 'permit_empty|integer',
        'file_rencana_path' => 'permit_empty|max_length[500]',
        'file_rencana_name' => 'permit_empty|max_length[255]',
        'file_rencana_size' => 'permit_empty|integer',
        'uploaded_by' => 'permit_empty|integer',
        'uploaded_at' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'tahun' => [
            'required' => 'Tahun harus diisi',
            'integer' => 'Tahun harus berupa angka',
            'min_length' => 'Tahun harus 4 digit',
            'max_length' => 'Tahun harus 4 digit'
        ],
        'triwulan' => [
            'required' => 'Triwulan harus diisi',
            'integer' => 'Triwulan harus berupa angka',
            'in_list' => 'Triwulan harus 1, 2, 3, atau 4'
        ],
        'jenis_indikator' => [
            'required' => 'Jenis indikator harus diisi',
            'max_length' => 'Jenis indikator maksimal 100 karakter'
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

    public function getByTahunTriwulan($tahun, $triwulan)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan
        ])->findAll();
    }

    public function getByJenis($tahun, $triwulan, $jenis)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenis
        ])->first();
    }

    public function getByUser($userId)
    {
        return $this->where('uploaded_by', $userId)->findAll();
    }

    public function getRecent($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')->limit($limit)->findAll();
    }

    public function getByTahun($tahun)
    {
        return $this->where('tahun', $tahun)->orderBy('triwulan', 'ASC')->findAll();
    }
}
