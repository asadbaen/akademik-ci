<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Siswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/siswa/saveUpdate" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_siswa" id="id_siswa" value="<?= $siswa['id_siswa']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>NIS</label>
                                <input type="text" id="nis" name="nis" class="form-control" placeholder="isi NIS Siswa" value="<?= $siswa['nis']; ?>">
                            </div>
                            <div class="form-group">
                                <label>NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" placeholder="isi NIK Siswa" value="<?= $siswa['nik']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" id="nama_siswa" name="nama_siswa" class="form-control" placeholder="isi nama_siswa Siswa" value="<?= $siswa['nama_siswa']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="custom-select rounded-0" id="Jenis_kelamin" name="Jenis_kelamin">
                                    <?php foreach ($enum_values as $value) : ?>
                                        <?php
                                        $display_value = ($value == 'L') ? 'Laki-laki' : (($value == 'P') ? 'Perempuan' : $value);
                                        ?>
                                        <option value="<?php echo $value; ?>" <?php if ($value == $siswa['Jenis_kelamin']) echo 'selected'; ?>><?php echo $display_value; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="isi Tempat Lahir Siswa" value="<?= $siswa['Tempat_lahir']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?= $siswa['Tanggal_lahir']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" id="Agama" name="Agama" class="form-control" placeholder="isi Agama Siswa" value="<?= $siswa['Agama']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="isi Alamat Siswa" value="<?= $siswa['alamat']; ?>">
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="number" id="No_telpon" name="No_telpon" class="form-control" placeholder="isi No Telepon Siswa" value="<?= $siswa['No_telpon']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Nama Ayah</label>
                                <input type="text" name="Nama_ayah" id="Nama_ayah" class="form-control" placeholder="isi Nama Ayah Siswa" value="<?= $siswa['Nama_ayah']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Nama Ibu</label>
                                <input type="text" id="Nama_ibu" name="Nama_ibu" class="form-control" placeholder="isi Nama Ibu Siswa" value="<?= $siswa['Nama_ibu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ayah</label>
                                <input type="text" id="Pekerjaan_ayah" name="Pekerjaan_ayah" class="form-control" placeholder="isi Pekerjaan Ayah Siswa" value="<?= $siswa['Pekerjaan_ayah']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Pekerjaan Ibu</label>
                                <input type="text" id="Pekerjaan_ibu" name="Pekerjaan_ibu" class="form-control" placeholder="isi Pekerjaan Ibu Siswa" value="<?= $siswa['Pekerjaan_ibu']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Input Foto</label>
                                <div class="mt-2">
                                    <?php if ($siswa['foto']) : ?>
                                        <img id="preview" src="<?= base_url('uploads/' . $siswa['foto']); ?>" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <img id="preview" src="#" alt="Product Image" style="max-width: 200px; max-height: 200px; display: none;">
                                    <?php endif; ?>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="foto" id="foto" class="custom-file-input" onchange="previewImage(event)" />
                                        <input name="delete_foto_siswa" value="<?= base_url('uploads/' . $siswa['foto']); ?>" type="hidden" onchange="previewImage(event)" />
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