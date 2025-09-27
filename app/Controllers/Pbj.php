<?php

namespace App\Controllers;

use App\Models\PbjModel;

class Pbj extends BaseController
{
    protected $pbjModel;

    public function __construct()
    {
        $this->pbjModel = new PbjModel();
        helper(['form']);
    }

    public function input()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Input PBJ',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/input', $data);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan bulan harus diisi']);
        }

        try {
            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'rup_tender_pagu' => (int)($this->request->getPost('rup_tender_pagu') ?: 0),
                'rup_tender_realisasi' => (int)($this->request->getPost('rup_tender_realisasi') ?: 0),
                'rup_epurchasing_pagu' => (int)($this->request->getPost('rup_epurchasing_pagu') ?: 0),
                'rup_epurchasing_realisasi' => (int)($this->request->getPost('rup_epurchasing_realisasi') ?: 0),
                'rup_nontender_pagu' => (int)($this->request->getPost('rup_nontender_pagu') ?: 0),
                'rup_nontender_realisasi' => (int)($this->request->getPost('rup_nontender_realisasi') ?: 0),
                'swakelola_pagu' => (int)($this->request->getPost('swakelola_pagu') ?: 0),
                'swakelola_realisasi' => (int)($this->request->getPost('swakelola_realisasi') ?: 0),
                'keterangan_tender' => $this->request->getPost('keterangan_tender'),
                'keterangan_epurchasing' => $this->request->getPost('keterangan_epurchasing'),
                'keterangan_nontender' => $this->request->getPost('keterangan_nontender'),
                'keterangan_swakelola' => $this->request->getPost('keterangan_swakelola'),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year and month
            $existing = $this->pbjModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                // Update existing data
                $this->pbjModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pbjModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data PBJ berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function rekap_indeks()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Rekap Indeks PBJ',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'chartData' => $this->getChartData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/rekap_indeks', $data);
    }

    private function getChartData($tahun, $bulan)
    {
        $data = $this->pbjModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if (!$data) {
            return [
                'total' => 0,
                'tender' => 0,
                'epurchasing' => 0,
                'nontender' => 0,
                'swakelola' => 0
            ];
        }
        
        $totalPagu = $data['rup_tender_pagu'] + $data['rup_epurchasing_pagu'] + 
                     $data['rup_nontender_pagu'] + $data['swakelola_pagu'];
        $totalRealisasi = $data['rup_tender_realisasi'] + $data['rup_epurchasing_realisasi'] + 
                         $data['rup_nontender_realisasi'] + $data['swakelola_realisasi'];
        
        return [
            'total' => $totalPagu,
            'realisasi' => $totalRealisasi,
            'tender' => $data['rup_tender_realisasi'],
            'epurchasing' => $data['rup_epurchasing_realisasi'],
            'nontender' => $data['rup_nontender_realisasi'],
            'swakelola' => $data['swakelola_realisasi']
        ];
    }

    private function getExistingData($tahun, $bulan)
    {
        $data = $this->pbjModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        return $data ?: [];
    }
}
