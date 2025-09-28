<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <!-- Profile Card -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <div class="profile-avatar-container">
                        <?php if (!empty($user->avatar) && file_exists(FCPATH . $user->avatar)): ?>
                            <img class="profile-user-img img-fluid img-circle" 
                                 src="<?= base_url($user->avatar) ?>" 
                                 alt="User profile picture" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        <?php else: ?>
                            <div class="profile-user-img img-fluid img-circle bg-primary d-flex align-items-center justify-content-center" 
                                 style="width: 100px; height: 100px; font-size: 40px; color: white;">
                                <?= strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h3 class="profile-username text-center"><?= $user->first_name . ' ' . $user->last_name ?></h3>
                    <p class="text-muted text-center"><?= $user->email ?></p>
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#avatarModal">
                        <i class="fas fa-camera"></i> Ganti Avatar
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Akun</h3>
            </div>
            <div class="card-body">
                <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                <p class="text-muted"><?= $user->email ?></p>
                <hr>
                <strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
                <p class="text-muted"><?= $user->phone ?: 'Belum diisi' ?></p>
                <hr>
                <strong><i class="fas fa-building mr-1"></i> Perusahaan</strong>
                <p class="text-muted"><?= $user->company ?: 'Belum diisi' ?></p>
                <hr>
                <strong><i class="fas fa-calendar mr-1"></i> Terdaftar</strong>
                <p class="text-muted"><?= date('d F Y', strtotime($user->created_on)) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Profile Edit Form -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
            </div>
            <form id="profileForm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">Nama Depan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="first_name" name="first_name" 
                                       value="<?= $user->first_name ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Nama Belakang <span class="text-danger">*</span></label>
                                <input type="text" class="form-control rounded-0" id="last_name" name="last_name" 
                                       value="<?= $user->last_name ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control rounded-0" id="email" name="email" 
                                       value="<?= $user->email ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Telepon</label>
                                <input type="text" class="form-control rounded-0" id="phone" name="phone" 
                                       value="<?= $user->phone ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company">Perusahaan</label>
                        <input type="text" class="form-control rounded-0" id="company" name="company" 
                               value="<?= $user->company ?>">
                    </div>
                    <div class="form-group">
                        <label for="password">Password Baru (kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control rounded-0" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">Konfirmasi Password</label>
                        <input type="password" class="form-control rounded-0" id="password_confirm" name="password_confirm">
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah Password</h3>
            </div>
            <form id="changePasswordForm">
                <div class="card-body">
                    <div class="form-group">
                        <label for="current_password">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" class="form-control rounded-0" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password">Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control rounded-0" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control rounded-0" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning rounded-0">
                        <i class="fas fa-key"></i> Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Avatar Upload Modal -->
<div class="modal fade" id="avatarModal" tabindex="-1" role="dialog" aria-labelledby="avatarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="avatarModalLabel">Upload Avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="avatarForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="avatar">Pilih Foto</label>
                        <input type="file" class="form-control-file rounded-0" id="avatar" name="avatar" 
                               accept="image/*" required>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: JPG, PNG, GIF. Maksimal 2MB.
                        </small>
                    </div>
                    <div class="preview-container" style="display: none;">
                        <label>Preview:</label>
                        <div class="text-center">
                            <img id="avatarPreview" class="img-fluid img-circle" style="max-width: 150px; max-height: 150px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.profile-avatar-container {
    position: relative;
    display: inline-block;
}

.profile-user-img {
    border: 3px solid #adb5bd;
    transition: all 0.3s ease;
}

.profile-user-img:hover {
    border-color: #007bff;
    transform: scale(1.05);
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    
    // Profile form submit
    $('#profileForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            first_name: $('#first_name').val(),
            last_name: $('#last_name').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            company: $('#company').val(),
            password: $('#password').val(),
            password_confirm: $('#password_confirm').val()
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('profile/update') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Profile berhasil diperbarui'); }
                // Update display name
                $('.profile-username').text(formData.first_name + ' ' + formData.last_name);
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memperbarui profile'); }
                if(res.errors) {
                    Object.keys(res.errors).forEach(function(field) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).after('<div class="invalid-feedback">' + res.errors[field] + '</div>');
                    });
                }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal memperbarui profile'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal memperbarui profile'); }
            }
        });
    });
    
    // Change password form submit
    $('#changePasswordForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            current_password: $('#current_password').val(),
            new_password: $('#new_password').val(),
            confirm_password: $('#confirm_password').val()
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('profile/changePassword') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Password berhasil diubah'); }
                $('#changePasswordForm')[0].reset();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal mengubah password'); }
                if(res.errors) {
                    Object.keys(res.errors).forEach(function(field) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field).after('<div class="invalid-feedback">' + res.errors[field] + '</div>');
                    });
                }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal mengubah password'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal mengubah password'); }
            }
        });
    });
    
    // Avatar upload
    $('#avatarForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append(csrfTokenName, csrfHash);
        
        $.ajax({
            url: '<?= base_url('profile/uploadAvatar') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'Avatar berhasil diupload'); }
                    $('#avatarModal').modal('hide');
                    // Update avatar display
                    $('.profile-user-img').attr('src', res.avatar_url);
                    $('.profile-avatar-container').html('<img class="profile-user-img img-fluid img-circle" src="' + res.avatar_url + '" alt="User profile picture" style="width: 100px; height: 100px; object-fit: cover;">');
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mengupload avatar'); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupload avatar'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupload avatar'); }
                }
            }
        });
    });
    
    // Avatar preview
    $('#avatar').on('change', function(){
        var file = this.files[0];
        if(file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#avatarPreview').attr('src', e.target.result);
                $('.preview-container').show();
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Remove validation classes on input
    $('input, select, textarea').on('input change', function(){
        $(this).removeClass('is-invalid');
        $(this).next('.invalid-feedback').remove();
    });
    
    // Clear password fields when profile form is submitted
    $('#profileForm').on('submit', function(){
        $('#password, #password_confirm').val('');
    });
})();
</script>
<?= $this->endSection() ?>
