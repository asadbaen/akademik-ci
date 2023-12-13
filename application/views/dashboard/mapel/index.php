<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">Data Mapel</h3>
                    <p><a class="btn btn-primary float-sm-right" href="<?php echo base_url() ?>admin/mapel/create">Tambah Data</a></p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Mapel</th>
                                <th>Nama Mapel</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($dataMapel as $key) :  ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $key['kode_mapel']; ?></td>
                                    <td><?= $key['nama_mapel']; ?></td>


                                    <td>
                                        <div>
                                            <a class="btn btn-danger" href="<?php echo base_url() ?>admin/mapel/delete/<?= $key['id_mapel']; ?>">Delete</a>
                                            <a class="btn btn-primary" href="<?php echo base_url() ?>admin/mapel/edit/<?= $key['id_mapel'] ?>">Edit</a>
                                            <a class="btn btn-info" href="<?php echo base_url() ?>admin/mapel/kd/<?= $key['id_mapel']; ?>">info Kd</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Kode Mapel</th>
                                <th>Nama Mapel</th>
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