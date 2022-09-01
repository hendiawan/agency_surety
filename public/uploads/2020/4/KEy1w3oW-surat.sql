-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2020 at 08:59 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `surat`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `cari_surat_masuk`
-- (See below for the actual view)
--
CREATE TABLE `cari_surat_masuk` (
`id` int(11)
,`nomor_surat` varchar(40)
,`tgl_terima` date
,`tgl_surat` date
,`prihal` varchar(50)
,`pengirim` varchar(40)
,`Tujuan_Surat` varchar(30)
,`Petugas` varchar(30)
,`catatan` text
,`tgl_server` datetime
);

-- --------------------------------------------------------

--
-- Table structure for table `m_devisi`
--

CREATE TABLE `m_devisi` (
  `id` int(11) NOT NULL,
  `kode_devisi` varchar(10) NOT NULL,
  `nama_devisi` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_devisi`
--

INSERT INTO `m_devisi` (`id`, `kode_devisi`, `nama_devisi`) VALUES
(1, 'Dev001', 'PIMPINAN'),
(2, 'Dev002', 'PANITERA'),
(3, 'Dev003', 'PLH SEKRETARIS/PANITERA'),
(4, 'Dev004', 'KASUBAG UMUM & KEUANGAN'),
(5, 'Dev005', 'KASUBAG KEPEGAWAIAN DAN ORTALA'),
(6, 'Dev006', 'KASUBAG TU DAN PELAPORAN'),
(8, 'Dev007', 'PANITERA MUDA PERKARA'),
(9, 'Dev008', 'PANITERA MUDA HUKUM');

-- --------------------------------------------------------

--
-- Table structure for table `m_pegawai`
--

CREATE TABLE `m_pegawai` (
  `id` int(11) NOT NULL,
  `kode_pegawai` varchar(10) NOT NULL,
  `nama_pegawai` varchar(30) NOT NULL,
  `jabatan` varchar(15) NOT NULL,
  `kode_devisi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_pegawai`
--

INSERT INTO `m_pegawai` (`id`, `kode_pegawai`, `nama_pegawai`, `jabatan`, `kode_devisi`) VALUES
(1, 'PEG001', 'LALU HENDIAWAN DIPA', 'PENGAWAS', 'Dev001'),
(2, 'PEG002', 'DEWI WULANDARI', 'PENGAWAS', 'Dev003'),
(4, 'PEG003', 'RISKA ANDELA GUNTARI', 'CEO', 'Dev002');

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE `m_user` (
  `id` int(11) NOT NULL,
  `kode_user` varchar(10) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(150) NOT NULL,
  `kode_pegawai` varchar(10) NOT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`id`, `kode_user`, `username`, `password`, `kode_pegawai`, `level`) VALUES
(1, 'USR-1', 'hendiawan', '21232f297a57a5a743894a0e4a801fc3', 'PEG001', 'Admin'),
(2, 'USR-2', 'dewi', 'ed1d859c50262701d92e5cbf39652792', 'PEG002', 'Admin'),
(3, 'Usr-3', 'dela', '4e4a3b45c22f1be8f65067b617722ad6', 'PEG003', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `t_surat_keluar`
--

CREATE TABLE `t_surat_keluar` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(40) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `tgl_surat` date NOT NULL,
  `tujuan` varchar(40) NOT NULL,
  `prihal` text NOT NULL,
  `kode_pegawai` varchar(10) NOT NULL,
  `kode_user` varchar(10) NOT NULL,
  `catatan` text NOT NULL,
  `tgl_server` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_surat_keluar`
--

INSERT INTO `t_surat_keluar` (`id`, `nomor_surat`, `tgl_kirim`, `tgl_surat`, `tujuan`, `prihal`, `kode_pegawai`, `kode_user`, `catatan`, `tgl_server`) VALUES
(1, '001/jnb/ii/2020', '2020-02-21', '2020-02-22', 'PD. BPR NTB Lotim', 'Pengumuman		', 'PEG002', 'USR-1', 'tolong di proses', '2020-02-22 00:00:00'),
(2, '001/jnb/ii/2021', '2020-02-22', '2020-02-22', 'PD. BPR NTB Sumbawa Barat', 'Pengumuman	', 'PEG001', 'USR-1', 'tolong di proses', '2020-02-22 00:00:00'),
(3, '0210021001', '2020-03-13', '2020-03-28', 'dinar perindustrian', 'mohon bantuan hukum', 'PEG002', 'USR-1', 'tolong diproeses', '2020-03-12 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `t_surat_masuk`
--

CREATE TABLE `t_surat_masuk` (
  `id` int(11) NOT NULL,
  `nomor_surat` varchar(40) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_surat` date NOT NULL,
  `prihal` varchar(50) NOT NULL,
  `pengirim` varchar(40) NOT NULL,
  `kode_pegawai` varchar(10) NOT NULL,
  `kode_user` varchar(10) NOT NULL,
  `catatan` text NOT NULL,
  `tgl_server` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `t_surat_masuk`
--

INSERT INTO `t_surat_masuk` (`id`, `nomor_surat`, `tgl_terima`, `tgl_surat`, `prihal`, `pengirim`, `kode_pegawai`, `kode_user`, `catatan`, `tgl_server`) VALUES
(6, '01/JNB/II/2020', '2020-02-22', '2020-04-16', 'PERMOHONAN KEIKUTSERTAAN LELANG', 'Dinas Perindustrian Dan Perdagangan', 'PEG002', 'USR-1', 'Deadline tanggal 15 Oktober 2020', '2020-02-22 00:00:00'),
(7, '9210992129', '2020-03-22', '2020-03-22', 'PELAPORAN KASUS PENGGELAPAN MOBIL', 'DINAS PETERNAKAN', 'PEG001', 'USR-1', 'MOHON UNTUK SEGERA DI PROSES', '2020-03-22 00:00:00');

-- --------------------------------------------------------

--
-- Structure for view `cari_surat_masuk`
--
DROP TABLE IF EXISTS `cari_surat_masuk`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `cari_surat_masuk`  AS  select `masuk`.`id` AS `id`,`masuk`.`nomor_surat` AS `nomor_surat`,`masuk`.`tgl_terima` AS `tgl_terima`,`masuk`.`tgl_surat` AS `tgl_surat`,`masuk`.`prihal` AS `prihal`,`masuk`.`pengirim` AS `pengirim`,`tujuan`.`nama_pegawai` AS `Tujuan_Surat`,`petugas`.`nama_pegawai` AS `Petugas`,`masuk`.`catatan` AS `catatan`,`masuk`.`tgl_server` AS `tgl_server` from (((`t_surat_masuk` `masuk` join `m_pegawai` `tujuan` on((`tujuan`.`kode_pegawai` = `masuk`.`kode_pegawai`))) join `m_user` `u` on((`u`.`kode_user` = `masuk`.`kode_user`))) join `m_pegawai` `petugas` on((`petugas`.`kode_pegawai` = `u`.`kode_pegawai`))) where ((`petugas`.`nama_pegawai` like '%menghen%') or (`masuk`.`nomor_surat` like '%menghen%') or (`masuk`.`prihal` like '%menghen%') or (`masuk`.`pengirim` like '%menghen%') or (`masuk`.`catatan` like '%menghen%') or (`masuk`.`tgl_terima` like '%menghen%') or (`masuk`.`tgl_surat` like '%menghen%')) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `m_devisi`
--
ALTER TABLE `m_devisi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_pegawai`
--
ALTER TABLE `m_pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_surat_keluar`
--
ALTER TABLE `t_surat_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `t_surat_masuk`
--
ALTER TABLE `t_surat_masuk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `m_devisi`
--
ALTER TABLE `m_devisi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `m_pegawai`
--
ALTER TABLE `m_pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_surat_keluar`
--
ALTER TABLE `t_surat_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `t_surat_masuk`
--
ALTER TABLE `t_surat_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
