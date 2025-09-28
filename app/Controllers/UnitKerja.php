<?php

namespace App\Controllers;

use App\Models\UnitKerjaModel;

class UnitKerja extends BaseController
{
    protected $unitKerjaModel;

    public function __construct()
    {
        $this->unitKerjaModel = new UnitKerjaModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $data = [
            'title' => 'Master Unit Kerja',
            'unitKerjaList' => $this->unitKerjaModel->findAll()
        ];

        return $this->view($this->theme->getThemePath() . '/unit-kerja/index', $data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'kode_unit_kerja' => 'required|max_length[50]|is_unique[tbl_m_unit_kerja.kode_unit_kerja]',
            'nama_unit_kerja' => 'required|max_length[255]',
            'alamat' => 'permit_empty',
            'telepon' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'kepala_unit_kerja' => 'permit_empty|max_length[255]',
            'nip_kepala' => 'permit_empty|max_length[50]',
            'status' => 'permit_empty|in_list[Aktif,Tidak Aktif]',
            'keterangan' => 'permit_empty'
        ], [
            'kode_unit_kerja' => [
                'required' => 'Kode unit kerja harus diisi',
                'max_length' => 'Kode unit kerja maksimal 50 karakter',
                'is_unique' => 'Kode unit kerja sudah digunakan'
            ],
            'nama_unit_kerja' => [
                'required' => 'Nama unit kerja harus diisi',
                'max_length' => 'Nama unit kerja maksimal 255 karakter'
            ],
            'telepon' => [
                'max_length' => 'Nomor telepon maksimal 20 karakter'
            ],
            'email' => [
                'valid_email' => 'Format email tidak valid',
                'max_length' => 'Email maksimal 100 karakter'
            ],
            'kepala_unit_kerja' => [
                'max_length' => 'Nama kepala unit kerja maksimal 255 karakter'
            ],
            'nip_kepala' => [
                'max_length' => 'NIP kepala maksimal 50 karakter'
            ],
            'status' => [
                'in_list' => 'Status harus Aktif atau Tidak Aktif'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            $data = [
                'kode_unit_kerja' => $this->request->getPost('kode_unit_kerja'),
                'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
                'alamat' => $this->request->getPost('alamat') ?: '',
                'telepon' => $this->request->getPost('telepon') ?: '',
                'email' => $this->request->getPost('email') ?: '',
                'kepala_unit_kerja' => $this->request->getPost('kepala_unit_kerja') ?: '',
                'nip_kepala' => $this->request->getPost('nip_kepala') ?: '',
                'status' => $this->request->getPost('status') ?: 'Aktif',
                'keterangan' => $this->request->getPost('keterangan') ?: ''
            ];

            $this->unitKerjaModel->insert($data);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Unit kerja berhasil ditambahkan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menambahkan unit kerja: ' . $e->getMessage(),
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

        $unitKerja = $this->unitKerjaModel->find($id);
        if (!$unitKerja) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Unit kerja tidak ditemukan']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'kode_unit_kerja' => "required|max_length[50]|is_unique[tbl_m_unit_kerja.kode_unit_kerja,id,{$id}]",
            'nama_unit_kerja' => 'required|max_length[255]',
            'alamat' => 'permit_empty',
            'telepon' => 'permit_empty|max_length[20]',
            'email' => 'permit_empty|valid_email|max_length[100]',
            'kepala_unit_kerja' => 'permit_empty|max_length[255]',
            'nip_kepala' => 'permit_empty|max_length[50]',
            'status' => 'permit_empty|in_list[Aktif,Tidak Aktif]',
            'keterangan' => 'permit_empty'
        ], [
            'kode_unit_kerja' => [
                'required' => 'Kode unit kerja harus diisi',
                'max_length' => 'Kode unit kerja maksimal 50 karakter',
                'is_unique' => 'Kode unit kerja sudah digunakan'
            ],
            'nama_unit_kerja' => [
                'required' => 'Nama unit kerja harus diisi',
                'max_length' => 'Nama unit kerja maksimal 255 karakter'
            ],
            'telepon' => [
                'max_length' => 'Nomor telepon maksimal 20 karakter'
            ],
            'email' => [
                'valid_email' => 'Format email tidak valid',
                'max_length' => 'Email maksimal 100 karakter'
            ],
            'kepala_unit_kerja' => [
                'max_length' => 'Nama kepala unit kerja maksimal 255 karakter'
            ],
            'nip_kepala' => [
                'max_length' => 'NIP kepala maksimal 50 karakter'
            ],
            'status' => [
                'in_list' => 'Status harus Aktif atau Tidak Aktif'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            $data = [
                'kode_unit_kerja' => $this->request->getPost('kode_unit_kerja'),
                'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
                'alamat' => $this->request->getPost('alamat') ?: '',
                'telepon' => $this->request->getPost('telepon') ?: '',
                'email' => $this->request->getPost('email') ?: '',
                'kepala_unit_kerja' => $this->request->getPost('kepala_unit_kerja') ?: '',
                'nip_kepala' => $this->request->getPost('nip_kepala') ?: '',
                'status' => $this->request->getPost('status') ?: 'Aktif',
                'keterangan' => $this->request->getPost('keterangan') ?: ''
            ];

            $this->unitKerjaModel->update($id, $data);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Unit kerja berhasil diperbarui',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal memperbarui unit kerja: ' . $e->getMessage(),
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

        $unitKerja = $this->unitKerjaModel->find($id);
        if (!$unitKerja) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Unit kerja tidak ditemukan']);
        }

        try {
            $this->unitKerjaModel->delete($id);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Unit kerja berhasil dihapus',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menghapus unit kerja: ' . $e->getMessage(),
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

        $unitKerja = $this->unitKerjaModel->find($id);
        if (!$unitKerja) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Unit kerja tidak ditemukan']);
        }

        return $this->response->setJSON([
            'ok' => true,
            'data' => $unitKerja,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }

    public function search()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $keyword = $this->request->getPost('keyword');
        $results = $this->unitKerjaModel->searchUnitKerja($keyword);

        return $this->response->setJSON([
            'ok' => true,
            'data' => $results,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash()
        ]);
    }
}