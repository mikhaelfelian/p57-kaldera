<?php

namespace App\Models;

use CodeIgniter\Model;

class BelanjaInputModel extends Model
{
    protected $table = 'tbl_belanja_input';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'tahun', 'tahapan', 'bulan',
        'pegawai_anggaran', 'pegawai_realisasi',
        'barang_jasa_anggaran', 'barang_jasa_realisasi',
        'hibah_anggaran', 'hibah_realisasi',
        'bansos_anggaran', 'bansos_realisasi',
        'modal_anggaran', 'modal_realisasi',
        'total_anggaran', 'total_realisasi'
    ];

    protected $validationRules = [
        'tahun' => 'required|integer|greater_than_equal_to[2000]|less_than_equal_to[2100]',
        'tahapan' => 'required|in_list[penetapan,pergeseran,perubahan]',
        'bulan' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[12]',
        'pegawai_anggaran' => 'permit_empty|numeric',
        'pegawai_realisasi' => 'permit_empty|numeric',
        'barang_jasa_anggaran' => 'permit_empty|numeric',
        'barang_jasa_realisasi' => 'permit_empty|numeric',
        'hibah_anggaran' => 'permit_empty|numeric',
        'hibah_realisasi' => 'permit_empty|numeric',
        'bansos_anggaran' => 'permit_empty|numeric',
        'bansos_realisasi' => 'permit_empty|numeric',
        'modal_anggaran' => 'permit_empty|numeric',
        'modal_realisasi' => 'permit_empty|numeric',
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
}
