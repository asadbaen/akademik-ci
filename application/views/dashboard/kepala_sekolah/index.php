<!-- Navbar -->
<!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-5">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <?php foreach ($data as $key) : ?>
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="<?= base_url('uploads/' . $key['foto']); ?>" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center"><?= $key['Nama']; ?></h3>

                                <p class="text-muted text-center"><?= $key['Jabatan']; ?></p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>NIP</b> <a class="float-right"><?= $key['nip']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Nama</b> <a class="float-right"><?= $key['Nama']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Jabatan</b> <a class="float-right"><?= $key['Jabatan']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Jenis Kelamin</b> <a class="float-right">
                                            <?php
                                            $display_key = ($key['Jenis_kelamin'] == 'L') ? 'Laki-laki' : (($key['Jenis_kelamin'] == 'P') ? 'Perempuan' : $key['Jenis_kelamin']);
                                            echo $display_key . '<br>';

                                            ?>

                                        </a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Alamat</b> <a class="float-right"><?= $key['alamat']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tanggal Lahir</b> <a class="float-right"><?= $key['Tanggal_lahir']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tempat Lahir</b> <a class="float-right"><?= $key['Tempat_lahir']; ?></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Agama</b> <a class="float-right"><?= $key['agama']; ?></a>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->