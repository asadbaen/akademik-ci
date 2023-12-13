<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-circle"></i> Data Diri</h1>
    </div>
    <?php if ($this->session->flashdata('message')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $this->session->flashdata('message'); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-3" class="text-center">
                    <h6 class="text-dark font-weight-bold">Foto Guru</h6>
                    <div id="foto" class="mb-3">
                        <?php if ($siswa['foto']) : ?>
                            <img src="<?= base_url('uploads/' . $siswa['foto']) ?>" alt="foto <?= $siswa['nama_siswa'] ?>" style="width: 200px; height: 300px; border-radius: 15px;">
                        <?php else : ?>
                            <img src="<?= base_url('assets/photos/user-placeholder.jpg') ?>" alt="photo <?= $siswa['nama_siswa'] ?>" style="width: 200px; height: 300px; border-radius: 15px;">
                        <?php endif ?>
                    </div>
                </div>
                <div class="col-sm-9">
                    <h6 class="text-dark font-weight-bold">Data Diri</h6>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-borderless no-margin table-striped">
                                <tr>
                                    <th class="text-left" width="150px">NIS</th>
                                    <td><span id="nis">: <?= $siswa['nis'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">NIK</th>
                                    <td><span id="nik">: <?= $siswa['nik'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Nama</th>
                                    <td><span id="nama_siswa">: <?= $siswa['nama_siswa'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Jenis Kelamin</th>
                                    <td>
                                        <span id="jenis-kelamin">:
                                            <?php
                                            $jenis_kelamin = $siswa['Jenis_kelamin'];
                                            if ($jenis_kelamin == 'P') {
                                                echo 'Perempuan';
                                            } elseif ($jenis_kelamin == 'L') {
                                                echo 'Laki-laki';
                                            } else {
                                                echo 'Tidak diketahui';
                                            }
                                            ?>
                                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Tanggal Lahir</th>
                                    <td><span id="tanggal-lahir">: <?= $siswa['Tanggal_lahir'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Tempat Lahir</th>
                                    <td><span id="Tempat-lahir">: <?= $siswa['Tempat_lahir'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Agama</th>
                                    <td><span id="agama">: <?= $siswa['Agama'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Nama Ayah</th>
                                    <td><span id="Nama_ayah">: <?= $siswa['Nama_ayah'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Pekerjaan Ayah</th>
                                    <td><span id="Pekerjaan_ayah">: <?= $siswa['Pekerjaan_ayah'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">Nama Ibu</th>
                                    <td><span id="Nama_ibu">: <?= $siswa['Nama_ibu'] ?></span></td>
                                </tr>

                                <tr>
                                    <th class="text-left" width="150px">Pekerjaan Ibu</th>
                                    <td><span id="Pekerjaan_ibu">: <?= $siswa['Pekerjaan_ibu'] ?></span></td>
                                </tr>
                                <tr>
                                    <th class="text-left" width="150px">No. Telepon</th>
                                    <td><span id="No_telpon">: <?= $siswa['No_telpon'] ?></span></td>
                                </tr>
                            </table>
                            <?= anchor('siswa/datadiri/password', '<div class="btn btn-sm btn-primary  mr-1 ml-1 mb-1"><i class="fa fa-lock"></i> Ganti Password</div>') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>