<?php

namespace App\Controllers;

use App\Models\BanmasBansosModel;

class BanmasBansos extends BaseController
{
    protected $banmasBansosModel;

    public function __construct()
    {
        $this->banmasBansosModel = new BanmasBansosModel();
        helper(['form']);
    }

    public function bansos()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Bantuan Sosial',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'bansosList' => $this->getBansosList()
        ];

        return $this->view($this->theme->getThemePath() . '/bantuan/bansos', $data);
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
                'jenis_bansos' => $this->request->getPost('jenis_bansos'),
                'nama_bansos' => $this->request->getPost('nama_bansos'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'nilai_bansos' => (int)($this->request->getPost('nilai_bansos') ?: 0),
                'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                'catatan_kendala' => $this->request->getPost('catatan_kendala'),
                'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut'),
                'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year, month, and jenis_bansos
            $existing = $this->banmasBansosModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_bansos' => $data['jenis_bansos']
            ])->first();

            if ($existing) {
                // Update existing data
                $this->banmasBansosModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->banmasBansosModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data bantuan sosial berhasil disimpan',
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
        $jenisBansos = $this->request->getPost('jenis_bansos');

        if (!$tahun || !$bulan || !$jenisBansos) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/bantuan/bansos/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $data = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_bansos' => $jenisBansos,
                    'nama_bansos' => $this->request->getPost('nama_bansos'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'nilai_bansos' => (int)($this->request->getPost('nilai_bansos') ?: 0),
                    'file_path' => 'file/bantuan/bansos/' . $newName,
                    'file_name' => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->banmasBansosModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_bansos' => $jenisBansos
                ])->first();

                if ($existing) {
                    // Delete old file if exists
                    if ($existing['file_path'] && file_exists(FCPATH . $existing['file_path'])) {
                        unlink(FCPATH . $existing['file_path']);
                    }
                    $this->banmasBansosModel->update($existing['id'], $data);
                } else {
                    $this->banmasBansosModel->insert($data);
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
        $data = $this->banmasBansosModel->find($id);
        
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
        $data = $this->banmasBansosModel->find($id);
        
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
        $data = $this->banmasBansosModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->findAll();
        
        $result = [];
        foreach ($data as $row) {
            if ($row['feedback_unit_kerja']) {
                $row['feedback_unit_kerja'] = json_decode($row['feedback_unit_kerja'], true);
            }
            $result[$row['jenis_bansos']] = $row;
        }
        
        return $result;
    }

    private function getBansosList()
    {
        return [
            'bansos_tunai' => 'Bantuan Sosial Tunai',
            'bansos_non_tunai' => 'Bantuan Sosial Non Tunai',
            'bansos_beras' => 'Bantuan Sosial Beras',
            'bansos_lainnya' => 'Bantuan Sosial Lainnya'
        ];
    }
}
