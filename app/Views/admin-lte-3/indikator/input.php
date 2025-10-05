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
                    <select name="year" class="form-control rounded-0"
                        onchange="document.getElementById('filterForm').submit()">
                        <?php
                        $currentYear = date('Y');
                        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++):
                            ?>
                            <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Triwulan</label>
                    <select name="triwulan" class="form-control rounded-0"
                        onchange="document.getElementById('filterForm').submit()">
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
                        <th class="text-center" style="vertical-align: middle;" rowspan="2" colspan="2">Upload Data</th>
                        <th class="text-center" style="vertical-align: middle;" rowspan="2">Status</th>
                        <th class="text-center" style="vertical-align: middle;" colspan="6">Aksi</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="vertical-align: middle;">Verifikasi Bidang</th>
                        <th class="text-center" style="vertical-align: middle;">Hasil Tindak Lanjut</th>
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
                            <td>
                                <?= $label ?>
                            </td>
                            <td class="text-center" style="width: 1%; vertical-align: middle;">
                                <button type="button"
                                    class="btn btn-success btn-sm rounded-0 upload-catatan-btn d-flex align-items-center justify-content-center"
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #28a745; border-color: #28a745;">
                                    <i class="fas fa-upload mr-1"></i>
                                    <div class="uploaded-filename"
                                        style="display: none; font-size: 9px; margin-top: 2px; color: white; font-weight: bold; word-break: break-all;">
                                    </div>
                                </button>
                            </td>
                            <td style="vertical-align: middle;">
                                <span class="mx-1">
                                    <?php echo ($data['file_catatan_name'] ?? '') ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <?php 
                                $statusVerifikasi = $data['status_verifikasi_bidang'] ?? 'Belum Diperiksa';
                                $isSesuai = $statusVerifikasi === 'Sesuai';
                                $isTidakSesuai = $statusVerifikasi === 'Tidak Sesuai';
                                ?>
                                <div class="btn-group verifikasi-group" role="group" aria-label="Verifikasi" data-jenis="<?= $key ?>">
                                    <button type="button" 
                                        class="btn btn-sm rounded-0 btn-verifikasi-sesuai <?= $isSesuai ? 'btn-success' : 'btn-outline-success' ?>" 
                                        title="Sesuai"
                                        data-jenis="<?= $key ?>"
                                        data-status="Sesuai"
                                        style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button type="button" 
                                        class="btn btn-sm rounded-0 btn-verifikasi-tidak-sesuai <?= $isTidakSesuai ? 'btn-danger' : 'btn-outline-danger' ?>" 
                                        title="Tidak Sesuai"
                                        data-jenis="<?= $key ?>"
                                        data-status="Tidak Sesuai"
                                        style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="text-center align-middle" style="vertical-align: middle;">
                                <button type="button"
                                    class="btn btn-warning btn-sm rounded-0 d-flex justify-content-center align-items-center mx-auto verifikasi-bidang-btn"
                                    style="height: 38px; width: 38px;"
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>">
                                    <i class="fas fa-check mx-auto" style="display: block; margin: 0 auto;"></i>
                                </button>
                            </td>
                            <td class="text-center align-middle" style="vertical-align: middle;">
                                <button type="button"
                                    class="btn btn-info btn-sm rounded-0 upload-rencana-btn d-flex justify-content-center align-items-center mx-auto"
                                    data-jenis="<?= $key ?>" data-label="<?= $label ?>"
                                    style="background-color: #17a2b8; border-color: #17a2b8; height: 38px; width: 38px;">
                                    <i class="fas fa-comment mx-auto" style="display: block; margin: 0 auto;"></i>
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

<!-- Upload Catatan Modal -->
<div class="modal fade" id="uploadCatatanModal" tabindex="-1" role="dialog" aria-labelledby="uploadCatatanModalLabel"
    aria-hidden="true">
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
                        <input type="text" class="form-control rounded-0" id="catatan_jenis_indikator"
                            name="jenis_indikator" readonly>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Catatan Indikator</label>
                        <textarea class="form-control rounded-0" id="catatan_indikator" name="catatan_indikator"
                            rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">File Catatan</label>
                        <input type="file" class="form-control-file rounded-0" id="file_catatan" name="file"
                            accept=".xlsx,.xls,.pdf,.doc,.docx">
                        <small class="form-text text-muted">Format yang diperbolehkan: Excel, PDF, Word</small>
                        <div id="uploaded_filename" class="mt-2" style="display: none;">
                            <small class="text-success">
                                <i class="fas fa-check-circle"></i> File berhasil diupload: <span
                                    id="filename_display"></span>
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
<div class="modal fade" id="verifikasiBidangModal" tabindex="-1" role="dialog" aria-labelledby="verifikasiBidangModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="verifikasiBidangModalLabel">Verifikasi Bidang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="verifikasiBidangForm">
                <div class="modal-body">
                    <input type="hidden" name="jenis_indikator" id="rencana_jenis_indikator" value="">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="verifikatorTable">
                            <thead style="background-color: #3b6ea8; color: white;">
                                <tr>
                                    <th style="width: 30%; vertical-align: middle;">Verifikator</th>
                                    <th class="text-center" style="width: 30%; vertical-align: middle;">Hasil Verifikasi</th>
                                    <th class="text-center" style="width: 30%; vertical-align: middle;">Rencana Tindak Lanjut</th>
                                    <th class="text-center" style="width: 10%; vertical-align: middle;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="verifikatorTableBody">
                                <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="text-left mb-3">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="addRowBtn">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-0" id="selesaiBtn">
                        <i class="fas fa-check"></i> Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Hasil Tindak Lanjut Modal -->
<div class="modal fade" id="hasilTindakLanjutModal" tabindex="-1" role="dialog" aria-labelledby="hasilTindakLanjutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="hasilTindakLanjutModalLabel">Hasil Tindak Lanjut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="hasilTindakLanjutForm">
            <div class="modal-body">
                    <input type="hidden" name="jenis_indikator" id="hasil_jenis_indikator" value="">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered" id="hasilTindakLanjutTable">
                            <thead style="background-color: #3b6ea8; color: white;">
                                <tr>
                                    <th style="width: 50%; vertical-align: middle;">Verifikator</th>
                                    <th class="text-center" style="width: 50%; vertical-align: middle;">Hasil Tindak Lanjut</th>
                                </tr>
                            </thead>
                            <tbody id="hasilTindakLanjutTableBody">
                                <!-- Rows will be dynamically added here -->
                            </tbody>
                        </table>
                        </div>
                    
                    <div class="text-left mb-3">
                        <button type="button" class="btn btn-primary btn-sm rounded-0" id="addHasilRowBtn">
                            <i class="fas fa-plus"></i> Tambah Baris
                        </button>
                    </div>
                        </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info rounded-0" id="selesaiHasilBtn">
                        <i class="fas fa-check"></i> Selesai
                    </button>
                    </div>
            </form>
                </div>
                </div>
</div>

<!-- Upload Hasil Tindak Lanjut File Modal -->
<div class="modal fade" id="uploadHasilTindakLanjutFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadHasilTindakLanjutFileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadHasilTindakLanjutFileModalLabel">Upload File Hasil Tindak Lanjut</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadHasilTindakLanjutFileForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="hasil_htl_id" name="htl_id" value="">
                    <input type="hidden" id="hasil_htl_tahun" name="htl_tahun" value="">
                    <input type="hidden" id="hasil_htl_triwulan" name="htl_triwulan" value="">
                    <input type="hidden" id="hasil_htl_jenis_indikator" name="htl_jenis_indikator" value="">
                    <input type="hidden" id="hasil_htl_nama" name="htl_nama" value="">
                    
                    <div class="alert alert-info rounded-0">
                        <i class="fas fa-info-circle"></i> Upload file untuk: <strong id="hasil_htl_info_text"></strong>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Nama Verifikator</label>
                        <input type="text" class="form-control rounded-0" id="display_hasil_htl_nama" readonly>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Pilih File <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="hasil_htl_file" name="file" 
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                            <label class="custom-file-label rounded-0" for="hasil_htl_file">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: PDF, Word, Excel, atau gambar (JPG, PNG). Maksimal 10MB.
                        </small>
                    </div>

                    <div id="hasil_htl_current_file_info" style="display: none;">
                        <div class="alert alert-success rounded-0">
                            <i class="fas fa-file"></i> File saat ini: <strong id="hasil_htl_current_file_name"></strong>
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

<!-- Preview Hasil Tindak Lanjut File Modal -->
<div class="modal fade" id="previewHasilTindakLanjutFileModal" tabindex="-1" role="dialog" aria-labelledby="previewHasilTindakLanjutFileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="previewHasilTindakLanjutFileModalLabel">
                    <i class="fas fa-eye"></i> Preview File: <span id="preview_hasil_htl_file_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="preview_hasil_htl_loading" class="text-center py-5">
                    <i class="fas fa-spinner fa-spin fa-3x text-primary"></i>
                    <p class="mt-3">Loading file...</p>
                </div>
                <div id="preview_hasil_htl_error" style="display: none;" class="alert alert-danger m-3 rounded-0">
                    <i class="fas fa-exclamation-triangle"></i> <span id="preview_hasil_htl_error_message"></span>
                </div>
                <div id="preview_hasil_htl_content" style="display: none;">
                    <iframe id="preview_hasil_htl_iframe" style="width: 100%; height: 600px; border: none;"></iframe>
                </div>
                <div id="preview_hasil_htl_download_notice" style="display: none;" class="alert alert-info m-3 rounded-0">
                    <i class="fas fa-info-circle"></i> 
                    File ini tidak dapat ditampilkan di browser. Silakan download untuk melihat isi file.
                    <br>
                    <button type="button" class="btn btn-primary btn-sm rounded-0 mt-2" id="preview_hasil_htl_download_btn">
                        <i class="fas fa-download"></i> Download File
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-0" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary rounded-0" id="preview_hasil_htl_download_btn_footer">
                    <i class="fas fa-download"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Verifikator File Modal -->
<div class="modal fade" id="uploadVerifikatorFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadVerifikatorFileModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header" style="background-color: #3b6ea8; color: white;">
                <h5 class="modal-title" id="uploadVerifikatorFileModalLabel">Upload File Verifikator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="uploadVerifikatorFileForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="verif_id" name="verif_id" value="">
                    <input type="hidden" id="verif_type" name="verif_type" value="">
                    <input type="hidden" id="verif_tahun" name="verif_tahun" value="">
                    <input type="hidden" id="verif_triwulan" name="verif_triwulan" value="">
                    <input type="hidden" id="verif_jenis_indikator" name="verif_jenis_indikator" value="">
                    <input type="hidden" id="verif_nama" name="verif_nama" value="">
                    
                    <div class="alert alert-info rounded-0">
                        <i class="fas fa-info-circle"></i> Upload file untuk: <strong id="verif_info_text"></strong>
                    </div>

                <div class="form-group">
                        <label class="font-weight-bold">Nama Verifikator</label>
                        <input type="text" class="form-control rounded-0" id="display_verif_nama" readonly>
                </div>

                        <div class="form-group">
                        <label class="font-weight-bold">Pilih File <span class="text-danger">*</span></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="verif_file" name="file" 
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" required>
                            <label class="custom-file-label rounded-0" for="verif_file">Pilih file...</label>
                        </div>
                        <small class="form-text text-muted">
                            Format yang diperbolehkan: PDF, Word, Excel, atau gambar (JPG, PNG). Maksimal 10MB.
                        </small>
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
<div class="modal fade" id="previewFileModal" tabindex="-1" role="dialog" aria-labelledby="previewFileModalLabel"
    aria-hidden="true">
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

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    .upload-catatan-btn,
    .upload-rencana-btn,
    .preview-btn {
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

    .btn-verifikasi-sesuai,
    .btn-verifikasi-tidak-sesuai {
        min-width: 45px;
        transition: all 0.3s ease;
    }

    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
        background-color: transparent;
    }

    .btn-outline-success:hover {
        color: #fff;
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
        background-color: transparent;
    }

    .btn-outline-danger:hover {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .verifikasi-group .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    /* Verifikator Table Styles */
    #verifikatorTable {
        margin-bottom: 0;
    }

    #verifikatorTable thead th {
        border: 1px solid #dee2e6;
    }

    #verifikatorTable tbody td {
        vertical-align: middle;
    }

    #verifikatorTable .verifikator-row input[type="text"] {
        border: 1px solid #ced4da;
    }

    #verifikatorTable .verifikator-row input[type="text"]:focus {
        border-color: #3b6ea8;
        box-shadow: 0 0 0 0.2rem rgba(59, 110, 168, 0.25);
    }

    .remove-row-btn:hover {
        background-color: #c82333 !important;
        border-color: #bd2130 !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    (function () {
        var csrfToken = '<?= csrf_token() ?>';
        var csrfHash = '<?= csrf_hash() ?>';
        var csrfTokenName = '<?= service('security')->getTokenName() ?>';
        var currentDataId = null;

        // Function to open hasil tindak lanjut file preview
        function openHasilTindakLanjutFilePreview(htlId, fileName) {
            // Reset modal state
            $('#preview_hasil_htl_loading').show();
            $('#preview_hasil_htl_error').hide();
            $('#preview_hasil_htl_content').hide();
            $('#preview_hasil_htl_download_notice').hide();
            $('#preview_hasil_htl_iframe').attr('src', '');
            $('#preview_hasil_htl_file_title').text(fileName);

            // Open modal
            $('#previewHasilTindakLanjutFileModal').modal('show');

            // Get file extension
            var extension = fileName.split('.').pop().toLowerCase();
            var previewUrl = '<?= base_url('indikator/input/preview-hasil-htl-file') ?>/' + htlId;
            var downloadUrl = '<?= base_url('indikator/input/download-hasil-htl-file') ?>/' + htlId;

            // Set download button URLs
            $('#preview_hasil_htl_download_btn').off('click').on('click', function() {
                window.open(downloadUrl, '_blank');
            });
            $('#preview_hasil_htl_download_btn_footer').off('click').on('click', function() {
                window.open(downloadUrl, '_blank');
            });

            // Check if file can be previewed
            var canPreview = ['pdf', 'jpg', 'jpeg', 'png', 'gif'].indexOf(extension) !== -1;

            if (canPreview) {
                // Load file in iframe
                $('#preview_hasil_htl_iframe').on('load', function() {
                    $('#preview_hasil_htl_loading').hide();
                    $('#preview_hasil_htl_content').show();
                }).on('error', function() {
                    $('#preview_hasil_htl_loading').hide();
                    $('#preview_hasil_htl_error_message').text('Gagal memuat file preview');
                    $('#preview_hasil_htl_error').show();
                });

                // Set iframe source
                $('#preview_hasil_htl_iframe').attr('src', previewUrl);
            } else {
                // Show download notice for non-previewable files
                $('#preview_hasil_htl_loading').hide();
                $('#preview_hasil_htl_download_notice').show();
            }
        }

        // Upload Catatan button click
        $(document).on('click', '.upload-catatan-btn', function () {
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

        // Verifikasi Bidang button click
        $(document).on('click', '.verifikasi-bidang-btn', function () {
            var jenis = $(this).data('jenis');
            var label = $(this).data('label');

            $('#rencana_jenis_indikator').val(jenis);
            
            // Load existing data or use defaults
            loadVerifikatorData(jenis);

            $('#verifikasiBidangModal').modal('show');
        });

        // Hasil Tindak Lanjut button click
        $(document).on('click', '.upload-rencana-btn', function () {
            var jenis = $(this).data('jenis');
            var label = $(this).data('label');

            $('#hasil_jenis_indikator').val(jenis);
            
            // Load existing data or use defaults
            loadHasilTindakLanjutData(jenis);

            $('#hasilTindakLanjutModal').modal('show');
        });

        // Load verifikator data from database or use defaults
        function loadVerifikatorData(jenisIndikator) {
            var tbody = $('#verifikatorTableBody');
            tbody.empty();
            tbody.append('<tr><td colspan="4" class="text-center">Loading...</td></tr>');

            $.ajax({
                url: '<?= base_url('indikator/input/get-verifikator') ?>',
                type: 'GET',
                data: {
                    tahun: <?= $tahun ?>,
                    triwulan: <?= $triwulan ?>,
                    jenis_indikator: jenisIndikator
                },
                dataType: 'json',
                success: function (res) {
                    tbody.empty();
                    
                    if (res && res.ok && res.data && res.data.length > 0) {
                        // Load existing data from database
                        res.data.forEach(function(verif) {
                            addVerifikatorRow(verif.nama_verifikator, verif);
                        });
                    } else {
                        // Use default verifikators
                        resetVerifikatorTable();
                    }
                },
                error: function () {
                    tbody.empty();
                    // Use default verifikators on error
                    resetVerifikatorTable();
                }
            });
        }

        // Load hasil tindak lanjut data from database or use defaults
        function loadHasilTindakLanjutData(jenisIndikator) {
            var tbody = $('#hasilTindakLanjutTableBody');
            tbody.empty();
            tbody.append('<tr><td colspan="2" class="text-center">Loading...</td></tr>');

            $.ajax({
                url: '<?= base_url('indikator/input/get-verifikator') ?>',
                type: 'GET',
                data: {
                    tahun: <?= $tahun ?>,
                    triwulan: <?= $triwulan ?>,
                    jenis_indikator: jenisIndikator
                },
                dataType: 'json',
                success: function (res) {
                    tbody.empty();
                    
                    if (res && res.ok && res.data && res.data.length > 0) {
                        // Load existing data from database
                        res.data.forEach(function(verif) {
                            addHasilTindakLanjutRow(verif.nama_verifikator, verif);
                        });
                    } else {
                        // Use default verifikators
                        resetHasilTindakLanjutTable();
                    }
                },
                error: function () {
                    tbody.empty();
                    // Use default verifikators on error
                    resetHasilTindakLanjutTable();
                }
            });
        }

        // Reset verifikator table with default rows
        function resetVerifikatorTable() {
            var defaultVerifikators = ['Sekretariat', 'Bidang Minerba', 'Bidang GAT', 'Bidang EBT', 'Bidang Gatrik'];
            var tbody = $('#verifikatorTableBody');
            tbody.empty();
            
            defaultVerifikators.forEach(function(verifikator) {
                addVerifikatorRow(verifikator);
            });
        }

        // Reset hasil tindak lanjut table with default rows
        function resetHasilTindakLanjutTable() {
            var defaultVerifikators = ['Sekretariat', 'Bidang Minerba', 'Bidang GAT', 'Bidang EBT', 'Bidang Gatrik'];
            var tbody = $('#hasilTindakLanjutTableBody');
            tbody.empty();
            
            defaultVerifikators.forEach(function(verifikator) {
                addHasilTindakLanjutRow(verifikator);
            });
        }

        // Add new row to verifikator table
        function addVerifikatorRow(verifikatorName = '', verifData = null) {
            var rowId = 'verif_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            // Get verif ID if data exists
            var verifId = verifData ? verifData.id : '';
            var hasilFile = verifData ? verifData.hasil_verifikasi_file_name : '';
            var rencanaFile = verifData ? verifData.rencana_tindak_lanjut_file_name : '';
            
            var newRow = `
                <tr class="verifikator-row" data-row-id="${rowId}" data-verif-id="${verifId}">
                    <td>
                        <input type="text" class="form-control rounded-0 verifikator-name-input" name="verifikator[]" placeholder="Nama Verifikator" value="${verifikatorName}" data-row-id="${rowId}">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm rounded-0 btn-upload-verif ${hasilFile ? 'btn-success' : ''}" title="${hasilFile ? hasilFile : 'Upload Dokumen'}" 
                            data-row-id="${rowId}" data-type="hasil" data-verif-name="${verifikatorName}"
                            style="background-color: ${hasilFile ? '#28a745' : '#28a745'}; border-color: ${hasilFile ? '#28a745' : '#6f42c1'};">
                            <i class="fas ${hasilFile ? 'fa-file-alt' : 'fa-file-upload'}" style="color: #fff;"></i>
                        </button>
                        ${hasilFile ? `
                        <button type="button" class="btn btn-sm rounded-0 mr-1 btn-check-status" title="Check" data-row-id="${rowId}" data-type="hasil" style="background-color: #6f42c1; color: #fff;">
                            <i class="fas fa-eye"></i>
                        </button>
                        ` : ''}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm rounded-0 mr-1 btn-check-status" title="Check" data-row-id="${rowId}" data-type="rencana">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm rounded-0 btn-upload-verif ${rencanaFile ? 'btn-success' : ''}" title="${rencanaFile ? rencanaFile : 'Upload Dokumen'}"
                            data-row-id="${rowId}" data-type="rencana" data-verif-name="${verifikatorName}"
                            style="background-color: ${rencanaFile ? '#28a745' : '#6f42c1'}; border-color: ${rencanaFile ? '#28a745' : '#6f42c1'};">
                            <i class="fas ${rencanaFile ? 'fa-check-circle' : 'fa-file-alt'}"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm rounded-0 remove-row-btn" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#verifikatorTableBody').append(newRow);
        }

        // Add new row to hasil tindak lanjut table
        function addHasilTindakLanjutRow(verifikatorName = '', verifData = null) {
            var rowId = 'hasil_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            
            // Get verif ID if data exists
            var verifId = verifData ? verifData.id : '';
            var hasilFile = verifData ? verifData.hasil_verifikasi_file_name : '';
            
            var newRow = `
                <tr class="hasil-tindak-lanjut-row" data-row-id="${rowId}" data-verif-id="${verifId}">
                    <td>
                        <input type="text" class="form-control rounded-0 hasil-verifikator-name-input" name="hasil_verifikator[]" placeholder="Nama Verifikator" value="${verifikatorName}" data-row-id="${rowId}">
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-success btn-sm rounded-0 mr-1 btn-check-hasil-status" title="Check" data-row-id="${rowId}">
                                <i class="fas fa-file-upload"></i>
                            </button>
                            <button type="button" class="btn btn-sm rounded-0 btn-upload-hasil ${hasilFile ? 'btn-success' : ''}" title="${hasilFile ? hasilFile : 'Upload Dokumen'}" 
                                data-row-id="${rowId}" data-verif-name="${verifikatorName}"
                                style="background-color: ${hasilFile ? '#28a745' : '#6f42c1'}; border-color: ${hasilFile ? '#28a745' : '#6f42c1'};">
                                <i class="fas ${hasilFile ? 'fa-check-circle' : 'fa-file-alt'}"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            $('#hasilTindakLanjutTableBody').append(newRow);
        }

        // Add row button click
        $(document).on('click', '#addRowBtn', function () {
            addVerifikatorRow();
        });

        // Add hasil row button click
        $(document).on('click', '#addHasilRowBtn', function () {
            addHasilTindakLanjutRow();
        });

        // Remove row button click
        $(document).on('click', '.remove-row-btn', function () {
            // Ensure at least one row remains
            if ($('.verifikator-row').length > 1) {
                $(this).closest('tr').remove();
            } else {
                if (window.toastr) {
                    toastr.warning('Minimal harus ada 1 baris verifikator');
                } else {
                    alert('Minimal harus ada 1 baris verifikator');
                }
            }
        });

        // Upload verifikator file button click
        $(document).on('click', '.btn-upload-verif', function () {
            var rowId = $(this).data('row-id');
            var type = $(this).data('type'); // 'hasil' or 'rencana'
            var row = $('tr[data-row-id="' + rowId + '"]');
            var verifId = row.data('verif-id');
            var verifName = row.find('.verifikator-name-input').val();
            var jenisIndikator = $('#rencana_jenis_indikator').val();

            console.log('Upload button clicked:', {
                rowId: rowId,
                type: type,
                verifId: verifId,
                verifName: verifName,
                jenisIndikator: jenisIndikator
            });

            if (!verifName || verifName.trim() === '') {
                if (window.toastr) {
                    toastr.warning('Nama verifikator harus diisi terlebih dahulu');
                }
                return;
            }

            if (!jenisIndikator || jenisIndikator.trim() === '') {
                if (window.toastr) {
                    toastr.error('Jenis indikator tidak ditemukan. Silakan tutup dan buka kembali modal.');
                }
                return;
            }

            // Set modal data
            $('#verif_id').val(verifId || '');
            $('#verif_type').val(type);
            $('#verif_tahun').val(<?= $tahun ?>);
            $('#verif_triwulan').val(<?= $triwulan ?>);
            $('#verif_jenis_indikator').val(jenisIndikator);
            $('#verif_nama').val(verifName);
            $('#display_verif_nama').val(verifName);

            var infoText = type === 'hasil' ? 'Hasil Verifikasi' : 'Rencana Tindak Lanjut';
            $('#verif_info_text').text(infoText + ' - ' + verifName);

            // Reset file input
            $('#verif_file').val('');
            $('.custom-file-label').text('Pilih file...');
            $('#current_file_info').hide();

            // Show current file if exists
            var currentFile = $(this).attr('title');
            if (currentFile && currentFile !== 'Upload Dokumen') {
                $('#current_file_name').text(currentFile);
                $('#current_file_info').show();
            }

            $('#uploadVerifikatorFileModal').modal('show');
        });

        // Update file input label
        $('#verif_file').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Update hasil file input label
        $('#hasil_htl_file').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Upload verifikator file form submit
        $('#uploadVerifikatorFileForm').on('submit', function (e) {
            e.preventDefault();

            // Debug: Check form values before submission
            console.log('Form submission - Hidden field values:', {
                verif_id: $('#verif_id').val(),
                verif_type: $('#verif_type').val(),
                verif_tahun: $('#verif_tahun').val(),
                verif_triwulan: $('#verif_triwulan').val(),
                verif_jenis_indikator: $('#verif_jenis_indikator').val(),
                verif_nama: $('#verif_nama').val()
            });

            var formData = new FormData(this);
            formData.append(csrfTokenName, csrfHash);

            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

            $.ajax({
                url: '<?= base_url('indikator/input/upload-verifikator-file') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                    
                    submitBtn.prop('disabled', false).html(originalBtnText);

                    if (res && res.ok) {
                        if (window.toastr) { 
                            toastr.success(res.message || 'File berhasil diupload'); 
                        }
                        $('#uploadVerifikatorFileModal').modal('hide');
                        
                        // Update button appearance
                        var type = $('#verif_type').val();
                        var verifId = $('#verif_id').val();
                        var fileName = res.file_name;
                        
                        // Find and update the button
                        var btn = $('.btn-upload-verif[data-type="' + type + '"]').filter(function() {
                            var row = $(this).closest('tr');
                            return row.data('verif-id') == verifId || 
                                   row.find('.verifikator-name-input').val() === $('#verif_nama').val();
                        }).first();

                        if (btn.length > 0) {
                            btn.attr('title', fileName);
                            btn.css({
                                'background-color': '#28a745',
                                'border-color': '#28a745'
                            });
                            btn.removeClass('btn-info').addClass('btn-success');
                            btn.find('i').removeClass('fa-file-alt').addClass('fa-check-circle');
                            
                            // Update row verif ID if new
                            if (res.verif_id && !verifId) {
                                btn.closest('tr').attr('data-verif-id', res.verif_id);
                            }
                        }
                    } else {
                        if (window.toastr) { 
                            toastr.error(res.message || 'Gagal mengupload file'); 
                        }
                    }
                },
                error: function (xhr) {
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

        // Upload hasil tindak lanjut file form submit
        $('#uploadHasilTindakLanjutFileForm').on('submit', function (e) {
            e.preventDefault();

            // Debug: Check form values before submission
            console.log('Hasil HTL Form submission - Hidden field values:', {
                htl_id: $('#hasil_htl_id').val(),
                htl_tahun: $('#hasil_htl_tahun').val(),
                htl_triwulan: $('#hasil_htl_triwulan').val(),
                htl_jenis_indikator: $('#hasil_htl_jenis_indikator').val(),
                htl_nama: $('#hasil_htl_nama').val()
            });

            var formData = new FormData(this);
            formData.append(csrfTokenName, csrfHash);

            var submitBtn = $(this).find('button[type="submit"]');
            var originalBtnText = submitBtn.html();
            submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Uploading...');

            $.ajax({
                url: '<?= base_url('indikator/input/upload-hasil-htl-file') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (res) {
                    if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                    
                    submitBtn.prop('disabled', false).html(originalBtnText);

                    if (res && res.ok) {
                        if (window.toastr) { 
                            toastr.success(res.message || 'File berhasil diupload'); 
                        }
                        $('#uploadHasilTindakLanjutFileModal').modal('hide');
                        
                        // Update button appearance
                        var htlId = $('#hasil_htl_id').val();
                        var fileName = res.file_name;
                        
                        // Find and update the button
                        var btn = $('.btn-upload-hasil').filter(function() {
                            var row = $(this).closest('tr');
                            return row.data('verif-id') == htlId || 
                                   row.find('.hasil-verifikator-name-input').val() === $('#hasil_htl_nama').val();
                        }).first();

                        if (btn.length > 0) {
                            btn.attr('title', fileName);
                            btn.css({
                                'background-color': '#28a745',
                                'border-color': '#28a745'
                            });
                            btn.removeClass('btn-info').addClass('btn-success');
                            btn.find('i').removeClass('fa-file-alt').addClass('fa-check-circle');
                            
                            // Update row htl ID if new
                            if (res.htl_id && !htlId) {
                                btn.closest('tr').attr('data-verif-id', res.htl_id);
                            }
                        }
                    } else {
                        if (window.toastr) { 
                            toastr.error(res.message || 'Gagal mengupload file'); 
                        }
                    }
                },
                error: function (xhr) {
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

        // Preview hasil tindak lanjut file button click
        $(document).on('click', '.btn-check-hasil-status', function () {
            var rowId = $(this).data('row-id');
            var row = $('tr[data-row-id="' + rowId + '"]');
            var htlId = row.data('verif-id');

            if (!htlId) {
                if (window.toastr) {
                    toastr.warning('Belum ada file yang diupload untuk verifikator ini');
                }
                return;
            }

            // Get file info from button
            var uploadBtn = row.find('.btn-upload-hasil');
            var fileName = uploadBtn.attr('title');

            if (!fileName || fileName === 'Upload Dokumen') {
                if (window.toastr) {
                    toastr.warning('Belum ada file yang diupload');
                }
                return;
            }

            // Open preview modal - inline function
            $('#preview_hasil_htl_loading').show();
            $('#preview_hasil_htl_error').hide();
            $('#preview_hasil_htl_content').hide();
            $('#preview_hasil_htl_download_notice').hide();
            $('#preview_hasil_htl_iframe').attr('src', '');
            $('#preview_hasil_htl_file_title').text(fileName);
            $('#previewHasilTindakLanjutFileModal').modal('show');
            
            var extension = fileName.split('.').pop().toLowerCase();
            var previewUrl = '<?= base_url('indikator/input/preview-hasil-htl-file') ?>/' + htlId;
            var downloadUrl = '<?= base_url('indikator/input/download-hasil-htl-file') ?>/' + htlId;
            
            if (['pdf', 'jpg', 'jpeg', 'png', 'gif'].indexOf(extension) !== -1) {
                $('#preview_hasil_htl_iframe').attr('src', previewUrl);
                $('#preview_hasil_htl_loading').hide();
                $('#preview_hasil_htl_content').show();
            } else {
                $('#preview_hasil_htl_loading').hide();
                $('#preview_hasil_htl_download_notice').show();
            }
        });

        // Preview file button click (eye button in verifikator table)
        $(document).on('click', '.btn-check-status', function () {
            var rowId = $(this).data('row-id');
            var type = $(this).data('type'); // 'hasil' or 'rencana'
            var row = $('tr[data-row-id="' + rowId + '"]');
            var verifId = row.data('verif-id');


            // Get file info from button
            var uploadBtn = row.find('.btn-upload-verif[data-type="' + type + '"]');
            var fileName = uploadBtn.attr('title');

            // Open preview modal
            openFilePreview(verifId, type, fileName);
        });

        // Function to open file preview
        function openFilePreview(verifId, type, fileName) {
            // Reset modal state
            $('#preview_loading').show();
            $('#preview_error').hide();
            $('#preview_content').hide();
            $('#preview_download_notice').hide();
            $('#preview_iframe').attr('src', '');
            $('#preview_file_title').text(fileName);

            var typeText = type === 'hasil' ? 'Hasil Verifikasi' : 'Rencana Tindak Lanjut';
            
            // Open modal
            $('#previewFileModal').modal('show');

            // Get file extension
            var extension = fileName.split('.').pop().toLowerCase();
            var previewUrl = '<?= base_url('indikator/input/preview-verifikator-file') ?>/' + verifId + '/' + type;
            var downloadUrl = '<?= base_url('indikator/input/download-verifikator-file') ?>/' + verifId + '/' + type;

            // Set download button URLs
            $('#preview_download_btn').off('click').on('click', function() {
                window.open(downloadUrl, '_blank');
            });
            $('#preview_download_btn_footer').off('click').on('click', function() {
                window.open(downloadUrl, '_blank');
            });

            // Check if file can be previewed
            var canPreview = ['pdf', 'jpg', 'jpeg', 'png', 'gif'].indexOf(extension) !== -1;

            if (canPreview) {
                // Load file in iframe
                $('#preview_iframe').on('load', function() {
                    $('#preview_loading').hide();
                    $('#preview_content').show();
                }).on('error', function() {
                    $('#preview_loading').hide();
                    $('#preview_error_message').text('Gagal memuat file preview');
                    $('#preview_error').show();
                });

                // Set iframe source
                $('#preview_iframe').attr('src', previewUrl);
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

        // Preview button click
        $(document).on('click', '.preview-btn', function () {
            var id = $(this).data('id');
            currentDataId = id;

            $.get('<?= base_url('indikator/input/preview') ?>/' + id, function (res) {
                if (res && res.ok) {
                    $('#preview_jenis_indikator').text(res.data.jenis_indikator);
                    $('#preview_triwulan').text('Triwulan ' + res.data.triwulan);
                    $('#preview_catatan_indikator').text(res.data.catatan_indikator || '-');
                    $('#preview_rencana_tindak_lanjut').text(res.data.rencana_tindak_lanjut || '-');
                    $('#preview_file_catatan').text(res.data.file_catatan_name || '-');
                    $('#preview_file_rencana').text(res.data.file_rencana_name || '-');
                    $('#preview_uploaded_at').text(formatDate(res.data.uploaded_at));
                    
                    // Display verification status with badge
                    var statusVerifikasi = res.data.status_verifikasi_bidang || 'Belum Diperiksa';
                    var badgeClass = 'badge-secondary';
                    if (statusVerifikasi === 'Sesuai') {
                        badgeClass = 'badge-success';
                    } else if (statusVerifikasi === 'Tidak Sesuai') {
                        badgeClass = 'badge-danger';
                    }
                    $('#preview_status_verifikasi').html('<span class="badge ' + badgeClass + '">' + statusVerifikasi + '</span>');
                    $('#preview_tanggal_verifikasi').text(formatDate(res.data.tanggal_verifikasi));

                    $('#previewModal').modal('show');
                } else {
                    if (window.toastr) { toastr.error(res.message || 'Gagal memuat data'); }
                }
            }, 'json').fail(function () {
                if (window.toastr) { toastr.error('Gagal memuat data'); }
            });
        });

        // Download buttons
        $(document).on('click', '#downloadCatatanBtn', function () {
            if (currentDataId) {
                window.open('<?= base_url('indikator/input/download-catatan') ?>/' + currentDataId, '_blank');
            }
        });

        $(document).on('click', '#downloadRencanaBtn', function () {
            if (currentDataId) {
                window.open('<?= base_url('indikator/input/download-rencana') ?>/' + currentDataId, '_blank');
            }
        });

        // Upload Catatan form submit
        $('#uploadCatatanForm').on('submit', function (e) {
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
                success: function (res) {
                    if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                    if (res && res.ok) {
                        // Show uploaded filename in the button
                        if (res.filename) {
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
                        if (window.toastr) { toastr.success(res.message || 'File catatan berhasil diupload'); }

                        // Hide modal after showing result
                        $('#uploadCatatanModal').modal('hide');
                    } else {
                        if (window.toastr) { toastr.error(res.message || 'Gagal mengupload file'); }
                    }
                },
                error: function (xhr) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                        if (window.toastr) { toastr.error(data.message || 'Gagal mengupload file'); }
                    } catch (e) {
                        if (window.toastr) { toastr.error('Gagal mengupload file'); }
                    }
                }
            });
        });

        // Save verifikator names only when adding new verifikators without files
        function saveVerifikatorNames() {
            // Collect only NEW verifikators (without verif_id) that haven't uploaded files yet
            var newVerifikators = [];
            $('.verifikator-row').each(function() {
                var verifId = $(this).data('verif-id');
                var verifikatorName = $(this).find('input[name="verifikator[]"]').val();
                
                // Only include new verifikators that don't have an ID yet
                if (!verifId && verifikatorName.trim() !== '') {
                    newVerifikators.push({
                        nama: verifikatorName.trim()
                    });
                }
            });

            // Only save if there are new verifikators
            if (newVerifikators.length === 0) {
                return Promise.resolve(); // Nothing to save
            }

            var formData = {
                tahun: <?= $tahun ?>,
                triwulan: <?= $triwulan ?>,
                jenis_indikator: $('#rencana_jenis_indikator').val(),
                verifikator_data: JSON.stringify(newVerifikators)
            };
            formData[csrfTokenName] = csrfHash;

            return $.ajax({
                url: '<?= base_url('indikator/input/upload-rencana') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json'
            });
        }

        // Selesai button click handler
        $(document).on('click', '#selesaiBtn', function () {
            var btn = $(this);
            var originalText = btn.html();
            
            // Disable button and show loading
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            
            // Save new verifikators (if any)
            saveVerifikatorNames().then(function(res) {
                    if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                
                // Close modal
                $('#verifikasiBidangModal').modal('hide');
                
                // Show success message
                if (window.toastr) {
                    toastr.success('Data verifikator berhasil disimpan');
                }
            }).catch(function(xhr) {
                // Re-enable button on error
                btn.prop('disabled', false).html(originalText);
                
                    try {
                        var data = JSON.parse(xhr.responseText);
                        if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { 
                        toastr.error(data.message || 'Gagal menyimpan data'); 
                    }
                    } catch (e) {
                    if (window.toastr) { 
                        toastr.error('Gagal menyimpan data'); 
                    }
                }
            });
        });

        // Selesai hasil tindak lanjut button click handler
        $(document).on('click', '#selesaiHasilBtn', function () {
            var btn = $(this);
            var originalText = btn.html();
            
            // Disable button and show loading
            btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
            
            // Save new verifikators (if any)
            saveHasilTindakLanjutNames().then(function(res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                
                // Close modal
                $('#hasilTindakLanjutModal').modal('hide');
                
                // Show success message
                if (window.toastr) {
                    toastr.success('Data hasil tindak lanjut berhasil disimpan');
                }
            }).catch(function(xhr) {
                // Re-enable button on error
                btn.prop('disabled', false).html(originalText);
                
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { 
                        toastr.error(data.message || 'Gagal menyimpan data'); 
                    }
                } catch (e) {
                    if (window.toastr) { 
                        toastr.error('Gagal menyimpan data'); 
                    }
                }
            });
        });

        // Save hasil tindak lanjut names only when adding new verifikators without files
        function saveHasilTindakLanjutNames() {
            // Collect only NEW verifikators (without verif_id) that haven't uploaded files yet
            var newVerifikators = [];
            $('.hasil-tindak-lanjut-row').each(function() {
                var verifId = $(this).data('verif-id');
                var verifikatorName = $(this).find('input[name="hasil_verifikator[]"]').val();
                
                // Only include new verifikators that don't have an ID yet
                if (!verifId && verifikatorName.trim() !== '') {
                    newVerifikators.push({
                        nama: verifikatorName.trim()
                    });
                }
            });

            // Only save if there are new verifikators
            if (newVerifikators.length === 0) {
                return Promise.resolve(); // Nothing to save
            }

            var formData = {
                tahun: <?= $tahun ?>,
                triwulan: <?= $triwulan ?>,
                jenis_indikator: $('#hasil_jenis_indikator').val(),
                verifikator_data: JSON.stringify(newVerifikators)
            };
            formData[csrfTokenName] = csrfHash;

            return $.ajax({
                url: '<?= base_url('indikator/input/upload-rencana') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json'
            });
        }

        // Save button
        $('#btnSave').on('click', function () {
            var formData = {
                tahun: <?= $tahun ?>,
                triwulan: <?= $triwulan ?>,
            };

            formData[csrfTokenName] = csrfHash;

            $.post('<?= base_url('indikator/input/save') ?>', formData, function (res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                if (res && res.csrf_token) { csrfToken = res.csrf_token; }
                if (res && res.ok) {
                    if (window.toastr) { toastr.success(res.message || 'Data berhasil disimpan'); }
                } else {
                    if (window.toastr) { toastr.error(res.message || 'Gagal menyimpan data'); }
                }
            }, 'json').fail(function (xhr) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (data && data.csrf_token) { csrfToken = data.csrf_token; }
                    if (window.toastr) { toastr.error(data.message || 'Gagal menyimpan data'); }
                } catch (e) {
                    if (window.toastr) { toastr.error('Gagal menyimpan data'); }
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

        // Verification button click handlers
        $(document).on('click', '.btn-verifikasi-sesuai, .btn-verifikasi-tidak-sesuai', function () {
            var jenis = $(this).data('jenis');
            var status = $(this).data('status');
            var btnGroup = $(this).closest('.verifikasi-group');
            var btnSesuai = btnGroup.find('.btn-verifikasi-sesuai');
            var btnTidakSesuai = btnGroup.find('.btn-verifikasi-tidak-sesuai');

            // Show confirmation
            if (!confirm('Apakah Anda yakin ingin mengubah status verifikasi menjadi "' + status + '"?')) {
                return;
            }

            var formData = {
                tahun: <?= $tahun ?>,
                triwulan: <?= $triwulan ?>,
                jenis_indikator: jenis,
                status: status
            };
            formData[csrfTokenName] = csrfHash;

            // Disable buttons during request
            btnSesuai.prop('disabled', true);
            btnTidakSesuai.prop('disabled', true);

            $.ajax({
                url: '<?= base_url('indikator/input/update-verifikasi') ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (res) {
                    if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                    
                    // Re-enable buttons
                    btnSesuai.prop('disabled', false);
                    btnTidakSesuai.prop('disabled', false);

                    if (res && res.ok) {
                        // Update button styles based on the selected status
                        if (status === 'Sesuai') {
                            btnSesuai.removeClass('btn-outline-success').addClass('btn-success');
                            btnTidakSesuai.removeClass('btn-danger').addClass('btn-outline-danger');
                        } else {
                            btnTidakSesuai.removeClass('btn-outline-danger').addClass('btn-danger');
                            btnSesuai.removeClass('btn-success').addClass('btn-outline-success');
                        }
                        
                        if (window.toastr) { 
                            toastr.success(res.message || 'Status verifikasi berhasil diperbarui'); 
                        }
                    } else {
                        if (window.toastr) { 
                            toastr.error(res.message || 'Gagal memperbarui status verifikasi'); 
                        }
                    }
                },
                error: function (xhr) {
                    // Re-enable buttons
                    btnSesuai.prop('disabled', false);
                    btnTidakSesuai.prop('disabled', false);

                    try {
                        var data = JSON.parse(xhr.responseText);
                        if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                        if (window.toastr) { 
                            toastr.error(data.message || 'Gagal memperbarui status verifikasi'); 
                        }
                    } catch (e) {
                        if (window.toastr) { 
                            toastr.error('Gagal memperbarui status verifikasi'); 
                        }
                    }
                }
            });
        });
    })();
</script>
<?= $this->endSection() ?>