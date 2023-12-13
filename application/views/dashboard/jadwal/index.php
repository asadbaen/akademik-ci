<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-md-12">
                <div class="card-header">
                    <h3 class="card-title">Data Jadwal</h3>
                    <?= $this->session->flashdata('message'); ?>
                    <?php echo validation_errors(); ?>
                    <p><a class="btn btn-primary float-sm-right" href="<?php echo base_url() ?>admin/jadwal/create">Tambah Data</a></p>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mapel</th>
                                <th>Guru</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Tahun Ajaran</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($dataJadwal as $key) :  ?>
                                <tr>
                                    <td><?= $i; ?></td>

                                    <?php foreach ($dataMapel as $mapel) : ?>
                                        <?php if ($mapel['id_mapel'] == $key['mapel_id']) : ?>
                                            <td>
                                                <?php echo $mapel['nama_mapel']; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($dataGuru as $guru) : ?>
                                        <?php if ($guru['id_guru'] == $key['guru_id']) : ?>
                                            <td>
                                                <?php echo $guru['nama_guru']; ?>
                                            </td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <?php foreach ($dataKelas as $kelas) : ?>
                                        <?php if ($kelas['id_kelas'] == $key['kelas_id']) : ?>
                                            <td>
                                                <?php echo $kelas['nama_kelas']; ?>
                                            </td>

                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    <td><?= $key['hari']; ?></td>
                                    <td><?= date("H:i", strtotime($key['awal'])) ?> - <?= date("H:i", strtotime($key['akhir'])) ?> </td>

                                    <td>
                                        <?php echo 'Semester' . ' : ' . $tahun['semester'] . ' - ' . $tahun['nama']; ?>
                                    </td>

                                    <td>
                                        <div>
                                            <a class="btn btn-danger" href="<?php echo base_url() ?>admin/jadwal/delete/<?= $key['id_jadwal']; ?>">Delete</a>
                                            <a class="btn btn-primary" href="<?php echo base_url() ?>admin/jadwal/edit/<?= $key['id_jadwal'] ?>">Edit</a>
                                            <a class="btn btn-info" href="<?php echo base_url() ?>admin/jadwal/detail/<?= $key['id_jadwal']; ?>">Detail</a>
                                        </div>
                                    </td>

                                </tr>
                                <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Mapel</th>
                                <th>Kode Guru</th>
                                <th>Kelas</th>
                                <th>Hari</th>
                                <th>Jam</th>
                                <th>Tahun Ajaran</th>
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