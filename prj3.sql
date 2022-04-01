-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2022 at 05:45 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `prj3`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `ten` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sdt` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `trang_thai` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `ten`, `email`, `sdt`, `pass`, `trang_thai`) VALUES
(1, 'admin', 'admin@gmail.com', 0, '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cham_cong`
--

CREATE TABLE `cham_cong` (
  `id` int(11) NOT NULL,
  `id_nhan_vien` int(11) NOT NULL,
  `ngay` date NOT NULL,
  `gio_vao` time NOT NULL,
  `gio_ra` time DEFAULT NULL,
  `tinh_trang` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cham_cong`
--

INSERT INTO `cham_cong` (`id`, `id_nhan_vien`, `ngay`, `gio_vao`, `gio_ra`, `tinh_trang`) VALUES
(1, 2, '2022-03-22', '06:55:47', '07:44:52', 1),
(2, 3, '2022-03-22', '07:52:23', '16:00:40', 1),
(4, 2, '2022-03-23', '08:14:03', '15:41:19', 1),
(5, 2, '2022-03-26', '12:00:46', '20:14:06', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chuc_vu`
--

CREATE TABLE `chuc_vu` (
  `id` int(11) NOT NULL,
  `ten_chuc_vu` varchar(255) NOT NULL,
  `luong_co_ban` int(11) NOT NULL,
  `trang_thai` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `chuc_vu`
--

INSERT INTO `chuc_vu` (`id`, `ten_chuc_vu`, `luong_co_ban`, `trang_thai`) VALUES
(1, 'aaa', 123123, 1),
(2, 'Trưởng phòng', 25000000, 1),
(3, 'okokokok', 1, 1),
(4, 'Test2', 13213, 1),
(5, 'helo', 123123123, 1),
(6, 'Test', 111111, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hop_dong_lao_dong`
--

CREATE TABLE `hop_dong_lao_dong` (
  `id_hd` int(11) NOT NULL,
  `id_nv` int(11) NOT NULL,
  `loai_hop_dong` varchar(255) NOT NULL,
  `id_chuc_vu` int(11) NOT NULL,
  `chi_nhanh` varchar(255) NOT NULL,
  `dia_diem` varchar(255) NOT NULL,
  `luong_co_ban` int(11) NOT NULL,
  `phu_cap` int(11) NOT NULL,
  `ngay_bat_dau` date NOT NULL,
  `ngay_ket_thuc` date NOT NULL,
  `trang_thai_hd` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `hop_dong_lao_dong`
--

INSERT INTO `hop_dong_lao_dong` (`id_hd`, `id_nv`, `loai_hop_dong`, `id_chuc_vu`, `chi_nhanh`, `dia_diem`, `luong_co_ban`, `phu_cap`, `ngay_bat_dau`, `ngay_ket_thuc`, `trang_thai_hd`) VALUES
(1, 2, 'tesst', 4, 'HN', 'TH', 1000000, 300000, '2022-08-03', '2022-01-04', 1),
(2, 3, 'tesst23', 5, 'HN', 'TH', 3000000, 100000, '2022-09-03', '2022-09-04', 1);

-- --------------------------------------------------------

--
-- Table structure for table `luong`
--

CREATE TABLE `luong` (
  `id_bl` int(11) NOT NULL,
  `nam` varchar(255) NOT NULL,
  `thang` varchar(255) NOT NULL,
  `id_nhan_vien` int(11) NOT NULL,
  `cong_chuan` int(11) NOT NULL,
  `cong_thuc_te` int(11) NOT NULL,
  `luong_co_ban` int(11) NOT NULL,
  `phu_cap` int(11) NOT NULL,
  `thuong` int(11) NOT NULL,
  `ung_truoc` int(11) NOT NULL,
  `phat_muon` int(11) NOT NULL,
  `tinh_trang` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `luong`
--

INSERT INTO `luong` (`id_bl`, `nam`, `thang`, `id_nhan_vien`, `cong_chuan`, `cong_thuc_te`, `luong_co_ban`, `phu_cap`, `thuong`, `ung_truoc`, `phat_muon`, `tinh_trang`) VALUES
(7, '2022', '04', 2, 24, 24, 1000000, 300000, 0, 0, 1, 1),
(8, '2022', '04', 3, 24, 24, 3000000, 100000, 0, 100000, 0, 1),
(11, '2022', '03', 2, 24, 3, 1000000, 200000, 300000, 0, 1, 2),
(12, '2022', '03', 3, 24, 1, 3000000, 100000, 0, 0, 0, 2),
(17, '2022', '02', 2, 24, 0, 1000000, 300000, 0, 0, 0, 2),
(18, '2022', '02', 3, 24, 0, 3000000, 100000, 0, 0, 0, 2),
(19, '2022', '05', 2, 24, 0, 1000000, 300000, 0, 0, 0, 1),
(20, '2022', '05', 3, 24, 0, 3000000, 100000, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `nhan_vien`
--

CREATE TABLE `nhan_vien` (
  `id` int(11) NOT NULL,
  `ma_nv` int(11) DEFAULT NULL,
  `ten_nv` varchar(255) DEFAULT NULL,
  `sdt_nv` varchar(11) DEFAULT NULL,
  `id_luong` int(11) DEFAULT NULL,
  `id_cham_cong` int(11) DEFAULT NULL,
  `id_dd_truy_cap` int(11) DEFAULT NULL,
  `trang_thai` int(11) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `gioi_tinh` tinyint(4) DEFAULT NULL,
  `que_quan` varchar(255) DEFAULT NULL,
  `quoc_tich` varchar(255) DEFAULT NULL,
  `dia_chi` varchar(255) DEFAULT NULL,
  `cmnd` varchar(255) DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `hoc_van` varchar(255) DEFAULT NULL,
  `ten_tk` varchar(255) DEFAULT NULL,
  `mat_khau` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `nhan_vien`
--

INSERT INTO `nhan_vien` (`id`, `ma_nv`, `ten_nv`, `sdt_nv`, `id_luong`, `id_cham_cong`, `id_dd_truy_cap`, `trang_thai`, `ngay_sinh`, `gioi_tinh`, `que_quan`, `quoc_tich`, `dia_chi`, `cmnd`, `anh`, `email`, `hoc_van`, `ten_tk`, `mat_khau`) VALUES
(1, NULL, 'admin', NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', '1'),
(2, 12, 'Đinh Đại Phát', '0348935101', NULL, NULL, 1, 1, '2001-08-01', 1, 'HN', 'VN', 'TH', '001201004041', NULL, 'vkl704531@gmail.comm', NULL, 'phat', '1'),
(3, 123, 'Nữ', '0357895252', NULL, NULL, 2, 1, '2001-09-01', 2, 'HN', 'VN', 'TH', '003565998745', NULL, 'nu@gmail.com', NULL, 'nu', '1');

-- --------------------------------------------------------

--
-- Table structure for table `truy_cap`
--

CREATE TABLE `truy_cap` (
  `id` int(11) NOT NULL,
  `ten_dia_diem` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `trang_thai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `truy_cap`
--

INSERT INTO `truy_cap` (`id`, `ten_dia_diem`, `ip`, `trang_thai`) VALUES
(1, 'Local', '127.0.0.1', 1),
(2, 'Local2', '0.1.1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cham_cong`
--
ALTER TABLE `cham_cong`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chuc_vu`
--
ALTER TABLE `chuc_vu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hop_dong_lao_dong`
--
ALTER TABLE `hop_dong_lao_dong`
  ADD PRIMARY KEY (`id_hd`),
  ADD KEY `id_chuc_vu` (`id_chuc_vu`),
  ADD KEY `id_nv` (`id_nv`);

--
-- Indexes for table `luong`
--
ALTER TABLE `luong`
  ADD PRIMARY KEY (`id_bl`);

--
-- Indexes for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ma_nv` (`ma_nv`),
  ADD KEY `id_dd_truy_cap` (`id_dd_truy_cap`),
  ADD KEY `id_luong` (`id_luong`),
  ADD KEY `id_cham_cong` (`id_cham_cong`);

--
-- Indexes for table `truy_cap`
--
ALTER TABLE `truy_cap`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cham_cong`
--
ALTER TABLE `cham_cong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chuc_vu`
--
ALTER TABLE `chuc_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `hop_dong_lao_dong`
--
ALTER TABLE `hop_dong_lao_dong`
  MODIFY `id_hd` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `luong`
--
ALTER TABLE `luong`
  MODIFY `id_bl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `truy_cap`
--
ALTER TABLE `truy_cap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hop_dong_lao_dong`
--
ALTER TABLE `hop_dong_lao_dong`
  ADD CONSTRAINT `hop_dong_lao_dong_ibfk_1` FOREIGN KEY (`id_chuc_vu`) REFERENCES `chuc_vu` (`id`),
  ADD CONSTRAINT `hop_dong_lao_dong_ibfk_2` FOREIGN KEY (`id_nv`) REFERENCES `nhan_vien` (`id`);

--
-- Constraints for table `nhan_vien`
--
ALTER TABLE `nhan_vien`
  ADD CONSTRAINT `nhan_vien_ibfk_1` FOREIGN KEY (`id_dd_truy_cap`) REFERENCES `truy_cap` (`id`),
  ADD CONSTRAINT `nhan_vien_ibfk_5` FOREIGN KEY (`id_luong`) REFERENCES `luong` (`id_bl`),
  ADD CONSTRAINT `nhan_vien_ibfk_6` FOREIGN KEY (`id_cham_cong`) REFERENCES `cham_cong` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
