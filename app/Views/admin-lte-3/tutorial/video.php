<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between align-items-center rounded-0">
                <div>
                    <span class="mr-2">Tambah Tutorial Video</span>
                </div>
                <div class="text-right small">
                    <strong><?= esc($user->first_name ?? '') ?></strong>
                </div>
            </div>
            <div class="card-body">
                <?php if (empty($hasLimit)): ?>
                <?= form_open('tutorial/store', ['id' => 'tutorialForm', 'class' => 'mb-3', 'enctype' => 'multipart/form-data']) ?>
                    <?= csrf_field() ?>
                    <input type="hidden" name="type" value="video">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Judul Tutorial</label>
                            <input type="text" id="title" name="title" class="form-control rounded-0" placeholder="Judul Tutorial Video" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="files">File Video</label>
                            <input type="file" id="files" name="files[]" class="form-control-file rounded-0" accept=".mp4,.avi,.mov,.wmv" multiple>
                            <small class="form-text text-muted">Bisa pilih banyak file sekaligus (opsional). Format: MP4, AVI, MOV, WMV (Maks 100MB per file)</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control rounded-0" rows="3" placeholder="Deskripsi tutorial..."></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="link_url">Atau Link YouTube (opsional)</label>
                            <input type="url" id="link_url" name="link_url" class="form-control rounded-0" placeholder="https://www.youtube.com/watch?v=...">
                            <small class="form-text text-muted">Isi link YouTube jika tidak mengupload file video.</small>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success rounded-0">
                        <i class="fas fa-upload"></i> Upload Tutorial
                    </button>
                <?= form_close() ?>
                <?php else: ?>
                    <div class="alert alert-info rounded-0 mb-3">Data tutorial video sudah ada. Hanya diperbolehkan 1 data.</div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped rounded-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width:30%">Judul</th>
                                <th style="width:25%">File</th>
                                <th style="width:15%">Ukuran</th>
                                <th style="width:15%">Dibuat</th>
                                <th class="text-center" style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($tutorials)): foreach ($tutorials as $row): ?>
                                <tr>
                                    <td>
                                        <strong><?= esc($row->title) ?></strong>
                                        <?php if (!empty($row->description)): ?>
                                            <br><small class="text-muted"><?= esc($row->description) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($row->link_url)): ?>
                                            <i class="fab fa-youtube text-danger"></i>
                                            <span>Link YouTube</span>
                                        <?php else: ?>
                                            <i class="fas fa-video text-primary"></i>
                                            <?= esc($row->file_name) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= !empty($row->file_size) ? $model->formatFileSize($row->file_size) : '-' ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($row->created_at)) ?></td>
                                    <td class="text-center">
                                        <a href="<?= base_url('tutorial/preview/' . $row->id) ?>" class="btn btn-sm btn-info rounded-0" target="_blank">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        <a href="<?= base_url('tutorial/download/' . $row->id) ?>" class="btn btn-sm btn-success rounded-0">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger rounded-0 btn-delete" data-id="<?= $row->id ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada tutorial video</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(function(){
    const $form = $('#tutorialForm');
    $form.on('submit', function(e){
        e.preventDefault();
        
        // Validate file size (100MB max per file) if files chosen
        const fileInput = document.getElementById('files');
        const linkUrl = $('#link_url').val().trim();
        if ((!fileInput.files || fileInput.files.length === 0) && linkUrl === '') {
            toastr.error('Pilih file video atau isi link YouTube');
            return;
        }
        if (fileInput.files && fileInput.files.length > 0) {
            for (let i = 0; i < fileInput.files.length; i++) {
                if (fileInput.files[i].size > 100 * 1024 * 1024) {
                    toastr.error('Ukuran file maksimal 100MB per file');
                    return;
                }
            }
        }
        
        const formData = new FormData($form[0]);
        // The form already has CSRF token from <?= csrf_field() ?>
        // Just append the files
        for (let i = 0; i < fileInput.files.length; i++) {
            formData.append('files[]', fileInput.files[i]);
        }
        // append link if provided (already in form, but override if filled)
        if (linkUrl) formData.set('link_url', linkUrl);
        $.ajax({
            url: '<?= base_url('tutorial/store') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if (res && res.ok) { 
                    toastr.success('Tutorial Video berhasil diupload' + (res.count ? ' ('+res.count+' file)' : '')); 
                    window.location.reload(); 
                } else { 
                    toastr.error(res && res.message ? res.message : 'Gagal mengupload tutorial'); 
                }
            },
            error: function(xhr, status, error){
                console.error('Upload error:', xhr.responseText);
                toastr.error('Terjadi kesalahan saat mengupload: ' + error);
            }
        });
    });

    $(document).on('click', '.btn-delete', function(){
        const id = $(this).data('id');
        const proceed = function(){
            $.post('<?= base_url('tutorial/delete') ?>/' + id, {<?= json_encode(csrf_token()) ?>: '<?= csrf_hash() ?>'}, function(res){
                if (res && res.ok) { 
                    toastr.success('Tutorial dihapus'); 
                    window.location.reload(); 
                } else { 
                    toastr.error('Gagal menghapus tutorial'); 
                }
            }).fail(function(){ 
                toastr.error('Gagal menghapus tutorial'); 
            });
        };
        
        if (window.Swal) { 
            Swal.fire({ 
                title: 'Hapus Tutorial?', 
                text: 'Tindakan ini tidak dapat dibatalkan.', 
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonText: 'Ya, hapus', 
                cancelButtonText: 'Batal' 
            }).then(r => { 
                if (r.isConfirmed) proceed(); 
            }); 
        } else { 
            if (confirm('Hapus tutorial?')) proceed(); 
        }
    });
});
</script>
<?= $this->endSection() ?>
