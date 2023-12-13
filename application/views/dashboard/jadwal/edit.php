<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Jadwal</h3>
                        <?= $this->session->flashdata('message'); ?>
                        <?php echo validation_errors(); ?>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="<?php echo base_url(); ?>admin/jadwal/saveUpdate" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_jadwal" id="id_jadwal" value="<?= $jadwal['id_jadwal']; ?>">
                        <div class="card-body col-md-6">
                            <div class="form-group">
                                <label>Mapel</label>
                                <select class="custom-select rounded-0" id="mapel_id" name="mapel_id">
                                    <?php foreach ($dataMapel as $value) : ?>
                                        <option value="<?php echo $value['id_mapel']; ?>" <?php if ($value == $jadwal['mapel_id']) echo 'selected'; ?>> <?= $value['kode_mapel']; ?> - <?= $value['nama_mapel']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kode Guru</label>
                                <select class="custom-select rounded-0" id="guru_id" name="guru_id">
                                    <?php foreach ($dataGuru as $value) : ?>
                                        <option value="<?php echo $value['id_guru']; ?>" <?php if ($value == $jadwal['guru_id']) echo 'selected'; ?>><?= $value['nama_guru']; ?> (<?php echo $value['Kode_guru']; ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="custom-select rounded-0" id="kelas_id" name="kelas_id">
                                    <?php foreach ($dataKelas as $value) : ?>
                                        <option value="<?php echo $value['id_kelas']; ?>" <?php if ($value == $jadwal['kelas_id']) echo 'selected'; ?>><?= $value['nama_kelas']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Pilih hari</label>
                                <select name="hari" id="" class="form-control select2" required>
                                    <?php $hari = (object)array("Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"); ?>
                                    <?php foreach ($hari as $value) : ?>
                                        <option value="<?= $value ?>" <?= $value == $jadwal['hari'] ? "selected" : "" ?>><?= $value ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">Awal Jam Mapel</label>
                                        <?php $jama_awal = explode(":", $jadwal["awal"]); ?>
                                        <?php $jama_akir = explode(":", $jadwal["akhir"]); ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="awalj" id="" class="form-control select2" required>
                                                    <option value="">Jam</option>
                                                    <?php for ($i = 5; $i < 18; $i++) : ?>
                                                        <option value="<?= $awal = $i < 10 ? "0" . $i : $i ?>" <?= $awal == $jama_awal[0] ? "selected" : "" ?>>
                                                            Jam <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="akhirm" id="" class="form-control select2" required>
                                                    <option value="">Menit</option>
                                                    <?php for ($i = 0; $i < 60; $i++) : ?>
                                                        <option value="<?= $akhir = $i < 10 ? "0" . $i : $i ?>" <?= $akhir == $jama_awal[1] ? "selected" : "" ?>>
                                                            Menit <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="text-danger">Akhir Jam Mapel</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <select name="awalj2" id="" class="form-control select2" required>
                                                    <option value="">Jam</option>
                                                    <?php for ($i = 5; $i < 18; $i++) : ?>
                                                        <option value="<?= $awal = $i < 10 ? "0" . $i : $i ?>" <?= $awal == $jama_akir[0] ? "selected" : "" ?>>
                                                            Jam <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select name="akhirm2" id="" class="form-control select2" required>
                                                    <option value="">Menit</option>
                                                    <?php for ($i = 0; $i < 60; $i++) : ?>
                                                        <option value="<?= $akhir = $i < 10 ? "0" . $i : $i ?>" <?= $akhir == $jama_akir[1] ? "selected" : "" ?>>
                                                            Menit <?= $i < 10 ? "0" . $i : $i ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tahun Ajaran</label>
                                <div class="input-group">
                                    <input type="hidden" name="tahun" id="tahun" value="<?= $tahun['id_tahun']; ?>">
                                    <input class="form-control" type="text" value="<?= $tahun['nama'] . ' - ' . $tahun['semester'] ?>" readonly>
                                    <?= form_error('tahun', '<small class="text-danger">', '</small>'); ?>
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
    function showYearPicker() {
        var yearInput = document.getElementById("yearInput");
        var currentYear = new Date().getFullYear();

        // Tampilkan input tahun dengan rentang 10 tahun sebelumnya hingga 10 tahun ke depan dari tahun saat ini
        yearInput.setAttribute("min", currentYear - 10);
        yearInput.setAttribute("max", currentYear + 10);

        yearInput.addEventListener("input", function() {
            // Validasi jika Anda ingin mengambil tindakan saat input berubah
            // Misalnya, Anda dapat menambahkan logika untuk menanggapi perubahan tahun di sini
            var selectedYear = yearInput.value;
            console.log("Tahun yang dipilih: " + selectedYear);
        });

        // Fokuskan input tahun
        yearInput.focus();
    }
</script>