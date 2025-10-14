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
            'unitKerjaList' => $this->unitKerjaModel->getUnitKerjaForDisplay()
        ];

        return $this->view($this->theme->getThemePath() . '/unit-kerja/index', $data);
    }

    public function create()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'ok'      => false,
                'message' => 'Invalid request'
            ]);
        }

        $validation = \Config\Services::validation();
        $validation->setRules(
            [
                'nama_unit_kerja'    => 'required|max_length[255]',
                'alamat'             => 'permit_empty'
            ],
            [
                'nama_unit_kerja' => [
                    'required'   => 'Nama unit kerja harus diisi',
                    'max_length' => 'Nama unit kerja maksimal 255 karakter'
                ]
            ]
        );

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Validasi gagal',
                'errors'    => $validation->getErrors(),
                'csrf_token'=> csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            // Check if maximum limit of 9 items is reached
            $currentCount = $this->unitKerjaModel->countAll();
            if ($currentCount >= 10) {
                return $this->response->setJSON([
                    'ok'        => false,
                    'message'   => 'Maksimal 9 unit kerja yang dapat ditambahkan',
                    'csrf_token'=> csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }

            $nama_unit_kerja    = $this->request->getPost('nama_unit_kerja');
            $alamat             = $this->request->getPost('alamat') ?: '';

            // Generate kode_unit_kerja automatically
            $kode_unit_kerja = 'UK' . str_pad($currentCount + 1, 3, '0', STR_PAD_LEFT);

            $data = [
                'kode_unit_kerja'    => $kode_unit_kerja,
                'nama_unit_kerja'    => $nama_unit_kerja,
                'alamat'             => $alamat,
                'telepon'            => '',
                'email'              => '',
                'kepala_unit_kerja'  => '',
                'nip_kepala'         => '',
                'status'             => 'Aktif',
                'keterangan'         => ''
            ];

            $this->unitKerjaModel->insert($data);

            return $this->response->setJSON([
                'ok'        => true,
                'message'   => 'Unit kerja berhasil ditambahkan',
                'csrf_token'=> csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok'        => false,
                'message'   => 'Gagal menambahkan unit kerja: ' . $e->getMessage(),
                'csrf_token'=> csrf_token(),
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
            'nama_unit_kerja' => 'required|max_length[255]',
            'alamat' => 'permit_empty'
        ], [
            'nama_unit_kerja' => [
                'required' => 'Nama unit kerja harus diisi',
                'max_length' => 'Nama unit kerja maksimal 255 karakter'
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
                'nama_unit_kerja' => $this->request->getPost('nama_unit_kerja'),
                'alamat' => $this->request->getPost('alamat') ?: ''
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