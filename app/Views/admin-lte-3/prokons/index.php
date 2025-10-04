<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">PROGRES KONSULTASI</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3">Prokons</span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form method="get" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="font-weight-bold">Tahun</label>
                    <select name="year" class="form-control rounded-0" onchange="this.form.submit()">
                        <?php 
                        $currentYear = date('Y');
                        for($i = $currentYear - 5; $i <= $currentYear + 5; $i++): 
                        ?>
                        <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Bulan :</label>
                    <select name="bulan" class="form-control rounded-0" onchange="this.form.submit()">
                        <?php 
                        helper(['tanggalan']);
                        for($i = 1; $i <= 12; $i++): 
                        ?>
                        <option value="<?= $i ?>" <?= ($bulan == $i) ? 'selected' : '' ?>><?= bulan_ke_str($i) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </form>
        
        <div class="table-responsive rounded-0">
            <table class="table table-striped table-bordered rounded-0">
                <thead style="background-color: #3b6ea8; color: white;">
                    <tr>
                        <th class="text-center" style="vertical-align: middle; width: 35%;">Jenis Bantuan</th>
                        <th class="text-center" style="vertical-align: middle; width: 15%;">Upload Data</th>
                        <th class="text-center" style="vertical-align: middle; width: 20%;">Aksi</th>
                        <th class="text-center" style="vertical-align: middle; width: 30%;">Dokumen Administrasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Debug: Log categories data
                    log_message('debug', 'Categories data in view: ' . json_encode($categories));
                    foreach ($categories as $category): 
                        // Debug: Log each category
                        log_message('debug', 'Category: ' . $category['key'] . ', Data count: ' . count($category['data']));
                    ?>
                    <tr>
                        <td class="text-left" style="vertical-align: middle; padding-left: 15px;">
                            <strong><?= $category['nama'] ?></strong>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <?php if (empty($category['data'])): ?>
                                <button type="button" class="btn btn-success upload-data-btn" 
                                        data-jenis="<?= $category['key'] ?>" data-label="<?= $category['nama'] ?>"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-lock" style="color: white;"></i>
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-success upload-data-btn" 
                                        data-jenis="<?= $category['key'] ?>" data-label="<?= $category['nama'] ?>"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-check" style="color: white;"></i>
                                    <?php if ($category['data'][0]->file_name): ?>
                                    <div class="uploaded-filename" style="display: none; font-size: 8px; color: white; position: absolute; top: 50px; left: 10px; background: rgba(0,0,0,0.8); padding: 2px 4px; border-radius: 3px; z-index: 1000;">
                                        <?= $category['data'][0]->file_name ?>
                                    </div>
                                    <?php endif; ?>
                                </button>
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <?php if (!empty($category['data'])): ?>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-info btn-sm action-btn" 
                                            data-action="view" data-id="<?= $category['data'][0]->id ?>"
                                            style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-eye" style="color: white; font-size: 14px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-primary btn-sm action-btn" 
                                            data-action="download" data-id="<?= $category['data'][0]->id ?>"
                                            style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-download" style="color: white; font-size: 14px;"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm action-btn" 
                                            data-action="delete" data-id="<?= $category['data'][0]->id ?>"
                                            style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-trash" style="color: white; font-size: 14px;"></i>
                                    </button>
                                </div>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <?php if (!empty($category['data']) && $category['data'][0]->file_path_dok): ?>
                                <span class="dokumen-link">
                                    <a href="<?= $category['data'][0]->file_path_dok ?>" target="_blank" 
                                       style="color: #007bff; text-decoration: none;">
                                        <?= strlen($category['data'][0]->file_path_dok) > 30 ? 
                                            substr($category['data'][0]->file_path_dok, 0, 30) . '...' : 
                                            $category['data'][0]->file_path_dok ?>
                                    </a>
                                </span>
                            <?php elseif (!empty($category['data'])): ?>
                                <span class="text-muted">(input link aja)</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                            <button type="button" class="btn btn-warning btn-sm ml-2 edit-doc-link-btn" 
                                    data-jenis="<?= $category['key'] ?>" data-label="<?= $category['nama'] ?>"
                                    <?= !empty($category['data']) ? 'data-current-link="' . ($category['data'][0]->file_path_dok ?? '') . '"' : '' ?>
                                    style="width: 25px; height: 25px; display: inline-flex; align-items: center; justify-content: center; padding: 0;">
                                <i class="fas fa-pen" style="color: white; font-size: 10px;"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Data Modal -->
<div class="modal fade" id="uploadDataModal" tabindex="-1" role="dialog" aria-labelledby="uploadDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadDataModalLabel">Upload Data Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDataForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="jenis_bantuan" id="upload_jenis_bantuan">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Bantuan</label>
                        <input type="text" class="form-control rounded-0" id="upload_nama_bantuan" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File Data</label>
                        <input type="file" class="form-control-file rounded-0" name="file" accept=".pdf,.doc,.docx,.xlsx,.xls">
                        <small class="form-text text-muted">Format yang diperbolehkan: PDF, Word, Excel</small>
                        <div id="upload_result" class="mt-2" style="display: none;">
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> File berhasil diupload: <span id="uploaded_filename"></span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-0">
                        <i class="fas fa-upload"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Document Link Modal -->
<div class="modal fade" id="editDocLinkModal" tabindex="-1" role="dialog" aria-labelledby="editDocLinkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="editDocLinkModalLabel">Edit Dokumen Administrasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDocLinkForm">
                <div class="modal-body">
                    <input type="hidden" name="jenis_bantuan" id="doc_jenis_bantuan">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Bantuan</label>
                        <input type="text" class="form-control rounded-0" id="doc_nama_bantuan" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Link Dokumen</label>
                        <input type="url" class="form-control rounded-0" name="doc_link" id="doc_link_input" 
                               placeholder="https://example.com">
                        <small class="form-text text-muted">Masukkan URL lengkap dokumen administrasi</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-0">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Preview File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding: 0; position: relative;">
                <div id="previewLoading" style="display: none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 1000;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <iframe id="previewIframe" src="" style="width: 100%; height: 500px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="downloadPreviewBtn">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.upload-data-btn, .action-btn {
    transition: all 0.3s ease;
}

.upload-data-btn:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

.btn-info:hover, .action-btn[data-action="view"]:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
}

.btn-primary:hover, .action-btn[data-action="download"]:hover {
    background-color: #0069d9 !important;
    border-color: #0062cc !important;
}

.btn-danger:hover, .action-btn[data-action="delete"]:hover {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.uploaded-filename {
    white-space: nowrap;
    max-width: 200px;
    overflow: hidden;
    text-indent: overflow;
}

/* Preview Modal Styles */
#previewModal .modal-dialog {
    max-width: 90%;
    width: 90%;
}

#previewModal .modal-body {
    padding: 0;
    background: #f8f9fa;
}

#previewIframe {
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

#previewModal .modal-header {
    background: #3b6ea8;
    color: white;
    border-bottom: none;
}

#previewModal .modal-header .close {
    color: white;
    opacity: 0.8;
}

#previewModal .modal-header .close:hover {
    opacity: 1;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    
    // Upload Data button click
    $(document).on('click', '.upload-data-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('.modal-title').text('Upload Data ' + label);
        $('#upload_jenis_bantuan').val(jenis);
        $('#upload_nama_bantuan').val(label);
        $('#upload_result').hide();
        
        $('#uploadDataModal').modal('show');
    });
    
    // Edit Document Link button click
    $(document).on('click', '.edit-doc-link-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        var currentLink = $(this).data('current-link') || '';
        
        $('#doc_jenis_bantuan').val(jenis);
        $('#doc_nama_bantuan').val(label);
        $('#doc_link_input').val(currentLink);
        
        $('#editDocLinkModal').modal('show');
    });
    
    // Action buttons click
    $(document).on('click', '.action-btn', function(){
        var action = $(this).data('action');
        var id = $(this).data('id');
        
        switch(action) {
            case 'view':
                // Show preview modal
                var previewUrl = '<?= base_url('prokons/view') ?>/' + id + '?preview=1';
                $('#previewLoading').show();
                $('#previewIframe').attr('src', previewUrl);
                $('#downloadPreviewBtn').data('id', id);
                $('#previewModal').modal('show');
                break;
            case 'download':
                window.open('<?= base_url('prokons/view') ?>/' + id, '_blank');
                break;
            case 'delete':
                if(confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.post('<?= base_url('prokons/delete') ?>/' + id, {
                        [csrfTokenName]: csrfHash
                    }, function(res) {
                        if(res && res.csrf_hash) csrfHash = res.csrf_hash;
                        if(res && res.ok) {
                            if(window.toastr) toastr.success(res.message || 'Data berhasil dihapus');
                            location.reload();
                        } else {
                            if(window.toastr) toastr.error(res.message || 'Gagal menghapus data');
                        }
                    }, 'json').fail(function() {
                        if(window.toastr) toastr.error('Terjadi kesalahan');
                    });
                }
                break;
        }
    });
    
    // Upload Data form submit
    $('#uploadDataForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('tahun', <?= $tahun ?>);
        formData.append('bulan', <?= $bulan ?>);
        formData.append(csrfTokenName, csrfHash);
        
        $.ajax({
            url: '<?= base_url('prokons/upload-data') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if(res && res.csrf_hash) csrfHash = res.csrf_hash;
                if(res && res.ok) {
                    if(res.filename) {
                        $('#uploaded_filename').text(res.filename);
                        $('#upload_result').show();
                    }
                    if(window.toastr) toastr.success(res.message || 'File berhasil diupload');
                    $('#uploadDataModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    if(window.toastr) toastr.error(res.message || 'Gagal mengupload file');
                }
            },
            error: function(xhr) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash) csrfHash = data.csrf_hash;
                    if(window.toastr) toastr.error(data.message || 'Gagal mengupload file');
                } catch(e) {
                    if(window.toastr) toastr.error('Gagal mengupload file');
                }
            }
        });
    });
    
    // Edit Document Link form submit
    $('#editDocLinkForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = $(this).serialize();
        formData += '&tahun=' + <?= $tahun ?> + '&bulan=' + <?= $bulan ?> + '&' + csrfTokenName + '=' + csrfHash;
        
        console.log('Submitting doc link form with data:', formData);
        
        $.post('<?= base_url('prokons/save-doc-link') ?>', formData, function(res) {
            console.log('Doc link response:', res);
            if(res && res.csrf_hash) csrfHash = res.csrf_hash;
            if(res && res.ok) {
                if(window.toastr) toastr.success(res.message || 'Link dokumen berhasil disimpan');
                $('#editDocLinkModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr) toastr.error(res.message || 'Gagal menyimpan link dokumen');
            }
        }, 'json').fail(function(xhr) {
            try {
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash) csrfHash = data.csrf_hash;
                if(window.toastr) toastr.error(data.message || 'Gagal menyimpan link dokumen');
            } catch(e) {
                if(window.toastr) toastr.error('Gagal menyimpan link dokumen');
            }
        });
    });
    
    // Download button in preview modal
    $(document).on('click', '#downloadPreviewBtn', function(){
        var id = $(this).data('id');
        if(id) {
            window.open('<?= base_url('prokons/view') ?>/' + id, '_blank');
        }
    });
    
    // Clear iframe when modal is hidden
    $('#previewModal').on('hidden.bs.modal', function () {
        $('#previewIframe').attr('src', '');
        $('#previewLoading').hide();
    });
    
    // Hide loading when iframe loads
    $('#previewIframe').on('load', function() {
        $('#previewLoading').hide();
    });
})();
</script>
<?= $this->endSection() ?>
