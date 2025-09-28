<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
    $feedbackData = $existing['feedback_unit_kerja'] ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">MONITORING PROGRES PENCATATAN PBJ</h3>
        <div class="d-flex align-items-center">
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
                            <th class="text-center">Aksi</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-center">Preview</th>
                            <th class="text-center">Verifikasi Sekretariat</th>
                            <th class="text-center">Feed back Unit Kerja</th>
                            <th class="text-center">Cetak (excel, Pdf)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Monitoring Progres Pencatatan PBJ
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-lock"></i>
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
                                <button type="button" class="btn btn-info btn-sm mr-1" title="Preview">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-warning btn-sm mr-1" title="Verifikasi Sekretariat" data-toggle="modal" data-target="#verifikasiModal">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary btn-sm mr-1" title="Feed back Unit Kerja" data-toggle="modal" data-target="#feedbackModal">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-info btn-sm" title="Cetak" onclick="exportToExcel()">
                                    <i class="fas fa-file-alt"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Verifikasi Sekretariat Section -->
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Verifikasi Sekretariat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Catatan Kendala</label>
                            <textarea name="catatan_kendala" class="form-control" rows="3" 
                                      placeholder="Catatan kendala"><?= $existing['catatan_kendala'] ?? '' ?></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Rencana Tindak Lanjut</label>
                            <textarea name="rencana_tindak_lanjut" class="form-control" rows="3" 
                                      placeholder="Rencana tindak lanjut"><?= $existing['rencana_tindak_lanjut'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feed back Unit Kerja Section -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Feed back Unit Kerja</h5>
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
                                <?php for($i = 1; $i <= 2; $i++): ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td>
                                        <input type="text" name="feedback_unit_kerja[<?= $i ?>][unit_kerja]" 
                                               class="form-control form-control-sm" 
                                               value="<?= $feedbackData[$i]['unit_kerja'] ?? '' ?>" 
                                               placeholder="Unit Kerja">
                                    </td>
                                    <td>
                                        <textarea name="feedback_unit_kerja[<?= $i ?>][alasan_saran]" 
                                                  class="form-control form-control-sm" rows="2" 
                                                  placeholder="Alasan dan saran tindak lanjut perbaikan"><?= $feedbackData[$i]['alasan_saran'] ?? '' ?></textarea>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
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
        </form>
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
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    
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
        // Create a simple table export
        var table = document.querySelector('.table');
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'pbj_progres_<?= $tahun ?>_<?= bulan_ke_str($bulan) ?>.xlsx');
    }
    
    // Make export function globally available
    window.exportToExcel = exportToExcel;
})();
</script>
<?= $this->endSection() ?>
