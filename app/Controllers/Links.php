<?php

namespace App\Controllers;

use App\Models\LinksModel;

class Links extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LinksModel();
        helper(['form']);
    }

    public function index()
    {
        $items = $this->model->where('tipe', 1)->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'title'      => 'Web GIS ESDM - Links',
            'Pengaturan' => $this->pengaturan,
            'user'       => $this->ionAuth->user()->row(),
            'items'      => $items,
        ];
        return view($this->theme->getThemePath() . '/links/index', $data);
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

        $this->model->insert([
            'name'       => $name,
            'links'      => $links,
            'keterangan' => $keterangan,
            'status'     => '1',
            'tipe'       => '1',
        ]);

        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('links'))->with('success', 'Link ditambahkan');
    }

    public function delete($id)
    {
        $id = (int)$id;
        $this->model->delete($id);
        return $this->request->isAJAX() ? $this->response->setJSON(['ok' => true]) : redirect()->to(base_url('links'))->with('success', 'Link dihapus');
    }
}


