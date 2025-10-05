<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">MONITORING PROGRES PENCATATAN PBJ</h3>
        <div class="d-flex align-items-center">
            <button type="button" class="btn btn-success rounded-0 mr-2" onclick="exportToExcel()">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form id="pbjProgresForm" method="get">
            <div class="row mb-3">
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <label class="font-weight-bold">Bulan :</label>
                    <select name="bulan" class="form-control rounded-0" onchange="this.form.submit()">
                        <?php foreach ($bulanList as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                </div>
            </div>

            <!-- Main Monitoring Table -->
            <div class="table-responsive rounded-0 mb-4">
                <table class="table table-bordered rounded-0">
                    <thead style="background-color: #3b6ea8; color: white;">
                        <tr>
                            <th style="width: 200px;">Indikator</th>
                            <th class="text-center">Upload Data</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" colspan="3">Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Preview</th>
                            <th class="text-center">Verifikasi Sekretariat</th>
                            <th class="text-center">Feed back Unit Kerja</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Monitoring Progres Pencatatan PBJ
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm" id="uploadDataBtn" 
                                        data-tahun="<?= $tahun ?>" data-bulan="<?= $bulan ?>">
                                    <i class="fas fa-file-upload"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <select name="status" class="form-control form-control-sm status-select">
                                    <option value="Belum Diperiksa" <?= ($existing['status'] ?? '') == 'Belum Diperiksa' ? 'selected' : '' ?>>Belum Diperiksa</option>
                                    <option value="Sesuai" <?= ($existing['status'] ?? '') == 'Sesuai' ? 'selected' : '' ?>>Sesuai</option>
                                    <option value="Tidak Sesuai" <?= ($existing['status'] ?? '') == 'Tidak Sesuai' ? 'selected' : '' ?>>Tidak Sesuai</option>
                                </select>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm mr-1" id="previewDataBtn" title="Preview"
                                        data-tahun="<?= $tahun ?>" data-bulan="<?= $bulan ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm mr-1" id="verifikasiSekretariatBtn" title="Verifikasi Sekretariat"
                                        data-tahun="<?= $tahun ?>" data-bulan="<?= $bulan ?>">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm mr-1" id="feedbackUnitKerjaBtn" title="Feed back Unit Kerja"
                                        data-tahun="<?= $tahun ?>" data-bulan="<?= $bulan ?>">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </form>
    </div>
</div>

<!-- Upload Data Modal -->
<div class="modal fade" id="uploadDataModal" tabindex="-1" role="dialog" aria-labelledby="uploadDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadDataModalLabel">Upload Data PBJ Progres</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDataForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="upload_tahun" name="tahun" value="<?= $tahun ?>">
                    <input type="hidden" id="upload_bulan" name="bulan" value="<?= $bulan ?>">
                    
                    <div class="alert alert-info rounded-0">
                        <i class="fas fa-info-circle"></i> Upload file data untuk periode <strong><?= $tahun ?> - <?= bulan_ke_str($bulan) ?></strong>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Pilih File <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="upload_file" name="file" 
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                            <label class="custom-file-label rounded-0" for="upload_file">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: PDF, Word, Excel, atau gambar (JPG, PNG). Maksimal 10MB.
                        </small>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Keterangan</label>
                        <textarea class="form-control rounded-0" id="upload_keterangan" name="keterangan" 
                            rows="3" placeholder="Keterangan file yang diupload"></textarea>
                    </div>

                    <div id="current_file_info" style="display: none;">
                        <div class="alert alert-success rounded-0">
                            <i class="fas fa-file"></i> File saat ini: <strong id="current_file_name"></strong>
                            <br>
                            <small>File baru akan menggantikan file yang ada.</small>
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

<!-- Preview File Modal -->
<div class="modal fade" id="previewFileModal" tabindex="-1" role="dialog" aria-labelledby="previewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="previewFileModalLabel">
                    <i class="fas fa-eye"></i> Preview File: <span id="preview_file_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="preview_loading" class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                    <p class="mt-3">Loading file...</p>
                </div>
                <div id="preview_error" style="display: none;" class="alert alert-danger m-3 rounded-0">
                    <i class="fas fa-exclamation-triangle"></i> <span id="preview_error_message"></span>
                </div>
                <div id="preview_content" style="display: none;">
                    <iframe id="preview_iframe" style="width: 100%; height: 600px; border: none;"></iframe>
                </div>
                <div id="preview_download_notice" style="display: none;" class="alert alert-info m-3 rounded-0">
                    <i class="fas fa-info-circle"></i> 
                    File ini tidak dapat ditampilkan di browser. Silakan download untuk melihat isi file.
                    <br>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 mt-2" id="preview_download_btn">
                        <i class="fas fa-download"></i> Download File
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary rounded-0" id="preview_download_btn_footer">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Verifikasi Sekretariat Modal -->
<div class="modal fade" id="verifikasiSekretariatModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiSekretariatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #ffc107; color: #212529;">
                <h5 class="modal-title" id="verifikasiSekretariatModalLabel">
                    <i class="fas fa-file-alt"></i> Verifikasi Sekretariat
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #212529;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifikasiSekretariatForm">
                <div class="modal-body">
                    <input type="hidden" id="verif_tahun" name="tahun" value="<?= $tahun ?>">
                    <input type="hidden" id="verif_bulan" name="bulan" value="<?= $bulan ?>">
                    
                    <div class="alert alert-info rounded-0">
                        <i class="fas fa-info-circle"></i> Verifikasi Sekretariat untuk periode <strong><?= $tahun ?> - <?= bulan_ke_str($bulan) ?></strong>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan Kendala</label>
                                <textarea name="catatan_kendala" class="form-control rounded-0" rows="4" 
                                    placeholder="Masukkan catatan kendala yang ditemukan"><?= $existing['catatan_kendala'] ?? '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                                <textarea name="rencana_tindak_lanjut" class="form-control rounded-0" rows="4" 
                                    placeholder="Masukkan rencana tindak lanjut"><?= $existing['rencana_tindak_lanjut'] ?? '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-0">
                        <i class="fas fa-save"></i> Simpan Verifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Feedback Unit Kerja Modal -->
<div class="modal fade" id="feedbackUnitKerjaModal" tabindex="-1" role="dialog" aria-labelledby="feedbackUnitKerjaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #007bff; color: white;">
                <h5 class="modal-title" id="feedbackUnitKerjaModalLabel">
                    <i class="fas fa-file-alt"></i> Feed back Unit Kerja
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="feedbackUnitKerjaForm">
                <div class="modal-body">
                    <input type="hidden" id="feedback_tahun" name="tahun" value="<?= $tahun ?>">
                    <input type="hidden" id="feedback_bulan" name="bulan" value="<?= $bulan ?>">
                    
                    <div class="alert alert-info rounded-0">
                        <i class="fas fa-info-circle"></i> Feed back Unit Kerja untuk periode <strong><?= $tahun ?> - <?= bulan_ke_str($bulan) ?></strong>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Unit Kerja</th>
                                    <th>Alasan dan Saran Tindak Lanjut Perbaikan</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="feedbackModalTableBody">
                                <!-- Dynamic rows will be added here -->
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right mb-3">
                        <button type="button" class="btn btn-success btn-sm rounded-0" id="addFeedbackRow">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-0">
                        <i class="fas fa-save"></i> Simpan Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.status-select {
    min-width: 120px;
}
.card-header.bg-warning {
    background-color: #ffc107 !important;
}
.card-header.bg-primary {
    background-color: #007bff !important;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= service('security')->getTokenName() ?>';
    
    // Status change handler
    $('.status-select').on('change', function(){
        var status = $(this).val();
        var tahun = <?= $tahun ?>;
        var bulan = <?= $bulan ?>;
        
        var formData = {
            tahun: tahun,
            bulan: bulan,
            status: status
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('pbj/input/progres/update-status') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.csrf_token){ csrfToken = res.csrf_token; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Status berhasil diperbarui'); }
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memperbarui status'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(data && data.csrf_token){ csrfToken = data.csrf_token; }
                if(window.toastr){ toastr.error(data.message || 'Gagal memperbarui status'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal memperbarui status'); }
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            status: $('select[name="status"]').val(),
            catatan_kendala: $('textarea[name="catatan_kendala"]').val(),
            rencana_tindak_lanjut: $('textarea[name="rencana_tindak_lanjut"]').val(),
            feedback_unit_kerja: {}
        };
        
        // Collect feedback data
        $('input[name^="feedback_unit_kerja"]').each(function(){
            var name = $(this).attr('name');
            var matches = name.match(/feedback_unit_kerja\[(\d+)\]\[(\w+)\]/);
            if(matches) {
                var index = matches[1];
                var field = matches[2];
                if(!formData.feedback_unit_kerja[index]) {
                    formData.feedback_unit_kerja[index] = {};
                }
                formData.feedback_unit_kerja[index][field] = $(this).val();
            }
        });
        
        $('textarea[name^="feedback_unit_kerja"]').each(function(){
            var name = $(this).attr('name');
            var matches = name.match(/feedback_unit_kerja\[(\d+)\]\[(\w+)\]/);
            if(matches) {
                var index = matches[1];
                var field = matches[2];
                if(!formData.feedback_unit_kerja[index]) {
                    formData.feedback_unit_kerja[index] = {};
                }
                formData.feedback_unit_kerja[index][field] = $(this).val();
            }
        });
        
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('pbj/input/progres/save') ?>', formData, function(res){
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
    
    // Export function
    function exportToExcel() {
        // Use server-side PHPSpreadsheet export
        var tahun = <?= $tahun ?>;
        var bulan = <?= $bulan ?>;
        
        // Create download link
        var url = '<?= base_url('pbj/input/progres/export-excel') ?>?tahun=' + tahun + '&bulan=' + bulan;
        
        // Open in new window to trigger download
        window.open(url, '_blank');
    }
    
    // Make export function globally available
    window.exportToExcel = exportToExcel;
    
    // Upload data button click
    $('#uploadDataBtn').on('click', function() {
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        
        $('#upload_tahun').val(tahun);
        $('#upload_bulan').val(bulan);
        
        // Reset form
        $('#uploadDataForm')[0].reset();
        $('#upload_tahun').val(tahun);
        $('#upload_bulan').val(bulan);
        $('.custom-file-label').text('Pilih file...');
        $('#current_file_info').hide();
        
        // Check if file already exists
        $.get('<?= base_url('pbj/input/progres/check-file') ?>', {
            tahun: tahun,
            bulan: bulan
        }, function(res) {
            if (res && res.has_file) {
                $('#current_file_name').text(res.file_name);
                $('#current_file_info').show();
            }
        }, 'json');
        
        $('#uploadDataModal').modal('show');
    });
    
    // Update file input label
    $('#upload_file').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });
    
    // Upload form submit
    $('#uploadDataForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append(csrfTokenName, csrfHash);
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');
        
        $.ajax({
            url: '<?= base_url('pbj/input/progres/upload-file') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                if (res && res.ok) {
                    if (window.toastr) { 
                        toastr.success(res.message || 'File berhasil diupload'); 
                    }
                    $('#uploadDataModal').modal('hide');
                    
                    // Update upload button appearance
                    $('#uploadDataBtn').removeClass('btn-success').addClass('btn-warning');
                    $('#uploadDataBtn').html('<i class="fas fa-check"></i>');
                    $('#uploadDataBtn').attr('title', 'File sudah diupload');
                } else {
                    if (window.toastr) { 
                        toastr.error(res.message || 'Gagal mengupload file'); 
                    }
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { 
                        toastr.error(data.message || 'Gagal mengupload file'); 
                    }
                } catch (e) {
                    if (window.toastr) { 
                        toastr.error('Gagal mengupload file'); 
                    }
                }
            }
        });
    });
    
    // Preview data button click
    $('#previewDataBtn').on('click', function() {
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        
        // Check if file exists first
        $.get('<?= base_url('pbj/input/progres/check-file') ?>', {
            tahun: tahun,
            bulan: bulan
        }, function(res) {
            if (res && res.has_file) {
                openFilePreview(tahun, bulan, res.file_name);
            } else {
                if (window.toastr) {
                    toastr.warning('Belum ada file yang diupload');
                }
            }
        }, 'json').fail(function() {
            if (window.toastr) {
                toastr.error('Gagal memeriksa file');
            }
        });
    });
    
    // Function to open file preview
    function openFilePreview(tahun, bulan, fileName) {
        // Reset modal state
        $('#preview_loading').show();
        $('#preview_error').hide();
        $('#preview_content').hide();
        $('#preview_download_notice').hide();
        $('#preview_iframe').attr('src', '');
        $('#preview_file_title').text(fileName);
        
        // Open modal
        $('#previewFileModal').modal('show');
        
        // Get file extension
        var extension = fileName.split('.').pop().toLowerCase();
        var previewUrl = '<?= base_url('pbj/input/progres/preview-file') ?>/' + tahun + '/' + bulan + '?preview=1';
        var downloadUrl = '<?= base_url('pbj/input/progres/download-file') ?>/' + tahun + '/' + bulan;
        
        // Set download button URLs
        $('#preview_download_btn').off('click').on('click', function() {
            window.open(downloadUrl, '_blank');
        });
        $('#preview_download_btn_footer').off('click').on('click', function() {
            window.open(downloadUrl, '_blank');
        });
        
        // Check if file can be previewed
        var canPreview = ['pdf', 'jpg', 'jpeg', 'png', 'gif'].indexOf(extension) !== -1;
        
        // Debug logging
        console.log('Preview URL:', previewUrl);
        console.log('File extension:', extension);
        console.log('Can preview:', canPreview);
        
        if (canPreview) {
            // Load file in iframe
            $('#preview_iframe').off('load error').on('load', function() {
                $('#preview_loading').hide();
                $('#preview_content').show();
            }).on('error', function() {
                $('#preview_loading').hide();
                $('#preview_error_message').text('Gagal memuat file preview');
                $('#preview_error').show();
            });
            
            // Set iframe source
            $('#preview_iframe').attr('src', previewUrl);
            
            // Set timeout to handle cases where iframe doesn't load
            setTimeout(function() {
                if ($('#preview_loading').is(':visible')) {
                    $('#preview_loading').hide();
                    $('#preview_error_message').text('Timeout loading file preview');
                    $('#preview_error').show();
                }
            }, 10000); // 10 second timeout
        } else {
            // Show download notice for non-previewable files
            $('#preview_loading').hide();
            $('#preview_download_notice').show();
        }
    }
    
    // Close preview modal cleanup
    $('#previewFileModal').on('hidden.bs.modal', function () {
        $('#preview_iframe').attr('src', '');
    });
    
    // Verifikasi Sekretariat button click
    $('#verifikasiSekretariatBtn').on('click', function() {
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        
        $('#verif_tahun').val(tahun);
        $('#verif_bulan').val(bulan);
        
        // Load existing data
        $.get('<?= base_url('pbj/input/progres/get-verifikasi') ?>', {
            tahun: tahun,
            bulan: bulan
        }, function(res) {
            if (res && res.ok && res.data) {
                $('textarea[name="catatan_kendala"]').val(res.data.catatan_kendala || '');
                $('textarea[name="rencana_tindak_lanjut"]').val(res.data.rencana_tindak_lanjut || '');
            }
        }, 'json').fail(function() {
            // Reset form on error
            $('textarea[name="catatan_kendala"]').val('');
            $('textarea[name="rencana_tindak_lanjut"]').val('');
        });
        
        $('#verifikasiSekretariatModal').modal('show');
    });
    
    // Verifikasi Sekretariat form submit
    $('#verifikasiSekretariatForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = $(this).serialize();
        formData += '&' + csrfTokenName + '=' + csrfHash;
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        $.ajax({
            url: '<?= base_url('pbj/input/progres/save-verifikasi') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                if (res && res.ok) {
                    if (window.toastr) { 
                        toastr.success(res.message || 'Verifikasi berhasil disimpan'); 
                    }
                    $('#verifikasiSekretariatModal').modal('hide');
                } else {
                    if (window.toastr) { 
                        toastr.error(res.message || 'Gagal menyimpan verifikasi'); 
                    }
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { 
                        toastr.error(data.message || 'Gagal menyimpan verifikasi'); 
                    }
                } catch (e) {
                    if (window.toastr) { 
                        toastr.error('Gagal menyimpan verifikasi'); 
                    }
                }
            }
        });
    });
    
    // Feedback Unit Kerja button click
    $('#feedbackUnitKerjaBtn').on('click', function() {
        var tahun = $(this).data('tahun');
        var bulan = $(this).data('bulan');
        
        $('#feedback_tahun').val(tahun);
        $('#feedback_bulan').val(bulan);
        
        // Load existing feedback data
        console.log('Loading feedback for tahun:', tahun, 'bulan:', bulan);
        
        // First add a default row
        addFeedbackRow();
        
        $.get('<?= base_url('pbj/input/progres/get-feedback') ?>', {
            tahun: tahun,
            bulan: bulan
        }, function(res) {
            console.log('Feedback data response:', res);
            if (res && res.ok && res.data) {
                console.log('Raw data from server:', res.data);
                console.log('Data type:', typeof res.data);
                console.log('Data length/keys:', Array.isArray(res.data) ? res.data.length : Object.keys(res.data).length);
                
                if ((Array.isArray(res.data) && res.data.length > 0) || (!Array.isArray(res.data) && Object.keys(res.data).length > 0)) {
                    console.log('Loading existing feedback data:', res.data);
                    loadFeedbackRows(res.data);
                } else {
                    console.log('No existing data found');
                }
            } else {
                console.log('No data in response');
            }
        }, 'json').fail(function(xhr) {
            console.log('Error loading feedback data:', xhr);
            console.log('Response text:', xhr.responseText);
        });
        
        // Always add at least one row when modal opens
        if ($('#feedbackModalTableBody tr').length === 0) {
            addFeedbackRow();
        }
        
        $('#feedbackUnitKerjaModal').modal('show');
    });
    
    // Add feedback row button
    $('#addFeedbackRow').on('click', function() {
        addFeedbackRow();
    });
    
    // Remove feedback row
    $(document).on('click', '.remove-feedback-row', function() {
        $(this).closest('tr').remove();
        updateFeedbackRowNumbers();
    });
    
    // Feedback form submit
    $('#feedbackUnitKerjaForm').on('submit', function(e) {
        e.preventDefault();
        
        var formData = collectFeedbackData();
        formData += '&' + csrfTokenName + '=' + csrfHash;
        
        var submitBtn = $(this).find('button[type="submit"]');
        var originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
        
        $.ajax({
            url: '<?= base_url('pbj/input/progres/save-feedback') ?>',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                if (res && res.ok) {
                    if (window.toastr) { 
                        toastr.success(res.message || 'Feedback berhasil disimpan'); 
                    }
                    $('#feedbackUnitKerjaModal').modal('hide');
                } else {
                    if (window.toastr) { 
                        toastr.error(res.message || 'Gagal menyimpan feedback'); 
                    }
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { 
                        toastr.error(data.message || 'Gagal menyimpan feedback'); 
                    }
                } catch (e) {
                    if (window.toastr) { 
                        toastr.error('Gagal menyimpan feedback'); 
                    }
                }
            }
        });
    });
    
    // Function to add feedback row
    function addFeedbackRow() {
        var rowCount = $('#feedbackModalTableBody tr').length;
        var rowNumber = rowCount + 1;
        
        console.log('Adding feedback row ' + rowNumber);
        
        var rowHtml = '<tr>' +
            '<td>' + rowNumber + '</td>' +
            '<td>' +
                '<input type="text" name="feedback_unit_kerja[' + rowNumber + '][unit_kerja]" ' +
                'class="form-control form-control-sm" placeholder="Unit Kerja">' +
            '</td>' +
            '<td>' +
                '<textarea name="feedback_unit_kerja[' + rowNumber + '][alasan_saran]" ' +
                'class="form-control form-control-sm" rows="2" ' +
                'placeholder="Alasan dan saran tindak lanjut perbaikan"></textarea>' +
            '</td>' +
            '<td class="text-center">' +
                '<button type="button" class="btn btn-danger btn-sm remove-feedback-row" title="Hapus Baris">' +
                    '<i class="fas fa-trash"></i>' +
                '</button>' +
            '</td>' +
        '</tr>';
        
        $('#feedbackModalTableBody').append(rowHtml);
    }
    
    // Function to load existing feedback rows
    function loadFeedbackRows(data) {
        console.log('loadFeedbackRows called with data:', data);
        console.log('Data type:', typeof data);
        console.log('Is array:', Array.isArray(data));
        console.log('Object keys:', Object.keys(data));
        
        $('#feedbackModalTableBody').empty();
        
        if (data && Object.keys(data).length > 0) {
            console.log('Loading existing feedback rows');
            
            // Handle object format like {"1":{"unit_kerja":"hghghgh","alasan_saran":"hghghgh"},"2":{"unit_kerja":"hghghg","alasan_saran":"hghghgh"}}
            Object.keys(data).forEach(function(key) {
                var item = data[key];
                console.log('Processing item for key', key, ':', item);
                
                var rowHtml = '<tr>' +
                    '<td>' + key + '</td>' +
                    '<td>' +
                        '<input type="text" name="feedback_unit_kerja[' + key + '][unit_kerja]" ' +
                        'class="form-control form-control-sm" value="' + (item.unit_kerja || '') + '" ' +
                        'placeholder="Unit Kerja">' +
                    '</td>' +
                    '<td>' +
                        '<textarea name="feedback_unit_kerja[' + key + '][alasan_saran]" ' +
                        'class="form-control form-control-sm" rows="2" ' +
                        'placeholder="Alasan dan saran tindak lanjut perbaikan">' + (item.alasan_saran || '') + '</textarea>' +
                    '</td>' +
                    '<td class="text-center">' +
                        '<button type="button" class="btn btn-danger btn-sm remove-feedback-row" title="Hapus Baris">' +
                            '<i class="fas fa-trash"></i>' +
                        '</button>' +
                    '</td>' +
                '</tr>';
                
                $('#feedbackModalTableBody').append(rowHtml);
            });
        } else {
            console.log('No existing data, adding default row');
            // Add default empty row if no data
            addFeedbackRow();
        }
    }
    
    // Function to collect feedback data
    function collectFeedbackData() {
        var formData = $('#feedbackUnitKerjaForm').serialize();
        return formData;
    }
    
    // Function to update row numbers
    function updateFeedbackRowNumbers() {
        $('#feedbackModalTableBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1);
        });
    }
})();
</script>
<?= $this->endSection() ?>
