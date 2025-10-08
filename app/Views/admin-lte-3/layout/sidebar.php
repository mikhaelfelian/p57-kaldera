<?php
    helper(['general']);
?>
<aside class="main-sidebar sidebar-light-primary elevation-0">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link" style="border-bottom: 1px solid #eee; min-height: 60px; width: 100%; display: flex; align-items: center; justify-content: center; padding: 5px; box-sizing: border-box;">
        <img 
            src="<?= base_url('public/file/app/logo_only.png') ?>" 
            alt="KALDERA ESDM Logo" 
            class="brand-image" 
            style="width: 100%; height: auto; object-fit: contain; display: block; max-width: none;"
        >
        <!-- <span class="brand-text font-weight-light">&nbsp;<?php // $Pengaturan ? $Pengaturan->judul_app : env('app.name') ?></span> -->
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="<?php echo base_url((!empty($Pengaturan->logo) ? $Pengaturan->logo_header : 'public/assets/theme/admin-lte-3/dist/img/AdminLTELogo.png')); ?>"
                        class="brand-image img-rounded-0 elevation-0"
                        style="width: 209px; height: 85px; background-color: transparent;" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"></a>
                </div>
            </div>
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>"
                        class="nav-link <?= isMenuActive('dashboard') ? 'active' : '' ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php // if (isset($_GET['year']) && !empty($_GET['year'])): ?>
                    <li class="nav-header">MASTER DATA</li>
                    <li
                        class="nav-item has-treeview <?= isMenuActive(['tfk', 'tfk/data', 'tfk/input', 'tfk/rekap', 'tfk/master']) ? 'menu-open' : '' ?>">
                    <a href="#" 
                        class="nav-link <?= isMenuActive(['tfk', 'tfk/data', 'tfk/input', 'tfk/rekap', 'tfk/master']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-bullseye"></i>
                            <p>
                                Target Fisik & Keu
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('tfk/data') ?>"
                                    class="nav-link <?= isMenuActive(['tfk', 'tfk/data']) ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="<?= base_url('tfk/master') ?>"
                                    class="nav-link <?= isMenuActive('tfk/master') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-database nav-icon"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>-->
                            
                            <li class="nav-item">
                                <a href="<?= base_url('tfk/input') ?>"
                                    class="nav-link <?= isMenuActive('tfk/input') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li> 
               
                            <li class="nav-item">
                                <a href="<?= base_url('tfk/rekap') ?>"
                                    class="nav-link <?= isMenuActive('tfk/rekap') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['belanja/master','belanja/input','belanja/rekap']) ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('belanja/master') ?>" class="nav-link <?= isMenuActive(['belanja/master','belanja/input','belanja/rekap']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Belanja
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('belanja/master') ?>" class="nav-link <?= isMenuActive('belanja/master') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('belanja/input') ?>" class="nav-link <?= isMenuActive('belanja/input') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('belanja/rekap') ?>" class="nav-link <?= isMenuActive('belanja/rekap') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['pendapatan/master','pendapatan/input','pendapatan/rekap']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive(['pendapatan/master','pendapatan/input','pendapatan/rekap']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Pendapatan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('pendapatan/master') ?>" class="nav-link <?= isMenuActive('pendapatan/master') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pendapatan/input') ?>" class="nav-link <?= isMenuActive('pendapatan/input') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pendapatan/rekap') ?>" class="nav-link <?= isMenuActive('pendapatan/rekap') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['indikator/metadata','indikator/input','indikator/rekap']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive(['indikator/metadata','indikator/input','indikator/rekap']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Indikator Kinerja
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Metadata -->
                            <li class="nav-item">
                                <a href="<?= base_url('indikator/metadata') ?>" class="nav-link <?= isMenuActive('indikator/metadata') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-database nav-icon"></i>
                                    <p>Metadata</p>
                                </a>
                            </li>
                            <!-- Input -->
                            <li class="nav-item">
                                <a href="<?= base_url('indikator/input') ?>" class="nav-link <?= isMenuActive('indikator/input') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-keyboard nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive([
                        'pbj/input/indeks', 
                        'pbj/input/realisasi_pdn', 
                        'pbj/input/progres', 
                        'pbj/rekap/indeks', 
                        'pbj/rekap/realisasi_pdn', 
                        'pbj/rekap/progres'
                    ], true) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive([
                            'pbj/input/indeks', 
                            'pbj/input/realisasi_pdn', 
                            'pbj/input/progres', 
                            'pbj/rekap/indeks', 
                            'pbj/rekap/realisasi_pdn', 
                            'pbj/rekap/progres'
                        ], true) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>
                                Pencatatan PBJ
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- Input Section -->
                            <li class="nav-header font-weight-bold" style="font-size: 1rem;"><?= nbs(3) ?>Input</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/input/indeks') ?>" class="nav-link <?= isMenuActive('pbj/input/indeks') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <p>Indeks PBJ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/input/realisasi_pdn') ?>" class="nav-link <?= isMenuActive('pbj/input/realisasi_pdn') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <p>Indeks Realisasi PDN</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/input/progres') ?>" class="nav-link <?= isMenuActive('pbj/input/progres') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-line nav-icon"></i>
                                    <p>Progres PBJ</p>
                                </a>
                            </li>
                            <!-- Rekap Section -->
                            <li class="nav-header font-weight-bold mt-2" style="font-size: 1rem;"><?= nbs(3) ?>Rekap</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/rekap/indeks') ?>" class="nav-link <?= isMenuActive('pbj/rekap/indeks') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Indeks PBJ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/rekap/realisasi_pdn') ?>" class="nav-link <?= isMenuActive('pbj/rekap/realisasi_pdn') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Indeks Realisasi PDN</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pbj/rekap/progres') ?>" class="nav-link <?= isMenuActive('pbj/rekap/progres') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-chart-bar nav-icon"></i>
                                    <p>Progres PBJ</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['banmas']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive(['banmas']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>
                                Bantuan Masyarakat
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('banmas') ?>" class="nav-link <?= isMenuActive('banmas') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-keyboard nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['prokons']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive(['prokons']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Progres Konsultasi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('prokons') ?>" class="nav-link <?= isMenuActive('prokons') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-keyboard nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive(['pt-minerba', 'pt-gat', 'pt-gatrik', 'pt-ebt']) ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= isMenuActive(['pt-minerba', 'pt-gat', 'pt-gatrik', 'pt-ebt']) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>
                                Persetujuan Teknis
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                                                        <li class="nav-item">
                                <a href="<?= base_url('pt-minerba/master') ?>" class="nav-link <?= isMenuActive(['pt-minerba/master']) ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-building nav-icon"></i>
                                    <p>Master Unit Kerja</p>
                                </a>
                            </li>
                            <!-- Sektor Minerba -->
                            <li class="nav-header font-weight-bold"><?= nbs(2) ?>Sektor Minerba</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-minerba/input') ?>" class="nav-link <?= isMenuActive('pt-minerba/master') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-minerba/rekap') ?>" class="nav-link <?= isMenuActive('pt-minerba/rekap') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>

                            <!-- Sektor GAT -->
                            <li class="nav-header font-weight-bold"><?= nbs(2) ?>Sektor GAT</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-gat/input') ?>" class="nav-link <?= isMenuActive('pt-gat/input') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-gat/rekap') ?>" class="nav-link <?= isMenuActive('pt-gat/rekap') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>

                            <!-- Sektor Gatrik -->
                            <li class="nav-header font-weight-bold"><?= nbs(2) ?>Sektor Gatrik</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-gatrik/input') ?>" class="nav-link <?= isMenuActive('pt-gatrik/input') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-gatrik/rekap') ?>" class="nav-link <?= isMenuActive('pt-gatrik/rekap') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>

                            <!-- Sektor EBT -->
                            <li class="nav-header font-weight-bold"><?= nbs(2) ?>Sektor EBT</li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-ebt/input') ?>" class="nav-link <?= isMenuActive('pt-ebt/input') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-edit nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('pt-ebt/rekap') ?>" class="nav-link <?= isMenuActive('pt-ebt/rekap') ? 'active' : '' ?>">
                                    <?= nbs(5) ?>
                                    <i class="fas fa-table nav-icon"></i>
                                    <p>Rekap</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Additional menu items as in the image -->
                    <li class="nav-item has-treeview <?= isMenuActive('gender') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('gender') ?>" class="nav-link <?= isMenuActive('gender') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-venus-mars"></i>
                            <p>
                                Gender
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('gender') ?>" class="nav-link <?= isMenuActive('gender') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive('risiko') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('risiko') ?>" class="nav-link <?= isMenuActive('risiko') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-shield-alt"></i>
                            <p>
                                Manajemen Risiko
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('risiko') ?>" class="nav-link <?= isMenuActive('risiko') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive('sdgs') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('sdgs') ?>" class="nav-link <?= isMenuActive('sdgs') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-globe"></i>
                            <p>
                                SDG's
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('sdgs') ?>" class="nav-link <?= isMenuActive('sdgs') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive('gulkin') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('gulkin') ?>" class="nav-link <?= isMenuActive('gulkin') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-industry"></i>
                            <p>
                                Gulkin
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('gulkin') ?>" class="nav-link <?= isMenuActive('gulkin') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive('links') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('links') ?>" class="nav-link <?= isMenuActive('links') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-map-marked-alt"></i>
                            <p>
                                Web Gis ESDM
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('links') ?>" class="nav-link <?= isMenuActive('links') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= isMenuActive('uploads') ? 'menu-open' : '' ?>">
                        <a href="<?= base_url('uploads') ?>" class="nav-link <?= isMenuActive('uploads') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Pelaporan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('uploads') ?>" class="nav-link <?= isMenuActive('uploads') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>
                                ESDM Feedback
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('esdm-feedbacks') ?>" class="nav-link <?= isMenuActive('esdm-feedbacks') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php // endif; ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<style>
/* Force logo to fill sidebar width */
.main-sidebar .brand-link {
    width: 100% !important;
    padding: 5px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-sizing: border-box !important;
}

.main-sidebar .brand-link .brand-image {
    width: 100% !important;
    max-width: none !important;
    height: auto !important;
    object-fit: contain !important;
    display: block !important;
    margin: 0 !important;
}

/* Override any AdminLTE styles */
.brand-link {
    width: 100% !important;
    padding: 5px !important;
}

.brand-image {
    width: 100% !important;
    max-width: none !important;
}
</style>