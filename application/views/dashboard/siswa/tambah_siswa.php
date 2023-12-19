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
                    <form action="<?php echo base_url(); ?>admin/siswa/saveCreate" method="POST" enctype="multipart/form-data">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" id="nis" name="nis" class="form-control" placeholder="isi NIS Siswa" value="<?php echo set_value('nis'); ?>">
                                <?= form_error('nis', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" placeholder="isi NIK Siswa" value="<?php echo set_value('nik'); ?>">
                                <?= form_error('nik', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="isi Nama Siswa" value="<?php echo set_value('nama_siswa'); ?>">
                                <?= form_error('nama_siswa', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="custom-select rounded-0" id="Jenis_kelamin" name="Jenis_kelamin">
                                    <option value="<?php echo set_value('Jenis_kelamin'); ?>">Pilih Jenis Kelamin</option>
                                    <?php foreach ($enum_values as $value) : ?>
                                        <?= $display_value = ($value == 'L') ? 'Laki - Laki' : (($value == 'P') ? 'Perempuan' : $value); ?>
                                        <option value="<?php echo $value; ?>"><?php echo $display_value; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?= form_error('Jenis_kelamin', '<small class="text-danger">', '</small>'); ?>
                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="isi Tempat Lahir Siswa" value="<?php echo set_value('Tempat_lahir'); ?>">
                                <?= form_error('Tempat_lahir', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?php echo set_value('Tanggal_lahir'); ?>">
                                <?= form_error('Tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <select class="custom-select rounded-0" id="Agama" name="Agama">
                                    <option value="">- Pilih Agama -</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="isi Alamat Siswa">
                                <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="number" id="No_telpon" name="No_telpon" class="form-control" placeholder="isi No Telepon Siswa" value="<?php echo set_value('No_telpon'); ?>">
                                <?= form_error('No_telpon', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" name="Nama_ayah" id="Nama_ayah" class="form-control" placeholder="isi Nama Ayah Siswa" value="<?php echo set_value('Nama_ayah'); ?>">
                                <?= form_error('Nama_ayah', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Ibu</label>
                                <input type="text" id="Nama_ibu" name="Nama_ibu" class="form-control" placeholder="isi Nama Ibu Siswa" value="<?php set_value('Nama_ibu'); ?>">
                                <?= form_error('Nama_ibu', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ayah</label>
                                <input type="text" id="Pekerjaan_ayah" name="Pekerjaan_ayah" class="form-control" placeholder="isi Pekerjaan Ayah Siswa" value="<?php echo set_value('Pekerjaan_ayah'); ?>">
                                <?= form_error('Pekerjaan_ayah', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ibu</label>
                                <input type="text" id="Pekerjaan_ibu" name="Pekerjaan_ibu" class="form-control" placeholder="isi Pekerjaan Ibu Siswa" value="<?php echo set_value('Pekerjaan_ibu'); ?>">
                                <?= form_error('Pekerjaan_ibu', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Input Foto</label>
                                <img id="preview" src="#" alt="Product Image" style="max-width: 200px; max-height: 200px; margin-top: 10px; display: none;">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="foto" id="foto" class="custom-file-input" onchange="previewImage(event)" />
                                        <label class="custom-file-label">Choose file</label>
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