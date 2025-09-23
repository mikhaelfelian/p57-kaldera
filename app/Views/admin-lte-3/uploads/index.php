<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header rounded-0">
                <h3 class="card-title mb-0">Upload Laporan</h3>
            </div>
            <div class="card-body">
                <?= form_open_multipart('uploads/store', ['id' => 'uploadForm', 'class' => 'mb-3']) ?>
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="name">Nama Laporan</label>
                        <input type="text" id="name" name="name" class="form-control rounded-0" placeholder="Nama laporan" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" rows="3" class="form-control rounded-0" placeholder="Keterangan laporan"></textarea>
                    </div>
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-6">
                            <label for="file">File</label>
                            <input type="file" id="file" name="file" class="form-control-file" required>
                            <div class="small text-muted mt-1">PDF/Excel/Word/Gambar diperbolehkan</div>
                            <div class="progress mt-2" style="height:6px; display:none;">
                                <div class="progress-bar bg-success" role="progressbar" style="width:0%"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <button type="submit" class="btn btn-success rounded-0">Upload</button>
                        </div>
                    </div>
                <?= form_close() ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped rounded-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width:30%">Nama</th>
                                <th style="width:30%">Keterangan</th>
                                <th style="width:20%">Dibuat</th>
                                <th class="text-center" style="width:20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): foreach ($items as $row): ?>
                                <tr>
                                    <td><?= esc($row['name']) ?></td>
                                    <td><?= esc($row['keterangan']) ?></td>
                                    <td><?= esc($row['created_at']) ?></td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary rounded-0" href="<?= base_url('uploads/preview/' . $row['id']) ?>" target="_blank" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-sm btn-info rounded-0" href="<?= base_url('uploads/download/' . $row['id']) ?>" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger rounded-0 btn-delete" data-id="<?= $row['id'] ?>" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Belum ada data</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <iframe id="previewFrame" src="" style="width: 100%; height: 520px; border: 0;" class="rounded-0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(function(){
    const $form = $('#uploadForm');
    const $progress = $form.find('.progress');
    const $bar = $progress.find('.progress-bar');

    $form.on('submit', function(e){
        e.preventDefault();
        const formData = new FormData(this);
        $progress.show();
        $bar.css('width','0%');
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            xhr: function(){
                const xhr = $.ajaxSettings.xhr();
                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', function(ev){
                        if (ev.lengthComputable) {
                            const percent = Math.round((ev.loaded / ev.total) * 100);
                            $bar.css('width', percent + '%');
                        }
                    }, false);
                }
                return xhr;
            },
            success: function(res){
                if (res && res.ok) { toastr.success(res.message || 'Berhasil'); window.location.reload(); }
                else { toastr.error(res && res.message ? res.message : 'Gagal menyimpan'); }
            },
            error: function(){ toastr.error('Terjadi kesalahan'); },
            complete: function(){ setTimeout(function(){ $progress.hide(); }, 600); }
        });
    });

    $(document).on('click', '.btn-delete', function(){
        const id = $(this).data('id');
        const proceed = function(){
            $.post('<?= base_url('uploads/delete') ?>/' + id, {<?= json_encode(csrf_token()) ?>: '<?= csrf_hash() ?>'}, function(res){
                if (res && res.ok) { toastr.success('Data dihapus'); window.location.reload(); } else { toastr.error('Gagal menghapus'); }
            }).fail(function(){ toastr.error('Gagal menghapus'); });
        };
        if (window.Swal) { Swal.fire({ title: 'Hapus data?', text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' }).then(r => { if (r.isConfirmed) proceed(); }); }
        else { if (confirm('Hapus data?')) proceed(); }
    });
});
</script>
<?= $this->endSection() ?>


