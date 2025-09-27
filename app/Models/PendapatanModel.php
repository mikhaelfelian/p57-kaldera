<?php

namespace App\Models;

use CodeIgniter\Model;

class PendapatanModel extends Model
{
    protected $table = 'tbl_pendapatan';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tahun', 'tahapan',
        'retribusi_penyewaan', 'retribusi_laboratorium', 'retribusi_alat',
        'hasil_kerjasama', 'penerimaan_komisi', 'sewa_ruang_koperasi',
        'total'
    ];

    protected $validationRules = [
        'tahun' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        'tahapan' => 'required|in_list[penetapan,pergeseran,perubahan]',
        'retribusi_penyewaan' => 'permit_empty|numeric',
        'retribusi_laboratorium' => 'permit_empty|numeric',
        'retribusi_alat' => 'permit_empty|numeric',
        'hasil_kerjasama' => 'permit_empty|numeric',
        'penerimaan_komisi' => 'permit_empty|numeric',
        'sewa_ruang_koperasi' => 'permit_empty|numeric',
        'total' => 'permit_empty|numeric',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get data by tahun and tahapan
     */
    public function getByTahunTahapan($tahun, $tahapan)
    {
        return $this->where([
            'tahun' => $tahun,
            'tahapan' => $tahapan
        ])->first();
    }

    /**
     * Upsert data for a specific tahun and tahapan
     */
    public function upsert($tahun, $tahapan, $data)
    {
        $existing = $this->getByTahunTahapan($tahun, $tahapan);

        if ($existing) {
            $this->update($existing['id'], $data);
            return $existing['id'];
        } else {
            $data['tahun'] = $tahun;
            $data['tahapan'] = $tahapan;
            return $this->insert($data);
        }
    }

    /**
     * Calculate total from all fields
     */
    public function calculateTotal($data)
    {
        $fields = [
            'retribusi_penyewaan', 'retribusi_laboratorium', 'retribusi_alat',
            'hasil_kerjasama', 'penerimaan_komisi', 'sewa_ruang_koperasi'
        ];
        
        $total = 0;
        foreach ($fields as $field) {
            $total += (float)($data[$field] ?? 0);
        }
        
        return $total;
    }
}
