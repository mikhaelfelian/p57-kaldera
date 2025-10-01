<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $tahapanList = [
        'penetapan' => 'Penetapan APBD',
        'pergeseran' => 'Pergeseran',
        'perubahan' => 'Perubahan APBD'
    ];
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
    $master = $masterData ?? [];
?>
<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0">
        <h3 class="card-title mb-0">PENDAPATAN</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3">Input</span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form method="get" id="filterForm">
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="font-weight-bold">Tahapan</label>
                    <select name="tahapan" class="form-control rounded-0" id="tahapanSelect" onchange="document.getElementById('filterForm').submit()">
                        <?php foreach ($tahapanList as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Tahun</label>
                    <select name="year" class="form-control rounded-0" id="yearSelect" onchange="document.getElementById('filterForm').submit()">
                        <?php 
                        $currentYear = date('Y');
                        for($i = $currentYear - 5; $i <= $currentYear + 5; $i++): 
                        ?>
                        <option value="<?= $i ?>" <?= ($year == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="font-weight-bold">Bulan :</label>
                    <select name="bulan" class="form-control rounded-0" id="bulanSelect" onchange="document.getElementById('filterForm').submit()">
                        <?php foreach ($bulanList as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </form>

        <div class="table-responsive rounded-0">
            <table class="table table-bordered rounded-0">
                <thead style="background-color: #3b6ea8; color: white;">
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Uraian</th>
                        <th class="text-center">Target Tahunan (Rp)</th>
                        <th class="text-center">Realisasi (Rp)</th>
                        <th class="text-center">% Capaian</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $rows = [
                        [
                            'no' => 1,
                            'label' => 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
                            'field' => 'retribusi_penyewaan',
                            'target' => (float)($master['retribusi_penyewaan'] ?? 0),
                            'realisasi' => (float)($existing['retribusi_penyewaan_realisasi'] ?? 0)
                        ],
                        [
                            'no' => 2,
                            'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
                            'field' => 'retribusi_laboratorium',
                            'target' => (float)($master['retribusi_laboratorium'] ?? 0),
                            'realisasi' => (float)($existing['retribusi_laboratorium_realisasi'] ?? 0)
                        ],
                        [
                            'no' => 3,
                            'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
                            'field' => 'retribusi_alat',
                            'target' => (float)($master['retribusi_alat'] ?? 0),
                            'realisasi' => (float)($existing['retribusi_alat_realisasi'] ?? 0)
                        ],
                        [
                            'no' => 4,
                            'label' => 'Hasil Kerja Sama Pemanfaatan BMD',
                            'field' => 'hasil_kerjasama',
                            'target' => (float)($master['hasil_kerjasama'] ?? 0),
                            'realisasi' => (float)($existing['hasil_kerjasama_realisasi'] ?? 0)
                        ],
                        [
                            'no' => 5,
                            'label' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
                            'field' => 'penerimaan_komisi',
                            'target' => (float)($master['penerimaan_komisi'] ?? 0),
                            'realisasi' => (float)($existing['penerimaan_komisi_realisasi'] ?? 0)
                        ],
                        [
                            'no' => 6,
                            'label' => 'Sewa Ruang Koperasi',
                            'field' => 'sewa_ruang_koperasi',
                            'target' => (float)($master['sewa_ruang_koperasi'] ?? 0),
                            'realisasi' => (float)($existing['sewa_ruang_koperasi_realisasi'] ?? 0)
                        ],
                    ];
                    $totalTarget = 0;
                    $totalRealisasi = 0;
                    ?>
                    
                    <?php foreach ($rows as $row): ?>
                    <?php 
                        $target = $row['target'];
                        $realisasi = $row['realisasi'];
                        $persen = $target > 0 ? ($realisasi / $target) * 100 : 0;
                        
                        $totalTarget += $target;
                        $totalRealisasi += $realisasi;
                    ?>
                    <tr>
                        <td class="text-center"><?= $row['no'] ?></td>
                        <td class="font-weight-bold"><?= $row['label'] ?></td>
                        <td class="text-right"><?= format_angka($target, 2) ?></td>
                        <td class="text-right">
                            <span class="editable-span" data-field="<?= $row['field'] ?>_realisasi" data-value="<?= $realisasi ?>">
                                <?= $realisasi > 0 ? format_angka($realisasi, 2) : '-' ?>
                            </span>
                            <i class="fas fa-pencil-alt text-muted ml-1 edit-icon" data-field="<?= $row['field'] ?>_realisasi"></i>
                        </td>
                        <td class="text-right">
                            <span class="calculated-percent" data-field="<?= $row['field'] ?>_percent"><?= format_angka($persen, 2) ?></span>%
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <!-- TOTAL Row -->
                    <?php 
                        $totalPersen = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;
                    ?>
                    <tr style="background-color: #3b6ea8; color: white;">
                        <td class="text-center font-weight-bold">-</td>
                        <td class="font-weight-bold">TOTAL</td>
                        <td class="text-right font-weight-bold"><?= format_angka($totalTarget) ?></td>
                        <td class="text-right font-weight-bold">
                            <span id="totalRealisasi"><?= format_angka($totalRealisasi) ?></span>
                        </td>
                        <td class="text-right font-weight-bold">
                            <span id="totalPersen"><?= format_angka($totalPersen, 0) ?></span>%
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
.calculated-percent {
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
    
    function recalculateAll(){
        var totalRealisasi = 0;
        var totalTarget = 0;
        
        $('tbody tr').not(':last').each(function(){
            var $row = $(this);
            var $targetCell = $row.find('td:nth-child(3)');
            var targetText = $targetCell.text().replace(/[^\d]/g, '');
            var target = parseFloat(targetText) || 0;
            totalTarget += target;
            
            // Get realisasi input
            var $realisasiSpan = $row.find('.editable-span');
            if($realisasiSpan.length > 0){
                var realisasi = parseFloat($realisasiSpan.data('value')) || 0;
                totalRealisasi += realisasi;
                
                // Calculate percentage
                var persen = target > 0 ? (realisasi / target) * 100 : 0;
                $row.find('.calculated-percent').text(Math.round(persen));
            }
        });
        
        // Update totals
        var totalPersen = totalTarget > 0 ? (totalRealisasi / totalTarget) * 100 : 0;
        $('#totalRealisasi').text(formatCurrencyRp(totalRealisasi));
        $('#totalPersen').text(Math.round(totalPersen));
    }
    
    // Handle span and icon clicks for editing
    $(document).on('click', '.editable-span, .edit-icon', function(e){
        e.preventDefault();
        var $span = $(this).hasClass('editable-span') ? $(this) : $(this).siblings('.editable-span');
        var field = $span.data('field');
        var currentValue = parseFloat($span.data('value')) || 0;
        
        if ($span.find('input').length > 0) return; // Already editing
        
        var $input = $('<input type="number" class="editable-input" value="' + currentValue + '" step="0.01">');
        $span.html($input);
        $input.focus().select();
        
        $input.on('blur keypress', function(e){
            if (e.type === 'blur' || e.which === 13) {
                var newValue = parseFloat($(this).val()) || 0;
                $span.text(newValue > 0 ? formatCurrencyRp(newValue) : '-').data('value', newValue);
                $(this).remove();
                recalculateAll();
            }
        });
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $year ?>,
            tahapan: $('select[name="tahapan"]').val(),
            bulan: $('select[name="bulan"]').val(),
        };
        
        // Add all input values
        $('.editable-span').each(function(){
            var name = $(this).attr('data-field');
            var value = parseFloat($(this).data('value')) || 0;
            formData[name] = value;
        });
        
        formData[csrfToken] = csrfHash;
        
        $.post('<?= base_url('pendapatan/input/save') ?>', formData, function(res){
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
    
    // Initial calculation
    recalculateAll();

    // Enhanced dropdown change handlers for database search
    document.getElementById('yearSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('year', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    document.getElementById('tahapanSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('tahapan', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    document.getElementById('bulanSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('bulan', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });
})();
</script>
<?= $this->endSection() ?>
