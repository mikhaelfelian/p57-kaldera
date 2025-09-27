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
        <h3 class="card-title mb-0">BELANJA</h3>
        <div class="d-flex align-items-center">
            <span class="text-success font-weight-bold mr-3"></span>
        </div>
    </div>
    <div class="card-body rounded-0">
        <form id="belanjaInputForm" method="post">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="font-weight-bold">Tahapan</label>
                    <select name="tahapan" class="form-control rounded-0" onchange="this.form.submit()">
                        <?php foreach ($tahapanList as $key => $label): ?>
                        <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
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
                    <input type="hidden" name="year" value="<?= $year ?>">
                </div>
            </div>

            <div class="table-responsive rounded-0">
                <table class="table table-bordered rounded-0">
                    <thead style="background-color: #3b6ea8; color: white;">
                        <tr>
                            <th style="width: 200px;">Jenis Belanja</th>
                            <th class="text-center">Anggaran (Rp)</th>
                            <th class="text-center">Realisasi</th>
                            <th class="text-center">Sisa Anggaran</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-center">(Rp)</th>
                            <th class="text-center">%</th>
                            <th class="text-center">(Rp)</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $rows = [
                            'pegawai'     => [
                                'label' => 'Belanja Pegawai',
                                'sub'   => '(Gaji, TPP, Honor)'
                            ],
                            'barang_jasa' => [
                                'label' => 'Belanja Barang dan Jasa',
                                'sub'   => ''
                            ],
                            'hibah'       => [
                                'label' => 'Belanja Hibah',
                                'sub'   => ''
                            ],
                            'bansos'      => [
                                'label' => 'Belanja Bantuan Sosial',
                                'sub'   => ''
                            ],
                            'modal'       => [
                                'label' => 'Belanja Modal',
                                'sub'   => ''
                            ],
                        ];
                        $totalAnggaran = 0;
                        $totalRealisasi = 0;
                        ?>
                        
                        <?php foreach ($rows as $key => $row): ?>
                        <?php 
                            // Get anggaran from master data, fallback to existing data
                            $anggaran = (float)($master[$key] ?? $existing[$key.'_anggaran'] ?? 0);
                            $realisasi = (float)($existing[$key.'_realisasi'] ?? 0);
                            $sisa = $anggaran - $realisasi;
                            $persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;
                            $sisaPersen = $anggaran > 0 ? ($sisa / $anggaran) * 100 : 0;
                            
                            $totalAnggaran += $anggaran;
                            $totalRealisasi += $realisasi;
                        ?>
                        <tr>
                            <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                <?= $row['label'] ?><?= $row['sub'] ? '<br><small>'.$row['sub'].'</small>' : '' ?>
                            </td>
                            <td class="text-right"><?= format_angka_rp($anggaran) ?></td>
                            <td class="text-right">
                                <input type="number" name="<?= $key ?>_realisasi" value="<?= $realisasi ?>" 
                                       class="form-control form-control-sm text-right editable-input" 
                                       data-field="<?= $key ?>_realisasi" step="0.01">
                            </td>
                            <td class="text-right">
                                <span class="calculated-percent"><?= format_angka($persen, 2) ?></span>%
                            </td>
                            <td class="text-right">
                                <span class="calculated-sisa"><?= format_angka_rp($sisa) ?></span>
                            </td>
                            <td class="text-right">
                                <span class="calculated-sisa-percent"><?= format_angka($sisaPersen, 2) ?></span>%
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- TOTAL Row -->
                        <?php 
                            $totalSisa = $totalAnggaran - $totalRealisasi;
                            $totalPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
                            $totalSisaPersen = $totalAnggaran > 0 ? ($totalSisa / $totalAnggaran) * 100 : 0;
                        ?>
                        <tr style="background-color: #3b6ea8; color: white;">
                            <td class="font-weight-bold">TOTAL</td>
                            <td class="text-right font-weight-bold"><?= format_angka_rp($totalAnggaran) ?></td>
                            <td class="text-right font-weight-bold">
                                <span id="totalRealisasi"><?= format_angka_rp($totalRealisasi) ?></span>
                            </td>
                            <td class="text-right font-weight-bold">
                                <span id="totalPersen"><?= format_angka($totalPersen, 2) ?></span>%
                            </td>
                            <td class="text-right font-weight-bold">
                                <span id="totalSisa"><?= format_angka_rp($totalSisa) ?></span>
                            </td>
                            <td class="text-right font-weight-bold">
                                <span id="totalSisaPersen"><?= format_angka($totalSisaPersen, 2) ?></span>%
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
.calculated-percent, .calculated-sisa, .calculated-sisa-percent {
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
    
    function recalculateAll(){
        var totalRealisasi = 0;
        var totalAnggaran = 0;
        
        // Get anggaran values from first column (they're static)
        $('tbody tr').each(function(){
            var $row = $(this);
            var $anggaranCell = $row.find('td:nth-child(2)');
            var anggaranText = $anggaranCell.text().replace(/[^\d]/g, '');
            var anggaran = parseFloat(anggaranText) || 0;
            totalAnggaran += anggaran;
            
            // Get realisasi input
            var $realisasiInput = $row.find('input[type="number"]');
            if($realisasiInput.length > 0){
                var realisasi = parseFloat($realisasiInput.val()) || 0;
                totalRealisasi += realisasi;
                
                // Calculate percentages and sisa
                var persen = anggaran > 0 ? (realisasi / anggaran) * 100 : 0;
                var sisa = anggaran - realisasi;
                var sisaPersen = anggaran > 0 ? (sisa / anggaran) * 100 : 0;
                
                // Update calculated values
                $row.find('.calculated-percent').text(persen.toFixed(2));
                $row.find('.calculated-sisa').text(formatCurrencyRp(sisa));
                $row.find('.calculated-sisa-percent').text(sisaPersen.toFixed(2));
            }
        });
        
        // Update totals
        var totalSisa = totalAnggaran - totalRealisasi;
        var totalPersen = totalAnggaran > 0 ? (totalRealisasi / totalAnggaran) * 100 : 0;
        var totalSisaPersen = totalAnggaran > 0 ? (totalSisa / totalAnggaran) * 100 : 0;
        
        $('#totalRealisasi').text(formatCurrencyRp(totalRealisasi));
        $('#totalPersen').text(totalPersen.toFixed(2));
        $('#totalSisa').text(formatCurrencyRp(totalSisa));
        $('#totalSisaPersen').text(totalSisaPersen.toFixed(2));
    }
    
    // Recalculate on input change
    $(document).on('input', 'input[type="number"]', function(){
        recalculateAll();
    });
    
    // Save button
    $('#btnSave').on('click', function(){
        var formData = {
            tahun: <?= $year ?>,
            tahapan: $('select[name="tahapan"]').val(),
            bulan: $('select[name="bulan"]').val(),
        };
        
        // Add all input values
        $('input[type="number"]').each(function(){
            var name = $(this).attr('name');
            var value = parseFloat($(this).val()) || 0;
            formData[name] = value;
        });
        
        formData[csrfToken] = csrfHash;
        
        $.post('<?= base_url('belanja/input/save') ?>', formData, function(res){
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
})();
</script>
<?= $this->endSection() ?>
