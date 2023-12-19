<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="card col-md-12">
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