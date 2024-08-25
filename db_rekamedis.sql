-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2024 at 07:35 AM
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
-- Database: `db_rekamedis`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_obat`
--

CREATE TABLE `tbl_obat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kegunaan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_obat`
--

INSERT INTO `tbl_obat` (`id`, `nama`, `kegunaan`) VALUES
(6, 'panadol', 'penurun panas'),
(7, 'sanmol forte', 'penurun panas, pereda  nyeri'),
(9, 'Ibuprofen', 'meredakan nyeri, mengurangi peradangan, dan menurunkan demam'),
(10, 'Amoxicillin', 'Antibiotik yang digunakan untuk mengobati berbagai infeksi bakteri'),
(11, 'Aspirin', 'Mengurangi rasa sakit, peradangan, dan demam'),
(12, 'antasida', 'sakit kepala');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pasien`
--

CREATE TABLE `tbl_pasien` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `gender` enum('P','W') NOT NULL,
  `telpon` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pasien`
--

INSERT INTO `tbl_pasien` (`id`, `nama`, `tgl_lahir`, `gender`, `telpon`, `alamat`) VALUES
('240807061356', 'sartika', '2001-09-23', 'W', '081355107844', 'laimu'),
('240819011217', 'calo', '2003-03-03', 'P', '081231456798', 'pelauw');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekamedis`
--

CREATE TABLE `tbl_rekamedis` (
  `no_rm` varchar(15) NOT NULL,
  `tgl_rm` date NOT NULL,
  `id_pasien` varchar(20) NOT NULL,
  `keluhan` text NOT NULL,
  `id_dokter` int(11) NOT NULL,
  `diagnosa` text NOT NULL,
  `obat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_rekamedis`
--

INSERT INTO `tbl_rekamedis` (`no_rm`, `tgl_rm`, `id_pasien`, `keluhan`, `id_dokter`, `diagnosa`, `obat`) VALUES
('RM-001-190824', '2024-08-19', '240819011217', 'sakit gigi', 1, 'di cunglil', 'Amoxicillin'),
('RM-002-150824', '2024-08-15', '240807061356', 'pusing', 1, 'masuk angin', 'sanmol forte, panadol');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `userid` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `jabatan` enum('1','2','3') NOT NULL COMMENT '1=administrator, 2=petugas, 3=dokter',
  `alamat` varchar(100) NOT NULL,
  `gambar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`userid`, `username`, `fullname`, `password`, `jabatan`, `alamat`, `gambar`) VALUES
(1, 'Eva', 'dr.Evalone V.Pattileamonia', '$2y$10$jZu9VBOu7x9VD6iqEOq8xuk.L.hyIVGQi2VqEZ7Dd3lIFd3GEFFOu', '3', 'ambon', '1722943684-dokter2.jpg'),
(7, 'putri', 'putri indah sari hatapayo, S.Kep', '$2y$10$J5nJT7UKDoahEFR2TO9Te.X769aDn/u5o/zxgCVa4JmmknBa6asHC', '1', 'Ambon', 'user.jpg'),
(10, 'Ika', 'Kartika Nahumury, Amd.Kep', '$2y$10$48ynxyI2IvQufLFuF5/vA.ceZP7cxIeHyMoDtvrUEnwye2/EJu9s6', '2', 'Halong', 'user.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pasien`
--
ALTER TABLE `tbl_pasien`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_rekamedis`
--
ALTER TABLE `tbl_rekamedis`
  ADD PRIMARY KEY (`no_rm`),
  ADD KEY `id_pasien` (`id_pasien`),
  ADD KEY `id_dokter` (`id_dokter`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_obat`
--
ALTER TABLE `tbl_obat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_rekamedis`
--
ALTER TABLE `tbl_rekamedis`
  ADD CONSTRAINT `tbl_rekamedis_ibfk_1` FOREIGN KEY (`id_pasien`) REFERENCES `tbl_pasien` (`id`),
  ADD CONSTRAINT `tbl_rekamedis_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `tbl_user` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
