<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $triwulanList = [
        1 => 'Triwulan I',
        2 => 'Triwulan II',
        3 => 'Triwulan III',
        4 => 'Triwulan IV'
    ];
    
    $existing = $existingData ?? [];
    $indikatorList = $indikatorList ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">INPUT INDIKATOR</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3">Input</span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form method="get" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="font-weight-bold">Tahun</label>
                    <select name="year" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                        <?php 
                        $currentYear = date('Y');
                        for($i = $currentYear - 5; $i <= $currentYear + 5; $i++): 
                        ?>
                        <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Triwulan</label>
                    <select name="triwulan" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                        <?php foreach ($triwulanList as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($triwulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
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
                        <th style="width: 200px; vertical-align: middle;" rowspan="2">Indikator</th>
                        <th class="text-center" style="vertical-align: middle;" rowspan="2">Upload Data</th>
                        <th class="text-center" style="vertical-align: middle;" rowspan="2">Status</th>
                        <th class="text-center" style="vertical-align: middle;" colspan="7">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="vertical-align: middle;">Verifikasi Bidang</th>
                        <th class="text-center" style="vertical-align: middle;">Hasil Tindak Lanjut</th>
                        <th class="text-center" style="vertical-align: middle;">Cetak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rows = [
                        'tujuan' => 'Indikator Tujuan',
                        'sasaran' => 'Indikator Sasaran',
                        'program' => 'Indikator Program',
                        'kegiatan' => 'Indikator Kegiatan',
                        'sub_kegiatan' => 'Indikator Sub Kegiatan'
                    ];
                    ?>
                    
                    <?php foreach ($rows as $key => $label): ?>
                    <?php 
                        $hasData = isset($existing[$key]);
                        $data = $hasData ? $existing[$key] : null;
                    ?>
                    <tr>
                        <td >
                            <?= $label ?>
                        </td>
                        <td class="text-center" style="width: 30%;">
                            <button type="button" class="btn btn-success btn-sm rounded-0 upload-catatan-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-upload"></i>
                                <div class="uploaded-filename" style="display: none; font-size: 9px; margin-top: 2px; color: white; font-weight: bold; word-break: break-all;"></div>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0" disabled>
                                Sesuai
                            </button>
                        </td>
                        <td class="text-center align-middle" style="vertical-align: middle;">
                            <button type="button" class="btn btn-warning btn-sm rounded-0 d-flex justify-content-center align-items-center mx-auto" style="height: 38px; width: 38px;" disabled>
                                <i class="fas fa-check mx-auto" style="display: block; margin: 0 auto;"></i>
                            </button>
                        </td>
                        <td class="text-center align-middle" style="vertical-align: middle;">
                            <button type="button" class="btn btn-info btn-sm rounded-0 upload-rencana-btn d-flex justify-content-center align-items-center mx-auto" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #17a2b8; border-color: #17a2b8; height: 38px; width: 38px;">
                                <i class="fas fa-comment mx-auto" style="display: block; margin: 0 auto;"></i>
                            </button>
                        </td>
                        <td class="text-center align-middle" style="vertical-align: middle;">
                            <?php if ($hasData): ?>
                            <button type="button" class="btn btn-default btn-sm rounded-0 preview-btn d-flex justify-content-center align-items-center mx-auto" 
                                    data-id="<?= $data['id'] ?>" data-jenis="<?= $key ?>" style="height: 38px; width: 38px;">
                                <i class="fas fa-print mx-auto" style="display: block; margin: 0 auto;"></i>
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-warning btn-sm rounded-0 d-flex justify-content-center align-items-center mx-auto" style="height: 38px; width: 38px;" disabled>
                                <i class="fas fa-print mx-auto" style="display: block; margin: 0 auto;"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
            </div>
            <div class="col-md-6 text-right">
                <button type="button" id="btnSave" class="btn btn-success rounded-0">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Catatan Modal -->
<div class="modal fade" id="uploadCatatanModal" tabindex="-1" role="dialog" aria-labelledby="uploadCatatanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadCatatanModalLabel">Upload Catatan Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadCatatanForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Indikator</label>
                        <input type="text" class="form-control rounded-0" id="catatan_jenis_indikator" name="jenis_indikator" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan Indikator</label>
                        <textarea class="form-control rounded-0" id="catatan_indikator" name="catatan_indikator" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File Catatan</label>
                        <input type="file" class="form-control-file rounded-0" id="file_catatan" name="file" 
                               accept=".xlsx,.xls,.pdf,.doc,.docx">
                        <small class="form-text text-muted">Format yang diperbolehkan: Excel, PDF, Word</small>
                        <div id="uploaded_filename" class="mt-2" style="display: none;">
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> File berhasil diupload: <span id="filename_display"></span>
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

<!-- Upload Rencana Modal -->
<div class="modal fade" id="uploadRencanaModal" tabindex="-1" role="dialog" aria-labelledby="uploadRencanaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadRencanaModalLabel">Upload Rencana Tindak Lanjut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rencanaForm" onsubmit="return false;">
                <div class="modal-body">
                    <input type="hidden" name="jenis_indikator" id="rencana_jenis_indikator" value="">
                    <div class="form-group">
                        <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                        <textarea class="form-control rounded-0" id="rencana_tindak_lanjut" name="rencana_tindak_lanjut" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-info rounded-0">
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
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="previewModalLabel">Preview Data Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Jenis Indikator</label>
                            <p id="preview_jenis_indikator" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Triwulan</label>
                            <p id="preview_triwulan" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Catatan Indikator</label>
                    <p id="preview_catatan_indikator" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                    <p id="preview_rencana_tindak_lanjut" class="form-control-plaintext"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Catatan</label>
                            <p id="preview_file_catatan" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Rencana</label>
                            <p id="preview_file_rencana" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Uploaded At</label>
                            <p id="preview_uploaded_at" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Actions</label>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm rounded-0" id="downloadCatatanBtn">
                                    <i class="fas fa-download"></i> Download Catatan
                                </button>
                                <button type="button" class="btn btn-info btn-sm rounded-0" id="downloadRencanaBtn">
                                    <i class="fas fa-download"></i> Download Rencana
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.upload-catatan-btn, .upload-rencana-btn, .preview-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-catatan-btn:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

.upload-rencana-btn:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
}

.preview-btn:hover {
    background-color: #5a32a3 !important;
    border-color: #5a32a3 !important;
}

.modal-header {
    border-bottom: 1px solid #dee2e6;
}

.modal-footer {
    border-top: 1px solid #dee2e6;
}

.form-control-plaintext {
    background-color: #f8f9fa;
    padding: 0.375rem 0.75rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    var currentDataId = null;
    
    // Upload Catatan button click
    $(document).on('click', '.upload-catatan-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#catatan_jenis_indikator').val(jenis);
        $('#catatan_indikator').val('');
        $('#file_catatan').val('');
        $('#uploaded_filename').hide();
        
        // Reset upload button state
        $('#uploadCatatanForm button[type="submit"]').prop('disabled', false).html('<i class="fas fa-upload"></i> Upload');
        
        $('#uploadCatatanModal').modal('show');
    });
    
    // Upload Rencana button click
    $(document).on('click', '.upload-rencana-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#rencana_jenis_indikator').val(jenis);
        $('#rencana_tindak_lanjut').val('');
        $('#file_rencana').val('');
        
        $('#uploadRencanaModal').modal('show');
    });
    
    // Preview button click
    $(document).on('click', '.preview-btn', function(){
        var id = $(this).data('id');
        currentDataId = id;
        
        $.get('<?= base_url('indikator/input/preview') ?>/' + id, function(res){
            if(res && res.ok){
                $('#preview_jenis_indikator').text(res.data.jenis_indikator);
                $('#preview_triwulan').text('Triwulan ' + res.data.triwulan);
                $('#preview_catatan_indikator').text(res.data.catatan_indikator || '-');
                $('#preview_rencana_tindak_lanjut').text(res.data.rencana_tindak_lanjut || '-');
                $('#preview_file_catatan').text(res.data.file_catatan_name || '-');
                $('#preview_file_rencana').text(res.data.file_rencana_name || '-');
                $('#preview_uploaded_at').text(formatDate(res.data.uploaded_at));
                
                $('#previewModal').modal('show');
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memuat data'); }
            }
        }, 'json').fail(function(){
            if(window.toastr){ toastr.error('Gagal memuat data'); }
        });
    });
    
    // Download buttons
    $(document).on('click', '#downloadCatatanBtn', function(){
        if(currentDataId){
            window.open('<?= base_url('indikator/input/download-catatan') ?>/' + currentDataId, '_blank');
        }
    });
    
    $(document).on('click', '#downloadRencanaBtn', function(){
        if(currentDataId){
            window.open('<?= base_url('indikator/input/download-rencana') ?>/' + currentDataId, '_blank');
        }
    });
    
    // Upload Catatan form submit
    $('#uploadCatatanForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('tahun', <?= $tahun ?>);
        formData.append('triwulan', <?= $triwulan ?>);
        formData.append(csrfTokenName, csrfHash);
        
        $.ajax({
            url: '<?= base_url('indikator/input/upload-catatan') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    // Show uploaded filename in the button
                    if(res.filename) {
                        var jenis = $('#catatan_jenis_indikator').val();
                        var button = $('.upload-catatan-btn[data-jenis="' + jenis + '"]');
                        var filenameDiv = button.find('.uploaded-filename');
                        filenameDiv.text(res.filename).show();
                        button.find('i').hide();
                        
                        // Change button style to show success
                        button.css({
                            'background-color': '#28a745',
                            'border-color': '#28a745',
                            'color': 'white'
                        });
                    }
                    if(window.toastr){ toastr.success(res.message || 'File catatan berhasil diupload'); }
                    
                    // Hide modal after showing result
                    $('#uploadCatatanModal').modal('hide');
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mengupload file'); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupload file'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupload file'); }
                }
            }
        });
    });
    
    // Upload Rencana form submit
    $('#uploadRencanaForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('tahun', <?= $tahun ?>);
        formData.append('triwulan', <?= $triwulan ?>);
        formData.append(csrfTokenName, csrfHash);
        
        $.ajax({
            url: '<?= base_url('indikator/input/upload-rencana') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'File rencana berhasil diupload'); }
                    $('#uploadRencanaModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mengupload file'); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupload file'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupload file'); }
                }
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            triwulan: <?= $triwulan ?>,
        };
        
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('indikator/input/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.csrf_token){ csrfToken = res.csrf_token; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Data berhasil disimpan'); }
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menyimpan data'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(data && data.csrf_token){ csrfToken = data.csrf_token; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan data'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan data'); }
            }
        });
    });
    
    function formatDate(dateString) {
        if (!dateString) return '-';
        var date = new Date(dateString);
        return date.toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
})();
</script>
<?= $this->endSection() ?>
