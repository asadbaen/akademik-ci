SELECT tbl_siswa.Nama FROM tbl_siswa JOIN tbl_kelas_siswa on tbl_siswa.Id_siswa = tbl_kelas_siswa.Id_siswa WHERE tbl_kelas_siswa.Id_kelas = 3

<!-- kelas -->
SELECT tbl_kelas.Nama_kelas FROM tbl_kelas JOIN tbl_kelas_siswa ON tbl_kelas.Id_kelas = tbl_kelas_siswa.Id_kelas WHERE tbl_kelas_siswa.Id_kelas = 3;