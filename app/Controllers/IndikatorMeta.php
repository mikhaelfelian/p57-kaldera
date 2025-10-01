<?php

namespace App\Controllers;

use App\Models\IndikatorMetaModel;
use CodeIgniter\HTTP\ResponseInterface;

class IndikatorMeta extends BaseController
{
    protected $indikatorMetaModel;

    public function __construct()
    {
        $this->indikatorMetaModel = new IndikatorMetaModel();
        helper(['form']);
    }

    public function metadata()
    {
        $data = [
            'title' => 'Metadata Indikator',
            'indikatorList' => $this->getIndikatorList(),
            'existingData' => $this->getExistingData()
        ];

        return $this->view($this->theme->getThemePath() . '/indikator/metadata', $data);
    }

    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $jenisIndikator = $this->request->getPost('jenis_indikator');
        $namaIndikator = $this->request->getPost('nama_indikator');
        $formulasi = $this->request->getPost('formulasi');
        $definisiOperasional = $this->request->getPost('definisi_operasional');

        if (!$jenisIndikator || !$namaIndikator) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Jenis dan nama indikator harus diisi']);
        }

        $file = $this->request->getFile('file');
        
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'File tidak valid']);
        }

        // Create upload directory if not exists
        $uploadPath = FCPATH . '/file/indikator/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate unique filename
        $fileName = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        $data = [
            'jenis_indikator' => $jenisIndikator,
            'nama_indikator' => $namaIndikator,
            'deskripsi' => $formulasi . "\n\nDefinisi Operasional:\n" . $definisiOperasional,
            'file_path' => '/file/indikator/' . $fileName,
            'file_name' => $file->getClientName(),
            'file_size' => $file->getSize(),
            'uploaded_by' => session('user_id') ?? 1,
            'uploaded_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        try {
            $this->indikatorMetaModel->insert($data);
            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'File berhasil diupload',
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

    public function viewData($id)
    {
        $data = $this->indikatorMetaModel->find($id);
        
        if (!$data) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => $data,
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function download($id)
    {
        $data = $this->indikatorMetaModel->find($id);
        
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $filePath = FCPATH . $data['file_path'];
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        return $this->response->download($filePath, null);
    }

    public function preview($id)
    {
        $data = $this->indikatorMetaModel->find($id);
        
        if (!$data) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        $filePath = FCPATH . $data['file_path'];
        
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }

        // Get file extension to determine content type
        $extension = pathinfo($data['file_name'], PATHINFO_EXTENSION);
        $contentType = $this->getContentType($extension);

        // Set appropriate headers
        $this->response->setHeader('Content-Type', $contentType);
        $this->response->setHeader('Content-Disposition', 'inline; filename="' . $data['file_name'] . '"');
        
        // Output file content
        return $this->response->setBody(file_get_contents($filePath));
    }

    private function getContentType($extension)
    {
        $contentTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'txt' => 'text/plain',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'html' => 'text/html',
            'xml' => 'application/xml',
        ];

        return $contentTypes[strtolower($extension)] ?? 'application/octet-stream';
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

    private function getExistingData()
    {
        $data = $this->indikatorMetaModel->findAll();
        $result = [];
        
        foreach ($data as $row) {
            $result[$row['jenis_indikator']] = $row;
        }
        
        return $result;
    }
}