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
        <h3 class="card-title mb-0">PBJ</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form id="pbjInputForm" method="post">
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
                    <thead style="background-color: #3b6ea8; color: white;">
                        <tr>
                            <th style="width: 200px;">Uraian</th>
                            <th class="text-center">RUP Tender</th>
                            <th class="text-center">RUP E-Purchasing</th>
                            <th class="text-center">RUP Non Tender</th>
                            <th class="text-center">SWAKELOLA</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th class="text-center">Pagu (Rp)</th>
                            <th class="text-center">Pagu (Rp)</th>
                            <th class="text-center">Pagu (Rp)</th>
                            <th class="text-center">Pagu (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Pagu Row -->
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Pagu (Rp)
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_tender_pagu" value="<?= $existing['rup_tender_pagu'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_tender_pagu" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_epurchasing_pagu" value="<?= $existing['rup_epurchasing_pagu'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_epurchasing_pagu" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_nontender_pagu" value="<?= $existing['rup_nontender_pagu'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_nontender_pagu" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="swakelola_pagu" value="<?= $existing['swakelola_pagu'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="swakelola_pagu" step="0.01">
                            </td>
                        </tr>
                        
                        <!-- Realisasi Row -->
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Realisasi (Rp)
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_tender_realisasi" value="<?= $existing['rup_tender_realisasi'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_tender_realisasi" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_epurchasing_realisasi" value="<?= $existing['rup_epurchasing_realisasi'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_epurchasing_realisasi" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="rup_nontender_realisasi" value="<?= $existing['rup_nontender_realisasi'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="rup_nontender_realisasi" step="0.01">
                            </td>
                            <td class="text-right">
                                <input type="number" name="swakelola_realisasi" value="<?= $existing['swakelola_realisasi'] ?? 0 ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="swakelola_realisasi" step="0.01">
                            </td>
                        </tr>
                        
                        <!-- Indeks Row -->
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Indeks
                            </td>
                            <td class="text-right">
                                <span class="calculated-indeks" data-field="rup_tender">0.00</span>%
                            </td>
                            <td class="text-right">
                                <span class="calculated-indeks" data-field="rup_epurchasing">0.00</span>%
                            </td>
                            <td class="text-right">
                                <span class="calculated-indeks" data-field="rup_nontender">0.00</span>%
                            </td>
                            <td class="text-right">
                                <span class="calculated-indeks" data-field="swakelola">0.00</span>%
                            </td>
                        </tr>
                        
                        <!-- Keterangan Row -->
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                Keterangan
                            </td>
                            <td>
                                <textarea name="keterangan_tender" class="form-control form-control-sm" rows="2" 
                                          placeholder="Keterangan RUP Tender"><?= $existing['keterangan_tender'] ?? '' ?></textarea>
                            </td>
                            <td>
                                <textarea name="keterangan_epurchasing" class="form-control form-control-sm" rows="2" 
                                          placeholder="Keterangan RUP E-Purchasing"><?= $existing['keterangan_epurchasing'] ?? '' ?></textarea>
                            </td>
                            <td>
                                <textarea name="keterangan_nontender" class="form-control form-control-sm" rows="2" 
                                          placeholder="Keterangan RUP Non Tender"><?= $existing['keterangan_nontender'] ?? '' ?></textarea>
                            </td>
                            <td>
                                <textarea name="keterangan_swakelola" class="form-control form-control-sm" rows="2" 
                                          placeholder="Keterangan SWAKELOLA"><?= $existing['keterangan_swakelola'] ?? '' ?></textarea>
                            </td>
                        </tr>
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
        var fields = ['rup_tender', 'rup_epurchasing', 'rup_nontender', 'swakelola'];
        
        fields.forEach(function(field) {
            var pagu = parseFloat($('input[name="' + field + '_pagu"]').val()) || 0;
            var realisasi = parseFloat($('input[name="' + field + '_realisasi"]').val()) || 0;
            var indeks = pagu > 0 ? (realisasi / pagu) * 100 : 0;
            
            $('.calculated-indeks[data-field="' + field + '"]').text(indeks.toFixed(2));
        });
    }
    
    // Recalculate on input change
    $(document).on('input', 'input[type="number"]', function(){
        recalculateIndeks();
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $tahun ?>,
            bulan: $('select[name="bulan"]').val(),
        };
        
        // Add all input values
        $('input[type="number"]').each(function(){
            var name = $(this).attr('name');
            var value = parseFloat($(this).val()) || 0;
            formData[name] = value;
        });
        
        // Add all textarea values
        $('textarea').each(function(){
            var name = $(this).attr('name');
            var value = $(this).val();
            formData[name] = value;
        });
        
        formData[csrfTokenName] = csrfHash;
        
        $.post('<?= base_url('pbj/input/save') ?>', formData, function(res){
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
    
    // Initial calculation
    recalculateIndeks();
})();
</script>
<?= $this->endSection() ?>
