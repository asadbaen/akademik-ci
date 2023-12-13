<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table>
                            <tbody>
                                <tr>
                                    <td>Kode/Kelas</td>
                                    <td>: <?= isset($contents['absensi']) ? $contents['absensi']->nama_kelas : ' ' ?></td>
                                </tr>

                                <tr>
                                    <td>Kode/Mapel</td>
                                    <td>: <?= isset($contents['absensi']->kode_mapel) ? $contents['absensi']->kode_mapel : ' ' ?>/<?= isset($contents['absensi']->nama_mapel) ? $contents['absensi']->nama_mapel : " " ?></td>
                                </tr>
                                <tr>
                                    <td>Jam Mapel</td>
                                    <td>: <?= date("H:i", strtotime(isset($contents['absensi']->awal) ? $contents['absensi']->awal : "")) ?>
                                        - <?= date("H:i", strtotime(isset($contents['absensi']->akhir) ? $contents['absensi']->akhir : "")) ?></td>
                                </tr>
                                <tr>
                                    <td>Guru Pengampu</td>
                                    <td>: <?= $contents['absensi']->nama_guru ?> (<?= $contents['absensi']->No_telpon ?>)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <form action="<?= isset($contents['edit']) ? base_url("admin/absensi/save_absensi") : base_url("admin/absensi/update_absensi") ?>" method="post">
                    <input type="hidden" name="kelas_id" value="<?= $contents['absensi']->kelas_id ?>">
                    <input type="hidden" name="mapel_id" value="<?= $contents['absensi']->mapel_id ?>">
                    <input type="hidden" name="mapel" value="<?= $contents['absensi']->nama_mapel ?>">
                    <input type="hidden" name="jadwal_id" value="<?= $contents['absensi']->id_jadwal ?>">
                    <div class="card">
                        <div class="card-header">
                            Form Absensi Hari ini : <b><?= getDay(date("l")) ?>, <?= date("d-M-Y") ?></b>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-hover">
                                <thead class="bg-purple">
                                    <tr>
                                        <th>#</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>L/P</th>
                                        <th>Keterangan</th>
                                        <th>Absensi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contents['detail_absensi'] as $key => $value) : ?>
                                        <tr>
                                            <td><?= ($key + 1) ?></td>
                                            <td><?= $value->nis ?></td>
                                            <td><?= $value->nama_siswa ?></td>
                                            <td><?= $value->Jenis_kelamin ?></td>
                                            <td>
                                                <?php if (isset($value->keterangan)) : ?>
                                                    <input class="form-control" type="text" name="keterangan[]" value="<?= $value->keterangan ?>" required>
                                                <?php else : ?>
                                                    <input class="form-control" type="text" name="keterangan[]" value="Hadir" placeholder="keterangan">
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (isset($value->absensi_id)) : ?>
                                                    <input type="hidden" name="absensi_id[]" value="<?= $value->absensi_id ?>" required>
                                                <?php endif; ?>
                                                <input type="hidden" name="siswa_id[]" value="<?= $value->id_siswa ?>" required>
                                                <?php $checked = isset($value->absensi) ? $value->absensi : "" ?>
                                                <select name="absensi[]" class="form-control">
                                                    <option value="H" <?= $checked == "H" ? "selected" : "" ?>>Hadir</option>
                                                    <option value="I" <?= $checked == "I" ? "selected" : "" ?>>Izin</option>
                                                    <option value="A" <?= $checked == "A" ? "selected" : "" ?>>Alpa</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <button type="reset" class="btn btn-danger">Reset</button>
                            <button type="submit" name="simpan" value="simpan" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>