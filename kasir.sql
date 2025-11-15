-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2025 at 12:10 AM
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
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detailpenjualan`
--

CREATE TABLE `detailpenjualan` (
  `DetailID` int NOT NULL,
  `PenjualanID` int NOT NULL,
  `ProdukID` int NOT NULL,
  `JumlahProduk` int NOT NULL,
  `SubTotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detailpenjualan`
--

INSERT INTO `detailpenjualan` (`DetailID`, `PenjualanID`, `ProdukID`, `JumlahProduk`, `SubTotal`) VALUES
(23, 27, 1, 1, '5000.00'),
(24, 28, 1, 1, '5000.00'),
(25, 29, 1, 1, '5000.00'),
(26, 30, 1, 1, '5000.00'),
(27, 31, 1, 1, '5000.00'),
(28, 32, 1, 1, '5000.00'),
(29, 33, 1, 1, '5000.00'),
(30, 33, 1, 2, '10000.00'),
(31, 34, 1, 1, '5000.00'),
(32, 34, 1, 2, '10000.00'),
(33, 35, 2, 1, '3000.00'),
(34, 35, 3, 1, '10000.00'),
(35, 36, 1, 1, '5000.00'),
(36, 37, 1, 1, '5000.00'),
(37, 38, 1, 1, '5000.00'),
(38, 39, 1, 1, '5000.00'),
(39, 40, 1, 1, '5000.00'),
(40, 41, 1, 1, '5000.00'),
(41, 42, 1, 1, '5000.00'),
(42, 43, 1, 1, '5000.00'),
(43, 44, 3, 1, '10000.00'),
(44, 45, 1, 1, '5000.00'),
(45, 46, 1, 1, '5000.00'),
(46, 47, 1, 1, '5000.00'),
(47, 48, 1, 1, '5000.00'),
(48, 49, 1, 1, '5000.00'),
(49, 50, 1, 1, '5000.00'),
(50, 50, 1, 2, '10000.00'),
(51, 50, 2, 2, '6000.00'),
(52, 51, 1, 1, '5000.00'),
(53, 52, 1, 1, '5000.00'),
(54, 53, 2, 1, '3000.00'),
(55, 53, 3, 2, '20000.00'),
(56, 54, 7, 1, '1000.00'),
(57, 55, 2, 1, '3000.00'),
(58, 56, 1, 1, '3500.00'),
(59, 57, 5, 1, '3000.00'),
(60, 57, 7, 3, '3000.00'),
(61, 57, 2, 2, '6000.00'),
(62, 58, 5, 1, '3000.00'),
(63, 58, 7, 3, '3000.00'),
(64, 58, 2, 2, '6000.00'),
(65, 59, 5, 1, '3000.00'),
(66, 59, 7, 3, '3000.00'),
(67, 59, 2, 2, '6000.00'),
(68, 60, 5, 1, '3000.00'),
(69, 60, 7, 3, '3000.00'),
(70, 60, 2, 2, '6000.00'),
(71, 61, 5, 1, '3000.00'),
(72, 61, 7, 3, '3000.00'),
(73, 61, 2, 2, '6000.00'),
(74, 62, 2, 1, '3000.00'),
(75, 62, 6, 1, '500.00'),
(76, 63, 8, 1, '1500.00'),
(77, 63, 9, 3, '3000.00');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `PelangganID` int NOT NULL,
  `NamaPelanggan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `NomorTelepon` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`PelangganID`, `NamaPelanggan`, `Alamat`, `NomorTelepon`) VALUES
(1, 'Umum', '-', '-'),
(2, 'fandi', 'semboro', '0823827813789'),
(3, 'bu setyo', 'krangkongan', '0857894567890'),
(10, 'ihsan', 'salaan', '085806789054'),
(11, 'tohari', 'semboro lor', '0894568976453'),
(12, 'ali', 'umbulsari', '0894568976543'),
(13, 'lukman', 'mloko', '0894568976908'),
(14, 'fani', 'semboro', '085678345234');

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `PenjualanID` int NOT NULL,
  `TanggalPenjualan` date NOT NULL,
  `TotalHarga` decimal(10,2) NOT NULL,
  `PelangganID` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`PenjualanID`, `TanggalPenjualan`, `TotalHarga`, `PelangganID`) VALUES
(25, '2025-11-13', '5000.00', 1),
(26, '2025-11-13', '10000.00', 1),
(27, '2025-11-13', '5000.00', 1),
(28, '2025-11-13', '5000.00', 1),
(29, '2025-11-13', '5000.00', 1),
(30, '2025-11-13', '5000.00', 1),
(31, '2025-11-13', '5000.00', 1),
(32, '2025-11-13', '5000.00', 1),
(33, '2025-11-13', '15000.00', 1),
(34, '2025-11-13', '15000.00', 1),
(35, '2025-11-13', '13000.00', 1),
(36, '2025-11-13', '5000.00', 1),
(37, '2025-11-13', '5000.00', 1),
(38, '2025-11-13', '5000.00', 1),
(39, '2025-11-13', '5000.00', 1),
(40, '2025-11-13', '5000.00', 1),
(41, '2025-11-13', '5000.00', 1),
(42, '2025-11-13', '5000.00', 1),
(43, '2025-11-13', '5000.00', 1),
(44, '2025-11-13', '10000.00', 1),
(45, '2025-11-13', '5000.00', 1),
(46, '2025-11-13', '5000.00', 1),
(47, '2025-11-13', '5000.00', 1),
(48, '2025-11-13', '5000.00', 1),
(49, '2025-11-14', '5000.00', 1),
(50, '2025-11-14', '21000.00', 1),
(51, '2025-11-14', '5000.00', 3),
(52, '2025-11-14', '5000.00', 2),
(53, '2025-11-14', '23000.00', 1),
(54, '2025-11-14', '1000.00', 1),
(55, '2025-11-14', '3000.00', 1),
(56, '2025-11-14', '3500.00', 1),
(57, '2025-11-14', '12000.00', 1),
(58, '2025-11-14', '12000.00', 1),
(59, '2025-11-14', '12000.00', 1),
(60, '2025-11-14', '12000.00', 1),
(61, '2025-11-14', '12000.00', 1),
(62, '2025-11-14', '3500.00', 1),
(63, '2025-11-14', '4500.00', 11);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `ProdukID` int NOT NULL,
  `NamaProduk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `Harga` decimal(10,2) NOT NULL,
  `Stok` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`ProdukID`, `NamaProduk`, `Harga`, `Stok`) VALUES
(1, 'Mie Sedap', '3500.00', 13),
(2, 'Ice Cream', '3000.00', 0),
(3, 'sampo', '500.00', 0),
(5, 'sabun mandi', '3000.00', 10),
(6, 'masako', '500.00', 29),
(7, 'micin', '1000.00', 11),
(8, 'kopi susu', '1500.00', 5),
(9, 'kopi plus', '1000.00', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `level` enum('admin','petugas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `level`) VALUES
(5, 'admin', 'admin', '$2y$10$PYycXqHD4JGeDjIv/9sb9ehynLwfiYrJiciX4xqNP5jMGlY1wPixy', 'admin'),
(6, 'fandy', 'fandi', '$2y$10$igOMvU8uUTrpzvWlvoTLEeyaKzuDQqi3WpoJsHVYMzUMHNXGaLnA2', 'admin'),
(7, 'fandi', 'fandy', '$2y$10$GEy0uOTRSpaN8mplELeja.kiGc4mYiGupM84vP6Cm7yh6fpIzC/g6', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD PRIMARY KEY (`DetailID`),
  ADD KEY `PenjualanID` (`PenjualanID`),
  ADD KEY `ProdukID` (`ProdukID`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`PelangganID`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`PenjualanID`),
  ADD KEY `PelangganID` (`PelangganID`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`ProdukID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  MODIFY `DetailID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `PelangganID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `PenjualanID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `ProdukID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detailpenjualan`
--
ALTER TABLE `detailpenjualan`
  ADD CONSTRAINT `detailpenjualan_ibfk_1` FOREIGN KEY (`PenjualanID`) REFERENCES `penjualan` (`PenjualanID`),
  ADD CONSTRAINT `detailpenjualan_ibfk_2` FOREIGN KEY (`ProdukID`) REFERENCES `produk` (`ProdukID`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`PelangganID`) REFERENCES `pelanggan` (`PelangganID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
