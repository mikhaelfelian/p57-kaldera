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
        $jenis_barang = $this->request->getPost('jenis_barang');

        if (!$tahun || !$bulan || !$jenis_barang) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            // Check if data exists for this year, month, and jenis_barang
            $existing = $this->banmasBsModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_barang' => $jenis_barang
            ])->first();

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_barang' => $jenis_barang
            ];

            // Only update fields that are provided
            if ($this->request->getPost('nama_barang')) {
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
            if ($this->request->getPost('catatan_kendala')) {
                $data['catatan_kendala'] = $this->request->getPost('catatan_kendala');
            }
            if ($this->request->getPost('rencana_tindak_lanjut')) {
                $data['rencana_tindak_lanjut'] = $this->request->getPost('rencana_tindak_lanjut');
            }
            if ($this->request->getPost('feedback_unit_kerja')) {
                $data['feedback_unit_kerja'] = json_encode($this->request->getPost('feedback_unit_kerja'));
            }

            if ($existing) {
                // Update only provided fields
                $this->banmasBsModel->update($existing['id'], $data);
            } else {
                // Insert new data with default values
                $data = array_merge($data, [
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
                $this->banmasBsModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data barang diserahkan berhasil disimpan',
                'data' => $existing ? $existing : ['id' => $this->banmasBsModel->getInsertID()],
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
        $jenisBarang = $this->request->getPost('jenis_barang');

        if (!$tahun || !$bulan || !$jenisBarang) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            $file = $this->request->getFile('file');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/bantuan/barang/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $newName = $file->getRandomName();
                $file->move($uploadPath, $newName);

                $data = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_barang' => $jenisBarang,
                    'nama_barang' => $this->request->getPost('nama_barang'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'nilai_barang' => (int)($this->request->getPost('nilai_barang') ?: 0),
                    'file_path' => 'file/bantuan/barang/' . $newName,
                    'file_name' => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->banmasBsModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_barang' => $jenisBarang
                ])->first();

                if ($existing) {
                    // Delete old file if exists
                    if ($existing['file_path'] && file_exists(FCPATH . $existing['file_path'])) {
                        unlink(FCPATH . $existing['file_path']);
                    }
                    $this->banmasBsModel->update($existing['id'], $data);
                } else {
                    $this->banmasBsModel->insert($data);
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
        ])->findAll();
        
        $result = [];
        foreach ($data as $row) {
            if ($row['feedback_unit_kerja']) {
                $row['feedback_unit_kerja'] = json_decode($row['feedback_unit_kerja'], true);
            }
            $result[$row['jenis_barang']] = $row;
        }
        
        return $result;
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
