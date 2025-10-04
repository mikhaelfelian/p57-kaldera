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
for ($i = 1; $i <= 12; $i++) {
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
        <form id="belanjaInputForm" method="get">
            <div class="row mb-3">
            <div class="col-md-4">
                <label class="font-weight-bold">Tahun</label>
                <select name="year" class="form-control rounded-0 mr-3" id="yearSelect" onchange="this.form.submit()">
                    <?php 
                        $current = (int)($year ?? date('Y')); 
                        $start = $current - 5;
                        $end = $current + 5;
                        for ($i = $end; $i >= $start; $i--): 
                    ?>
                        <option value="<?= $i ?>" <?= $i === $current ? 'selected' : '' ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Tahapan</label>
                    <select name="tahapan" class="form-control rounded-0" id="tahapanSelect" onchange="this.form.submit()">
                        <?php foreach ($tahapanList as $key => $label): ?>
                            <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Bulan :</label>
                    <select name="bulan" class="form-control rounded-0" id="bulanSelect" onchange="this.form.submit()">
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
                            <th class="text-center" colspan="2">Realisasi</th>
                            <th class="text-center" colspan="2">Sisa Anggaran</th>
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
                            'pegawai' => [
                                'label' => 'Belanja Pegawai',
                                'sub' => '(Gaji, TPP, Honor)'
                            ],
                            'barang_jasa' => [
                                'label' => 'Belanja Barang dan Jasa',
                                'sub' => ''
                            ],
                            'hibah' => [
                                'label' => 'Belanja Hibah',
                                'sub' => ''
                            ],
                            'bansos' => [
                                'label' => 'Belanja Bantuan Sosial',
                                'sub' => ''
                            ],
                            'modal' => [
                                'label' => 'Belanja Modal',
                                'sub' => ''
                            ],
                        ];
                        $totalAnggaran = 0;
                        $totalRealisasi = 0;
                        $totalSisa = 0;
                        ?>
                        <?php foreach ($rows as $key => $row): ?>
                            <?php
                            // Get anggaran from master data, fallback to existing data
                            $anggaran = (float) ($master[$key] ?? $existing[$key . '_anggaran'] ?? 0);
                            $realisasi = (float) ($existing[$key . '_realisasi'] ?? 0);
                            $sisa = $anggaran - $realisasi;
                            $persen = $anggaran > 0 ? ($realisasi / $anggaran) * 100 : 0;
                            $sisaPersen = $anggaran > 0 ? ($sisa / $anggaran) * 100 : 0;

                            $totalAnggaran += $anggaran;
                            $totalRealisasi += $realisasi;
                            $totalSisa = $totalSisa + $sisa;
                            ?>
                            <tr>
                                <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                    <?= $row['label'] ?>    <?= $row['sub'] ? '<br><small>' . $row['sub'] . '</small>' : '' ?>
                                </td>
                                <td class="text-right"><?= format_angka($anggaran) ?></td>
                                <td class="text-right">
                                    <input type="text" id="angka<?= $key ?>" name="<?= $key ?>_realisasi"
                                        value="<?= (float) $realisasi ?>"
                                        class="form-control form-control-sm text-right number-format rounded-0"
                                        data-field="<?= $key ?>_realisasi" data-original-value="<?= (float) $realisasi ?>">
                                </td>
                                <td class="text-right">
                                    <span class="calculated-percent"><?= format_angka($persen, 2) ?></span>%
                                </td>
                                <td class="text-right">
                                    <?= ($sisa) ? format_angka($sisa, 2) : '0' ?>
                                </td>
                                <td class="text-right">
                                    <span class="calculated-sisa-percent"><?= format_angka($sisaPersen, 2) ?></span>%
                                </td>
                            </tr>
                        <?php endforeach; ?>

                        <!-- TOTAL Row -->
                        <?php
                        $totalPersen = $totalAnggaran > 0 ? ($totalRealisasi / $totalAnggaran) * 100 : 0;
                        $totalSisaPersen = $totalAnggaran > 0 ? ($totalSisa / $totalAnggaran) * 100 : 0;
                        ?>
                        <tr style="background-color: #3b6ea8; color: white;">
                            <td class="font-weight-bold">TOTAL</td>
                            <td class="text-right font-weight-bold"><?= format_angka($totalAnggaran, 2) ?></td>
                            <td class="text-right font-weight-bold">
                                <span id="totalRealisasi"><?= format_angka($totalRealisasi, 2) ?></span>
                            </td>
                            <td class="text-right font-weight-bold">
                                <span id="totalPersen"><?= format_angka($totalPersen, 2) ?></span>%
                            </td>
                            <td class="text-right font-weight-bold">
                                <span id="totalSisa"><?= format_angka($totalSisa,2) ?></span>
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

    .calculated-percent,
    .calculated-sisa,
    .calculated-sisa-percent {
        font-weight: bold;
        color: #333;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    (function () {

        $(document).ready(function () {
            // $("input[id=jml], input[id=harga], input[id=diskon], input[id=potongan]").autoNumeric({ aSep: '.', aDec: ',', aPad: false });
            $('input[id^="angka"]').autoNumeric({ aSep: '.', aDec: ',', aPad: false });
        });

        var csrfToken = '<?= csrf_token() ?>';
        var csrfHash = '<?= csrf_hash() ?>';

        function formatCurrency(n) {
            try {
                return new Intl.NumberFormat('id-ID').format(Number(n));
            } catch (e) {
                return Number(n).toLocaleString('id-ID');
            }
        }

        // Use .autoNumeric({ aSep: '.', aDec: ',', aPad: false }); for formatting
        function formatCurrencyRp(n) {
            // Create a temporary input to use autoNumeric formatting
            var $input = $('<input type="text" />');
            $input.val(n);
            $input.autoNumeric({ aSep: '.', aDec: ',', aPad: false });
            $input.autoNumeric('set', n);
            var formatted = $input.val();
            $input.remove();
            return formatted;
        }

        function recalculateAll() {
            var totalRealisasi = 0;
            var totalAnggaran = 0;

            // Get anggaran values from first column (they're static)
            $('tbody tr').each(function () {
                var $row = $(this);
                var $anggaranCell = $row.find('td:nth-child(2)');
                var anggaranText = $anggaranCell.text().replace(/[^\d]/g, '');
                var anggaran = parseFloat(anggaranText) || 0;
                totalAnggaran += anggaran;

                // Get realisasi input (jquery.number formatted)
                var $realisasiInput = $row.find('.number-format');
                if ($realisasiInput.length > 0) {
                    var raw = ($realisasiInput.val() || '').replace(/[^0-9\-]/g, '');
                    var realisasi = parseFloat(raw) || 0;
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
            // var totalSisa = totalAnggaran - totalRealisasi;
            // var totalPersen = totalAnggaran > 0 ? (totalRealisasi / totalAnggaran) * 100 : 0;
            // var totalSisaPersen = totalAnggaran > 0 ? (totalSisa / totalAnggaran) * 100 : 0;

            // $('#totalRealisasi').text(formatCurrencyRp(totalRealisasi));
            // $('#totalPersen').text(totalPersen.toFixed(2));
            // $('#totalSisa').text(formatCurrencyRp(totalSisa));
            // $('#totalSisaPersen').text(totalSisaPersen.toFixed(2));
        }

        // Initialize jQuery number formatting for inputs (library loaded in main layout)
        function initNumberFormat() {
            if ($.isFunction($.fn.number)) {
                $('.number-format').each(function () {
                    var $el = $(this);
                    var val = parseFloat($el.val()) || 0;
                    $el.val(val);
                    $el.number(true, 0, ',', '.');
                });
            }
        }

        // Recalculate on input change
        $(document).on('input change', '.number-format', function () {
            recalculateAll();
        });

        // Save button
        $('#btnSave').on('click', function () {
            var formData = {
                tahun: <?= $year ?>,
                tahapan: $('select[name="tahapan"]').val(),
                bulan: $('select[name="bulan"]').val(),
            };

            // Add all input values (parse formatted with jquery.number)
            $('.number-format').each(function () {
                var name = $(this).attr('name');
                var raw = ($(this).val() || '').replace(/[^0-9\-]/g, '');
                var value = parseFloat(raw) || 0;
                formData[name] = value;
            });

            formData[csrfToken] = csrfHash;

            $.post('<?= base_url('belanja/input/save') ?>', formData, function (res) {
                if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
                if (res && res.ok) {
                    if (window.toastr) { toastr.success(res.message || 'Data berhasil disimpan'); }
                    // Reload page after 2 seconds
                    setTimeout(function () {
                        location.reload();
                    }, 2000);
                } else {
                    if (window.toastr) { toastr.error(res.message || 'Gagal menyimpan data'); }
                }
            }, 'json').fail(function (xhr) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                    if (window.toastr) { toastr.error(data.message || 'Gagal menyimpan data'); }
                } catch (e) {
                    if (window.toastr) { toastr.error('Gagal menyimpan data'); }
                }
            });
        });

        // Initial calculation
        recalculateAll();
        initNumberFormat();

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