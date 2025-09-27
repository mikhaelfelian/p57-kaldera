<?php

namespace App\Controllers;

use App\Models\PgModel;

class Pg extends BaseController
{
    protected $pgModel;

    public function __construct()
    {
        $this->pgModel = new PgModel();
        helper(['form']);
    }

    public function pk()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'RANCANGAN AKSI PERUBAHAN',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'indikatorList' => $this->getIndikatorList()
        ];

        return $this->view($this->theme->getThemePath() . '/pk/index', $data);
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
                'indikator' => $this->request->getPost('indikator'),
                'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                'catatan_kendala' => $this->request->getPost('catatan_kendala'),
                'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut'),
                'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year and month
            $existing = $this->pgModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                // Update existing data
                $this->pgModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pgModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data rancangan aksi perubahan berhasil disimpan',
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

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/pk/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $data = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'indikator' => $this->request->getPost('indikator'),
                    'file_path' => 'file/pk/' . $newName,
                    'file_name' => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->pgModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ])->first();

                if ($existing) {
                    // Delete old file if exists
                    if ($existing['file_path'] && file_exists(FCPATH . $existing['file_path'])) {
                        unlink(FCPATH . $existing['file_path']);
                    }
                    $this->pgModel->update($existing['id'], $data);
                } else {
                    $this->pgModel->insert($data);
                }

                return $this->response->setJSON([
                    'ok' => true, 
                    'message' => 'File berhasil diupload',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON([
                    'ok' => false, 
                    'message' => 'File tidak valid',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Gagal mengupload file: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function preview($id)
    {
        $data = $this->pgModel->find($id);
        
        if (!$data) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        if ($data['feedback_unit_kerja']) {
            $data['feedback_unit_kerja'] = json_decode($data['feedback_unit_kerja'], true);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => $data,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function download($id)
    {
        $data = $this->pgModel->find($id);
        
        if (!$data || !$data['file_path']) {
            return $this->response->setJSON(['ok' => false, 'message' => 'File tidak ditemukan']);
        }

        $filePath = FCPATH . $data['file_path'];
        
        if (!file_exists($filePath)) {
            return $this->response->setJSON(['ok' => false, 'message' => 'File tidak ditemukan']);
        }

        return $this->response->download($filePath, $data['file_name']);
    }

    private function getExistingData($tahun, $bulan)
    {
        $data = $this->pgModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if ($data && $data['feedback_unit_kerja']) {
            $data['feedback_unit_kerja'] = json_decode($data['feedback_unit_kerja'], true);
        }
        
        return $data;
    }

    private function getIndikatorList()
    {
        return [
            'monitoring_progres_belanja' => 'Monitoring Progres Belanja Konsultansi, dll',
            'monitoring_progres_barang' => 'Monitoring Progres Barang yang diserahkan kepada masyarakat',
            'monitoring_progres_lainnya' => 'Monitoring Progres Lainnya'
        ];
    }
}