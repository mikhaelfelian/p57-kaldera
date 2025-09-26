<?php

namespace App\Controllers;

use App\Models\TargetFisikKeuMasterModel;
use App\Models\TargetFisikKeuDetailModel;
use App\Models\FiskalModel;

class TargetFisikKeu extends BaseController
{
	protected $masterModel;
	protected $detailModel;
	protected $fiskalModel;

	public function __construct()
	{
		$this->masterModel = new TargetFisikKeuMasterModel();
		$this->detailModel = new TargetFisikKeuDetailModel();
		$this->fiskalModel = new FiskalModel();
	}

    /**
     * Input manual page (static layout with tahapan dropdown)
     */
    public function input($masterId = null)
    {
        $year = (int)($this->request->getGet('year') ?: date('Y'));
        $tahapan = (string)($this->request->getGet('tahapan') ?: 'Penetapan APBD');

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
			$value = (float)$this->request->getPost('value');
			$year = (int)$this->request->getPost('year') ?: (int)date('Y');

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
				'bulan' => $bulan
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
        $masterId = (int)($this->request->getGet('master_id') ?: 0);

        $masters = $this->masterModel->orderBy('id', 'DESC')->findAll();
        if (!$masterId && !empty($masters)) {
            $masterId = (int)$masters[0]['id'];
        }

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
            'masters' => $masters,
            'selectedMaster' => $selectedMaster,
            'masterId' => $masterId,
            'year' => $year,
            'details' => $details,
            'chartData' => $chartData,
        ];

        return view($this->theme->getThemePath() . '/tfk/rekap', $data);
	}

	public function master()
	{
		$items = $this->masterModel->orderBy('id', 'DESC')->findAll();
		$data = [
			'title' => 'TFK - Master Data',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'items' => $items,
		];
		return view($this->theme->getThemePath() . '/tfk/master', $data);
	}

	public function masterStore()
	{
		$nama = trim((string)$this->request->getPost('nama'));
		$tahapan = trim((string)$this->request->getPost('tahapan'));
		if ($nama === '') {
			return redirect()->back()->with('error', 'Nama wajib diisi');
		}
		$this->masterModel->insert([
			'nama' => $nama,
			'tahapan' => $tahapan,
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
}


