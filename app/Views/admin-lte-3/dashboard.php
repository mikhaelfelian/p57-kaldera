<?= $this->extend(theme_path('main')) ?>

<?= $this->section('css') ?>
<style>
    .kaldera-wrap {
        border-top: 8px solid #7fb19f;
        border-bottom: 8px solid #7fb19f;
        background: #f5f6f7;
        padding: 10px 10px 20px 10px;
    }

    .kaldera-left .menu-item {
        display: flex;
        align-items: center;
        margin: 12px 0;
        font-weight: 700;
    }

    .kaldera-left .menu-num {
        width: 28px;
        height: 28px;
        background: #f1f671;
        border: 2px solid #b7be2a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-right: 8px;
    }

    .kaldera-left .menu-title {
        color: #214c3f;
    }

    .kaldera-right .header-strip {
        background: #d1e3cf;
        padding: 10px 15px;
        font-weight: 700;
        color: #214c3f;
    }

    .welcome-panel {
        background: #59a16f;
        border-radius: 28px;
        color: #fff;
        padding: 24px;
        margin: 26px 0 12px 0;
        min-height: 220px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .welcome-panel .text-block {
        font-family: Menlo, Consolas, Monaco, monospace;
    }

    .welcome-panel .text-block .small {
        color: #d9f2e1;
        font-weight: 800;
        letter-spacing: .5px;
    }

    .welcome-panel .title {
        font-weight: 900;
        font-size: 20px;
    }

    .welcome-panel .subtitle {
        font-weight: 800;
        font-size: 16px;
        margin-bottom: 8px;
    }

    .welcome-panel .desc {
        opacity: .95;
    }

    /* Professional Year Selection Cards Styling */
    .year-selection-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        padding: 2rem;
        margin: 1rem 0;
    }

    .year-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .year-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 1;
    }

    .year-card:hover::before {
        opacity: 1;
    }

    .year-card:hover {
        transform: translateY(-8px) scale(1.02);
    }

    .year-card .card {
        border: none;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .year-card .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .year-card:hover .card::before {
        transform: scaleX(1);
    }

    .year-card:hover .card {
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }

    .year-card .card-body {
        padding: 2.5rem 1.5rem;
        position: relative;
        z-index: 2;
    }

    .year-card .year-icon {
        margin-bottom: 1.5rem;
    }

    .year-card .year-icon .icon-wrapper {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        position: relative;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        transition: all 0.3s ease;
    }

    .year-card:hover .year-icon .icon-wrapper {
        transform: scale(1.1);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
    }

    .year-card .year-icon .icon-wrapper i {
        font-size: 2rem;
        color: #ffffff;
    }

    .year-card .card-title {
        color: #2c3e50;
        font-weight: 700;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .year-card .year-number {
        font-size: 2.5rem;
        font-weight: 900;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        line-height: 1;
    }

    .year-card:hover .year-number {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .year-card .card-subtitle {
        color: #6c757d;
        font-size: 0.9rem;
        font-weight: 500;
        margin-top: 0.5rem;
    }

    /* Active state */
    .year-card.active .card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .year-card.active .card::before {
        background: rgba(255, 255, 255, 0.3);
        transform: scaleX(1);
    }

    .year-card.active .card-title {
        color: rgba(255, 255, 255, 0.9);
    }

    .year-card.active .year-number {
        color: white;
        -webkit-text-fill-color: white;
    }

    .year-card.active .card-subtitle {
        color: rgba(255, 255, 255, 0.7);
    }

    .year-card.active .year-icon .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .year-selection-container {
            padding: 1rem;
        }
        
        .year-card .card-body {
            padding: 1.5rem 1rem;
        }
        
        .year-card .year-icon .icon-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .year-card .year-icon .icon-wrapper i {
            font-size: 1.5rem;
        }
        
        .year-card .year-number {
            font-size: 2rem;
        }
    }
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
    <div class="row">
        <div class="col-12">
            <div class="year-selection-container">
                <div class="text-center mb-4">
                    <h2 class="font-weight-bold text-dark mb-2">
                        <i class="fas fa-calendar-check text-primary mr-2"></i>
                        Pilih Tahun Data Fiskal
                    </h2>
                    <p class="text-muted">Silakan pilih tahun untuk mengakses data fiskal yang tersedia</p>
                </div>
                
                <div class="row" id="year-selection">
                    <?php if (!empty($availableYears)): ?>
                        <?php foreach ($availableYears as $year): ?>
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                                <div class="year-card" data-year="<?= $year ?>" style="cursor: pointer;">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <div class="year-icon">
                                                <div class="icon-wrapper">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </div>
                                            <h5 class="card-title">E-Penatausahaan</h5>
                                            <h2 class="year-number"><?= $year ?></h2>
                                            <p class="card-subtitle">Data Fiskal</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <i class="fas fa-database fa-4x text-muted"></i>
                                </div>
                                <h4 class="text-muted mb-3">Belum Ada Data Fiskal</h4>
                                <p class="text-muted">Data fiskal belum tersedia. Silakan hubungi administrator untuk menambahkan data.</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
$(document).ready(function() {
    // Year selection functionality
    $('.year-card').on('click', function() {
        var selectedYear = $(this).data('year');
        
        // Remove active class from all cards
        $('.year-card').removeClass('active');
        
        // Add active class to selected card
        $(this).addClass('active');
        
        // Show loading state
        showLoading();
        
        // Here you can add AJAX call to load data for selected year
        // For now, we'll just show an alert
        setTimeout(function() {
            hideLoading();
            showYearData(selectedYear);
        }, 1000);
    });
    
    // Add professional active state styling
    $('<style>')
        .prop('type', 'text/css')
        .html(`
            .year-card.active .card {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
                color: white !important;
                transform: translateY(-8px) scale(1.02) !important;
                box-shadow: 0 20px 40px rgba(102, 126, 234, 0.3) !important;
            }
            .year-card.active .card::before {
                background: rgba(255, 255, 255, 0.3) !important;
                transform: scaleX(1) !important;
            }
            .year-card.active .card-title {
                color: rgba(255, 255, 255, 0.9) !important;
            }
            .year-card.active .year-number {
                color: white !important;
                -webkit-text-fill-color: white !important;
            }
            .year-card.active .card-subtitle {
                color: rgba(255, 255, 255, 0.7) !important;
            }
            .year-card.active .year-icon .icon-wrapper {
                background: rgba(255, 255, 255, 0.2) !important;
                box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2) !important;
            }
        `)
        .appendTo('head');
    
    function showLoading() {
        // You can implement a loading spinner here
        console.log('Loading data...');
    }
    
    function hideLoading() {
        // Hide loading spinner
        console.log('Data loaded');
    }
    
    function showYearData(year) {
        // Show professional success message
        Swal.fire({
            title: 'Tahun Berhasil Dipilih!',
            html: `
                <div class="text-center">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="text-dark mb-2">E-Penatausahaan ${year}</h5>
                    <p class="text-muted mb-0">Data fiskal untuk tahun ${year} telah dipilih dan siap digunakan.</p>
                </div>
            `,
            icon: 'success',
            confirmButtonText: 'Lanjutkan',
            confirmButtonColor: '#667eea',
            showCancelButton: true,
            cancelButtonText: 'Batal',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // You can redirect to a specific page or load data here
                // window.location.href = '<?= base_url() ?>target-fisik-keu?year=' + year;
                console.log('Proceeding with year:', year);
            }
        });
    }
});
</script>
<?= $this->endSection() ?>