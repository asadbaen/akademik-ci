<div class="container-fluid">
    <!-- Page Heading -->
    <?php $button = ($tahun) ? 'enabled' : 'disabled'; ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-sort-numeric-down"></i> Data Nilai <?= $thn = ($tahun) ? '(Tahun Ajaran ' . $tahun['nama'] . ')' : '(Tidak Ada Tahun Ajaran Yang Aktif)';  ?></h1>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-header bg-behance">
                    <h6 class="text-white">Masukkan Data Yang Diperlukan</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="g-kelas">Kelas</label>
                        <select class="form-control" id="g-kelas" name="kelas">
                            <option value="">--Pilih Kelas--</option>
                            <?php foreach ($pengampu as $kl) : ?>
                                <option value="<?php echo $kl->id_kelas ?>"><?= $kl->nama_kelas ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php echo form_error('kelas', '<div class="text-danger small ml-3">', '</div>') ?>
                    </div>
                    <div class="form-group">
                        <label for="g-mapel">Mata Pelajaran</label>
                        <select class="form-control" id="g-mapel" name="mapel">
                            <option value="">--Pilih Mata Pelajaran--</option>
                        </select>
                        <?php echo form_error('mapel', '<div class="text-danger small ml-3">', '</div>') ?>
                    </div>
                    <div class="form-group">
                        <label for="penilaian">Penilaian</label>
                        <select class="form-control" id="g-penilaian" name="penilaian">
                            <option value="">--Pilih Penilaian--</option>
                            <option value="PTS">PTS</option>
                            <option value="PAS">PAS</option>
                        </select>
                        <?php echo form_error('penilaian', '<div class="text-danger small ml-3">', '</div>') ?>
                    </div>
                    <button onclick="guruSearchNilai()" class="btn btn-primary" <?= $button ?>><i class="fas fa-search"></i> Cari</button>
                </div>
            </div>
        </div>
        <div class="col-sm-9" id="table-result">

        </div>
    </div>
</div>
</main>