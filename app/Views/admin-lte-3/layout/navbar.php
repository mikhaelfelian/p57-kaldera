<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" title="Toggle Sidebar">
                <i class="fas fa-bars"></i>
            </a>
        </li>
        <li class="nav-item">
            <span class="nav-link" id="tanggalan">
                <?= format_tanggal_waktu() ?>
            </span>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <?php 
                $navbarImage = '';
                if (!empty($user->profile)) {
                    $imagePath = $user->profile;
                    if (strpos($imagePath, 'public/') === 0) {
                        $imagePath = substr($imagePath, 7);
                    }
                    $fullPath = FCPATH . $imagePath;
                    if (file_exists($fullPath)) {
                        $navbarImage = base_url($imagePath);
                    }
                }
                ?>
                <?php if ($navbarImage): ?>
                    <img src="<?= $navbarImage ?>" class="user-image img-circle elevation-0" alt="User Image">
                <?php else: ?>
                    <div class="user-image img-circle elevation-0 bg-primary d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 14px; color: white;">
                        <?= strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?>
                    </div>
                <?php endif; ?>
                <span class="d-none d-md-inline"><?= $user->first_name ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-success">
                    <?php 
                    $dropdownImage = '';
                    if (!empty($user->profile)) {
                        $imagePath = $user->profile;
                        if (strpos($imagePath, 'public/') === 0) {
                            $imagePath = substr($imagePath, 7);
                        }
                        $fullPath = FCPATH . $imagePath;
                        if (file_exists($fullPath)) {
                            $dropdownImage = base_url($imagePath);
                        }
                    }
                    ?>
                    <?php if ($dropdownImage): ?>
                        <img src="<?= $dropdownImage ?>" class="img-circle elevation-0" alt="User Image">
                    <?php else: ?>
                        <div class="img-circle elevation-0 bg-primary d-flex align-items-center justify-content-center mx-auto" style="width: 90px; height: 90px; font-size: 36px; color: white;">
                            <?= strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?>
                        </div>
                    <?php endif; ?>
                    <p>
                        <?= $user->first_name . ' ' . $user->last_name ?>
                        <small>Member since <?= date('d-m-Y', $user->created_on) ?></small>
                    </p>
                </li>
                
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="<?= base_url('profile') ?>" class="btn btn-default btn-flat">Profile</a>
                    <a href="<?= base_url('auth/logout') ?>" class="btn btn-default btn-flat float-right">Sign out</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>

<script>
function updateDateTime() {
    const now = new Date();
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    
    const day = days[now.getDay()];
    const date = String(now.getDate()).padStart(2, '0');
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    const time = now.toTimeString().split(' ')[0];
    
    const formatted = `${day}, ${date} ${month} ${year} | ${time}`;
    document.querySelector('#tanggalan').textContent = formatted;
}

// Update every second
setInterval(updateDateTime, 1000);
updateDateTime(); // Initial call
</script> 