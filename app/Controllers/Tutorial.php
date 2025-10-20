<?php

namespace App\Controllers;

use App\Models\TutorialModel;

class Tutorial extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TutorialModel();
        helper(['form']);
    }

    public function index()
    {
        return redirect()->to(base_url('tutorial/pdf'));
    }

    public function pdf()
    {
        $hasLimit = $this->model->where('type', 'pdf')->countAllResults() >= 1;
        $tutorials = $this->model->where('type', 'pdf')->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'title'      => 'Tutorial PDF',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'tutorials'  => $tutorials,
            'type'       => 'pdf',
            'model'      => $this->model,
            'hasLimit'   => $hasLimit,
        ];
        return view($this->theme->getThemePath() . '/tutorial/pdf', $data);
    }

    public function video()
    {
        $hasLimit = $this->model->where('type', 'video')->countAllResults() >= 1;
        $tutorials = $this->model->where('type', 'video')->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'title'      => 'Tutorial Video',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'tutorials'  => $tutorials,
            'type'       => 'video',
            'model'      => $this->model,
            'hasLimit'   => $hasLimit,
        ];
        return view($this->theme->getThemePath() . '/tutorial/video', $data);
    }

    public function store()
    {
        try {
            log_message('info', 'Tutorial store method called');
            
            $title = trim((string)$this->request->getPost('title'));
            $description = trim((string)$this->request->getPost('description'));
            $type = trim((string)$this->request->getPost('type'));
            $linkUrl = trim((string)$this->request->getPost('link_url'));
            
            log_message('info', 'Title: ' . $title . ', Type: ' . $type);

        // Enforce single-row limit per type
        $existingCount = $this->model->where('type', $type)->countAllResults();
        if ($existingCount >= 1) {
            $msg = 'Hanya boleh 1 data untuk tipe ' . $type;
            return $this->request->isAJAX()
                ? $this->response->setJSON(['ok' => false, 'message' => $msg])
                : redirect()->to(base_url('tutorial/' . $type))->with('error', $msg);
        }

        if ($title === '' || $type === '') {
            $msg = 'Judul dan tipe tutorial wajib diisi';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }
        
        // either uploading files or using linkUrl (for video only)
        $uploadedFiles = [];
        try {
            $uploadedFiles = $this->request->getFileMultiple('files');
            if (empty($uploadedFiles)) {
                $singleFile = $this->request->getFile('files');
                if ($singleFile && $singleFile->isValid()) {
                    $uploadedFiles = [$singleFile];
                }
            }
        } catch (\Exception $e) {
            // No files uploaded, that's ok
            $uploadedFiles = [];
        }

        if ($type === 'video' && $linkUrl !== '' && empty($uploadedFiles)) {
            // store as link-only record
            $this->model->insert([
                'title'       => $title,
                'description' => $description,
                'type'        => 'video',
                'link_url'    => $linkUrl,
                'file_name'   => null,
                'file_path'   => null,
                'file_size'   => 0,
                'status'      => '1',
                'created_by'  => $this->ionAuth->user()->row()->id,
            ]);

            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true, 'count' => 1]) : redirect()->to(base_url('tutorial/video'))->with('success', 'Link video berhasil ditambahkan');
        }

        if (empty($uploadedFiles)) {
            $msg = 'Pilih file untuk diupload atau masukkan link YouTube (khusus video)';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

        // Validate and save each file; single request creates multiple rows
        $allowedTypes = $type === 'pdf' ? ['application/pdf'] : ['video/mp4', 'video/avi', 'video/mov', 'video/wmv'];

        // Create upload directory if not exists
        $uploadPath = WRITEPATH . 'uploads/tutorials/' . $type . '/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $savedCount = 0;
        foreach ($uploadedFiles as $file) {
            if (!$file->isValid()) { continue; }
            if (!in_array($file->getMimeType(), $allowedTypes)) { continue; }

            $fileName = $file->getRandomName();
            $file->move($uploadPath, $fileName);

            $this->model->insert([
                'title'       => $title,
                'description' => $description,
                'type'        => $type,
                'file_name'   => $fileName,
                'file_path'   => $uploadPath . $fileName,
                'file_size'   => $file->getSize(),
                'status'      => '1',
                'created_by'  => $this->ionAuth->user()->row()->id,
            ]);
            $savedCount++;
        }

        if ($savedCount === 0) {
            $msg = 'Tidak ada file yang valid untuk diupload';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true, 'count' => $savedCount]) : redirect()->to(base_url('tutorial/' . $type))->with('success', 'Berhasil mengupload ' . $savedCount . ' file');
        } catch (\Exception $e) {
            log_message('error', 'Tutorial store error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->request->isAJAX() 
                ? $this->response->setJSON(['ok' => false, 'message' => 'Error: ' . $e->getMessage()]) 
                : redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function download($id)
    {
        $tutorial = $this->model->find($id);
        if (!$tutorial) {
            return redirect()->back()->with('error', 'Tutorial tidak ditemukan');
        }

        // If it's a link-based tutorial, redirect to the link
        if (!empty($tutorial->link_url)) {
            return redirect()->to($tutorial->link_url);
        }

        if (empty($tutorial->file_path) || !file_exists($tutorial->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        return $this->response->download($tutorial->file_path, null);
    }

    public function preview($id)
    {
        $tutorial = $this->model->find($id);
        if (!$tutorial) {
            return redirect()->back()->with('error', 'Tutorial tidak ditemukan');
        }

        // Allow preview for link-based tutorials too
        if (empty($tutorial->link_url) && (empty($tutorial->file_path) || !file_exists($tutorial->file_path))) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $data = [
            'title'     => 'Preview Tutorial',
            'tutorial'  => $tutorial,
            'Pengaturan' => $this->pengaturan,
            'user'      => $this->ionAuth->user()->row(),
        ];

        return view($this->theme->getThemePath() . '/tutorial/preview', $data);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $tutorial = $this->model->find($id);
        
        if ($tutorial && !empty($tutorial->file_path) && file_exists($tutorial->file_path)) {
            unlink($tutorial->file_path);
        }
        
        $this->model->delete($id);
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->back()->with('success', 'Tutorial dihapus');
    }
}
