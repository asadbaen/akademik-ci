<!-- Main content -->
<section class="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> <i class="fas fa-sticky-note"></i> Laporan Daftar Nilai</h1>
        </div>
        <div class="card">
            <div class="card-header bg-behance">
                <h6 class="text-white">Masukkan Data Yang Diperlukan</h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="thn_ajaran">Tahun Ajaran</label>
                    <select class="form-control" id="thn_ajaran" name="thn_ajaran">
                        <option value="">--Pilih Tahun Ajaran--</option>
                        <?php foreach ($tahun as $th) : ?>
                            <option value="<?php echo $th->id_tahun ?>"><?= $th->nama ?> - Semester <?= $th->semester ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php echo form_error('thn_ajaran', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select class="form-control" id="kelas" name="kelas">
                        <option value="">--Pilih Kelas--</option>
                    </select>
                    <?php echo form_error('kelas', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <div class="form-group">
                    <label for="penilaian">Penilaian</label>
                    <select class="form-control" id="penilaian" name="penilaian">
                        <option value="">--Pilih Penilaian--</option>
                        <option value="PTS">PTS</option>
                        <option value="PAS">PAS</option>
                    </select>
                    <?php echo form_error('penilaian', '<div class="text-danger small ml-3">', '</div>') ?>
                </div>
                <button onclick="lihatLaporanNilai()" class="btn btn-primary"><i class="fas fa-search"></i> Lihat</button>
            </div>
        </div>
        <div id="data-all-nilai"></div>
    </div>
    </main>

    <script>
        function lihatLaporanNilai() {
            const thnAjaran = $('#thn_ajaran').val();
            const kelas = $('#kelas').val();
            const jenisNilai = $('#penilaian').val();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('Laporan_nilai/data_all_nilai') ?>',
                data: {
                    id_tahun: thnAjaran,
                    id_kelas: kelas,
                    nilai: jenisNilai
                },
                success: function(response) {
                    console.log(response);
                    $('#data-all-nilai').html(response);
                },
                error: function(response) {
                    $('#data-all-nilai').html(response);
                }
            });
        }
    </script>

    <!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->