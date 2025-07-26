-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 22, 2025 at 06:53 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_azta_icecream`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas`
--

CREATE TABLE `aktivitas` (
  `id_aktivitas` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `aksi` varchar(255) DEFAULT NULL,
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `aktivitas`
--

INSERT INTO `aktivitas` (`id_aktivitas`, `id_user`, `aksi`, `waktu`) VALUES
(1, 3, 'Mengirim testimoni untuk produk ID 27', '2025-07-19 13:38:06'),
(2, 3, 'Melakukan checkout', '2025-07-19 21:20:52'),
(3, 3, 'Melakukan checkout', '2025-07-19 15:34:33'),
(4, 1, 'Login ke sistem', '2025-07-19 21:38:10');

-- --------------------------------------------------------

--
-- Table structure for table `checkout`
--

CREATE TABLE `checkout` (
  `id_checkout` int NOT NULL,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL,
  `total` decimal(12,2) NOT NULL,
  `alamat` text NOT NULL,
  `tanggal_kirim` date NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `tanggal_checkout` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkout`
--

INSERT INTO `checkout` (`id_checkout`, `id_user`, `id_produk`, `jumlah`, `total`, `alamat`, `tanggal_kirim`, `metode_pembayaran`, `status`, `tanggal_checkout`, `created_at`) VALUES
(35, 3, 22, 1, 15000.00, 'AX', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:43:43'),
(36, 3, 23, 1, 15000.00, 'AX', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:43:43'),
(37, 3, 27, 1, 15000.00, 'AX', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:43:43'),
(38, 3, 25, 1, 15000.00, 'XXC', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:44:18'),
(39, 3, 23, 1, 15000.00, 'XXC', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:44:18'),
(40, 3, 23, 1, 15000.00, 'III', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:44:33'),
(41, 3, 22, 1, 15000.00, 'GHG', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:51:13'),
(42, 3, 23, 1, 15000.00, 'GHG', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:51:13'),
(43, 3, 24, 1, 15000.00, 'GHG', '2025-07-18', 'COD', 'pending', NULL, '2025-07-18 15:51:13'),
(44, 3, 22, 1, 15000.00, 'sqa', '2025-07-19', 'COD', 'menunggu', '2025-07-18 18:18:27', '2025-07-18 16:18:27'),
(45, 3, 23, 1, 15000.00, 'sqa', '2025-07-19', 'COD', 'menunggu', '2025-07-18 18:18:27', '2025-07-18 16:18:28'),
(46, 3, 24, 1, 15000.00, 'sqa', '2025-07-19', 'COD', 'menunggu', '2025-07-18 18:18:27', '2025-07-18 16:18:28'),
(47, 1, 22, 1, 15000.00, 'ddd', '2025-07-25', 'COD', 'pending', NULL, '2025-07-18 17:33:33'),
(48, 1, 23, 1, 15000.00, 'tes', '2025-07-19', 'Transfer', 'pending', NULL, '2025-07-18 17:33:55'),
(49, 1, 23, 1, 15000.00, 'qdwdwd', '2025-07-19', 'COD', 'menunggu', '2025-07-18 19:34:16', '2025-07-18 17:34:16'),
(50, 1, 24, 2, 30000.00, 'scscscsc', '2025-07-19', 'COD', 'menunggu', '2025-07-18 19:42:49', '2025-07-18 17:42:49'),
(51, 1, 23, 1, 15000.00, 'scscscsc', '2025-07-19', 'COD', 'menunggu', '2025-07-18 19:42:49', '2025-07-18 17:42:49'),
(52, 1, 24, 1, 15000.00, 'xs', '2025-07-19', 'COD', 'menunggu', '2025-07-18 20:38:21', '2025-07-18 18:38:21'),
(53, 1, 23, 1, 15000.00, 'fevef', '2025-07-19', 'Transfer', 'pending', NULL, '2025-07-19 00:56:46'),
(54, 1, 24, 1, 15000.00, 'hbhb', '2025-07-19', 'Transfer', 'pending', NULL, '2025-07-19 00:57:08'),
(55, 1, 25, 1, 80000.00, 'gunung sari', '2025-07-19', 'Transfer', 'pending', NULL, '2025-07-19 03:37:43'),
(56, 1, 26, 1, 15000.00, 'berbas', '2025-07-19', 'Transfer', 'pending', NULL, '2025-07-19 03:42:52'),
(57, 1, 27, 1, 15000.00, 'btg', '2025-07-19', 'Transfer Bank', 'menunggu', '2025-07-19 05:43:34', '2025-07-19 03:43:34'),
(58, 1, 28, 1, 9000.00, 'btg', '2025-07-19', 'Transfer Bank', 'menunggu', '2025-07-19 05:43:34', '2025-07-19 03:43:34'),
(59, 1, 29, 1, 8000.00, 'btg', '2025-07-19', 'Transfer Bank', 'menunggu', '2025-07-19 05:43:34', '2025-07-19 03:43:34'),
(60, 1, 26, 1, 15000.00, 'rerererer', '2025-07-31', 'Transfer', 'pending', NULL, '2025-07-19 05:52:21'),
(61, 3, 24, 1, 600000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:20:52', '2025-07-19 13:20:52'),
(62, 3, 27, 1, 15000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:20:52', '2025-07-19 13:20:52'),
(63, 3, 24, 1, 600000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:31:19', '2025-07-19 13:31:19'),
(64, 3, 27, 1, 15000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:31:19', '2025-07-19 13:31:19'),
(65, 3, 24, 1, 600000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:31:28', '2025-07-19 13:31:28'),
(66, 3, 27, 1, 15000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:31:28', '2025-07-19 13:31:28'),
(67, 3, 24, 1, 600000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:34:33', '2025-07-19 13:34:33'),
(68, 3, 27, 1, 15000.00, 'jhjh', '2025-07-19', 'COD', 'menunggu', '2025-07-19 15:34:33', '2025-07-19 13:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'satuan'),
(2, 'mix\r\n'),
(3, '1 dus\r\n'),
(4, 'stik\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `kontak_admin`
--

CREATE TABLE `kontak_admin` (
  `id_kontak` int NOT NULL,
  `nama_admin` varchar(100) DEFAULT NULL,
  `no_wa` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kontak_admin`
--

INSERT INTO `kontak_admin` (`id_kontak`, `nama_admin`, `no_wa`, `email`, `alamat`) VALUES
(1, 'Admin Azta', '6281234567890', 'admin@azta.com', 'Jl. Es Krim No. 12, Bontang');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int NOT NULL,
  `id_checkout` int NOT NULL,
  `jumlah` int NOT NULL,
  `tanggal` date DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `bukti` varchar(255) DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_checkout`, `jumlah`, `tanggal`, `metode`, `bukti`, `tanggal_pembayaran`) VALUES
(1, 42, 40, '2025-07-19', NULL, NULL, NULL),
(2, 37, 30, '2025-07-24', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int NOT NULL,
  `nama_aplikasi` varchar(100) DEFAULT NULL,
  `deskripsi` text,
  `alamat_toko` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_aplikasi`, `deskripsi`, `alamat_toko`) VALUES
(1, 'Azta Es Cream', 'Es Krim Berkualitas\r\n', 'Jl. Contoh No.1, Bontang');

-- --------------------------------------------------------

--
-- Table structure for table `pengiriman`
--

CREATE TABLE `pengiriman` (
  `id_pengiriman` int NOT NULL,
  `id_checkout` int NOT NULL,
  `nama_kurir` varchar(100) DEFAULT NULL,
  `tanggal_kirim` date DEFAULT NULL,
  `status_pengiriman` enum('dalam proses','dikirim','diterima') DEFAULT 'dalam proses'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengiriman`
--

INSERT INTO `pengiriman` (`id_pengiriman`, `id_checkout`, `nama_kurir`, `tanggal_kirim`, `status_pengiriman`) VALUES
(5, 46, 'jon', '2025-07-21', 'dalam proses');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `stok` int DEFAULT '0',
  `deskripsi` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `id_kategori`, `harga`, `gambar`, `stok`, `deskripsi`) VALUES
(22, 'Mochi Durian', 3, 150000.00, 'mochidurian.png', 50, ''),
(23, 'Mochi Peach', 3, 150000.00, 'mochi.png', 50, ''),
(24, 'Bucket Series', 2, 600000.00, 'bucketseries.png', 50, ''),
(25, 'Coklat Krispi', 3, 80000.00, 'eskrimcoklat.png', 50, ''),
(26, 'Bucket 3 Variant', 1, 15000.00, 'eskrimember.png', 50, NULL),
(27, 'Vanilla Box', 1, 15000.00, 'eskrimvanilla.png', 50, NULL),
(28, 'Strawberry Sundae', 1, 9000.00, 'sundaeicecream.png', 50, ''),
(29, 'Corn Stik', 4, 8000.00, 'cornstik.png', 15, ''),
(30, 'Blueberry Mania', 2, 130000.00, 'blueberrymania.png', 300, ''),
(31, 'Fruizzy Lychee', 3, 80000.00, 'fruizzylychee.png', 50, ''),
(32, 'Histeria Peach', 1, 20000.00, 'histeriapeach.png', 80, ''),
(33, 'Milk Tea Boba', 3, 50000.00, 'milkteaboba.png', 83, ''),
(34, 'Mochi All Variant', 2, 80000.00, 'mochimix.png', 87, ''),
(35, 'Moong Bean', 1, 6000.00, 'moongbean.png', 500, ''),
(36, 'Strawberry Crispy', 1, 8000.00, 'strawberrycrispy.png', 300, ''),
(37, 'Jeruk', 3, 88000.00, 'jeruk.png', 80, ''),
(38, 'Fruit Twister', 3, 200000.00, 'fruittwister.png', 70, ''),
(39, 'Juju Apple', 3, 120000.00, 'jujuapple.png', 60, '');

-- --------------------------------------------------------

--
-- Table structure for table `testimoni`
--

CREATE TABLE `testimoni` (
  `id_testimoni` int NOT NULL,
  `id_user` int NOT NULL,
  `id_produk` int NOT NULL,
  `pesan` text NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testimoni`
--

INSERT INTO `testimoni` (`id_testimoni`, `id_user`, `id_produk`, `pesan`, `tanggal`) VALUES
(3, 3, 23, 'enak', '2025-07-19 03:18:30'),
(4, 3, 27, 'segerr\r\n', '2025-07-19 13:38:06');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_user` int NOT NULL,
  `total` int NOT NULL,
  `status` varchar(50) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_user`, `total`, `status`, `tanggal`) VALUES
(1, 3, 615000, 'pending', '2025-07-19 15:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','pelanggan') DEFAULT 'pelanggan',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Admin Azta', 'admin@azta.com', '$2y$10$g1RqPs2dCROKwkAHHe7ck.TkdfCC8hx9sCzgtl3OM33tj2H254nIe', 'admin', '2025-07-17 01:18:04'),
(3, 'Maul', 'vidi@mail.com', '$2y$10$W6Chzt3wRP6y4pzAZtAYG.SqLB.Zna8xFuDoNWBtdzEUfZsv9QO4G', 'pelanggan', '2025-07-17 08:20:34'),
(4, 'cahaya', 'cahaya@gmail.com', '$2y$10$PXsm/cPdDOrNsDXxFNljcemNNLlEEYS/hfxOVeyNqfQ.FDQKQjjd2', 'pelanggan', '2025-07-18 15:18:04'),
(5, 'sari', 'sari@gmail.com', '$2y$10$mZ1bAQPCOeyu5UW/dItLh.uziRvGYF1YYnt7kyL8iAMJ0OcTFANnS', 'pelanggan', '2025-07-21 12:37:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD PRIMARY KEY (`id_aktivitas`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `checkout`
--
ALTER TABLE `checkout`
  ADD PRIMARY KEY (`id_checkout`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `fk_checkout_user` (`id_user`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `kontak_admin`
--
ALTER TABLE `kontak_admin`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_checkout` (`id_checkout`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD PRIMARY KEY (`id_pengiriman`),
  ADD KEY `id_checkout` (`id_checkout`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD PRIMARY KEY (`id_testimoni`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas`
--
ALTER TABLE `aktivitas`
  MODIFY `id_aktivitas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `checkout`
--
ALTER TABLE `checkout`
  MODIFY `id_checkout` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kontak_admin`
--
ALTER TABLE `kontak_admin`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengiriman`
--
ALTER TABLE `pengiriman`
  MODIFY `id_pengiriman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `testimoni`
--
ALTER TABLE `testimoni`
  MODIFY `id_testimoni` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas`
--
ALTER TABLE `aktivitas`
  ADD CONSTRAINT `aktivitas_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Constraints for table `checkout`
--
ALTER TABLE `checkout`
  ADD CONSTRAINT `checkout_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `checkout_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_checkout_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_checkout`) REFERENCES `checkout` (`id_checkout`) ON DELETE CASCADE;

--
-- Constraints for table `pengiriman`
--
ALTER TABLE `pengiriman`
  ADD CONSTRAINT `pengiriman_ibfk_1` FOREIGN KEY (`id_checkout`) REFERENCES `checkout` (`id_checkout`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`) ON DELETE SET NULL;

--
-- Constraints for table `testimoni`
--
ALTER TABLE `testimoni`
  ADD CONSTRAINT `testimoni_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `testimoni_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
