<footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 3.1.0
    </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js') ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

<!-- daterangepicker -->
<script src="<?php echo base_url('assets/plugins/moment/moment.min.js') ?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Summernote -->
<script src="<?php echo base_url('assets/plugins/summernote/summernote-bs4.min.js') ?>"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
<!-- data tables -->
<!-- DataTables  & Plugins -->
<script src="<?= base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/dist/js/adminlte.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/dist/js/demo.js') ?>"></script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "paging": true,
        });
    });
</script>
<script>
    $(function() {
        $('#reservationdate').datetimepicker({
            format: 'YYYY',
            viewMode: 'years',
            minDate: new Date('2003-01-01'), // Opsi ini untuk membatasi pemilihan tahun hanya ke tahun saat ini dan setelahnya
        });
    });
</script>
<script>
    $(function() {
        $('#kelas').change(function() {
            const kelas = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('admin/nilai/get_mapel') ?>',
                data: 'id_kelas=' + kelas,
                success: function(response) {
                    console.log(response);
                    $('#mapel').html(response);
                }
            });
        })
    });
</script>
<script>
    function searchNilai() {
        const idKelas = $('#kelas').val()
        const idMapel = $('#mapel').val()
        const penilaian = $('#penilaian').val()

        console.log(idKelas + '-' + idMapel + '-' + penilaian);

        // if (idKelas !== '' && idMapel !== '') {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('admin/nilai/data_nilai_permapel') ?>',
            data: {
                id_kelas: idKelas,
                id_mapel: idMapel,
                nilai: penilaian
            },
            success: function(response) {
                $('#table-result').html(response);
            },
            error: function(response) {
                $('#table-result').html(response);
            }
        });
        // }
    }
</script>

<script>
    $(function() {
        $('#thn_ajaran').change(function() {
            const tahun = $(this).val();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('admin/laporan_nilai/get_kelas') ?>',
                data: {
                    id_tahun: tahun,
                },
                success: function(response) {
                    $('#kelas').html(response);
                }
            });
        })
    });
</script>
<script>
    $(document).ready(function() {
        $(".add-kd").click(function() {
            var html = $(".kd-copy").html();
            $(".after-add-kd").after(html);
        });
        $("body").on("click", ".remove-kd", function() {
            $(this).parents(".control-group").remove();
        });
    });
</script>
<script>
    //onclick hapus data tahun
    function confirmDelete(id) {
        const href = '<?= site_url('admin/tahun_ajaran/delete/') ?>' + id;

        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "data tahun ajaran akan dihapus",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Hapus Data',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = href;
            }
        });
    }

    //datatables
    $(document).ready(function() {
        $('#table-tahun').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "<?= site_url('admin/tahun_ajaran/get_result_tahun') ?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": [0, -1, -2],
                    "className": 'text-center'
                },
                {
                    "targets": [-1],
                    "orderable": false
                }
            ]
        });
    });
</script>

<!-- guru/nilai -->
<script>
    $(document).ready(function() {
        $('#g-kelas').change(function() {
            const idkelas = $(this).val();
            const idGuru = '<?= $id_guru ?>';
            $.ajax({
                type: 'POST',
                url: '<?= base_url('guru/nilai/get_mapel') ?>',
                data: {
                    id_kelas: idkelas,
                    id_guru: idGuru
                },
                success: function(response) {
                    $('#g-mapel').html(response);
                }
            });
        })
    });

    function guruSearchNilai() {
        const idKelas = $('#g-kelas').val()
        const idMapel = $('#g-mapel').val()
        const idGuru = '<?= $id_guru ?>';
        const penilaian = $('#g-penilaian').val()

        // if (idKelas !== '' && idMapel !== '') {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('guru/nilai/data_nilai_permapel') ?>',
            data: {
                id_kelas: idKelas,
                id_mapel: idMapel,
                nilai: penilaian
            },
            success: function(response) {
                $('#table-result').html(response);
            },
            error: function(response) {
                $('#table-result').html(response);
            }
        });
        // }
    }
</script>

<script>
    $(document).ready(function() {
        $('#g-thn_ajaran').change(function() {
            const tahun = $(this).val();
            const guru = '<?= $id_guru ?>';
            $.ajax({
                type: 'POST',
                url: '<?= base_url('guru/laporannilai/get_kelas') ?>',
                data: {
                    id_tahun: tahun,
                    id_guru: guru
                },
                success: function(response) {
                    $('#g-kelas').html(response);
                }
            });
        })
    });
</script>
</body>


</html>