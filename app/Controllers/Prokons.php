<?php

namespace App\Controllers;

use App\Models\ProkonsModel;

class Prokons extends BaseController
{
    protected $prokonsModel;

    public function __construct()
    {
        parent::__construct();
        $this->prokonsModel = new ProkonsModel();
        helper(['form']);
    }

    /**
     * Index page - main prokons management page
     */
    public function index()
    {
        // Get year and month from URL parameters or use current date
        $tahun = $this->request->getGet('year') ?: date('Y');
        $bulan = $this->request->getGet('bulan') ?: date('n');
        
        // Get data for selected year and month, grouped by type
        $prokonsData = $this->prokonsModel
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('tipe', 'ASC')
            ->findAll();

        // Debug: Log the retrieved data
        log_message('debug', 'Prokons data retrieved: ' . json_encode($prokonsData));
        log_message('debug', 'Year: ' . $tahun . ', Month: ' . $bulan);

        // Group data by type
        $groupedData = [];
        foreach ($prokonsData as $item) {
            if (!isset($groupedData[$item->tipe])) {
                $groupedData[$item->tipe] = [];
            }
            $groupedData[$item->tipe][] = $item;
        }
        
        // Debug: Log the grouped data
        log_message('debug', 'Grouped data: ' . json_encode($groupedData));

        // Define jenis bantuan types
        $jenisTypes = [
            'hibah' => 'Monitoring',
        ];

        // Get categories based on tipe values (0=hibah, 1=bansos, 2=barang)
        $categories = [
            [
                'key' => 'hibah',
                'nama' => 'Monitoring Progres Konsultasi',
                'data' => $groupedData[0] ?? []
            ],
        ];

        return $this->view('admin-lte-3/prokons/index', [
            'title' => 'Progres Konsultasi',
            'categories' => $categories,
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
    }

    /**
     * Upload data file
     */
    public function uploadData()
    {
        if (!$this->validate([
            'jenis_bantuan' => 'required|in_list[hibah,bansos,barang]',
            'file' => 'uploaded[file]|max_size[file,10240]|ext_in[file,pdf,doc,docx,xlsx,xls]'
        ])) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        $jenisBantuan = $this->request->getPost('jenis_bantuan');
        $tahun = $this->request->getPost('tahun') ?: date('Y');
        $bulan = $this->request->getPost('bulan') ?: date('n');
        $file = $this->request->getFile('file');

        if (!$file->isValid()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'File tidak valid'
            ]);
        }

        // Map jenis bantuan to tipe values
        $tipeMap = [
            'hibah' => 0,
            'bansos' => 1,
            'barang' => 2
        ];
        $tipeValue = $tipeMap[$jenisBantuan] ?? 0;

        // Check if data already exists for this type
        $existingData = $this->prokonsModel
            ->where('tipe', $tipeValue)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if ($existingData) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Data untuk jenis bantuan ini sudah ada pada bulan tersebut'
            ]);
        }

        // Generate unique filename
        $filename = $tahun . '_' . $jenisBantuan . '_' . time() . '.' . $file->getExtension();
        $uploadPath = 'file/prokons/' . $tahun;
        
        // Create directory if not exists
        if (!is_dir(WRITEPATH . '../public/file/' . $uploadPath)) {
            mkdir(WRITEPATH . '../public/file/' . $uploadPath, 0755, true);
        }

        if (!$file->move(WRITEPATH . '../public/file/' . $uploadPath, $filename)) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupload file'
            ]);
        }

        // Save to database
        $data = [
            'tahun' => $tahun,
            'bulan' => $bulan,
            'nama_hibah' => ucfirst($jenisBantuan),
            'deskripsi' => 'Upload data ' . ucfirst($jenisBantuan),
            'nilai_hibah' => 0,
            'status' => 'Belum Diperiksa',
            'tipe' => $tipeValue,
            'file_path' => $uploadPath . '/' . $filename,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => session()->get('user_id') ?? 0,
            'uploaded_at' => date('Y-m-d H:i:s')
        ];

        $insertId = $this->prokonsModel->insert($data);
        if ($insertId) {
            // Debug: Log the inserted data
            log_message('debug', 'Prokons data inserted with ID: ' . $insertId);
            log_message('debug', 'Inserted data: ' . json_encode($data));
            
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'filename' => $file->getClientName(),
                'insert_id' => $insertId
            ]);
        }

        return $this->response->setJSON([
            'ok' => false,
            'message' => 'Gagal menyimpan data'
        ]);
    }

    /**
     * Save administrative document link
     */
    public function saveDocLink()
    {
        // Debug: Log the received data
        log_message('debug', 'saveDocLink POST data: ' . json_encode($this->request->getPost()));
        
        if (!$this->validate([
            'jenis_bantuan' => 'required|in_list[hibah,bansos,barang]',
            'doc_link' => 'required|valid_url'
        ])) {
            $errors = $this->validator->getErrors();
            log_message('debug', 'saveDocLink validation errors: ' . json_encode($errors));
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed: ' . implode(', ', $errors)
            ]);
        }

        $jenisBantuan = $this->request->getPost('jenis_bantuan');
        $tahun = $this->request->getPost('tahun') ?: date('Y');
        $bulan = $this->request->getPost('bulan') ?: date('n');
        $docLink = $this->request->getPost('doc_link');
        
        log_message('debug', 'saveDocLink params: jenis=' . $jenisBantuan . ', tahun=' . $tahun . ', bulan=' . $bulan . ', link=' . $docLink);

        // Map jenis bantuan to tipe values
        $tipeMap = [
            'hibah' => 0,
            'bansos' => 1,
            'barang' => 2
        ];
        $tipeValue = $tipeMap[$jenisBantuan] ?? 0;

        // Find existing data
        $existingData = $this->prokonsModel
            ->where('tipe', $tipeValue)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        $recordId = null;
        if (!$existingData) {
            // Create new record if doesn't exist
            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'nama_hibah' => ucfirst($jenisBantuan),
                'deskripsi' => 'Dokumen administrasi ' . ucfirst($jenisBantuan),
                'nilai_hibah' => 0,
                'status' => 'Belum Diperiksa',
                'tipe' => $tipeValue,
                'uploaded_by' => session()->get('user_id') ?? 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $insertId = $this->prokonsModel->insert($data);
            if (!$insertId) {
                log_message('debug', 'saveDocLink failed to create new record');
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'Gagal membuat record baru'
                ]);
            }
            $recordId = $insertId;
        } else {
            $recordId = $existingData->id;
        }

        // Update with document link
        $updateData = [
            'file_path_dok' => $docLink,
            'file_name_dok' => $docLink,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        log_message('debug', 'saveDocLink updating record ID: ' . $recordId . ' with data: ' . json_encode($updateData));
        
        if ($this->prokonsModel->update($recordId, $updateData)) {
            log_message('debug', 'saveDocLink update successful');
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Link dokumen berhasil disimpan'
            ]);
        }

        log_message('debug', 'saveDocLink update failed');
        return $this->response->setJSON([
            'ok' => false,
            'message' => 'Gagal menyimpan link dokumen'
        ]);
    }

    /**
     * View uploaded file (for preview or download)
     */
    public function viewFile($id)
    {
        $data = $this->prokonsModel->find($id);
        if (!$data || !$data->file_path) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = WRITEPATH . '../public/file/' . $data->file_path;
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        // Get file extension to determine content type
        $extension = strtolower(pathinfo($data->file_name, PATHINFO_EXTENSION));
        
        // Set appropriate content type for preview
        $contentType = 'application/octet-stream';
        $disposition = 'attachment'; // Default to download
        
        switch ($extension) {
            case 'pdf':
                $contentType = 'application/pdf';
                $disposition = 'inline'; // Allow preview
                break;
            case 'jpg':
            case 'jpeg':
                $contentType = 'image/jpeg';
                $disposition = 'inline';
                break;
            case 'png':
                $contentType = 'image/png';
                $disposition = 'inline';
                break;
            case 'gif':
                $contentType = 'image/gif';
                $disposition = 'inline';
                break;
            case 'txt':
                $contentType = 'text/plain';
                $disposition = 'inline';
                break;
            case 'html':
            case 'htm':
                $contentType = 'text/html';
                $disposition = 'inline';
                break;
        }

        // Check if it's a preview request (from iframe)
        $isPreview = $this->request->getGet('preview') === '1';
        
        if ($isPreview && in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'html', 'htm'])) {
            $disposition = 'inline';
        }

        header('Content-Description: File Transfer');
        header('Content-Type: ' . $contentType);
        header('Content-Disposition: ' . $disposition . '; filename="' . $data->file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Delete prokons data
     */
    public function delete($id)
    {
        $data = $this->prokonsModel->find($id);
        if (!$data) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        // Delete file if exists
        if ($data->file_path) {
            $filePath = WRITEPATH . '../public/file/' . $data->file_path;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($this->prokonsModel->delete($id)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }

        return $this->response->setJSON([
            'ok' => false,
            'message' => 'Gagal menghapus data'
        ]);
    }

    /**
     * Get updated data for AJAX refresh
     */
    public function getData()
    {
        $tahun = $this->request->getGet('year') ?: date('Y');
        $bulan = $this->request->getGet('bulan') ?: date('n');
        
        // Get data for selected year and month, grouped by type
        $prokonsData = $this->prokonsModel
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('tipe', 'ASC')
            ->findAll();

        // Group data by type
        $groupedData = [];
        foreach ($prokonsData as $item) {
            if (!isset($groupedData[$item->tipe])) {
                $groupedData[$item->tipe] = [];
            }
            $groupedData[$item->tipe][] = $item;
        }

        // Define jenis bantuan types (0=hibah, 1=bansos, 2=barang)
        $categories = [
            [
                'key' => 'hibah',
                'nama' => 'Hibah',
                'data' => $groupedData[0] ?? []
            ],
            [
                'key' => 'bansos', 
                'nama' => 'Bantuan Sosial',
                'data' => $groupedData[1] ?? []
            ],
            [
                'key' => 'barang',
                'nama' => 'Barang yang diserahkan kepada masyarakat', 
                'data' => $groupedData[2] ?? []
            ]
        ];

        return $this->response->setJSON([
            'ok' => true,
            'categories' => $categories,
            'tahun' => $tahun,
            'bulan' => $bulan
        ]);
    }
}
