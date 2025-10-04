<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
    helper(['tanggalan', 'angka']);
    $bulanList = [];
    for($i = 1; $i <= 12; $i++) {
        $bulanList[$i] = bulan_ke_str($i);
    }
    
    $data = $rekapData ?? [];
    $totals = $totalsData ?? [];
    $chart = $chartData ?? [];
?>
<div class="row">
    <!-- Left Panel - Chart -->
    <div class="col-md-3">
        <div class="card rounded-0">
            <div class="card-body text-center">
                <h4 class="mb-3">Persetujuan Teknis</h4>
                <div style="width: 200px; height: 200px; margin: 0 auto;">
                    <canvas id="ptChart"></canvas>
                </div>
                <div class="mt-3">
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <div style="width: 15px; height: 15px; background-color: #28a745; margin-right: 8px;"></div>
                        <small>Disetujui (<?= format_angka($chart['disetujui_percent'] ?? 0, 0) ?>%)</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <div style="width: 15px; height: 15px; background-color: #ffc107; margin-right: 8px;"></div>
                        <small>Masih Proses (<?= format_angka($chart['proses_percent'] ?? 0, 0) ?>%)</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <div style="width: 15px; height: 15px; background-color: #17a2b8; margin-right: 8px;"></div>
                        <small>Dikembalikan (<?= format_angka($chart['dikembalikan_percent'] ?? 0, 0) ?>%)</small>
                    </div>
                    <div class="d-flex align-items-center justify-content-start">
                        <div style="width: 15px; height: 15px; background-color: #dc3545; margin-right: 8px;"></div>
                        <small>Ditolak (<?= format_angka($chart['ditolak_percent'] ?? 0, 0) ?>%)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Panel - Main Content -->
    <div class="col-md-9">
        <div class="card rounded-0">
            <div class="card-header d-flex align-items-center justify-content-between rounded-0" style="background-color: #dc3545; color: white;">
                <h3 class="card-title mb-0 font-weight-bold">PERSETUJUAN TEKNIS - SEKTOR GATRIK</h3>
                <div class="d-flex align-items-center">
                    <span class="font-weight-bold">Rekap</span>
                </div>
            </div>
            <div class="card-body rounded-0">
                <form method="get" id="filterForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="font-weight-bold">Tahun:</label>
                            <select name="year" class="form-control rounded-0" id="yearSelect" onchange="document.getElementById('filterForm').submit()">
                                <?php 
                                $currentYear = date('Y');
                                $current = (int)($year ?? date('Y'));
                                for($i = $currentYear + 5; $i >= $currentYear - 5; $i--): 
                                ?>
                                <option value="<?= $i ?>" <?= ($current == $i) ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="font-weight-bold">Bulan:</label>
                            <select name="bulan" class="form-control rounded-0" id="bulanSelect" onchange="document.getElementById('filterForm').submit()">
                                <?php foreach ($bulanList as $key => $label): ?>
                                <option value="<?= $key ?>" <?= ($bulan == $key) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </form>

                <div class="table-responsive rounded-0">
                    <table class="table table-bordered rounded-0">
                        <thead style="background-color: #dc3545; color: white;">
                            <tr>
                                <th style="width: 5%;" class="text-center">No</th>
                                <th style="width: 25%;">UNIT KERJA</th>
                                <th style="width: 10%;" class="text-center">PERMOHONAN<br>MASUK</th>
                                <th style="width: 10%;" class="text-center">MASIH<br>PROSES</th>
                                <th style="width: 10%;" class="text-center">DISETUJUI</th>
                                <th style="width: 10%;" class="text-center">DIKEMBALIKAN</th>
                                <th style="width: 10%;" class="text-center">DITOLAK</th>
                                <th style="width: 20%;" class="text-center">KETERANGAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if (!empty($data)): 
                                foreach ($data as $row): 
                            ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="font-weight-bold"><?= esc($row->unit_kerja_nama) ?></td>
                                <td class="text-center"><?= format_angka($row->permohonan_masuk) ?></td>
                                <td class="text-center"><?= format_angka($row->masih_proses) ?></td>
                                <td class="text-center"><?= format_angka($row->disetujui) ?></td>
                                <td class="text-center"><?= format_angka($row->dikembalikan) ?></td>
                                <td class="text-center"><?= format_angka($row->ditolak) ?></td>
                                <td><small><?= esc($row->keterangan) ?></small></td>
                            </tr>
                            <?php 
                                endforeach; 
                            else: 
                            ?>
                            <tr>
                                <td colspan="8" class="text-center">
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-info-circle"></i> Tidak ada data untuk periode yang dipilih
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                            
                            <!-- TOTAL Row -->
                            <?php if (!empty($totals)): ?>
                            <tr style="background-color: #f8f9fa; font-weight: bold;">
                                <td colspan="2" class="text-center font-weight-bold">JUMLAH</td>
                                <td class="text-center font-weight-bold"><?= format_angka($totals->total_permohonan_masuk) ?></td>
                                <td class="text-center font-weight-bold"><?= format_angka($totals->total_masih_proses) ?></td>
                                <td class="text-center font-weight-bold"><?= format_angka($totals->total_disetujui) ?></td>
                                <td class="text-center font-weight-bold"><?= format_angka($totals->total_dikembalikan) ?></td>
                                <td class="text-center font-weight-bold"><?= format_angka($totals->total_ditolak) ?></td>
                                <td></td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?= base_url('pt-gatrik/rekap/export-excel?year='.$year.'&bulan='.$bulan) ?>" 
                           class="btn btn-success rounded-0 mr-2">
                            <i class="fas fa-file-excel"></i> Export Excel
                        </a>
                        <a href="<?= base_url('pt-gatrik/rekap/export-pdf?year='.$year.'&bulan='.$bulan) ?>" 
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
    vertical-align: middle;
}
.table td {
    border: 1px solid #dee2e6;
    vertical-align: middle;
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
        var ctx = document.getElementById('ptChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Disetujui', 'Masih Proses', 'Dikembalikan', 'Ditolak'],
                datasets: [{
                    data: [
                        chartData.disetujui || 0, 
                        chartData.masih_proses || 0, 
                        chartData.dikembalikan || 0, 
                        chartData.ditolak || 0
                    ],
                    backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
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
        var ctx = document.getElementById('ptChart').getContext('2d');
        ctx.font = '16px Arial';
        ctx.fillStyle = '#999';
        ctx.textAlign = 'center';
        ctx.fillText('Tidak ada data', 100, 100);
    }

    // Enhanced dropdown change handlers
    document.getElementById('yearSelect').addEventListener('change', function(){
        var params = new URLSearchParams(window.location.search);
        params.set('year', this.value);
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

