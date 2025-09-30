<?php

namespace App\Controllers;

use App\Models\BanmasBsModel;

class BanmasBs extends BaseController
{
    protected $banmasBsModel;

    public function __construct()
    {
        $this->banmasBsModel = new BanmasBsModel();
        helper(['form']);
    }

    public function barang()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Barang diserahkan',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'barangList' => $this->getBarangList()
        ];

        return $this->view($this->theme->getThemePath() . '/bantuan/barang', $data);
    }

    public function save()
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
            // Check if data exists for this year and month
            $existing = $this->banmasBsModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan
            ];

            // Only update fields that are provided
            if ($this->request->getPost('nama_barang') !== null) {
                $data['nama_barang'] = $this->request->getPost('nama_barang');
            }
            if ($this->request->getPost('deskripsi')) {
                $data['deskripsi'] = $this->request->getPost('deskripsi');
            }
            if ($this->request->getPost('nilai_barang')) {
                $data['nilai_barang'] = (float)$this->request->getPost('nilai_barang');
            }
            if ($this->request->getPost('status')) {
                $data['status'] = $this->request->getPost('status');
            }
            if ($this->request->getPost('catatan_kendala') !== null) {
                $data['catatan_kendala'] = $this->request->getPost('catatan_kendala');
            }
            if ($this->request->getPost('rencana_tindak_lanjut') !== null) {
                $data['rencana_tindak_lanjut'] = $this->request->getPost('rencana_tindak_lanjut');
            }
            if ($this->request->getPost('feedback_unit_kerja')) {
                $data['feedback_unit_kerja'] = json_encode($this->request->getPost('feedback_unit_kerja'));
            }

            if ($existing) {
                // Update only provided fields
                $this->banmasBsModel->update($existing['id'], $data);
                $resultData = $existing;
                $resultData['id'] = $existing['id'];
            } else {
                // Insert new data with default values
                $insertData = array_merge($data, [
                    'nama_barang' => $this->request->getPost('nama_barang') ?: '',
                    'deskripsi' => $this->request->getPost('deskripsi') ?: '',
                    'nilai_barang' => (float)($this->request->getPost('nilai_barang') ?: 0),
                    'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                    'catatan_kendala' => $this->request->getPost('catatan_kendala') ?: '',
                    'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut') ?: '',
                    'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);
                $this->banmasBsModel->insert($insertData);
                $resultData = ['id' => $this->banmasBsModel->getInsertID()];
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data barang diserahkan berhasil disimpan',
                'data' => $resultData,
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
            $isDokAdmin = $this->request->getPost('dok_admin') === '1';
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/bantuan/barang/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                // decide target columns for file fields
                $filePathColumn = $isDokAdmin ? 'file_path_dok' : 'file_path';
                $fileNameColumn = $isDokAdmin ? 'file_name_dok' : 'file_name';

                $data = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'nama_barang' => $this->request->getPost('nama_barang'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'nilai_barang' => (float)($this->request->getPost('nilai_barang') ?: 0),
                    $filePathColumn => 'file/bantuan/barang/' . $newName,
                    $fileNameColumn => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->banmasBsModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan
                ])->first();

                if ($existing) {
                    // Delete old file if exists for the same target column
                    $existingPath = $existing[$filePathColumn] ?? null;
                    if ($existingPath && file_exists(FCPATH . $existingPath)) {
                        unlink(FCPATH . $existingPath);
                    }
                    $this->banmasBsModel->update($existing['id'], $data);
                    $resultData = $existing;
                    $resultData['id'] = $existing['id'];
                    $resultData[$fileNameColumn] = $file->getClientName();
                } else {
                    $this->banmasBsModel->insert($data);
                    $resultData = ['id' => $this->banmasBsModel->getInsertID()];
                    $resultData[$fileNameColumn] = $file->getClientName();
                }

                return $this->response->setJSON([
                    'ok' => true, 
                    'message' => 'File berhasil diupload',
                    'data' => $resultData,
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
        $data = $this->banmasBsModel->find($id);
        
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
        $data = $this->banmasBsModel->find($id);
        
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
        $data = $this->banmasBsModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if ($data && $data['feedback_unit_kerja']) {
            $data['feedback_unit_kerja'] = json_decode($data['feedback_unit_kerja'], true);
        }
        
        return $data ? ['monitoring_progres' => $data] : [];
    }

    private function getBarangList()
    {
        return [
            'barang_makanan' => 'Barang Makanan',
            'barang_sembako' => 'Barang Sembako',
            'barang_sandang' => 'Barang Sandang',
            'barang_lainnya' => 'Barang Lainnya'
        ];
    }
}
