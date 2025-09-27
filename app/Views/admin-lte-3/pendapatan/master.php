<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $tahapanList = [
        'penetapan' => 'Penetapan APBD',
        'pergeseran' => 'Pergeseran',
        'perubahan' => 'Perubahan APBD'
    ];
    
    $existing = $existingData ?? [];
?>
<div class="row">
    <!-- Right Panel - Main Content -->
    <div class="col-md-12">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">PENDAPATAN</h3>
                <div class="d-flex align-items-center">
                    <span class="text-success font-weight-bold mr-3">Master Data</span>
                </div>
            </div>
            <div class="card-body rounded-0">
                <form method="get" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="font-weight-bold">Tahapan</label>
                            <select name="tahapan" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                                <?php foreach ($tahapanList as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="font-weight-bold">Tahun</label>
                            <select name="year" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()" readonly disabled>
                                <?php 
                                $currentYear = date('Y');
                                for($i = $currentYear - 5; $i <= $currentYear + 5; $i++): 
                                ?>
                                <option value="<?= $i ?>" <?= ($year == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
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
                                <th style="width: 50px;">No</th>
                                <th>Uraian</th>
                                <th class="text-center" style="width: 200px;">Target Tahunan (Rp)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rows = [
                                [
                                    'no' => 1,
                                    'label' => 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
                                    'field' => 'retribusi_penyewaan',
                                    'value' => (float)($existing['retribusi_penyewaan'] ?? 0)
                                ],
                                [
                                    'no' => 2,
                                    'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
                                    'field' => 'retribusi_laboratorium',
                                    'value' => (float)($existing['retribusi_laboratorium'] ?? 0)
                                ],
                                [
                                    'no' => 3,
                                    'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
                                    'field' => 'retribusi_alat',
                                    'value' => (float)($existing['retribusi_alat'] ?? 0)
                                ],
                                [
                                    'no' => 4,
                                    'label' => 'Hasil Kerja Sama Pemanfaatan BMD',
                                    'field' => 'hasil_kerjasama',
                                    'value' => (float)($existing['hasil_kerjasama'] ?? 0)
                                ],
                                [
                                    'no' => 5,
                                    'label' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
                                    'field' => 'penerimaan_komisi',
                                    'value' => (float)($existing['penerimaan_komisi'] ?? 0)
                                ],
                                [
                                    'no' => 6,
                                    'label' => 'Sewa Ruang Koperasi',
                                    'field' => 'sewa_ruang_koperasi',
                                    'value' => (float)($existing['sewa_ruang_koperasi'] ?? 0)
                                ],
                            ];
                            $total = (float)($existing['total'] ?? 0);
                            ?>
                            
                            <?php foreach ($rows as $row): ?>
                            <tr>
                                <td class="text-center"><?= $row['no'] ?></td>
                                <td class="font-weight-bold"><?= $row['label'] ?></td>
                                <td class="text-right">
                                    <span class="editable-span" data-field="<?= $row['field'] ?>" data-value="<?= $row['value'] ?>">
                                        <?= $row['value'] > 0 ? format_angka_rp($row['value']) : '-' ?>
                                    </span>
                                    <i class="fas fa-pencil-alt text-muted ml-1 edit-icon" data-field="<?= $row['field'] ?>"></i>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- TOTAL Row -->
                            <tr style="background-color: #3b6ea8; color: white;">
                                <td class="text-center font-weight-bold">-</td>
                                <td class="font-weight-bold">Total</td>
                                <td class="text-right font-weight-bold">
                                    <span class="editable-span" data-field="total" data-value="<?= $total ?>">
                                        <?= format_angka_rp($total) ?>
                                    </span>
                                    <i class="fas fa-pencil-alt text-muted ml-1 edit-icon" data-field="total"></i>
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
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.editable-span {
    cursor: pointer;
    padding: 2px 5px;
    border-radius: 3px;
    transition: background-color 0.2s;
}
.editable-span:hover {
    background-color: #f8f9fa;
}
.edit-icon {
    cursor: pointer;
    opacity: 0.6;
    transition: opacity 0.2s;
}
.edit-icon:hover {
    opacity: 1;
}
.editable-input {
    border: 1px solid #007bff;
    background: white;
    padding: 2px 5px;
    border-radius: 3px;
    width: 100%;
    text-align: right;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    
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
    
    function parseCurrency(str) {
        if (!str || str === '-') return 0;
        return parseFloat(str.replace(/[^\d]/g, '')) || 0;
    }
    
    // Handle span and icon clicks for editing
    $(document).on('click', '.editable-span, .edit-icon', function(e){
        e.preventDefault();
        var $span = $(this).hasClass('editable-span') ? $(this) : $(this).siblings('.editable-span');
        var field = $span.data('field');
        var currentValue = parseCurrency($span.text());
        
        if ($span.find('input').length > 0) return; // Already editing
        
        var $input = $('<input type="number" class="editable-input" value="' + currentValue + '" step="0.01">');
        $span.html($input);
        $input.focus().select();
        
        $input.on('blur keypress', function(e){
            if (e.type === 'blur' || e.which === 13) {
                var newValue = parseFloat($(this).val()) || 0;
                $span.text(newValue > 0 ? formatCurrencyRp(newValue) : '-').data('value', newValue);
                $(this).remove();
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var fields = {};
        var hasChanges = false;
        
        $('.editable-span').each(function(){
            var field = $(this).data('field');
            var value = parseFloat($(this).data('value')) || 0;
            fields[field] = value;
        });
        
        // Check if there are any non-zero values
        Object.keys(fields).forEach(function(key) {
            if (key !== 'total' && fields[key] > 0) {
                hasChanges = true;
            }
        });
        
        if (!hasChanges) {
            if(window.toastr){ toastr.warning('Tidak ada data untuk disimpan'); }
            return;
        }
        
        // Calculate total
        var total = 0;
        Object.keys(fields).forEach(function(key) {
            if (key !== 'total') {
                total += fields[key];
            }
        });
        fields.total = total;
        
        // Update total display
        $('.editable-span[data-field="total"]').text(formatCurrencyRp(total)).data('value', total);
        
        // Save each field sequentially to avoid CSRF issues
        var fieldKeys = Object.keys(fields).filter(function(key) { return key !== 'total'; });
        var currentIndex = 0;
        
        function saveNextField() {
            if (currentIndex >= fieldKeys.length) {
                if(window.toastr){ toastr.success('Data berhasil disimpan'); }
                return;
            }
            
            var field = fieldKeys[currentIndex];
            $.post('<?= base_url('pendapatan/master/update') ?>', {
                tahun: <?= $year ?>,
                tahapan: '<?= $tahapan ?>',
                field: field,
                value: fields[field],
                [csrfToken]: csrfHash
            }, function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                currentIndex++;
                saveNextField();
            }, 'json').fail(function(xhr){
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan data'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menyimpan data'); }
                }
            });
        }
        
        saveNextField();
    });
    
    // Load existing data on page load
    $.get('<?= base_url('pendapatan/master/get') ?>?year=<?= $year ?>&tahapan=<?= $tahapan ?>', function(res){
        if(res && res.ok && res.data){
            var data = res.data;
            Object.keys(data).forEach(function(key) {
                if (key !== 'id' && key !== 'tahun' && key !== 'tahapan' && key !== 'created_at' && key !== 'updated_at') {
                    var value = parseFloat(data[key]) || 0;
                    $('.editable-span[data-field="' + key + '"]').text(value > 0 ? formatCurrencyRp(value) : '-').data('value', value);
                }
            });
        }
        if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
    }, 'json');
})();
</script>
<?= $this->endSection() ?>
