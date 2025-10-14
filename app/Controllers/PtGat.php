<?php

namespace App\Controllers;

use App\Models\UnitKerjaModel;
use App\Models\PtModel;

class PtGat extends BaseController
{
    protected $unitKerjaModel;
    protected $ptModel;

    public function __construct()
    {
        $this->unitKerjaModel = new UnitKerjaModel();
        $this->ptModel = new PtModel();
        helper(['form', 'url', 'tanggalan']);
    }

    public function index()
    {
        // Get parameters from URL
        $year = $this->request->getGet('year') ?? date('Y');
        $bulan = $this->request->getGet('bulan') ?? date('n');

        // Get unit kerja list
        $unitKerjaList = $this->unitKerjaModel->where('status', 'Aktif')->findAll();

        // Get existing data for this periode
        $existingData = $this->ptModel->getByPeriode($year, $bulan, 'gat');

        // Create a map of existing data by unit kerja name
        $existingMap = [];
        foreach ($existingData as $item) {
            $existingMap[$item->unit_kerja_nama] = $item;
        }

        $data = [
            'title' => 'Persetujuan Teknis - GAT',
            'year' => (int)$year,
            'bulan' => (int)$bulan,
            'unitKerjaList' => $unitKerjaList,
            'existingData' => $existingMap
        ];

        return $this->view($this->theme->getThemePath() . '/pt-gat/input', $data);
    }

    public function saveData()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Invalid request'
            ]);
        }

        try {
            $tahun = $this->request->getPost('tahun');
            $bulan = $this->request->getPost('bulan');
            $dataRows = $this->request->getPost('data');

            if (empty($dataRows) || !is_array($dataRows)) {
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'Data tidak valid',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }

            // Save each row
            foreach ($dataRows as $row) {
                $saveData = [
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                    'sektor' => 'gat',
                    'unit_kerja_id' => $row['unit_kerja_id'] ?? null,
                    'unit_kerja_nama' => $row['unit_kerja_nama'],
                    'permohonan_masuk' => (int)($row['permohonan_masuk'] ?? 0),
                    'masih_proses' => (int)($row['masih_proses'] ?? 0),
                    'disetujui' => (int)($row['disetujui'] ?? 0),
                    'dikembalikan' => (int)($row['dikembalikan'] ?? 0),
                    'ditolak' => (int)($row['ditolak'] ?? 0),
                    'keterangan' => $row['keterangan'] ?? ''
                ];

                $this->ptModel->saveData($saveData);
            }

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Data berhasil disimpan',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            log_message('error', 'Error saving PT GAT data: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }

    public function rekap()
    {
        // Get parameters from URL
        $year = $this->request->getGet('year') ?? date('Y');
        $bulan = $this->request->getGet('bulan') ?? date('n');

        // Get unit kerja list from master table
        $unitKerjaList = $this->unitKerjaModel->where('status', 'Aktif')->findAll();
        
        // Get PT data for this periode
        $ptData = $this->ptModel->getByPeriode($year, $bulan, 'gat');
        
        // Create a map of PT data by unit kerja name
        $ptDataMap = [];
        foreach ($ptData as $item) {
            $ptDataMap[$item->unit_kerja_nama] = $item;
        }
        
        // Build rekap data by combining unit kerja master data with PT data
        $rekapData = [];
        foreach ($unitKerjaList as $unitKerja) {
            $unitName = is_object($unitKerja) ? $unitKerja->nama_unit_kerja : $unitKerja['nama_unit_kerja'];
            $ptItem = $ptDataMap[$unitName] ?? null;
            
            $rekapData[] = (object)[
                'unit_kerja_nama' => $unitName,
                'permohonan_masuk' => $ptItem ? (int)$ptItem->permohonan_masuk : 0,
                'masih_proses' => $ptItem ? (int)$ptItem->masih_proses : 0,
                'disetujui' => $ptItem ? (int)$ptItem->disetujui : 0,
                'dikembalikan' => $ptItem ? (int)$ptItem->dikembalikan : 0,
                'ditolak' => $ptItem ? (int)$ptItem->ditolak : 0,
                'keterangan' => $ptItem ? $ptItem->keterangan : ''
            ];
        }

        // Calculate totals from the combined data
        $totalsData = (object)[
            'total_permohonan_masuk' => array_sum(array_column($rekapData, 'permohonan_masuk')),
            'total_masih_proses' => array_sum(array_column($rekapData, 'masih_proses')),
            'total_disetujui' => array_sum(array_column($rekapData, 'disetujui')),
            'total_dikembalikan' => array_sum(array_column($rekapData, 'dikembalikan')),
            'total_ditolak' => array_sum(array_column($rekapData, 'ditolak'))
        ];

        // Calculate chart data
        $total = (int)($totalsData->total_permohonan_masuk ?? 0);
        $chartData = [
            'disetujui' => (int)($totalsData->total_disetujui ?? 0),
            'masih_proses' => (int)($totalsData->total_masih_proses ?? 0),
            'dikembalikan' => (int)($totalsData->total_dikembalikan ?? 0),
            'ditolak' => (int)($totalsData->total_ditolak ?? 0),
            'total' => $total,
            'disetujui_percent' => $total > 0 ? round(($totalsData->total_disetujui / $total) * 100, 2) : 0,
            'proses_percent' => $total > 0 ? round(($totalsData->total_masih_proses / $total) * 100, 2) : 0,
            'dikembalikan_percent' => $total > 0 ? round(($totalsData->total_dikembalikan / $total) * 100, 2) : 0,
            'ditolak_percent' => $total > 0 ? round(($totalsData->total_ditolak / $total) * 100, 2) : 0
        ];

        $data = [
            'title' => 'Rekap Persetujuan Teknis - GAT',
            'year' => (int)$year,
            'bulan' => (int)$bulan,
            'rekapData' => $rekapData,
            'totalsData' => $totalsData,
            'chartData' => $chartData
        ];

        return $this->view($this->theme->getThemePath() . '/pt-gat/rekap', $data);
    }

    public function exportExcel()
    {
        // Get parameters from URL
        $year = $this->request->getGet('year') ?? date('Y');
        $bulan = $this->request->getGet('bulan') ?? date('n');

        // Get data for this periode
        $rekapData = $this->ptModel->getByPeriode($year, $bulan, 'gat');
        $totalsData = $this->ptModel->getTotals($year, $bulan, 'gat');

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Sistem Kaldera ESDM')
            ->setTitle('Rekap Persetujuan Teknis - Sektor GAT')
            ->setDescription('Export data rekap persetujuan teknis sektor gat');

        // Set headers
        $sheet->setCellValue('A1', 'REKAP PERSETUJUAN TEKNIS - SEKTOR GAT');
        $sheet->setCellValue('A2', 'Periode: ' . bulan_ke_str($bulan) . ' ' . $year);
        $sheet->setCellValue('A3', 'Tanggal Export: ' . date('d/m/Y H:i:s'));

        // Set table headers
        $headers = ['No', 'Unit Kerja', 'Permohonan Masuk', 'Masih Proses', 'Disetujui', 'Dikembalikan', 'Ditolak', 'Keterangan'];
        $col = 'A';
        $row = 5;
        
        foreach ($headers as $header) {
            $sheet->setCellValue($col . $row, $header);
            $col++;
        }

        // Style headers
        $headerRange = 'A5:H5';
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('DC3545');
        $sheet->getStyle($headerRange)->getFont()->getColor()->setRGB('FFFFFF');

        // Add data rows
        $row = 6;
        $no = 1;
        foreach ($rekapData as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data->unit_kerja_nama);
            $sheet->setCellValue('C' . $row, $data->permohonan_masuk);
            $sheet->setCellValue('D' . $row, $data->masih_proses);
            $sheet->setCellValue('E' . $row, $data->disetujui);
            $sheet->setCellValue('F' . $row, $data->dikembalikan);
            $sheet->setCellValue('G' . $row, $data->ditolak);
            $sheet->setCellValue('H' . $row, $data->keterangan);
            $row++;
        }

        // Add totals row
        if ($totalsData) {
            $sheet->setCellValue('A' . $row, '');
            $sheet->setCellValue('B' . $row, 'JUMLAH');
            $sheet->setCellValue('C' . $row, $totalsData->total_permohonan_masuk);
            $sheet->setCellValue('D' . $row, $totalsData->total_masih_proses);
            $sheet->setCellValue('E' . $row, $totalsData->total_disetujui);
            $sheet->setCellValue('F' . $row, $totalsData->total_dikembalikan);
            $sheet->setCellValue('G' . $row, $totalsData->total_ditolak);
            $sheet->setCellValue('H' . $row, '');
            
            // Style totals row
            $totalsRange = 'A' . $row . ':H' . $row;
            $sheet->getStyle($totalsRange)->getFont()->setBold(true);
            $sheet->getStyle($totalsRange)->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setRGB('F8F9FA');
        }

        // Auto-size columns
        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Set filename
        $filename = 'Rekap_PT_GAT_' . $year . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create writer and save
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportPdf()
    {
        // Get parameters from URL
        $year = $this->request->getGet('year') ?? date('Y');
        $bulan = $this->request->getGet('bulan') ?? date('n');

        // Get data for this periode
        $rekapData = $this->ptModel->getByPeriode($year, $bulan, 'gat');
        $totalsData = $this->ptModel->getTotals($year, $bulan, 'gat');

        // Create new PDF document
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        
        // Set document information
        $pdf->SetCreator('Sistem Kaldera ESDM');
        $pdf->SetAuthor('Sistem Kaldera ESDM');
        $pdf->SetTitle('Rekap Persetujuan Teknis - Sektor GAT');
        $pdf->SetSubject('Export data rekap persetujuan teknis sektor gat');

        // Set margins
        $pdf->SetMargins(10, 15, 10);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', 'B', 16);
        $pdf->Cell(0, 10, 'REKAP PERSETUJUAN TEKNIS - SEKTOR GAT', 0, 1, 'C');
        
        $pdf->SetFont('helvetica', '', 12);
        $pdf->Cell(0, 8, 'Periode: ' . bulan_ke_str($bulan) . ' ' . $year, 0, 1, 'C');
        $pdf->Cell(0, 8, 'Tanggal Export: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $pdf->Ln(5);

        // Create table
        $pdf->SetFont('helvetica', 'B', 10);
        
        // Table headers
        $headers = ['No', 'Unit Kerja', 'Permohonan Masuk', 'Masih Proses', 'Disetujui', 'Dikembalikan', 'Ditolak', 'Keterangan'];
        $widths = [15, 50, 25, 25, 25, 25, 25, 40];
        
        // Header row
        $pdf->SetFillColor(220, 53, 69);
        $pdf->SetTextColor(255, 255, 255);
        for ($i = 0; $i < count($headers); $i++) {
            $pdf->Cell($widths[$i], 8, $headers[$i], 1, 0, 'C', true);
        }
        $pdf->Ln();

        // Data rows
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('helvetica', '', 9);
        $no = 1;
        foreach ($rekapData as $data) {
            $pdf->Cell($widths[0], 6, $no++, 1, 0, 'C');
            $pdf->Cell($widths[1], 6, $data->unit_kerja_nama, 1, 0, 'L');
            $pdf->Cell($widths[2], 6, number_format($data->permohonan_masuk), 1, 0, 'C');
            $pdf->Cell($widths[3], 6, number_format($data->masih_proses), 1, 0, 'C');
            $pdf->Cell($widths[4], 6, number_format($data->disetujui), 1, 0, 'C');
            $pdf->Cell($widths[5], 6, number_format($data->dikembalikan), 1, 0, 'C');
            $pdf->Cell($widths[6], 6, number_format($data->ditolak), 1, 0, 'C');
            $pdf->Cell($widths[7], 6, $data->keterangan, 1, 0, 'L');
            $pdf->Ln();
        }

        // Totals row
        if ($totalsData) {
            $pdf->SetFont('helvetica', 'B', 9);
            $pdf->SetFillColor(248, 249, 250);
            $pdf->Cell($widths[0], 6, '', 1, 0, 'C', true);
            $pdf->Cell($widths[1], 6, 'JUMLAH', 1, 0, 'C', true);
            $pdf->Cell($widths[2], 6, number_format($totalsData->total_permohonan_masuk), 1, 0, 'C', true);
            $pdf->Cell($widths[3], 6, number_format($totalsData->total_masih_proses), 1, 0, 'C', true);
            $pdf->Cell($widths[4], 6, number_format($totalsData->total_disetujui), 1, 0, 'C', true);
            $pdf->Cell($widths[5], 6, number_format($totalsData->total_dikembalikan), 1, 0, 'C', true);
            $pdf->Cell($widths[6], 6, number_format($totalsData->total_ditolak), 1, 0, 'C', true);
            $pdf->Cell($widths[7], 6, '', 1, 0, 'C', true);
        }

        // Set filename and output
        $filename = 'Rekap_PT_GAT_' . $year . '_' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '.pdf';
        $pdf->Output($filename, 'D');
        exit;
    }
}
