<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Mapel</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/mapel/saveCreate" method="POST" enctype="multipart/form-data">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Nama Mapel</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="nama_mapel" placeholder="Mata Pelajaran" value="<?php echo set_value('nama_mapel'); ?>">
                                </div>
                                <?= form_error('nama_mapel', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <div class="input-group">
                                    <input class="form-control" type="text" name="kode_mapel" placeholder="Mata Pelajaran" value="<?php echo set_value('kode_mapel'); ?>">
                                </div>
                                <?= form_error('kode_mapel', '<small class="text-danger">', '</small>'); ?>
                            </div>
                            <div class="form-group">
                                <label for="komp_dasar">Kompetensi Dasar</label>
                                <div class="input-group control-group after-add-kd">
                                    <input type="text" name="kd[]" class="form-control" id="komp_dasar" placeholder="Masukan Kompetensi Dasar">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary add-kd" type="button"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <?php echo form_error('kd[]', '<div class="text-danger small ml-3">', '</div>') ?>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <div class="kd-copy invisible">
                        <div class="input-group control-group mt-2">
                            <input type="text" name="kd[]" class="form-control" id="komp_dasar_add" placeholder="Masukan Kompetensi Dasar">
                            <div class="input-group-btn">
                                <button class="btn btn-danger remove-kd" type="button"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
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