-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 30, 2020 at 02:32 PM
-- Server version: 10.2.30-MariaDB
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u5119056_hcd`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensis`
--

CREATE TABLE `absensis` (
  `id` int(11) NOT NULL,
  `pin` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `masuk` time NOT NULL,
  `istirahat` time NOT NULL,
  `kembali` time NOT NULL,
  `pulang` time NOT NULL,
  `telat` int(11) NOT NULL,
  `telatkembali` int(11) NOT NULL,
  `pulangcepat` int(11) NOT NULL,
  `istirahatcepat` int(16) NOT NULL,
  `kehadiran` varchar(15) NOT NULL,
  `keterangan` varchar(70) NOT NULL,
  `pengecualian` varchar(50) NOT NULL,
  `tugas` text NOT NULL,
  `hasil` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `absensis`
--

INSERT INTO `absensis` (`id`, `pin`, `tgl`, `masuk`, `istirahat`, `kembali`, `pulang`, `telat`, `telatkembali`, `pulangcepat`, `istirahatcepat`, `kehadiran`, `keterangan`, `pengecualian`, `tugas`, `hasil`) VALUES
(7033, 9, '2020-03-30', '09:24:38', '00:00:00', '00:00:00', '14:05:32', 24, 0, 174, 0, '1', '', '', '', ''),
(7032, 7, '2020-03-30', '09:02:13', '00:00:00', '13:58:51', '14:01:13', 2, 28, 178, 0, '1', '', '', 'Masuk pagi tadi jam 6.30 am', ''),
(7031, 10, '2020-03-30', '08:44:19', '00:00:00', '00:00:00', '14:02:17', 0, 0, 177, 0, '1', '', '', 'Senin 30 maret 2020,masuk', ''),
(7030, 6, '2020-03-30', '08:47:48', '00:00:00', '14:12:26', '14:11:06', 0, 42, 168, 0, '1', '', '', 'Meng input dan meng jurnal kas harian hari ini', ''),
(7029, 5, '2020-03-30', '08:17:59', '00:00:00', '00:00:00', '14:08:30', 0, 0, 171, 0, '1', '', '', '- mengecek kas awal dan tutup kas secara online dari staf keuangan\r\n- mengecek neraca harian sebelum tutup kas', '- kas kecil telah d cek bserta nota dan penjurnalan sbelum d input k sistem\r\n- melakukan prencanaan penggunaan biaya'),
(7028, 8, '2020-03-30', '07:25:55', '00:00:00', '00:00:00', '14:02:00', 0, 0, 178, 0, '1', '', '', 'Standbay dirumah tnggu panggilan dari kantor', ''),
(7027, 16, '2020-03-30', '07:13:14', '00:00:00', '14:06:36', '14:17:44', 0, 36, 162, 0, '1', '', '', 'Proses penjaminan di website ', ''),
(7026, 3, '2020-03-30', '07:09:07', '00:00:00', '00:00:00', '14:04:15', 0, 0, 175, 0, '1', '', '', 'Kerja kantor, menyusun sop yg belum selesai', ''),
(7025, 11, '2020-03-30', '07:08:41', '00:00:00', '00:00:00', '14:17:40', 0, 0, 162, 0, '1', '', '', '- proses penjaminan\r\n-testing website penjaminan yg di update sama kabag IT', ''),
(7024, 8, '2020-03-30', '07:01:09', '00:00:00', '00:00:00', '14:02:00', 0, 0, 178, 0, '1', '', '', '', ''),
(7023, 1, '2020-03-30', '06:52:05', '00:00:00', '00:00:00', '14:30:48', 0, 0, 149, 0, '1', '', '', 'Update fitur aplikasi penjaminan terutama terkait case by case', 'Telah melakukan Analisis aplikasi terkait update fitur yang berkaitan dengan case by case.'),
(7022, 4, '2020-03-30', '06:36:57', '00:00:00', '00:00:00', '14:06:38', 0, 0, 173, 0, '1', '', '', 'melakukan pekerjaan SDM dan mendraft SK-SK', ''),
(6997, 4, '2020-03-23', '08:11:37', '12:00:00', '13:30:00', '17:00:50', 0, 0, 0, 0, '1', '', '', '0', ''),
(6996, 4, '2020-03-20', '07:52:41', '12:00:00', '13:45:00', '17:00:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6995, 4, '2020-03-19', '07:57:26', '12:03:00', '13:01:00', '17:04:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6994, 4, '2020-03-18', '07:57:38', '12:03:44', '13:25:50', '17:18:01', 0, 0, 0, 0, '1', '', '', '0', ''),
(6993, 10, '2020-03-23', '07:13:42', '12:05:00', '13:10:00', '17:03:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6992, 10, '2020-03-20', '07:15:54', '12:01:07', '13:20:16', '17:05:25', 0, 0, 0, 0, '1', '', '', '0', ''),
(6991, 10, '2020-03-19', '07:20:45', '12:03:00', '13:04:00', '17:03:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6990, 10, '2020-03-18', '07:10:56', '12:03:03', '13:01:09', '17:03:17', 0, 0, 0, 0, '1', '', '', '0', ''),
(6989, 11, '2020-03-23', '07:05:42', '12:05:00', '13:20:00', '17:02:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6988, 11, '2020-03-20', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, '0', 'SAKIT', '', '0', ''),
(6987, 11, '2020-03-18', '00:00:00', '00:00:00', '00:00:00', '00:00:00', 0, 0, 0, 0, '0', 'SAKIT', '', '0', ''),
(6986, 16, '2020-03-23', '07:59:34', '12:05:00', '13:20:00', '17:03:00', 0, 0, 0, 0, '1', '', '', '0', ''),
(6985, 16, '2020-03-20', '07:59:35', '12:02:00', '13:50:00', '17:01:00', 0, 0, 0, 0, '1', '', '', '0', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7034;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
