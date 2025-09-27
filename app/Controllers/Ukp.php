<?php

namespace App\Controllers;

use App\Models\UkpModel;

class Ukp extends BaseController
{
    protected $ukpModel;

    public function __construct()
    {
        $this->ukpModel = new UkpModel();
        helper(['form']);
    }

    public function master()
    {
        $data = [
            'title' => 'Master Unit Kerja (UKP)',
            'ukpList' => $this->ukpModel->orderBy('nama_ukp', 'ASC')->findAll()
        ];

        return $this->view($this->theme->getThemePath() . '/ukp/master', $data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $rules = [
            'kode_ukp' => 'required|max_length[50]|is_unique[tbl_m_ukp.kode_ukp]',
            'nama_ukp' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_ukp' => $this->request->getPost('kode_ukp'),
            'nama_ukp' => $this->request->getPost('nama_ukp'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];

        try {
            $this->ukpModel->insert($data);
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ]);
        }
    }

    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $ukp = $this->ukpModel->find($id);
        if (!$ukp) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        $rules = [
            'kode_ukp' => "required|max_length[50]|is_unique[tbl_m_ukp.kode_ukp,id,{$id}]",
            'nama_ukp' => 'required|max_length[255]',
            'deskripsi' => 'permit_empty',
            'status' => 'required|in_list[aktif,tidak_aktif]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_ukp' => $this->request->getPost('kode_ukp'),
            'nama_ukp' => $this->request->getPost('nama_ukp'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'status' => $this->request->getPost('status')
        ];

        try {
            $this->ukpModel->update($id, $data);
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil diupdate',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ]);
        }
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $ukp = $this->ukpModel->find($id);
        if (!$ukp) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        try {
            $this->ukpModel->delete($id);
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil dihapus',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ]);
        }
    }

    public function get($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $ukp = $this->ukpModel->find($id);
        if (!$ukp) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Data tidak ditemukan']);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => $ukp,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }
}
