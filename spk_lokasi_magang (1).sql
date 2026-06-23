-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 23, 2026 at 02:11 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_lokasi_magang`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int NOT NULL,
  `kode` varchar(5) DEFAULT NULL,
  `nama_perusahaan` varchar(100) DEFAULT NULL,
  `alamat` text,
  `kota` varchar(50) DEFAULT NULL,
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `kode`, `nama_perusahaan`, `alamat`, `kota`, `deskripsi`) VALUES
(1, 'A001', 'PT ABCD', 'Tangerang', 'Tangerang', 'Pabrik'),
(2, 'A002', 'PT DEF', 'Tangerang', 'Tangerang', 'Pabrik'),
(4, 'A003', 'PT XYZ', 'Tangerang', 'Tangerang', 'Pabrik');

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` int NOT NULL,
  `kode` varchar(5) DEFAULT NULL,
  `nama_kriteria` varchar(100) DEFAULT NULL,
  `atribut` enum('benefit','cost') DEFAULT NULL,
  `bobot` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `kode`, `nama_kriteria`, `atribut`, `bobot`) VALUES
(1, 'K001', 'Jarak Tempuh', 'cost', 0.07),
(2, 'K002', 'Kesesuaian Bidang Magang', 'benefit', 0.33),
(3, 'K003', 'Reputasi Perusahaan', 'benefit', 0.28),
(4, 'K004', 'Fasilitas', 'benefit', 0.16),
(6, 'K005', 'Kesempatan Kontrak', 'benefit', 0.16);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` int NOT NULL,
  `id_alternatif` int DEFAULT NULL,
  `id_kriteria` int DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_penilaian`, `id_alternatif`, `id_kriteria`, `nilai`) VALUES
(1, 1, 1, 4.00),
(2, 1, 2, 5.00),
(3, 1, 3, 5.00),
(4, 1, 4, 4.00),
(5, 1, 6, 5.00),
(6, 2, 1, 5.00),
(7, 2, 2, 4.00),
(8, 2, 3, 4.00),
(9, 2, 4, 4.00),
(10, 2, 6, 5.00),
(11, 4, 1, 4.00),
(12, 4, 2, 4.00),
(13, 4, 3, 5.00),
(14, 4, 4, 5.00),
(15, 4, 6, 4.00);

-- --------------------------------------------------------

--
-- Table structure for table `perbandingan_kriteria`
--

CREATE TABLE `perbandingan_kriteria` (
  `id` int NOT NULL,
  `kriteria_1` int NOT NULL,
  `kriteria_2` int NOT NULL,
  `nilai` decimal(10,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `perbandingan_kriteria`
--

INSERT INTO `perbandingan_kriteria` (`id`, `kriteria_1`, `kriteria_2`, `nilai`) VALUES
(1, 1, 1, 1.0000),
(2, 2, 2, 1.0000),
(3, 3, 3, 1.0000),
(4, 4, 4, 1.0000),
(5, 6, 6, 1.0000),
(6, 1, 2, 0.3333),
(7, 2, 1, 3.0000),
(8, 1, 3, 0.2000),
(9, 3, 1, 5.0000),
(10, 1, 4, 0.3333),
(11, 4, 1, 3.0000),
(12, 1, 6, 0.3333),
(13, 6, 1, 3.0000),
(14, 2, 3, 2.0000),
(15, 3, 2, 0.5000),
(16, 2, 4, 2.0000),
(17, 4, 2, 0.5000),
(18, 2, 6, 2.0000),
(19, 6, 2, 0.5000),
(20, 3, 4, 2.0000),
(21, 4, 3, 0.5000),
(22, 3, 6, 2.0000),
(23, 6, 3, 0.5000),
(24, 4, 6, 1.0000),
(25, 6, 4, 1.0000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `no_telp`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', '08816807058', 'admin@gmail.com', '$2y$10$shJ8QR96OAUcZKV4uWRFzu3oISyrBAMYNOmPZDHRI9l5frfvYFwPe', '2026-06-22 14:14:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_alternatif` (`id_alternatif`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- Indexes for table `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id_kriteria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `perbandingan_kriteria`
--
ALTER TABLE `perbandingan_kriteria`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE,
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
