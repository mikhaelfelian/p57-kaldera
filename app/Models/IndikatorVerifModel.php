<?php

namespace App\Models;

use CodeIgniter\Model;

class IndikatorVerifModel extends Model
{
    protected $table = 'tbl_indikator_verif';
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
        'hasil_verifikasi_status',
        'hasil_verifikasi_file',
        'hasil_verifikasi_file_name',
        'rencana_tindak_lanjut_status',
        'rencana_tindak_lanjut_file',
        'rencana_tindak_lanjut_file_name',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'tahun' => 'required|integer|min_length[4]|max_length[4]',
        'triwulan' => 'required|integer|in_list[1,2,3,4]',
        'jenis_indikator' => 'required|max_length[100]',
        'nama_verifikator' => 'required|max_length[255]',
        'hasil_verifikasi_status' => 'permit_empty|in_list[Belum,Sudah]',
        'rencana_tindak_lanjut_status' => 'permit_empty|in_list[Belum,Sudah]',
    ];

    protected $validationMessages = [
        'tahun' => [
            'required' => 'Tahun harus diisi',
            'integer' => 'Tahun harus berupa angka',
        ],
        'triwulan' => [
            'required' => 'Triwulan harus diisi',
            'integer' => 'Triwulan harus berupa angka',
        ],
        'jenis_indikator' => [
            'required' => 'Jenis indikator harus diisi',
        ],
        'nama_verifikator' => [
            'required' => 'Nama verifikator harus diisi',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Get verifikator by tahun, triwulan, and jenis
    public function getByPeriode($tahun, $triwulan, $jenisIndikator)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator
        ])->findAll();
    }

    // Delete all verifikator by periode
    public function deleteByPeriode($tahun, $triwulan, $jenisIndikator)
    {
        return $this->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator
        ])->delete();
    }

    // Get verifikator with indikator input data
    public function getWithIndikatorInput($tahun, $triwulan, $jenisIndikator)
    {
        return $this->select('tbl_indikator_verif.*, tbl_indikator_input.catatan_indikator')
            ->join('tbl_indikator_input', 'tbl_indikator_verif.indikator_input_id = tbl_indikator_input.id', 'left')
            ->where([
                'tbl_indikator_verif.tahun' => $tahun,
                'tbl_indikator_verif.triwulan' => $triwulan,
                'tbl_indikator_verif.jenis_indikator' => $jenisIndikator
            ])
            ->findAll();
    }
}

