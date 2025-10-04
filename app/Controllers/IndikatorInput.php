<?php

namespace App\Controllers;

use App\Models\IndikatorInputModel;
use CodeIgniter\HTTP\ResponseInterface;

class IndikatorInput extends BaseController
{
    protected $indikatorInputModel;

    public function __construct()
    {
        $this->indikatorInputModel = new IndikatorInputModel();
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
            'file_catatan_path' => 'public/file/indikator/input/' . $fileName,
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

        // CSRF protection is handled by the framework automatically
        // The CSRF token name is: ' . config('Security')->tokenName

        $tahun = (int)$this->request->getPost('tahun');
        $triwulan = (int)$this->request->getPost('triwulan');
        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $rencanaTindakLanjut = $this->request->getPost('rencana_tindak_lanjut');

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
            'rencana_tindak_lanjut' => $rencanaTindakLanjut,
            'file_rencana_path' => 'public/file/indikator/input/' . $fileName,
            'file_rencana_name' => $file->getClientName(),
            'file_rencana_size' => $file->getSize(),
            'uploaded_by' => session('user_id') ?? 1,
            'uploaded_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            if ($existing) {
                $this->indikatorInputModel->update($existing['id'], $data);
            } else {
                $data['tahun'] = $tahun;
                $data['triwulan'] = $triwulan;
                $data['jenis_indikator'] = $jenisIndikator;
                $data['created_at'] = date('Y-m-d H:i:s');
                $this->indikatorInputModel->insert($data);
            }
            
            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'File rencana tindak lanjut berhasil diupload',
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

    public function downloadCatatan($id)
    {
        $data = $this->indikatorInputModel->find($id);
        
        if (!$data || !$data['file_catatan_path']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $filePath = FCPATH . $data['file_catatan_path'];
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
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
}
