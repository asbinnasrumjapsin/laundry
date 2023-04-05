-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2023 at 02:25 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `20laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bahan_baku`
--

CREATE TABLE `tb_bahan_baku` (
  `id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `kategori` varchar(191) DEFAULT NULL,
  `satuan_id` int(11) NOT NULL,
  `stok` decimal(10,2) NOT NULL,
  `stok_minimal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan_baku`
--

INSERT INTO `tb_bahan_baku` (`id`, `nama`, `kategori`, `satuan_id`, `stok`, `stok_minimal`) VALUES
(2, 'Parfum', 'Parfum', 5, '45.84', '10.00'),
(4, 'Deterjen cair', 'Detergen Cair', 5, '45.33', '30.00'),
(5, 'molto', 'Parfum', 5, '10.00', '10.00'),
(8, 'Lavender', 'Parfum', 5, '0.00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_beli`
--

CREATE TABLE `tb_beli` (
  `id` int(11) NOT NULL,
  `nomor` varchar(100) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `tgl` date NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_beli`
--

INSERT INTO `tb_beli` (`id`, `nomor`, `supplier_id`, `tgl`, `total`) VALUES
(44, 'PBN-0001', 2, '2022-08-25', 9000),
(45, 'PBN-0002', 2, '2022-09-07', 60000),
(46, 'PBN-0003', 2, '2023-01-11', 24000),
(47, 'PBN-0004', 2, '2023-01-26', 760000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_beli_detail`
--

CREATE TABLE `tb_beli_detail` (
  `no_po` varchar(100) NOT NULL,
  `tgl_pengajuan` datetime NOT NULL,
  `id_suplier` int(11) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `status_pengajuan` varchar(25) NOT NULL,
  `barang_datang` int(11) DEFAULT NULL,
  `harga_suplier` int(11) DEFAULT NULL,
  `alasan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_beli_detail`
--

INSERT INTO `tb_beli_detail` (`no_po`, `tgl_pengajuan`, `id_suplier`, `bahan_id`, `qty`, `harga`, `status_pengajuan`, `barang_datang`, `harga_suplier`, `alasan`) VALUES
('PBN-0001', '2023-01-27 21:36:00', 2, 2, 40, 20000, 'Selesai', 40, 20000, 'ok'),
('PBN-0002', '2023-01-27 22:08:00', 2, 5, 200, 30, 'Selesai', 200, 30, 'ok'),
('PBN-0003', '2023-01-27 23:17:00', 3, 4, 3, 20000, 'Selesai', 3, 20000, 'ok'),
('PBN-0004', '2023-01-28 01:02:00', 2, 4, 2, 20000, 'Tidak Setuju', NULL, NULL, 'ok'),
('PBN-0005', '2023-01-28 01:04:00', 2, 4, 30, 20000, 'Selesai', 30, 20000, 'stok ditambah'),
('PBN-0006', '2023-02-02 21:14:00', 3, 5, 10, 12, 'Selesai', 10, 200000, '15');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `kd_jenis` int(11) NOT NULL,
  `jenis_laundry` varchar(100) NOT NULL,
  `lama_proses` int(11) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`kd_jenis`, `jenis_laundry`, `lama_proses`, `tarif`) VALUES
(20, 'Express', 1, 12000),
(21, 'Kilat', 2, 10000),
(22, 'Reguler', 3, 8000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_bahan`
--

CREATE TABLE `tb_jenis_bahan` (
  `id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `bahan_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `nilai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis_bahan`
--

INSERT INTO `tb_jenis_bahan` (`id`, `jenis_id`, `bahan_id`, `satuan_id`, `nilai`) VALUES
(20, 20, 4, 2, 15),
(22, 21, 2, 2, 2),
(24, 22, 2, 2, 2),
(32, 20, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` int(11) NOT NULL,
  `tgl_laporan` date NOT NULL,
  `ket_laporan` int(1) NOT NULL,
  `catatan` text NOT NULL,
  `id_laundry` char(10) DEFAULT NULL,
  `pemasukan` int(11) NOT NULL DEFAULT '0',
  `id_pembelian` int(11) DEFAULT NULL,
  `id_pengeluaran` char(10) DEFAULT NULL,
  `pengeluaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `id_pembelian`, `id_pengeluaran`, `pengeluaran`) VALUES
(66, '2022-08-25', 1, '', 'LD-0002', 132000, NULL, NULL, 0),
(67, '2022-08-25', 1, '', 'LD-0003', 120000, NULL, NULL, 0),
(68, '2022-08-25', 1, 'bersih dan harum', 'LD-0001', 84000, NULL, NULL, 0),
(69, '2022-09-07', 1, '', 'LD-0004', 36000, NULL, NULL, 0),
(70, '2023-01-14', 1, '', 'LD-0005', 16000, NULL, NULL, 0),
(71, '2023-01-14', 1, '', 'LD-0006', 60000, NULL, NULL, 0),
(72, '2023-01-11', 2, 'Pembelian Bahan baku', NULL, 0, 46, NULL, 24000),
(73, '2023-01-26', 1, '', 'LD-0009', 60000, NULL, NULL, 0),
(74, '2023-01-26', 1, '', 'LD-0010', 60000, NULL, NULL, 0),
(75, '2023-01-14', 1, '', 'LD-0008', 96000, NULL, NULL, 0),
(76, '2023-01-26', 1, '', 'LD-0011', 60000, NULL, NULL, 0),
(77, '2023-01-26', 2, 'Pembelian Bahan baku', NULL, 0, 47, NULL, 760000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry`
--

CREATE TABLE `tb_laundry` (
  `id_laundry` char(10) NOT NULL,
  `konsumen` varchar(191) DEFAULT NULL,
  `telp` varchar(20) DEFAULT NULL,
  `alamat` text,
  `userid` int(11) NOT NULL,
  `kd_jenis` char(6) NOT NULL,
  `tgl_terima` datetime NOT NULL,
  `tgl_selesai` date DEFAULT NULL,
  `tgl_pengambilan` datetime DEFAULT NULL,
  `nama_pengambil` text,
  `jml_kilo` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `totalbayar` int(11) NOT NULL,
  `status_pembayaran` int(1) NOT NULL,
  `status_pengambilan` int(1) NOT NULL,
  `parfum_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_laundry`
--

INSERT INTO `tb_laundry` (`id_laundry`, `konsumen`, `telp`, `alamat`, `userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `tgl_pengambilan`, `nama_pengambil`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`, `status_pengambilan`, `parfum_id`) VALUES
('LD-0002', 'dsad', 'dada', 'dadad', 38, '20', '2023-01-26 00:00:00', '2023-01-27', '2023-01-26 00:00:00', 'dsad', 2, 'dsadadad', 24000, 1, 1, 0),
('LD-0003', 'asbin', '88282828', 'jl. surabaya', 38, '21', '2023-01-26 00:00:00', '2023-01-28', '2023-01-26 00:00:00', 'asbin', 3, 'dsdad', 30000, 1, 1, 0),
('LD-0004', 'sdads', 'sasa', 'Jl. banten', 38, '21', '2023-01-26 00:00:00', '2023-01-28', '2023-01-26 00:00:00', 'sdads', 8, 'azazaza', 80000, 1, 1, 0),
('LD-0005', 'asbin', 'sasa', 'Kota jakarta', 38, '21', '2023-01-26 00:00:00', '2023-01-28', '2023-01-26 00:00:00', 'asrul', 6, 'mm,m,m', 60000, 1, 1, 0),
('LD-0006', 'bnbnmb', '777', 'jkjklj', 38, '20', '2023-01-26 00:00:00', '2023-01-27', '2023-01-26 00:00:00', 'bnbnmb', 5, 'nmbmnbnb', 60000, 1, 1, 0),
('LD-0007', 'jkjkjk', 'hhhhhjh', 'kjjjj', 38, '21', '2023-01-26 00:00:00', '2023-01-28', '2023-01-26 00:00:00', 'tukang ojeg', 6, 'njnjnk', 60000, 1, 1, 0),
('LD-0008', 'asbin', 'n', 'Jl. banten', 38, '21', '2023-01-26 00:00:00', '2023-01-28', '2023-01-26 00:00:00', 'asbin', 7, 'jnjjnjnj', 70000, 1, 1, 0),
('LD-0009', 'zazmaz', 'nnxsjxak', 'xsnaxjnx', 38, '20', '2023-01-26 00:00:00', '2023-01-27', '2023-01-26 00:00:00', 'zazmaz', 2, 'njjnj', 24000, 1, 1, 0),
('LD-0010', 'jkjlk', '78787', 'Jl. banten', 38, '21', '2023-01-27 00:00:00', '2023-01-29', NULL, NULL, 4, 'mkjklj', 40000, 0, 0, 0),
('LD-0011', 'mnmn,m', 'mm,.m,', 'Jl. banten', 38, '20', '2023-01-27 00:00:00', '2023-01-28', NULL, NULL, 6, 'mm,m.', 72000, 0, 0, 0),
('LD-0012', 'sdada', 'dsa', 'dsada', 38, '21', '2023-01-28 00:00:00', '2023-01-30', '2023-01-28 00:00:00', 'sdada', 2, 'dasdd', 20000, 1, 1, 0),
('LD-0013', 'Udin', '12134214', 'Jl. Rancabentang', 35, '20', '2023-02-02 00:00:00', '2023-02-03', NULL, NULL, 1, '', 12000, 0, 0, 0),
('LD-0014', 'wqeqw', '12134214', 'Jl. Rancabentang', 35, '20', '2023-02-02 00:00:00', '2023-02-03', '2023-02-03 00:00:00', 'asrul', 12, 'wqewq', 144000, 1, 1, 0),
('LD-0015', 'udin', '12134214', 'Mars', 35, '20', '2023-02-02 00:00:00', '2023-02-03', '2023-02-02 00:00:00', '', 2, '', 24000, 1, 1, 0),
('LD-0016', 'Udin', '12134214', 'Mars', 35, '21', '2023-02-02 00:00:00', '2023-02-04', '2023-02-02 00:00:00', 'slebew', 12, '', 120000, 1, 1, 0),
('LD-0017', 'Udin Slebew', '12134214', 'Mars', 35, '22', '2023-02-03 09:19:00', '2023-02-06', '2023-02-03 21:23:00', 'Udin Slebew', 2, '', 16000, 1, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry_detail`
--

CREATE TABLE `tb_laundry_detail` (
  `id` int(11) NOT NULL,
  `id_laundry` char(10) CHARACTER SET utf8mb4 NOT NULL,
  `nama` varchar(191) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_laundry_detail`
--

INSERT INTO `tb_laundry_detail` (`id`, `id_laundry`, `nama`, `qty`) VALUES
(1, 'LD-0002', 'T-Shirt', 2),
(2, 'LD-0016', 'T-Shirt / Kaos', 12),
(3, 'LD-0016', 'Kemeja', 165),
(4, 'LD-0017', 'Handuk', 1),
(5, 'LD-0017', 'T-Shirt / Kaos', 7),
(6, 'LD-0017', 'Celana Pendek', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_parfum`
--

CREATE TABLE `tb_parfum` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id_pengeluaran` char(10) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `catatan` text NOT NULL,
  `pengeluaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_satuan`
--

CREATE TABLE `tb_satuan` (
  `id` int(11) NOT NULL,
  `nama` varchar(60) NOT NULL,
  `operator` varchar(50) DEFAULT NULL,
  `operator_val` decimal(10,3) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_satuan`
--

INSERT INTO `tb_satuan` (`id`, `nama`, `operator`, `operator_val`, `parent_id`) VALUES
(2, 'Mililiter (mL)', '/', '1000.000', 5),
(5, 'Liter', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_supplier`
--

CREATE TABLE `tb_supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_supplier`
--

INSERT INTO `tb_supplier` (`id`, `nama`, `alamat`, `telp`) VALUES
(2, 'CV Detergen Indonesia', 'jakarta', '081333456'),
(3, 'cv.cahaya birbal', 'makassar', '0982888888');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `userid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpass` varchar(100) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jk` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `usertelp` varchar(20) NOT NULL,
  `userfoto` varchar(50) DEFAULT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`userid`, `username`, `userpass`, `nama`, `jk`, `alamat`, `usertelp`, `userfoto`, `level`) VALUES
(32, 'asbin', '$2y$10$kYyn7.M..OzsmV6gKX6UneV3GwxhUVl6fhFZzeIvcMUZjoDNDfGj6', 'asbin', 'Laki - laki', 'makassar', '082189000002', '63c7cba77713b.jpg', 'admin'),
(35, 'Muh Asrul', '$2y$10$kYyn7.M..OzsmV6gKX6UneV3GwxhUVl6fhFZzeIvcMUZjoDNDfGj6', 'asrul', 'Laki - laki', 'birbal', '0987654567890', NULL, 'kasir'),
(36, 'andi', '$2y$10$QgRkpE.oxMWxLer.gURjA.8sueQ8Ebc1jS50DFL4MH5U/x31/.7S6', 'andi', 'Laki - laki', 'bandung', '085189658253', NULL, 'kasir'),
(38, 'luthvi', '$2y$10$G.fLFnBkGN0dLw6WB3xqSOKfI1oetvxXA8xAtjaEEeaJGVTJJYd8y', 'luthvi', 'Laki - laki', 'jl.babakansari', '8817764685', NULL, 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahan_baku`
--
ALTER TABLE `tb_bahan_baku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_beli`
--
ALTER TABLE `tb_beli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_beli_detail`
--
ALTER TABLE `tb_beli_detail`
  ADD PRIMARY KEY (`no_po`),
  ADD KEY `beli_id` (`id_suplier`),
  ADD KEY `bahan_id` (`bahan_id`);

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `tb_jenis_bahan`
--
ALTER TABLE `tb_jenis_bahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jenis_id` (`jenis_id`),
  ADD KEY `bahan_id` (`bahan_id`),
  ADD KEY `satuan_id` (`satuan_id`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tb_laundry`
--
ALTER TABLE `tb_laundry`
  ADD PRIMARY KEY (`id_laundry`);

--
-- Indexes for table `tb_laundry_detail`
--
ALTER TABLE `tb_laundry_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laundry_rel` (`id_laundry`);

--
-- Indexes for table `tb_parfum`
--
ALTER TABLE `tb_parfum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tb_satuan`
--
ALTER TABLE `tb_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_bahan_baku`
--
ALTER TABLE `tb_bahan_baku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_beli`
--
ALTER TABLE `tb_beli`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `kd_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_jenis_bahan`
--
ALTER TABLE `tb_jenis_bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `tb_laundry_detail`
--
ALTER TABLE `tb_laundry_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_parfum`
--
ALTER TABLE `tb_parfum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_supplier`
--
ALTER TABLE `tb_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_jenis_bahan`
--
ALTER TABLE `tb_jenis_bahan`
  ADD CONSTRAINT `tb_jenis_bahan_ibfk_1` FOREIGN KEY (`bahan_id`) REFERENCES `tb_bahan_baku` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_jenis_bahan_ibfk_2` FOREIGN KEY (`satuan_id`) REFERENCES `tb_satuan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_jenis_bahan_ibfk_3` FOREIGN KEY (`jenis_id`) REFERENCES `tb_jenis` (`kd_jenis`) ON DELETE CASCADE;

--
-- Constraints for table `tb_laundry_detail`
--
ALTER TABLE `tb_laundry_detail`
  ADD CONSTRAINT `laundry_rel` FOREIGN KEY (`id_laundry`) REFERENCES `tb_laundry` (`id_laundry`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
