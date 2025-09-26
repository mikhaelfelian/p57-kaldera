<?= $this->extend(theme_path('main')) ?>

<?= $this->section('content') ?>
<?php 
$months = ['jan'=>'Januari','feb'=>'Februari','mar'=>'Maret','apr'=>'April','mei'=>'Mei','jun'=>'Juni','jul'=>'Juli','ags'=>'Agustus','sep'=>'September','okt'=>'Oktober','nov'=>'November','des'=>'Desember'];
$tahapan = ['Penetapan APBD', 'Pergeseran', 'Perubahan APBD'];
?>

<div class="row">
    <!-- Main Content Area -->
    <div class="col-md-12">
		<div class="card">
			<div class="card-header d-flex align-items-center justify-content-between">
				<h3 class="card-title">Target Fisik dan Keuangan - Rekap</h3>
				<div class="d-flex align-items-center">
                    <form class="form-inline mr-3" method="get">
                        <label class="mr-2">Tahun:</label>
                        <?php $current = (int)($year ?? date('Y')); ?>
                        <select name="year" class="form-control form-control-sm" disabled readonly>
                            <option value="<?= $current ?>" selected><?= $current ?></option>
                        </select>
                        <input type="hidden" name="year" value="<?= $current ?>">
					</form>
                    <div class="btn-group">
                        <a class="btn btn-success btn-sm" id="btnExportPdf">Export PDF</a>
                        <a class="btn btn-success btn-sm" id="btnExportExcel">Export Excel</a>
                    </div>
				</div>
			</div>
			<div class="card-body">
				<?php if ($selectedMaster): ?>
				<div class="row">
					<!-- Data Table -->
					<div class="col-md-7">
						<div class="table-responsive">
							<table class="table table-bordered table-sm" id="rekapTable">
								<thead class="bg-light">
									<tr>
										<th style="width: 200px;">Kumulatif</th>
										<?php foreach ($months as $label): ?>
										<th class="text-center" style="width: 80px;"><?= $label ?></th>
										<?php endforeach; ?>
									</tr>
								</thead>
								<tbody>
									<?php $map = $details ?? []; ?>
									<!-- Target Fisik -->
                                    <tr>
                                        <td class="red-box"><strong>Target Fisik (%)</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['target_fisik']) ? (float)$d['target_fisik'] : 0; ?>
                                        <td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Realisasi Fisik -->
									<tr>
										<td><strong>Realisasi Fisik (%)</strong></td>
										<?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['realisasi_fisik']) ? (float)$d['realisasi_fisik'] : 0; ?>
										<td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Realisasi Fisik Prov -->
									<tr>
										<td><strong>Realisasi Fisik Prov (%)</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['realisasi_fisik_prov']) ? (float)$d['realisasi_fisik_prov'] : 0; ?>
										<td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Deviasi Fisik -->
									<tr class="bg-warning-light">
										<td><strong>Deviasi Fisik (%)</strong></td>
										<?php foreach ($months as $k=>$label): 
											$d = $map[$k] ?? []; 
                                            $target = (float)($d['target_fisik'] ?? 0);
											$realisasi = (float)($d['realisasi_fisik'] ?? 0);
											$deviasi = $realisasi - $target;
										?>
										<td class="text-center <?= $deviasi < 0 ? 'text-danger' : ($deviasi > 0 ? 'text-success' : '') ?>">
											<?= number_format($deviasi, 1) ?>
										</td>
										<?php endforeach; ?>
									</tr>
									<!-- Target Keuangan -->
									<tr>
                                        <td class="red-box"><strong>Target Keuangan (%)</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['target_keuangan']) ? (float)$d['target_keuangan'] : 0; ?>
										<td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Realisasi Keuangan -->
									<tr>
										<td><strong>Realisasi Keuangan (%)</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['realisasi_keuangan']) ? (float)$d['realisasi_keuangan'] : 0; ?>
										<td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Realisasi Keu Prov -->
									<tr>
										<td><strong>Realisasi Keu Prov (%)</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = isset($d['realisasi_keuangan_prov']) ? (float)$d['realisasi_keuangan_prov'] : 0; ?>
										<td class="text-center"><?= number_format($val, 1) ?></td>
										<?php endforeach; ?>
									</tr>
									<!-- Deviasi Keuangan -->
									<tr class="bg-warning-light">
										<td><strong>Deviasi Keuangan (%)</strong></td>
										<?php foreach ($months as $k=>$label): 
											$d = $map[$k] ?? []; 
                                            $target = (float)($d['target_keuangan'] ?? 0);
                                            $realisasi = (float)($d['realisasi_keuangan'] ?? 0);
											$deviasi = $realisasi - $target;
										?>
										<td class="text-center <?= $deviasi < 0 ? 'text-danger' : ($deviasi > 0 ? 'text-success' : '') ?>">
											<?= number_format($deviasi, 1) ?>
										</td>
										<?php endforeach; ?>
									</tr>
									<!-- Analisa -->
									<tr>
										<td><strong>Analisa</strong></td>
                                        <?php foreach ($months as $k=>$label): $d = $map[$k] ?? []; $val = $d['analisa'] ?? ''; ?>
										<td class="text-center"><?= esc($val) ?></td>
										<?php endforeach; ?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>

					<!-- Chart Area -->
					<div class="col-md-5">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Grafik Progress</h3>
							</div>
							<div class="card-body">
								<canvas id="progressChart" width="400" height="300"></canvas>
							</div>
						</div>
					</div>
				</div>
				<?php else: ?>
				<div class="alert alert-info text-center">
					<h4>Pilih Master Data untuk melihat rekap</h4>
					<p>Gunakan dropdown di atas untuk memilih master data yang ingin dilihat rekapnya.</p>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
.bg-warning-light {
	background-color: #fff3cd !important;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Data
const chartData = <?= json_encode($chartData ?? []) ?>;

// Create Chart
const ctx = document.getElementById('progressChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: chartData.map(d => d.month),
        datasets: [
            {
                label: 'T.Fisik',
                data: chartData.map(d => d.target_fisik),
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            },
            {
                label: 'R.Fisik',
                data: chartData.map(d => d.realisasi_fisik),
                borderColor: 'rgb(255, 99, 132)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                tension: 0.1
            },
            {
                label: 'T.Keuangan',
                data: chartData.map(d => d.target_keu),
                borderColor: 'rgb(54, 162, 235)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.1
            },
            {
                label: 'R.Keuangan',
                data: chartData.map(d => d.realisasi_keu),
                borderColor: 'rgb(255, 205, 86)',
                backgroundColor: 'rgba(255, 205, 86, 0.2)',
                tension: 0.1
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        },
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Export: build URLs to backend endpoints
document.getElementById('btnExportPdf').addEventListener('click', function(){
    var params = new URLSearchParams(window.location.search);
    if (!params.get('year')) params.set('year', '<?= (int)$year ?>');
    if (!params.get('tahapan')) params.set('tahapan', '<?= esc(service('request')->getGet('tahapan') ?? 'penetapan') ?>');
    window.location.href = '<?= base_url('tfk/rekap/export-pdf') ?>' + '?' + params.toString();
});
document.getElementById('btnExportExcel').addEventListener('click', function(){
    var params = new URLSearchParams(window.location.search);
    if (!params.get('year')) params.set('year', '<?= (int)$year ?>');
    if (!params.get('tahapan')) params.set('tahapan', '<?= esc(service('request')->getGet('tahapan') ?? 'penetapan') ?>');
    window.location.href = '<?= base_url('tfk/rekap/export-excel') ?>' + '?' + params.toString();
});
</script>
<?= $this->endSection() ?>