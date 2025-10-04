<?php

namespace App\Models;

use CodeIgniter\Model;

class BanmasModel extends Model
{
    protected $table            = 'tbl_banmas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    // Timestamps
    protected $useTimestamps = true;            // uses created_at & updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Mass assignment
    protected $allowedFields = [
        'tahun',
        'bulan',
        'nama_hibah',
        'deskripsi',
        'nilai_hibah',
        'status',
        'tipe',
        'file_path',
        'file_path_dok',
        'file_name',
        'file_name_dok',
        'file_size',
        'uploaded_by',
        'uploaded_at',
        // created_at & updated_at otomatis oleh CI4
    ];

    // Validation
    protected $validationRules = [];

    protected $validationMessages = [];
    protected $skipValidation     = false;

    // ------ Convenience query helpers ------
    /**
     * Get records by year and (optional) month.
     *
     * @param int $tahun
     * @param int|null $bulan
     * @return array
     */
    public function getByPeriode(int $tahun, ?int $bulan = null): array
    {
        $builder = $this->where('tahun', $tahun);
        if ($bulan !== null) {
            $builder = $builder->where('bulan', $bulan);
        }
        return $builder->orderBy('tahun', 'DESC')
                       ->orderBy('bulan', 'DESC')
                       ->findAll();
    }

    /**
     * Update status with whitelist values.
     *
     * @param int $id
     * @param string $status One of: Sesuai, Tidak Sesuai, Belum Diperiksa
     * @return bool
     */
    public function setStatus(int $id, string $status): bool
    {
        $allowed = ['Sesuai', 'Tidak Sesuai', 'Belum Diperiksa'];
        if (! in_array($status, $allowed, true)) {
            return false;
        }
        return (bool) $this->update($id, ['status' => $status]);
    }

    /**
     * Save upload metadata for a record.
     *
     * @param int $id
     * @param array $meta Keys can include: file_path, file_path_dok, file_name, file_name_dok, file_size, uploaded_by, uploaded_at
     * @return bool
     */
    public function saveUploadMeta(int $id, array $meta): bool
    {
        $fields = array_intersect_key($meta, array_flip([
            'file_path','file_path_dok','file_name','file_name_dok','file_size','uploaded_by','uploaded_at'
        ]));
        if (empty($fields)) {
            return false;
        }
        return (bool) $this->update($id, $fields);
    }
}
