<?php

namespace App\Controllers;

use App\Models\PbjPdnModel;

class PbjPdn extends BaseController
{
    protected $pbjPdnModel;

    public function __construct()
    {
        $this->pbjPdnModel = new PbjPdnModel();
        helper(['form']);
    }

    public function realisasi_pdn()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Indeks Realisasi PDN',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/realisasi_pdn', $data);
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');

        if (!$tahun || !$bulan) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Tahun dan bulan harus diisi']);
        }

        try {
            $paguRupTaggingPdn = (int)($this->request->getPost('pagu_rup_tagging_pdn') ?: 0);
            $realisasiPdn = (int)($this->request->getPost('realisasi_pdn') ?: 0);
            
            // Calculate indeks: Realisasi PDN / Pagu RUP Tagging PDN * 100
            $indeks = $paguRupTaggingPdn > 0 ? ($realisasiPdn / $paguRupTaggingPdn) * 100 : 0;

            $data = [
                'tahun' => $tahun,
                'bulan' => $bulan,
                'pagu_rup_tagging_pdn' => $paguRupTaggingPdn,
                'realisasi_pdn' => $realisasiPdn,
                'indeks' => $indeks,
                'keterangan' => $this->request->getPost('keterangan'),
                'uploaded_by' => $this->ionAuth->user()->row()->id ?? null,
                'uploaded_at' => date('Y-m-d H:i:s')
            ];

            // Check if data exists for this year and month
            $existing = $this->pbjPdnModel->where([
                'tahun' => $tahun,
                'bulan' => $bulan
            ])->first();

            if ($existing) {
                // Update existing data
                $this->pbjPdnModel->update($existing['id'], $data);
            } else {
                // Insert new data
                $this->pbjPdnModel->insert($data);
            }

            return $this->response->setJSON([
                'ok' => true, 
                'message' => 'Data PBJ PDN berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false, 
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function rekap_realisasi_pdn()
    {
        $tahun = (int)($this->request->getGet('year') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        $data = [
            'title' => 'Rekap Indeks Realisasi PDN',
            'tahun' => $tahun,
            'bulan' => $bulan,
            'existingData' => $this->getExistingData($tahun, $bulan),
            'chartData' => $this->getChartData($tahun, $bulan)
        ];

        return $this->view($this->theme->getThemePath() . '/pbj/rekap_realisasi_pdn', $data);
    }

    private function getChartData($tahun, $bulan)
    {
        $data = $this->pbjPdnModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        if (!$data) {
            return [
                'pagu' => 0,
                'realisasi' => 0,
                'indeks' => 0
            ];
        }
        
        return [
            'pagu' => $data['pagu_rup_tagging_pdn'],
            'realisasi' => $data['realisasi_pdn'],
            'indeks' => $data['indeks']
        ];
    }

    private function getExistingData($tahun, $bulan)
    {
        $data = $this->pbjPdnModel->where([
            'tahun' => $tahun,
            'bulan' => $bulan
        ])->first();
        
        return $data ?: [];
    }

    /**
     * Export Excel for Rekap Realisasi PDN
     */
    public function rekapRealisasiPdnExportExcel()
    {
        $tahun = (int)($this->request->getGet('tahun') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        // Get existing data
        $existing = $this->getExistingData($tahun, $bulan);
        
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Sistem Kaldera ESDM')
            ->setLastModifiedBy('Sistem Kaldera ESDM')
            ->setTitle('Rekap Realisasi PDN')
            ->setSubject('Export Data Rekap Realisasi PDN')
            ->setDescription('Data rekap realisasi PDN untuk periode ' . $tahun . ' - ' . bulan_ke_str($bulan));
        
        // Set headers
        $headers = [
            'A1' => 'REKAP REALISASI PDN',
            'A2' => 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan),
            'A3' => 'Tanggal Export: ' . date('d/m/Y H:i:s'),
            'A5' => 'No',
            'B5' => 'Bulan',
            'C5' => 'Pagu RUP Tagging PDN',
            'D5' => 'Realisasi PDN',
            'E5' => 'Indeks Realisasi PDN (%)',
            'F5' => 'Keterangan',
            'G5' => 'Uploaded By',
            'H5' => 'Uploaded At'
        ];
        
        // Set header values
        foreach ($headers as $cell => $value) {
            $sheet->setCellValue($cell, $value);
        }
        
        // Style headers
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A2:A3')->getFont()->setSize(10);
        $sheet->getStyle('A5:H5')->getFont()->setBold(true);
        $sheet->getStyle('A5:H5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('3B6EA8');
        $sheet->getStyle('A5:H5')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFFFFF'));
        
        // Set data
        $row = 6;
        if ($existing) {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, number_format($existing['pagu_rup_tagging_pdn'] ?? 0, 0, ',', '.'));
            $sheet->setCellValue('D' . $row, number_format($existing['realisasi_pdn'] ?? 0, 0, ',', '.'));
            $sheet->setCellValue('E' . $row, number_format($existing['indeks'] ?? 0, 2) . '%');
            $sheet->setCellValue('F' . $row, $existing['keterangan'] ?? '');
            $sheet->setCellValue('G' . $row, $existing['uploaded_by'] ?? '');
            $sheet->setCellValue('H' . $row, $existing['uploaded_at'] ?? '');
        } else {
            $sheet->setCellValue('A' . $row, 1);
            $sheet->setCellValue('B' . $row, bulan_ke_str($bulan));
            $sheet->setCellValue('C' . $row, 'Belum Ada Data');
        }
        
        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Set filename
        $filename = 'PBJ_Realisasi_PDN_' . $tahun . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . date('YmdHis') . '.xlsx';
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        // Create writer and save
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export PDF for Rekap Realisasi PDN
     */
    public function rekapRealisasiPdnExportPdf()
    {
        $tahun = (int)($this->request->getGet('tahun') ?: date('Y'));
        $bulan = (int)($this->request->getGet('bulan') ?: date('n'));
        
        // Get existing data
        $existing = $this->getExistingData($tahun, $bulan);
        
        // Create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('Sistem Kaldera ESDM');
        $pdf->SetAuthor('Sistem Kaldera ESDM');
        $pdf->SetTitle('Rekap Realisasi PDN');
        $pdf->SetSubject('Export Data Rekap Realisasi PDN');
        $pdf->SetKeywords('PBJ, Realisasi, PDN, ESDM, Kaldera');
        
        // Set default header data
        $pdf->SetHeaderData('', 0, 'REKAP REALISASI PDN', 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan) . ' | Tanggal: ' . date('d/m/Y H:i:s'));
        
        // Set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        // Set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        
        // Set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        // Set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        // Add a page
        $pdf->AddPage();
        
        // Set font
        $pdf->SetFont('helvetica', '', 10);
        
        // Title
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'REKAP REALISASI PDN', 0, 1, 'C');
        $pdf->SetFont('helvetica', '', 10);
        $pdf->Cell(0, 5, 'Periode: ' . $tahun . ' - ' . bulan_ke_str($bulan), 0, 1, 'C');
        $pdf->Cell(0, 5, 'Tanggal Export: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(10);
        
        // Data table
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'DATA REALISASI PDN', 0, 1, 'L');
        $pdf->SetFont('helvetica', '', 10);
        
        if ($existing) {
            // Table headers
            $pdf->SetFillColor(59, 110, 168); // Blue background
            $pdf->SetTextColor(255, 255, 255); // White text
            $pdf->SetFont('helvetica', 'B', 9);
            
            $pdf->Cell(30, 8, 'Bulan', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Pagu RUP Tagging PDN', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Realisasi PDN', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Indeks (%)', 1, 0, 'C', true);
            $pdf->Cell(40, 8, 'Uploaded By', 1, 0, 'C', true);
            $pdf->Cell(30, 8, 'Uploaded At', 1, 1, 'C', true);
            
            // Table data
            $pdf->SetTextColor(0, 0, 0); // Black text
            $pdf->SetFont('helvetica', '', 9);
            
            $pdf->Cell(30, 8, bulan_ke_str($bulan), 1, 0, 'C');
            $pdf->Cell(40, 8, number_format($existing['pagu_rup_tagging_pdn'] ?? 0, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(40, 8, number_format($existing['realisasi_pdn'] ?? 0, 0, ',', '.'), 1, 0, 'R');
            $pdf->Cell(30, 8, number_format($existing['indeks'] ?? 0, 2) . '%', 1, 0, 'C');
            $pdf->Cell(40, 8, $existing['uploaded_by'] ?? '', 1, 0, 'C');
            $pdf->Cell(30, 8, $existing['uploaded_at'] ?? '', 1, 1, 'C');
            
            $pdf->Ln(10);
            
            // Keterangan
            if (!empty($existing['keterangan'])) {
                $pdf->SetFont('helvetica', 'B', 10);
                $pdf->Cell(0, 6, 'Keterangan:', 0, 1, 'L');
                $pdf->SetFont('helvetica', '', 9);
                $pdf->MultiCell(0, 5, $existing['keterangan'], 0, 'L');
            }
        } else {
            $pdf->SetFont('helvetica', '', 10);
            $pdf->Cell(0, 8, 'Belum Ada Data untuk periode ini', 0, 1, 'C');
        }
        
        // Set filename
        $filename = 'PBJ_Realisasi_PDN_' . $tahun . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '_' . date('YmdHis') . '.pdf';
        
        // Output PDF
        $pdf->Output($filename, 'D');
        exit;
    }
}
