<?php

namespace App\Models;

use CodeIgniter\Model;

class UkpModel extends Model
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
        'status' => 'required|in_list[Aktif,Tidak Aktif]',
        'keterangan' => 'permit_empty'
    ];

    protected $validationMessages = [
        'kode_unit_kerja' => [
            'required' => 'Kode Unit Kerja harus diisi',
            'max_length' => 'Kode Unit Kerja maksimal 50 karakter',
            'is_unique' => 'Kode Unit Kerja sudah digunakan'
        ],
        'nama_unit_kerja' => [
            'required' => 'Nama Unit Kerja harus diisi',
            'max_length' => 'Nama Unit Kerja maksimal 255 karakter'
        ],
        'telepon' => [
            'max_length' => 'Telepon maksimal 20 karakter'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'max_length' => 'Email maksimal 100 karakter'
        ],
        'kepala_unit_kerja' => [
            'max_length' => 'Nama Kepala Unit Kerja maksimal 255 karakter'
        ],
        'nip_kepala' => [
            'max_length' => 'NIP Kepala maksimal 50 karakter'
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status harus Aktif atau Tidak Aktif'
        ]
    ];

    public function getUkpList($search = '', $limit = 10, $offset = 0)
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kode_unit_kerja', $search)
                ->orLike('nama_unit_kerja', $search)
                ->orLike('kepala_unit_kerja', $search)
                ->groupEnd();
        }
        
        return $builder->orderBy('nama_unit_kerja', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    public function getUkpCount($search = '')
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kode_unit_kerja', $search)
                ->orLike('nama_unit_kerja', $search)
                ->orLike('kepala_unit_kerja', $search)
                ->groupEnd();
        }
        
        return $builder->countAllResults();
    }
}