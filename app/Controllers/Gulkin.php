<?php

namespace App\Controllers;

use App\Models\GulkinModel;

class Gulkin extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new GulkinModel();
        helper(['form', 'tanggalan']);
    }

    public function index()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $items = $this->model
            ->where('year', $year)
            ->orderBy('month', 'ASC')
            ->findAll();
        $data = [
            'title'      => 'Gulkin - Input',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'items'      => $items,
            'year'       => $year,
        ];
        return view($this->theme->getThemePath() . '/gulkin/index', $data);
    }

    public function store()
    {
        try {
            $year   = (int)($this->request->getPost('year') ?: date('Y'));
            $month  = (string)($this->request->getPost('month') ?: date('m'));
            $uraian = trim((string)$this->request->getPost('uraian'));

            // Convert month to 2-digit format (01-12) for database validation
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);

            if ($uraian === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
                $msg = 'Uraian dan bulan wajib diisi dan bulan hanya boleh 1 sampai 12';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

            $data = [
                'year'   => $year,
                'month'  => $month,
                'uraian' => $uraian,
            ];

            // Debug: Log the data being inserted
            log_message('debug', 'Gulkin insert data: ' . json_encode($data));
            
            // Test database connection
            if (!$this->model->db->tableExists('tbl_gulkin')) {
                $msg = 'Database table tbl_gulkin tidak ditemukan';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

            // Try direct database insert to bypass model validation
            $db = \Config\Database::connect();
            $builder = $db->table('tbl_gulkin');
            $result = $builder->insert($data);
            
            if (!$result) {
                $msg = 'Gagal menyimpan data ke database (direct insert failed)';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }
            
            $id = $db->insertID();

            if (!$id) {
                $errors = $this->model->errors();
                log_message('error', 'Gulkin insert failed. Errors: ' . json_encode($errors));
                $msg = 'Gagal menyimpan data ke database. Errors: ' . implode(', ', $errors);
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

        $file = $this->request->getFile('fupload');
        if ($file && $file->isValid()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['pdf', 'xls', 'xlsx', 'csv'];
            if (!in_array($ext, $allowed)) {
                $this->model->delete($id);
                $msg = 'File harus PDF atau Excel (xls/xlsx/csv)';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

            $targetDir = FCPATH . 'file' . DIRECTORY_SEPARATOR . 'gulkin' . DIRECTORY_SEPARATOR . $id;
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $newName = 'gulkin_' . $id . '_' . time() . '.' . $ext;
            $file->move($targetDir, $newName, true);
            $relative = '/file/gulkin/' . $id . '/' . $newName;
            $this->model->update($id, ['fupload' => $relative]);
        }

            if ($this->request->isAJAX()) {
                $row = $this->model->find($id);
                return $this->response->setJSON(['ok' => true, 'message' => 'Data tersimpan', 'data' => $row]);
            }
            return redirect()->to(base_url('gulkin'))->with('success', 'Data tersimpan');
            
        } catch (\Exception $e) {
            log_message('error', 'Gulkin store error: ' . $e->getMessage());
            $msg = 'Terjadi kesalahan: ' . $e->getMessage();
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }
    }

    public function preview($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['fupload'])) return redirect()->back()->with('error', 'File tidak ditemukan');
        $path = $row['fupload'];
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) return redirect()->back()->with('error', 'File tidak ditemukan di server');
        return redirect()->to(base_url(ltrim($path, '/\\')));
    }

    public function download($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['fupload'])) return redirect()->back()->with('error', 'File tidak ditemukan');
        $path = $row['fupload'];
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) return redirect()->back()->with('error', 'File tidak ditemukan di server');
        return $this->response->download($absolute, null);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $row = $this->model->find($id);
        if ($row) {
            if (!empty($row['fupload'])) {
                $path = str_starts_with($row['fupload'], FCPATH) ? $row['fupload'] : FCPATH . ltrim($row['fupload'], '/\\');
                if (is_file($path)) @unlink($path);
                $dir = dirname($path);
                if (is_dir($dir)) @rmdir($dir);
            }
            $this->model->delete($id);
        }
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('gulkin'))->with('success', 'Data dihapus');
    }

    /**
     * Check if file exists for a gulkin record
     */
    public function checkFile($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $row = $this->model->find((int)$id);
        if (!$row) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        if (!empty($row['fupload'])) {
            $fileName = basename($row['fupload']);
            return $this->response->setJSON([
                'ok' => true,
                'file_name' => $fileName,
                'file_path' => $row['fupload']
            ]);
        }

        return $this->response->setJSON([
            'ok' => true,
            'file_name' => null
        ]);
    }

    /**
     * Upload file for gulkin record
     */
    public function uploadFile()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        try {
            $gulkinId = (int)$this->request->getPost('gulkin_id');
            if (!$gulkinId) {
                return $this->response->setJSON(['ok' => false, 'message' => 'ID Gulkin tidak valid']);
            }

            // Check if gulkin record exists
            $gulkin = $this->model->find($gulkinId);
            if (!$gulkin) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Data Gulkin tidak ditemukan']);
            }

            $file = $this->request->getFile('file');
            if (!$file || !$file->isValid()) {
                return $this->response->setJSON(['ok' => false, 'message' => 'File tidak valid']);
            }

            $ext = strtolower($file->getExtension());
            $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];
            if (!in_array($ext, $allowed)) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Format file tidak diperbolehkan']);
            }

            // Check file size (10MB max)
            if ($file->getSize() > 10 * 1024 * 1024) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Ukuran file terlalu besar (maksimal 10MB)']);
            }

            // Create target directory
            $targetDir = FCPATH . 'file' . DIRECTORY_SEPARATOR . 'gulkin' . DIRECTORY_SEPARATOR . $gulkinId;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            // Delete old file if exists
            if (!empty($gulkin['fupload'])) {
                $oldFile = FCPATH . ltrim($gulkin['fupload'], '/');
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            // Generate new filename
            $newName = 'gulkin_' . $gulkinId . '_' . time() . '.' . $ext;
            $file->move($targetDir, $newName, true);
            
            // Update database
            $relativePath = '/file/gulkin/' . $gulkinId . '/' . $newName;
            $this->model->update($gulkinId, ['fupload' => $relativePath]);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'File berhasil diupload',
                'file_name' => $newName,
                'file_path' => $relativePath,
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Gulkin upload file error: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
}


