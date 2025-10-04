<?php

namespace App\Models;

use CodeIgniter\Model;

class PtModel extends Model
{
    protected $table = 'tbl_pt';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'tahun',
        'bulan',
        'sektor',
        'unit_kerja_id',
        'unit_kerja_nama',
        'permohonan_masuk',
        'masih_proses',
        'disetujui',
        'dikembalikan',
        'ditolak',
        'keterangan'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
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

    /**
     * Get data by periode (tahun, bulan, sektor)
     */
    public function getByPeriode($tahun, $bulan, $sektor = 'minerba')
    {
        return $this->where([
            'tahun' => $tahun,
            'bulan' => $bulan,
            'sektor' => $sektor
        ])->findAll();
    }

    /**
     * Save or update data for a unit kerja in a specific periode
     */
    public function saveData($data)
    {
        $existing = $this->where([
            'tahun' => $data['tahun'],
            'bulan' => $data['bulan'],
            'sektor' => $data['sektor'],
            'unit_kerja_id' => $data['unit_kerja_id'] ?? null,
            'unit_kerja_nama' => $data['unit_kerja_nama']
        ])->first();

        if ($existing) {
            return $this->update($existing->id, $data);
        }

        return $this->insert($data);
    }

    /**
     * Get totals for a periode
     */
    public function getTotals($tahun, $bulan, $sektor = 'minerba')
    {
        $result = $this->select('
            SUM(permohonan_masuk) as total_permohonan_masuk,
            SUM(masih_proses) as total_masih_proses,
            SUM(disetujui) as total_disetujui,
            SUM(dikembalikan) as total_dikembalikan,
            SUM(ditolak) as total_ditolak
        ')
        ->where([
            'tahun' => $tahun,
            'bulan' => $bulan,
            'sektor' => $sektor
        ])
        ->first();

        return $result;
    }

    /**
     * Delete data by periode
     */
    public function deleteByPeriode($tahun, $bulan, $sektor = 'minerba')
    {
        return $this->where([
            'tahun' => $tahun,
            'bulan' => $bulan,
            'sektor' => $sektor
        ])->delete();
    }
}
