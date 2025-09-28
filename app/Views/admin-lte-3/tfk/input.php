<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php helper(['angka']); $months = ['jan'=>'Januari','feb'=>'Februari','mar'=>'Maret','apr'=>'April','mei'=>'Mei','jun'=>'Juni','jul'=>'Juli','ags'=>'Agustus','sep'=>'September','okt'=>'Oktober','nov'=>'November','des'=>'Desember']; ?>
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title">Target Fisik & Keuangan - Input</h3>
        <form class="form-inline" method="get">
            <?php $current = (int)($year ?? date('Y')); $start=$current-5; $end=$current+5; ?>
            <label class="mr-2">Tahun</label>
            <select name="year" class="form-control form-control-sm mr-3" disabled readonly>
                <option value="<?= $current ?>" selected><?= $current ?></option>
            </select>
            <input type="hidden" name="year" value="<?= $current ?>">
            <label class="mr-2">Tahapan</label>
            <select name="tahapan" class="form-control form-control-sm" id="tahapanSelect">
                <?php foreach(($tahapanOptions ?? ['penetapan'=>'Penetapan APBD','pergeseran'=>'Pergeseran','perubahan'=>'Perubahan APBD']) as $k=>$o): ?>
                <option value="<?= $k ?>" <?= ($tahapan===$k)?'selected':'' ?>><?= $o ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive mt-2">
            <table class="table table-bordered mb-0 rounded-0" id="tfkInput" data-year="<?= (int)($year) ?>" data-master-id="<?= (int)($sourceMaster['id'] ?? 0) ?>">
                <thead>
                    <tr>
                        <th style="width:220px">Kumulatif</th>
                        <?php foreach ($months as $label): ?>
                            <th><?= $label ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $map = $detailsMap; ?>
                    <tr>
                        <td class="red-box"><strong>Target Fisik (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['target_fisik'] ?? 0); ?>
                        <td><span class="static" data-bulan="<?= $k ?>" data-field="fisik" data-value="<?= $val ?>"><?= format_angka($val) ?></span></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr class="sep-top">
                        <td><strong>Realisasi Fisik (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['realisasi_fisik'] ?? 0); ?>
                        <td><span class="editable" data-bulan="<?= $k ?>" data-field="real_fisik" data-id="<?= (int)($d['id'] ?? 0) ?>" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Realisasi Fisik Prov (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['realisasi_fisik_prov'] ?? 0); ?>
                        <td><span class="editable" data-bulan="<?= $k ?>" data-field="real_fisik_prov" data-id="<?= (int)($d['id'] ?? 0) ?>" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Deviasi Fisik (%)</strong><div class="text-muted small">Realisasi - Target</div></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $target=(float)($d['target_fisik']??0); $real=(float)($d['realisasi_fisik']??0); $dev=$real-$target; ?>
                        <td><span class="calc" data-bulan="<?= $k ?>" data-type="dev_fisik" data-value="<?= $dev ?>"><?= format_angka($dev, 2) ?></span></td>
                        <?php endforeach; ?>
                    </tr>

                    <tr class="sep-top">
                        <td class="red-box"><strong>Target Keuangan (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['target_keuangan'] ?? 0); ?>
                        <td><span class="static" data-bulan="<?= $k ?>" data-field="keu" data-value="<?= $val ?>"><?= format_angka($val) ?></span></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Realisasi Keuangan (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['realisasi_keuangan'] ?? 0); ?>
                        <td><span class="editable" data-bulan="<?= $k ?>" data-field="real_keu" data-id="<?= (int)($d['id'] ?? 0) ?>" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Realisasi Keuangan Prov (%)</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (float)($d['realisasi_keuangan_prov'] ?? 0); ?>
                        <td><span class="editable" data-bulan="<?= $k ?>" data-field="real_keu_prov" data-id="<?= (int)($d['id'] ?? 0) ?>" data-value="<?= $val ?>"><?= format_angka($val, 2) ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Deviasi Keuangan (%)</strong><div class="text-muted small">Realisasi - Target</div></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $target=(float)($d['target_keuangan']??0); $real=(float)($d['realisasi_keuangan']??0); $dev=$real-$target; ?>
                        <td><span class="calc" data-bulan="<?= $k ?>" data-type="dev_keu" data-value="<?= $dev ?>"><?= format_angka($dev, 2) ?></span></td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><strong>Analisa</strong></td>
                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = (string)($d['analisa'] ?? ''); ?>
                        <td><span class="editable-text" data-bulan="<?= $k ?>" data-field="analisa" data-id="<?= (int)($d['id'] ?? 0) ?>" data-value="<?= esc($val) ?>"><?= esc($val) ?></span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                        <?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
            <div class="text-right mt-3">
                <button type="button" class="btn btn-success rounded-0" id="btnSaveInput">Simpan</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    #tfkInput { border-color: #1f4986; }
    #tfkInput th {
        background-color: #275a9a;
        color: #fff;
        text-align: center;
    }
    #tfkInput td { vertical-align: middle; }
    #tfkInput tbody tr td { background: #e6eef8; }
    #tfkInput tbody tr:nth-child(odd) td { background: #f3f7fc; }
    #tfkInput .editable, #tfkInput .editable-text { cursor: pointer; }
    #tfkInput td.red-box {
        border: 3px solid #d9534f !important;
        background-color: #fff;
        color: #d9534f;
    }
    #tfkInput td:first-child { font-weight: 600; }
    #tfkInput .sep-top td { border-top: 4px solid #000 !important; }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    function openNumeric(span){
        var value = (span.data('value')!==undefined)? span.data('value') : 0;
        var input = $('<input type="number" step="0.01" class="form-control form-control-sm rounded-0" />');
        input.val(value);
        span.hide(); span.after(input); input.focus();
        function commit(){
            var newVal = parseFloat(input.val()||0);
            var payload = {
                id: span.data('id')||0,
                master_id: $('#tfkInput').data('master-id')||0,
                bulan: span.data('bulan'),
                year: $('#tfkInput').data('year'),
                field: span.data('field'),
                value: newVal,
                tahapan: $('select[name="tahapan"]').val()
            };
            $.post('<?= base_url('tfk/update-cell') ?>', payload, function(res){
                if(res && res.ok){
                    span.data('id', res.id);
                    span.data('value', newVal);
                    try { span.text(new Intl.NumberFormat('id-ID').format(newVal)); } catch(e){ span.text(newVal); }
                    recalc();
                }
                input.remove(); span.show();
            }, 'json').fail(function(){ input.remove(); span.show(); });
        }
        input.on('blur', commit);
        input.on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); commit(); } });
    }
    function openText(span){
        var value = span.data('value')||'';
        var input = $('<textarea class="form-control form-control-sm rounded-0" rows="2"></textarea>');
        input.val(value);
        span.hide(); span.after(input); input.focus();
        function commit(){
            var newVal = input.val()||'';
            var payload = {
                id: span.data('id')||0,
                master_id: $('#tfkInput').data('master-id')||0,
                bulan: span.data('bulan'),
                year: $('#tfkInput').data('year'),
                field: span.data('field'),
                value: newVal,
                tahapan: $('select[name="tahapan"]').val()
            };
            $.post('<?= base_url('tfk/update-cell') ?>', payload, function(res){
                if(res && res.ok){ span.data('id', res.id); span.data('value', newVal); span.text(newVal); }
                input.remove(); span.show();
            }, 'json').fail(function(){ input.remove(); span.show(); });
        }
        input.on('blur', commit);
        input.on('keydown', function(e){ if(e.key==='Enter' && e.ctrlKey){ e.preventDefault(); commit(); } });
    }

    $(document).on('click', '#tfkInput .editable', function(){ openNumeric($(this)); });
    $(document).on('click', '#tfkInput .editable-text', function(){ openText($(this)); });
    $(document).on('click', '#tfkInput .edit-icon', function(){ var s=$(this).siblings('span').first(); if(s.hasClass('editable')) openNumeric(s); else openText(s); });

    function recalc(){
        $('#tfkInput tbody tr').each(function(){ /* noop for row context */ });
        <?php foreach ($months as $k=>$label): ?>
        (function(){
            var targetF = parseFloat($('span.static[data-field="fisik"][data-bulan="<?= $k ?>"]').data('value')||0);
            var realF = parseFloat($('span.editable[data-field="real_fisik"][data-bulan="<?= $k ?>"]').data('value')||0);
            var targetK = parseFloat($('span.static[data-field="keu"][data-bulan="<?= $k ?>"]').data('value')||0);
            var realK = parseFloat($('span.editable[data-field="real_keu"][data-bulan="<?= $k ?>"]').data('value')||0);
            var devF = realF - targetF; var devK = realK - targetK;
            var dvF = $('span.calc[data-type="dev_fisik"][data-bulan="<?= $k ?>"]');
            var dvK = $('span.calc[data-type="dev_keu"][data-bulan="<?= $k ?>"]');
            dvF.data('value', devF); dvK.data('value', devK);
            try { dvF.text(new Intl.NumberFormat('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2}).format(devF)); } catch(e){ dvF.text(devF.toFixed(2)); }
            try { dvK.text(new Intl.NumberFormat('id-ID',{minimumFractionDigits:2,maximumFractionDigits:2}).format(devK)); } catch(e){ dvK.text(devK.toFixed(2)); }
        })();
        <?php endforeach; ?>
    }

    // Load data when tahapan changes
    function loadDataByTahapan() {
        var tahun = $('#tfkInput').data('year');
        var tahapan = $('#tahapanSelect').val();
        var masterId = $('#tfkInput').data('master-id');
        
        console.log('Loading data for tahun:', tahun, 'tahapan:', tahapan, 'masterId:', masterId);
        
        $.get('<?= base_url('tfk/get-data') ?>', {
            tahun: tahun,
            tahapan: tahapan,
            master_id: masterId,
            _: Date.now() // cache buster
        }, function(res) {
            console.log('Received response:', res);
            if (res && res.ok && res.data && Object.keys(res.data).length > 0) {
                updateTableWithData(res.data);
                console.log('Data loaded successfully');
            } else {
                console.log('No data found for tahun:', tahun, 'tahapan:', tahapan);
                // Reset all editable cells to 0 if no data found
                $('#tfkInput .editable, #tfkInput .editable-text').each(function(){
                    $(this).data('value', 0).text('0');
                });
                recalc();
            }
        }, 'json').fail(function(xhr) {
            console.error('Failed to load data:', xhr.responseText);
            toastr.error('Gagal memuat data dari database');
        });
    }
    
    // Update table with loaded data
    function updateTableWithData(data) {
        console.log('Updating table with data:', data);
        
        // Update static target rows first
        $('#tfkInput .static').each(function(){
            var $span = $(this);
            var bulan = $span.data('bulan');
            var field = $span.data('field'); // 'fisik' or 'keu'
            var dbField = field === 'fisik' ? 'target_fisik' : 'target_keuangan';
            if(data[bulan] && data[bulan][dbField] !== undefined){
                var value = parseFloat(data[bulan][dbField]) || 0;
                $span.data('value', value);
                try { $span.text(new Intl.NumberFormat('id-ID').format(value)); } catch(e){ $span.text(value); }
            } else {
                $span.data('value', 0).text('0');
            }
        });

        // Update all editable cells with loaded data
        $('#tfkInput .editable').each(function(){
            var $span = $(this);
            var bulan = $span.data('bulan');
            var field = $span.data('field');
            
            // Map field names to database fields
            var dbField = field;
            if (field === 'real_fisik') dbField = 'realisasi_fisik';
            if (field === 'real_keu') dbField = 'realisasi_keuangan';
            if (field === 'real_fisik_prov') dbField = 'realisasi_fisik_prov';
            if (field === 'real_keu_prov') dbField = 'realisasi_keuangan_prov';
            
            if(data[bulan] && data[bulan][dbField] !== undefined) {
                var value = parseFloat(data[bulan][dbField]) || 0;
                $span.data('value', value);
                try {
                    $span.text(new Intl.NumberFormat('id-ID', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(value));
                } catch(e) {
                    $span.text(value.toFixed(2));
                }
            }
        });
        
        // Update editable-text cells (analisa)
        $('#tfkInput .editable-text').each(function(){
            var $span = $(this);
            var bulan = $span.data('bulan');
            var field = $span.data('field');
            
            if(data[bulan] && data[bulan][field] !== undefined) {
                var value = data[bulan][field] || '';
                $span.data('value', value).text(value);
            }
        });
        
        // Recalculate deviations
        recalc();
    }
    
    // Bind tahapan change event
    $(document).on('change', '#tahapanSelect', function(){
        console.log('Tahapan changed to:', $(this).val());
        loadDataByTahapan();
    });
    
    // Load data on page load
    loadDataByTahapan();

    $('#btnSaveInput').on('click', function(){
        // nothing extra; values are saved per-cell on edit
        toastr && toastr.success && toastr.success('Tersimpan');
    });
})();
</script>
<?= $this->endSection() ?>


