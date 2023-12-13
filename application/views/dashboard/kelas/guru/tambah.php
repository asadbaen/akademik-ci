<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Siswa</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/guru_kelas/simpan_kelas_siswa" method="POST" enctype="multipart/form-data">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <input type="hidden" name="tahun" id="tahun" value="<?= $tahun['nama']; ?>">
                                <input class="form-control" type="text" value="<?= $tahun['nama'] . ' - ' . $tahun['semester'] ?>" readonly>
                                <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pilih Kelas</label>
                                <select class="custom-select rounded-0" id="id_kelas" name="id_kelas">
                                    <option value="<?php echo set_value('id_kelas'); ?>">Pilih Kelas</option>
                                    <?php foreach ($kelas as $value) : ?>
                                        <option value="<?php echo $value['id_kelas']; ?>"><?php echo $value['nama_kelas']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_kelas', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pilih Siswa</label>
                                <select class="custom-select rounded-0" id="id_siswa" name="id_siswa">
                                    <option value="<?php echo set_value('id_siswa'); ?>">Pilih Siswa</option>
                                    <?php foreach ($siswa as $value) : ?>
                                        <option value="<?php echo $value['id_siswa']; ?>"><?php echo $value['nama_siswa']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('id_siswa', '<small class="text-danger">', '</small>'); ?>
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
<!-- /.content-wrapper -->
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var preview = document.getElementById('preview');
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>