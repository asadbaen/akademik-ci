<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Mapel</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/mapel/saveUpdate" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_mapel" id="id_mapel" value="<?= $mapel['id_mapel']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Nama Mapel</label>
                                <input type="text" id="nama_mapel" name="nama_mapel" class="form-control" placeholder="Nama Mapel" value="<?= $mapel['nama_mapel']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <input type="text" id="kode_mapel" name="kode_mapel" class="form-control" placeholder="Kode Mapel" value="<?= $mapel['kode_mapel']; ?>">
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