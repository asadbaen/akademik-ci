<nav class="main-header navbar navbar-expand navbar-white ">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav">
        <li class="">Sistem Informasi Pengolahan Data Nilai Siswa</li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <?php if ($this->session->userdata("level") == "admin") : ?>
                <div class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <p>Hello, <?= $nama ?></p>
                </div>
            <?php endif; ?>

            <?php if ($this->session->userdata("level") == "siswa") : ?>
                <div class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <p>Hello, <?= $nama ?></p>
                </div>

            <?php endif; ?>
            <?php if ($this->session->userdata("level") == "guru") : ?>
                <div class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <p>Hello, <?= $nama ?></p>
                </div>

            <?php endif; ?>
        </li>

        <!-- Messages Dropdown Menu -->

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-user-alt"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="<?= base_url('uploads/' . $foto) ?> " alt=" User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h4 class="dropdown">
                                <?= $nama; ?>
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h4>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>

                <div class="dropdown-divider"></div>
                <a href="" class="dropdown-item dropdown-footer" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->

<div class="c-body">
    <main class="c-main">

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apakah Anda ingin Logout?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="<?php echo base_url('login/logout') ?>">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Navbar -->