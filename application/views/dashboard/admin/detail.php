<!-- Navbar -->
<!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail admin</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v1</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detail Kepla</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form>
                            <div class="card-body col-md-6">
                                <div class="form-group">
                                    <label>Nip</label>
                                    <input type="text" id="nip" name="nip" class="form-control" placeholder="isi NIS admin" value="<?= $admin['nip']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" id="Nama" name="Nama" class="form-control" placeholder="isi NIK admin" value="<?= $admin['Nama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" id="Jabatan" name="Jabatan" class="form-control" placeholder="isi Jabatan admin" value="<?= $admin['Jabatan']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="custom-select rounded-0" id="Jenis_kelamin" name="Jenis_kelamin">
                                        <?php foreach ($enum_values as $value) : ?>
                                            <?php
                                            $display_value = ($value == 'L') ? 'Laki-laki' : (($value == 'P') ? 'Perempuan' : $value);
                                            ?>
                                            <option value="<?php echo $value; ?>" <?php if ($value == $admin['Jenis_kelamin']) echo 'selected'; ?>><?php echo $display_value; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="isi Tempat Lahir admin" value="<?= $admin['Tempat_lahir']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?= $admin['Tanggal_lahir']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" id="agama" name="agama" class="form-control" placeholder="isi agama" value="<?= $admin['agama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="isi Alamat admin" value="<?= $admin['alamat']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>No Telepon</label>
                                    <input type="text" id="No_telpon" name="No_telpon" class="form-control" placeholder="isi No_telpon admin" value="<?= $admin['No_telpon']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" id="email" name="email" class="form-control" placeholder="isi email admin" value="<?= $admin['email']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <div class="mt-2">
                                        <?php if ($admin['foto']) : ?>
                                            <img id="preview" src="<?= base_url('uploads/' . $admin['foto']); ?>" alt=" Image" style="max-width: 200px; max-height: 200px;">
                                        <?php else : ?>
                                            <img id="preview" src="#" alt=" Image" style="max-width: 200px; max-height: 200px; display: none;">
                                        <?php endif; ?>
                                    </div>
                                </div>
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