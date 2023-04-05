-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 17, 2022 at 08:12 PM
-- Server version: 5.7.24
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laundryshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bahan_baku`
--

CREATE TABLE `tb_bahan_baku` (
  `id` int(11) NOT NULL,
  `nama` varchar(191) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `stok` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bahan_baku`
--

INSERT INTO `tb_bahan_baku` (`id`, `nama`, `satuan_id`, `stok`) VALUES
(1, 'Deterjen', 1, '9.10'),
(2, 'Parfum', 2, '972.00');

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
(1, 'Laundry + Seterika', 3, 7000),
(2, 'Fast Laundry', 1, 10000),
(12, 'Regular', 2, 6000),
(13, 'Cuci Karpet', 3, 10000);

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
(1, 12, 1, 3, 15),
(2, 2, 1, 3, 15),
(4, 2, 2, 2, 2),
(6, 12, 2, 2, 2),
(7, 1, 1, 3, 30),
(8, 1, 2, 5, 2),
(9, 13, 1, 3, 150);

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
  `pemasukan` int(11) NOT NULL,
  `id_pengeluaran` char(10) DEFAULT NULL,
  `pengeluaran` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `id_pengeluaran`, `pengeluaran`) VALUES
(28, '2022-01-09', 1, '5 baju, 5 celana levis', 'LD-0001', 70000, NULL, 0),
(29, '2022-01-09', 1, '10 kemeja, 2 celana training', 'LD-0002', 100000, NULL, 0),
(30, '2022-01-09', 1, 'Karpet 20kg', 'LD-0003', 200000, NULL, 0),
(31, '2022-01-09', 1, '2 celana, 3 baju, 2 kaus', 'LD-0005', 35000, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry`
--

CREATE TABLE `tb_laundry` (
  `id_laundry` char(10) NOT NULL,
  `pelangganid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `kd_jenis` char(6) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jml_kilo` int(11) NOT NULL,
  `catatan` text NOT NULL,
  `totalbayar` int(11) NOT NULL,
  `status_pembayaran` int(1) NOT NULL,
  `status_pengambilan` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_laundry`
--

INSERT INTO `tb_laundry` (`id_laundry`, `pelangganid`, `userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`, `status_pengambilan`) VALUES
('LD-0001', 5, 27, '1', '2022-01-09', '2022-01-12', 10, '5 baju, 5 celana levis', 70000, 1, 1),
('LD-0002', 3, 27, '2', '2022-01-09', '2022-01-10', 10, '10 kemeja, 2 celana training', 100000, 1, 0),
('LD-0003', 5, 27, '13', '2022-01-09', '2022-01-12', 20, 'Karpet 20kg', 200000, 1, 0),
('LD-0004', 9, 27, '12', '2022-01-09', '2022-01-11', 9, '14 kaus', 54000, 0, 0),
('LD-0005', 9, 27, '1', '2022-01-09', '2022-01-12', 5, '2 celana, 3 baju, 2 kaus', 35000, 1, 0),
('LD-0006', 3, 27, '12', '2022-07-17', '2022-07-19', 2, 'sadasd', 12000, 0, 0),
('LD-0007', 3, 27, '12', '2022-07-17', '2022-07-19', 2, 'sadasd', 12000, 0, 0),
('LD-0008', 3, 27, '12', '2022-07-17', '2022-07-19', 2, 'wq', 12000, 0, 0),
('LD-0009', 5, 27, '12', '2022-07-17', '2022-07-19', 2, 'as', 12000, 0, 0),
('LD-0010', 5, 27, '12', '2022-07-17', '2022-07-19', 2, 'wq', 12000, 0, 0),
('LD-0011', 3, 27, '1', '2022-07-17', '2022-07-20', 2, 'w', 14000, 0, 0),
('LD-0012', 3, 27, '1', '2022-07-17', '2022-07-20', 2, 'w', 14000, 0, 0),
('LD-0013', 3, 27, '12', '2022-07-17', '2022-07-19', 2, 'w', 12000, 0, 0),
('LD-0014', 3, 27, '12', '2022-07-17', '2022-07-19', 4, 's', 24000, 0, 0),
('LD-0015', 3, 27, '12', '2022-07-17', '2022-07-19', 4, 's', 24000, 0, 0),
('LD-0016', 3, 27, '12', '2022-07-17', '2022-07-19', 4, 's', 24000, 0, 0),
('LD-0017', 3, 27, '12', '2022-07-17', '2022-07-19', 4, 's', 24000, 0, 0),
('LD-0018', 3, 27, '12', '2022-07-17', '2022-07-19', 4, 'w', 24000, 0, 0),
('LD-0019', 3, 27, '12', '2022-07-17', '2022-07-19', 12, 'w', 72000, 0, 0),
('LD-0020', 3, 27, '1', '2022-07-17', '2022-07-20', 4, 'r', 28000, 0, 0),
('LD-0021', 3, 27, '1', '2022-07-17', '2022-07-20', 10, 'j', 70000, 0, 0),
('LD-0022', 3, 27, '1', '2022-07-17', '2022-07-20', 5, 'w', 35000, 0, 0),
('LD-0023', 1, 27, '2', '2022-07-17', '2022-07-18', 2, 'asbin', 20000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `pelangganid` int(11) NOT NULL,
  `pelanggannama` varchar(150) NOT NULL,
  `pelangganjk` varchar(15) NOT NULL,
  `pelangganalamat` text NOT NULL,
  `pelanggantelp` varchar(20) NOT NULL,
  `pelangganfoto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`pelangganid`, `pelanggannama`, `pelangganjk`, `pelangganalamat`, `pelanggantelp`, `pelangganfoto`) VALUES
(1, 'Konsumen Umum', '', '', '', NULL),
(3, 'Mang mamang', 'Laki - laki', 'Olimpuck', '085233444541', '61da618d4343f.png'),
(5, 'Fandi Aziz Pratama', 'Laki - laki', 'bandar', '0895392518654', '61d9335273e98.png'),
(9, 'Rendi', 'Laki - laki', 'Solo', '086532187609', '61da61ef62df1.jpg'),
(10, 'Toni', 'Laki - laki', 'Jogja', '0987654332', '61dac09d9118d.jpg');

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
(1, 'KG', NULL, NULL, NULL),
(2, 'Mililiter (ML)', NULL, NULL, NULL),
(3, 'Gram', '/', '1000.000', 1),
(5, 'Liter', '*', '1000.000', 2);

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
(27, 'admin', '$2y$10$jHVWlsxaOWBLuudZYgl6nu.dwbTM64yPDqwtV9W0d1X3CFaoBUeSS', 'Yeni Yaradana Ahmed zuliadin', 'Laki - laki', 'New Giniea', '08953925199', '61da60dc3ce8b.jpg', 'admin'),
(28, 'fandiaz', '$2y$10$4sr89AaocI6DvBEF0jBfdeF3Q8/EY1/gwmLrodrSz1XUth.uJs3La', 'Fandi Aziz', 'Laki - laki', 'Bandardawung', '0895392518509', '61d844f1efc33.jpg', 'kasir'),
(31, 'Yuli', '$2y$10$R.KSk67SfxEwOm4B.nH9uegiyVyZmROF7/MSHYiuQ.9AmuZ3NU.aq', 'Yulianto', 'Laki - laki', 'Solo', '089654321', '61dad24785895.jpg', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bahan_baku`
--
ALTER TABLE `tb_bahan_baku`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`pelangganid`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `kd_jenis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_jenis_bahan`
--
ALTER TABLE `tb_jenis_bahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `pelangganid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_satuan`
--
ALTER TABLE `tb_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
