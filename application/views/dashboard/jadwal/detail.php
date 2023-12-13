<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Jadwal</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body col-md-6">

                            <div class="form-group">
                                <label for="mapel">Mapel</label>
                                <?php foreach ($dataMapel as $value) : ?>
                                    <?php if ($value['id_mapel'] == $jadwal['mapel_id']) : ?>
                                        <input class="form-control" type="text" value="<?= $value['nama_mapel']; ?>" readonly />
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label for="kodeGuru">Kode Guru</label>
                                <?php foreach ($dataGuru as $value) : ?>
                                    <?php if ($value['id_guru'] == $jadwal['guru_id']) : ?>
                                        <input class="form-control" type="text" value="<?= $value['nama_guru'] . ' (' . $value['Kode_guru'] . ')'; ?>" readonly />
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label for="kelas">Kelas</label>
                                <?php foreach ($dataKelas as $value) : ?>
                                    <?php if ($value['id_kelas'] == $jadwal['kelas_id']) : ?>
                                        <input class="form-control" type="text" value="<?= $value['nama_kelas']; ?>" readonly />
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Hari</label>
                                <input type="text" class="form-control" value="<?= $jadwal['hari']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Tahun ajaran</label>
                                <input type="text" class="form-control" value="<?= $jadwal['Tahun_ajaran']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Awal Jam Mapel</label>
                                        <div>
                                            <input type="text" class="form-control" value="<?= $jadwal['awal']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="text-danger">Akhir Jam Mapel</label>
                                        <div class="row">
                                            <input type="text" class="form-control" value="<?= $jadwal['akhir']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.card-body -->
                <!-- <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> -->
                </form>
            </div>
        </div>
    </div>
    <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->