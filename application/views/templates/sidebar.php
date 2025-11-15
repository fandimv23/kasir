<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-cash-register"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi Kasir</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Master Data -->
    <div class="sidebar-heading">Master Data</div>

    <li class="nav-item <?= ($this->uri->segment(1) == 'produk') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('produk'); ?>">
            <i class="fas fa-fw fa-box"></i>
            <span>Data Produk</span>
        </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(1) == 'pelanggan') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('pelanggan'); ?>">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pelanggan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Transaksi -->
    <div class="sidebar-heading">Transaksi</div>

    <li class="nav-item <?= ($this->uri->segment(1) == 'penjualan') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('penjualan'); ?>">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Transaksi Penjualan</span>
        </a>
    </li>

    <li class="nav-item <?= ($this->uri->segment(1) == 'laporan_penjualan') ? 'active' : ''; ?>">
        <a class="nav-link" href="<?= base_url('laporan_penjualan'); ?>">
            <i class="fas fa-fw fa-chart-line"></i>
            <span>Laporan Penjualan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Admin Only -->
    <?php if ($this->session->userdata('level') == 'admin') : ?>
        <div class="sidebar-heading">Administrator</div>

        <li class="nav-item <?= ($this->uri->segment(1) == 'user') ? 'active' : ''; ?>">
            <a class="nav-link" href="<?= base_url('user'); ?>">
                <i class="fas fa-fw fa-user-cog"></i>
                <span>Manajemen User</span>
            </a>
        </li>

        <hr class="sidebar-divider">
    <?php endif; ?>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>

</ul>
