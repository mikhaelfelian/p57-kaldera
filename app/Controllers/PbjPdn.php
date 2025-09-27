<?php

namespace App\Controllers;

use App\Models\PbjPdnModel;

class PbjPdn extends BaseController
{
    protected $pbjPdnModel;

    public function __construct()
    {
        $this->pbjPdnModel = new PbjPdnModel();
        helper(['form']);
    }

    public function realisasi_pdn()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Indeks Realisasi PDN',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/realisasi_pdn', $data);
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
            $paguRupTaggingPdn = (int)($this->request->getPost('pagu_rup_tagging_pdn') ?: 0);
            $realisasiPdn = (int)($this->request->getPost('realisasi_pdn') ?: 0);
            
            // Calculate indeks: Realisasi PDN / Pagu RUP Tagging PDN * 100
            $indeks = $paguRupTaggingPdn > 0 ? ($realisasiPdn / $paguRupTaggingPdn) * 100 : 0;

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'pagu_rup_tagging_pdn' => $paguRupTaggingPdn,
                'realisasi_pdn' => $realisasiPdn,
                'indeks' => $indeks,
                'keterangan' => $this->request->getPost('keterangan'),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year and month
            $existing = $this->pbjPdnModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                // Update existing data
                $this->pbjPdnModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pbjPdnModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data PBJ PDN berhasil disimpan',
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

    public function rekap_realisasi_pdn()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Rekap Indeks Realisasi PDN',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'chartData' => $this->getChartData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/rekap_realisasi_pdn', $data);
    }

    private function getChartData($tahun, $bulan)
    {
        $data = $this->pbjPdnModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if (!$data) {
            return [
                'pagu' => 0,
                'realisasi' => 0,
                'indeks' => 0
            ];
        }
        
        return [
            'pagu' => $data['pagu_rup_tagging_pdn'],
            'realisasi' => $data['realisasi_pdn'],
            'indeks' => $data['indeks']
        ];
    }

    private function getExistingData($tahun, $bulan)
    {
        $data = $this->pbjPdnModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        return $data ?: [];
    }
}
