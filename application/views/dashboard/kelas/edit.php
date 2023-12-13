<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit kelas</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/kelas/saveUpdate" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_kelas" id="id_kelas" value="<?= $kelas['id_kelas']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" id="nama_kelas" name="nama_kelas" class="form-control" placeholder="isi kelas" value="<?= $kelas['nama_kelas']; ?>">
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