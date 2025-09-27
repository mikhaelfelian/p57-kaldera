<?php

namespace App\Controllers;

use App\Models\PendapatanModel;
use App\Models\PengaturanModel;

class Pendapatan extends BaseController
{
    protected $pendapatanModel;
    protected $pengaturanModel;
    protected $pengaturan;

    public function __construct()
    {
        parent::__construct();
        $this->pendapatanModel = new PendapatanModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->pengaturan = $this->pengaturanModel->getSettings();
    }

    /**
     * Pendapatan Master Data page
     */
    public function master()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');

        // Get existing data
        $existingData = $this->pendapatanModel->getByTahunTahapan($year, $tahapan);

        $data = [
            'title' => 'Pendapatan - Master Data',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'year' => $year,
            'tahapan' => $tahapan,
            'existingData' => $existingData,
        ];

        return view('admin-lte-3/pendapatan/master', $data);
    }

    /**
     * Get existing data for AJAX
     */
    public function pendapatanMasterGet()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');

        $data = $this->pendapatanModel->getByTahunTahapan($year, $tahapan);

        return $this->response->setJSON([
            'ok' => true,
            'data' => $data,
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash(),
        ]);
    }

    /**
     * Update pendapatan data
     */
    public function pendapatanMasterUpdate()
    {
        try {
            $year = (int)$this->request->getPost('tahun');
            $tahapan = (string)$this->request->getPost('tahapan');
            $field = (string)$this->request->getPost('field');
            $value = (float)$this->request->getPost('value');

            // Get existing data
            $existingData = $this->pendapatanModel->getByTahunTahapan($year, $tahapan);
            
            // Prepare update data
            $updateData = [];
            if ($existingData) {
                $updateData = $existingData;
            }
            $updateData[$field] = $value;

            // Calculate total
            $updateData['total'] = $this->pendapatanModel->calculateTotal($updateData);

            // Upsert data
            $this->pendapatanModel->upsert($year, $tahapan, $updateData);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil disimpan',
                'total' => $updateData['total'],
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'PendapatanMasterUpdate Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok' => false,
                'message' => $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }
    }
}
