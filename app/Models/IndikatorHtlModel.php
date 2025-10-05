<?php

namespace App\Models;

use CodeIgniter\Model;

class IndikatorHtlModel extends Model
{
    protected $table = 'tbl_indikator_htl';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'indikator_input_id',
        'tahun',
        'triwulan',
        'jenis_indikator',
        'nama_verifikator',
        'hasil_tindak_lanjut_status',
        'hasil_tindak_lanjut_file',
        'hasil_tindak_lanjut_file_name',
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
        'indikator_input_id' => 'permit_empty|integer',
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'triwulan' => 'required|integer|in_list[1,2,3,4]',
        'jenis_indikator' => 'required|max_length[100]',
        'nama_verifikator' => 'required|max_length[255]',
        'hasil_tindak_lanjut_status' => 'required|in_list[Belum,Sudah]',
        'hasil_tindak_lanjut_file' => 'permit_empty|max_length[500]',
        'hasil_tindak_lanjut_file_name' => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getByPeriode($tahun, $triwulan, $jenisIndikator)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator
        ])->findAll();
    }

    public function deleteByPeriode($tahun, $triwulan, $jenisIndikator)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator
        ])->delete();
    }
}
