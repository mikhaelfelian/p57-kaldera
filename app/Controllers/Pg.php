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

    public function pengawasan()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Pengawasan',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'indikatorList' => $this->getIndikatorList()
        ];

        return $this->view($this->theme->getThemePath() . '/pk/pengawasan', $data);
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
                'deskripsi' => $this->request->getPost('deskripsi'),
                'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                'catatan_kendala' => $this->request->getPost('catatan_kendala'),
                'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut'),
                'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year, month, and indikator
            $existing = $this->pgModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'indikator' => $data['indikator']
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
                'message' => 'Data pengawasan berhasil disimpan',
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
        $indikator = $this->request->getPost('indikator');

        if (!$tahun || !$bulan || !$indikator) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/pk/pengawasan/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $data = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'indikator' => $indikator,
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'file_path' => 'file/pk/pengawasan/' . $newName,
                    'file_name' => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->pgModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'indikator' => $indikator
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
        ])->findAll();
        
        $result = [];
        foreach ($data as $row) {
            if ($row['feedback_unit_kerja']) {
                $row['feedback_unit_kerja'] = json_decode($row['feedback_unit_kerja'], true);
            }
            $result[$row['indikator']] = $row;
        }
        
        return $result;
    }

    private function getIndikatorList()
    {
        return [
            'monitoring_belanja_konsultansi' => 'Monitoring Progres Belanja Konsultansi, dll',
            'monitoring_belanja_operasional' => 'Monitoring Progres Belanja Operasional',
            'monitoring_belanja_modal' => 'Monitoring Progres Belanja Modal',
            'monitoring_lainnya' => 'Monitoring Progres Lainnya'
        ];
    }
}
