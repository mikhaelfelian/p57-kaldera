<?php

namespace App\Controllers;

use App\Models\GenderModel;

class Gender extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new GenderModel();
        helper(['form']);
    }

    public function index()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));

        $items = $this->model->orderBy('id', 'DESC')->findAll();

        $data = [
            'title'       => 'Gender - Input',
            'Pengaturan'  => $this->pengaturan,
            'user'        => $this->ionAuth->user()->row(),
            'items'       => $items,
            'year'        => $year,
        ];

        return view($this->theme->getThemePath() . '/gender/index', $data);
    }

    public function store()
    {
        $year   = (int)($this->request->getPost('year') ?: date('Y'));
        $month  = (string)($this->request->getPost('month') ?: date('m'));
        $uraian = trim((string)$this->request->getPost('uraian'));

        if ($uraian === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['ok' => false, 'message' => 'Uraian dan bulan wajib diisi']);
            }
            return redirect()->back()->with('error', 'Uraian dan bulan wajib diisi');
        }

        // Insert first to get ID
        $id = $this->model->insert([
            'year'   => $year,
            'month'  => $month,
            'uraian' => $uraian,
        ], true);

        // Handle upload (pdf/excel)
        $file = $this->request->getFile('fupload');
        if ($file && $file->isValid()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['pdf', 'xls', 'xlsx', 'csv'];
            if (!in_array($ext, $allowed)) {
                $this->model->delete($id);
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['ok' => false, 'message' => 'File harus PDF atau Excel (xls/xlsx/csv)']);
                }
                return redirect()->back()->with('error', 'File harus PDF atau Excel (xls/xlsx/csv)');
            }

            $targetDir = FCPATH . '' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . $id;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $newName = 'gender_' . $id . '_' . time() . '.' . $ext;
            $file->move($targetDir, $newName, true);

            $relative = '/file/' . $id . '/' . $newName;
            $this->model->update($id, ['fupload' => $relative]);
        }

        if ($this->request->isAJAX()) {
            $row = $this->model->find($id);
            return $this->response->setJSON(['ok' => true, 'message' => 'Data tersimpan', 'data' => $row]);
        }

        return redirect()->to(base_url('gender'))->n            ->with('success', 'Data tersimpan');
    }

    public function preview($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['fupload'])) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $path = $row['fupload'];
        // Normalize path: ensure it is relative to FCPATH
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server');
        }
        return redirect()->to(base_url(ltrim($path, '/\\')));
    }

    public function download($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['fupload'])) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }
        $path = $row['fupload'];
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) {
            return redirect()->back()->with('error', 'File tidak ditemukan di server');
        }
        return $this->response->download($absolute, null);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $row = $this->model->find($id);
        if ($row) {
            // Remove file and directory
            if (!empty($row['fupload'])) {
                $path = str_starts_with($row['fupload'], FCPATH) ? $row['fupload'] : FCPATH . ltrim($row['fupload'], '/\\');
                if (is_file($path)) {
                    @unlink($path);
                }
                // Attempt to remove folder if empty
                $dir = dirname($path);
                if (is_dir($dir)) {
                    @rmdir($dir);
                }
            }
            $this->model->delete($id);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => true]);
        }
        return redirect()->to(base_url('gender'))->n            ->with('success', 'Data dihapus');
    }
}


