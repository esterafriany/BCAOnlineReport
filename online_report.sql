-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2016 at 11:41 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `online_report`
--

-- --------------------------------------------------------

--
-- Table structure for table `or_angkatan`
--

CREATE TABLE IF NOT EXISTS `or_angkatan` (
  `id` int(11) NOT NULL,
  `nama_angkatan` int(11) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_detail_nilai_ujian_lisan`
--

CREATE TABLE IF NOT EXISTS `or_detail_nilai_ujian_lisan` (
  `id` int(11) NOT NULL,
  `nilai_ujian_id` int(11) NOT NULL,
  `penilaian_program_id` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_nilai_ujian_lisan`
--

CREATE TABLE IF NOT EXISTS `or_nilai_ujian_lisan` (
  `id` int(11) NOT NULL,
  `nip_penguji` int(11) NOT NULL,
  `nama_penguji` int(11) NOT NULL,
  `divisi_penguji` int(11) NOT NULL,
  `total_nilai` int(11) NOT NULL,
  `komentar` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_penilaian_program`
--

CREATE TABLE IF NOT EXISTS `or_penilaian_program` (
`id` int(11) NOT NULL,
  `kriteria_penilaian` varchar(200) NOT NULL,
  `komposisi_nilai` varchar(11) NOT NULL,
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `or_penilaian_program`
--

INSERT INTO `or_penilaian_program` (`id`, `kriteria_penilaian`, `komposisi_nilai`, `program_id`) VALUES
(1, 'Teknik Presentasi', '20%', 1),
(2, 'Penguasaan Materi', '25%', 1);

-- --------------------------------------------------------

--
-- Table structure for table `or_peserta`
--

CREATE TABLE IF NOT EXISTS `or_peserta` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `divisi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_program`
--

CREATE TABLE IF NOT EXISTS `or_program` (
`id` int(11) NOT NULL,
  `nama_program` varchar(200) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `or_program`
--

INSERT INTO `or_program` (`id`, `nama_program`) VALUES
(1, 'P2M Muda 1'),
(2, 'P2M Muda 2'),
(3, 'PFL CS dan Teller'),
(4, 'PSPO'),
(5, 'Program Muda 2'),
(7, 'Program Muda 4'),
(8, 'Program Muda 5');

-- --------------------------------------------------------

--
-- Table structure for table `or_ujian_lisan`
--

CREATE TABLE IF NOT EXISTS `or_ujian_lisan` (
  `id` int(11) NOT NULL,
  `program_id` int(11) NOT NULL,
  `kode_unik` varchar(10) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_ujian_tulis`
--

CREATE TABLE IF NOT EXISTS `or_ujian_tulis` (
  `id` int(11) NOT NULL,
  `id_peserta` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `or_user`
--

CREATE TABLE IF NOT EXISTS `or_user` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `or_user`
--

INSERT INTO `or_user` (`id`, `username`, `password`, `role`) VALUES
(1, 'penguji', '81dc9bdb52d04dc20036dbd8313ed055', 1),
(2, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `or_angkatan`
--
ALTER TABLE `or_angkatan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_detail_nilai_ujian_lisan`
--
ALTER TABLE `or_detail_nilai_ujian_lisan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_nilai_ujian_lisan`
--
ALTER TABLE `or_nilai_ujian_lisan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_penilaian_program`
--
ALTER TABLE `or_penilaian_program`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_peserta`
--
ALTER TABLE `or_peserta`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_program`
--
ALTER TABLE `or_program`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_ujian_lisan`
--
ALTER TABLE `or_ujian_lisan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_ujian_tulis`
--
ALTER TABLE `or_ujian_tulis`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `or_user`
--
ALTER TABLE `or_user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `or_penilaian_program`
--
ALTER TABLE `or_penilaian_program`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `or_program`
--
ALTER TABLE `or_program`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
