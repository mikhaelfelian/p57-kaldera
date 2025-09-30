<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    $tahapanList = [
        '' => '- Pilih Tahapan -',
        'penetapan' => 'Penetapan APBD',
        'pergeseran' => 'Pergeseran',
        'perubahan' => 'Perubahan APBD'
    ];
    $currentTahapan = $tahapan ?? '';
?>
<div class="card" id="belanjaCard" data-year="<?= (int)($year ?? date('Y')) ?>" data-tahapan="<?= esc($currentTahapan) ?>">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h3 class="card-title mb-0">Belanja</h3>
        <form class="form-inline">
            <?php 
                $current = (int)($year ?? date('Y')); 
                $start = $current - 5;
                $end = $current + 5;
            ?>
            <label class="mr-2">Tahun</label>
            <select name="year" class="form-control form-control-sm rounded-0 mr-3" id="yearSelect">
                <?php for ($i = $end; $i >= $start; $i--): ?>
                    <option value="<?= $i ?>" <?= $i === $current ? 'selected' : '' ?>><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <label class="mr-2">Tahapan</label>
            <select name="tahapan" class="form-control form-control-sm" id="tahapanSelect">
                <?php foreach ($tahapanList as $key => $label): ?>
                    <option value="<?= $key ?>" <?= $key === $currentTahapan ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <div class="card-body">
        <div class="mb-2 text-muted small">Klik nilai anggaran untuk mengedit. Tekan Enter atau pindah fokus untuk menyimpan.</div>
        <div class="table-responsive mt-2">
            <table class="table table-bordered mb-0 rounded-0 tfk-master-table">
                <thead>
                    <tr>
                        <th style="width:220px">Jenis Belanja</th>
                        <th class="text-center">Anggaran (Rp)</th>
                    </tr>
                </thead>
                <tbody id="belanjaBody">
                    <tr data-field="pegawai">
                        <td class="row-title"><strong>Belanja Pegawai</strong><br><small>(Gaji, TPP, Honor)</small></td>
                        <td class="text-right align-middle"><span class="currency editable" data-id="0" data-value="0" data-field="pegawai">0</span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                    </tr>
                    <tr data-field="barang_jasa">
                        <td class="row-title">Belanja Barang dan Jasa</td>
                        <td class="text-right align-middle"><span class="currency editable" data-id="0" data-value="0" data-field="barang_jasa">0</span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                    </tr>
                    <tr data-field="hibah">
                        <td class="row-title">Belanja Hibah</td>
                        <td class="text-right align-middle"><span class="currency editable" data-id="0" data-value="0" data-field="hibah">0</span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                    </tr>
                    <tr data-field="bansos">
                        <td class="row-title">Belanja Bantuan Sosial</td>
                        <td class="text-right align-middle"><span class="currency editable" data-id="0" data-value="0" data-field="bansos">0</span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                    </tr>
                    <tr data-field="modal">
                        <td class="row-title">Belanja Modal</td>
                        <td class="text-right align-middle"><span class="currency editable" data-id="0" data-value="0" data-field="modal">0</span> <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i></td>
                    </tr>
                    <tr>
                        <td class="row-title"><strong>TOTAL</strong></td>
                        <td class="text-right align-middle"><span class="currency" id="totalVal">0</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.tfk-master-table th {
    background: #3b6ea8;
    color: #fff;
}
.tfk-master-table td { vertical-align: middle; }
.tfk-master-table .row-title {
    background: #2f5f93; color: #fff; font-weight: 600; width: 220px;
}
.tfk-master-table tbody tr td:not(.row-title) { background: #e6edf7; }
.tfk-master-table tbody tr:nth-child(even) td:not(.row-title) { background: #f0f5fb; }
.editable { cursor: pointer; }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function(){
    var csrfToken = '<?= config('Security')->tokenName ?>';
    var csrfHash = '<?= csrf_hash() ?>';
    
    function formatCurrency(n){ 
        try { 
            return new Intl.NumberFormat('id-ID').format(Number(n)); 
        } catch(e){ 
            return Number(n).toLocaleString('id-ID'); 
        } 
    }
    
    function parseVal(span){ 
        var dv = $(span).data('value'); 
        return dv !== undefined ? parseFloat(dv) : parseFloat($(span).text().replace(/\./g,'')); 
    }
    
    function recalcTotal(){ 
        var t = 0; 
        $('#belanjaBody .editable').each(function(){ 
            t += parseVal(this) || 0; 
        }); 
        $('#totalVal').text(formatCurrency(t)); 
    }

    function loadExisting(){
        var tahun = $('#belanjaCard').data('year');
        var tahapan = $('select[name="tahapan"]').val();
        $.get('<?= base_url('belanja/master/get') ?>', {tahun:tahun, tahapan:tahapan}, function(res){
            if(res && res.ok && res.row){
                var r = res.row; var map = {
                    'pegawai': r.pegawai||0,
                    'barang_jasa': r.barang_jasa||0,
                    'hibah': r.hibah||0,
                    'bansos': r.bansos||0,
                    'modal': r.modal||0
                };
                Object.keys(map).forEach(function(k){
                    var $s = $('#belanjaBody span.editable[data-field="'+k+'"]');
                    $s.data('value', parseFloat(map[k]));
                    $s.text(formatCurrency(map[k]));
                });
                $('#totalVal').text(formatCurrency(r.total||0));
                if(res.csrf_hash){ csrfHash = res.csrf_hash; }
            }
        }, 'json');
    }
    
    function makeInput(span){
        var $span = $(span);
        var value = parseVal(span) || 0;
        var $input = $('<input type="number" step="0.01" class="form-control form-control-sm text-right" />');
        $input.val(value); 
        $span.hide().after($input); 
        $input.focus().select();
        
        function commit(){
            var newVal = parseFloat($input.val()||0);
            var payload = {
                tahun: $('#belanjaCard').data('year'),
                tahapan: $('select[name="tahapan"]').val(),
                field: $span.data('field'),
                value: newVal
            }; 
            payload[csrfToken] = csrfHash;
            
            $.post('<?= base_url('belanja/master/update') ?>', payload, function(res){
                if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
                if(res && res.ok){
                    $span.data('value', newVal).text(formatCurrency(newVal));
                    if(window.toastr){ toastr.success('Tersimpan'); }
                } else {
                    if(window.toastr){ toastr.error(res && res.message ? res.message : 'Gagal menyimpan'); }
                }
                $input.remove(); 
                $span.show(); 
                recalcTotal();
            }, 'json').fail(function(xhr){ 
                // 403 SecurityException (CSRF) or other server errors
                try{
                    var data = JSON.parse(xhr.responseText);
                    if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                    if(window.toastr){ toastr.error(data.message || 'Gagal menyimpan (Server)'); }
                }catch(e){
                    if(window.toastr){ toastr.error('Gagal menyimpan (Server)'); }
                }
                $input.remove(); 
                $span.show(); 
                recalcTotal(); 
            });
        }
        $input.on('blur', commit);
        $input.on('keydown', function(e){ if(e.key==='Enter'){ e.preventDefault(); commit(); } });
    }
    
    $(document).on('click', '#belanjaBody .editable', function(){ 
        makeInput(this); 
    });
    
    $(document).on('click', '#belanjaBody .edit-icon', function(){ 
        var span = $(this).siblings('span').first();
        if(span.hasClass('editable')) {
            makeInput(span[0]); 
        }
    });
    
    // preload and bind change
    loadExisting();
    $('select[name="tahapan"]').on('change', function(){
        this.form && this.form.submit ? this.form.submit() : loadExisting();
    });
    
    // Batch save (single request to avoid CSRF issues)
    $('#btnBelanjaSave').on('click', function(){
        var tahun = $('#belanjaCard').data('year');
        var tahapan = $('select[name="tahapan"]').val();
        var data = {tahun: tahun, tahapan: tahapan};
        
        // Collect all field values
        $('#belanjaBody span.editable').each(function(){
            var field = $(this).data('field');
            var value = parseVal(this) || 0;
            data[field] = value;
        });
        
        if(Object.keys(data).length <= 2){ if(window.toastr){ toastr.info('Tidak ada perubahan'); } return; }
        
        data[csrfToken] = csrfHash;
        
        $.post('<?= base_url('belanja/master/update-batch') ?>', data, function(res){
            if(res && res.csrf_hash){ csrfHash = res.csrf_hash; }
            if(res && res.ok){
                if(window.toastr){ toastr.success('Data berhasil disimpan'); }
                loadExisting();
            } else {
                if(window.toastr){ toastr.error(res && res.message ? res.message : 'Gagal menyimpan data'); }
            }
        }, 'json').fail(function(xhr){ 
            try{
                var data = JSON.parse(xhr.responseText);
                if(data && data.csrf_hash){ csrfHash = data.csrf_hash; }
                if(window.toastr){ toastr.error(data && data.message ? data.message : 'Gagal menyimpan data'); }
            }catch(e){
                if(window.toastr){ toastr.error('Gagal menyimpan data'); }
            }
        });
    });

    recalcTotal();

    // Handle year dropdown change
    document.getElementById('yearSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('year', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    // Handle tahapan dropdown change
    document.getElementById('tahapanSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('tahapan', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });
})();
</script>
<?= $this->endSection() ?>
