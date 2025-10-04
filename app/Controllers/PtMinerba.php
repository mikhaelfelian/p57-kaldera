<?php

namespace App\Controllers;

use App\Models\UnitKerjaModel;
use App\Models\PtModel;

class PtMinerba extends BaseController
{
    protected $unitKerjaModel;
    protected $ptModel;

    public function __construct()
    {
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->ptModel = new PtModel();
        helper(['form', 'url', 'tanggalan']);
    }

    public function index()
    {
        // Get parameters from URL
        $year = $this->request->getGet('year') ?? date('Y');
        $bulan = $this->request->getGet('bulan') ?? date('n');

        // Get unit kerja list
        $unitKerjaList = $this->unitKerjaModel->where('status', 'Aktif')->findAll();

        // Get existing data for this periode
        $existingData = $this->ptModel->getByPeriode($year, $bulan, 'minerba');

        // Create a map of existing data by unit kerja name
        $existingMap = [];
        foreach ($existingData as $item) {
            $existingMap[$item->unit_kerja_nama] = $item;
        }

        $data = [
            'title' => 'Persetujuan Teknis - Minerba',
            'year' => (int)$year,
            'bulan' => (int)$bulan,
            'unitKerjaList' => $unitKerjaList,
            'existingData' => $existingMap
        ];

        return $this->view($this->theme->getThemePath() . '/pt-minerba/input', $data);
    }

    public function saveData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Invalid request'
            ]);
        }

        try {
            $tahun = $this->request->getPost('tahun');
            $bulan = $this->request->getPost('bulan');
            $dataRows = $this->request->getPost('data');

            if (empty($dataRows) || !is_array($dataRows)) {
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'Data tidak valid',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }

            // Save each row
            foreach ($dataRows as $row) {
                $saveData = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'sektor' => 'minerba',
                    'unit_kerja_id' => $row['unit_kerja_id'] ?? null,
                    'unit_kerja_nama' => $row['unit_kerja_nama'],
                    'permohonan_masuk' => (int)($row['permohonan_masuk'] ?? 0),
                    'masih_proses' => (int)($row['masih_proses'] ?? 0),
                    'disetujui' => (int)($row['disetujui'] ?? 0),
                    'dikembalikan' => (int)($row['dikembalikan'] ?? 0),
                    'ditolak' => (int)($row['ditolak'] ?? 0),
                    'keterangan' => $row['keterangan'] ?? ''
                ];

                $this->ptModel->saveData($saveData);
            }

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error saving PT data: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
}
