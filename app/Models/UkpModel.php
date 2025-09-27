<?php

namespace App\Models;

use CodeIgniter\Model;

class UkpModel extends Model
{
    protected $table = 'tbl_m_ukp';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'kode_ukp',
        'nama_ukp',
        'alamat',
        'telepon',
        'email',
        'website',
        'kepala_ukp',
        'nip_kepala',
        'status',
        'keterangan'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kode_ukp' => 'required|max_length[50]|is_unique[tbl_m_ukp.kode_ukp,id,{id}]',
        'nama_ukp' => 'required|max_length[255]',
        'alamat' => 'permit_empty',
        'telepon' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[100]',
        'website' => 'permit_empty|valid_url|max_length[255]',
        'kepala_ukp' => 'permit_empty|max_length[255]',
        'nip_kepala' => 'permit_empty|max_length[50]',
        'status' => 'required|in_list[Aktif,Tidak Aktif]',
        'keterangan' => 'permit_empty'
    ];

    protected $validationMessages = [
        'kode_ukp' => [
            'required' => 'Kode UKP harus diisi',
            'max_length' => 'Kode UKP maksimal 50 karakter',
            'is_unique' => 'Kode UKP sudah digunakan'
        ],
        'nama_ukp' => [
            'required' => 'Nama UKP harus diisi',
            'max_length' => 'Nama UKP maksimal 255 karakter'
        ],
        'telepon' => [
            'max_length' => 'Telepon maksimal 20 karakter'
        ],
        'email' => [
            'valid_email' => 'Format email tidak valid',
            'max_length' => 'Email maksimal 100 karakter'
        ],
        'website' => [
            'valid_url' => 'Format website tidak valid',
            'max_length' => 'Website maksimal 255 karakter'
        ],
        'kepala_ukp' => [
            'max_length' => 'Nama Kepala UKP maksimal 255 karakter'
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
                ->like('kode_ukp', $search)
                ->orLike('nama_ukp', $search)
                ->orLike('kepala_ukp', $search)
                ->groupEnd();
        }
        
        return $builder->orderBy('nama_ukp', 'ASC')
            ->limit($limit, $offset)
            ->get()
            ->getResult();
    }

    public function getUkpCount($search = '')
    {
        $builder = $this->builder();
        
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kode_ukp', $search)
                ->orLike('nama_ukp', $search)
                ->orLike('kepala_ukp', $search)
                ->groupEnd();
        }
        
        return $builder->countAllResults();
    }
}