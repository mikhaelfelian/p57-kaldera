<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TutorialSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Tutorial Dasar Sistem',
                'description' => 'Tutorial dasar untuk menggunakan sistem KALDERA ESDM',
                'type' => 'pdf',
                'file_name' => 'tutorial-dasar.pdf',
                'file_path' => WRITEPATH . 'uploads/tutorials/pdf/tutorial-dasar.pdf',
                'file_size' => 1024000,
                'status' => '1',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Panduan Upload Data',
                'description' => 'Video tutorial cara upload data ke sistem',
                'type' => 'video',
                'file_name' => 'panduan-upload.mp4',
                'file_path' => WRITEPATH . 'uploads/tutorials/video/panduan-upload.mp4',
                'file_size' => 5120000,
                'status' => '1',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('tutorials')->insertBatch($data);
    }
}
