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
    $chart = $chartData ?? [];
?>
<div class="row">
    <!-- Left Panel - Chart -->
    <div class="col-md-3">
        <div class="card rounded-0">
            <div class="card-body text-center">
                <h4 class="mb-3">Rupiah</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="pendapatanChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <span>Realisasi</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <div style="width: 15px; height: 15px; background-color: #007bff; margin-right: 8px;"></div>
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
                <h3 class="card-title mb-0">PENDAPATAN</h3>
                <div class="d-flex align-items-center">
                    <span class="text-success font-weight-bold mr-3">Rekap</span>
                </div>
            </div>
            <div class="card-body rounded-0">
                <form method="get" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="font-weight-bold">Tahapan</label>
                            <select name="tahapan" class="form-control rounded-0" onchange="document.getElementById('filterForm').submit()">
                                <?php foreach ($tahapanList as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
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
                            <input type="hidden" name="year" value="<?= $year ?>">
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
                                    'target' => (float)($existing['retribusi_penyewaan_target'] ?? 0),
                                    'realisasi' => (float)($existing['retribusi_penyewaan_realisasi'] ?? 0)
                                ],
                                [
                                    'no' => 2,
                                    'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
                                    'field' => 'retribusi_laboratorium',
                                    'target' => (float)($existing['retribusi_laboratorium_target'] ?? 0),
                                    'realisasi' => (float)($existing['retribusi_laboratorium_realisasi'] ?? 0)
                                ],
                                [
                                    'no' => 3,
                                    'label' => 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
                                    'field' => 'retribusi_alat',
                                    'target' => (float)($existing['retribusi_alat_target'] ?? 0),
                                    'realisasi' => (float)($existing['retribusi_alat_realisasi'] ?? 0)
                                ],
                                [
                                    'no' => 4,
                                    'label' => 'Hasil Kerja Sama Pemanfaatan BMD',
                                    'field' => 'hasil_kerjasama',
                                    'target' => (float)($existing['hasil_kerjasama_target'] ?? 0),
                                    'realisasi' => (float)($existing['hasil_kerjasama_realisasi'] ?? 0)
                                ],
                                [
                                    'no' => 5,
                                    'label' => 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
                                    'field' => 'penerimaan_komisi',
                                    'target' => (float)($existing['penerimaan_komisi_target'] ?? 0),
                                    'realisasi' => (float)($existing['penerimaan_komisi_realisasi'] ?? 0)
                                ],
                                [
                                    'no' => 6,
                                    'label' => 'Sewa Ruang Koperasi',
                                    'field' => 'sewa_ruang_koperasi',
                                    'target' => (float)($existing['sewa_ruang_koperasi_target'] ?? 0),
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
                                <td class="text-right" style="color: #dc3545;"><?= format_angka_rp($target) ?></td>
                                <td class="text-right" style="color: #007bff;"><?= format_angka_rp($realisasi) ?></td>
                                <td class="text-right" style="color: #007bff;"><?= format_angka($persen, 2) ?>%</td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <!-- TOTAL Row -->
                            <?php 
                                $totalPersen = $totalTarget > 0 ? ($totalRealisasi / $totalTarget) * 100 : 0;
                            ?>
                            <tr style="background-color: #3b6ea8; color: white;">
                                <td class="text-center font-weight-bold">-</td>
                                <td class="font-weight-bold">TOTAL</td>
                                <td class="text-right font-weight-bold" style="color: #dc3545;"><?= format_angka_rp($totalTarget) ?></td>
                                <td class="text-right font-weight-bold" style="color: #007bff;"><?= format_angka_rp($totalRealisasi) ?></td>
                                <td class="text-right font-weight-bold" style="color: #007bff;"><?= format_angka($totalPersen, 2) ?>%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= base_url('pendapatan/rekap/export-excel?year='.$year.'&tahapan='.$tahapan.'&bulan='.$bulan) ?>" 
                           class="btn btn-success rounded-0 mr-2">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="<?= base_url('pendapatan/rekap/export-pdf?year='.$year.'&tahapan='.$tahapan.'&bulan='.$bulan) ?>" 
                           class="btn btn-danger rounded-0">
                            <i class="fas fa-file-pdf"></i> Export PDF
                        </a>
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
        var ctx = document.getElementById('pendapatanChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Realisasi', 'Sisa Anggaran'],
                datasets: [{
                    data: [chartData.realisasi, chartData.sisa],
                    backgroundColor: ['#dc3545', '#007bff'],
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
        document.getElementById('pendapatanChart').getContext('2d').fillText('No Data', 100, 100);
    }
})();
</script>
<?= $this->endSection() ?>
