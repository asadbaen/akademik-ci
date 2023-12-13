<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Tambah Kelas</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/kelas/saveCreate" method="POST" enctype="multipart/form-data">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Nama Kelas</label>
                                <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" placeholder="isi nama_kelas" value="<?php echo set_value('nama_kelas'); ?>">
                                <?= form_error('nama_kelas', '<small class="text-danger">', '</small>'); ?>
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