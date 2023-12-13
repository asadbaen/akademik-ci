<!-- Navbar -->
<!-- Main Sidebar Container -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Table Guru</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Table Kepala Sekolah</li>
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
                            <h3 class="card-title">Tambah kepala</h3>
                            <?= $this->session->flashdata('message'); ?>
                            <?php echo validation_errors(); ?>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="<?php echo base_url(); ?>save-kepala-create" method="POST" enctype="multipart/form-data">
                            <div class="card-body col-md-6">
                                <div class="form-group">
                                    <label>NIP</label>
                                    <input type="number" id="nip" name="nip" class="form-control" placeholder="isi NIP" value="<?php echo set_value('nip'); ?>">
                                    <?= form_error('nip', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" id="Nama" name="Nama" class="form-control" placeholder="Nama Lengkap" value="<?php echo set_value('Nama'); ?>">
                                    <?= form_error('Nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Jabatan</label>
                                    <input type="text" id="Jabatan" name="Jabatan" class="form-control" placeholder="Jabatan" value="<?php echo set_value('Jabatan'); ?>">
                                    <?= form_error('Jabatan', '<small class="text-danger">', '</small>'); ?>
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
                                    <input type="text" id="Tempat_lahir" name="Tempat_lahir" class="form-control" placeholder="Tempat Lahir " value="<?php echo set_value('Tempat_lahir'); ?>">
                                    <?= form_error('Tempat_lahir', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" id="Tanggal_lahir" name="Tanggal_lahir" class="form-control" value="<?php echo set_value('Tanggal_lahir'); ?>">
                                    <?= form_error('Tanggal_lahir', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Agama</label>
                                    <input type="text" id="agama" name="agama" class="form-control" placeholder="agama" value="<?php echo set_value('agama'); ?>">
                                    <?= form_error('agama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <input type="text" id="alamat" name="alamat" class="form-control" placeholder="Alamat Lengkap">
                                    <?= form_error('alamat', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Input Foto</label>
                                    <img id="preview" src="#" alt="foto" style="max-width: 200px; max-height: 200px; margin-top: 10px; display: none;">
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