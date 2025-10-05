<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $existing = $existingData ?? [];
    $chart = $chartData ?? [];
?>
<div class="row">
    <!-- Left Panel - Chart -->
    <div class="col-md-3">
        <div class="card rounded-0">
            <div class="card-body text-center">
                <h4 class="mb-3">Progress</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="pdnChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 8px;"></div>
                        <span>Realisasi</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <span>Sisa Pagu</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Main Content -->
    <div class="col-md-9">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">INDEKS REALISASI PDN</h3>
                <div class="d-flex align-items-center">
                    <span class="text-success font-weight-bold mr-3">Rekap</span>
                </div>
            </div>
            <div class="card-body rounded-0">
                <form method="get" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="font-weight-bold">Tahun</label>
                            <select name="year" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
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
                            <select name="bulan" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                                <?php foreach ($bulanList as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </form>

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
                                <td class="text-right"><?= format_angka_rp($existing['pagu_rup_tagging_pdn'] ?? 0) ?></td>
                                <td class="text-right"><?= format_angka_rp($existing['realisasi_pdn'] ?? 0) ?></td>
                                <td class="text-right"><?= format_angka($existing['indeks'] ?? 0, 2) ?>%</td>
                                <td><?= $existing['keterangan'] ?? '-' ?></td>
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
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Summary</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-primary"><?= format_angka_rp($chart['pagu'] ?? 0) ?></h3>
                                            <small>Total Pagu</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-success"><?= format_angka_rp($chart['realisasi'] ?? 0) ?></h3>
                                            <small>Total Realisasi</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h3 class="text-info"><?= format_angka($chart['indeks'] ?? 0, 2) ?>%</h3>
                                            <small>Indeks Realisasi</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success rounded-0 mr-2" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-danger rounded-0" onclick="exportToPdf()">
                            <i class="fas fa-file-pdf"></i> Export PDF
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
.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.table th {
    border: none;
}
.table td {
    border: 1px solid #dee2e6;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    // Chart data from PHP
    var chartData = <?= json_encode($chart) ?>;
    
    if (chartData && chartData.pagu > 0) {
        var ctx = document.getElementById('pdnChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Realisasi', 'Sisa Pagu'],
                datasets: [{
                    data: [chartData.realisasi, chartData.pagu - chartData.realisasi],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    } else {
        // Show empty state
        var ctx = document.getElementById('pdnChart').getContext('2d');
        ctx.fillStyle = '#6c757d';
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('No Data', 100, 100);
    }
    
    // Export functions
    function exportToExcel() {
        // Use server-side PHPSpreadsheet export
        var tahun = <?= $tahun ?>;
        var bulan = <?= $bulan ?>;
        
        // Create download link
        var url = '<?= base_url('pbj/rekap/realisasi_pdn/export-excel') ?>?tahun=' + tahun + '&bulan=' + bulan;
        
        // Open in new window to trigger download
        window.open(url, '_blank');
    }
    
    function exportToPdf() {
        // Use server-side TCPDF export
        var tahun = <?= $tahun ?>;
        var bulan = <?= $bulan ?>;
        
        // Create download link
        var url = '<?= base_url('pbj/rekap/realisasi_pdn/export-pdf') ?>?tahun=' + tahun + '&bulan=' + bulan;
        
        // Open in new window to trigger download
        window.open(url, '_blank');
    }
    
    // Make export functions globally available
    window.exportToExcel = exportToExcel;
    window.exportToPdf = exportToPdf;
})();
</script>
<?= $this->endSection() ?>
