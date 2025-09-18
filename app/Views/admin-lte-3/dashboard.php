<?= $this->extend(theme_path('main')) ?>

<?= $this->section('css') ?>
<style>
    .kaldera-wrap { border-top: 8px solid #7fb19f; border-bottom: 8px solid #7fb19f; background: #f5f6f7; padding: 10px 10px 20px 10px; }
    .kaldera-left .menu-item { display: flex; align-items: center; margin: 12px 0; font-weight: 700; }
    .kaldera-left .menu-num { width: 28px; height: 28px; background: #f1f671; border: 2px solid #b7be2a; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; margin-right: 8px; }
    .kaldera-left .menu-title { color: #214c3f; }
    .kaldera-right .header-strip { background: #d1e3cf; padding: 10px 15px; font-weight: 700; color: #214c3f; }
    .welcome-panel { background: #59a16f; border-radius: 28px; color: #fff; padding: 24px; margin: 26px 0 12px 0; min-height: 220px; display: flex; align-items: center; justify-content: space-between; }
    .welcome-panel .text-block { font-family: Menlo, Consolas, Monaco, monospace; }
    .welcome-panel .text-block .small { color: #d9f2e1; font-weight: 800; letter-spacing: .5px; }
    .welcome-panel .title { font-weight: 900; font-size: 20px; }
    .welcome-panel .subtitle { font-weight: 800; font-size: 16px; margin-bottom: 8px; }
    .welcome-panel .desc { opacity: .95; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="kaldera-wrap">
<div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between py-2">
                <h3 class="m-0 font-weight-bold">KONSEP <em>LAYOUT</em> KALDERA ESDM</h3>
                <div class="text-right small text-muted">
                    <div><strong><?= esc($user->first_name ?? '') ?></strong></div>
                    <div>OPD Program - NIP</div>
            </div>
        </div>
    </div>
        <div class="col-md-3 kaldera-left">
        <div class="card">
                <div class="card-body p-3">
                    <div class="menu-item"><span class="menu-num">1</span><span class="menu-title">Target Fisik & Keu</span></div>
                    <div class="menu-item"><span class="menu-num">2</span><span class="menu-title">Belanja</span></div>
                    <div class="menu-item"><span class="menu-num">3</span><span class="menu-title">Pendapatan</span></div>
                    <div class="menu-item"><span class="menu-num">4</span><span class="menu-title">Indikator Kinerja</span></div>
                    <div class="menu-item"><span class="menu-num">5</span><span class="menu-title">Pencatatan PBJ</span></div>
                    <div class="menu-item"><span class="menu-num">6</span><span class="menu-title">Belanja ke Masyarakat</span></div>
                    <div class="menu-item"><span class="menu-num">7</span><span class="menu-title">Progres Konsultansi/Konstruksi</span></div>
                    <div class="menu-item"><span class="menu-num">8</span><span class="menu-title">Persetujuan Teknis</span></div>
                        </div>
                    </div>
                </div>
        <div class="col-md-9 kaldera-right">
            <div class="header-strip">Beranda</div>
            <div class="welcome-panel">
                <div class="text-block">
                    <div class="small">SUGENG RAWUH</div>
                    <div class="title">KALDERA ESDM <span class="font-weight-normal">2025</span></div>
                    <div class="desc">Sistem Kinerja Pengendalian Dan</div>
                    <div class="desc">Pelaporan Digital ESDM</div>
            </div>
                <div class="text-right">
                    <i class="fas fa-chart-line fa-5x" style="opacity:.8"></i>
                </div>
            </div>
                </div>
            </div>
</div>
<?= $this->endSection() ?>

