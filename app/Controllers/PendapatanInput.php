<?php

namespace App\Controllers;

use App\Models\PendapatanInputModel;
use App\Models\PendapatanModel;
use App\Models\PengaturanModel;

class PendapatanInput extends BaseController
{
    protected $pendapatanInputModel;
    protected $pendapatanModel;
    protected $pengaturanModel;
    protected $pengaturan;

    public function __construct()
    {
        parent::__construct();
        $this->pendapatanInputModel = new PendapatanInputModel();
        $this->pendapatanModel = new PendapatanModel();
        $this->pengaturanModel = new PengaturanModel();
        $this->pengaturan = $this->pengaturanModel->getSettings();
    }

    /**
     * Pendapatan Input page
     */
    public function input()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        $bulan = (int)($this->request->getGet('bulan') ?: 9); // Default to September

        // Get master data for target values
        $masterData = $this->pendapatanModel->getByTahunTahapan($year, $tahapan);
        
        // Get existing input data
        $existingData = $this->pendapatanInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

        $data = [
            'title' => 'Pendapatan - Input',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'year' => $year,
            'tahapan' => $tahapan,
            'bulan' => $bulan,
            'existingData' => $existingData,
            'masterData' => $masterData,
        ];

        return view('admin-lte-3/pendapatan/input', $data);
    }

    /**
     * Save pendapatan input data
     */
    public function inputSave()
    {
        try {
            $tahun = (int)$this->request->getPost('tahun');
            $tahapan = (string)$this->request->getPost('tahapan');
            $bulan = (int)$this->request->getPost('bulan');
            
            // Get master data to get target values
            $masterData = $this->pendapatanModel->getByTahunTahapan($tahun, $tahapan);
            if (!$masterData) {
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'Master data tidak ditemukan. Silakan isi Master Data terlebih dahulu.',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash(),
                ]);
            }
            
            $inputData = [
                'tahun' => $tahun,
                'tahapan' => $tahapan,
                'bulan' => $bulan,
                'retribusi_penyewaan_target' => (float)$masterData['retribusi_penyewaan'],
                'retribusi_penyewaan_realisasi' => (float)$this->request->getPost('retribusi_penyewaan_realisasi'),
                'retribusi_laboratorium_target' => (float)$masterData['retribusi_laboratorium'],
                'retribusi_laboratorium_realisasi' => (float)$this->request->getPost('retribusi_laboratorium_realisasi'),
                'retribusi_alat_target' => (float)$masterData['retribusi_alat'],
                'retribusi_alat_realisasi' => (float)$this->request->getPost('retribusi_alat_realisasi'),
                'hasil_kerjasama_target' => (float)$masterData['hasil_kerjasama'],
                'hasil_kerjasama_realisasi' => (float)$this->request->getPost('hasil_kerjasama_realisasi'),
                'penerimaan_komisi_target' => (float)$masterData['penerimaan_komisi'],
                'penerimaan_komisi_realisasi' => (float)$this->request->getPost('penerimaan_komisi_realisasi'),
                'sewa_ruang_koperasi_target' => (float)$masterData['sewa_ruang_koperasi'],
                'sewa_ruang_koperasi_realisasi' => (float)$this->request->getPost('sewa_ruang_koperasi_realisasi'),
            ];

            // Calculate totals
            $totals = $this->pendapatanInputModel->calculateTotals($inputData);
            $inputData['total_target'] = $totals['total_target'];
            $inputData['total_realisasi'] = $totals['total_realisasi'];

            $this->pendapatanInputModel->upsert($tahun, $tahapan, $bulan, $inputData);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'PendapatanInputSave Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok' => false,
                'message' => $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }
    }

    /**
     * Pendapatan Rekap page (read-only with chart and export)
     */
    public function rekap()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        $bulan = (int)($this->request->getGet('bulan') ?: 1); // Default to January

        // Get data directly from tbl_pendapatan_input using tahun and bulan
        $existingData = $this->pendapatanInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

        // Prepare chart data
        $chartData = [];
        if ($existingData) {
            $totalTarget = (float)($existingData['total_target'] ?? 0);
            $totalRealisasi = (float)($existingData['total_realisasi'] ?? 0);
            $totalSisa = $totalTarget - $totalRealisasi;
            
            $chartData = [
                'realisasi' => $totalRealisasi,
                'sisa' => $totalSisa,
                'total' => $totalTarget
            ];
        }
        
        $data = [
            'title' => 'Pendapatan - Rekap',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'year' => $year,
            'tahapan' => $tahapan,
            'bulan' => $bulan,
            'existingData' => $existingData,
            'chartData' => $chartData,
        ];

        return view('admin-lte-3/pendapatan/rekap', $data);
    }

    /**
     * Export Pendapatan Rekap to Excel
     */
    public function rekapExportExcel()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        $bulan = (int)($this->request->getGet('bulan') ?: 1);

        // Get data directly from tbl_pendapatan_input using tahun and bulan
        $existingData = $this->pendapatanInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

        // Create Excel file using PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'REKAP PENDAPATAN - ' . bulan_ke_str($bulan) . ' ' . $year);
        $sheet->setCellValue('A2', 'Tahapan: ' . ucfirst($tahapan));
        
        // Table headers
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Uraian');
        $sheet->setCellValue('C4', 'Target Tahunan (Rp)');
        $sheet->setCellValue('D4', 'Realisasi (Rp)');
        $sheet->setCellValue('E4', '% Capaian');

        // Data rows
        $rows = [
            'retribusi_penyewaan' => 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
            'retribusi_laboratorium' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
            'retribusi_alat' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
            'hasil_kerjasama' => 'Hasil Kerja Sama Pemanfaatan BMD',
            'penerimaan_komisi' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
            'sewa_ruang_koperasi' => 'Sewa Ruang Koperasi'
        ];

        $row = 5;
        $totalTarget = 0;
        $totalRealisasi = 0;

        foreach ($rows as $key => $label) {
            $target = (float)($existingData[$key.'_target'] ?? 0);
            $realisasi = (float)($existingData[$key.'_realisasi'] ?? 0);
            $persen = $target > 0 ? ($realisasi / $target) * 100 : 0;

            $sheet->setCellValue('A' . $row, $row - 4);
            $sheet->setCellValue('B' . $row, $label);
            $sheet->setCellValue('C' . $row, $target);
            $sheet->setCellValue('D' . $row, $realisasi);
            $sheet->setCellValue('E' . $row, $persen);

            $totalTarget += $target;
            $totalRealisasi += $realisasi;
            $row++;
        }

        // Total row
        $totalPersen = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;

        $sheet->setCellValue('A' . $row, 'TOTAL');
        $sheet->setCellValue('B' . $row, 'TOTAL');
        $sheet->setCellValue('C' . $row, $totalTarget);
        $sheet->setCellValue('D' . $row, $totalRealisasi);
        $sheet->setCellValue('E' . $row, $totalPersen);

        // Set response headers
        $filename = 'Rekap_Pendapatan_' . bulan_ke_str($bulan) . '_' . $year . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export Pendapatan Rekap to PDF
     */
    public function rekapExportPDF()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        $bulan = (int)($this->request->getGet('bulan') ?: 1);

        // Get data directly from tbl_pendapatan_input using tahun and bulan
        $existingData = $this->pendapatanInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

        // Create PDF using TCPDF
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Pendapatan Rekap System');
        $pdf->SetTitle('Rekap Pendapatan - ' . bulan_ke_str($bulan) . ' ' . $year);
        $pdf->SetHeaderData('', 0, 'REKAP PENDAPATAN', 'Tahapan: ' . ucfirst($tahapan));
        $pdf->setHeaderFont(Array('helvetica', '', 12));
        $pdf->setFooterFont(Array('helvetica', '', 8));
        $pdf->SetMargins(15, 25, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);
        $pdf->AddPage();

        // Table data
        $rows = [
            'retribusi_penyewaan' => 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
            'retribusi_laboratorium' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
            'retribusi_alat' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
            'hasil_kerjasama' => 'Hasil Kerja Sama Pemanfaatan BMD',
            'penerimaan_komisi' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
            'sewa_ruang_koperasi' => 'Sewa Ruang Koperasi'
        ];

        $html = '<table border="1" cellpadding="5">
            <tr style="background-color:#3b6ea8; color:white; font-weight:bold;">
                <th width="5%">No</th>
                <th width="40%">Uraian</th>
                <th width="15%">Target Tahunan (Rp)</th>
                <th width="15%">Realisasi (Rp)</th>
                <th width="10%">% Capaian</th>
            </tr>';

        $totalTarget = 0;
        $totalRealisasi = 0;
        $rowNum = 1;

        foreach ($rows as $key => $label) {
            $target = (float)($existingData[$key.'_target'] ?? 0);
            $realisasi = (float)($existingData[$key.'_realisasi'] ?? 0);
            $persen = $target > 0 ? ($realisasi / $target) * 100 : 0;

            $html .= '<tr>
                <td align="center">' . $rowNum . '</td>
                <td>' . $label . '</td>
                <td align="right">' . number_format($target, 0, ',', '.') . '</td>
                <td align="right">' . number_format($realisasi, 0, ',', '.') . '</td>
                <td align="right">' . number_format($persen, 2) . '%</td>
            </tr>';

            $totalTarget += $target;
            $totalRealisasi += $realisasi;
            $rowNum++;
        }

        // Total row
        $totalPersen = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;

        $html .= '<tr style="background-color:#3b6ea8; color:white; font-weight:bold;">
            <td align="center">TOTAL</td>
            <td>TOTAL</td>
            <td align="right">' . number_format($totalTarget, 0, ',', '.') . '</td>
            <td align="right">' . number_format($totalRealisasi, 0, ',', '.') . '</td>
            <td align="right">' . number_format($totalPersen, 2) . '%</td>
        </tr></table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('Rekap_Pendapatan_' . bulan_ke_str($bulan) . '_' . $year . '.pdf', 'D');
    }
}
