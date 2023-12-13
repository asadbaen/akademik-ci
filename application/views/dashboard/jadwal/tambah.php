<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Jadwal Pelajaran</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/jadwal/saveCreate" method="POST" enctype="multipart/form-data">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Mapel</label>
                                <select class="custom-select rounded-0" id="mapel_id" name="mapel_id">
                                    <option value="">Pilih Mapel</option>
                                    <?php foreach ($dataMapel as $value) : ?>

                                        <option value="<?php echo $value['id_mapel']; ?>">
                                            <?php echo $value["kode_mapel"]; ?> - <?php echo $value["nama_mapel"]; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_mapel', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Kode Guru</label>
                                <select class="custom-select rounded-0" id="guru_id" name="guru_id">
                                    <option value="">Pilih guru</option>
                                    <?php foreach ($dataGuru as $value) : ?>

                                        <option value="<?php echo $value['id_guru']; ?>">
                                            <?php echo $value["nama_guru"]; ?> (<?= $value['Kode_guru']; ?>) </option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_guru', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="custom-select rounded-0" id="kelas_id" name="kelas_id">
                                    <option value="<?php echo set_value('kelas'); ?>">Pilih Kelas</option>
                                    <?php foreach ($dataKelas as $value) : ?>

                                        <option value="<?php echo $value['id_kelas']; ?>">
                                            <?php echo $value["nama_kelas"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_kelas', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih hari</label>
                                <select name="hari" id="hari" class="form-control select2" required>
                                    <option value="">Pilih</option>
                                    <?php $hari = (object)array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"); ?>
                                    <?php foreach ($hari as $value) : ?>
                                        <option value="<?= $value ?>"><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <div class="input-group">
                                    <input type="hidden" name="tahun" id="tahun" value="<?= $tahun['id_tahun']; ?>">
                                    <input class="form-control" type="text" value="<?= $tahun['nama'] . ' - ' . $tahun['semester'] ?>" readonly>
                                    <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Awal Jam Mapel</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="awalj" id="" class="form-control select2" required>
                                                    <option value="">Jam</option>
                                                    <?php for ($i = 5; $i < 18; $i++) : ?>
                                                        <option value="<?= $i < 10 ? "0" . $i : $i ?>">Jam <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="akhirm" id="" class="form-control select2" required>
                                                    <option value="">Menit</option>
                                                    <?php for ($i = 0; $i < 60; $i++) : ?>
                                                        <option value="<?= $i < 10 ? "0" . $i : $i ?>">Menit <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="text-danger">Akhir Jam Mapel</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="awalj2" id="" class="form-control select2" required>
                                                    <option value="">Jam</option>
                                                    <?php for ($i = 5; $i < 18; $i++) : ?>
                                                        <option value="<?= $i < 10 ? "0" . $i : $i ?>">Jam <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="akhirm2" id="" class="form-control select2" required>
                                                    <option value="">Menit</option>
                                                    <?php for ($i = 0; $i < 60; $i++) : ?>
                                                        <option value="<?= $i < 10 ? "0" . $i : $i ?>">Menit <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
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