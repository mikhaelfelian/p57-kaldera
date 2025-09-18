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
        'target_fisik',
        'target_keuangan',
        'realisasi_fisik',
        'realisasi_keuangan',
        'realisasi_fisik_prov',
        'realisasi_keuangan_prov',
        'deviasi_fisik',
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
        'target_fisik' => 'decimal',
        'target_keuangan' => 'decimal',
        'realisasi_fisik' => 'decimal',
        'realisasi_keuangan' => 'decimal',
        'realisasi_fisik_prov' => 'decimal',
        'realisasi_keuangan_prov' => 'decimal',
        'deviasi_fisik' => 'decimal',
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
        
        return $this->where([
            'master_id' => $masterId,
            'tipe' => $tipe,
            'tahun' => $year
        ])->orderBy('bulan', 'ASC')->findAll();
    }

    /**
     * Upsert data for a specific month
     */
    public function upsertMonthData($masterId, $tipe, $year, $bulan, $data)
    {
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
            $deviasi_fisik = $record['realisasi_fisik'] - $record['target_fisik'];
            $deviasi_keuangan = $record['realisasi_keuangan'] - $record['target_keuangan'];
            
            return $this->update($id, [
                'deviasi_fisik' => $deviasi_fisik,
                'deviasi_keuangan' => $deviasi_keuangan
            ]);
        }
        return false;
    }
}
