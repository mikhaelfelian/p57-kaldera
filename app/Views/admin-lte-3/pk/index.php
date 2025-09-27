<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
    $indikatorList = $indikatorList ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">RANCANGAN AKSI PERUBAHAN</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form method="get" id="filterForm">
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
        </form>

        <div class="table-responsive rounded-0">
            <table class="table table-bordered rounded-0">
                <thead style="background-color: #3b6ea8; color: white;">
                    <tr>
                        <th style="width: 200px;">Indikator</th>
                        <th class="text-center">Upload Data</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="text-center">Upload Data</th>
                        <th class="text-center">Sesuai</th>
                        <th class="text-center">Preview</th>
                        <th class="text-center">Verifikasi Bidang</th>
                        <th class="text-center">Feed back Unit Kerja</th>
                        <th class="text-center">Cetak (excel, Pdf)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rows = [
                        'monitoring_progres_belanja' => 'Monitoring Progres Belanja Konsultansi, dll',
                        'monitoring_progres_barang' => 'Monitoring Progres Barang yang diserahkan kepada masyarakat',
                        'monitoring_progres_lainnya' => 'Monitoring Progres Lainnya'
                    ];
                    ?>
                    
                    <?php foreach ($rows as $key => $label): ?>
                    <?php 
                        $hasData = isset($existing) && $existing;
                        $data = $hasData ? $existing : null;
                    ?>
                    <tr>
                        <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                            <?= $label ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0 upload-data-btn" 
                                    data-indikator="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0" disabled>
                                Sesuai
                            </button>
                        </td>
                        <td class="text-center">
                            <?php if ($hasData): ?>
                            <button type="button" class="btn btn-primary btn-sm rounded-0 preview-btn" 
                                    data-id="<?= $data['id'] ?>" data-indikator="<?= $key ?>"
                                    style="background-color: #6f42c1; border-color: #6f42c1;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" disabled>
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm rounded-0 verifikasi-btn" 
                                    data-indikator="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #ffc107; border-color: #ffc107;">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm rounded-0 feedback-btn" 
                                    data-indikator="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #17a2b8; border-color: #17a2b8;">
                                <i class="fas fa-comment"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" disabled>
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Verifikasi Sekretariat Section -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: #ffc107; color: #212529;">
                        <h5 class="card-title mb-0">Verifikasi Sekretariat</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Catatan Kendala</label>
                            <textarea class="form-control rounded-0" id="verifikasi_catatan_kendala" rows="3" 
                                      placeholder="Masukkan catatan kendala..."></textarea>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                            <textarea class="form-control rounded-0" id="verifikasi_rencana_tindak_lanjut" rows="3" 
                                      placeholder="Masukkan rencana tindak lanjut..."></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header" style="background-color: #17a2b8; color: white;">
                        <h5 class="card-title mb-0">Feed back Unit Kerja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Unit Kerja</th>
                                        <th>Alasan dan Saran Tindak Lanjut Perbaikan</th>
                                    </tr>
                                </thead>
                                <tbody id="feedbackTableBody">
                                    <?php for($i = 1; $i <= 3; $i++): ?>
                                    <tr>
                                        <td><?= $i ?></td>
                                        <td>
                                            <input type="text" name="feedback_unit_kerja[<?= $i ?>][unit_kerja]" 
                                                   class="form-control form-control-sm" 
                                                   placeholder="Unit Kerja">
                                        </td>
                                        <td>
                                            <textarea name="feedback_unit_kerja[<?= $i ?>][alasan_saran]" 
                                                      class="form-control form-control-sm" rows="2" 
                                                      placeholder="Alasan dan saran tindak lanjut perbaikan"></textarea>
                                        </td>
                                    </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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

<!-- Upload Data Modal -->
<div class="modal fade" id="uploadDataModal" tabindex="-1" role="dialog" aria-labelledby="uploadDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadDataModalLabel">Upload Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDataForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Indikator</label>
                        <input type="text" class="form-control rounded-0" id="data_indikator" name="indikator" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File Dokumen</label>
                        <input type="file" class="form-control-file rounded-0" id="file_dokumen" name="file" 
                               accept=".xlsx,.xls,.pdf,.doc,.docx" required>
                        <small class="form-text text-muted">Format yang diperbolehkan: Excel, PDF, Word</small>
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

<!-- Verifikasi Bidang Modal -->
<div class="modal fade" id="verifikasiModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #ffc107; color: #212529;">
                <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifikasiForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Indikator</label>
                        <input type="text" class="form-control rounded-0" id="verifikasi_indikator" name="indikator" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan Kendala</label>
                        <textarea class="form-control rounded-0" id="verifikasi_catatan_kendala_modal" name="catatan_kendala" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                        <textarea class="form-control rounded-0" id="verifikasi_rencana_tindak_lanjut_modal" name="rencana_tindak_lanjut" rows="3"></textarea>
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

<!-- Feed back Unit Kerja Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #17a2b8; color: white;">
                <h5 class="modal-title" id="feedbackModalLabel">Feed back Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="feedbackForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Indikator</label>
                        <input type="text" class="form-control rounded-0" id="feedback_indikator" name="indikator" readonly>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">No</th>
                                    <th>Unit Kerja</th>
                                    <th>Alasan dan Saran Tindak Lanjut Perbaikan</th>
                                </tr>
                            </thead>
                            <tbody id="feedbackModalTableBody">
                                <?php for($i = 1; $i <= 3; $i++): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <input type="text" name="feedback_unit_kerja[<?= $i ?>][unit_kerja]" 
                                               class="form-control form-control-sm" 
                                               placeholder="Unit Kerja">
                                    </td>
                                    <td>
                                        <textarea name="feedback_unit_kerja[<?= $i ?>][alasan_saran]" 
                                                  class="form-control form-control-sm" rows="2" 
                                                  placeholder="Alasan dan saran tindak lanjut perbaikan"></textarea>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info rounded-0">
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
                <h5 class="modal-title" id="previewModalLabel">Preview Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="font-weight-bold">Indikator</label>
                    <p id="preview_indikator" class="form-control-plaintext"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <p id="preview_status" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Dokumen</label>
                            <p id="preview_file_name" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Catatan Kendala</label>
                    <p id="preview_catatan_kendala" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                    <p id="preview_rencana_tindak_lanjut" class="form-control-plaintext"></p>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="font-weight-bold">Actions</label>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm rounded-0" id="downloadBtn">
                                    <i class="fas fa-download"></i> Download Dokumen
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
.upload-data-btn, .preview-btn, .verifikasi-btn, .feedback-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-data-btn:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

.preview-btn:hover {
    background-color: #5a32a3 !important;
    border-color: #5a32a3 !important;
}

.verifikasi-btn:hover {
    background-color: #e0a800 !important;
    border-color: #d39e00 !important;
}

.feedback-btn:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
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

.card {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
}

.card-header {
    border-bottom: 1px solid #dee2e6;
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
    
    // Upload Data button click
    $(document).on('click', '.upload-data-btn', function(){
        var indikator = $(this).data('indikator');
        var label = $(this).data('label');
        
        $('#data_indikator').val(label);
        $('#file_dokumen').val('');
        
        $('#uploadDataModal').modal('show');
    });
    
    // Verifikasi button click
    $(document).on('click', '.verifikasi-btn', function(){
        var indikator = $(this).data('indikator');
        var label = $(this).data('label');
        
        $('#verifikasi_indikator').val(label);
        $('#verifikasi_catatan_kendala_modal').val('');
        $('#verifikasi_rencana_tindak_lanjut_modal').val('');
        
        $('#verifikasiModal').modal('show');
    });
    
    // Feedback button click
    $(document).on('click', '.feedback-btn', function(){
        var indikator = $(this).data('indikator');
        var label = $(this).data('label');
        
        $('#feedback_indikator').val(label);
        
        $('#feedbackModal').modal('show');
    });
    
    // Preview button click
    $(document).on('click', '.preview-btn', function(){
        var id = $(this).data('id');
        currentDataId = id;
        
        $.get('<?= base_url('pk/preview') ?>/' + id, function(res){
            if(res && res.ok){
                $('#preview_indikator').text(res.data.indikator);
                $('#preview_status').text(res.data.status || 'Belum Diperiksa');
                $('#preview_file_name').text(res.data.file_name || '-');
                $('#preview_catatan_kendala').text(res.data.catatan_kendala || '-');
                $('#preview_rencana_tindak_lanjut').text(res.data.rencana_tindak_lanjut || '-');
                
                $('#previewModal').modal('show');
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memuat data'); }
            }
        }, 'json').fail(function(){
            if(window.toastr){ toastr.error('Gagal memuat data'); }
        });
    });
    
    // Download button
    $(document).on('click', '#downloadBtn', function(){
        if(currentDataId){
            window.open('<?= base_url('pk/download') ?>/' + currentDataId, '_blank');
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
            url: '<?= base_url('pk/upload') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'Data berhasil diupload'); }
                    $('#uploadDataModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mengupload data'); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupload data'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupload data'); }
                }
            }
        });
    });
    
    // Verifikasi form submit
    $('#verifikasiForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            indikator: $('#verifikasi_indikator').val(),
            catatan_kendala: $('#verifikasi_catatan_kendala_modal').val(),
            rencana_tindak_lanjut: $('#verifikasi_rencana_tindak_lanjut_modal').val()
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('pk/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Verifikasi berhasil disimpan'); }
                $('#verifikasiModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menyimpan verifikasi'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan verifikasi'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan verifikasi'); }
            }
        });
    });
    
    // Feedback form submit
    $('#feedbackForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            indikator: $('#feedback_indikator').val(),
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
        
        $.post('<?= base_url('pk/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Feedback berhasil disimpan'); }
                $('#feedbackModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menyimpan feedback'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan feedback'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan feedback'); }
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            catatan_kendala: $('#verifikasi_catatan_kendala').val(),
            rencana_tindak_lanjut: $('#verifikasi_rencana_tindak_lanjut').val(),
            feedback_unit_kerja: {}
        };
        
        // Collect feedback data from main form
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
        
        $.post('<?= base_url('pk/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Data berhasil disimpan'); }
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menyimpan data'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan data'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan data'); }
            }
        });
    });
})();
</script>
<?= $this->endSection() ?>
