-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2023 at 11:29 AM
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
-- Database: `makanan_hewan`
--

-- --------------------------------------------------------

--
-- Table structure for table `makanan`
--

CREATE TABLE `makanan` (
  `id_makanan` int(11) NOT NULL,
  `nama_makanan` varchar(50) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `berat` varchar(30) NOT NULL,
  `deskripsi` varchar(500) NOT NULL,
  `kategori` varchar(30) NOT NULL,
  `usia_pemakaian` int(10) NOT NULL,
  `komposisi` varchar(50) NOT NULL,
  `merk` varchar(30) NOT NULL,
  `rating` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makanan`
--

INSERT INTO `makanan` (`id_makanan`, `nama_makanan`, `gambar`, `berat`, `deskripsi`, `kategori`, `usia_pemakaian`, `komposisi`, `merk`, `rating`) VALUES
(1, 'Whiskas Premium', 'nice.png', '200', 'makanan kucing premium yang populer', 'kucing', 1, 'ikan, vitamin, serat', 'whiskas', 4),
(2, 'Blitz Yum', 'blit.jpg', '900', 'makanan anjing yang populer', 'anjing', 1, 'kolagen, ayam, sapi, telur, serat', 'blitz', 5),
(3, 'Poka', 'poka,jpg', '500', 'poka makanan kelinci', 'kelinci', 2, 'serat, sayur, vitamin', 'Po', 5),
(4, 'HappyHamst', 'hamst', '200', 'makanan hamster', 'hamster', 1, 'biji bijian, serat, vitamin', 'Po', 4);

-- --------------------------------------------------------

--
-- Table structure for table `makanan_favorit`
--

CREATE TABLE `makanan_favorit` (
  `id_makanan_favorit` int(11) NOT NULL,
  `id_makanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `makanan_favorit`
--

INSERT INTO `makanan_favorit` (`id_makanan_favorit`, `id_makanan`, `id_pelanggan`) VALUES
(1, 3, 3),
(2, 1, 1),
(3, 1, 1),
(4, 2, 2),
(5, 3, 2),
(6, 3, 2),
(7, 4, 2),
(8, 4, 2),
(9, 4, 2),
(10, 4, 2),
(11, 4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telp` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `username`, `password`, `nama`, `email`, `telp`) VALUES
(1, 'arisandi', '123', 'I Gusti Agung Pt Arisandi Yudiarta', 'pepegaman@gmail.com', '081236000782'),
(2, 'pizzaboy', '123', 'The Pizza Man', 'pizzaman@gmail.com', '081888888888');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `makanan`
--
ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id_makanan`);

--
-- Indexes for table `makanan_favorit`
--
ALTER TABLE `makanan_favorit`
  ADD PRIMARY KEY (`id_makanan_favorit`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `makanan`
--
ALTER TABLE `makanan`
  MODIFY `id_makanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `makanan_favorit`
--
ALTER TABLE `makanan_favorit`
  MODIFY `id_makanan_favorit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
