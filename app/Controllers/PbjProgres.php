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

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        $tahun = (int)($this->request->getGet('tahun') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        // Get existing data
        $existing = $this->getExistingData($tahun, $bulan);
        
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Sistem Kaldera ESDM')
            ->setLastModifiedBy('Sistem Kaldera ESDM')
            ->setTitle('Monitoring Progres Pencatatan PBJ')
            ->setSubject('Export Data PBJ Progres')
            ->setDescription('Data monitoring progres pencatatan PBJ untuk periode ' . $tahun . ' - ' . bulan_ke_str($bulan));
        
        // Set headers
        $headers = [
            'A1' => 'MONITORING PROGRES PENCATATAN PBJ',
            'A2' => 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan),
            'A3' => 'Tanggal Export: ' . date('d/m/Y H:i:s'),
            'A5' => 'No',
            'B5' => 'Bulan',
            'C5' => 'Status',
            'D5' => 'Catatan Kendala',
            'E5' => 'Rencana Tindak Lanjut',
            'F5' => 'Feedback Unit Kerja',
            'G5' => 'File Upload',
            'H5' => 'Keterangan',
            'I5' => 'Uploaded By',
            'J5' => 'Uploaded At'
        ];
        
        // Set header values
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Style headers
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A3')->getFont()->setSize(10);
        $sheet->getStyle('A5:J5')->getFont()->setBold(true);
        $sheet->getStyle('A5:J5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('3B6EA8');
        $sheet->getStyle('A5:J5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        
        // Set data
        $row = 6;
        if ($existing) {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, $existing['status'] ?? '');
            $sheet->setCellValue('D' . $row, $existing['catatan_kendala'] ?? '');
            $sheet->setCellValue('E' . $row, $existing['rencana_tindak_lanjut'] ?? '');
            
            // Process feedback data
            $feedbackData = [];
            if ($existing['feedback_unit_kerja']) {
                $feedback = json_decode($existing['feedback_unit_kerja'], true);
                if ($feedback) {
                    foreach ($feedback as $item) {
                        $feedbackData[] = ($item['unit_kerja'] ?? '') . ': ' . ($item['alasan_saran'] ?? '');
                    }
                }
            }
            $sheet->setCellValue('F' . $row, implode('; ', $feedbackData));
            $sheet->setCellValue('G' . $row, $existing['file_name'] ?? '');
            $sheet->setCellValue('H' . $row, $existing['keterangan'] ?? '');
            $sheet->setCellValue('I' . $row, $existing['uploaded_by'] ?? '');
            $sheet->setCellValue('J' . $row, $existing['uploaded_at'] ?? '');
        } else {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, 'Belum Ada Data');
        }
        
        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set filename
        $filename = 'PBJ_Progres_' . $tahun . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . date('YmdHis') . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Create writer and save
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export Excel for Rekap
     */
    public function rekapExportExcel()
    {
        $tahun = (int)($this->request->getGet('tahun') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        // Get existing data
        $existing = $this->getExistingData($tahun, $bulan);
        $chartData = $this->getChartData($tahun, $bulan);
        
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Sistem Kaldera ESDM')
            ->setLastModifiedBy('Sistem Kaldera ESDM')
            ->setTitle('Rekap Progres Pencatatan PBJ')
            ->setSubject('Export Data Rekap PBJ Progres')
            ->setDescription('Data rekap progres pencatatan PBJ untuk periode ' . $tahun . ' - ' . bulan_ke_str($bulan));
        
        // Set headers
        $headers = [
            'A1' => 'REKAP PROGRES PENCATATAN PBJ',
            'A2' => 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan),
            'A3' => 'Tanggal Export: ' . date('d/m/Y H:i:s'),
            'A5' => 'No',
            'B5' => 'Bulan',
            'C5' => 'Status',
            'D5' => 'Catatan Kendala',
            'E5' => 'Rencana Tindak Lanjut',
            'F5' => 'Feedback Unit Kerja',
            'G5' => 'File Upload',
            'H5' => 'Keterangan',
            'I5' => 'Uploaded By',
            'J5' => 'Uploaded At'
        ];
        
        // Set header values
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Style headers
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A3')->getFont()->setSize(10);
        $sheet->getStyle('A5:J5')->getFont()->setBold(true);
        $sheet->getStyle('A5:J5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('3B6EA8');
        $sheet->getStyle('A5:J5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        
        // Set data
        $row = 6;
        if ($existing) {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, $existing['status'] ?? '');
            $sheet->setCellValue('D' . $row, $existing['catatan_kendala'] ?? '');
            $sheet->setCellValue('E' . $row, $existing['rencana_tindak_lanjut'] ?? '');
            
            // Process feedback data
            $feedbackData = [];
            if ($existing['feedback_unit_kerja']) {
                $feedback = json_decode($existing['feedback_unit_kerja'], true);
                if ($feedback) {
                    foreach ($feedback as $item) {
                        $feedbackData[] = ($item['unit_kerja'] ?? '') . ': ' . ($item['alasan_saran'] ?? '');
                    }
                }
            }
            $sheet->setCellValue('F' . $row, implode('; ', $feedbackData));
            $sheet->setCellValue('G' . $row, $existing['file_name'] ?? '');
            $sheet->setCellValue('H' . $row, $existing['keterangan'] ?? '');
            $sheet->setCellValue('I' . $row, $existing['uploaded_by'] ?? '');
            $sheet->setCellValue('J' . $row, $existing['uploaded_at'] ?? '');
        } else {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, 'Belum Ada Data');
        }
        
        // Add chart data summary if available
        if ($chartData && !empty($chartData)) {
            $row += 2;
            $sheet->setCellValue('A' . $row, 'SUMMARY DATA');
            $sheet->getStyle('A' . $row)->getFont()->setBold(true)->setSize(14);
            $row++;
            
            foreach ($chartData as $key => $value) {
                $sheet->setCellValue('A' . $row, ucfirst(str_replace('_', ' ', $key)));
                $sheet->setCellValue('B' . $row, $value);
                $row++;
            }
        }
        
        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set filename
        $filename = 'PBJ_Rekap_Progres_' . $tahun . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . date('YmdHis') . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Create writer and save
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export PDF for Rekap
     */
    public function rekapExportPdf()
    {
        $tahun = (int)($this->request->getGet('tahun') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        // Get existing data
        $existing = $this->getExistingData($tahun, $bulan);
        $chartData = $this->getChartData($tahun, $bulan);
        
        // Create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('Sistem Kaldera ESDM');
        $pdf->SetAuthor('Sistem Kaldera ESDM');
        $pdf->SetTitle('Rekap Progres Pencatatan PBJ');
        $pdf->SetSubject('Export Data Rekap PBJ Progres');
        $pdf->SetKeywords('PBJ, Progres, ESDM, Kaldera');
        
        // Set default header data
        $pdf->SetHeaderData('', 0, 'REKAP PROGRES PENCATATAN PBJ', 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan) . ' | Tanggal: ' . date('d/m/Y H:i:s'));
        
        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', '', 10);
        
        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'REKAP PROGRES PENCATATAN PBJ', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan), 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal Export: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(10);
        
        // Data table
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'DATA PROGRES PBJ', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        
        if ($existing) {
            // Table headers
            $pdf->SetFillColor(59, 110, 168); // Blue background
            $pdf->SetTextColor(255, 255, 255); // White text
            $pdf->SetFont('helvetica', 'B', 9);
            
            $pdf->Cell(30, 8, 'Bulan', 1, 0, 'C', true);
            $pdf->Cell(25, 8, 'Status', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'File Upload', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Uploaded By', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Uploaded At', 1, 1, 'C', true);
            
            // Table data
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('helvetica', '', 9);
            
            $pdf->Cell(30, 8, bulan_ke_str($bulan), 1, 0, 'C');
            $pdf->Cell(25, 8, $existing['status'] ?? '', 1, 0, 'C');
            $pdf->Cell(40, 8, $existing['file_name'] ?? '', 1, 0, 'C');
            $pdf->Cell(40, 8, $existing['uploaded_by'] ?? '', 1, 0, 'C');
            $pdf->Cell(30, 8, $existing['uploaded_at'] ?? '', 1, 1, 'C');
            
            $pdf->Ln(10);
            
            // Catatan Kendala
            if (!empty($existing['catatan_kendala'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 6, 'Catatan Kendala:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 9);
                $pdf->MultiCell(0, 5, $existing['catatan_kendala'], 0, 'L');
                $pdf->Ln(5);
            }
            
            // Rencana Tindak Lanjut
            if (!empty($existing['rencana_tindak_lanjut'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 6, 'Rencana Tindak Lanjut:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 9);
                $pdf->MultiCell(0, 5, $existing['rencana_tindak_lanjut'], 0, 'L');
                $pdf->Ln(5);
            }
            
            // Feedback Unit Kerja
            if (!empty($existing['feedback_unit_kerja'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 6, 'Feedback Unit Kerja:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 9);
                
                $feedback = json_decode($existing['feedback_unit_kerja'], true);
                if ($feedback) {
                    foreach ($feedback as $index => $item) {
                        $pdf->SetFont('helvetica', 'B', 9);
                        $pdf->Cell(0, 5, 'Unit Kerja ' . $index . ':', 0, 1, 'L');
                        $pdf->SetFont('helvetica', '', 9);
                        $pdf->Cell(0, 5, 'Unit: ' . ($item['unit_kerja'] ?? ''), 0, 1, 'L');
                        $pdf->Cell(0, 5, 'Alasan/Saran: ' . ($item['alasan_saran'] ?? ''), 0, 1, 'L');
                        $pdf->Ln(3);
                    }
                }
            }
            
            // Keterangan
            if (!empty($existing['keterangan'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 6, 'Keterangan:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 9);
                $pdf->MultiCell(0, 5, $existing['keterangan'], 0, 'L');
            }
        } else {
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 8, 'Belum Ada Data untuk periode ini', 0, 1, 'C');
        }
        
        // Add chart data summary if available
        if ($chartData && !empty($chartData)) {
            $pdf->AddPage();
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(0, 8, 'SUMMARY DATA', 0, 1, 'L');
            $pdf->SetFont('helvetica', '', 10);
            
            foreach ($chartData as $key => $value) {
                $pdf->Cell(60, 6, ucfirst(str_replace('_', ' ', $key)) . ':', 0, 0, 'L');
                $pdf->Cell(0, 6, $value, 0, 1, 'L');
            }
        }
        
        // Set filename
        $filename = 'PBJ_Rekap_Progres_' . $tahun . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . date('YmdHis') . '.pdf';
        
        // Output PDF
        $pdf->Output($filename, 'D');
        exit;
    }
}
