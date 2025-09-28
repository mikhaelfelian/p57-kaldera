<?php

namespace App\Controllers;

use App\Models\TargetFisikKeuMasterModel;
use App\Models\TargetFisikKeuDetailModel;
use App\Models\FiskalModel;
use App\Models\TfkMasterAnggaranModel;
use App\Models\BelanjaAnggaranModel;
use App\Models\BelanjaInputModel;

class TargetFisikKeu extends BaseController
{
	protected $masterModel;
	protected $detailModel;
	protected $fiskalModel;
    protected $anggaranModel;
    protected $belanjaModel;
    protected $belanjaInputModel;

	public function __construct()
	{
		$this->masterModel = new TargetFisikKeuMasterModel();
		$this->detailModel = new TargetFisikKeuDetailModel();
		$this->fiskalModel = new FiskalModel();
        $this->anggaranModel = new TfkMasterAnggaranModel();
        $this->belanjaModel = new BelanjaAnggaranModel();
        $this->belanjaInputModel = new BelanjaInputModel();
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

        // Build tahapan options from existing fiskal rows for this master+year
        $tahapanOptions = ['penetapan' => 'Penetapan APBD', 'pergeseran' => 'Pergeseran', 'perubahan' => 'Perubahan APBD'];
        if ($sourceMaster) {
            $distinctTahapan = $this->fiskalModel
                ->distinct()
                ->select('tahapan')
                ->where(['master_id' => $sourceMaster['id'], 'tipe' => '1', 'tahun' => $year])
                ->findColumn('tahapan');
            if (!empty($distinctTahapan)) {
                $mapNames = ['penetapan' => 'Penetapan APBD', 'pergeseran' => 'Pergeseran', 'perubahan' => 'Perubahan APBD'];
                $tahapanOptions = [];
                foreach ($distinctTahapan as $t) { $tahapanOptions[$t] = $mapNames[$t] ?? ucfirst($t); }
                if (!array_key_exists($tahapan, $tahapanOptions)) {
                    $firstKey = array_key_first($tahapanOptions);
                    if ($firstKey) { $tahapan = $firstKey; }
                }
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
            'tahapanOptions' => $tahapanOptions,
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
            // NOTE: Unique key is on (master_id, tipe, tahun, bulan) so we must
            // search without filtering by 'tahapan' to avoid duplicate key errors
            $existing = $this->fiskalModel->where([
                'master_id' => $masterId,
                'tipe' => '1',
                'tahun' => $year,
                'bulan' => $bulan,
            ])->first();
			
			log_message('debug', 'Looking for existing record: master_id=' . $masterId . ', tipe=1, tahun=' . $year . ', bulan=' . $bulan);
			log_message('debug', 'Existing record found: ' . json_encode($existing));

            $data = [
                $dbField => $value,
                // Always keep latest tahapan value on the row
                'tahapan' => $tahapan,
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

	public function getData()
	{
		try {
			$tahun = (int)$this->request->getGet('tahun') ?: date('Y');
			$tahapan = $this->request->getGet('tahapan') ?: 'penetapan';
			
			log_message('debug', 'getData called with tahun: ' . $tahun . ', tahapan: ' . $tahapan);
			
            // Get data from database based on tahun, tahapan and master
            $masterId = (int)($this->request->getGet('master_id') ?: 1);
            $rows = $this->fiskalModel->where([
                'tahun' => $tahun,
                'tahapan' => $tahapan,
                'tipe' => '1',
                'master_id' => $masterId
            ])->findAll();

            // Fallback: if no rows found for specific master, try without master filter
            if (empty($rows)) {
                $rows = $this->fiskalModel->where([
                    'tahun' => $tahun,
                    'tahapan' => $tahapan,
                    'tipe' => '1',
                ])->findAll();
                log_message('debug', 'Fallback query without master_id returned ' . count($rows) . ' rows');
            }
			
            log_message('debug', 'Found ' . count($rows) . ' records for tahun: ' . $tahun . ', tahapan: ' . $tahapan . ', master_id: ' . $masterId);
			log_message('debug', 'Raw rows data: ' . json_encode($rows));
			
			// Organize data by bulan
			$data = [];
			foreach ($rows as $row) {
				$data[$row['bulan']] = [
					'id' => $row['id'],
					'target_fisik' => (float)$row['target_fisik'],
					'target_keuangan' => (float)$row['target_keuangan'],
					'realisasi_fisik' => (float)$row['realisasi_fisik'],
					'realisasi_keuangan' => (float)$row['realisasi_keuangan'],
					'realisasi_fisik_prov' => (float)$row['realisasi_fisik_prov'],
					'realisasi_keuangan_prov' => (float)$row['realisasi_keuangan_prov'],
					'deviasi_fisik' => (float)$row['deviasi_fisik'],
					'deviasi_keuangan' => (float)$row['deviasi_keuangan'],
					'analisa' => (string)$row['analisa']
				];
			}
			
			log_message('debug', 'Organized data: ' . json_encode($data));
			
			return $this->response->setJSON([
				'ok' => true,
				'data' => $data,
				'csrf_hash' => csrf_hash()
			]);
			
		} catch (\Exception $e) {
			log_message('error', 'getData error: ' . $e->getMessage());
			return $this->response->setJSON(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()]);
		}
	}

	public function saveAll()
	{
		try {
			$tahun = (int)$this->request->getPost('tahun') ?: date('Y');
			$tahapan = $this->request->getPost('tahapan') ?: 'penetapan';
			$data = $this->request->getPost('data');
			
			log_message('debug', 'saveAll called with tahun: ' . $tahun . ', tahapan: ' . $tahapan);
			log_message('debug', 'Data received: ' . json_encode($data));
			
			if (empty($data) || !is_array($data)) {
				return $this->response->setJSON(['ok' => false, 'message' => 'No data provided']);
			}
			
			$savedCount = 0;
			$errors = [];
			
			// Process each month's data
			foreach ($data as $bulan => $monthData) {
				if (!in_array($bulan, ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'])) {
					continue; // Skip invalid bulan
				}
				
                // Check if record exists using unique key columns only
                $existing = $this->fiskalModel->where([
                    'master_id' => 1,
                    'tipe' => '1',
                    'tahun' => $tahun,
                    'bulan' => $bulan,
                ])->first();
				
                $recordData = [
					'master_id' => 1,
					'tipe' => '1',
					'tahun' => $tahun,
					'bulan' => $bulan,
                    // Keep latest tahapan value on the row
                    'tahapan' => $tahapan,
					'target_fisik' => isset($monthData['fisik']) ? (float)$monthData['fisik'] : 0,
					'target_keuangan' => isset($monthData['keu']) ? (float)$monthData['keu'] : 0
				];
				
				$this->fiskalModel->skipValidation(true);
				
				if ($existing) {
					// Update existing record
					$result = $this->fiskalModel->update($existing['id'], $recordData);
					if ($result) {
						$savedCount++;
						log_message('debug', 'Updated record for bulan: ' . $bulan);
					} else {
						$errors[] = 'Failed to update bulan: ' . $bulan;
					}
				} else {
					// Create new record
					$id = $this->fiskalModel->insert($recordData);
					if ($id) {
						$savedCount++;
						log_message('debug', 'Created new record for bulan: ' . $bulan . ' with ID: ' . $id);
					} else {
						$errors[] = 'Failed to create record for bulan: ' . $bulan;
					}
				}
			}
			
			log_message('debug', 'saveAll completed. Saved: ' . $savedCount . ', Errors: ' . count($errors));
			
			return $this->response->setJSON([
				'ok' => true,
				'message' => 'Data saved successfully',
				'saved_count' => $savedCount,
				'errors' => $errors,
				'csrf_hash' => csrf_hash()
			]);
			
		} catch (\Exception $e) {
			log_message('error', 'saveAll error: ' . $e->getMessage());
			return $this->response->setJSON(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()]);
		}
	}

	public function test()
	{
		return $this->response->setJSON([
			'ok' => true,
			'message' => 'TFK controller is working',
			'time' => date('Y-m-d H:i:s'),
			'csrf_hash' => csrf_hash()
		]);
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
				// Only update the specific field, preserve all other existing data
				$updateData = [
					$field => $value
				];
				$this->belanjaModel->update($row['id'], $updateData);
				
				// Recalculate total after update
				$updatedRow = $this->belanjaModel->find($row['id']);
				$newTotal = (float)($updatedRow['pegawai'] + $updatedRow['barang_jasa'] + $updatedRow['hibah'] + $updatedRow['bansos'] + $updatedRow['modal']);
				$this->belanjaModel->update($row['id'], ['total' => $newTotal]);
				
				$row = $this->belanjaModel->find($row['id']);
			} else {
				// Create new record with default values, only set the specific field
				$data = [
					'tahun'=>$tahun,
					'tahapan'=>$tahapan,
					'pegawai'=>0,'barang_jasa'=>0,'hibah'=>0,'bansos'=>0,'modal'=>0,
				];
				$data[$field] = $value;
				$data['total'] = (float)$value; // For new record, total equals the single field value
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

	/**
	 * Batch update belanja master data
	 */
	public function belanjaMasterUpdateBatch()
	{
		try {
			$tahun = (int)$this->request->getPost('tahun');
			$tahapan = (string)$this->request->getPost('tahapan');
			
			if (!$tahun) { $tahun = (int)date('Y'); }
            if (!in_array($tahapan, ['penetapan','pergeseran','perubahan'])) {
                $tahapan = 'penetapan';
            }

			// Get all field values
			$allowed = ['pegawai','barang_jasa','hibah','bansos','modal'];
			$data = ['tahun' => $tahun, 'tahapan' => $tahapan];
			
			foreach ($allowed as $field) {
				$value = $this->request->getPost($field);
				if ($value !== null) {
					$data[$field] = (float)$value;
				}
			}
			
			$row = $this->belanjaModel->where(['tahun'=>$tahun,'tahapan'=>$tahapan])->first();
			if ($row) {
				// Update existing record
				$this->belanjaModel->update($row['id'], $data);
				
				// Recalculate total
				$updatedRow = $this->belanjaModel->find($row['id']);
				$newTotal = (float)($updatedRow['pegawai'] + $updatedRow['barang_jasa'] + $updatedRow['hibah'] + $updatedRow['bansos'] + $updatedRow['modal']);
				$this->belanjaModel->update($row['id'], ['total' => $newTotal]);
				
				$row = $this->belanjaModel->find($row['id']);
			} else {
				// Create new record
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
			log_message('error', 'BelanjaMasterUpdateBatch Error: ' . $e->getMessage());
            return $this->response->setJSON([
                'ok'=>false,
                'message'=>$e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
		}
	}

	/**
	 * Belanja Input page
	 */
	public function belanjaInput()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
		$bulan = (int)($this->request->getGet('bulan') ?: 9); // Default to September

		// Get master data for anggaran values
		$masterData = $this->belanjaModel->where(['tahun' => $year, 'tahapan' => $tahapan])->first();
		
		// Get existing data using id_belanja if master data exists
		$existingData = null;
		if ($masterData) {
			$existingData = $this->belanjaInputModel->getByIdBelanjaBulan($masterData['id'], $bulan);
		}
		
		$data = [
			'title' => 'Belanja - Input',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'year' => $year,
			'tahapan' => $tahapan,
			'bulan' => $bulan,
			'existingData' => $existingData,
			'masterData' => $masterData,
		];

		return view($this->theme->getThemePath() . '/tfk/belanja_input', $data);
	}

	/**
	 * Save belanja input data
	 */
	public function belanjaInputSave()
	{
		try {
			$tahun = (int)$this->request->getPost('tahun');
			$tahapan = (string)$this->request->getPost('tahapan');
			$bulan = (int)$this->request->getPost('bulan');

			// Ensure helper available for format_angka_db
			helper(['angka']);
			if (!function_exists('format_angka_db')) {
				// Fallback parser: strip non-digits except minus
				function format_angka_db($angka) {
					if (is_null($angka)) return 0;
					if (is_numeric($angka)) return (float)$angka;
					$raw = preg_replace('/[^0-9\-]/', '', (string)$angka);
					return (float)$raw;
				}
			}
			
			// Get master data to get id_belanja
			$masterData = $this->belanjaModel->where(['tahun' => $tahun, 'tahapan' => $tahapan])->first();
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
				'pegawai_anggaran' => (float)$masterData['pegawai'],
				'pegawai_realisasi' => (float)format_angka_db($this->request->getPost('pegawai_realisasi')),
				'barang_jasa_anggaran' => (float)$masterData['barang_jasa'],
				'barang_jasa_realisasi' => (float)format_angka_db($this->request->getPost('barang_jasa_realisasi')),
				'hibah_anggaran' => (float)$masterData['hibah'],
				'hibah_realisasi' => (float)format_angka_db($this->request->getPost('hibah_realisasi')),
				'bansos_anggaran' => (float)$masterData['bansos'],
				'bansos_realisasi' => (float)format_angka_db($this->request->getPost('bansos_realisasi')),
				'modal_anggaran' => (float)$masterData['modal'],
				'modal_realisasi' => (float)format_angka_db($this->request->getPost('modal_realisasi')),
			];

			// Calculate totals
			$inputData['total_anggaran'] = $inputData['pegawai_anggaran'] + $inputData['barang_jasa_anggaran'] + 
											$inputData['hibah_anggaran'] + $inputData['bansos_anggaran'] + $inputData['modal_anggaran'];
			$inputData['total_realisasi'] = $inputData['pegawai_realisasi'] + $inputData['barang_jasa_realisasi'] + 
											$inputData['hibah_realisasi'] + $inputData['bansos_realisasi'] + $inputData['modal_realisasi'];

			$this->belanjaInputModel->upsertByIdBelanja($masterData['id'], $bulan, $inputData);

			return $this->response->setJSON([
				'ok' => true,
				'message' => 'Data berhasil disimpan',
				'csrf_token' => csrf_token(),
				'csrf_hash' => csrf_hash(),
			]);
		} catch (\Exception $e) {
			log_message('error', 'BelanjaInputSave Error: ' . $e->getMessage());
			return $this->response->setJSON([
				'ok' => false,
				'message' => $e->getMessage(),
				'csrf_token' => csrf_token(),
				'csrf_hash' => csrf_hash(),
			]);
		}
	}

	/**
	 * Belanja Rekap page (read-only with chart and export)
	 */
	public function belanjaRekap()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
		$bulan = (int)($this->request->getGet('bulan') ?: 9); // Default to September

		// Get data directly from tbl_belanja_input using tahun and bulan
		$existingData = $this->belanjaInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

		// Prepare chart data
		$chartData = [];
		if ($existingData) {
			$totalAnggaran = (float)($existingData['total_anggaran'] ?? 0);
			$totalRealisasi = (float)($existingData['total_realisasi'] ?? 0);
			$totalSisa = $totalAnggaran - $totalRealisasi;
			
			// Calculate percentages
			$realisasiPercent = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
			$sisaPercent = $totalAnggaran > 0 ? ($totalSisa / $totalAnggaran) * 100 : 0;
			
			$chartData = [
				'realisasi' => $totalRealisasi,
				'sisa' => $totalSisa,
				'total' => $totalAnggaran,
				'realisasi_percent' => $realisasiPercent,
				'sisa_percent' => $sisaPercent
			];
		}
		
		$data = [
			'title' => 'Belanja - Rekap',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'year' => $year,
			'tahapan' => $tahapan,
			'bulan' => $bulan,
			'existingData' => $existingData,
			'masterData' => null, // Not needed for direct search
			'chartData' => $chartData,
		];

		return view($this->theme->getThemePath() . '/tfk/belanja_rekap', $data);
	}

	/**
	 * Export Belanja Rekap to Excel
	 */
	public function belanjaRekapExportExcel()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
		$bulan = (int)($this->request->getGet('bulan') ?: 9);

		// Get data directly from tbl_belanja_input using tahun and bulan
		$existingData = $this->belanjaInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

		// Create Excel file using PhpSpreadsheet
		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		
		// Set headers
		$sheet->setCellValue('A1', 'REKAP BELANJA - ' . bulan_ke_str($bulan) . ' ' . $year);
		$sheet->setCellValue('A2', 'Tahapan: ' . ucfirst($tahapan));
		
		// Table headers
		$sheet->setCellValue('A4', 'Jenis Belanja');
		$sheet->setCellValue('B4', 'Anggaran (Rp)');
		$sheet->setCellValue('C4', 'Realisasi (Rp)');
		$sheet->setCellValue('D4', 'Realisasi (%)');
		$sheet->setCellValue('E4', 'Sisa Anggaran (Rp)');
		$sheet->setCellValue('F4', 'Sisa Anggaran (%)');

		// Data rows
		$rows = ['pegawai', 'barang_jasa', 'hibah', 'bansos', 'modal'];
		$labels = [
			'pegawai' => 'Belanja Pegawai',
			'barang_jasa' => 'Belanja Barang dan Jasa',
			'hibah' => 'Belanja Hibah',
			'bansos' => 'Belanja Bantuan Sosial',
			'modal' => 'Belanja Modal'
		];

		$row = 5;
		$totalAnggaran = 0;
		$totalRealisasi = 0;

		foreach ($rows as $key) {
			$anggaran = (float)($existingData[$key.'_anggaran'] ?? 0);
			$realisasi = (float)($existingData[$key.'_realisasi'] ?? 0);
			$sisa = $anggaran - $realisasi;
			$persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;
			$sisaPersen = $anggaran > 0 ? ($sisa / $anggaran) * 100 : 0;

			$sheet->setCellValue('A' . $row, $labels[$key]);
			$sheet->setCellValue('B' . $row, $anggaran);
			$sheet->setCellValue('C' . $row, $realisasi);
			$sheet->setCellValue('D' . $row, $persen);
			$sheet->setCellValue('E' . $row, $sisa);
			$sheet->setCellValue('F' . $row, $sisaPersen);

			$totalAnggaran += $anggaran;
			$totalRealisasi += $realisasi;
			$row++;
		}

		// Total row
		$totalSisa = $totalAnggaran - $totalRealisasi;
		$totalPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
		$totalSisaPersen = $totalAnggaran > 0 ? ($totalSisa / $totalAnggaran) * 100 : 0;

		$sheet->setCellValue('A' . $row, 'TOTAL');
		$sheet->setCellValue('B' . $row, $totalAnggaran);
		$sheet->setCellValue('C' . $row, $totalRealisasi);
		$sheet->setCellValue('D' . $row, $totalPersen);
		$sheet->setCellValue('E' . $row, $totalSisa);
		$sheet->setCellValue('F' . $row, $totalSisaPersen);

		// Set response headers
		$filename = 'Rekap_Belanja_' . bulan_ke_str($bulan) . '_' . $year . '.xlsx';
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	/**
	 * Export Belanja Rekap to PDF
	 */
	public function belanjaRekapExportPDF()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$tahapan = (string)($this->request->getGet('tahapan') ?: 'penetapan');
		$bulan = (int)($this->request->getGet('bulan') ?: 9);

		// Get data directly from tbl_belanja_input using tahun and bulan
		$existingData = $this->belanjaInputModel->getByTahunTahapanBulan($year, $tahapan, $bulan);

		// Create PDF using TCPDF
		$pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
		$pdf->SetCreator('Belanja Rekap System');
		$pdf->SetTitle('Rekap Belanja - ' . bulan_ke_str($bulan) . ' ' . $year);
		$pdf->SetHeaderData('', 0, 'REKAP BELANJA', 'Tahapan: ' . ucfirst($tahapan));
		$pdf->setHeaderFont(Array('helvetica', '', 12));
		$pdf->setFooterFont(Array('helvetica', '', 8));
		$pdf->SetMargins(15, 25, 15);
		$pdf->SetHeaderMargin(5);
		$pdf->SetFooterMargin(10);
		$pdf->SetAutoPageBreak(TRUE, 25);
		$pdf->AddPage();

		// Table data
		$rows = ['pegawai', 'barang_jasa', 'hibah', 'bansos', 'modal'];
		$labels = [
			'pegawai' => 'Belanja Pegawai',
			'barang_jasa' => 'Belanja Barang dan Jasa',
			'hibah' => 'Belanja Hibah',
			'bansos' => 'Belanja Bantuan Sosial',
			'modal' => 'Belanja Modal'
		];

		$html = '<table border="1" cellpadding="5">
			<tr style="background-color:#3b6ea8; color:white; font-weight:bold;">
				<th width="25%">Jenis Belanja</th>
				<th width="15%">Anggaran (Rp)</th>
				<th width="15%">Realisasi (Rp)</th>
				<th width="10%">Realisasi (%)</th>
				<th width="15%">Sisa Anggaran (Rp)</th>
				<th width="10%">Sisa Anggaran (%)</th>
			</tr>';

		$totalAnggaran = 0;
		$totalRealisasi = 0;

		foreach ($rows as $key) {
			$anggaran = (float)($existingData[$key.'_anggaran'] ?? 0);
			$realisasi = (float)($existingData[$key.'_realisasi'] ?? 0);
			$sisa = $anggaran - $realisasi;
			$persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;
			$sisaPersen = $anggaran > 0 ? ($sisa / $anggaran) * 100 : 0;

			$html .= '<tr>
				<td>' . $labels[$key] . '</td>
				<td align="right">' . number_format($anggaran, 0, ',', '.') . '</td>
				<td align="right">' . number_format($realisasi, 0, ',', '.') . '</td>
				<td align="right">' . number_format($persen, 2) . '%</td>
				<td align="right">' . number_format($sisa, 0, ',', '.') . '</td>
				<td align="right">' . number_format($sisaPersen, 2) . '%</td>
			</tr>';

			$totalAnggaran += $anggaran;
			$totalRealisasi += $realisasi;
		}

		// Total row
		$totalSisa = $totalAnggaran - $totalRealisasi;
		$totalPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
		$totalSisaPersen = $totalAnggaran > 0 ? ($totalSisa / $totalAnggaran) * 100 : 0;

		$html .= '<tr style="background-color:#3b6ea8; color:white; font-weight:bold;">
			<td>TOTAL</td>
			<td align="right">' . number_format($totalAnggaran, 0, ',', '.') . '</td>
			<td align="right">' . number_format($totalRealisasi, 0, ',', '.') . '</td>
			<td align="right">' . number_format($totalPersen, 2) . '%</td>
			<td align="right">' . number_format($totalSisa, 0, ',', '.') . '</td>
			<td align="right">' . number_format($totalSisaPersen, 2) . '%</td>
		</tr></table>';

		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output('Rekap_Belanja_' . bulan_ke_str($bulan) . '_' . $year . '.pdf', 'D');
	}
}


