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
        <h3 class="card-title mb-0">INDEKS REALISASI PDN</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form id="pbjPdnForm" method="post">
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

            <div class="table-responsive rounded-0">
                <table class="table table-bordered rounded-0">
                    <thead style="background-color: #8B4513; color: white;">
                        <tr>
                            <th style="width: 200px;">PAGU RUP TAGGING PDN (Rp.)</th>
                            <th class="text-center">REALISASI PDN (Rp.)</th>
                            <th class="text-center">INDEKS</th>
                            <th class="text-center">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-right">
                                <input type="number" name="pagu_rup_tagging_pdn" 
                                       value="<?= $existing['pagu_rup_tagging_pdn'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="pagu_rup_tagging_pdn" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="realisasi_pdn" 
                                       value="<?= $existing['realisasi_pdn'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="realisasi_pdn" step="0.01">
                            </td>
                            <td class="text-right">
                                <span class="calculated-indeks"><?= format_angka($existing['indeks'] ?? 0, 2) ?></span>%
                            </td>
                            <td>
                                <textarea name="keterangan" class="form-control form-control-sm" rows="2" 
                                          placeholder="Keterangan"><?= $existing['keterangan'] ?? '' ?></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Formula Section -->
            <div class="mt-3 mb-3">
                <h5 class="text-primary font-weight-bold">Rumus :</h5>
                <p class="text-muted">Indeks = Realisasi PDN (Rp) / Pagu RUP Tagging PDN (Rp) × 100%</p>
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
.editable-input {
    border: 1px solid #ddd;
    background: #f8f9fa;
}
.editable-input:focus {
    border-color: #007bff;
    background: white;
}
.calculated-indeks {
    font-weight: bold;
    color: #333;
    font-size: 1.1em;
}
.badge-success {
    background-color: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 3px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    var csrfTokenName = '<?= config('Security')->tokenName ?>';
    
    function formatCurrency(n){ 
        try { 
            return new Intl.NumberFormat('id-ID').format(Number(n)); 
        } catch(e){ 
            return Number(n).toLocaleString('id-ID'); 
        } 
    }
    
    function formatCurrencyRp(n){ 
        try { 
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(Number(n)); 
        } catch(e){ 
            return 'Rp ' + Number(n).toLocaleString('id-ID'); 
        } 
    }
    
    function recalculateIndeks(){
        var paguRupTaggingPdn = parseFloat($('input[name="pagu_rup_tagging_pdn"]').val()) || 0;
        var realisasiPdn = parseFloat($('input[name="realisasi_pdn"]').val()) || 0;
        
        // Calculate indeks: Realisasi PDN / Pagu RUP Tagging PDN * 100
        var indeks = paguRupTaggingPdn > 0 ? (realisasiPdn / paguRupTaggingPdn) * 100 : 0;
        
        $('.calculated-indeks').text(indeks.toFixed(2));
    }
    
    // Recalculate on input change
    $(document).on('input', 'input[type="number"]', function(){
        recalculateIndeks();
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: <?= $bulan ?>,
            pagu_rup_tagging_pdn: parseFloat($('input[name="pagu_rup_tagging_pdn"]').val()) || 0,
            realisasi_pdn: parseFloat($('input[name="realisasi_pdn"]').val()) || 0,
            keterangan: $('textarea[name="keterangan"]').val()
        };
        
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('pbj/input/realisasi_pdn/save') ?>', formData, function(res){
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
    
    // Export functions
    function exportToExcel() {
        // Create a simple table export
        var table = document.querySelector('.table');
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'pbj_pdn_<?= $tahun ?>_<?= bulan_ke_str($bulan) ?>.xlsx');
    }
    
    function exportToPdf() {
        // Simple PDF export using window.print
        window.print();
    }
    
    // Make export functions globally available
    window.exportToExcel = exportToExcel;
    window.exportToPdf = exportToPdf;
    
    // Initial calculation
    recalculateIndeks();
})();
</script>
<?= $this->endSection() ?>
