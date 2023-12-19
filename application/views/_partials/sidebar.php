<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url('/') ?>" class="brand-link">
        <img src="<?= base_url(); ?>assets/dist/img/logo/logoSMP.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('uploads/' . $foto) ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $nama; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu  Admin-->

        <?php if ($this->session->userdata("level") == "admin") : ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('admin') ?>" class="nav-link <?php if ($menu == 'dashboard') echo 'active' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                User
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/user'); ?>" class="nav-link <?php if ($menu == 'user') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/profile'); ?>" class="nav-link <?php if ($menu == 'profile') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/guru'); ?>" class="nav-link <?php if ($menu == 'guru') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Guru</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/siswa'); ?>" class="nav-link <?php if ($menu == 'siswa') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Siswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Pembelajaran
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/tahun_ajaran'); ?>" class="nav-link <?php if ($menu == 'tahun_ajaran') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tahun Ajaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/mapel'); ?>" class="nav-link <?php if ($menu == 'mapel') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Mata Pelajaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/jadwal'); ?>" class="nav-link <?php if ($menu == 'jadwal') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Jadwal Pelajaran</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Kelas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/absensi'); ?>" class="nav-link <?php if ($menu == 'absensi') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Absensi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/kelas'); ?>" class="nav-link <?php if ($menu == 'kelas') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Kelas</p>
                                </a>
                            </li>
                            <?php
                            $queryKelas = "SELECT * FROM `tbl_kelas`";

                            $data_kelas = $this->db->query($queryKelas)->result_array();

                            // var_dump($data_kelas);
                            // die();
                            ?>

                            <?php foreach ($data_kelas as $kelas) : ?>

                                <?php
                                $kelas_id = $kelas['id_kelas'];
                                $queryKelas_siswa = "select * form `tbl_kelas_siswa` where `id_kelas` = $kelas_id";

                                // var_dump($queryKelas_siswa);
                                // die();
                                ?>
                                <li class="nav-item">
                                    <a href="<?php echo base_url() ?>admin/Kelas_siswa/kelasId/<?= $kelas['id_kelas'] ?>" class="nav-link <?php if ($menu == 'kelas_siswa') echo 'active' ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p><?= $kelas['nama_kelas']; ?></p>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/guru_kelas'); ?>" class="nav-link <?php if ($menu == 'guru_kelas') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Guru kelas</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>
                                Nilai
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/nilai') ?>" class="nav-link <?php if ($menu == 'nilai') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nilai Siswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Cetak data
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('admin/Laporan_nilai') ?>" class="nav-link  <?php if ($menu == 'laporan_nilai') echo 'active' ?>">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laporan Nilai Siswa</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
        <!-- /.sidebar-menu Admin-->

        <!-- Sidebar Menu  Siswa-->
        <?php if ($this->session->userdata("level") == "siswa") : ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('siswa') ?>" class="nav-link <?php if ($menu == 'dashboard') echo 'active' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('siswa/datadiri') ?>" class="nav-link <?php if ($menu == 'datadiri') echo 'active' ?>">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('siswa/nilai') ?>" class="nav-link <?php if ($menu == 'nilai') echo 'active' ?>">
                            <i class="nav-icon fas fa-pen-square"></i>
                            <p>
                                Nilai
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('siswa/datadiri/password') ?>" class="nav-link <?php if ($menu == 'password') echo 'active' ?>">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Ganti Password
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>
        <?php if ($this->session->userdata("level") == "guru") : ?>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('guru') ?>" class="nav-link <?php if ($menu == 'dashboard') echo 'active' ?>">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('guru/profile') ?>" class="nav-link <?php if ($menu == 'datadiri') echo 'active' ?>">
                            <i class="nav-icon fas fa-user-alt"></i>
                            <p>
                                Profile
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('guru/nilai') ?>" class="nav-link <?php if ($menu == 'nilai') echo 'active' ?>">
                            <i class="nav-icon fas fa-pen-square"></i>
                            <p>
                                Nilai
                            </p>
                        </a>
                    </li>
                    <li class="nav-item menu-open">
                        <a href="<?php echo base_url('guru/jadwal') ?>" class="nav-link <?php if ($menu == 'jadwal') echo 'active' ?>">
                            <i class="nav-icon fas fa-pen-square"></i>

                            <p>
                                Jadwal Pelajaran
                            </p>
                        </a>
                    </li>

                </ul>
            </nav>
        <?php endif; ?>
        <!-- /.sidebar-menu Admin-->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Dashboard</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <?php foreach ($breadcrumb as $bc) {
                            if ($bc->link != NULL) {
                                echo '<li class="breadcrumb-item"><a href="' . base_url($bc->link) . '">' . $bc->name . '</a></li>';
                            } else {
                                echo '<li class="breadcrumb-item active">' . $bc->name . '</li>';
                            }
                        }
                        ?>

                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->