-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2025 at 07:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `komunikasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `kendala`
--

CREATE TABLE `kendala` (
  `id` int(11) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `waktu_selesai` datetime DEFAULT NULL,
  `sumber` varchar(100) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Belum ditindak',
  `unit` varchar(50) DEFAULT NULL,
  `tanggapan_teknik` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kendala`
--

INSERT INTO `kendala` (`id`, `waktu`, `waktu_selesai`, `sumber`, `pesan`, `status`, `unit`, `tanggapan_teknik`) VALUES
(2, '2025-08-09 13:10:21', NULL, 'ac mati', 'freon basah', 'Ditindak', NULL, 'sudah bisa'),
(3, '2025-08-11 01:23:46', NULL, 'ac mati', 'freon bocor', 'Ditindak', NULL, 'delay'),
(4, '2025-08-11 01:34:23', NULL, 'tolong', 'mewoow', 'Sedang Ditindak', NULL, 'delay'),
(5, '2025-08-14 06:45:55', NULL, 'ac mati', 'gg', 'Sedang Ditindak', NULL, NULL),
(6, '2025-08-14 07:24:42', NULL, 'Server', 'Tidak bisa akses database', 'Belum Ditindak', NULL, NULL),
(7, '2025-08-14 07:24:42', NULL, 'Router', 'Ping ke ISP gagal', 'Sedang Ditindak', NULL, 'Teknik sedang cek jaringan'),
(8, '2025-08-14 07:24:42', NULL, 'Switch', 'Port 3 mati total', 'Pending', NULL, NULL),
(9, '2025-08-14 07:24:42', NULL, 'Firewall', 'Rule tidak terupdate', 'Ditindak', NULL, 'Sudah diperbaiki'),
(10, '2025-08-14 07:30:10', NULL, 'Server', 'Tidak bisa akses database', 'Belum Ditindak', NULL, NULL),
(11, '2025-08-14 07:30:10', NULL, 'Router', 'Ping ke ISP gagal', 'Sedang Ditindak', NULL, 'Teknik sedang cek jaringan'),
(12, '2025-08-14 07:30:10', NULL, 'Switch', 'Port 3 mati total', 'Pending', NULL, NULL),
(13, '2025-08-14 07:30:10', NULL, 'Firewall', 'Rule tidak terupdate', 'Ditindak', NULL, 'Sudah diperbaiki'),
(14, '2025-08-14 10:35:58', NULL, 'tolong ac', 'freyon bocor', 'Sedang Ditindak', NULL, 'ditangani'),
(15, '2025-08-15 04:09:48', NULL, 'ac mati', 'freon', 'Sedang Ditindak', NULL, NULL),
(16, '2025-08-15 08:07:00', NULL, 'kabel putus', 'putus karena kesambel petir', 'Pending', NULL, NULL),
(17, '2025-08-15 08:58:19', NULL, 'wc mampet', 'ada sesuatu', 'Pending', NULL, NULL),
(18, '2025-08-15 09:05:59', NULL, 'ac mati', 'ruangan panas', 'Sedang Ditindak', NULL, NULL),
(19, '2025-08-15 09:58:35', NULL, 'akdakda', 'adkadk', 'Sedang Ditindak', NULL, NULL),
(20, '2025-08-18 04:02:27', NULL, 'ada', 'dada', 'Sedang Ditindak', NULL, NULL),
(21, '2025-08-19 03:14:39', NULL, 'kertas habis', 'kertas ', 'Sedang Ditindak', 'surveillance', NULL),
(22, '2025-08-19 09:07:18', NULL, 'tolongg', 'saya skit', 'Sedang Ditindak', 'listrik', NULL),
(23, '2025-08-20 02:09:48', NULL, 'kabel putus', 'tidak ada tegangan yang menyambung', 'Pending', 'listrik', 'bawa kabel lebih'),
(24, '2025-08-20 02:13:08', NULL, 'kertas', 'kertas habis di ruangan ops', 'Sedang Ditindak', 'rdps', 'oke'),
(25, '2025-08-20 02:13:43', NULL, 'alarm radar PSR', 'Radarnya tidak berfungsi', 'Ditindak', 'surveillance', 'ada'),
(26, '2025-08-20 02:14:25', NULL, 'Alarm GP', 'ada yang kepotong kabelnya', 'Sedang Ditindak', 'navigasi', 'delay'),
(27, '2025-08-20 02:15:33', NULL, 'Radio VHF', 'VSWR terlalu besar', 'Ditindak', 'radkom', 'gg\'s'),
(28, '2025-08-20 02:15:49', NULL, 'Kabel FO ', 'kabel FO putus', 'Ditindak', 'radtel', 'dah selesai bos'),
(29, '2025-08-20 02:16:54', NULL, 'tidak ada data yang diberikan', 'BMKG tidak memberikan data', 'Sedang Ditindak', 'amss', 'apa yang harus dilakukan'),
(30, '2025-08-21 04:07:26', NULL, 'ac mati', 'ruangan panas', 'Pending', 'radtel', 'dadadad'),
(31, '2025-08-21 04:07:45', NULL, 'Radio VHF', 'putus kabelnya', 'Sudah Diperbaiki', 'radkom', 'dadasd'),
(32, '2025-08-21 06:48:07', NULL, 'test', 'ada kerusakan ', 'Laporan Masuk', 'radkom', NULL),
(33, '2025-08-21 08:50:29', NULL, 'testtt', 'cek\r\n', 'Sudah Diperbaiki', 'SRSJ', NULL),
(35, '2025-08-21 14:23:15', NULL, 'testtttt', 'cekkk testtt', 'Dalam Perbaikan', 'Radkom', NULL),
(36, '2025-08-22 13:25:11', NULL, 'testt', 'testtt\r\n', 'Sudah Diperbaiki', 'Radkom', NULL),
(37, '2025-08-22 13:25:28', NULL, 'cekk', 'cekkk\r\n', 'Dalam Perbaikan', 'Radkom', 'amann'),
(38, '2025-08-22 13:29:46', NULL, 'Tx Radio mati', 'di UPLB mati\r\n', 'Sudah Diperbaiki', 'Radkom', 'sudah di tangani radkom'),
(39, '2025-08-22 13:30:06', NULL, 'Jaringan', 'server backup down\r\n', 'Pending', 'Radkom', 'tunggu sparepart'),
(40, '2025-08-22 13:30:30', NULL, 'CWP', 'CWP op room problem\r\n', 'Laporan Masuk', NULL, NULL),
(41, '2025-08-22 13:30:48', NULL, 'amss', 'ATIS tidak update\r\n', 'Laporan Masuk', NULL, NULL),
(42, '2025-08-22 13:31:17', NULL, 'Runway', 'ILS Runway 07R problem', 'Laporan Masuk', NULL, NULL),
(43, '2025-08-22 13:31:34', NULL, 'radar', 'input dari ADS-B mati satu', 'Laporan Masuk', NULL, NULL),
(44, '2025-08-22 13:31:48', NULL, 'UPS', 'UPS di MLAT mati', 'Laporan Masuk', NULL, NULL),
(45, '2025-08-25 02:05:24', NULL, 'test', 'ada gangguan', 'Laporan Masuk', 'Radkom', NULL),
(46, '2025-08-25 02:05:58', NULL, 'test1', 'ada gangguan lagi', 'Sudah Diperbaiki', 'Radkom', 'aman'),
(47, '2025-08-25 02:07:27', NULL, 'test2', 'ada gangguan 2', 'Pending', 'Radkom', NULL),
(48, '2025-08-25 02:18:20', NULL, 'testtt', 'testtt', 'Dalam Perbaikan', 'SRSJ', NULL),
(49, '2025-08-25 02:18:28', NULL, 'cekkk', 'cekkkk', 'Laporan Masuk', 'Radkom', 'aman'),
(50, '2025-08-25 03:03:28', NULL, 'gangguan radio', 'gada balikan di cirebon\r\n', 'Sudah Diperbaiki', 'SRSJ', 'cekKK'),
(51, '2025-08-25 03:05:58', NULL, 'CWP', 'data radar fir barat ilang', 'Pending', 'SRSJ', 'aman'),
(52, '2025-08-25 04:38:21', NULL, 'testt terakhir', 'testt', 'Laporan Masuk', 'SRSJ', NULL),
(53, '2025-08-25 07:21:02', NULL, 'ops room', 'monitor CWP mati', 'Laporan Masuk', 'SRSJ', NULL),
(54, '2025-08-25 08:56:12', NULL, 'tower', 'Gangguan frekuensi pada ground control 2', 'Laporan Masuk', 'Radkom', 'Akan saya tindaklanjuti dengan berkoordinasi dengan cabang Bandung '),
(55, '2025-08-25 09:08:22', NULL, 'tower', 'FREKUENSI GROUND CONTROL 3', 'Pending', 'Radkom', 'masalah sparepart'),
(56, '2025-08-26 01:35:13', NULL, 'testt', 'testtt', 'Laporan Masuk', 'Radkom', 'cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang '),
(57, '2025-08-26 01:35:20', NULL, 'cek 1', 'cek 1', 'Sudah Diperbaiki', 'Radkom', 'cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang '),
(58, '2025-08-26 01:35:29', NULL, 'cekk 2', 'cekk 2', 'Pending', 'SRSJ', 'testtt'),
(59, '2025-08-26 01:35:47', NULL, 'cek panjang', 'cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang ', 'Dalam Perbaikan', 'Radkom', 'cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang cek panjang '),
(60, '2025-08-26 02:18:10', NULL, 'test345', 'cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala cek kendala ', 'Laporan Masuk', 'RDPS', NULL),
(61, '2025-08-26 02:18:23', NULL, 'test123', 'test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 test123 ', 'Laporan Masuk', 'RDPS', NULL),
(65, '2025-08-27 06:39:23', NULL, 'test radkom', 'test radkom', 'Laporan Masuk', NULL, NULL),
(66, '2025-08-27 06:39:55', NULL, 'test radtel', 'test radtel\r\n', 'Laporan Masuk', NULL, NULL),
(67, '2025-08-27 06:40:04', NULL, 'test amss', 'test amss', 'Laporan Masuk', 'AMSS', NULL),
(68, '2025-08-27 06:40:11', NULL, 'test rdps', 'test rdps', 'Laporan Masuk', NULL, NULL),
(69, '2025-08-27 06:40:19', NULL, 'test navigasi', 'test navigasi', 'Laporan Masuk', NULL, NULL),
(70, '2025-08-27 06:40:29', NULL, 'test surveillance', 'test surveillance', 'Laporan Masuk', NULL, NULL),
(71, '2025-08-27 06:40:38', NULL, 'test listrik', 'test listrik', 'Laporan Masuk', NULL, NULL),
(72, '2025-08-27 06:40:49', NULL, 'test bangunan', 'test bangunan', 'Laporan Masuk', 'AMSS', 'cek 123'),
(142, '2025-08-28 06:47:23', NULL, 'Jdkf', 'Mckf', 'Laporan Masuk', 'Surveillance', NULL),
(143, '2025-08-28 06:49:09', NULL, 'Hi', 'Nopal', 'Laporan Masuk', 'SRSJ', NULL),
(144, '2025-08-28 06:50:16', NULL, 'Vidbd', 'Vib', 'Laporan Masuk', 'SRSJ', NULL),
(145, '2025-08-28 06:51:57', NULL, 'Jjn', 'Nn', 'Laporan Masuk', 'Radkom', NULL),
(146, '2025-08-28 06:52:16', NULL, 'Bdbdb', 'Dbdnbc', 'Laporan Masuk', 'Radkom', NULL),
(147, '2025-08-28 06:52:30', NULL, 'Hshsh', 'Nfjfn', 'Laporan Masuk', 'Radkom', NULL),
(148, '2025-08-28 06:59:38', NULL, 'Chxhcuc', 'Fucucu', 'Dalam Perbaikan', NULL, NULL),
(149, '2025-08-28 07:00:08', NULL, 'Fugig', 'Fhdud', 'Sudah Diperbaiki', NULL, 'cek'),
(150, '2025-08-28 07:05:27', NULL, 'J', 'H', 'Laporan Masuk', NULL, NULL),
(153, '2025-08-28 07:13:07', NULL, 'H', 'Y', 'Laporan Masuk', NULL, NULL),
(154, '2025-08-28 07:13:33', NULL, 'Qq', 'Q', 'Laporan Masuk', NULL, NULL),
(155, '2025-08-28 07:13:55', NULL, 'X', 'F', 'Laporan Masuk', NULL, NULL),
(156, '2025-08-28 07:14:13', NULL, 'D', 'F', 'Laporan Masuk', NULL, NULL),
(157, '2025-08-28 07:14:41', NULL, 'N', 'V', 'Laporan Masuk', NULL, NULL),
(158, '2025-08-28 07:15:59', NULL, 'H', 'H', 'Laporan Masuk', NULL, NULL),
(159, '2025-08-28 07:16:23', NULL, 'B', 'Yy', 'Laporan Masuk', NULL, NULL),
(160, '2025-08-28 07:16:36', NULL, 'F', 'F', 'Laporan Masuk', NULL, NULL),
(161, '2025-08-28 07:16:57', NULL, 'Gucu', 'Cuxycy', 'Laporan Masuk', NULL, NULL),
(162, '2025-08-28 07:17:19', NULL, 'Cjc', 'Zhdu', 'Laporan Masuk', NULL, NULL),
(163, '2025-08-28 07:19:15', NULL, 'Nfnfnf', 'Bdbdbd', 'Laporan Masuk', NULL, NULL),
(164, '2025-08-28 07:19:54', NULL, 'G', 'Vv', 'Laporan Masuk', NULL, NULL),
(165, '2025-08-28 07:20:06', NULL, 'G', 'Jjj', 'Laporan Masuk', NULL, NULL),
(166, '2025-08-28 07:20:35', NULL, 'D', 'Ggg', 'Pending', 'Radkom', NULL),
(167, '2025-08-28 07:21:23', NULL, 'Hshb', 'Fbdbcb', 'Laporan Masuk', NULL, NULL),
(168, '2025-08-28 07:24:23', NULL, 'G', 'Ggnnm', 'Dalam Perbaikan', 'SRSJ', NULL),
(169, '2025-08-28 07:24:48', NULL, 'Nfjfn', 'Gnfnfn', 'Laporan Masuk', NULL, NULL),
(170, '2025-08-28 07:26:06', NULL, 'I', 'I', 'Sudah Diperbaiki', NULL, NULL),
(171, '2025-08-28 07:29:54', NULL, 'Hdbdbd', 'Bdbdb', 'Dalam Perbaikan', NULL, NULL),
(172, '2025-08-28 07:36:28', NULL, 'Hdhdbdb', 'Jfjfnfn', 'Sudah Diperbaiki', 'Radkom', NULL),
(173, '2025-08-28 07:38:50', NULL, 'Fjckc', 'Hkvkv', 'Laporan Masuk', 'AMSS', NULL),
(174, '2025-08-28 07:44:22', NULL, 'Gh', 'Bjkl', 'Pending', 'SRSJ', NULL),
(176, '2025-08-28 21:34:31', NULL, 'Cek', 'Cek', 'Dalam Perbaikan', 'Radkom', 'Aman\r\n'),
(177, '2025-08-28 21:34:44', NULL, 'Cek 2', 'Cek 2', 'Laporan Masuk', NULL, NULL),
(178, '2025-08-28 21:35:49', NULL, 'Cek3', 'Cek3', 'Pending', 'Bangunan', NULL),
(179, '2025-08-28 22:17:39', NULL, 'Cek 4', 'Cek 4', 'Dalam Perbaikan', NULL, NULL),
(180, '2025-08-28 22:30:03', NULL, 'Cek3 ', 'Cek4', 'Sudah Diperbaiki', NULL, NULL),
(181, '2025-08-28 22:46:14', NULL, 'Tes', 'Tes', 'Laporan Masuk', NULL, NULL),
(182, '2025-08-28 22:56:41', NULL, 'Testt', 'Testt', 'Laporan Masuk', NULL, 'cekk'),
(183, '2025-08-28 23:18:31', '2025-08-29 14:25:16', 'Hsh', 'JdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcncJdjdjfnfjfncjcncjfnccncknckcnc', 'Sudah Diperbaiki', NULL, NULL),
(184, '2025-08-28 23:49:31', NULL, 'Testt', 'Testt', 'Laporan Masuk', NULL, NULL),
(185, '2025-08-28 23:50:00', NULL, 'Gsh', 'Hshs', 'Laporan Masuk', NULL, NULL),
(186, '2025-08-28 23:51:35', '2025-08-29 14:24:59', 'Test', 'Gesg', 'Sudah Diperbaiki', 'Bangunan', 'asaas'),
(187, '2025-08-28 23:52:25', '2025-08-29 14:03:48', 'Testt', 'G', 'Sudah Diperbaiki', NULL, NULL),
(188, '2025-08-28 23:57:09', NULL, 'Test', 'P', 'Laporan Masuk', 'Radkom', NULL),
(189, '2025-08-28 23:57:53', NULL, 'P', 'P', 'Sudah Diperbaiki', NULL, NULL),
(190, '2025-08-28 23:58:12', NULL, 'P', 'P', 'Pending', 'Radkom', NULL),
(191, '2025-08-29 00:03:53', NULL, 'Cek', 'Cek', 'Sudah Diperbaiki', 'Radkom', NULL),
(192, '2025-08-29 00:08:50', NULL, 'Jej', 'Ebbdsh', 'Sudah Diperbaiki', 'Radkom', NULL),
(193, '2025-08-29 02:02:39', '2025-08-29 14:02:40', 'ac mati', 'ruangan panas', 'Sudah Diperbaiki', 'Bangunan', NULL),
(195, '2025-08-29 05:59:50', '2025-08-29 14:01:57', 'DS JKT ke UPG u/s', 'Mulai dari pukul 08.00 UTC sering gangguan putus nyambung', 'Sudah Diperbaiki', 'Radkom', 'berkoordinasi dengan teknisi lintas arta'),
(196, '2025-08-29 06:57:40', '2025-08-29 14:02:01', 'cekq', 'cekkk\r\n', 'Sudah Diperbaiki', NULL, NULL),
(207, '2025-08-30 05:07:48', NULL, 'test teknik', 'test teknik\r\n', 'Laporan Masuk', NULL, NULL),
(208, '2025-08-30 05:08:08', '2025-08-30 12:12:58', 'test radkom', 'test radkom', 'Sudah Diperbaiki', 'Radkom', NULL),
(209, '2025-08-30 05:08:18', NULL, 'test srsj', 'test srsj', 'Laporan Masuk', 'SRSJ', NULL),
(210, '2025-08-30 05:08:27', NULL, 'test amss', 'test amss', 'Laporan Masuk', 'AMSS', NULL),
(211, '2025-08-30 05:08:36', NULL, 'test rdps', 'test rdps', 'Laporan Masuk', 'RDPS', NULL),
(212, '2025-08-30 05:08:48', NULL, 'test navigasi', 'test navigasi', 'Laporan Masuk', 'Navigasi', NULL),
(213, '2025-08-30 05:09:00', NULL, 'test surveillance', 'test surveillance', 'Laporan Masuk', 'Surveillance', NULL),
(214, '2025-08-30 05:09:17', NULL, 'test listrik', 'test listrik', 'Laporan Masuk', 'Listrik', NULL),
(215, '2025-08-30 05:09:25', NULL, 'test bangunan', 'test bangunan', 'Laporan Masuk', 'Bangunan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'teknik01', 'teknik123', 'teknik'),
(2, 'ops01', 'ops123', 'operasional'),
(18, 'radkom01', 'password123', 'radkom'),
(19, 'radtel01', 'password123', 'radtel'),
(20, 'surveillance01', 'password123', 'surveillance'),
(21, 'navigasi01', 'password123', 'navigasi'),
(22, 'amss01', 'password123', 'amss'),
(23, 'rdps01', 'password123', 'rdps'),
(24, 'listrik01', 'password123', 'listrik'),
(25, 'bangunan01', 'password123', 'bangunan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kendala`
--
ALTER TABLE `kendala`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kendala`
--
ALTER TABLE `kendala`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
