-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2023 at 12:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `akademik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_absensi`
--

CREATE TABLE `tbl_absensi` (
  `absensi_id` int(11) NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `absensi` char(1) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_absensi`
--

INSERT INTO `tbl_absensi` (`absensi_id`, `jadwal_id`, `kelas_id`, `mapel_id`, `siswa_id`, `absensi`, `keterangan`, `created_at`) VALUES
(5, 10, 1, 5, 11, 'A', 'bolos', '2023-12-04 19:30:30'),
(6, 10, 1, 5, 13, 'H', 'hadir', '2023-12-04 19:30:30'),
(7, 2, 2, 1, 8, 'H', 'infone', '2023-12-04 19:38:10'),
(8, 2, 2, 1, 12, 'I', 'izin sakit', '2023-12-04 19:38:10'),
(9, 9, 1, 1, 11, 'A', 'tidak izin', '2023-12-05 02:46:35'),
(10, 9, 1, 1, 13, 'H', 'Hadir', '2023-12-05 02:46:36');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_guru`
--

CREATE TABLE `tbl_guru` (
  `id_guru` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `Jabatan` varchar(20) DEFAULT NULL,
  `nama_guru` varchar(50) DEFAULT NULL,
  `Jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `Tanggal_lahir` date DEFAULT NULL,
  `Tempat_lahir` varchar(50) DEFAULT NULL,
  `Agama` varchar(20) DEFAULT NULL,
  `Kode_guru` varchar(20) DEFAULT NULL,
  `No_telpon` varchar(20) DEFAULT NULL,
  `foto_guru` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_guru`
--

INSERT INTO `tbl_guru` (`id_guru`, `nip`, `Jabatan`, `nama_guru`, `Jenis_kelamin`, `alamat`, `Tanggal_lahir`, `Tempat_lahir`, `Agama`, `Kode_guru`, `No_telpon`, `foto_guru`) VALUES
(3, '13173716327', 'Bundahara', 'Uta Uta', 'P', 'asdad', '2023-10-31', 'asdasd', 'asdada', '213213123', '12313131', '20231104215425_2023_Sat.jpg'),
(4, '21312312', 'Prodi', 'Sinta Aulia', 'P', 'adasd', '2023-11-01', 'asdasda', 'asdad', '12131', '23131', '20231104221525_2023_Sat.jpg'),
(6, '12839283218', 'Guru', 'Lufy Taro', 'L', 'Indonesia', '2023-10-30', 'Indonesia', 'Islam', '082182819', '213131312', '20231117062530_2023_Fri.jpg'),
(7, '1010180', 'Jakarta', 'Mika Tambayong', 'P', 'Indonesia', '2023-11-26', 'Jakarta', 'Islam', '082931391', '090920390193', '20231204173032_2023_Mon.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jadwal_pelajaran`
--

CREATE TABLE `tbl_jadwal_pelajaran` (
  `id_jadwal` int(11) NOT NULL,
  `mapel_id` int(11) DEFAULT NULL,
  `guru_id` int(11) DEFAULT NULL,
  `hari` varchar(20) NOT NULL,
  `kelas_id` int(11) DEFAULT NULL,
  `Tahun_ajaran` varchar(25) DEFAULT NULL,
  `awal` time NOT NULL,
  `akhir` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jadwal_pelajaran`
--

INSERT INTO `tbl_jadwal_pelajaran` (`id_jadwal`, `mapel_id`, `guru_id`, `hari`, `kelas_id`, `Tahun_ajaran`, `awal`, `akhir`) VALUES
(2, 1, 3, 'Senin', 2, '2019', '07:05:00', '10:11:00'),
(8, 1, 3, 'Senin', 1, '2023', '07:07:00', '10:09:00'),
(9, 1, 3, 'Selasa', 1, '2023', '09:09:00', '10:12:00'),
(10, 5, 7, 'Senin', 1, '2019', '12:12:00', '10:10:00'),
(11, 7, 4, 'Sabtu', 2, '2023', '14:11:00', '10:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas`
--

CREATE TABLE `tbl_kelas` (
  `id_kelas` int(11) NOT NULL,
  `Tahun_ajaran` varchar(12) DEFAULT NULL,
  `nama_kelas` varchar(20) DEFAULT NULL,
  `jumlah_siswa` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kelas`
--

INSERT INTO `tbl_kelas` (`id_kelas`, `Tahun_ajaran`, `nama_kelas`, `jumlah_siswa`, `created_at`) VALUES
(1, '2019', 'Kelas 1', '20', '2023-12-05 00:59:09'),
(2, '2019', 'Kelas 2', '20', '2023-12-05 00:59:09'),
(3, '2019', 'kelas 3', '20', '2023-12-05 00:59:09'),
(4, '2019', 'Kelas Praktikum', '12123', '2023-12-05 00:59:09');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kelas_siswa`
--

CREATE TABLE `tbl_kelas_siswa` (
  `id_kelas_siswa` int(11) NOT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `tahun_ajaran` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kelas_siswa`
--

INSERT INTO `tbl_kelas_siswa` (`id_kelas_siswa`, `id_kelas`, `id_siswa`, `tahun_ajaran`, `created_at`) VALUES
(1, 3, 9, '2023/2024', '2023-12-05 00:51:56'),
(2, 2, 8, '2023/2024', '2023-12-05 00:51:56'),
(5, 1, 11, '2023/2024', '2023-12-05 00:51:56'),
(6, 2, 12, '2023/2024', '2023-12-05 00:51:56'),
(7, 1, 13, '2023/2024', '2023-12-05 00:51:56');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kepala_sekolah`
--

CREATE TABLE `tbl_kepala_sekolah` (
  `Id_kepala_sekolah` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `Jabatan` varchar(50) DEFAULT NULL,
  `Nama` varchar(50) DEFAULT NULL,
  `Jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `Tanggal_lahir` date DEFAULT NULL,
  `Tempat_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kepala_sekolah`
--

INSERT INTO `tbl_kepala_sekolah` (`Id_kepala_sekolah`, `nip`, `Jabatan`, `Nama`, `Jenis_kelamin`, `alamat`, `Tanggal_lahir`, `Tempat_lahir`, `agama`, `foto`) VALUES
(1, '00000000', 'Kepala Sekolah', 'Kepala', 'P', 'asdadasda', '2023-10-30', 'asdadadasda', 'sadasda', 'WhatsApp_Image_2023-06-15_at_19_08_252.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_matapelajaran`
--

CREATE TABLE `tbl_matapelajaran` (
  `id_mapel` int(20) NOT NULL,
  `nama_mapel` varchar(50) DEFAULT NULL,
  `kode_mapel` varchar(50) NOT NULL,
  `guru_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_matapelajaran`
--

INSERT INTO `tbl_matapelajaran` (`id_mapel`, `nama_mapel`, `kode_mapel`, `guru_id`) VALUES
(1, 'Ilmu Pengetahuan Alam', 'IPA', 3),
(2, 'Ilmu Pengetahuan Sosial', 'IPS', 3),
(3, 'Bahasa Inggris', 'BING', 3),
(5, 'Rekayasa Perangkat Lunak', 'RPL', 6),
(7, 'Sejarah Kebudayaan Islam', 'SKI', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_presensi`
--

CREATE TABLE `tbl_presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_kelas` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `hadir` tinyint(1) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_presensi`
--

INSERT INTO `tbl_presensi` (`id_presensi`, `id_siswa`, `id_kelas`, `tanggal`, `hadir`, `keterangan`) VALUES
(1, 11, 2, '2023-12-01', 1, 'aasda');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siswa`
--

CREATE TABLE `tbl_siswa` (
  `id_siswa` int(11) NOT NULL,
  `nis` varchar(20) DEFAULT NULL,
  `nik` varchar(20) NOT NULL,
  `nama_siswa` varchar(50) DEFAULT NULL,
  `Jenis_kelamin` enum('L','P') DEFAULT NULL,
  `Tanggal_lahir` date DEFAULT NULL,
  `Tempat_lahir` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `Agama` varchar(20) DEFAULT NULL,
  `No_telpon` varchar(20) DEFAULT NULL,
  `Nama_ayah` varchar(50) DEFAULT NULL,
  `Nama_ibu` varchar(50) DEFAULT NULL,
  `Pekerjaan_ayah` varchar(20) DEFAULT NULL,
  `Pekerjaan_ibu` varchar(20) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_siswa`
--

INSERT INTO `tbl_siswa` (`id_siswa`, `nis`, `nik`, `nama_siswa`, `Jenis_kelamin`, `Tanggal_lahir`, `Tempat_lahir`, `alamat`, `Agama`, `No_telpon`, `Nama_ayah`, `Nama_ibu`, `Pekerjaan_ayah`, `Pekerjaan_ibu`, `foto`, `created_at`) VALUES
(8, '1117101481', '1117101481', 'Indihome', 'L', '2023-10-30', 'Banyuwangi', 'oke jos', 'Islam', '091281921971', 'asdad', 'adsada', 'dasad', 'asdsad', '36d038aed5aaff96943b41469e5dd693.jpg', '2023-12-05 01:00:13'),
(9, '22451617', '12762617', 'Mila', 'P', '2023-11-01', 'asdaa', 'asdad', 'asdad', '131231231', 'asdada', 'asdada', 'adsads', 'adsad', '20231103152913_2023_Fri.jpg', '2023-12-05 01:00:13'),
(11, '11111', '128912388', 'Budiono', 'L', '2023-10-29', 'Surabaya', 'Surabaya', 'Islam', '01923019319', 'Asep', 'Siti', 'aksakkd', 'sakdla', '20231118042755_2023_Sat.jpg', '2023-12-05 01:00:13'),
(12, '17281781', '1862186281', 'sinta maria', 'P', '2023-11-26', 'Jogja', 'asadsad', 'Islam', '211312312', 'adasd', 'adada', 'adasd', 'asdad', '20231201041133_2023_Fri.jpg', '2023-12-05 01:00:13'),
(13, '89898492', '0129019', 'Neko Maru', 'L', '2023-11-28', 'sdadsa', 'asdads', 'asdasd', '3414123', 'adad', 'adasd', 'adad', 'adsa', '20231204181018_2023_Mon.jpg', '2023-12-05 01:00:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tu_admin`
--

CREATE TABLE `tbl_tu_admin` (
  `id_tu_admin` int(11) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `Jabatan` varchar(50) DEFAULT NULL,
  `Nama` varchar(50) DEFAULT NULL,
  `Jenis_kelamin` enum('L','P') DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `Tanggal_lahir` date DEFAULT NULL,
  `Tempat_lahir` varchar(50) DEFAULT NULL,
  `agama` varchar(20) DEFAULT NULL,
  `No_telpon` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `foto` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_tu_admin`
--

INSERT INTO `tbl_tu_admin` (`id_tu_admin`, `nip`, `Jabatan`, `Nama`, `Jenis_kelamin`, `alamat`, `Tanggal_lahir`, `Tempat_lahir`, `agama`, `No_telpon`, `email`, `foto`) VALUES
(1, '11111', 'admin', 'Admin', 'L', 'asdada', '2023-10-29', 'asdada', 'asdadsa', '1312313123', 'admin@gmail.com', '20231114151836_2023_Tue.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kd`
--

CREATE TABLE `tb_kd` (
  `id_kd` int(10) NOT NULL,
  `nama_kd` varchar(15) NOT NULL,
  `jenis_penilaian` enum('PTS','PAS') NOT NULL,
  `id_mapel` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kd`
--

INSERT INTO `tb_kd` (`id_kd`, `nama_kd`, `jenis_penilaian`, `id_mapel`) VALUES
(1, 'KD 3.2', 'PTS', 3),
(2, 'KD 3.2', 'PAS', 5),
(3, 'KD 3.3', 'PTS', 2),
(4, 'KD 3.2', 'PTS', 5),
(5, 'KD 3.1', 'PTS', 7),
(6, 'KD 3.1', 'PAS', 7),
(7, 'KD 3.2', 'PTS', 7),
(8, 'KD 3.2', 'PAS', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` int(10) NOT NULL,
  `jenis` varchar(20) NOT NULL,
  `nilai` float NOT NULL,
  `id_kd` int(10) NOT NULL,
  `id_kelas_siswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_nilai`
--

INSERT INTO `tb_nilai` (`id_nilai`, `jenis`, `nilai`, `id_kd`, `id_kelas_siswa`) VALUES
(1, 'Tugas Harian 1', 50, 4, 2),
(2, 'Tugas Harian 1', 70, 4, 6),
(3, 'Tugas Harian 2', 20, 4, 2),
(4, 'Tugas Harian 2', 30, 4, 6),
(5, 'Tugas Harian 3', 50, 4, 2),
(6, 'Tugas Harian 3', 80, 4, 6),
(9, 'Tugas Harian 1', 50, 1, 2),
(10, 'Tugas Harian 1', 70, 1, 6),
(11, 'Tugas Harian 2', 80, 1, 2),
(12, 'Tugas Harian 2', 90, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengajar`
--

CREATE TABLE `tb_pengajar` (
  `id_pengajar` int(10) NOT NULL,
  `jabatan` enum('Kepala Sekolah','Guru Kelas','Guru Agama','Guru Penjas','Guru Bahasa','TU','Penjaga Sekolah') NOT NULL,
  `id_mapel` int(10) NOT NULL,
  `id_guru` int(10) NOT NULL,
  `id_kelas` int(10) NOT NULL,
  `id_tahun` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_pengajar`
--

INSERT INTO `tb_pengajar` (`id_pengajar`, `jabatan`, `id_mapel`, `id_guru`, `id_kelas`, `id_tahun`) VALUES
(1, 'Guru Kelas', 1, 3, 1, 1),
(2, 'Guru Kelas', 2, 3, 1, 1),
(3, 'Guru Kelas', 3, 4, 2, 1),
(4, 'Guru Kelas', 5, 7, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tahunajaran`
--

CREATE TABLE `tb_tahunajaran` (
  `id_tahun` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `semester` enum('Ganjil','Genap') NOT NULL,
  `shared` enum('0','1') NOT NULL,
  `status` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_tahunajaran`
--

INSERT INTO `tb_tahunajaran` (`id_tahun`, `nama`, `semester`, `shared`, `status`) VALUES
(1, '2023/2024', 'Ganjil', '1', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  ADD PRIMARY KEY (`absensi_id`);

--
-- Indexes for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `tbl_jadwal_pelajaran`
--
ALTER TABLE `tbl_jadwal_pelajaran`
  ADD PRIMARY KEY (`id_jadwal`);

--
-- Indexes for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tbl_kelas_siswa`
--
ALTER TABLE `tbl_kelas_siswa`
  ADD PRIMARY KEY (`id_kelas_siswa`);

--
-- Indexes for table `tbl_kepala_sekolah`
--
ALTER TABLE `tbl_kepala_sekolah`
  ADD PRIMARY KEY (`Id_kepala_sekolah`);

--
-- Indexes for table `tbl_matapelajaran`
--
ALTER TABLE `tbl_matapelajaran`
  ADD PRIMARY KEY (`id_mapel`);

--
-- Indexes for table `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD PRIMARY KEY (`id_presensi`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `tbl_tu_admin`
--
ALTER TABLE `tbl_tu_admin`
  ADD PRIMARY KEY (`id_tu_admin`);

--
-- Indexes for table `tb_kd`
--
ALTER TABLE `tb_kd`
  ADD PRIMARY KEY (`id_kd`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`);

--
-- Indexes for table `tb_pengajar`
--
ALTER TABLE `tb_pengajar`
  ADD PRIMARY KEY (`id_pengajar`);

--
-- Indexes for table `tb_tahunajaran`
--
ALTER TABLE `tb_tahunajaran`
  ADD PRIMARY KEY (`id_tahun`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_absensi`
--
ALTER TABLE `tbl_absensi`
  MODIFY `absensi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_guru`
--
ALTER TABLE `tbl_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_jadwal_pelajaran`
--
ALTER TABLE `tbl_jadwal_pelajaran`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_kelas`
--
ALTER TABLE `tbl_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_kelas_siswa`
--
ALTER TABLE `tbl_kelas_siswa`
  MODIFY `id_kelas_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_kepala_sekolah`
--
ALTER TABLE `tbl_kepala_sekolah`
  MODIFY `Id_kepala_sekolah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_matapelajaran`
--
ALTER TABLE `tbl_matapelajaran`
  MODIFY `id_mapel` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_siswa`
--
ALTER TABLE `tbl_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_tu_admin`
--
ALTER TABLE `tbl_tu_admin`
  MODIFY `id_tu_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kd`
--
ALTER TABLE `tb_kd`
  MODIFY `id_kd` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `id_nilai` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_pengajar`
--
ALTER TABLE `tb_pengajar`
  MODIFY `id_pengajar` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_tahunajaran`
--
ALTER TABLE `tb_tahunajaran`
  MODIFY `id_tahun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_kelas_siswa`
--
ALTER TABLE `tbl_kelas_siswa`
  ADD CONSTRAINT `tbl_kelas_siswa_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`Id_kelas`),
  ADD CONSTRAINT `tbl_kelas_siswa_ibfk_2` FOREIGN KEY (`Id_siswa`) REFERENCES `tbl_siswa` (`id_siswa`);

--
-- Constraints for table `tbl_presensi`
--
ALTER TABLE `tbl_presensi`
  ADD CONSTRAINT `tbl_presensi_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tbl_siswa` (`id_siswa`),
  ADD CONSTRAINT `tbl_presensi_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tbl_kelas` (`Id_kelas`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
