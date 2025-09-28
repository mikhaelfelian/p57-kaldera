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
                <h4 class="mb-3">Rupiah</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="pbjChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="width: 15px; height: 15px; background-color: #007bff; margin-right: 8px;"></div>
                        <span>Realisasi</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <span>Sisa Anggaran</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Main Content -->
    <div class="col-md-9">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">INDEKS PBJ</h3>
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
                        <thead style="background-color: #3b6ea8; color: white;">
                            <tr>
                                <th style="width: 200px;">Jenis PBJ</th>
                                <th class="text-center">Pagu (Rp)</th>
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
                                'rup_tender' => 'RUP Tender',
                                'rup_epurchasing' => 'RUP E-Purchasing',
                                'rup_nontender' => 'RUP Non Tender',
                                'swakelola' => 'SWAKELOLA'
                            ];
                            $totalPagu = 0;
                            $totalRealisasi = 0;
                            ?>
                            
                            <?php foreach ($rows as $key => $label): ?>
                            <?php 
                                $pagu = (float)($existing[$key.'_pagu'] ?? 0);
                                $realisasi = (float)($existing[$key.'_realisasi'] ?? 0);
                                $sisa = $pagu - $realisasi;
                                $persen = $pagu > 0 ? ($realisasi / $pagu) * 100 : 0;
                                $sisaPersen = $pagu > 0 ? ($sisa / $pagu) * 100 : 0;
                                
                                $totalPagu += $pagu;
                                $totalRealisasi += $realisasi;
                                
                            ?>
                            <tr>
                                <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                    <?= $label ?>
                                </td>
                                <td class="text-right"><?= format_angka_rp($pagu) ?></td>
                                <td class="text-right"><?= format_angka_rp($realisasi) ?></td>
                                <td class="text-right"><?= format_angka($persen, 2) ?>%</td>
                                <td class="text-right"><?= format_angka_rp($sisa) ?></td>
                                <td class="text-right"><?= format_angka($sisaPersen, 2) ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- TOTAL Row -->
                            <?php 
                                $totalSisa = $totalPagu - $totalRealisasi;
                                $totalPersen = $totalPagu > 0 ? ($totalRealisasi / $totalPagu) * 100 : 0;
                                $totalSisaPersen = $totalPagu > 0 ? ($totalSisa / $totalPagu) * 100 : 0;
                                
                            ?>
                            <tr style="background-color: #3b6ea8; color: white;">
                                <td class="font-weight-bold">TOTAL</td>
                                <td class="text-right font-weight-bold"><?= format_angka_rp($totalPagu) ?></td>
                                <td class="text-right font-weight-bold"><?= format_angka_rp($totalRealisasi) ?></td>
                                <td class="text-right font-weight-bold"><?= format_angka($totalPersen, 2) ?>%</td>
                                <td class="text-right font-weight-bold"><?= format_angka_rp($totalSisa) ?></td>
                                <td class="text-right font-weight-bold"><?= format_angka($totalSisaPersen, 2) ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
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
    
    if (chartData && chartData.total > 0) {
        var ctx = document.getElementById('pbjChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Realisasi', 'Sisa Anggaran'],
                datasets: [{
                    data: [chartData.realisasi, chartData.total - chartData.realisasi],
                    backgroundColor: ['#007bff', '#dc3545'],
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
        var ctx = document.getElementById('pbjChart').getContext('2d');
        ctx.fillStyle = '#6c757d';
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('No Data', 100, 100);
    }
    
    // Export functions
    function exportToExcel() {
        var table = document.querySelector('.table');
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'pbj_indeks_rekap_<?= $tahun ?>_<?= bulan_ke_str($bulan) ?>.xlsx');
    }
    
    function exportToPdf() {
        window.print();
    }
    
    // Make export functions globally available
    window.exportToExcel = exportToExcel;
    window.exportToPdf = exportToPdf;
})();
</script>
<?= $this->endSection() ?>
