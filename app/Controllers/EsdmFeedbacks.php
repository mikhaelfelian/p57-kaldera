<?php

namespace App\Controllers;

use App\Models\LinksModel;

class EsdmFeedbacks extends BaseController
{
    protected $model;
    protected $ionAuth;

    public function __construct()
    {
        $this->model = new LinksModel();
        helper(['form']);
    }

    public function index()
    {
        $items = $this->model->where('tipe', 2)->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'title'      => 'ESDM Feedbacks',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'items'      => $items,
        ];
        return view($this->theme->getThemePath() . '/esdm-feedbacks/index', $data);
    }

    public function store()
    {
        $name = trim((string)$this->request->getPost('name'));
        $links = trim((string)$this->request->getPost('links'));
        $keterangan = trim((string)$this->request->getPost('keterangan'));

        if ($name === '' || $links === '') {
            $msg = 'Nama dan Link wajib diisi';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

        $result = $this->model->insert([
            'name'       => $name,
            'links'      => $links,
            'keterangan' => $keterangan,
            'status'     => '1',
            'tipe'       => 2,
        ]);

        if ($result === false) {
            $errors = $this->model->errors();
            $dbError = method_exists($this, 'db') && $this->db ? $this->db->error() : [];
            $dbMsg = (!empty($dbError) && !empty($dbError['message'])) ? $dbError['message'] : '';
            $msgParts = [];
            if (!empty($errors)) { $msgParts[] = implode("\n", $errors); }
            if ($dbMsg !== '') { $msgParts[] = $dbMsg; }
            $msg = !empty($msgParts) ? implode("\n", $msgParts) : 'Gagal menyimpan data';
            return $this->request->isAJAX() ? $this->response->setJSON(['ok' => false, 'message' => $msg]) : redirect()->back()->with('error', $msg);
        }

        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('esdm-feedbacks'))->with('success', 'Link ditambahkan');
    }

    public function delete($id)
    {
        $id = (int)$id;
        $this->model->delete($id);
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('esdm-feedbacks'))->with('success', 'Link dihapus');
    }
}


