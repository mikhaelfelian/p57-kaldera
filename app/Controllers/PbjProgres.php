<?php

namespace App\Controllers;

use App\Models\PbjProgresModel;

class PbjProgres extends BaseController
{
    protected $pbjProgresModel;

    public function __construct()
    {
        $this->pbjProgresModel = new PbjProgresModel();
        helper(['form']);
    }

    public function progres()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Monitoring Progres Pencatatan PBJ',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/progres', $data);
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
                'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                'catatan_kendala' => $this->request->getPost('catatan_kendala'),
                'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut'),
                'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year and month
            $existing = $this->pbjProgresModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                // Update existing data
                $this->pbjProgresModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pbjProgresModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data PBJ Progres berhasil disimpan',
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

    public function updateStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $status = $this->request->getPost('status');

        if (!$tahun || !$bulan || !$status) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            $existing = $this->pbjProgresModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                $this->pbjProgresModel->update($existing['id'], [
                    'status' => $status,
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->pbjProgresModel->insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'status' => $status,
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Status berhasil diperbarui',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Gagal memperbarui status: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function rekap_progres()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Rekap Progres PBJ',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'chartData' => $this->getChartData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/rekap_progres', $data);
    }

    private function getChartData($tahun, $bulan)
    {
        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if (!$data) {
            return [
                'status' => 'Belum Diperiksa',
                'has_verifikasi' => false,
                'has_feedback' => false
            ];
        }
        
        $feedbackData = $data['feedback_unit_kerja'] ? json_decode($data['feedback_unit_kerja'], true) : [];
        
        return [
            'status' => $data['status'],
            'has_verifikasi' => !empty($data['catatan_kendala']) || !empty($data['rencana_tindak_lanjut']),
            'has_feedback' => !empty($feedbackData),
            'feedback_count' => count($feedbackData)
        ];
    }

    private function getExistingData($tahun, $bulan)
    {
        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if ($data && $data['feedback_unit_kerja']) {
            $data['feedback_unit_kerja'] = json_decode($data['feedback_unit_kerja'], true);
        }
        
        return $data ?: [];
    }
}
