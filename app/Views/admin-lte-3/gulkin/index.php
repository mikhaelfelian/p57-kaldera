<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between align-items-center rounded-0">
                <div>
                    <span class="mr-2">Metode : <em>Upload manual</em></span>
                </div>
                <div class="text-right small">
                    <strong><?= esc($user->first_name ?? '') ?></strong>
                </div>
            </div>
            <div class="card-body">
                <?= form_open_multipart('gulkin/store', ['id' => 'gulkinForm', 'class' => 'mb-3']) ?>
                    <?= csrf_field() ?>
                    <div class="form-row align-items-end">
                        <div class="form-group col-md-2">
                            <label for="year">Tahun</label>
                            <input type="number" id="year" name="year" class="form-control rounded-0" value="<?= esc($year) ?>" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="month">Bulan</label>
                            <select id="month" name="month" class="form-control rounded-0" required>
                                <?php for ($m = 1; $m <= 12; $m++): ?>
                                    <option value="<?= $m ?>" <?= (date('n') == $m ? 'selected' : '') ?>><?= bulan_ke_str($m) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="uraian">Uraian</label>
                            <input type="text" id="uraian" name="uraian" class="form-control rounded-0" placeholder="Monitoring Progres Gulkin" required>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="fupload">Upload (PDF/Excel)</label>
                            <input type="file" id="fupload" name="fupload" accept=".pdf,.xls,.xlsx,.csv" class="form-control-file">
                            <div class="progress mt-2" style="height:6px; display:none;">
                                <div class="progress-bar bg-success" role="progressbar" style="width:0%"></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success rounded-0">Simpan</button>
                <?= form_close() ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped rounded-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th class="text-center" style="width:10%">Bulan</th>
                                <th style="width:40%">Uraian</th>
                                <th class="text-center" style="width:20%">Upload Data</th>
                                <th class="text-center" style="width:30%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): foreach ($items as $row): ?>
                                <tr>
                                    <td class="text-center"><small><?= bulan_ke_str((int)($row['month'] ?? 1)) ?></small></td>
                                    <td>
                                        <div><?= esc($row['uraian']) ?></div>
                                    </td>
                                    <td class="text-center">
                                        <?php if (!empty($row['fupload'])): ?>
                                            <span class="badge badge-success">Sudah Upload</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary">Belum Ada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-sm btn-primary rounded-0" href="<?= base_url('gulkin/preview/' . $row['id']) ?>" target="_blank" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-sm btn-info rounded-0" href="<?= base_url('gulkin/download/' . $row['id']) ?>" title="Cetak / Download">
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
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(function(){
    const $form = $('#gulkinForm');
    const $progress = $form.find('.progress');
    const $bar = $progress.find('.progress-bar');

    $form.on('submit', function(e){
        e.preventDefault();
        
        // Validate form
        if (!$form[0].checkValidity()) {
            $form[0].reportValidity();
            return false;
        }
        
        const formData = new FormData(this);
        $progress.show();
        $bar.css('width','0%');
        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
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
                try {
                    if (typeof res === 'string') {
                        res = JSON.parse(res);
                    }
                    if (res && res.ok) { 
                        if (window.toastr) { toastr.success(res.message || 'Berhasil'); }
                        window.location.reload(); 
                    } else { 
                        if (window.toastr) { toastr.error(res && res.message ? res.message : 'Gagal menyimpan'); }
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    if (window.toastr) { toastr.error('Gagal menyimpan'); }
                }
            },
            error: function(xhr, status, error){
                console.error('AJAX Error:', status, error);
                if (window.toastr) { toastr.error('Terjadi kesalahan'); }
            },
            complete: function(){ setTimeout(function(){ $progress.hide(); }, 600); }
        });
    });

    $(document).on('click', '.btn-delete', function(){
        const id = $(this).data('id');
        const proceed = function(){
            $.ajax({
                url: '<?= base_url('gulkin/delete') ?>/' + id,
                method: 'POST',
                data: {
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                },
                headers: {'X-Requested-With': 'XMLHttpRequest'},
                dataType: 'json',
                success: function(res){ 
                    try {
                        if (typeof res === 'string') {
                            res = JSON.parse(res);
                        }
                        if (res && res.ok) { 
                            if (window.toastr) { toastr.success('Data dihapus'); }
                            window.location.reload(); 
                        } else { 
                            if (window.toastr) { toastr.error('Gagal menghapus'); }
                        }
                    } catch (e) {
                        console.error('Error parsing delete response:', e);
                        if (window.toastr) { toastr.error('Gagal menghapus'); }
                    }
                },
                error: function(xhr, status, error){
                    console.error('Delete AJAX Error:', status, error);
                    if (window.toastr) { toastr.error('Gagal menghapus'); }
                }
            });
        };
        if (window.Swal) { Swal.fire({ title: 'Hapus data?', text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' }).then(r => { if (r.isConfirmed) proceed(); }); }
        else { if (confirm('Hapus data?')) proceed(); }
    });
});
</script>
<?= $this->endSection() ?>


