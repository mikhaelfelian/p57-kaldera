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
                <h4 class="mb-3">Status</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="progresChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 8px;"></div>
                        <span>Sesuai</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <span>Tidak Sesuai</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Main Content -->
    <div class="col-md-9">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0">
                <h3 class="card-title mb-0">PROGRES PBJ</h3>
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
                                <th style="width: 200px;">Indikator</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Verifikasi</th>
                                <th class="text-center">Feedback</th>
                                <th class="text-center">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-weight-bold" style="background-color: #2f5f93; color: white;">
                                    Monitoring Progres Pencatatan PBJ
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-<?= $chart['status'] == 'Sesuai' ? 'success' : ($chart['status'] == 'Tidak Sesuai' ? 'danger' : 'secondary') ?>">
                                        <?= $chart['status'] ?? 'Belum Diperiksa' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($chart['has_verifikasi']): ?>
                                        <span class="badge badge-success">✓</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($chart['has_feedback']): ?>
                                        <span class="badge badge-success">✓ (<?= $chart['feedback_count'] ?>)</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="progress" style="height: 20px;">
                                        <?php 
                                        $progress = 0;
                                        if ($chart['status'] == 'Sesuai') $progress += 40;
                                        if ($chart['has_verifikasi']) $progress += 30;
                                        if ($chart['has_feedback']) $progress += 30;
                                        ?>
                                        <div class="progress-bar <?= $progress == 100 ? 'bg-success' : ($progress > 0 ? 'bg-warning' : 'bg-secondary') ?>" 
                                             role="progressbar" style="width: <?= $progress ?>%" 
                                             aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?= $progress ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Verifikasi Sekretariat Section -->
                <?php if ($chart['has_verifikasi']): ?>
                <div class="card mt-3">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">Verifikasi Sekretariat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="font-weight-bold">Catatan Kendala:</label>
                                <p><?= $existing['catatan_kendala'] ?? '-' ?></p>
                            </div>
                            <div class="col-md-6">
                                <label class="font-weight-bold">Rencana Tindak Lanjut:</label>
                                <p><?= $existing['rencana_tindak_lanjut'] ?? '-' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Feed back Unit Kerja Section -->
                <?php if ($chart['has_feedback']): ?>
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Feed back Unit Kerja</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Unit Kerja</th>
                                        <th>Alasan dan Saran Tindak Lanjut Perbaikan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $feedbackData = $existing['feedback_unit_kerja'] ?? [];
                                    $counter = 1;
                                    foreach ($feedbackData as $feedback): 
                                        if (empty($feedback['unit_kerja']) && empty($feedback['alasan_saran'])) continue;
                                    ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $feedback['unit_kerja'] ?? '-' ?></td>
                                        <td><?= $feedback['alasan_saran'] ?? '-' ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Summary</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-<?= $chart['status'] == 'Sesuai' ? 'success' : ($chart['status'] == 'Tidak Sesuai' ? 'danger' : 'secondary') ?>">
                                                <?= $chart['status'] ?? 'Belum Diperiksa' ?>
                                            </h3>
                                            <small>Status</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-<?= $chart['has_verifikasi'] ? 'success' : 'secondary' ?>">
                                                <?= $chart['has_verifikasi'] ? '✓' : '✗' ?>
                                            </h3>
                                            <small>Verifikasi</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-<?= $chart['has_feedback'] ? 'success' : 'secondary' ?>">
                                                <?= $chart['feedback_count'] ?? 0 ?>
                                            </h3>
                                            <small>Feedback</small>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-center">
                                            <h3 class="text-info"><?= $progress ?>%</h3>
                                            <small>Progress</small>
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
    
    var statusColors = {
        'Sesuai': '#28a745',
        'Tidak Sesuai': '#dc3545',
        'Belum Diperiksa': '#6c757d'
    };
    
    var ctx = document.getElementById('progresChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Sesuai', 'Tidak Sesuai'],
            datasets: [{
                data: [
                    chartData.status === 'Sesuai' ? 1 : 0,
                    chartData.status === 'Tidak Sesuai' ? 1 : 0
                ],
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
    
    // Export functions
    function exportToExcel() {
        var table = document.querySelector('.table');
        var wb = XLSX.utils.table_to_book(table);
        XLSX.writeFile(wb, 'pbj_progres_rekap_<?= $tahun ?>_<?= bulan_ke_str($bulan) ?>.xlsx');
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
