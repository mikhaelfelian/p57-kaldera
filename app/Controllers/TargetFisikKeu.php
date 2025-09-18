<?php

namespace App\Controllers;

use App\Models\TargetFisikKeuMasterModel;
use App\Models\TargetFisikKeuDetailModel;

class TargetFisikKeu extends BaseController
{
	protected $masterModel;
	protected $detailModel;

	public function __construct()
	{
		$this->masterModel = new TargetFisikKeuMasterModel();
		$this->detailModel = new TargetFisikKeuDetailModel();
	}

	public function index()
	{
		$year = (int)($this->request->getGet('year') ?: date('Y'));
		$items = $this->masterModel->orderBy('id', 'DESC')->findAll();
		$selectedId = (int)($this->request->getGet('master_id') ?: 0);
		if (!$selectedId && !empty($items)) {
			$selectedId = (int)$items[0]['id'];
		}
		$selectedMaster = null;
		$details = [];
		if ($selectedId) {
			$selectedMaster = $this->masterModel->find($selectedId);
			$rows = $this->detailModel
				->where('master_id', $selectedId)
				->where('tahun', $year)
				->findAll();
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

	public function input($id = null)
	{
		$master = null;
		$details = [];
		if ($id) {
			$master = $this->masterModel->find($id);
			if ($master) {
				$rows = $this->detailModel->where('master_id', $id)->findAll();
				foreach ($rows as $r) {
					$details[$r['bulan']] = $r;
				}
			}
		}

		$data = [
			'title' => 'Target Fisik & Keuangan - Input',
			'Pengaturan' => $this->pengaturan,
			'user' => $this->ionAuth->user()->row(),
			'master' => $master,
			'details' => $details,
		];

		return view($this->theme->getThemePath() . '/tfk/input', $data);
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
		$id = (int)$this->request->getPost('id');
		$masterId = (int)$this->request->getPost('master_id');
		$bulan = $this->request->getPost('bulan');
		$field = $this->request->getPost('field'); // fisik | keu
		$value = (float)$this->request->getPost('value');

		if (!$masterId || !in_array($bulan, ['jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des']) || !in_array($field, ['fisik','keu'])) {
			return $this->response->setJSON(['ok' => false, 'message' => 'Invalid params']);
		}

		// Upsert detail row
		$year = (int)$this->request->getPost('year') ?: (int)date('Y');
		$detail = $this->detailModel->where(['master_id' => $masterId, 'bulan' => $bulan, 'tahun' => $year])->first();
		if ($detail) {
			$detail[$field] = $value;
			$this->detailModel->update($detail['id'], $detail);
			$id = $detail['id'];
		} else {
			$id = $this->detailModel->insert([
				'master_id' => $masterId,
				'bulan' => $bulan,
				'tahun' => $year,
				$field => $value,
			]);
		}

		return $this->response->setJSON(['ok' => true, 'id' => $id, 'value' => $value]);
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
}


