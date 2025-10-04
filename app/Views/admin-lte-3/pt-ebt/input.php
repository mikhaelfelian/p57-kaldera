<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php
helper(['tanggalan', 'angka']);
$bulanList = [];
for ($i = 1; $i <= 12; $i++) {
    $bulanList[$i] = bulan_ke_str($i);
}
?>

<div class="card rounded-0">
    <div class="card-header d-flex align-items-center justify-content-between rounded-0" style="background-color: #dc3545; color: white;">
        <h3 class="card-title mb-0 font-weight-bold">PERSETUJUAN TEKNIS - SEKTOR EBT</h3>
    </div>
    <div class="card-body rounded-0">
        <form id="ptInputForm" method="get">
            <!-- Dropdowns Section -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="font-weight-bold">Tahun:</label>
                    <select name="year" class="form-control rounded-0" id="yearSelect" onchange="this.form.submit()">
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
                <div class="col-md-6">
                    <label class="font-weight-bold">Bulan:</label>
                    <select name="bulan" class="form-control rounded-0" id="bulanSelect" onchange="this.form.submit()">
                        <?php foreach ($bulanList as $key => $label): ?>
                            <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Formula Info -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert alert-info rounded-0">
                        <strong>Rumus:</strong> Jumlah = Jumlah pada masing-masing kolom
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-responsive rounded-0">
                <table class="table table-bordered rounded-0" id="ptTable">
                    <thead style="background-color: #dc3545; color: white;">
                        <tr>
                            <th style="width: 3%;" class="text-center">No</th>
                            <th style="width: 20%;">UNIT KERJA</th>
                            <th style="width: 12%;" class="text-center">PERMOHONAN<br>MASUK</th>
                            <th style="width: 12%;" class="text-center">MASIH<br>PROSES</th>
                            <th style="width: 12%;" class="text-center">DISETUJUI</th>
                            <th style="width: 12%;" class="text-center">DIKEMBALIKAN</th>
                            <th style="width: 12%;" class="text-center">DITOLAK</th>
                            <th style="width: 17%;" class="text-center">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $totalPermohonan = 0;
                        $totalProses = 0;
                        $totalDisetujui = 0;
                        $totalDikembalikan = 0;
                        $totalDitolak = 0;
                        
                        foreach ($unitKerjaList as $unitKerja): 
                            // Handle both object and array
                            $unitId = is_object($unitKerja) ? $unitKerja->id : $unitKerja['id'];
                            $unitName = is_object($unitKerja) ? $unitKerja->nama_unit_kerja : $unitKerja['nama_unit_kerja'];
                            
                            $existing = $existingData[$unitName] ?? null;
                            $permohonan = $existing->permohonan_masuk ?? 0;
                            $proses = $existing->masih_proses ?? 0;
                            $disetujui = $existing->disetujui ?? 0;
                            $dikembalikan = $existing->dikembalikan ?? 0;
                            $ditolak = $existing->ditolak ?? 0;
                            $keterangan = $existing->keterangan ?? '';
                            
                            $totalPermohonan += $permohonan;
                            $totalProses += $proses;
                            $totalDisetujui += $disetujui;
                            $totalDikembalikan += $dikembalikan;
                            $totalDitolak += $ditolak;
                        ?>
                        <tr class="data-row" 
                            data-unit-id="<?= $unitId ?>" 
                            data-unit-name="<?= esc($unitName) ?>">
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="font-weight-bold"><?= esc($unitName) ?></td>
                            <td class="text-center" style="background-color: #ffe6e6;">
                                <input type="number" class="form-control form-control-sm text-center rounded-0 data-input" 
                                    name="permohonan_masuk" value="<?= $permohonan ?>" min="0" 
                                    data-field="permohonan_masuk">
                            </td>
                            <td class="text-center" style="background-color: #ffe6e6;">
                                <input type="number" class="form-control form-control-sm text-center rounded-0 data-input" 
                                    name="masih_proses" value="<?= $proses ?>" min="0" 
                                    data-field="masih_proses">
                            </td>
                            <td class="text-center" style="background-color: #ffe6e6;">
                                <input type="number" class="form-control form-control-sm text-center rounded-0 data-input" 
                                    name="disetujui" value="<?= $disetujui ?>" min="0" 
                                    data-field="disetujui">
                            </td>
                            <td class="text-center" style="background-color: #ffe6e6;">
                                <input type="number" class="form-control form-control-sm text-center rounded-0 data-input" 
                                    name="dikembalikan" value="<?= $dikembalikan ?>" min="0" 
                                    data-field="dikembalikan">
                            </td>
                            <td class="text-center" style="background-color: #ffe6e6;">
                                <input type="number" class="form-control form-control-sm text-center rounded-0 data-input" 
                                    name="ditolak" value="<?= $ditolak ?>" min="0" 
                                    data-field="ditolak">
                            </td>
                            <td style="background-color: #ffe6e6;">
                                <input type="text" class="form-control form-control-sm rounded-0 data-input" 
                                    name="keterangan" value="<?= esc($keterangan) ?>" 
                                    data-field="keterangan">
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <!-- Total Row -->
                        <tr style="background-color: #f8f9fa; font-weight: bold;">
                            <td colspan="2" class="text-center font-weight-bold">JUMLAH</td>
                            <td class="text-center">
                                <input type="number" id="totalPermohonan" class="form-control form-control-sm text-center rounded-0 font-weight-bold" 
                                    value="<?= $totalPermohonan ?>" readonly style="background-color: #e9ecef;">
                            </td>
                            <td class="text-center">
                                <input type="number" id="totalProses" class="form-control form-control-sm text-center rounded-0 font-weight-bold" 
                                    value="<?= $totalProses ?>" readonly style="background-color: #e9ecef;">
                            </td>
                            <td class="text-center">
                                <input type="number" id="totalDisetujui" class="form-control form-control-sm text-center rounded-0 font-weight-bold" 
                                    value="<?= $totalDisetujui ?>" readonly style="background-color: #e9ecef;">
                            </td>
                            <td class="text-center">
                                <input type="number" id="totalDikembalikan" class="form-control form-control-sm text-center rounded-0 font-weight-bold" 
                                    value="<?= $totalDikembalikan ?>" readonly style="background-color: #e9ecef;">
                            </td>
                            <td class="text-center">
                                <input type="number" id="totalDitolak" class="form-control form-control-sm text-center rounded-0 font-weight-bold" 
                                    value="<?= $totalDitolak ?>" readonly style="background-color: #e9ecef;">
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Save Button -->
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
.table thead th {
    vertical-align: middle;
    font-weight: bold;
}

.data-input {
    border: 1px solid #ced4da;
}

.data-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.table tbody tr.data-row:hover {
    background-color: #f5f5f5;
}

.font-weight-bold input {
    font-weight: bold !important;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
(function() {
    var csrfToken = '<?= csrf_token() ?>';
    var csrfHash = '<?= csrf_hash() ?>';

    // Calculate totals
    function calculateTotals() {
        var totals = {
            permohonan_masuk: 0,
            masih_proses: 0,
            disetujui: 0,
            dikembalikan: 0,
            ditolak: 0
        };

        $('.data-row').each(function() {
            var $row = $(this);
            totals.permohonan_masuk += parseInt($row.find('input[name="permohonan_masuk"]').val()) || 0;
            totals.masih_proses += parseInt($row.find('input[name="masih_proses"]').val()) || 0;
            totals.disetujui += parseInt($row.find('input[name="disetujui"]').val()) || 0;
            totals.dikembalikan += parseInt($row.find('input[name="dikembalikan"]').val()) || 0;
            totals.ditolak += parseInt($row.find('input[name="ditolak"]').val()) || 0;
        });

        $('#totalPermohonan').val(totals.permohonan_masuk);
        $('#totalProses').val(totals.masih_proses);
        $('#totalDisetujui').val(totals.disetujui);
        $('#totalDikembalikan').val(totals.dikembalikan);
        $('#totalDitolak').val(totals.ditolak);
    }

    // Auto-calculate on input change
    $(document).on('input change', '.data-input[type="number"]', function() {
        calculateTotals();
    });

    // Save button
    $('#btnSave').on('click', function() {
        var dataRows = [];
        
        $('.data-row').each(function() {
            var $row = $(this);
            var rowData = {
                unit_kerja_id: $row.data('unit-id'),
                unit_kerja_nama: $row.data('unit-name'),
                permohonan_masuk: parseInt($row.find('input[name="permohonan_masuk"]').val()) || 0,
                masih_proses: parseInt($row.find('input[name="masih_proses"]').val()) || 0,
                disetujui: parseInt($row.find('input[name="disetujui"]').val()) || 0,
                dikembalikan: parseInt($row.find('input[name="dikembalikan"]').val()) || 0,
                ditolak: parseInt($row.find('input[name="ditolak"]').val()) || 0,
                keterangan: $row.find('input[name="keterangan"]').val() || ''
            };
            dataRows.push(rowData);
        });

        var formData = {
            tahun: <?= $year ?>,
            bulan: <?= $bulan ?>,
            data: dataRows
        };
        formData[csrfToken] = csrfHash;

        // Show loading
        $('#btnSave').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

        $.post('<?= base_url('pt-ebt/save-data') ?>', formData, function(res) {
            if (res && res.csrf_hash) { csrfHash = res.csrf_hash; }
            if (res && res.ok) {
                if (window.toastr) { toastr.success(res.message || 'Data berhasil disimpan'); }
                // Reload after 1 second
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                if (window.toastr) { toastr.error(res.message || 'Gagal menyimpan data'); }
                $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
            }
        }, 'json').fail(function(xhr) {
            try {
                var data = JSON.parse(xhr.responseText);
                if (data && data.csrf_hash) { csrfHash = data.csrf_hash; }
                if (window.toastr) { toastr.error(data.message || 'Gagal menyimpan data'); }
            } catch (e) {
                if (window.toastr) { toastr.error('Gagal menyimpan data'); }
            }
            $('#btnSave').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
        });
    });

    // Enhanced dropdown change handlers
    document.getElementById('yearSelect').addEventListener('change', function() {
        var params = new URLSearchParams(window.location.search);
        params.set('year', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    document.getElementById('bulanSelect').addEventListener('change', function() {
        var params = new URLSearchParams(window.location.search);
        params.set('bulan', this.value);
        window.location.href = window.location.pathname + '?' + params.toString();
    });

    // Initial calculation
    calculateTotals();
})();
</script>
<?= $this->endSection() ?>

