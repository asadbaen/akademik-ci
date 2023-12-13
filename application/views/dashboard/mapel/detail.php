<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Detail Siswa</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form>
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Nama Mapel</label>
                                <input type="text" class="form-control" value="<?= $mapel['nama_mapel']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Kode Mapel</label>
                                <input type="text" class="form-control" value="<?= $mapel['kode_mapel']; ?>" readonly>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        <!-- <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div> -->
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