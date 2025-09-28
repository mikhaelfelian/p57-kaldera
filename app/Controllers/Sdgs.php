<?php

namespace App\Controllers;

use App\Models\SdgsModel;

class Sdgs extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SdgsModel();
        helper(['form', 'tanggalan']);
    }

    public function index()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $items = $this->model->orderBy('id', 'DESC')->findAll();
        $data = [
            'title'      => 'SDG’s - Input',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'items'      => $items,
            'year'       => $year,
        ];
        return view($this->theme->getThemePath() . '/sdgs/index', $data);
    }

    public function store()
    {
        $year   = (int)($this->request->getPost('year') ?: date('Y'));
        $month  = (string)($this->request->getPost('month') ?: date('m'));
        $uraian = trim((string)$this->request->getPost('uraian'));

        if ($uraian === '' || !preg_match('/^(0[1-9]|1[0-2])$/', $month)) {
            $msg = 'Uraian dan bulan wajib diisi';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

        $id = $this->model->insert([
            'year'   => $year,
            'month'  => $month,
            'uraian' => $uraian,
        ], true);

        $file = $this->request->getFile('fupload');
        if ($file && $file->isValid()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['pdf', 'xls', 'xlsx', 'csv'];
            if (!in_array($ext, $allowed)) {
                $this->model->delete($id);
                $msg = 'File harus PDF atau Excel (xls/xlsx/csv)';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

            $targetDir = FCPATH . '' . DIRECTORY_SEPARATOR . 'file' . DIRECTORY_SEPARATOR . 'sdgs' . DIRECTORY_SEPARATOR . $id;
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $newName = 'sdgs_' . $id . '_' . time() . '.' . $ext;
            $file->move($targetDir, $newName, true);
            $relative = '/file/sdgs/' . $id . '/' . $newName;
            $this->model->update($id, ['fupload' => $relative]);
        }

        if ($this->request->isAJAX()) {
            $row = $this->model->find($id);
            return $this->response->setJSON(['ok' => true, 'message' => 'Data tersimpan', 'data' => $row]);
        }
        return redirect()->to(base_url('sdgs'))->with('success', 'Data tersimpan');
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
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('sdgs'))->with('success', 'Data dihapus');
    }
}


