<?php

namespace App\Models;

use CodeIgniter\Model;

class FiskalModel extends Model
{
    protected $table = 'tbl_fiskal';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'master_id',
        'tipe',
        'tahun',
        'bulan',
        'tahapan',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Target Fisik (%)'
        'target_fisik',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Target Keuangan (%)'
        'target_keuangan',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Fisik (%)'
        'realisasi_fisik',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Keuangan (%)'
        'realisasi_keuangan',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Fisik Provinsi (%)'
        'realisasi_fisik_prov',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Keuangan Provinsi (%)'
        'realisasi_keuangan_prov',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Deviasi Fisik (%) - calculated field'
        'deviasi_fisik',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Deviasi Keuangan (%) - calculated field'
        'deviasi_keuangan',
        'analisa'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'master_id' => 'required|integer',
        'tipe' => 'required|in_list[0,1,2,3,4,5,6,7,8,9,10]',
        'tahun' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        'bulan' => 'required|in_list[jan,feb,mar,apr,mei,jun,jul,ags,sep,okt,nov,des]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Target Fisik (%)'
        'target_fisik' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Target Keuangan (%)'
        'target_keuangan' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Fisik (%)'
        'realisasi_fisik' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Keuangan (%)'
        'realisasi_keuangan' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Fisik Provinsi (%)'
        'realisasi_fisik_prov' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Realisasi Keuangan Provinsi (%)'
        'realisasi_keuangan_prov' => 'decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Deviasi Fisik (%) - calculated field'
        'deviasi_fisik' => 'decimal',
        // DECIMAL(20,2) NOT NULL DEFAULT '0.00' COMMENT 'Deviasi Keuangan (%) - calculated field'
        'deviasi_keuangan' => 'decimal',
    ];

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
     * Get data by master_id, tipe, and year
     */
    public function getByMasterTipeYear($masterId, $tipe = '1', $year = null)
    {
        if (!$year) {
            $year = date('Y');
        }
        $builder = $this->where([
            'master_id' => $masterId,
            'tipe' => $tipe,
            'tahun' => $year
        ]);

        // Optional tahapan filter if provided via GET param in request service
        $request = service('request');
        $tahapan = $request ? $request->getGet('tahapan') : null;
        if ($tahapan) {
            $builder = $builder->where('tahapan', $tahapan);
        }

        return $builder->orderBy('bulan', 'ASC')->findAll();
    }

    /**
     * Upsert data for a specific month
     */
    public function upsertMonthData($masterId, $tipe, $year, $bulan, $data)
    {
        // Ensure default values for DECIMAL(20,2) NOT NULL DEFAULT '0.00' fields
        $decimalFields = [
            'target_fisik',
            'target_keuangan',
            'realisasi_fisik',
            'realisasi_keuangan',
            'realisasi_fisik_prov',
            'realisasi_keuangan_prov',
            'deviasi_fisik',
            'deviasi_keuangan'
        ];
        foreach ($decimalFields as $field) {
            if (!isset($data[$field]) || $data[$field] === null || $data[$field] === '') {
                $data[$field] = '0.00';
            }
        }

            $existing = $this->where([
            'master_id' => $masterId,
            'tipe' => $tipe,
            'tahun' => $year,
            'bulan' => $bulan
        ])->first();

        if ($existing) {
            return $this->update($existing['id'], $data);
        } else {
            $data['master_id'] = $masterId;
            $data['tipe'] = $tipe;
            $data['tahun'] = $year;
            $data['bulan'] = $bulan;
            if (!isset($data['tahapan'])) {
                $request = service('request');
                $data['tahapan'] = $request ? ($request->getGet('tahapan') ?: $request->getPost('tahapan')) : 'penetapan';
            }
            return $this->insert($data);
        }
    }

    /**
     * Calculate and update deviation fields
     */
    public function updateDeviations($id)
    {
        $record = $this->find($id);
        if ($record) {
            // Ensure values are float for calculation, fallback to 0.00 if null
            $target_fisik = isset($record['target_fisik']) ? (float)$record['target_fisik'] : 0.00;
            $realisasi_fisik = isset($record['realisasi_fisik']) ? (float)$record['realisasi_fisik'] : 0.00;
            $target_keuangan = isset($record['target_keuangan']) ? (float)$record['target_keuangan'] : 0.00;
            $realisasi_keuangan = isset($record['realisasi_keuangan']) ? (float)$record['realisasi_keuangan'] : 0.00;

            $deviasi_fisik = round($realisasi_fisik - $target_fisik, 2);
            $deviasi_keuangan = round($realisasi_keuangan - $target_keuangan, 2);

            return $this->update($id, [
                'deviasi_fisik' => number_format($deviasi_fisik, 2, '.', ''),
                'deviasi_keuangan' => number_format($deviasi_keuangan, 2, '.', '')
            ]);
        }
        return false;
    }
}
