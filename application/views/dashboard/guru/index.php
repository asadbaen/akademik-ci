<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">DataTable Guru</h3>
                    <p><a class="btn btn-primary float-sm-right" href="<?php echo base_url('admin/guru/create') ?>">Tambah Data</a></p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nip</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Tempat Lahir</th>
                                <th>Agama</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($data as $key) :  ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $key['nip']; ?></td>
                                    <td><?= $key['nama_guru']; ?></td>
                                    <td><?= $key['Jabatan']; ?></td>
                                    <td><?= $key['Jenis_kelamin']; ?></td>
                                    <td><?= $key['Tanggal_lahir']; ?></td>
                                    <td><?= $key['Tempat_lahir']; ?></td>
                                    <td><?= $key['Agama']; ?></td>
                                    <td>
                                        <div>
                                            <a class="btn btn-danger" href="<?php echo base_url('admin/guru/delete/') ?><?= $key['id_guru']; ?>">Delete</a>
                                            <a class="btn btn-primary" href="<?php echo base_url('admin/guru/edit/') ?><?= $key['id_guru'] ?>">Edit</a>
                                            <a class="btn btn-info" href="<?php echo base_url() ?>admin/guru/detail/<?= $key['id_guru']; ?>">Detail</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nip</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                <th>Tempat Lahir</th>
                                <th>Agama</th>
                                <th>Action</th>

                            </tr>
                        </tfoot>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->