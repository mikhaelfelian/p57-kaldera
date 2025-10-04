<?php

namespace App\Controllers;

use App\Models\BanmasModel;

class Banmas extends BaseController
{
    protected $banmasModel;

    public function __construct()
    {
        parent::__construct();
        $this->banmasModel = new BanmasModel();
        helper(['form']);
    }

    /**
     * Index page - main banmas management page
     */
    public function index()
    {
        // Get year and month from URL parameters or use current date
        $tahun = $this->request->getGet('year') ?: date('Y');
        $bulan = $this->request->getGet('bulan') ?: date('n');
        
        // Get data for selected year and month, grouped by type
        $banmasData = $this->banmasModel
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->orderBy('tipe', 'ASC')
            ->findAll();

        // Group data by type
        $groupedData = [];
        foreach ($banmasData as $item) {
            $groupedData[$item->tipe][] = $item;
        }

        // Define jenis bantuan types
        $jenisTypes = [
            'hibah' => 'Hibah',
            'bansos' => 'Bantuan Sosial', 
            'barang' => 'Barang yang diserahkan kepada masyarakat'
        ];

        // Get categories based on image
        $categories = [
            [
                'key' => 'hibah',
                'nama' => 'Hibah',
                'data' => $groupedData['hibah'] ?? []
            ],
            [
                'key' => 'bansos', 
                'nama' => 'Bantuan Sosial',
                'data' => $groupedData['bansos'] ?? []
            ],
            [
                'key' => 'barang',
                'nama' => 'Barang yang diserahkan kepada masyarakat', 
                'data' => $groupedData['barang'] ?? []
            ]
        ];

        return $this->view('admin-lte-3/banmas/index', [
            'title' => 'Manajemen Bantuan Masyarakat',
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

        // Check if data already exists for this type
        $existingData = $this->banmasModel
            ->where('tipe', $jenisBantuan)
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
        $uploadPath = 'banmas/' . $tahun;
        
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
            'tipe' => $jenisBantuan,
            'file_path' => $uploadPath . '/' . $filename,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => session()->get('user_id') ?? 0,
            'uploaded_at' => date('Y-m-d H:i:s')
        ];

        if ($this->banmasModel->insert($data)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'filename' => $file->getClientName()
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
        if (!$this->validate([
            'jenis_bantuan' => 'required|in_list[hibah,bansos,barang]',
            'doc_link' => 'required|valid_url'
        ])) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed: ' . implode(', ', $this->validator->getErrors())
            ]);
        }

        $jenisBantuan = $this->request->getPost('jenis_bantuan');
        $tahun = $this->request->getPost('tahun') ?: date('Y');
        $bulan = $this->request->getPost('bulan') ?: date('n');
        $docLink = $this->request->getPost('doc_link');

        // Find existing data
        $existingData = $this->banmasModel
            ->where('tipe', $jenisBantuan)
            ->where('tahun', $tahun)
            ->where('bulan', $bulan)
            ->first();

        if (!$existingData) {
            // Create new record if doesn't exist
            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'nama_hibah' => ucfirst($jenisBantuan),
                'deskripsi' => 'Dokumen administrasi ' . ucfirst($jenisBantuan),
                'nilai_hibah' => 0,
                'status' => 'Belum Diperiksa',
                'tipe' => $jenisBantuan,
                'uploaded_by' => session()->get('user_id') ?? 0,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $existingData = $this->banmasModel->insert($data);
        }

        // Update with document link
        $updateData = [
            'file_path_dok' => $docLink,
            'file_name_dok' => $docLink,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->banmasModel->update($existingData['id'] ?? $existingData, $updateData)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Link dokumen berhasil disimpan'
            ]);
        }

        return $this->response->setJSON([
            'ok' => false,
            'message' => 'Gagal menyimpan link dokumen'
        ]);
    }

    /**
     * View uploaded file
     */
    public function viewFile($id)
    {
        $data = $this->banmasModel->find($id);
        if (!$data || !$data->file_path) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = WRITEPATH . '../public/file/' . $data->file_path;
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $data->file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }

    /**
     * Delete banmas data
     */
    public function delete($id)
    {
        $data = $this->banmasModel->find($id);
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

        if ($this->banmasModel->delete($id)) {
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
}
