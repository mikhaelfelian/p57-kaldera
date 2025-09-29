<?php

namespace App\Controllers;

use App\Models\BanmasHibahModel;

class BanmasHibah extends BaseController
{
    protected $banmasHibahModel;

    public function __construct()
    {
        $this->banmasHibahModel = new BanmasHibahModel();
        helper(['form']);
    }

    public function hibah()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Bantuan Hibah',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'hibahList' => $this->getHibahList()
        ];

        return $this->view($this->theme->getThemePath() . '/bantuan/hibah', $data);
    }
    
    

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $jenis_hibah = $this->request->getPost('jenis_hibah');

        if (!$tahun || !$bulan || !$jenis_hibah) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak lengkap']);
        }

        try {
            // Check if data exists for this year, month, and jenis_hibah
            $existing = $this->banmasHibahModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_hibah' => $jenis_hibah
            ])->first();

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'jenis_hibah' => $jenis_hibah
            ];

            // Only update fields that are provided
            if ($this->request->getPost('nama_hibah')) {
                $data['nama_hibah'] = $this->request->getPost('nama_hibah');
            }
            if ($this->request->getPost('deskripsi')) {
                $data['deskripsi'] = $this->request->getPost('deskripsi');
            }
            if ($this->request->getPost('nilai_hibah')) {
                $data['nilai_hibah'] = (float)$this->request->getPost('nilai_hibah');
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
                $this->banmasHibahModel->update($existing['id'], $data);
            } else {
                // Insert new data with default values
                $data = array_merge($data, [
                    'nama_hibah' => $this->request->getPost('nama_hibah') ?: '',
                    'deskripsi' => $this->request->getPost('deskripsi') ?: '',
                    'nilai_hibah' => (float)($this->request->getPost('nilai_hibah') ?: 0),
                    'status' => $this->request->getPost('status') ?: 'Belum Diperiksa',
                    'catatan_kendala' => $this->request->getPost('catatan_kendala') ?: '',
                    'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut') ?: '',
                    'feedback_unit_kerja' => json_encode($this->request->getPost('feedback_unit_kerja') ?: []),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);
                $this->banmasHibahModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data hibah berhasil disimpan',
                'data' => $existing ? $existing : ['id' => $this->banmasHibahModel->getInsertID()],
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
        // Log all requests to this method
        log_message('debug', 'Upload method called - isAJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('debug', 'Request method: ' . $this->request->getMethod());
        log_message('debug', 'Content type: ' . $this->request->getHeaderLine('Content-Type'));
        
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $jenisHibah = $this->request->getPost('jenis_hibah');

        // Debug logging
        log_message('debug', 'Upload request - tahun: ' . $tahun . ', bulan: ' . $bulan . ', jenis_hibah: ' . $jenisHibah);
        log_message('debug', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('debug', 'Files: ' . json_encode($this->request->getFiles()));
        
        // More detailed validation
        $missingFields = [];
        if (!$tahun) $missingFields[] = 'tahun';
        if (!$bulan) $missingFields[] = 'bulan';
        if (!$jenisHibah) $missingFields[] = 'jenis_hibah';
        
        if (!empty($missingFields)) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Data tidak lengkap - Missing: ' . implode(', ', $missingFields),
                'debug' => [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_hibah' => $jenisHibah,
                    'post_data' => $this->request->getPost()
                ]
            ]);
        }

        try {
            $file = $this->request->getFile('file');
            $isDokAdmin = $this->request->getPost('dok_admin') === '1';
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Create upload directory if not exists
                $uploadPath = FCPATH . 'file/bantuan/hibah/';
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
                    'jenis_hibah' => $jenisHibah,
                    'nama_hibah' => $this->request->getPost('nama_hibah'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'nilai_hibah' => (float)($this->request->getPost('nilai_hibah') ?: 0),
                    $filePathColumn => 'file/bantuan/hibah/' . $newName,
                    $fileNameColumn => $file->getClientName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];

                // Check if data exists
                $existing = $this->banmasHibahModel->where([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'jenis_hibah' => $jenisHibah
                ])->first();

                if ($existing) {
                    // Delete old file if exists for the same target column
                    $existingPath = $existing[$filePathColumn] ?? null;
                    if ($existingPath && file_exists(FCPATH . $existingPath)) {
                        unlink(FCPATH . $existingPath);
                    }
                    log_message('debug', 'Updating existing record ID: ' . $existing['id']);
                    $this->banmasHibahModel->update($existing['id'], $data);
                } else {
                    log_message('debug', 'Inserting new record');
                    $this->banmasHibahModel->insert($data);
                }

                $insertedId = $existing ? $existing['id'] : $this->banmasHibahModel->getInsertID();
                log_message('debug', 'Final inserted/updated ID: ' . $insertedId);
                
                return $this->response->setJSON([
                    'ok' => true, 
                    'message' => 'File berhasil diupload dan disimpan ke database',
                    'data' => [
                        'id' => $insertedId,
                        'file_name' => $file->getClientName(),
                        'file_path' => 'file/bantuan/hibah/' . $newName,
                        'target_columns' => [ 'path' => $filePathColumn, 'name' => $fileNameColumn ],
                        'file_size' => $file->getSize()
                    ],
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
        $data = $this->banmasHibahModel->find($id);
        
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
        $data = $this->banmasHibahModel->find($id);
        
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
        $data = $this->banmasHibahModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->findAll();
        
        // Debug logging
        log_message('debug', 'getExistingData - tahun: ' . $tahun . ', bulan: ' . $bulan);
        log_message('debug', 'Found ' . count($data) . ' records');
        
        $result = [];
        foreach ($data as $row) {
            if ($row['feedback_unit_kerja']) {
                $row['feedback_unit_kerja'] = json_decode($row['feedback_unit_kerja'], true);
            }
            $result[$row['jenis_hibah']] = $row;
            log_message('debug', 'Added to result: ' . $row['jenis_hibah'] . ' (ID: ' . $row['id'] . ')');
        }
        
        log_message('debug', 'Final result keys: ' . implode(', ', array_keys($result)));
        return $result;
    }

    private function getHibahList()
    {
        return [
            'hibah_uang' => 'Hibah Uang',
            'hibah_barang' => 'Hibah Barang',
            'hibah_jasa' => 'Hibah Jasa',
            'hibah_lainnya' => 'Hibah Lainnya'
        ];
    }
}
