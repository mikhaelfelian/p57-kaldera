<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex justify-content-between align-items-center rounded-0">
                <div>
                    <span class="mr-2">Tambah Link ESDM Feedback</span>
                </div>
                <div class="text-right small">
                    <strong><?= esc($user->first_name ?? '') ?></strong>
                </div>
            </div>
            <div class="card-body">
                <?= form_open('esdm-feedbacks/store', ['id' => 'esdmForm', 'class' => 'mb-3']) ?>
                    <?= csrf_field() ?>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control rounded-0" placeholder="Nama Link" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="links">URL</label>
                            <input type="url" id="links" name="links" class="form-control rounded-0" placeholder="https://domain" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="keterangan">Keterangan</label>
                            <input type="text" id="keterangan" name="keterangan" class="form-control rounded-0" placeholder="Keterangan">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success rounded-0">Simpan</button>
                <?= form_close() ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped rounded-0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th style="width:25%">Nama</th>
                                <th style="width:35%">URL</th>
                                <th style="width:20%">Dibuat</th>
                                <th class="text-center" style="width:20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($items)): foreach ($items as $row): ?>
                                <tr>
                                    <td><?= esc($row['name']) ?></td>
                                    <td><a href="<?= esc($row['links']) ?>" target="_blank"><?= esc($row['links']) ?></a></td>
                                    <td><?= esc($row['created_at']) ?></td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-primary rounded-0 btn-preview" data-url="<?= esc($row['links']) ?>">
                                            <i class="fas fa-eye"></i> Preview
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger rounded-0 btn-delete" data-id="<?= $row['id'] ?>">
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

        <div class="card rounded-0">
            <div class="card-header rounded-0">
                <h3 class="card-title mb-0">Preview</h3>
            </div>
            <div class="card-body p-0">
                <iframe id="previewFrame" src="" style="width: 100%; height: 520px; border: 0;" class="rounded-0"></iframe>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(function(){
    const $form = $('#esdmForm');
    $form.on('submit', function(e){
        e.preventDefault();
        $.post($form.attr('action'), $form.serialize(), function(res){
            if (res && res.ok) { toastr.success('Link ditambahkan'); window.location.reload(); }
            else { toastr.error(res && res.message ? res.message : 'Gagal menyimpan'); }
        }).fail(function(){ toastr.error('Terjadi kesalahan'); });
    });

    $(document).on('click', '.btn-preview', function(){
        const url = $(this).data('url');
        $('#previewFrame').attr('src', url);
    });

    $(document).on('click', '.btn-delete', function(){
        const id = $(this).data('id');
        const proceed = function(){
            $.post('<?= base_url('esdm-feedbacks/delete') ?>/' + id, {<?= json_encode(csrf_token()) ?>: '<?= csrf_hash() ?>'}, function(res){
                if (res && res.ok) { toastr.success('Link dihapus'); window.location.reload(); } else { toastr.error('Gagal menghapus'); }
            }).fail(function(){ toastr.error('Gagal menghapus'); });
        };
        if (window.Swal) { Swal.fire({ title: 'Hapus link?', text: 'Tindakan ini tidak dapat dibatalkan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal' }).then(r => { if (r.isConfirmed) proceed(); }); }
        else { if (confirm('Hapus link?')) proceed(); }
    });
});
</script>
<?= $this->endSection() ?>


