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
                'uploaded_by' => session('user_id') ?? 1,
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
                    'uploaded_by' => session('user_id') ?? 1,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                $this->pbjProgresModel->insert([
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'status' => $status,
                    'uploaded_by' => session('user_id') ?? 1,
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

    /**
     * Upload file for PBJ progres
     */
    public function uploadFile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        if (!$this->validate([
            'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,xlsx,xls,jpg,jpeg,png]',
            'tahun' => 'required|integer',
            'bulan' => 'required|integer'
        ])) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $keterangan = $this->request->getPost('keterangan');
        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'File tidak valid'
            ]);
        }

        try {
            // Generate unique filename
            $filename = 'pbj_progres_' . $tahun . '_' . $bulan . '_' . time() . '.' . $file->getExtension();
            $uploadPath = 'file/pbj/progres/' . $tahun;
            
            // Create directory if not exists
            if (!is_dir(WRITEPATH . '../public/file/pbj/progres/' . $tahun)) {
                mkdir(WRITEPATH . '../public/file/pbj/progres/' . $tahun, 0755, true);
            }

            if (!$file->move(WRITEPATH . '../public/file/pbj/progres/' . $tahun, $filename)) {
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'Gagal mengupload file'
                ]);
            }

            // Check if data exists for this year and month
            $existing = $this->pbjProgresModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'file_path' => $uploadPath . '/' . $filename,
                'file_name' => $file->getClientName(),
                'file_size' => $file->getSize(),
                'keterangan' => $keterangan,
                'uploaded_by' => session('user_id') ?? 1,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            if ($existing) {
                // Delete old file if exists
                if ($existing['file_path'] && file_exists(WRITEPATH . '../public/' . $existing['file_path'])) {
                    unlink(WRITEPATH . '../public/' . $existing['file_path']);
                }
                
                // Update existing data
                $this->pbjProgresModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pbjProgresModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'file_name' => $file->getClientName(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    /**
     * Check if file exists for given year and month
     */
    public function checkFile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getGet('tahun');
        $bulan = (int)$this->request->getGet('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan bulan harus diisi']);
        }

        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();

        if ($data && $data['file_path']) {
            return $this->response->setJSON([
                'ok' => true,
                'has_file' => true,
                'file_name' => $data['file_name'],
                'file_path' => $data['file_path'],
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'ok' => true,
            'has_file' => false,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    /**
     * Preview file
     */
    public function previewFile($tahun, $bulan)
    {
        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();

        if (!$data || !$data['file_path']) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan');
        }

        $filePath = WRITEPATH . '../public/' . $data['file_path'];
        
        // Debug: Log the file path
        log_message('debug', 'Preview file path: ' . $filePath);
        log_message('debug', 'File exists: ' . (file_exists($filePath) ? 'YES' : 'NO'));
        
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan. Path: ' . $filePath);
        }

        // Get file extension
        $extension = pathinfo($data['file_name'], PATHINFO_EXTENSION);
        
        // Set content type
        $contentType = 'application/octet-stream';
        switch (strtolower($extension)) {
            case 'pdf':
                $contentType = 'application/pdf';
                break;
            case 'jpg':
            case 'jpeg':
                $contentType = 'image/jpeg';
                break;
            case 'png':
                $contentType = 'image/png';
                break;
            case 'gif':
                $contentType = 'image/gif';
                break;
            case 'doc':
                $contentType = 'application/msword';
                break;
            case 'docx':
                $contentType = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
                break;
            case 'xls':
                $contentType = 'application/vnd.ms-excel';
                break;
            case 'xlsx':
                $contentType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                break;
        }

        // Check if it's a preview request (from iframe)
        $isPreview = $this->request->getGet('preview') === '1';
        
        // Debug logging
        log_message('debug', 'Preview request: ' . ($isPreview ? 'YES' : 'NO'));
        log_message('debug', 'File extension: ' . $extension);
        log_message('debug', 'Content type: ' . $contentType);
        
        if ($isPreview && in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'html', 'htm'])) {
            $disposition = 'inline';
        } else {
            $disposition = 'attachment';
        }
        
        log_message('debug', 'Disposition: ' . $disposition);

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: ' . $disposition . '; filename="' . $data['file_name'] . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Download file
     */
    public function downloadFile($tahun, $bulan)
    {
        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();

        if (!$data || !$data['file_path']) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan');
        }

        $filePath = WRITEPATH . '../public/' . $data['file_path'];
        
        // Debug: Log the file path
        log_message('debug', 'Download file path: ' . $filePath);
        log_message('debug', 'File exists: ' . (file_exists($filePath) ? 'YES' : 'NO'));
        
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan. Path: ' . $filePath);
        }

        // Force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $data['file_name'] . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Get verifikasi data
     */
    public function getVerifikasi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getGet('tahun');
        $bulan = (int)$this->request->getGet('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan bulan harus diisi']);
        }

        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();

        if ($data) {
            return $this->response->setJSON([
                'ok' => true,
                'data' => [
                    'catatan_kendala' => $data['catatan_kendala'],
                    'rencana_tindak_lanjut' => $data['rencana_tindak_lanjut']
                ],
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => [
                'catatan_kendala' => '',
                'rencana_tindak_lanjut' => ''
            ],
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    /**
     * Save verifikasi data
     */
    public function saveVerifikasi()
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
                'catatan_kendala' => $this->request->getPost('catatan_kendala'),
                'rencana_tindak_lanjut' => $this->request->getPost('rencana_tindak_lanjut'),
                'verifikasi_by' => session('user_id') ?? 1,
                'verifikasi_at' => date('Y-m-d H:i:s')
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
                'message' => 'Verifikasi berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan verifikasi: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    /**
     * Get feedback data
     */
    public function getFeedback()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getGet('tahun');
        $bulan = (int)$this->request->getGet('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan bulan harus diisi']);
        }

        $data = $this->pbjProgresModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();

        log_message('debug', 'Get feedback - Data found: ' . ($data ? 'YES' : 'NO'));
        if ($data) {
            log_message('debug', 'Get feedback - feedback_unit_kerja: ' . ($data['feedback_unit_kerja'] ?? 'NULL'));
        }

        if ($data && $data['feedback_unit_kerja']) {
            $feedbackData = json_decode($data['feedback_unit_kerja'], true);
            
            log_message('debug', 'Get feedback - Decoded data: ' . json_encode($feedbackData));
            
            return $this->response->setJSON([
                'ok' => true,
                'data' => $feedbackData ?: [],
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => [],
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    /**
     * Save feedback data
     */
    public function saveFeedback()
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
            $feedbackData = $this->request->getPost('feedback_unit_kerja') ?: [];
            
            // Filter out empty rows
            $filteredData = array_filter($feedbackData, function($item) {
                return !empty($item['unit_kerja']) || !empty($item['alasan_saran']);
            });

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'feedback_unit_kerja' => json_encode($filteredData),
                'feedback_by' => session('user_id') ?? 1,
                'feedback_at' => date('Y-m-d H:i:s')
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
                'message' => 'Feedback berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan feedback: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
}
