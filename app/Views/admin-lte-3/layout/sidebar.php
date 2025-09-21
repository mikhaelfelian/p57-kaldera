<aside class="main-sidebar sidebar-light-primary elevation-0">
    <!-- Brand Logo -->
    <a href="<?= base_url() ?>" class="brand-link">
        <img src="<?= $Pengaturan->logo ? base_url($Pengaturan->logo) : base_url('public/assets/theme/admin-lte-3/dist/img/AdminLTELogo.png') ?>"
            alt="AdminLTE Logo" class="brand-image img-circle elevation-0" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $Pengaturan ? $Pengaturan->judul_app : env('app.name') ?></span>
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
                <?php if (isset($_GET['year']) && !empty($_GET['year'])): ?>
                    <li class="nav-header">MASTER DATA</li>
                    <li
                        class="nav-item has-treeview <?= isMenuActive(['tfk/master', 'tfk/rekap', 'tfk/input'], true) ? 'menu-open' : '' ?>">
                        <a href="#"
                            class="nav-link <?= isMenuActive(['tfk/master', 'tfk/rekap', 'tfk/input'], true) ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-bullseye"></i>
                            <p>
                                Target Fisik & Keu
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= base_url('tfk/master') ?>"
                                    class="nav-link <?= isMenuActive('tfk/master') ? 'active' : '' ?>">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-eye nav-icon"></i>
                                    <p>Master Data</p>
                                </a>
                            </li>
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
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-basket"></i>
                            <p>
                                Belanja
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>
                                Pendapatan
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-line"></i>
                            <p>
                                Indikator Kinerja
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-clipboard-check"></i>
                            <p>
                                Pencatatan PBJ
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>
                                Belanja ke Masyarakat
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>
                                Progres Konsultansi/Konstruksi
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle"></i>
                            <p>
                                Persetujuan Teknis
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- Additional menu items as in the image -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">Gender</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">Manajemen Risiko</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">SDG’s</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">Gulkin</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">Web Gis ESDM</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-check-circle" style="color: #000;"></i>
                            <p>
                                <span style="font-weight:bold;color:#000;">Pelaporan</span>
                                <i class="right fas fa-angle-left" style="color:#000;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p>Input</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <?= nbs(3) ?>
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>Data</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
</aside>