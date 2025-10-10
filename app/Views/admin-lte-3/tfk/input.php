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
        <h3 class="card-title mb-0">TARGET FISIK & KEUANGAN</h3>
    </div>
    <div class="card-body rounded-0">
        <form id="tfkInputForm" method="get">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="font-weight-bold">Tahun</label>
                    <select name="year" class="form-control rounded-0" id="yearSelect">
                        <?php
                        $currentYear = date('Y');
                        $selectedYear = isset($year) ? (int) $year : $currentYear;
                        for ($i = $currentYear - 5; $i <= $currentYear + 5; $i++):
                            ?>
                            <option value="<?= $i ?>" <?= ($selectedYear == $i) ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
            </select>
                </div>
                <div class="col-md-4">
                    <label class="font-weight-bold">Tahapan</label>
                    <select name="tahapan" class="form-control rounded-0" id="tahapanSelect">
                        <?php foreach ($tahapanList as $key => $label): ?>
                            <option value="<?= $key ?>" <?= ($tahapan === $key) ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
                </div>
    </div>

            <div class="table-responsive rounded-0">
                <table class="table table-bordered rounded-0" id="tfkTable">
                    <thead style="background-color: #275a9a; color: white;">
                        <tr>
                            <th style="width: 200px;">Kumulatif</th>
                            <th class="text-center">Januari</th>
                            <th class="text-center">Februari</th>
                            <th class="text-center">Maret</th>
                            <th class="text-center">April</th>
                            <th class="text-center">Mei</th>
                            <th class="text-center">Juni</th>
                            <th class="text-center">Juli</th>
                            <th class="text-center">Agustus</th>
                            <th class="text-center">September</th>
                            <th class="text-center">Oktober</th>
                            <th class="text-center">November</th>
                            <th class="text-center">Desember</th>
                    </tr>
                </thead>
                <tbody>
                        <!-- Target Fisik (%) -->
                        <tr>
                            <td class="red-box font-weight-bold">Target Fisik (%)</td>
                            <td class="text-center static-cell" data-bulan="jan" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="feb" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="mar" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="apr" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="mei" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="jun" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="jul" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="ags" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="sep" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="okt" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="nov" data-field="target_fisik">0.00</td>
                            <td class="text-center static-cell" data-bulan="des" data-field="target_fisik">0.00</td>
                    </tr>

                        <!-- Realisasi Fisik (%) -->
                        <tr>
                            <td class="font-weight-bold">Realisasi Fisik (%)</td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jan" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="feb" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mar" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="apr" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mei" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jun" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jul" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="ags" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="sep" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="okt" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="nov" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="des" data-field="realisasi_fisik">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                    </tr>

                        <!-- Realisasi Fisik Prov (%) -->
                        <tr>
                            <td class="font-weight-bold">Realisasi Fisik Prov (%)</td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jan"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="feb"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mar"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="apr"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mei"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jun"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jul"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="ags"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="sep"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="okt"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="nov"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="des"
                                    data-field="realisasi_fisik_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                    </tr>

                        <!-- Deviasi Fisik (%) -->
                        <tr>
                            <td class="font-weight-bold">Deviasi Fisik (%)</td>
                            <td class="text-center calculated-cell" data-bulan="jan" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="feb" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="mar" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="apr" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="mei" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="jun" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="jul" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="ags" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="sep" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="okt" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="nov" data-type="deviasi_fisik">0.00</td>
                            <td class="text-center calculated-cell" data-bulan="des" data-type="deviasi_fisik">0.00</td>
                    </tr>

                        <!-- Target Keuangan (%) -->
                        <tr class="sep-top">
                            <td class="red-box font-weight-bold">Target Keuangan (%)</td>
                            <td class="text-center static-cell" data-bulan="jan" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="feb" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="mar" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="apr" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="mei" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="jun" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="jul" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="ags" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="sep" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="okt" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="nov" data-field="target_keuangan">0.00</td>
                            <td class="text-center static-cell" data-bulan="des" data-field="target_keuangan">0.00</td>
                    </tr>

                        <!-- Realisasi Keuangan (%) -->
                        <tr>
                            <td class="font-weight-bold">Realisasi Keuangan (%)</td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jan" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="feb" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mar" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="apr" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mei" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jun" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jul" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="ags" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="sep" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="okt" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="nov" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="des" data-field="realisasi_keuangan">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                    </tr>

                        <!-- Realisasi Keuangan Prov (%) -->
                        <tr>
                            <td class="font-weight-bold">Realisasi Keuangan Prov (%)</td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jan"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="feb"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mar"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="apr"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="mei"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jun"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="jul"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="ags"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="sep"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="okt"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="nov"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-cell" data-bulan="des"
                                    data-field="realisasi_keuangan_prov">0.00</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                    </tr>

                        <!-- Deviasi Keuangan (%) -->
                        <tr>
                            <td class="font-weight-bold">Deviasi Keuangan (%)</td>
                            <td class="text-center calculated-cell" data-bulan="jan" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="feb" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="mar" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="apr" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="mei" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="jun" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="jul" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="ags" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="sep" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="okt" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="nov" data-type="deviasi_keuangan">0.00
                            </td>
                            <td class="text-center calculated-cell" data-bulan="des" data-type="deviasi_keuangan">0.00
                            </td>
                    </tr>

                        <!-- Analisa -->
                        <tr>
                            <td class="font-weight-bold">Analisa</td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="jan" data-field="analisa">Kegiatan on
                                    progress</span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="feb" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="mar" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="apr" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="mei" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="jun" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="jul" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="ags" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="sep" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="okt" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="nov" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                            <td class="text-center">
                                <span class="editable-text-cell" data-bulan="des" data-field="analisa"></span>
                                <i class="fas fa-pencil-alt text-muted ml-1 edit-icon"></i>
                            </td>
                    </tr>
                </tbody>
            </table>
            </div>
        </form>
        </div>
    <div class="card-footer rounded-0 d-flex justify-content-end">
        <button type="button" class="btn btn-success rounded-0" id="btnSave">
            <i class="fas fa-save"></i> Simpan
        </button>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css') ?>
<style>
    #tfkTable {
        border-color: #1f4986;
    }

    #tfkTable th {
        background-color: #275a9a;
        color: #fff;
        text-align: center;
    }

    #tfkTable td {
        vertical-align: middle;
        background: #e6eef8;
    }

    #tfkTable tbody tr:nth-child(odd) td {
        background: #f3f7fc;
    }

    #tfkTable .editable-cell,
    #tfkTable .editable-text-cell {
        cursor: pointer;
    }

    #tfkTable td.red-box {
        border: 3px solid #d9534f !important;
        background-color: #fff;
        color: #d9534f;
    }

    #tfkTable td:first-child {
        font-weight: 600;
    }

    #tfkTable .sep-top td {
        border-top: 4px solid #000 !important;
    }

    .edit-icon {
        cursor: pointer;
        opacity: 0.7;
    }

    .edit-icon:hover {
        opacity: 1;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    (function () {
        var csrfToken = '<?= csrf_token() ?>';
        var csrfHash = '<?= csrf_hash() ?>';

        // Format number to en-US style with dot decimals and comma thousands
        function formatAngka(num) {
            if (num === null || num === undefined || isNaN(num)) return '0.00';
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }).format(parseFloat(num));
        }

        // Parse localized number text (e.g., "56,98" -> 56.98)
        function parseLocaleNumber(text) {
            if (text === null || text === undefined) return 0;
            if (typeof text === 'number') return isNaN(text) ? 0 : text;
            var s = String(text).trim();
            if (!s) return 0;
            var hasComma = s.indexOf(',') !== -1;
            var hasDot = s.indexOf('.') !== -1;
            if (hasComma && hasDot) {
                // Determine decimal separator by the last occurrence
                if (s.lastIndexOf(',') > s.lastIndexOf('.')) {
                    // comma is decimal, dot is thousands: 1.234,56
                    s = s.replace(/\./g, '').replace(',', '.');
                } else {
                    // dot is decimal, comma is thousands: 1,234.56
                    s = s.replace(/,/g, '');
                }
            } else if (hasComma) {
                // Only comma present -> decimal is comma
                s = s.replace(/\./g, '').replace(',', '.');
            } else {
                // Only dot or none -> decimal is dot
                s = s.replace(/,/g, '');
            }
            var n = parseFloat(s);
            return isNaN(n) ? 0 : n;
        }

        // Edit numeric cells
        function openNumericEdit(span) {
            var value = parseLocaleNumber(span.text());
        var input = $('<input type="number" step="0.01" class="form-control form-control-sm rounded-0" />');
        input.val(value);
            span.hide();
            span.after(input);
            input.focus();

            function commit() {
                var newVal = parseLocaleNumber(input.val());
                span.text(formatAngka(newVal));
                // mark as staged so we only save modified cells
                span.data('staged', newVal);
                span.addClass('has-changes');
                input.remove();
                span.show();
                recalculateDeviations();
            }

            input.on('blur', commit);
            input.on('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    commit();
                }
            });
        }

        // Edit text cells
        function openTextEdit(span) {
            var value = span.text();
        var input = $('<textarea class="form-control form-control-sm rounded-0" rows="2"></textarea>');
        input.val(value);
            span.hide();
            span.after(input);
            input.focus();

            function commit() {
                var newVal = input.val();
                span.text(newVal);
                // mark as staged
                span.data('staged', newVal);
                span.addClass('has-changes');
                input.remove();
                span.show();
            }

        input.on('blur', commit);
            input.on('keydown', function (e) {
                if (e.key === 'Enter' && e.ctrlKey) {
                    e.preventDefault();
                    commit();
                }
            });
        }

        // Recalculate deviations
        function recalculateDeviations() {
            var months = ['jan', 'feb', 'mar', 'apr', 'mei', 'jun', 'jul', 'ags', 'sep', 'okt', 'nov', 'des'];

            months.forEach(function (bulan) {
                // Get target and realisasi values - parse formatted numbers correctly
                var targetFisikText = $('td[data-bulan="' + bulan + '"][data-field="target_fisik"]').text();
                var realFisikText = $('span[data-bulan="' + bulan + '"][data-field="realisasi_fisik"]').text();
                var targetKeuText = $('td[data-bulan="' + bulan + '"][data-field="target_keuangan"]').text();
                var realKeuText = $('span[data-bulan="' + bulan + '"][data-field="realisasi_keuangan"]').text();

                // Parse formatted numbers with comma decimal
                var targetFisik = parseLocaleNumber(targetFisikText);
                var realFisik = parseLocaleNumber(realFisikText);
                var targetKeu = parseLocaleNumber(targetKeuText);
                var realKeu = parseLocaleNumber(realKeuText);

                // Calculate deviations
                var devFisik = realFisik - targetFisik;
                var devKeu = realKeu - targetKeu;

                // Update deviation cells
                $('td[data-bulan="' + bulan + '"][data-type="deviasi_fisik"]').text(formatAngka(devFisik));
                $('td[data-bulan="' + bulan + '"][data-type="deviasi_keuangan"]').text(formatAngka(devKeu));
            });
        }

        // Event handlers
        $(document).on('click', '.editable-cell', function () {
            openNumericEdit($(this));
        });

        $(document).on('click', '.editable-text-cell', function () {
            openTextEdit($(this));
        });

        $(document).on('click', '.edit-icon', function () {
            var span = $(this).siblings('span').first();
            if (span.hasClass('editable-cell')) {
                openNumericEdit(span);
            } else if (span.hasClass('editable-text-cell')) {
                openTextEdit(span);
            }
        });

        // Load data when tahapan changes
        function loadData() {
            var tahun = $('#yearSelect').val();
            var tahapan = $('#tahapanSelect').val();

            console.log('=== LOADING DATA ===');
            console.log('Tahun:', tahun);
            console.log('Tahapan:', tahapan);

            if (!tahun || !tahapan) {
                console.error('Missing required parameters:', { tahun, tahapan });
                return;
            }

            $.get('<?= base_url('tfk/get-data') ?>', {
                tahun: tahun,
                tahapan: tahapan,
                _: Date.now()
            }, function (res) {
                console.log('=== AJAX RESPONSE ===');
                console.log('Response:', res);

                if (res && res.ok && res.data && Object.keys(res.data).length > 0) {
                    console.log('Data found, updating table...');
                    updateTableWithData(res.data);
                    console.log('Data loaded successfully');
                } else {
                    console.log('No data found, resetting to defaults');
                    resetTableToDefaults();
                }
            }, 'json').fail(function (xhr) {
                console.error('=== AJAX ERROR ===');
                console.error('Status:', xhr.status);
                console.error('Response:', xhr.responseText);
                if (window.toastr) {
                    toastr.error('Gagal memuat data dari database');
                }
            });
        }

        // Reset table to default values
        function resetTableToDefaults() {
            // Reset static target cells to 0 (no hardcoded values)
            $('.static-cell').each(function () {
                var $cell = $(this);
                var field = $cell.data('field');

                if (field === 'target_fisik' || field === 'target_keuangan') {
                    $cell.text(formatAngka(0));
                }
            });

            // Reset editable cells to 0
            $('.editable-cell').each(function () {
                $(this).text(formatAngka(0));
            });

            // Reset text cells to empty
            $('.editable-text-cell').each(function () {
                $(this).text('');
            });

            // Recalculate deviations
            recalculateDeviations();
        }

        // Update table with loaded data
        function updateTableWithData(data) {
            console.log('Updating table with data:', data);

            // Update static target cells
            $('.static-cell').each(function () {
                var $cell = $(this);
                var bulan = $cell.data('bulan');
                var field = $cell.data('field');

                if (data[bulan] && data[bulan][field] !== undefined) {
                    $cell.text(formatAngka(data[bulan][field]));
                    console.log('Updated static cell:', bulan, field, data[bulan][field]);
                }
            });

            // Update editable cells
            $('.editable-cell').each(function () {
                var $span = $(this);
                var bulan = $span.data('bulan');
                var field = $span.data('field');

                if (data[bulan] && data[bulan][field] !== undefined) {
                    $span.text(formatAngka(data[bulan][field]));
                    console.log('Updated editable cell:', bulan, field, data[bulan][field]);
                }
            });

            // Update text cells
            $('.editable-text-cell').each(function () {
                var $span = $(this);
                var bulan = $span.data('bulan');
                var field = $span.data('field');

                if (data[bulan] && data[bulan][field] !== undefined) {
                    $span.text(data[bulan][field]);
                    console.log('Updated text cell:', bulan, field, data[bulan][field]);
                }
            });

            // Recalculate deviations
            recalculateDeviations();
        }

        // Bind change events
        $(document).on('change', '#tahapanSelect', function () {
            console.log('Tahapan changed to:', $(this).val());
            loadData();
        });


        $(document).on('change', '#yearSelect', function () {
            console.log('Year changed to:', $(this).val());
            loadData();
        });

        // Test button for debugging
        $('#btnTest').on('click', function () {
            console.log('=== MANUAL TEST LOAD ===');
            loadData();
        });

        // Save button
        $('#btnSave').on('click', function () {
            var formData = {
                tahun: $('#yearSelect').val(),
                tahapan: $('#tahapanSelect').val(),
            };

            // Collect all cell data
            var cellData = {};
            $('.editable-cell, .editable-text-cell').each(function () {
                var $span = $(this);
                var bulan = $span.data('bulan');
                var field = $span.data('field');
                var staged = $span.data('staged');
                // Only send modified cells to avoid overwriting existing data
                if (staged === undefined) { return; }
                var value = $span.hasClass('editable-cell') ? parseLocaleNumber(staged) : staged;

                if (!cellData[bulan]) {
                    cellData[bulan] = {};
                }
                cellData[bulan][field] = value;
            });

            formData.data = cellData;
            formData[csrfToken] = csrfHash;

            $.post('<?= base_url('tfk/save-all') ?>', formData, function (res) {
                if (res && res.csrf_hash) {
                    csrfHash = res.csrf_hash;
                }
                if (res && res.ok) {
                    if (window.toastr) {
                        toastr.success(res.message || 'Data berhasil disimpan');
                    }
                    // apply staged values as current and clear staging
                    $('.editable-cell, .editable-text-cell').each(function(){
                        var $span = $(this);
                        var staged = $span.data('staged');
                        if (staged !== undefined) {
                            if ($span.hasClass('editable-cell')) {
                                $span.text(formatAngka(parseLocaleNumber(staged)));
                            } else {
                                $span.text(staged);
                            }
                            $span.removeData('staged');
                            $span.removeClass('has-changes');
                        }
                    });
                } else {
                    if (window.toastr) {
                        toastr.error(res.message || 'Gagal menyimpan data');
                    }
                }
            }, 'json').fail(function () {
                if (window.toastr) {
                    toastr.error('Gagal menyimpan data');
                }
            });
        });

        // Direct event binding for dropdowns
        $('#tahapanSelect').on('change', function () {
            console.log('Tahapan dropdown changed to:', $(this).val());
            loadData();
        });


        $('#yearSelect').on('change', function () {
            console.log('Year dropdown changed to:', $(this).val());
            loadData();
        });

        // Load data on page load
        loadData();
})();
</script>
<?= $this->endSection() ?>
