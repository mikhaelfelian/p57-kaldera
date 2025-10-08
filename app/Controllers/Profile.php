<?php

namespace App\Controllers;

class Profile extends BaseController
{
    protected $ionAuth;
    
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function index()
    {
        $user = $this->ionAuth->user()->row();
        
        $data = [
            'title' => 'Profile',
            'user' => $user
        ];

        return $this->view($this->theme->getThemePath() . '/profile/index', $data);
    }

    public function update()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $user = $this->ionAuth->user()->row();
        if (!$user) {
            return $this->response->setJSON(['ok' => false, 'message' => 'User not found']);
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required|min_length[2]|max_length[50]',
            'last_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|max_length[100]',
            'phone' => 'permit_empty|min_length[10]|max_length[20]',
            'username' => 'permit_empty|min_length[3]|max_length[100]',
            'company' => 'required|min_length[3]|max_length[100]',
            'password' => 'permit_empty|min_length[6]',
            'password_confirm' => 'matches[password]'
        ], [
            'first_name' => [
                'required' => 'Nama depan harus diisi',
                'min_length' => 'Nama depan minimal 2 karakter',
                'max_length' => 'Nama depan maksimal 50 karakter'
            ],
            'last_name' => [
                'required' => 'Nama belakang harus diisi',
                'min_length' => 'Nama belakang minimal 2 karakter',
                'max_length' => 'Nama belakang maksimal 50 karakter'
            ],
            'email' => [
                'required' => 'Email harus diisi',
                'valid_email' => 'Format email tidak valid',
                'max_length' => 'Email maksimal 100 karakter'
            ],
            'phone' => [
                'min_length' => 'Nomor telepon minimal 10 digit',
                'max_length' => 'Nomor telepon maksimal 20 digit'
            ],
            'username' => [
                'min_length' => 'Username minimal 3 karakter',
                'max_length' => 'Username maksimal 100 karakter'
            ],
            'company' => [
                'required' => 'NIP harus diisi',
                'min_length' => 'NIP minimal 3 karakter',
                'max_length' => 'NIP maksimal 100 karakter'
            ],
            'password' => [
                'min_length' => 'Password minimal 6 karakter'
            ],
            'password_confirm' => [
                'matches' => 'Konfirmasi password tidak cocok'
            ]
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Validasi gagal',
                'errors' => $validation->getErrors(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }

        try {
            $data = [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
                'email' => $this->request->getPost('email'),
                'phone' => $this->request->getPost('phone') ?: '',
                'username' => $this->request->getPost('username'),
                'company' => $this->request->getPost('company') ?: ''
            ];

            // Check if email is being changed
            if ($data['email'] !== $user->email) {
                // Check if new email already exists
                $existingUser = $this->ionAuth->where('email', $data['email'])->users()->row();
                if ($existingUser && $existingUser->id != $user->id) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'message' => 'Email sudah digunakan oleh user lain',
                        'csrf_token' => csrf_token(),
                        'csrf_hash' => csrf_hash()
                    ]);
                }
            }

            // Check if company (NIP) is being changed
            if ($data['company'] !== $user->company) {
                // Check if new company (NIP) already exists
                $existingUser = $this->ionAuth->where('company', $data['company'])->users()->row();
                if ($existingUser && $existingUser->id != $user->id) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'message' => 'NIP sudah digunakan oleh user lain',
                        'csrf_token' => csrf_token(),
                        'csrf_hash' => csrf_hash()
                    ]);
                }
            }

            // Update password if provided
            if ($this->request->getPost('password')) {
                $data['password'] = $this->request->getPost('password');
            }

            // Update user data
            $this->ionAuth->update($user->id, $data);

            return $this->response->setJSON([
                'ok' => true,
                'message' => 'Profile berhasil diperbarui',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal memperbarui profile: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }


    public function uploadAvatar()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['ok' => false, 'message' => 'Invalid request']);
        }

        $user = $this->ionAuth->user()->row();
        if (!$user) {
            return $this->response->setJSON(['ok' => false, 'message' => 'User not found']);
        }

        try {
            $file = $this->request->getFile('avatar');
            
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validate file type
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'message' => 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF',
                        'csrf_token' => csrf_token(),
                        'csrf_hash' => csrf_hash()
                    ]);
                }

                // Validate file size (max 2MB)
                if ($file->getSize() > 2097152) {
                    return $this->response->setJSON([
                        'ok' => false,
                        'message' => 'Ukuran file terlalu besar. Maksimal 2MB',
                        'csrf_token' => csrf_token(),
                        'csrf_hash' => csrf_hash()
                    ]);
                }

                // Create upload directory if not exists
                $uploadPath = FCPATH . '/file/profile/';
                if (!is_dir($uploadPath)) {
                    if (!mkdir($uploadPath, 0755, true)) {
                        return $this->response->setJSON([
                            'ok' => false,
                            'message' => 'Gagal membuat direktori upload',
                            'csrf_token' => csrf_token(),
                            'csrf_hash' => csrf_hash()
                        ]);
                    }
                }

                // Delete old avatar if exists
                if ($user->profile && file_exists(FCPATH . $user->profile)) {
                    unlink(FCPATH . $user->profile);
                }

                // Generate new filename
                $newName = 'avatar_' . $user->id . '_' . time() . '.' . $file->getExtension();
                $file->move($uploadPath, $newName);

                // Update user avatar
                $avatarPath = 'file/profile/' . $newName;
                $this->ionAuth->update($user->id, ['profile' => $avatarPath]);
                
                // Log for debugging
                log_message('debug', 'Avatar uploaded: ' . $avatarPath);

                return $this->response->setJSON([
                    'ok' => true,
                    'message' => 'Avatar berhasil diupload',
                    'avatar_url' => base_url($avatarPath),
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            } else {
                return $this->response->setJSON([
                    'ok' => false,
                    'message' => 'File tidak valid',
                    'csrf_token' => csrf_token(),
                    'csrf_hash' => csrf_hash()
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'ok' => false,
                'message' => 'Gagal mengupload avatar: ' . $e->getMessage(),
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash()
            ]);
        }
    }
}