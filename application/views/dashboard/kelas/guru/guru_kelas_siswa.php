<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <?= $this->session->flashdata('message'); ?>
                    <?php echo validation_errors(); ?>
                    <h3 class="card-title">DataTable Kelas</h3>
                    <p><a class="btn btn-primary float-sm-right" href="<?php echo base_url() ?>admin/guru_kelas/tambah_kelas_siswa">Tambah Data</a></p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>NIS</th>
                                <th>Siswa</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($kelas_siswa as $key) :  ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $key['nama_kelas']; ?></td>
                                    <td><?= $key['nis']; ?></td>
                                    <td><?= $key['nama_siswa']; ?></td>
                                    <td>
                                        <div>
                                            <a class="btn btn-danger" href="<?php echo base_url() ?>admin/guru_kelas/delete/<?= $key['id_kelas_siswa']; ?>">Delete</a>
                                            <a class="btn btn-primary" href="<?php echo base_url() ?>admin/guru_kelas/edit_kelas_siswa/<?= $key['id_kelas_siswa'] ?>">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kelas</th>
                                <th>NIS</th>
                                <th>Siswa</th>
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