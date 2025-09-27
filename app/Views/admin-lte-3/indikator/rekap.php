<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $triwulanList = [
        1 => 'Triwulan I',
        2 => 'Triwulan II',
        3 => 'Triwulan III',
        4 => 'Triwulan IV'
    ];
    
    $existing = $existingData ?? [];
    $indikatorList = $indikatorList ?? [];
    $chart = $chartData ?? [];
?>
<div class="row">
    <!-- Left Panel - Chart -->
    <div class="col-md-3">
        <div class="card rounded-0">
            <div class="card-body text-center">
                <h4 class="mb-3">Progress</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="indikatorChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 8px;"></div>
                        <span>Completed</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <span>Remaining</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Main Content -->
    <div class="col-md-9">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">INDIKATOR</h3>
                <div class="d-flex align-items-center">
                    <span class="text-success font-weight-bold mr-3">Rekap</span>
                </div>
            </div>
            <div class="card-body rounded-0">
                <form method="get" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label class="font-weight-bold">Tahun</label>
                            <select name="year" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()" readonly disabled>
                                <?php 
                                $currentYear = date('Y');
                                for($i = $currentYear - 5; $i <= $currentYear + 5; $i++): 
                                ?>
                                <option value="<?= $i ?>" <?= ($tahun == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="font-weight-bold">Triwulan</label>
                            <select name="triwulan" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                                <?php foreach ($triwulanList as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($triwulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                        </div>
                    </div>
                </form>

                <div class="table-responsive rounded-0">
                    <table class="table table-bordered rounded-0">
                        <thead style="background-color: #3b6ea8; color: white;">
                            <tr>
                                <th style="width: 200px;">Indikator</th>
                                <th class="text-center">Status Data</th>
                                <th class="text-center">File Upload</th>
                                <th class="text-center">Progress</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="text-center">Catatan</th>
                                <th class="text-center">Rencana</th>
                                <th class="text-center">File Catatan</th>
                                <th class="text-center">File Rencana</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rows = [
                                'tujuan' => 'Indikator Tujuan',
                                'sasaran' => 'Indikator Sasaran',
                                'program' => 'Indikator Program',
                                'kegiatan' => 'Indikator Kegiatan',
                                'sub_kegiatan' => 'Indikator Sub Kegiatan'
                            ];
                            $totalIndikator = count($rows);
                            $completedIndikator = 0;
                            $totalFiles = 0;
                            ?>
                            
                            <?php foreach ($rows as $key => $label): ?>
                            <?php 
                                $hasData = isset($existing[$key]);
                                $data = $hasData ? $existing[$key] : null;
                                
                                $hasCatatan = $hasData && !empty($data['catatan_indikator']);
                                $hasRencana = $hasData && !empty($data['rencana_tindak_lanjut']);
                                $hasFileCatatan = $hasData && !empty($data['file_catatan_path']);
                                $hasFileRencana = $hasData && !empty($data['file_rencana_path']);
                                
                                $progress = 0;
                                if ($hasCatatan) $progress += 25;
                                if ($hasRencana) $progress += 25;
                                if ($hasFileCatatan) $progress += 25;
                                if ($hasFileRencana) $progress += 25;
                                
                                if ($progress > 0) $completedIndikator++;
                                if ($hasFileCatatan) $totalFiles++;
                                if ($hasFileRencana) $totalFiles++;
                            ?>
                            <tr>
                                <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                    <?= $label ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($hasCatatan): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($hasRencana): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($hasFileCatatan): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($hasFileRencana): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar <?= $progress == 100 ? 'bg-success' : ($progress > 0 ? 'bg-warning' : 'bg-secondary') ?>" 
                                             role="progressbar" style="width: <?= $progress ?>%" 
                                             aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= $progress ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- TOTAL Row -->
                            <?php 
                                $totalProgress = $totalIndikator > 0 ? ($completedIndikator / $totalIndikator) * 100 : 0;
                            ?>
                            <tr style="background-color: #3b6ea8; color: white;">
                                <td class="font-weight-bold">TOTAL</td>
                                <td class="text-center font-weight-bold"><?= $completedIndikator ?>/<?= $totalIndikator ?></td>
                                <td class="text-center font-weight-bold"><?= $totalFiles ?></td>
                                <td class="text-center font-weight-bold">-</td>
                                <td class="text-center font-weight-bold">-</td>
                                <td class="text-center font-weight-bold"><?= format_angka($totalProgress, 1) ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Summary</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-primary"><?= $chart['total'] ?? 0 ?></h3>
                                            <small>Total Data</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-success"><?= $chart['completed'] ?? 0 ?></h3>
                                            <small>Completed</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-info"><?= $chart['files'] ?? 0 ?></h3>
                                            <small>Files Uploaded</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-warning"><?= $chart['remaining'] ?? 0 ?></h3>
                                            <small>Remaining</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success rounded-0 mr-2" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                        <button type="button" class="btn btn-info rounded-0" onclick="exportToExcel()">
                            <i class="fas fa-file-excel"></i> Export Excel
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
.progress {
    background-color: #e9ecef;
}
.badge {
    font-size: 0.75em;
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
        var ctx = document.getElementById('indikatorChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Remaining'],
                datasets: [{
                    data: [chartData.completed, chartData.remaining],
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
        var ctx = document.getElementById('indikatorChart').getContext('2d');
        ctx.fillStyle = '#6c757d';
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.fillText('No Data', 100, 100);
    }
    
    // Export to Excel function
    function exportToExcel() {
        // Create a simple table export
        var table = document.querySelector('.table');
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'indikator_rekap_<?= $tahun ?>_triwulan_<?= $triwulan ?>.xlsx');
    }
    
    // Make exportToExcel globally available
    window.exportToExcel = exportToExcel;
})();
</script>
<?= $this->endSection() ?>
