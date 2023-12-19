<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit guru</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/guru/saveUpdate" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_guru" id="id_guru" value="<?= $guru['id_guru']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Nip</label>
                                <input type="text" id="nip" name="nip" class="form-control" placeholder="isi nip guru" value="<?= $guru['nip']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" id="nama_guru" name="nama_guru" class="form-control" placeholder="Nama Lengkap" value="<?= $guru['nama_guru']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Nama Lengkap" value="<?= $guru['email']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <select class="custom-select rounded-0" id="Jenis_kelamin" name="Jenis_kelamin">
                                    <?php foreach ($enum_values as $value) : ?>
                                        <?php
                                        $display_value = ($value == 'L') ? 'Laki-laki' : (($value == 'P') ? 'Perempuan' : $value);
                                        ?>
                                        <option value="<?php echo $value; ?>" <?php if ($value == $guru['Jenis_kelamin']) echo 'selected'; ?>><?php echo $display_value; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                            <div class="form-group">
                                <label>Tempat Lahir</label>
                                <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="isi Tempat Lahir guru" value="<?= $guru['Tempat_lahir']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?= $guru['Tanggal_lahir']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="Agama">Agama</label>
                                <select class="custom-select rounded-0" id="Agama" name="Agama">
                                    <option value="">- Pilih Agama -</option>
                                    <?php
                                    $agamaOptions = array('Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha');

                                    foreach ($agamaOptions as $agamaOption) {
                                        echo '<option value="' . $agamaOption . '"';

                                        // Periksa apakah agama dari database cocok dengan opsi saat ini
                                        if ($guru['Agama'] == $agamaOption) {
                                            echo ' selected';
                                        }

                                        echo '>' . $agamaOption . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" id="alamat" name="alamat" class="form-control" placeholder="isi Alamat guru" value="<?= $guru['alamat']; ?>">
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="number" id="No_telpon" name="No_telpon" class="form-control" placeholder="isi No Telepon guru" value="<?= $guru['No_telpon']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Kode Guru</label>
                                <input type="text" name="Kode_guru" id="Kode_guru" class="form-control" placeholder="Kode guru" value="<?= $guru['Kode_guru']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Input Foto</label>
                                <div class="mt-2">
                                    <?php if ($guru['foto_guru']) : ?>
                                        <img id="preview" src="<?= base_url('uploads/' . $guru['foto_guru']); ?>" alt="Product Image" style="max-width: 200px; max-height: 200px;">
                                    <?php else : ?>
                                        <img id="preview" src="#" alt="Product Image" style="max-width: 200px; max-height: 200px; display: none;">
                                    <?php endif; ?>
                                </div>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="foto_guru" id="foto_guru" class="custom-file-input" onchange="previewImage(event)" />
                                        <input name="delete_foto_guru" value="<?= base_url('uploads/' . $guru['foto_guru']); ?>" type="hidden" onchange="previewImage(event)" />
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