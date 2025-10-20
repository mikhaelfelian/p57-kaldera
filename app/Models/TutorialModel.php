<?php

namespace App\Models;

use CodeIgniter\Model;

class TutorialModel extends Model
{
    protected $table = 'tutorials';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'description',
        'type',
        'file_name',
        'file_path',
        'link_url',
        'file_size',
        'status',
        'created_by',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'type' => 'required|in_list[pdf,video]',
        // file fields may be empty when using link_url for videos
        'status' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'Judul tutorial wajib diisi',
            'min_length' => 'Judul minimal 3 karakter',
            'max_length' => 'Judul maksimal 255 karakter'
        ],
        'type' => [
            'required' => 'Tipe tutorial wajib diisi',
            'in_list' => 'Tipe tutorial harus PDF atau Video'
        ],
        'file_name' => [
            'required' => 'Nama file wajib diisi'
        ],
        'file_path' => [
            'required' => 'Path file wajib diisi'
        ],
        'status' => [
            'required' => 'Status wajib diisi',
            'in_list' => 'Status harus 0 atau 1'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Get tutorials by type
     */
    public function getByType($type)
    {
        return $this->where('type', $type)
                   ->where('status', '1')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Get active tutorials
     */
    public function getActive()
    {
        return $this->where('status', '1')
                   ->orderBy('created_at', 'DESC')
                   ->findAll();
    }

    /**
     * Format file size for display
     */
    public function formatFileSize($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }
}
