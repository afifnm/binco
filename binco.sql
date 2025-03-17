-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 08:58 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binco`
--

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id_bahan` int(11) NOT NULL,
  `bahan` varchar(50) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id_bahan`, `bahan`, `harga`) VALUES
(1, 'Coco Peat', 50000),
(2, 'Coco Fyber', 900000),
(3, 'Coco Bristle', 200000),
(4, 'Lain-lain', 700000);

--
-- Triggers `bahan`
--
DELIMITER $$
CREATE TRIGGER `after_insert_bahan` AFTER INSERT ON `bahan` FOR EACH ROW BEGIN
    INSERT INTO bahan_stok (id_bahan, stok) VALUES (NEW.id_bahan, 0);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_log`
--

CREATE TABLE `bahan_log` (
  `id_log` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `tipe` enum('pembelian','penjualan','pembatalan') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(10,0) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `invoice` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_log`
--

INSERT INTO `bahan_log` (`id_log`, `id_bahan`, `tipe`, `jumlah`, `harga_satuan`, `tanggal`, `invoice`) VALUES
(2, 3, 'pembelian', 20, 100000, '2025-03-17 12:34:11', '25031731'),
(3, 3, 'pembelian', 20, 50000, '2025-03-17 12:36:40', '25031732'),
(4, 1, 'pembelian', 50, 20000, '2025-03-17 12:36:40', '25031732'),
(5, 3, 'pembatalan', 20, 100000, '2025-03-17 13:28:54', '25031731'),
(6, 3, 'pembatalan', 20, 50000, '2025-03-17 13:44:34', '25031732'),
(7, 1, 'pembatalan', 50, 20000, '2025-03-17 13:44:34', '25031732'),
(8, 1, 'pembelian', 50, 100000, '2025-03-17 13:49:20', '25031733');

-- --------------------------------------------------------

--
-- Table structure for table `bahan_masuk`
--

CREATE TABLE `bahan_masuk` (
  `id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_masuk`
--

INSERT INTO `bahan_masuk` (`id`, `invoice`, `username`, `id_supplier`, `tanggal`, `status`, `total`) VALUES
(1, '25031731', 'admin', 2, '2025-03-17 06:28:54', 0, 2000000),
(2, '25031732', 'admin', 2, '2025-03-17 06:44:34', 0, 2000000),
(3, '25031733', 'admin', 1, '2025-03-17 06:49:20', 1, 5000000);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_masuk_detail`
--

CREATE TABLE `bahan_masuk_detail` (
  `id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `kadar_air` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `harga_beli` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_masuk_detail`
--

INSERT INTO `bahan_masuk_detail` (`id`, `invoice`, `id_bahan`, `jumlah`, `kadar_air`, `berat`, `harga_beli`) VALUES
(4, '25031731', 3, 20, 20, 20, 100000),
(5, '25031732', 3, 20, 20, 20, 50000),
(6, '25031732', 1, 50, 40, 20, 20000),
(7, '25031733', 1, 50, 90, 20, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `bahan_stok`
--

CREATE TABLE `bahan_stok` (
  `id_stok` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bahan_stok`
--

INSERT INTO `bahan_stok` (`id_stok`, `id_bahan`, `stok`) VALUES
(1, 1, 50),
(2, 2, 0),
(3, 3, 60),
(4, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `nama_cv` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `nama_cv`, `alamat`, `telp`, `email`) VALUES
(1, 'KOPSISMART ', 'Jl. Yos Sudarso, Jengglong, Bejen, Kec. Karanganyar, Kabupaten Karanganyar, Jawa Tengah 57716', '+6282329769012', '-');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama`, `alamat`, `telp`) VALUES
(1, 'Jack', 'Jongke', '089090'),
(2, 'Apip', 'Jl. Sepat Bulu, Bulu, Sukoharjo, 57563', '0890902');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `level` enum('Admin','Kasir','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama`, `level`) VALUES
(3, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', 'Admin'),
(6, 'kasir', 'c7911af3adbd12a035b289556d96470a', 'Ali Marshanto', 'Kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id_bahan`);

--
-- Indexes for table `bahan_log`
--
ALTER TABLE `bahan_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `id_bahan` (`id_bahan`);

--
-- Indexes for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_masuk_detail`
--
ALTER TABLE `bahan_masuk_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_stok`
--
ALTER TABLE `bahan_stok`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_bahan` (`id_bahan`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id_bahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bahan_log`
--
ALTER TABLE `bahan_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bahan_masuk_detail`
--
ALTER TABLE `bahan_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bahan_stok`
--
ALTER TABLE `bahan_stok`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bahan_log`
--
ALTER TABLE `bahan_log`
  ADD CONSTRAINT `bahan_log_ibfk_1` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE;

--
-- Constraints for table `bahan_stok`
--
ALTER TABLE `bahan_stok`
  ADD CONSTRAINT `bahan_stok_ibfk_1` FOREIGN KEY (`id_bahan`) REFERENCES `bahan` (`id_bahan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
