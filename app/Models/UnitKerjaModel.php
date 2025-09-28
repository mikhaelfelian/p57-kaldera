<?php

namespace App\Models;

use CodeIgniter\Model;

class UnitKerjaModel extends Model
{
    protected $table = 'tbl_m_unit_kerja';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_unit_kerja',
        'nama_unit_kerja',
        'alamat',
        'telepon',
        'email',
        'kepala_unit_kerja',
        'nip_kepala',
        'status',
        'keterangan'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kode_unit_kerja' => 'required|max_length[50]|is_unique[tbl_m_unit_kerja.kode_unit_kerja,id,{id}]',
        'nama_unit_kerja' => 'required|max_length[255]',
        'alamat' => 'permit_empty',
        'telepon' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'kepala_unit_kerja' => 'permit_empty|max_length[255]',
        'nip_kepala' => 'permit_empty|max_length[50]',
        'status' => 'permit_empty|in_list[Aktif,Tidak Aktif]',
        'keterangan' => 'permit_empty'
    ];

    protected $validationMessages = [
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
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $deletedField = 'deleted_at';

    public function getUnitKerja($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }
        return $this->find($id);
    }

    public function getActiveUnitKerja()
    {
        return $this->where('status', 'Aktif')->findAll();
    }

    public function searchUnitKerja($keyword)
    {
        return $this->groupStart()
            ->like('nama_unit_kerja', $keyword)
            ->orLike('kode_unit_kerja', $keyword)
            ->orLike('kepala_unit_kerja', $keyword)
            ->groupEnd()
            ->findAll();
    }
}