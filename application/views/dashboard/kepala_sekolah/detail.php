<!-- Navbar -->
<!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Kepala</h1>
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
                                    <input type="text" id="nip" name="nip" class="form-control" placeholder="isi NIS kepala" value="<?= $kepala['nip']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" id="Nama" name="Nama" class="form-control" placeholder="isi NIK kepala" value="<?= $kepala['Nama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" id="Jabatan" name="Jabatan" class="form-control" placeholder="isi Jabatan kepala" value="<?= $kepala['Jabatan']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <select class="custom-select rounded-0" id="Jenis_kelamin" name="Jenis_kelamin">
                                        <?php foreach ($enum_values as $value) : ?>
                                            <?php
                                            $display_value = ($value == 'L') ? 'Laki-laki' : (($value == 'P') ? 'Perempuan' : $value);
                                            ?>
                                            <option value="<?php echo $value; ?>" <?php if ($value == $kepala['Jenis_kelamin']) echo 'selected'; ?>><?php echo $display_value; ?></option>
                                        <?php endforeach; ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="isi Tempat Lahir kepala" value="<?= $kepala['Tempat_lahir']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?= $kepala['Tanggal_lahir']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" id="agama" name="agama" class="form-control" placeholder="isi agama" value="<?= $kepala['agama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="isi Alamat kepala" value="<?= $kepala['alamat']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Foto</label>
                                    <div class="mt-2">
                                        <?php if ($kepala['foto']) : ?>
                                            <img id="preview" src="<?= base_url('uploads/' . $kepala['foto']); ?>" alt=" Image" style="max-width: 200px; max-height: 200px;">
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