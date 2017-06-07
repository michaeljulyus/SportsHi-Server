-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 07, 2017 at 12:03 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportshi`
--

-- --------------------------------------------------------

--
-- Table structure for table `sh_event`
--

CREATE TABLE `sh_event` (
  `id` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `olahraga` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto_event` varchar(400) NOT NULL,
  `location` varchar(100) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sh_event`
--

INSERT INTO `sh_event` (`id`, `username`, `olahraga`, `deskripsi`, `foto_event`, `location`, `waktu`) VALUES
(1, 'michaeljulyus', 'Playing Soccer', 'Ayo main basket bareng.', '2017-05-28_06-26-53.jpg', 'Lapangan Benteng', '2017-06-07 06:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `sh_kategori`
--

CREATE TABLE `sh_kategori` (
  `id` int(11) NOT NULL,
  `nama_olahraga` varchar(50) NOT NULL,
  `foto` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sh_kategori`
--

INSERT INTO `sh_kategori` (`id`, `nama_olahraga`, `foto`) VALUES
(1, 'Running', 'running.jpg'),
(2, 'Playing Soccer', 'soccer.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `sh_moment`
--

CREATE TABLE `sh_moment` (
  `id` int(11) NOT NULL,
  `username_post` varchar(40) NOT NULL,
  `username_tag` varchar(40) NOT NULL,
  `olahraga` varchar(100) NOT NULL,
  `foto_moment` varchar(400) NOT NULL,
  `deskripsi` text NOT NULL,
  `location` varchar(100) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sh_moment`
--

INSERT INTO `sh_moment` (`id`, `username_post`, `username_tag`, `olahraga`, `foto_moment`, `deskripsi`, `location`, `waktu`) VALUES
(4, 'michaeljulyus', '', 'Runnig', '2017-05-28_05-22-54.jpg', 'More practice for marathon match tomorrow.', 'Lapangan Sempur', '2017-06-07 06:30:08'),
(15, 'michaeljulyus', 'tonny', 'Playing Soccer', '2017-05-28_05-22-52.jpg', 'It''s fun to play soccer together with my best friend.', 'Lapangan Sempur', '2017-06-07 06:27:32');

-- --------------------------------------------------------

--
-- Table structure for table `sh_user`
--

CREATE TABLE `sh_user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(10) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `foto_profil` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sh_user`
--

INSERT INTO `sh_user` (`id`, `nama`, `jenis_kelamin`, `tanggal_lahir`, `username`, `password`, `email`, `foto_profil`) VALUES
(7, 'Michael Julyus Christopher', 'Male', '2017-06-03', 'michaeljulyus', '01cfcd4f6b8770febfb40cb906715822', 'michaeljulyus@gmail.com', '7.png'),
(8, 'Tonny David Richardo', 'Male', '1990-10-16', 'tonny', '827ccb0eea8a706c4c34a16891f84e7b', 'tonny@gmail.com', '8.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sh_event`
--
ALTER TABLE `sh_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sh_kategori`
--
ALTER TABLE `sh_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sh_moment`
--
ALTER TABLE `sh_moment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sh_user`
--
ALTER TABLE `sh_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sh_event`
--
ALTER TABLE `sh_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sh_kategori`
--
ALTER TABLE `sh_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sh_moment`
--
ALTER TABLE `sh_moment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `sh_user`
--
ALTER TABLE `sh_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
