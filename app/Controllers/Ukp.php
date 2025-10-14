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
        $search = $this->request->getGet('search') ?? '';
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $data = [
            'title' => 'Master Unit Kerja Pemerintah (UKP)',
            'search' => $search,
            'ukpList' => $this->ukpModel->getUkpList($search, $limit, $offset),
            'totalRecords' => $this->ukpModel->getUkpCount($search),
            'currentPage' => $page,
            'limit' => $limit,
            'totalPages' => ceil($this->ukpModel->getUkpCount($search) / $limit)
        ];

        return $this->view($this->theme->getThemePath() . '/ukp/master', $data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $rules = [
            'kode_unit_kerja' => 'required|max_length[50]|is_unique[tbl_m_unit_kerja.kode_unit_kerja]',
            'nama_unit_kerja' => 'required|max_length[255]',
            'alamat' => 'permit_empty',
            'telepon' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'kepala_unit_kerja' => 'permit_empty|max_length[255]',
            'nip_kepala' => 'permit_empty|max_length[50]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]',
            'keterangan' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_unit_kerja' => $this->request->getPost('kode_unit_kerja'),
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'kepala_unit_kerja' => $this->request->getPost('kepala_unit_kerja'),
            'nip_kepala' => $this->request->getPost('nip_kepala'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->ukpModel->insert($data)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data UKP berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan data UKP',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function update($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $rules = [
            'kode_unit_kerja' => "required|max_length[50]|is_unique[tbl_m_unit_kerja.kode_unit_kerja,id,{$id}]",
            'nama_unit_kerja' => 'required|max_length[255]',
            'alamat' => 'permit_empty',
            'telepon' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'kepala_unit_kerja' => 'permit_empty|max_length[255]',
            'nip_kepala' => 'permit_empty|max_length[50]',
            'status' => 'required|in_list[Aktif,Tidak Aktif]',
            'keterangan' => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validation failed',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $data = [
            'kode_unit_kerja' => $this->request->getPost('kode_unit_kerja'),
            'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'email' => $this->request->getPost('email'),
            'kepala_unit_kerja' => $this->request->getPost('kepala_unit_kerja'),
            'nip_kepala' => $this->request->getPost('nip_kepala'),
            'status' => $this->request->getPost('status'),
            'keterangan' => $this->request->getPost('keterangan')
        ];

        if ($this->ukpModel->update($id, $data)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data UKP berhasil diupdate',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupdate data UKP',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function delete($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        if ($this->ukpModel->delete($id)) {
            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data UKP berhasil dihapus',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menghapus data UKP',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function get($id)
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $ukp = $this->ukpModel->find($id);
        
        if ($ukp) {
            return $this->response->setJSON([
                'ok' => true,
                'data' => $ukp,
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } else {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Data UKP tidak ditemukan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
}