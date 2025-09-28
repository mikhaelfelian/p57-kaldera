<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
    $barangList = $barangList ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">BARANG DISERAHKAN</h3>
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
                        <th style="width: 200px;">Jenis Barang</th>
                        <th class="text-center">Upload Data</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th class="text-center">Nama Barang</th>
                        <th class="text-center">Nilai Barang</th>
                        <th class="text-center">Sesuai</th>
                        <th class="text-center">Preview</th>
                        <th class="text-center">Verifikasi Bidang</th>
                        <th class="text-center">Feed back Unit Kerja</th>
                        <th class="text-center">Cetak (excel, Pdf)</th>
                        <th class="text-center">Upload Dok. Adm.</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rows = [
                        'barang_makanan' => 'Barang Makanan',
                        'barang_sembako' => 'Barang Sembako',
                        'barang_sandang' => 'Barang Sandang',
                        'barang_lainnya' => 'Barang Lainnya'
                    ];
                    ?>
                    
                    <?php foreach ($rows as $key => $label): ?>
                    <?php 
                        $hasData = isset($existing[$key]);
                        $data = $hasData ? $existing[$key] : null;
                    ?>
                    <tr>
                        <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                            <?= $label ?>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0 upload-data-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #28a745; border-color: #28a745;">
                                <i class="fas fa-upload"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm rounded-0 upload-nilai-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #17a2b8; border-color: #17a2b8;">
                                <i class="fas fa-money-bill"></i>
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
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm rounded-0 verifikasi-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #ffc107; border-color: #ffc107;">
                                <i class="fas fa-check"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm rounded-0 feedback-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #17a2b8; border-color: #17a2b8;">
                                <i class="fas fa-comment"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-secondary btn-sm rounded-0" disabled>
                                <i class="fas fa-print"></i>
                            </button>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm rounded-0 upload-dok-btn" 
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #dc3545; border-color: #dc3545;">
                                <i class="fas fa-file-upload"></i>
                            </button>
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

<!-- Upload Data Modal -->
<div class="modal fade" id="uploadDataModal" tabindex="-1" role="dialog" aria-labelledby="uploadDataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadDataModalLabel">Upload Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDataForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Barang</label>
                        <input type="text" class="form-control rounded-0" id="data_jenis_barang" name="jenis_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nama Barang</label>
                        <input type="text" class="form-control rounded-0" id="data_nama_barang" name="nama_barang" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Deskripsi</label>
                        <textarea class="form-control rounded-0" id="data_deskripsi" name="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-0">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Upload Nilai Modal -->
<div class="modal fade" id="uploadNilaiModal" tabindex="-1" role="dialog" aria-labelledby="uploadNilaiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadNilaiModalLabel">Input Nilai Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadNilaiForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Barang</label>
                        <input type="text" class="form-control rounded-0" id="nilai_jenis_barang" name="jenis_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Nilai Barang (Rp)</label>
                        <input type="number" class="form-control rounded-0" id="nilai_barang" name="nilai_barang" 
                               step="0.01" min="0" required>
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
                        <label class="font-weight-bold">Jenis Barang</label>
                        <input type="text" class="form-control rounded-0" id="verifikasi_jenis_barang" name="jenis_barang" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan Kendala</label>
                        <textarea class="form-control rounded-0" id="verifikasi_catatan_kendala" name="catatan_kendala" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                        <textarea class="form-control rounded-0" id="verifikasi_rencana_tindak_lanjut" name="rencana_tindak_lanjut" rows="3"></textarea>
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
                        <label class="font-weight-bold">Jenis Barang</label>
                        <input type="text" class="form-control rounded-0" id="feedback_jenis_barang" name="jenis_barang" readonly>
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

<!-- Upload Dokumen Admin Modal -->
<div class="modal fade" id="uploadDokModal" tabindex="-1" role="dialog" aria-labelledby="uploadDokModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #dc3545; color: white;">
                <h5 class="modal-title" id="uploadDokModalLabel">Upload Dokumen Admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadDokForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Jenis Barang</label>
                        <input type="text" class="form-control rounded-0" id="dok_jenis_barang" name="jenis_barang" readonly>
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
                    <button type="submit" class="btn btn-danger rounded-0">
                        <i class="fas fa-upload"></i> Upload
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
                <h5 class="modal-title" id="previewModalLabel">Preview Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Jenis Barang</label>
                            <p id="preview_jenis_barang" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Nama Barang</label>
                            <p id="preview_nama_barang" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Deskripsi</label>
                    <p id="preview_deskripsi" class="form-control-plaintext"></p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Nilai Barang</label>
                            <p id="preview_nilai_barang" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Status</label>
                            <p id="preview_status" class="form-control-plaintext"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">File Dokumen</label>
                            <p id="preview_file_name" class="form-control-plaintext"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold">Uploaded At</label>
                            <p id="preview_uploaded_at" class="form-control-plaintext"></p>
                        </div>
                    </div>
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
.upload-data-btn, .upload-nilai-btn, .preview-btn, .verifikasi-btn, .feedback-btn, .upload-dok-btn {
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

.upload-nilai-btn:hover {
    background-color: #138496 !important;
    border-color: #138496 !important;
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

.upload-dok-btn:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
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
    
    // Initialize AutoNumeric formatting
    $('#nilai_barang').autoNumeric('init', {
        aSep: '.',
        aDec: ',',
        aSign: '',
        vMax: '999999999999999.99',
        vMin: '0',
        mDec: 0,
        dGroup: 3
    });
    
    // Upload Data button click
    $(document).on('click', '.upload-data-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#data_jenis_barang').val(jenis);
        $('#data_nama_barang').val('');
        $('#data_deskripsi').val('');
        
        $('#uploadDataModal').modal('show');
    });
    
    // Upload Nilai button click
    $(document).on('click', '.upload-nilai-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#nilai_jenis_barang').val(jenis);
        $('#nilai_barang').val('');
        
        $('#uploadNilaiModal').modal('show');
    });
    
    // Verifikasi button click
    $(document).on('click', '.verifikasi-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#verifikasi_jenis_barang').val(jenis);
        $('#verifikasi_catatan_kendala').val('');
        $('#verifikasi_rencana_tindak_lanjut').val('');
        
        $('#verifikasiModal').modal('show');
    });
    
    // Feedback button click
    $(document).on('click', '.feedback-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#feedback_jenis_barang').val(jenis);
        
        $('#feedbackModal').modal('show');
    });
    
    // Upload Dok button click
    $(document).on('click', '.upload-dok-btn', function(){
        var jenis = $(this).data('jenis');
        var label = $(this).data('label');
        
        $('#dok_jenis_barang').val(jenis);
        $('#file_dokumen').val('');
        
        $('#uploadDokModal').modal('show');
    });
    
    // Preview button click
    $(document).on('click', '.preview-btn', function(){
        var id = $(this).data('id');
        currentDataId = id;
        
        $.get('<?= base_url('bantuan/barang/preview') ?>/' + id, function(res){
            if(res && res.ok){
                $('#preview_jenis_barang').text(res.data.jenis_barang);
                $('#preview_nama_barang').text(res.data.nama_barang);
                $('#preview_deskripsi').text(res.data.deskripsi || '-');
                $('#preview_nilai_barang').text(formatCurrency(res.data.nilai_barang || 0));
                $('#preview_status').text(res.data.status || 'Belum Diperiksa');
                $('#preview_file_name').text(res.data.file_name || '-');
                $('#preview_uploaded_at').text(formatDate(res.data.uploaded_at));
                
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
            window.open('<?= base_url('bantuan/barang/download') ?>/' + currentDataId, '_blank');
        }
    });
    
    // Upload Data form submit
    $('#uploadDataForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            jenis_barang: $('#data_jenis_barang').val(),
            nama_barang: $('#data_nama_barang').val(),
            deskripsi: $('#data_deskripsi').val()
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('bantuan/barang/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Data berhasil disimpan'); }
                $('#uploadDataModal').modal('hide');
                location.reload();
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
    
    // Upload Nilai form submit
    $('#uploadNilaiForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            jenis_barang: $('#nilai_jenis_barang').val(),
            nilai_barang: $('#nilai_barang').autoNumeric('get') // Get raw number using AutoNumeric
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('bantuan/barang/save') ?>', formData, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success(res.message || 'Nilai barang berhasil disimpan'); }
                $('#uploadNilaiModal').modal('hide');
                location.reload();
            } else {
                if(window.toastr){ toastr.error(res.message || 'Gagal menyimpan nilai'); }
            }
        }, 'json').fail(function(xhr){
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan nilai'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan nilai'); }
            }
        });
    });
    
    // Verifikasi form submit
    $('#verifikasiForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            jenis_barang: $('#verifikasi_jenis_barang').val(),
            catatan_kendala: $('#verifikasi_catatan_kendala').val(),
            rencana_tindak_lanjut: $('#verifikasi_rencana_tindak_lanjut').val()
        };
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('bantuan/barang/save') ?>', formData, function(res){
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
            jenis_barang: $('#feedback_jenis_barang').val(),
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
        
        $.post('<?= base_url('bantuan/barang/save') ?>', formData, function(res){
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
    
    // Upload Dok form submit
    $('#uploadDokForm').on('submit', function(e){
        e.preventDefault();
        
        var formData = new FormData(this);
        formData.append('tahun', <?= $tahun ?>);
        formData.append('bulan', <?= $bulan ?>);
        formData.append(csrfTokenName, csrfHash);
        
        $.ajax({
            url: '<?= base_url('bantuan/barang/upload') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    if(window.toastr){ toastr.success(res.message || 'Dokumen berhasil diupload'); }
                    $('#uploadDokModal').modal('hide');
                    location.reload();
                } else {
                    if(window.toastr){ toastr.error(res.message || 'Gagal mengupload dokumen'); }
                }
            },
            error: function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal mengupload dokumen'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal mengupload dokumen'); }
                }
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
        };
        
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('bantuan/barang/save') ?>', formData, function(res){
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
    
    function formatCurrency(n){ 
        try { 
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(n)); 
        } catch(e){ 
            return 'Rp ' + Number(n).toLocaleString('id-ID'); 
        } 
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
