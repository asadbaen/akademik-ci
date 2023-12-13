<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit kelas</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/guru_kelas/update_kelas_siswa" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_kelas_siswa" id="id_kelas_siswa" value="<?= $kelas_siswa['id_kelas_siswa']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="hidden" name="tahun" id="tahun" value="<?= $tahun['id_tahun']; ?>">
                                <input class="form-control" type="text" value="<?= $tahun['nama'] . ' - ' . $tahun['semester'] ?>" readonly>
                                <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="custom-select rounded-0" id="id_kelas" name="id_kelas">
                                    <?php foreach ($data_kelas as $value) : ?>
                                        <option value="<?php echo $value['id_kelas']; ?>" <?php if ($value['id_kelas'] == $kelas_siswa['id_kelas']) echo 'selected'; ?>><?= $value['nama_kelas']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Siswa</label>
                                <select class="custom-select rounded-0" id="id_siswa" name="id_siswa">
                                    <?php foreach ($data_siswa as $value) : ?>
                                        <option value="<?php echo $value['id_siswa']; ?>" <?php if ($value['id_siswa'] == $kelas_siswa['id_siswa']) echo 'selected'; ?>><?= $value['nama_siswa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Checkbox untuk memindahkan kelas -->
                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="pindah_kelas" name="pindah_kelas" value="1">
                                    <label class="form-check-label" for="pindah_kelas">
                                        Pindahkan ke Kelas Lain
                                    </label>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>