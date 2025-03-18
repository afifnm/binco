-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2025 at 08:43 AM
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
-- Table structure for table `bahan_keluar`
--

CREATE TABLE `bahan_keluar` (
  `id` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `total` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bahan_keluar_detail`
--

CREATE TABLE `bahan_keluar_detail` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 1, 0),
(2, 2, 0),
(3, 3, 0),
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
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `alamat` varchar(80) NOT NULL,
  `telp` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama`, `alamat`, `telp`) VALUES
(3, 'Rizki', 'Polokarto', '0890902'),
(4, 'Ahmad', 'Jl. Sepat Bulu, Bulu, Sukoharjo, 57563', '0890902'),
(5, 'Nurudiin', 'Jl. Sepat, DK. Sepat, Rt:02/Rw:03, Bulu', '089090');

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
-- Indexes for table `bahan_keluar`
--
ALTER TABLE `bahan_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_keluar_detail`
--
ALTER TABLE `bahan_keluar_detail`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

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
-- AUTO_INCREMENT for table `bahan_keluar`
--
ALTER TABLE `bahan_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan_keluar_detail`
--
ALTER TABLE `bahan_keluar_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan_log`
--
ALTER TABLE `bahan_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bahan_masuk_detail`
--
ALTER TABLE `bahan_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
