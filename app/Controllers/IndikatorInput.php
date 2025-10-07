<?php

namespace App\Controllers;

use App\Models\IndikatorInputModel;
use App\Models\IndikatorVerifModel;
use CodeIgniter\HTTP\ResponseInterface;

class IndikatorInput extends BaseController
{
    protected $indikatorInputModel;
    protected $indikatorVerifModel;

    public function __construct()
    {
        $this->indikatorInputModel = new IndikatorInputModel();
        $this->indikatorVerifModel = new IndikatorVerifModel();
        helper(['form']);
    }

    public function input()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $triwulan = (int)($this->request->getGet('triwulan') ?: 1);
        
        $data = [
            'title' => 'Input Indikator',
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'indikatorList' => $this->getIndikatorList(),
            'existingData' => $this->getExistingData($tahun, $triwulan)
        ];

        return $this->view($this->theme->getThemePath() . '/indikator/input', $data);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        // CSRF protection is handled by the framework automatically
        // The CSRF token name is: ' . config('Security')->tokenName

        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');

        if (!$tahun || !$triwulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan triwulan harus diisi']);
        }

        try {
            // This method can be used to save filter state or perform other general save operations
            // For now, just return success since the actual data saving is handled by upload methods
            
            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data berhasil disimpan',
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

    public function uploadCatatan()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        // CSRF protection is handled by the framework automatically
        // The CSRF token name is: ' . config('Security')->tokenName

        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');
        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $catatanIndikator = $this->request->getPost('catatan_indikator');

        if (!$tahun || !$triwulan || !$jenisIndikator) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun, triwulan dan jenis indikator harus diisi']);
        }

        $file = $this->request->getFile('file');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'File tidak valid']);
        }

        // Create upload directory if not exists
        $uploadPath = FCPATH . 'file/indikator/input/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $fileName = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        // Check if record exists
        $existing = $this->indikatorInputModel->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator
        ])->first();

        $data = [
            'catatan_indikator' => $catatanIndikator,
            // Store path relative to public root
            'file_catatan_path' => 'file/indikator/input/' . $fileName,
            'file_catatan_name' => $file->getClientName(),
            'file_catatan_size' => $file->getSize(),
            'uploaded_by' => session('user_id') ?? 1,
            'uploaded_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $recordId = null;
            if ($existing) {
                $this->indikatorInputModel->update($existing['id'], $data);
                $recordId = $existing['id'];
            } else {
                $data['tahun'] = $tahun;
                $data['triwulan'] = $triwulan;
                $data['jenis_indikator'] = $jenisIndikator;
                $data['created_at'] = date('Y-m-d H:i:s');
                $recordId = $this->indikatorInputModel->insert($data);
            }
            
            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'File catatan berhasil diupload',
                'filename' => $file->getClientName(),
                'id' => $recordId,
                'jenis_indikator' => $jenisIndikator,
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

    public function uploadRencana()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');
        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $verifikatorDataJson = $this->request->getPost('verifikator_data');

        if (!$tahun || !$triwulan || !$jenisIndikator) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Tahun, triwulan dan jenis indikator harus diisi',
                'csrf_hash' => csrf_hash()
            ]);
        }

        if (!$verifikatorDataJson) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Data verifikator harus diisi',
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            // Parse verifikator data
            $verifikatorData = json_decode($verifikatorDataJson, true);
            
            if (!is_array($verifikatorData) || empty($verifikatorData)) {
                return $this->response->setJSON([
                    'ok' => false, 
                    'message' => 'Data verifikator tidak valid',
                    'csrf_hash' => csrf_hash()
                ]);
            }

            // Get or create indikator_input record
            $indikatorInput = $this->indikatorInputModel->where([
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'jenis_indikator' => $jenisIndikator
            ])->first();

            $indikatorInputId = null;
            if ($indikatorInput) {
                $indikatorInputId = $indikatorInput['id'];
            } else {
                // Create new indikator input record if doesn't exist
                $newInputData = [
                    'tahun' => $tahun,
                    'triwulan' => $triwulan,
                    'jenis_indikator' => $jenisIndikator,
                    'uploaded_by' => session('user_id') ?? 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $indikatorInputId = $this->indikatorInputModel->insert($newInputData);
            }

            // Get existing verifikator records
            $existingVerifikators = $this->indikatorVerifModel->where([
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'jenis_indikator' => $jenisIndikator
            ])->findAll();

            // Create map of existing verifikator names
            $existingNames = [];
            foreach ($existingVerifikators as $existing) {
                $existingNames[] = strtolower(trim($existing['nama_verifikator']));
            }

            // Insert only NEW verifikator records (don't delete existing ones)
            $insertCount = 0;
            foreach ($verifikatorData as $verifikator) {
                if (isset($verifikator['nama']) && !empty(trim($verifikator['nama']))) {
                    $namaVerifikator = trim($verifikator['nama']);
                    
                    // Only insert if this verifikator doesn't exist yet
                    if (!in_array(strtolower($namaVerifikator), $existingNames)) {
                        $verifData = [
                            'indikator_input_id' => $indikatorInputId,
                            'tahun' => $tahun,
                            'triwulan' => $triwulan,
                            'jenis_indikator' => $jenisIndikator,
                            'nama_verifikator' => $namaVerifikator,
                            'hasil_verifikasi_status' => 'Belum',
                            'rencana_tindak_lanjut_status' => 'Belum',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ];
                        
                        if ($this->indikatorVerifModel->insert($verifData)) {
                            $insertCount++;
                        }
                    }
                }
            }

            // Return success regardless - if no new records, it means all already exist
            $message = $insertCount > 0 
                ? "Berhasil menyimpan {$insertCount} verifikator baru"
                : "Semua verifikator sudah tersimpan";
            
            return $this->response->setJSON([
                'ok' => true, 
                'message' => $message,
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function previewCatatan()
    {
        $tahun = (int)$this->request->getGet('tahun');
        $triwulan = (int)$this->request->getGet('triwulan');
        $jenis = $this->request->getGet('jenis');
        
        if (!$tahun || !$triwulan || !$jenis) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak lengkap');
        }

        $data = $this->indikatorInputModel->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenis
        ])->first();
        
        if (!$data || !$data['file_catatan_path']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $storedPath = $data['file_catatan_path'];
        // Backward compat: some rows stored with 'public/file/...'
        if (str_starts_with($storedPath, 'public/')) {
            $storedPath = substr($storedPath, 7);
        }
        $filePath = FCPATH . ltrim($storedPath, '/\\');
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        // Get file extension and MIME type
        $extension = strtolower(pathinfo($data['file_catatan_name'], PATHINFO_EXTENSION));
        $mimeType = $this->getMimeType($extension);

        // Set appropriate headers for preview
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $data['file_catatan_name'] . '"');
        $this->response->setHeader('Content-Length', filesize($filePath));
        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return $this->response->setBody(file_get_contents($filePath));
    }

    public function downloadCatatan()
    {
        $tahun = (int)$this->request->getGet('tahun');
        $triwulan = (int)$this->request->getGet('triwulan');
        $jenis = $this->request->getGet('jenis');
        
        if (!$tahun || !$triwulan || !$jenis) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak lengkap');
        }

        $data = $this->indikatorInputModel->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenis
        ])->first();
        
        if (!$data || !$data['file_catatan_path']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $storedPath = $data['file_catatan_path'];
        if (str_starts_with($storedPath, 'public/')) {
            $storedPath = substr($storedPath, 7);
        }
        $filePath = FCPATH . ltrim($storedPath, '/\\');
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        return $this->response->download($filePath, $data['file_catatan_name']);
    }

    public function downloadRencana($id)
    {
        $data = $this->indikatorInputModel->find($id);
        
        if (!$data || !$data['file_rencana_path']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $filePath = FCPATH . $data['file_rencana_path'];
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        return $this->response->download($filePath, $data['file_rencana_name']);
    }

    public function preview($id)
    {
        $data = $this->indikatorInputModel->find($id);
        
        if (!$data) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => $data,
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function updateVerifikasi()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');
        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $status = $this->request->getPost('status');

        if (!$tahun || !$triwulan || !$jenisIndikator || !$status) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Data tidak lengkap',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Validate status
        if (!in_array($status, ['Sesuai', 'Tidak Sesuai'])) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Status verifikasi tidak valid',
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            // Find existing record
            $existing = $this->indikatorInputModel->where([
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'jenis_indikator' => $jenisIndikator
            ])->first();

            if (!$existing) {
                return $this->response->setJSON([
                    'ok' => false, 
                    'message' => 'Data tidak ditemukan. Silakan upload file catatan terlebih dahulu.',
                    'csrf_hash' => csrf_hash()
                ]);
            }

            // Update verification status
            $updateData = [
                'status_verifikasi_bidang' => $status,
                'tanggal_verifikasi' => date('Y-m-d H:i:s'),
                'verifikasi_by' => session('user_id') ?? 1
            ];

            $this->indikatorInputModel->update($existing['id'], $updateData);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Status verifikasi berhasil diperbarui',
                'status' => $status,
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal memperbarui status verifikasi: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function getVerifikatorData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getGet('tahun');
        $triwulan = (int)$this->request->getGet('triwulan');
        $jenisIndikator = $this->request->getGet('jenis_indikator');

        if (!$tahun || !$triwulan || !$jenisIndikator) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Parameter tidak lengkap',
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            $verifikatorData = $this->indikatorVerifModel->getByPeriode($tahun, $triwulan, $jenisIndikator);
            
            return $this->response->setJSON([
                'ok' => true,
                'data' => $verifikatorData,
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal memuat data: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function uploadVerifikatorFile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $verifId = $this->request->getPost('verif_id');
        $type = $this->request->getPost('verif_type'); // 'hasil' or 'rencana'
        $tahun = (int)$this->request->getPost('verif_tahun');
        $triwulan = (int)$this->request->getPost('verif_triwulan');
        $jenisIndikator = $this->request->getPost('verif_jenis_indikator');
        $namaVerifikator = $this->request->getPost('verif_nama');

        // Debug: Log received data
        log_message('debug', 'Upload Verifikator File - Received data: ' . json_encode([
            'verif_id' => $verifId,
            'type' => $type,
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'jenis_indikator' => $jenisIndikator,
            'nama_verifikator' => $namaVerifikator
        ]));

        if (!$tahun || !$triwulan || !$jenisIndikator || !$namaVerifikator || !$type) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Data tidak lengkap. Tahun: ' . $tahun . ', Triwulan: ' . $triwulan . ', Jenis: ' . $jenisIndikator . ', Nama: ' . $namaVerifikator . ', Type: ' . $type,
                'csrf_hash' => csrf_hash()
            ]);
        }

        if (!in_array($type, ['hasil', 'rencana'])) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Tipe file tidak valid',
                'csrf_hash' => csrf_hash()
            ]);
        }

        $file = $this->request->getFile('file');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'File tidak valid',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Validate file size (max 10MB)
        if ($file->getSize() > 10485760) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Ukuran file maksimal 10MB',
                'csrf_hash' => csrf_hash()
            ]);
        }

        // Create upload directory
        $uploadPath = FCPATH . 'file/indikator/verifikator/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        try {
            // Generate unique filename
            $fileName = $file->getRandomName();
            $file->move($uploadPath, $fileName);

            // Check if verifikator record exists
            $existing = null;
            if ($verifId) {
                $existing = $this->indikatorVerifModel->find($verifId);
            } else {
                // Find by name and periode
                $existing = $this->indikatorVerifModel->where([
                    'tahun' => $tahun,
                    'triwulan' => $triwulan,
                    'jenis_indikator' => $jenisIndikator,
                    'nama_verifikator' => $namaVerifikator
                ])->first();
            }

            // Prepare data based on type
            $filePathColumn = $type === 'hasil' ? 'hasil_verifikasi_file' : 'rencana_tindak_lanjut_file';
            $fileNameColumn = $type === 'hasil' ? 'hasil_verifikasi_file_name' : 'rencana_tindak_lanjut_file_name';
            $statusColumn = $type === 'hasil' ? 'hasil_verifikasi_status' : 'rencana_tindak_lanjut_status';

            $data = [
                $filePathColumn => 'file/indikator/verifikator/' . $fileName,
                $fileNameColumn => $file->getClientName(),
                $statusColumn => 'Sudah',
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $savedVerifId = null;

            if ($existing) {
                // Update existing record
                $this->indikatorVerifModel->update($existing['id'], $data);
                $savedVerifId = $existing['id'];
            } else {
                // Create new record
                $data['tahun'] = $tahun;
                $data['triwulan'] = $triwulan;
                $data['jenis_indikator'] = $jenisIndikator;
                $data['nama_verifikator'] = $namaVerifikator;
                $data['created_at'] = date('Y-m-d H:i:s');
                
                // Set default for the other type
                if ($type === 'hasil') {
                    $data['rencana_tindak_lanjut_status'] = 'Belum';
                } else {
                    $data['hasil_verifikasi_status'] = 'Belum';
                }

                $savedVerifId = $this->indikatorVerifModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'file_name' => $file->getClientName(),
                'verif_id' => $savedVerifId,
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupload file: ' . $e->getMessage(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function previewVerifikatorFile($verifId, $type)
    {
        if (!$verifId || !$type || !in_array($type, ['hasil', 'rencana'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak valid');
        }

        $verifikator = $this->indikatorVerifModel->find($verifId);
        
        if (!$verifikator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data verifikator tidak ditemukan');
        }

        // Get file path based on type
        $filePathColumn = $type === 'hasil' ? 'hasil_verifikasi_file' : 'rencana_tindak_lanjut_file';
        $fileNameColumn = $type === 'hasil' ? 'hasil_verifikasi_file_name' : 'rencana_tindak_lanjut_file_name';
        
        $filePath = $verifikator[$filePathColumn];
        $fileName = $verifikator[$fileNameColumn];

        if (!$filePath || !$fileName) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $fullPath = FCPATH . $filePath;
        
        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        // Get MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $fullPath);
        finfo_close($finfo);

        // Set appropriate headers for preview
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $fileName . '"');
        $this->response->setHeader('Content-Length', filesize($fullPath));
        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return $this->response->setBody(file_get_contents($fullPath));
    }

    public function downloadVerifikatorFile($verifId, $type)
    {
        if (!$verifId || !$type || !in_array($type, ['hasil', 'rencana'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak valid');
        }

        $verifikator = $this->indikatorVerifModel->find($verifId);
        
        if (!$verifikator) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data verifikator tidak ditemukan');
        }

        // Get file path based on type
        $filePathColumn = $type === 'hasil' ? 'hasil_verifikasi_file' : 'rencana_tindak_lanjut_file';
        $fileNameColumn = $type === 'hasil' ? 'hasil_verifikasi_file_name' : 'rencana_tindak_lanjut_file_name';
        
        $filePath = $verifikator[$filePathColumn];
        $fileName = $verifikator[$fileNameColumn];

        if (!$filePath || !$fileName) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $fullPath = FCPATH . $filePath;
        
        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        return $this->response->download($fullPath, null)->setFileName($fileName);
    }

    private function getIndikatorList()
    {
        return [
            'tujuan' => 'Indikator Tujuan',
            'sasaran' => 'Indikator Sasaran', 
            'program' => 'Indikator Program',
            'kegiatan' => 'Indikator Kegiatan',
            'sub_kegiatan' => 'Indikator Sub Kegiatan'
        ];
    }

    public function rekap()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $triwulan = (int)($this->request->getGet('triwulan') ?: 1);
        
        $data = [
            'title' => 'Rekap Indikator',
            'tahun' => $tahun,
            'triwulan' => $triwulan,
            'indikatorList' => $this->getIndikatorList(),
            'existingData' => $this->getExistingData($tahun, $triwulan),
            'chartData' => $this->getChartData($tahun, $triwulan)
        ];

        return $this->view($this->theme->getThemePath() . '/indikator/rekap', $data);
    }

    private function getChartData($tahun, $triwulan)
    {
        $data = $this->indikatorInputModel->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan
        ])->findAll();
        
        $totalData = count($data);
        $completedData = 0;
        $hasFiles = 0;
        
        foreach ($data as $row) {
            if (!empty($row['catatan_indikator']) || !empty($row['rencana_tindak_lanjut'])) {
                $completedData++;
            }
            if (!empty($row['file_catatan_path']) || !empty($row['file_rencana_path'])) {
                $hasFiles++;
            }
        }
        
        return [
            'total' => $totalData,
            'completed' => $completedData,
            'files' => $hasFiles,
            'remaining' => $totalData - $completedData
        ];
    }

    private function getExistingData($tahun, $triwulan)
    {
        $data = $this->indikatorInputModel->where([
            'tahun' => $tahun,
            'triwulan' => $triwulan
        ])->findAll();
        
        $result = [];
        foreach ($data as $row) {
            $result[$row['jenis_indikator']] = $row;
        }
        
        return $result;
    }

    // ==================== MISSING METHODS FOR COMPLETE MENU ====================
    
    public function uploadHasilHtlFile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        try {
            $htlId = $this->request->getPost('htl_id');
            $tahun = $this->request->getPost('htl_tahun');
            $triwulan = $this->request->getPost('htl_triwulan');
            $jenisIndikator = $this->request->getPost('htl_jenis_indikator');
            $nama = $this->request->getPost('htl_nama');
            $file = $this->request->getFile('file');

            if (!$file || !$file->isValid()) {
                return $this->response->setJSON(['ok' => false, 'message' => 'File tidak valid']);
            }

            // Create upload directory
            $uploadDir = FCPATH . 'file/indikator/hasil-htl/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Generate unique filename
            $originalName = $file->getClientName();
            $extension = $file->getClientExtension();
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $originalName);
            $filePath = 'file/indikator/hasil-htl/' . $fileName;

            // Move file
            if (!$file->move($uploadDir, $fileName)) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Gagal mengupload file']);
            }

            // Save to database
            $data = [
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'jenis_indikator' => $jenisIndikator,
                'nama_verifikator' => $nama,
                // Align with existing verifikator schema so UI can read it
                'hasil_verifikasi_file' => $filePath,
                'hasil_verifikasi_file_name' => $originalName,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($htlId) {
                $data['id'] = $htlId;
            }

            $this->indikatorVerifModel->save($data);
            $newHtlId = $this->indikatorVerifModel->getInsertID();

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'file_name' => $originalName,
                'htl_id' => $newHtlId ?: $htlId,
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Upload hasil HTL file error: ' . $e->getMessage());
            return $this->response->setJSON(['ok' => false, 'message' => 'Gagal mengupload file: ' . $e->getMessage()]);
        }
    }

    public function previewHasilHtlFile($htlId)
    {
        if (!$htlId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak valid');
        }

        $htl = $this->indikatorVerifModel->find($htlId);
        
        if (!$htl) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        // Support both old and new columns
        $filePath = $htl['hasil_verifikasi_file'] ?? $htl['hasil_tindak_lanjut_file'] ?? null;
        $fileName = $htl['hasil_verifikasi_file_name'] ?? $htl['hasil_tindak_lanjut_file_name'] ?? null;

        if (!$filePath || !$fileName) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $fullPath = FCPATH . $filePath;
        
        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        // Get file extension and MIME type
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $mimeType = $this->getMimeType($extension);

        // Set appropriate headers for preview
        $this->response->setHeader('Content-Type', $mimeType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $fileName . '"');
        $this->response->setHeader('Content-Length', filesize($fullPath));
        $this->response->setHeader('Cache-Control', 'no-cache, no-store, must-revalidate');
        $this->response->setHeader('Pragma', 'no-cache');
        $this->response->setHeader('Expires', '0');

        return $this->response->setBody(file_get_contents($fullPath));
    }

    public function downloadHasilHtlFile($htlId)
    {
        if (!$htlId) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Parameter tidak valid');
        }

        $htl = $this->indikatorVerifModel->find($htlId);
        
        if (!$htl) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }

        // Support both old and new columns
        $filePath = $htl['hasil_verifikasi_file'] ?? $htl['hasil_tindak_lanjut_file'] ?? null;
        $fileName = $htl['hasil_verifikasi_file_name'] ?? $htl['hasil_tindak_lanjut_file_name'] ?? null;

        if (!$filePath || !$fileName) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $fullPath = FCPATH . $filePath;
        
        if (!file_exists($fullPath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan di server');
        }

        return $this->response->download($fullPath, null)->setFileName($fileName);
    }

    public function deleteVerifikator()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $verifId = (int)$this->request->getPost('verif_id');
        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');

        if (!$verifId || !$jenisIndikator || !$tahun || !$triwulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Parameter tidak lengkap']);
        }

        try {
            // Find the verifikator record
            $verif = $this->indikatorVerifModel->where([
                'id' => $verifId,
                'tahun' => $tahun,
                'triwulan' => $triwulan,
                'jenis_indikator' => $jenisIndikator
            ])->first();

            if (!$verif) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
            }

            // Delete associated files if they exist
            $filesToDelete = [];
            
            if (!empty($verif['hasil_verifikasi_file'])) {
                $filesToDelete[] = FCPATH . $verif['hasil_verifikasi_file'];
            }
            if (!empty($verif['rencana_tindak_lanjut_file'])) {
                $filesToDelete[] = FCPATH . $verif['rencana_tindak_lanjut_file'];
            }
            if (!empty($verif['hasil_tindak_lanjut_file'])) {
                $filesToDelete[] = FCPATH . $verif['hasil_tindak_lanjut_file'];
            }

            // Delete the record from database
            $deleted = $this->indikatorVerifModel->delete($verifId);

            if ($deleted) {
                // Delete physical files
                foreach ($filesToDelete as $filePath) {
                    if (file_exists($filePath)) {
                        @unlink($filePath);
                    }
                }

                return $this->response->setJSON([
                    'ok' => true, 
                    'message' => 'Data berhasil dihapus',
                    'csrf_hash' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON(['ok' => false, 'message' => 'Gagal menghapus data']);
            }

        } catch (\Exception $e) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    private function getMimeType($extension)
    {
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}
