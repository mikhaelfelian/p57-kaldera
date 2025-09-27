<?php

namespace App\Models;

use CodeIgniter\Model;

class PendapatanInputModel extends Model
{
    protected $table = 'tbl_pendapatan_input';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tahun', 'tahapan', 'bulan',
        'retribusi_penyewaan_target', 'retribusi_penyewaan_realisasi',
        'retribusi_laboratorium_target', 'retribusi_laboratorium_realisasi',
        'retribusi_alat_target', 'retribusi_alat_realisasi',
        'hasil_kerjasama_target', 'hasil_kerjasama_realisasi',
        'penerimaan_komisi_target', 'penerimaan_komisi_realisasi',
        'sewa_ruang_koperasi_target', 'sewa_ruang_koperasi_realisasi',
        'total_target', 'total_realisasi'
    ];

    protected $validationRules = [
        'tahun' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        'tahapan' => 'required|in_list[penetapan,pergeseran,perubahan]',
        'bulan' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[12]',
        'retribusi_penyewaan_target' => 'permit_empty|numeric',
        'retribusi_penyewaan_realisasi' => 'permit_empty|numeric',
        'retribusi_laboratorium_target' => 'permit_empty|numeric',
        'retribusi_laboratorium_realisasi' => 'permit_empty|numeric',
        'retribusi_alat_target' => 'permit_empty|numeric',
        'retribusi_alat_realisasi' => 'permit_empty|numeric',
        'hasil_kerjasama_target' => 'permit_empty|numeric',
        'hasil_kerjasama_realisasi' => 'permit_empty|numeric',
        'penerimaan_komisi_target' => 'permit_empty|numeric',
        'penerimaan_komisi_realisasi' => 'permit_empty|numeric',
        'sewa_ruang_koperasi_target' => 'permit_empty|numeric',
        'sewa_ruang_koperasi_realisasi' => 'permit_empty|numeric',
        'total_target' => 'permit_empty|numeric',
        'total_realisasi' => 'permit_empty|numeric',
    ];

    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get data by tahun, tahapan, bulan
     */
    public function getByTahunTahapanBulan($tahun, $tahapan, $bulan)
    {
        return $this->where([
            'tahun' => $tahun,
            'tahapan' => $tahapan,
            'bulan' => $bulan
        ])->first();
    }

    /**
     * Upsert data for a specific tahun, tahapan, bulan
     */
    public function upsert($tahun, $tahapan, $bulan, $data)
    {
        $existing = $this->getByTahunTahapanBulan($tahun, $tahapan, $bulan);

        if ($existing) {
            $this->update($existing['id'], $data);
            return $existing['id'];
        } else {
            $data['tahun'] = $tahun;
            $data['tahapan'] = $tahapan;
            $data['bulan'] = $bulan;
            return $this->insert($data);
        }
    }

    /**
     * Calculate totals from all fields
     */
    public function calculateTotals($data)
    {
        $targetFields = [
            'retribusi_penyewaan_target', 'retribusi_laboratorium_target', 'retribusi_alat_target',
            'hasil_kerjasama_target', 'penerimaan_komisi_target', 'sewa_ruang_koperasi_target'
        ];
        
        $realisasiFields = [
            'retribusi_penyewaan_realisasi', 'retribusi_laboratorium_realisasi', 'retribusi_alat_realisasi',
            'hasil_kerjasama_realisasi', 'penerimaan_komisi_realisasi', 'sewa_ruang_koperasi_realisasi'
        ];
        
        $totalTarget = 0;
        $totalRealisasi = 0;
        
        foreach ($targetFields as $field) {
            $totalTarget += (float)($data[$field] ?? 0);
        }
        
        foreach ($realisasiFields as $field) {
            $totalRealisasi += (float)($data[$field] ?? 0);
        }
        
        return [
            'total_target' => $totalTarget,
            'total_realisasi' => $totalRealisasi
        ];
    }
}
