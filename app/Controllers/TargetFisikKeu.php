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

	public function index($masterId = null)
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$items = $this->masterModel->orderBy('id', 'DESC')->findAll();
		$selectedId = (int)($masterId ?: $this->request->getGet('master_id') ?: 0);
		if (!$selectedId && !empty($items)) {
			$selectedId = (int)$items[0]['id'];
		}
		$selectedMaster = null;
		$details = [];
		if ($selectedId) {
			$selectedMaster = $this->masterModel->find($selectedId);
			$rows = $this->fiskalModel->getByMasterTipeYear($selectedId, '1', $year);
			foreach ($rows as $r) {
				$details[$r['bulan']] = $r;
			}
		}
		$data = [
			'title' => 'Target Fisik & Keuangan - Data',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'items' => $items,
			'year' => $year,
			'masterId' => $selectedId,
			'selectedMaster' => $selectedMaster,
			'details' => $details,
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
		// Disable CSRF for this method only
		$config = config('App');
		$originalCSRF = $config->CSRFProtection;
		$config->CSRFProtection = false;
		
		try {
			
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
			
			if (!in_array($field, ['fisik','keu'])) {
				return $this->response->setJSON(['ok' => false, 'message' => 'Invalid field: ' . $field]);
			}

			// Map field names to database columns
			$fieldMap = [
				'fisik' => 'target_fisik',
				'keu' => 'target_keuangan'
			];

			$dbField = $fieldMap[$field] ?? $field;

			// Get existing record or create new one
			$existing = $this->fiskalModel->where([
				'master_id' => $masterId,
				'tipe' => '1',
				'tahun' => $year,
				'bulan' => $bulan
			])->first();

			$data = [
				$dbField => $value
			];

			if ($existing) {
				// Update existing record
				$this->fiskalModel->skipValidation(true);
				$result = $this->fiskalModel->update($existing['id'], $data);
				$id = $existing['id'];
				log_message('debug', 'Updated fiskal record: ' . $result);
			} else {
				// Create new record
				$data['master_id'] = $masterId;
				$data['tipe'] = '1';
				$data['tahun'] = $year;
				$data['bulan'] = $bulan;
				$this->fiskalModel->skipValidation(true);
				$id = $this->fiskalModel->insert($data);
				log_message('debug', 'Inserted fiskal record with ID: ' . $id);
			}

			// Update deviation calculations
			if ($id) {
				$this->fiskalModel->updateDeviations($id);
			}

			return $this->response->setJSON(['ok' => true, 'id' => $id, 'value' => $value]);
		} catch (\Exception $e) {
			log_message('error', 'updateCell error: ' . $e->getMessage());
			log_message('error', 'updateCell stack trace: ' . $e->getTraceAsString());
			return $this->response->setJSON(['ok' => false, 'message' => 'Server error: ' . $e->getMessage()]);
		} finally {
			// Restore original CSRF setting
			$config->CSRFProtection = $originalCSRF;
		}
	}

	public function rekap()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$masterId = (int)($this->request->getGet('master_id') ?: 0);
		
		$masters = $this->masterModel->orderBy('id', 'DESC')->findAll();
		$selectedMaster = null;
		$details = [];
		$chartData = [];
		
		if ($masterId) {
			$selectedMaster = $this->masterModel->find($masterId);
			if ($selectedMaster) {
				$rows = $this->detailModel
					->where('master_id', $masterId)
					->where('tahun', $year)
					->orderBy('bulan', 'ASC')
					->findAll();
				
				foreach ($rows as $r) {
					$details[$r['bulan']] = $r;
				}
				
				// Prepare chart data
				$months = ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des'];
				$monthNames = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
				
				foreach ($months as $i => $month) {
					$d = $details[$month] ?? [];
					$chartData[] = [
						'month' => $monthNames[$i],
						'target_fisik' => (float)($d['fisik'] ?? 0),
						'realisasi_fisik' => (float)($d['realisasi_fisik'] ?? 0),
						'target_keu' => (float)($d['keu'] ?? 0),
						'realisasi_keu' => (float)($d['keu_real'] ?? 0)
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


