<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $indikatorList = $indikatorList ?? [];
    $existingData = $existingData ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">METADATA INDIKATOR</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <div class="table-responsive rounded-0">
            <table class="table table-bordered rounded-0">
                <thead style="background-color: #3b6ea8; color: white;">
                    <tr>
                        <th style="width: 200px;">Indikator</th>
                        <th class="text-center">Upload Data</th>
                        <th class="text-center">View</th>
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
                        $hasData = isset($existingData[$key]);
                        $data = $hasData ? $existingData[$key] : null;
                    ?>
                    <tr>
                        <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                            <?= $label ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0 upload-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <?php if ($hasData): ?>
                            <button type="button" class="btn btn-primary btn-sm rounded-0 view-btn" 
                                    data-id="<?= $data['id'] ?>" data-jenis="<?= $key ?>"
                                    style="background-color: #6f42c1; border-color: #6f42c1;">
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" disabled>
                                <i class="fas fa-eye"></i>
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadModalLabel">Upload Data Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Indikator</label>
                        <input type="text" class="form-control rounded-0" id="jenis_indikator" name="jenis_indikator" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Indikator</label>
                        <input type="text" class="form-control rounded-0" id="nama_indikator" name="nama_indikator" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Formulasi</label>
                        <textarea class="form-control rounded-0" id="formulasi" name="formulasi" rows="2" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Definisi Operasional</label>
                        <textarea class="form-control rounded-0" id="definisi_operasional" name="definisi_operasional" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File</label>
                        <input type="file" class="form-control-file rounded-0" id="file" name="file" required 
                               accept=".xlsx,.xls,.pdf,.doc,.docx">
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

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="viewModalLabel">Detail Data Indikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Jenis Indikator</label>
                            <p id="view_jenis_indikator" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Indikator</label>
                            <p id="view_nama_indikator" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Formulasi</label>
                    <p id="view_formulasi" class="form-control-plaintext"></p>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Definisi Operasional</label>
                    <p id="view_definisi_operasional" class="form-control-plaintext"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Name</label>
                            <p id="view_file_name" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Size</label>
                            <p id="view_file_size" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Uploaded At</label>
                            <p id="view_uploaded_at" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Actions</label>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm rounded-0" id="downloadBtn">
                                    <i class="fas fa-download"></i> Download
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
.upload-btn, .view-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.upload-btn:hover {
    background-color: #218838 !important;
    border-color: #1e7e34 !important;
}

.view-btn:hover {
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
    var currentDataId = null;
    
    // Upload button click
    $(document).on('click', '.upload-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#jenis_indikator').val(jenis);
        $('#nama_indikator').val(label);
        $('#formulasi').val('');
        $('#definisi_operasional').val('');
        $('#file').val('');
        
        $('#uploadModal').modal('show');
    });
    
    // View button click
    $(document).on('click', '.view-btn', function(){
        var id = $(this).data('id');
        currentDataId = id;
        
        $.get('<?= base_url('indikator/view') ?>/' + id, function(res){
            if(res && res.ok){
                $('#view_jenis_indikator').text(res.data.jenis_indikator);
                $('#view_nama_indikator').text(res.data.nama_indikator);
                
                // Parse deskripsi to separate formulasi and definisi operasional
                var deskripsi = res.data.deskripsi || '';
                var parts = deskripsi.split('\n\nDefinisi Operasional:\n');
                var formulasi = parts[0] || '-';
                var definisiOperasional = parts[1] || '-';
                
                $('#view_formulasi').text(formulasi);
                $('#view_definisi_operasional').text(definisiOperasional);
                $('#view_file_name').text(res.data.file_name);
                $('#view_file_size').text(formatFileSize(res.data.file_size));
                $('#view_uploaded_at').text(formatDate(res.data.uploaded_at));
                
                $('#viewModal').modal('show');
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal memuat data'); }
            }
        }, 'json').fail(function(){
            if(window.toastr){ toastr.error('Gagal memuat data'); }
        });
    });
    
    // Download button click
    $(document).on('click', '#downloadBtn', function(){
        if(currentDataId){
            window.open('<?= base_url('indikator/download') ?>/' + currentDataId, '_blank');
        }
    });
    
    // Upload form submit
    $('#uploadForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append(csrfToken, csrfHash);
        
        $.ajax({
            url: '<?= base_url('indikator/upload') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'File berhasil diupload'); }
                    $('#uploadModal').modal('hide');
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
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        var k = 1024;
        var sizes = ['Bytes', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
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
