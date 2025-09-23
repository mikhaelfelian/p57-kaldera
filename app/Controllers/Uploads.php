<?php

namespace App\Controllers;

use App\Models\UploadModel;

class Uploads extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UploadModel();
        helper(['form']);
    }

    public function index()
    {
        $items = $this->model->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'title'      => 'Upload Laporan',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'items'      => $items,
        ];
        return view($this->theme->getThemePath() . '/uploads/index', $data);
    }

    public function store()
    {
        $name = trim((string)$this->request->getPost('name'));
        $keterangan = trim((string)$this->request->getPost('keterangan'));
        $user = $this->ionAuth->user()->row();
        $idUser = (int)($user->id ?? 0);

        if ($name === '') {
            $msg = 'Nama laporan wajib diisi';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

        $id = $this->model->insert([
            'id_user'    => $idUser,
            'name'       => $name,
            'keterangan' => $keterangan,
        ], true);

        $file = $this->request->getFile('file');
        if ($file && $file->isValid()) {
            $ext = strtolower($file->getExtension());
            $allowed = ['pdf', 'xls', 'xlsx', 'csv', 'doc', 'docx', 'png', 'jpg', 'jpeg'];
            if (!in_array($ext, $allowed)) {
                $this->model->delete($id);
                $msg = 'Tipe file tidak diizinkan';
                return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
            }

            $targetDir = FCPATH . 'file' . DIRECTORY_SEPARATOR . 'laporan' . DIRECTORY_SEPARATOR . $id . DIRECTORY_SEPARATOR . 'file';
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
            $newName = 'laporan_' . $id . '_' . time() . '.' . $ext;
            $file->move($targetDir, $newName, true);
            $relative = 'file/laporan/' . $id . '/file/' . $newName;
            $this->model->update($id, ['file' => $relative]);
        }

        if ($this->request->isAJAX()) {
            $row = $this->model->find($id);
            return $this->response->setJSON(['ok' => true, 'message' => 'Data tersimpan', 'data' => $row]);
        }
        return redirect()->to(base_url('uploads'))->with('success', 'Data tersimpan');
    }

    public function preview($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['file'])) return redirect()->back()->with('error', 'File tidak ditemukan');
        $path = $row['file'];
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) return redirect()->back()->with('error', 'File tidak ditemukan di server');
        return redirect()->to(base_url(ltrim($path, '/\\')));
    }

    public function download($id)
    {
        $row = $this->model->find((int)$id);
        if (!$row || empty($row['file'])) return redirect()->back()->with('error', 'File tidak ditemukan');
        $path = $row['file'];
        $absolute = str_starts_with($path, FCPATH) ? $path : FCPATH . ltrim($path, '/\\');
        if (!is_file($absolute)) return redirect()->back()->with('error', 'File tidak ditemukan di server');
        return $this->response->download($absolute, null);
    }

    public function delete($id)
    {
        $id = (int)$id;
        $row = $this->model->find($id);
        if ($row) {
            if (!empty($row['file'])) {
                $path = str_starts_with($row['file'], FCPATH) ? $row['file'] : FCPATH . ltrim($row['file'], '/\\');
                if (is_file($path)) @unlink($path);
                $dir = dirname($path);
                if (is_dir($dir)) @rmdir($dir);
                $parent = dirname($dir);
                if (is_dir($parent)) @rmdir($parent);
            }
            $this->model->delete($id);
        }
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('uploads'))->with('success', 'Data dihapus');
    }
}


