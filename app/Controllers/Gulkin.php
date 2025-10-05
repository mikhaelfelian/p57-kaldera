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
        $items = $this->model->orderBy('id', 'DESC')->findAll();
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
}


