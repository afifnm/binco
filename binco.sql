-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2025 at 08:44 AM
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
(3, 'Coco Bristle', 200000);

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

--
-- Dumping data for table `bahan_keluar`
--

INSERT INTO `bahan_keluar` (`id`, `id_pelanggan`, `invoice`, `username`, `tanggal`, `status`, `total`) VALUES
(1, 3, 'S25031931', 'admin', '2025-03-19 01:05:06', 1, 2000000),
(2, 4, 'S25031932', 'admin', '2025-03-19 01:05:20', 1, 4000000);

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

--
-- Dumping data for table `bahan_keluar_detail`
--

INSERT INTO `bahan_keluar_detail` (`id`, `invoice`, `id_bahan`, `jumlah`, `harga_jual`) VALUES
(1, 'S25031931', 3, 10, 200000),
(2, 'S25031932', 3, 20, 200000);

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
(1, 3, 'pembelian', 30, 50000, '2025-03-19 08:03:46', 'B25031931'),
(2, 3, 'pembelian', 10, 50000, '2025-03-19 08:03:46', 'B25031931'),
(3, 3, 'pembelian', 100, 40000, '2025-03-19 08:04:29', 'B25031932'),
(4, 3, 'pembatalan', 100, 40000, '2025-03-19 08:04:45', 'B25031932'),
(5, 3, 'penjualan', 10, 200000, '2025-03-19 08:05:06', 'S25031931'),
(6, 3, 'penjualan', 20, 200000, '2025-03-19 08:05:20', 'S25031932');

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
(1, 'B25031931', 'admin', 2, '2025-03-19 01:03:46', 1, 2000000),
(2, 'B25031932', 'admin', 1, '2025-03-19 01:04:45', 0, 4000000);

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
(1, 'B25031931', 3, 30, 50, 50, 50000),
(2, 'B25031931', 3, 10, 20, 20, 50000),
(3, 'B25031932', 3, 100, 40, 40, 40000);

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
(3, 3, 10);

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
(3, 'Bukan Pelanggan', '-', '-'),
(4, 'Ahmad', 'Jl. Sepat Bulu, Bulu, Sukoharjo, 57563', '0890902'),
(5, 'Nurudiin', 'Jl. Sepat, DK. Sepat, Rt:02/Rw:03, Bulu', '089090');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `harga` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama`, `stok`, `harga`) VALUES
(1, 'Gelas Binco', 52, 10000),
(2, 'Gantungan Kunci', 50, 25000),
(3, 'Lampu Hias', 100, 40000),
(4, 'Tali Sabut Kelapa', 90, 8000),
(5, 'Gelas Batok Kelapa', 50, 25000),
(6, 'Asbak Batok Kelapa', 40, 20000),
(7, 'Gantungan Kunci Batok Kelapa', 100, 10000),
(8, 'Lampu Hias Tempurung Kelapa', 30, 75000),
(9, 'Keset Sabut Kelapa', 60, 30000),
(10, 'Tali Sabut Kelapa', 80, 15000),
(11, 'Pot Tanaman Sabut Kelapa', 50, 35000),
(12, 'Sendok Tempurung Kelapa', 70, 12000),
(13, 'Tas Anyaman Daun Kelapa', 20, 50000),
(14, 'Topi Anyaman Daun Kelapa', 25, 40000),
(15, 'Cincin Batok Kelapa', 100, 15000),
(16, 'Anting Batok Kelapa', 90, 20000),
(17, 'Kalung Batok Kelapa', 85, 25000),
(18, 'Pigura Tempurung Kelapa', 40, 45000),
(19, 'Mainan Mobil Batok Kelapa', 35, 55000),
(20, 'Miniatur Hewan Batok Kelapa', 45, 60000),
(21, 'Mangkok Tempurung', 65, 20000),
(22, 'Centong Nasi Tempurung Kelapa', 55, 15000),
(23, 'Cangkir Sabut Kelapa', 30, 30000),
(24, 'Dompet Anyaman Daun Kelapa', 25, 45000),
(25, 'Kancing Baju Tempurung Kelapa', 200, 5000),
(26, 'Bros Batok Kelapa', 150, 12000),
(27, 'Tempat Tisu Tempurung Kelapa', 40, 35000),
(28, 'Sandal Sabut Kelapa', 30, 60000),
(29, 'Tempat Pensil Batok Kelapa', 50, 25000),
(30, 'Mangkok Sabut Kelapa', 55, 20000),
(31, 'Hiasan Dinding Batok Kelapa', 40, 80000),
(32, 'Sumpit Tempurung Kelapa', 90, 10000),
(33, 'Sapu Lidi Sabut Kelapa', 70, 25000),
(34, 'Tempat Lilin Batok Kelapa', 35, 30000),
(35, 'Tempat Perhiasan Tempurung Kelapa', 40, 40000),
(36, 'Gelang Batok Kelapa', 120, 18000),
(37, 'Tatakan Gelas Tempurung Kelapa', 80, 15000),
(38, 'Sendok Sayur Tempurung Kelapa', 60, 17000),
(39, 'Kursi Sabut Kelapa', 15, 250000),
(40, 'Meja Tempurung Kelapa', 10, 350000),
(41, 'Lukisan Batok Kelapa', 20, 150000),
(42, 'Boneka Sabut Kelapa', 30, 55000),
(43, 'Bakul Anyaman Daun Kelapa', 25, 45000),
(44, 'Kotak Perhiasan Sabut Kelapa', 40, 60000);

-- --------------------------------------------------------

--
-- Table structure for table `produk_log`
--

CREATE TABLE `produk_log` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga_satuan` decimal(10,0) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipe` enum('penjualan','pembatalan') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_sumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_log`
--

INSERT INTO `produk_log` (`id`, `invoice`, `id_produk`, `harga_satuan`, `tanggal`, `tipe`, `jumlah`, `id_sumber`) VALUES
(1, 'P25032031', 1, 10000, '2025-03-20 07:27:39', 'penjualan', 16, 3),
(2, 'P25032031', 3, 40000, '2025-03-20 07:27:39', 'penjualan', 20, 3),
(3, 'P25032031', 1, 10000, '2025-03-20 07:43:10', 'penjualan', 16, 3),
(4, 'P25032031', 3, 40000, '2025-03-20 07:43:10', 'penjualan', 20, 3);

-- --------------------------------------------------------

--
-- Table structure for table `produk_penjualan`
--

CREATE TABLE `produk_penjualan` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `id_sumber` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_penjualan`
--

INSERT INTO `produk_penjualan` (`id`, `invoice`, `tanggal`, `status`, `total`, `id_pelanggan`, `username`, `id_sumber`) VALUES
(1, 'P25032031', '2025-03-20 07:40:10', 0, 960000, 3, 'admin', 3);

-- --------------------------------------------------------

--
-- Table structure for table `produk_penjualan_detail`
--

CREATE TABLE `produk_penjualan_detail` (
  `id` int(11) NOT NULL,
  `invoice` varchar(20) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_jual` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_penjualan_detail`
--

INSERT INTO `produk_penjualan_detail` (`id`, `invoice`, `id_produk`, `jumlah`, `harga_jual`) VALUES
(1, 'P25032031', 1, 16, 10000),
(2, 'P25032031', 3, 20, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `sumber`
--

CREATE TABLE `sumber` (
  `id_sumber` int(11) NOT NULL,
  `sumber` varchar(30) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sumber`
--

INSERT INTO `sumber` (`id_sumber`, `sumber`, `created_at`, `updated_at`) VALUES
(2, 'Toko Binco', '2025-03-20 07:12:59', '2025-03-20 07:13:15'),
(3, 'Tiktok', '2025-03-20 07:13:26', '2025-03-20 07:13:26'),
(4, 'Shope', '2025-03-20 07:13:34', '2025-03-20 07:13:34');

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
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `produk_log`
--
ALTER TABLE `produk_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `produk_penjualan`
--
ALTER TABLE `produk_penjualan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk_penjualan_detail`
--
ALTER TABLE `produk_penjualan_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sumber`
--
ALTER TABLE `sumber`
  ADD PRIMARY KEY (`id_sumber`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bahan_keluar_detail`
--
ALTER TABLE `bahan_keluar_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bahan_log`
--
ALTER TABLE `bahan_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bahan_masuk`
--
ALTER TABLE `bahan_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bahan_masuk_detail`
--
ALTER TABLE `bahan_masuk_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `produk_log`
--
ALTER TABLE `produk_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `produk_penjualan`
--
ALTER TABLE `produk_penjualan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `produk_penjualan_detail`
--
ALTER TABLE `produk_penjualan_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sumber`
--
ALTER TABLE `sumber`
  MODIFY `id_sumber` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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

--
-- Constraints for table `produk_log`
--
ALTER TABLE `produk_log`
  ADD CONSTRAINT `produk_log_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
