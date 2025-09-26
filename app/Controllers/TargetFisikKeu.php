<?php

namespace App\Controllers;

use App\Models\TargetFisikKeuMasterModel;
use App\Models\TargetFisikKeuDetailModel;
use App\Models\FiskalModel;
use App\Models\TfkMasterAnggaranModel;
use App\Models\BelanjaAnggaranModel;

class TargetFisikKeu extends BaseController
{
	protected $masterModel;
	protected $detailModel;
	protected $fiskalModel;
    protected $anggaranModel;
    protected $belanjaModel;

	public function __construct()
	{
		$this->masterModel = new TargetFisikKeuMasterModel();
		$this->detailModel = new TargetFisikKeuDetailModel();
		$this->fiskalModel = new FiskalModel();
        $this->anggaranModel = new TfkMasterAnggaranModel();
        $this->belanjaModel = new BelanjaAnggaranModel();
	}

	/**
	 * Get current belanja anggaran by tahun+tahapan
	 */
	public function belanjaMasterGet()
	{
		$tahun = (int)$this->request->getGet('tahun');
		$tahapan = (string)$this->request->getGet('tahapan');
		if (!$tahun) { $tahun = (int)date('Y'); }
		if (!in_array($tahapan, ['penetapan','pergeseran','perubahan'])) {
			$tahapan = 'penetapan';
		}
		$row = $this->belanjaModel->where(['tahun'=>$tahun,'tahapan'=>$tahapan])->first();
		if (!$row) {
			$row = [
				'tahun'=>$tahun,
				'tahapan'=>$tahapan,
				'pegawai'=>0,'barang_jasa'=>0,'hibah'=>0,'bansos'=>0,'modal'=>0,'total'=>0,
			];
		}
		return $this->response->setJSON([
			'ok'=>true,
			'row'=>$row,
			'csrf_token'=>csrf_token(),
			'csrf_hash'=>csrf_hash(),
		]);
	}

    /**
     * Input manual page (static layout with tahapan dropdown)
     */
    public function input($masterId = null)
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');

        // Masters for dropdown (tahapan options come from master rows' "tahapan")
        $masters = $this->masterModel->orderBy('id', 'DESC')->findAll();

        // Choose first master as default source for target values
        $sourceMaster = $masters[0] ?? null;
        $detailsMap = [];
        if ($sourceMaster) {
            $rows = $this->fiskalModel->getByMasterTipeYear($sourceMaster['id'], '1', $year);
            foreach ($rows as $r) {
                $detailsMap[$r['bulan']] = $r;
            }
        }

        $data = [
            'title' => 'Target Fisik & Keuangan - Input Manual',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'year' => $year,
            'tahapan' => $tahapan,
            'masters' => $masters,
            'sourceMaster' => $sourceMaster,
            'detailsMap' => $detailsMap,
        ];

        return view($this->theme->getThemePath() . '/tfk/input', $data);
    }

	public function index($masterId = null)
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$items = $this->masterModel->orderBy('id', 'DESC')->findAll();
		
		// Load existing data for each master
		$mastersWithData = [];
		foreach ($items as $master) {
			$masterDetails = $this->fiskalModel->getByMasterTipeYear($master['id'], '1', $year);
			log_message('debug', 'Loading data for master ' . $master['id'] . ' year ' . $year . ': ' . json_encode($masterDetails));
			$map = [];
			foreach ($masterDetails as $detail) {
				$map[$detail['bulan']] = $detail;
			}
			$mastersWithData[] = [
				'master' => $master,
				'details' => $map
			];
		}
		
		$data = [
			'title' => 'Target Fisik & Keuangan - Data',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'items' => $items,
			'mastersWithData' => $mastersWithData,
			'year' => $year,
		];

		return view($this->theme->getThemePath() . '/tfk/index', $data);
	}


	public function store()
	{
		// Simple handling: master row + monthly fields for fisik% and keu%
		$post = $this->request->getPost();
		$masterId = $this->masterModel->insert([
			'nama' => $post['nama'] ?? 'TFK',
			'tahapan' => $post['tahapan'] ?? 'Penetapan APBD',
		]);

		$months = ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'];
		foreach ($months as $m) {
			$this->detailModel->insert([
				'master_id' => $masterId,
				'bulan' => $m,
				'fisik' => (float)($post['fisik_'.$m] ?? 0),
				'keu' => (float)($post['keu_'.$m] ?? 0),
			]);
		}

		return redirect()->route('tfk.data')->with('message', 'Data tersimpan');
	}

	public function updateCell()
	{
		// Simple test to verify route is working
		if (empty($this->request->getPost())) {
			return $this->response->setJSON(['ok' => true, 'message' => 'Route is working, but no POST data received']);
		}
		
		try {
			// Log all POST data for debugging
			log_message('debug', 'updateCell POST data: ' . json_encode($this->request->getPost()));
			
            $id = (int)$this->request->getPost('id');
			$masterId = (int)$this->request->getPost('master_id');
			$bulan = $this->request->getPost('bulan');
			$field = $this->request->getPost('field'); // fisik | keu
            $value = $this->request->getPost('value');
			$year = (int)$this->request->getPost('year') ?: (int)date('Y');
            $tahapan = (string)($this->request->getPost('tahapan') ?: 'penetapan');

			// Debug logging
			log_message('debug', 'updateCell params: ' . json_encode([
				'id' => $id,
				'master_id' => $masterId,
				'bulan' => $bulan,
				'field' => $field,
				'value' => $value,
				'year' => $year
			]));

			if (!$masterId) {
				return $this->response->setJSON(['ok' => false, 'message' => 'Master ID is required']);
			}
			
			if (!in_array($bulan, ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'])) {
				return $this->response->setJSON(['ok' => false, 'message' => 'Invalid bulan: ' . $bulan]);
			}
			
            if (!in_array($field, ['fisik','keu','real_fisik','real_keu','real_fisik_prov','real_keu_prov','analisa'])) {
				return $this->response->setJSON(['ok' => false, 'message' => 'Invalid field: ' . $field]);
			}

			// Map field names to database columns
            $fieldMap = [
				'fisik' => 'target_fisik',
                'keu' => 'target_keuangan',
                'real_fisik' => 'realisasi_fisik',
                'real_keu' => 'realisasi_keuangan',
                'real_fisik_prov' => 'realisasi_fisik_prov',
                'real_keu_prov' => 'realisasi_keuangan_prov',
                'analisa' => 'analisa',
			];

			$dbField = $fieldMap[$field] ?? $field;

			// Get existing record or create new one
            $existing = $this->fiskalModel->where([
				'master_id' => $masterId,
				'tipe' => '1',
				'tahun' => $year,
                'bulan' => $bulan,
                'tahapan' => $tahapan
			])->first();
			
			log_message('debug', 'Looking for existing record: master_id=' . $masterId . ', tipe=1, tahun=' . $year . ', bulan=' . $bulan);
			log_message('debug', 'Existing record found: ' . json_encode($existing));

			$data = [
				$dbField => $value
			];

			if ($existing) {
				// Update existing record
				$this->fiskalModel->skipValidation(true);
				$result = $this->fiskalModel->update($existing['id'], $data);
				$id = $existing['id'];
				log_message('debug', 'Updated fiskal record ID ' . $id . ' with data: ' . json_encode($data) . ' - Result: ' . $result);
			} else {
				// Create new record
				$data['master_id'] = $masterId;
				$data['tipe'] = '1';
				$data['tahun'] = $year;
                $data['bulan'] = $bulan;
                $data['tahapan'] = $tahapan;
				$this->fiskalModel->skipValidation(true);
				$id = $this->fiskalModel->insert($data);
				log_message('debug', 'Inserted fiskal record with ID: ' . $id . ' and data: ' . json_encode($data));
			}

			// Update deviation calculations
			if ($id) {
				$this->fiskalModel->updateDeviations($id);
			}

			// Verify the data was saved correctly
			$savedRecord = $this->fiskalModel->find($id);
			log_message('debug', 'Verification - Saved record: ' . json_encode($savedRecord));
			
			// Also check if the specific field was saved correctly
			$fieldValue = $savedRecord[$dbField] ?? 'NOT_FOUND';
			log_message('debug', 'Field ' . $dbField . ' value: ' . $fieldValue . ' (expected: ' . $value . ')');

			return $this->response->setJSON(['ok' => true, 'id' => $id, 'value' => $value]);
		} catch (\Exception $e) {
			log_message('error', 'updateCell error: ' . $e->getMessage());
			log_message('error', 'updateCell stack trace: ' . $e->getTraceAsString());
			return $this->response->setJSON(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()]);
		}
	}

	public function rekap()
	{
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        // Use first master automatically (no selector in UI)
        $masters = $this->masterModel->orderBy('id', 'DESC')->findAll();
        $masterId = !empty($masters) ? (int)$masters[0]['id'] : 0;

        $selectedMaster = null;
        $details = [];
        $chartData = [];

        if ($masterId) {
            $selectedMaster = $this->masterModel->find($masterId);
            if ($selectedMaster) {
                $rows = $this->fiskalModel->getByMasterTipeYear($masterId, '1', $year);
                foreach ($rows as $r) {
                    $details[$r['bulan']] = $r;
                }

                $months = ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'];
                $monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
                foreach ($months as $i => $m) {
                    $d = $details[$m] ?? [];
                    $chartData[] = [
                        'month' => $monthNames[$i],
                        'target_fisik' => (float)($d['target_fisik'] ?? 0),
                        'realisasi_fisik' => (float)($d['realisasi_fisik'] ?? 0),
                        'target_keuangan' => (float)($d['target_keuangan'] ?? 0),
                        'realisasi_keuangan' => (float)($d['realisasi_keuangan'] ?? 0),
                    ];
                }
            }
        }

        $data = [
            'title' => 'Target Fisik & Keuangan - Rekap',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'masters' => $masters, // kept for completeness although not shown in UI
            'selectedMaster' => $selectedMaster,
            'masterId' => $masterId,
            'year' => $year,
            'details' => $details,
            'chartData' => $chartData,
        ];

        return view($this->theme->getThemePath() . '/tfk/rekap', $data);
	}

    /**
     * Export Rekap to Excel (PhpSpreadsheet)
     */
    public function rekapExportExcel()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $masterId = (int)($this->request->getGet('master_id') ?: 0);
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        if (!$masterId) {
            $masters = $this->masterModel->orderBy('id', 'DESC')->findAll();
            $masterId = !empty($masters) ? (int)$masters[0]['id'] : 0;
        }

        // Pull data
        $rows = $this->fiskalModel->where([
            'master_id' => $masterId,
            'tipe'      => '1',
            'tahun'     => $year,
            'tahapan'   => $tahapan,
        ])->orderBy('bulan', 'ASC')->findAll();

        $map = [];
        foreach ($rows as $r) { $map[$r['bulan']] = $r; }
        $months = ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'];
        $monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        // Build spreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap ' . $year);

        // Header
        $sheet->setCellValue('A1', 'Kumulatif');
        foreach ($monthNames as $i => $name) {
            $col = chr(ord('B') + $i);
            $sheet->setCellValue($col . '1', $name);
        }

        $rowsSpec = [
            ['Target Fisik (%)', 'target_fisik', 0],
            ['Realisasi Fisik (%)', 'realisasi_fisik', 2],
            ['Realisasi Fisik Prov (%)', 'realisasi_fisik_prov', 2],
            ['Deviasi Fisik (%)', null, 2, function($d){return ($d['realisasi_fisik']??0)-($d['target_fisik']??0);} ],
            ['Target Keuangan (%)', 'target_keuangan', 0],
            ['Realisasi Keuangan (%)', 'realisasi_keuangan', 2],
            ['Realisasi Keuangan Prov (%)', 'realisasi_keuangan_prov', 2],
            ['Deviasi Keuangan (%)', null, 2, function($d){return ($d['realisasi_keuangan']??0)-($d['target_keuangan']??0);} ],
            ['Analisa', 'analisa', null],
        ];

        $r = 2;
        foreach ($rowsSpec as $spec) {
            [$label, $field, $decimals] = $spec;
            $sheet->setCellValue('A' . $r, $label);
            foreach ($months as $i => $m) {
                $col = chr(ord('B') + $i);
                $d = $map[$m] ?? [];
                if (isset($spec[3]) && is_callable($spec[3])) {
                    $val = call_user_func($spec[3], $d);
                } else {
                    $val = $field ? ($d[$field] ?? '') : '';
                }
                $sheet->setCellValue($col . $r, $val);
            }
            $r++;
        }

        // Output
        $filename = 'rekap_tfk_' . $year . '_' . $tahapan . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Export Rekap to PDF (TCPDF as FPDF-like library via vendor/tecnickcom/tcpdf)
     */
    public function rekapExportPDF()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $masterId = (int)($this->request->getGet('master_id') ?: 0);
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
        if (!$masterId) {
            $masters = $this->masterModel->orderBy('id', 'DESC')->findAll();
            $masterId = !empty($masters) ? (int)$masters[0]['id'] : 0;
        }

        $rows = $this->fiskalModel->where([
            'master_id' => $masterId,
            'tipe'      => '1',
            'tahun'     => $year,
            'tahapan'   => $tahapan,
        ])->orderBy('bulan', 'ASC')->findAll();

        $map = [];
        foreach ($rows as $r) { $map[$r['bulan']] = $r; }
        $months = ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'];
        $monthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        // Initialize TCPDF
        $pdf = new \TCPDF();
        $pdf->SetCreator('Kaldera');
        $pdf->SetAuthor('Kaldera');
        $pdf->SetTitle('Rekap TFK ' . $year);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage('L', 'A4');

        $html = '<h3 style="margin:0;">Rekap Target Fisik & Keuangan - ' . $year . ' (' . strtoupper($tahapan) . ')</h3>';
        $html .= '<table border="1" cellpadding="4" cellspacing="0">';
        $html .= '<tr><th>Kumulatif</th>';
        foreach ($monthNames as $name) { $html .= '<th>' . $name . '</th>'; }
        $html .= '</tr>';

        $rowsSpec = [
            ['Target Fisik (%)', 'target_fisik'],
            ['Realisasi Fisik (%)', 'realisasi_fisik'],
            ['Realisasi Fisik Prov (%)', 'realisasi_fisik_prov'],
            ['Deviasi Fisik (%)', null, function($d){return ($d['realisasi_fisik']??0)-($d['target_fisik']??0);} ],
            ['Target Keuangan (%)', 'target_keuangan'],
            ['Realisasi Keuangan (%)', 'realisasi_keuangan'],
            ['Realisasi Keuangan Prov (%)', 'realisasi_keuangan_prov'],
            ['Deviasi Keuangan (%)', null, function($d){return ($d['realisasi_keuangan']??0)-($d['target_keuangan']??0);} ],
            ['Analisa', 'analisa'],
        ];

        foreach ($rowsSpec as $spec) {
            [$label, $field] = $spec;
            $html .= '<tr><td><b>' . $label . '</b></td>';
            foreach ($months as $m) {
                $d = $map[$m] ?? [];
                if (isset($spec[2]) && is_callable($spec[2])) {
                    $val = call_user_func($spec[2], $d);
                } else {
                    $val = $field ? ($d[$field] ?? '') : '';
                }
                $html .= '<td>' . $val . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</table>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('rekap_tfk_' . $year . '_' . $tahapan . '.pdf', 'I');
        exit;
    }

    public function master()
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');

        // Determine master (first available)
        $masters = $this->masterModel->orderBy('id','DESC')->findAll();
        $masterId = !empty($masters) ? (int)$masters[0]['id'] : 0;

        // Load monthly target data (read-only)
        $details = [];
        if ($masterId) {
            $rows = $this->fiskalModel->where([
                'master_id' => $masterId,
                'tipe'      => '1',
                'tahun'     => $year,
                'tahapan'   => $tahapan,
            ])->orderBy('bulan','ASC')->findAll();
            foreach ($rows as $r) { $details[$r['bulan']] = $r; }
        }

        $data = [
            'title' => 'TFK - Master Data',
            'Pengaturan' => $this->pengaturan,
            'user' => $this->ionAuth->user()->row(),
            'year' => $year,
            'tahapan' => $tahapan,
            'details' => $details,
        ];
        return view($this->theme->getThemePath() . '/tfk/master', $data);
    }

	public function masterStore()
	{
        $tahun = (int)$this->request->getPost('tahun');
        $tahapan = (string)$this->request->getPost('tahapan');
        $pegawai = (float)$this->request->getPost('pegawai');
        $barang = (float)$this->request->getPost('barang_jasa');
        $hibah = (float)$this->request->getPost('hibah');
        $bansos = (float)$this->request->getPost('bansos');
        $modal = (float)$this->request->getPost('modal');
        $total = $pegawai + $barang + $hibah + $bansos + $modal;

        $this->anggaranModel->insert([
            'tahun' => $tahun,
            'tahapan' => $tahapan,
            'pegawai' => $pegawai,
            'barang_jasa' => $barang,
            'hibah' => $hibah,
            'bansos' => $bansos,
            'modal' => $modal,
            'total' => $total,
        ]);
		return redirect()->route('tfk.master')->with('message', 'Master ditambahkan');
	}

	public function masterDelete($id)
	{
		$id = (int)$id;
		if ($id) {
			$this->masterModel->delete($id);
		}
		return redirect()->route('tfk.master')->with('message', 'Master dihapus');
	}

	public function refreshCSRF()
	{
		return $this->response->setJSON([
			'ok' => true,
			'csrf_token' => csrf_token(),
			'csrf_hash' => csrf_hash()
		]);
	}

	public function belanjaMasterUpdate()
	{
		try {
			$tahun = (int)$this->request->getPost('tahun');
			$tahapan = (string)$this->request->getPost('tahapan');
			$field = (string)$this->request->getPost('field');
			$value = (float)$this->request->getPost('value');
			
			if (!$tahun) { $tahun = (int)date('Y'); }
            if (!in_array($tahapan, ['penetapan','pergeseran','perubahan'])) {
                $tahapan = 'penetapan';
            }
		$allowed = ['pegawai','barang_jasa','hibah','bansos','modal'];
		if (!in_array($field, $allowed)) {
		    return $this->response->setJSON([
		        'ok'=>false,
		        'message'=>'Invalid field',
		        'csrf_token' => csrf_token(),
		        'csrf_hash' => csrf_hash(),
		    ]);
		}
			$row = $this->belanjaModel->where(['tahun'=>$tahun,'tahapan'=>$tahapan])->first();
			if ($row) {
				$row[$field] = $value;
				$row['total'] = (float)($row['pegawai'] + $row['barang_jasa'] + $row['hibah'] + $row['bansos'] + $row['modal']);
				$this->belanjaModel->update($row['id'], $row);
			} else {
				$data = [
					'tahun'=>$tahun,
					'tahapan'=>$tahapan,
					'pegawai'=>0,'barang_jasa'=>0,'hibah'=>0,'bansos'=>0,'modal'=>0,
				];
				$data[$field] = $value;
				$data['total'] = (float)($data['pegawai'] + $data['barang_jasa'] + $data['hibah'] + $data['bansos'] + $data['modal']);
				$id = $this->belanjaModel->insert($data);
				$row = $this->belanjaModel->find($id);
			}
            return $this->response->setJSON([
                'ok'=>true,
                'row'=>$row,
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
		} catch (\Exception $e) {
			log_message('error', 'BelanjaMasterUpdate Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok'=>false,
                'message'=>$e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
		}
	}
}


