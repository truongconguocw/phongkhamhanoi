-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2025 at 10:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doan1`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

CREATE TABLE `auth_tokens` (
  `TokenID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Selector` varchar(255) NOT NULL,
  `ValidatorHash` varchar(255) NOT NULL,
  `ExpiresAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bacsi`
--

CREATE TABLE `bacsi` (
  `BacSiID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ChuyenKhoaID` int(11) DEFAULT NULL,
  `MoTa` text DEFAULT NULL,
  `KinhNghiem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bacsi`
--

INSERT INTO `bacsi` (`BacSiID`, `UserID`, `ChuyenKhoaID`, `MoTa`, `KinhNghiem`) VALUES
(1, 2, 5, '', '10 năm kinh nghiệm trong lĩnh vực Tim mạch'),
(2, 1, 27, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `benhnhan`
--

CREATE TABLE `benhnhan` (
  `BenhNhanID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `HoTen` varchar(100) NOT NULL,
  `NgaySinh` date DEFAULT NULL,
  `GioiTinh` enum('Nam','Nữ','Khác') DEFAULT NULL,
  `SoDienThoai` varchar(15) NOT NULL,
  `DiaChi` varchar(255) DEFAULT NULL,
  `NgayTaoHoSo` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `benhnhan`
--

INSERT INTO `benhnhan` (`BenhNhanID`, `UserID`, `HoTen`, `NgaySinh`, `GioiTinh`, `SoDienThoai`, `DiaChi`, `NgayTaoHoSo`) VALUES
(1, 2, 'Trương Công Ước', NULL, NULL, '0333876785', NULL, '2025-07-05 11:31:09'),
(2, 4, 'benh nhan', '1999-07-22', 'Nữ', '0123456789', 'Giáp Bát, Hà Nội', '2025-07-05 12:13:58'),
(3, 5, 'Admin', NULL, NULL, '0346861035', NULL, '2025-07-06 14:04:13'),
(4, 6, 'Nguyễn Văn A', '2008-06-04', 'Nam', '0346861036', NULL, '2025-07-06 17:37:39'),
(5, NULL, 'Nguyễn Thị A', '2006-11-23', 'Nữ', '0346861037', NULL, '2025-07-06 21:09:00'),
(6, 8, 'Phạm Thị Bích Ngọc', '1990-05-15', 'Nữ', '0912000001', 'Thanh Xuân, Hà Nội', '2025-06-01 08:00:00'),
(7, 9, 'Nguyễn Văn B', '1985-12-21', 'Nam', '0912000002', 'Hoàng Mai, Hà Nội', '2025-06-02 09:00:00'),
(8, 10, 'Lê Thị C', '1992-03-09', 'Nữ', '0912000003', 'Đống Đa, Hà Nội', '2025-06-03 10:00:00'),
(9, 11, 'Trần Anh Dũng', '2000-07-10', 'Nam', '0912000004', 'Cầu Giấy, Hà Nội', '2025-06-04 11:00:00'),
(10, 12, 'Đặng Thị Lan', '1978-09-25', 'Nữ', '0912000005', 'Hai Bà Trưng, Hà Nội', '2025-06-05 12:00:00'),
(11, 13, 'Lê Văn Tùng', '1995-01-30', 'Nam', '0912000006', 'Long Biên, Hà Nội', '2025-06-06 13:00:00'),
(12, 14, 'Hoàng Thị Mai', '1988-11-18', 'Nữ', '0912000007', 'Hà Đông, Hà Nội', '2025-06-07 14:00:00'),
(13, 15, 'Ngô Văn Huy', '1970-06-12', 'Nam', '0912000008', 'Tây Hồ, Hà Nội', '2025-06-08 15:00:00'),
(14, 16, 'Bùi Thị Hoa', '1993-10-05', 'Nữ', '0912000009', 'Ba Đình, Hà Nội', '2025-06-09 08:30:00'),
(15, 17, 'Đỗ Văn Nam', '1999-02-14', 'Nam', '0912000010', 'Nam Từ Liêm, Hà Nội', '2025-06-10 09:30:00'),
(16, 18, 'Nguyễn Thị Hường', '2001-08-20', 'Nữ', '0912000011', 'Bắc Từ Liêm, Hà Nội', '2025-06-11 10:30:00'),
(17, 19, 'Lê Minh Tâm', '1987-04-11', 'Nam', '0912000012', 'Thạch Thất, Hà Nội', '2025-06-12 11:30:00'),
(18, 20, 'Trần Thị Tuyết', '1984-12-08', 'Nữ', '0912000013', 'Chương Mỹ, Hà Nội', '2025-06-13 12:30:00'),
(19, 21, 'Nguyễn Đức Huy', '1996-07-19', 'Nam', '0912000014', 'Sơn Tây, Hà Nội', '2025-06-14 13:30:00'),
(20, 22, 'Phạm Thị Hòa', '1975-03-02', 'Nữ', '0912000015', 'Phúc Thọ, Hà Nội', '2025-06-15 14:30:00'),
(21, 23, 'Đinh Văn Phúc', '1983-10-22', 'Nam', '0912000016', 'Ba Vì, Hà Nội', '2025-06-16 15:30:00'),
(22, 24, 'Vũ Thị Hằng', '1991-09-12', 'Nữ', '0912000017', 'Thường Tín, Hà Nội', '2025-06-17 08:45:00'),
(23, 25, 'Hoàng Văn Duy', '1997-05-03', 'Nam', '0912000018', '', '2025-06-18 09:45:00'),
(24, 26, 'Nguyễn Thị Thắm', '1994-11-29', 'Nữ', '0912000019', 'Gia Lâm, Hà Nội', '2025-06-19 10:45:00'),
(25, 27, 'Phạm Văn Hòa', '1989-06-17', 'Nam', '0912000020', 'Mê Linh, Hà Nội', '2025-06-20 11:45:00'),
(26, 28, 'Trần Thị Minh', '1998-01-25', 'Nữ', '0912000021', 'Sóc Sơn, Hà Nội', '2025-06-21 12:45:00'),
(27, 29, 'Ngô Văn Phong', '1986-08-14', 'Nam', '0912000022', 'Đông Anh, Hà Nội', '2025-06-22 13:45:00'),
(28, 30, 'Bùi Thị Xuân', '2002-02-06', 'Nữ', '0912000023', 'Hoàn Kiếm, Hà Nội', '2025-06-23 14:45:00'),
(29, 31, 'Vũ Văn Thanh', '1979-07-28', 'Nam', '0912000024', 'Ứng Hòa, Hà Nội', '2025-06-24 15:45:00'),
(30, 32, 'Lý Thị Ngân', '1990-04-16', 'Nữ', '0912000025', 'Thanh Oai, Hà Nội', '2025-06-25 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `chitietdichvukham`
--

CREATE TABLE `chitietdichvukham` (
  `ChiTietID` int(11) NOT NULL,
  `LichKhamID` int(11) NOT NULL,
  `DichVuID` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL DEFAULT 1,
  `DonGiaTaiThoiDiem` decimal(15,2) NOT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chuyenkhoa`
--

CREATE TABLE `chuyenkhoa` (
  `ChuyenKhoaID` int(11) NOT NULL,
  `TenChuyenKhoa` varchar(100) NOT NULL,
  `MoTa` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chuyenkhoa`
--

INSERT INTO `chuyenkhoa` (`ChuyenKhoaID`, `TenChuyenKhoa`, `MoTa`) VALUES
(1, 'Nội tổng quát', 'Chẩn đoán và điều trị các bệnh nội khoa tổng quát.'),
(2, 'Ngoại tổng quát', 'Phẫu thuật điều trị các bệnh ngoại khoa phổ biến.'),
(3, 'Nhi khoa', 'Khám và điều trị bệnh lý trẻ em.'),
(4, 'Sản phụ khoa', 'Chăm sóc sức khỏe phụ nữ, thai sản.'),
(5, 'Tim mạch', 'Chẩn đoán và điều trị các bệnh tim mạch.'),
(6, 'Da liễu', 'Điều trị các bệnh về da và thẩm mỹ da.'),
(7, 'Tai Mũi Họng', 'Khám và điều trị các bệnh tai, mũi, họng.'),
(8, 'Răng Hàm Mặt', 'Chăm sóc răng miệng và phẫu thuật hàm mặt.'),
(9, 'Mắt', 'Khám và điều trị các bệnh về mắt.'),
(10, 'Thần kinh', 'Khám và điều trị các bệnh lý thần kinh.'),
(11, 'Ung bướu', 'Chẩn đoán và điều trị ung thư, khối u.'),
(12, 'Hô hấp', 'Khám và điều trị bệnh lý phổi và hô hấp.'),
(13, 'Tiêu hóa', 'Khám và điều trị bệnh dạ dày, ruột và gan.'),
(14, 'Thận - Tiết niệu', 'Điều trị bệnh thận và đường tiết niệu.'),
(15, 'Nội tiết', 'Chẩn đoán và điều trị bệnh lý nội tiết như tiểu đường.'),
(16, 'Chấn thương chỉnh hình', 'Phẫu thuật và điều trị xương khớp, chấn thương.'),
(17, 'Phục hồi chức năng', 'Hỗ trợ hồi phục chức năng vận động.'),
(18, 'Huyết học', 'Chẩn đoán và điều trị bệnh máu.'),
(19, 'Dinh dưỡng', 'Tư vấn chế độ ăn và dinh dưỡng.'),
(20, 'Nội soi', 'Dịch vụ nội soi tiêu hóa và hô hấp.'),
(21, 'Lão khoa', 'Khám và chăm sóc sức khỏe người cao tuổi.'),
(22, 'Tâm thần', 'Chẩn đoán và điều trị rối loạn tâm thần.'),
(23, 'Miễn dịch - Dị ứng', 'Chẩn đoán và điều trị dị ứng và rối loạn miễn dịch.'),
(24, 'Phong - Da liễu', 'Điều trị bệnh da liễu và bệnh phong.'),
(25, 'Hồi sức cấp cứu', 'Cấp cứu và chăm sóc bệnh nhân nặng.'),
(26, 'Gây mê hồi sức', 'Hỗ trợ gây mê và hồi tỉnh sau phẫu thuật.'),
(27, 'Chẩn đoán hình ảnh', 'Chụp X-quang, MRI, CT.'),
(28, 'Xét nghiệm y học', 'Phòng xét nghiệm y học lâm sàng.'),
(29, 'Y học cổ truyền', 'Điều trị bằng thuốc Nam, châm cứu.'),
(30, 'Sức khỏe sinh sản', 'Tư vấn và chăm sóc sức khỏe sinh sản.');

-- --------------------------------------------------------

--
-- Table structure for table `danhmucdichvu`
--

CREATE TABLE `danhmucdichvu` (
  `DichVuID` int(11) NOT NULL,
  `TenDichVu` varchar(255) NOT NULL,
  `MoTa` text DEFAULT NULL,
  `DonGia` decimal(15,2) NOT NULL DEFAULT 0.00,
  `HoatDong` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `danhmucthuoc`
--

CREATE TABLE `danhmucthuoc` (
  `ThuocID` int(11) NOT NULL,
  `TenThuoc` varchar(255) NOT NULL,
  `HoatChat` varchar(255) DEFAULT NULL,
  `DonViTinh` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `danhmucthuoc`
--

INSERT INTO `danhmucthuoc` (`ThuocID`, `TenThuoc`, `HoatChat`, `DonViTinh`) VALUES
(1, 'Paracetamol 500mg', 'Paracetamol', 'Viên'),
(2, 'Amoxicillin 500mg', 'Amoxicillin', 'Viên'),
(3, 'Ibuprofen 400mg', 'Ibuprofen', 'Viên'),
(4, 'Cefixime 100mg', 'Cefixime', 'Viên'),
(5, 'Vitamin C 500mg', 'Acid Ascorbic', 'Viên'),
(6, 'Clorpheniramin 4mg', 'Chlorpheniramine', 'Viên'),
(7, 'Omeprazole 20mg', 'Omeprazole', 'Viên'),
(8, 'Metformin 500mg', 'Metformin', 'Viên'),
(9, 'Amlodipine 5mg', 'Amlodipine', 'Viên'),
(10, 'Losartan 50mg', 'Losartan', 'Viên'),
(11, 'Furosemide 40mg', 'Furosemide', 'Viên'),
(12, 'Enalapril 10mg', 'Enalapril', 'Viên'),
(13, 'Simvastatin 20mg', 'Simvastatin', 'Viên'),
(14, 'Atorvastatin 10mg', 'Atorvastatin', 'Viên'),
(15, 'Prednisolone 5mg', 'Prednisolone', 'Viên'),
(16, 'Dexamethasone 0.5mg', 'Dexamethasone', 'Viên'),
(17, 'Azithromycin 250mg', 'Azithromycin', 'Viên'),
(18, 'Ciprofloxacin 500mg', 'Ciprofloxacin', 'Viên'),
(19, 'Clindamycin 300mg', 'Clindamycin', 'Viên'),
(20, 'Loperamide 2mg', 'Loperamide', 'Viên'),
(21, 'Salbutamol 2mg', 'Salbutamol', 'Viên'),
(22, 'Cetirizine 10mg', 'Cetirizine', 'Viên'),
(23, 'Loratadine 10mg', 'Loratadine', 'Viên'),
(24, 'Ranitidine 150mg', 'Ranitidine', 'Viên'),
(25, 'Pantoprazole 40mg', 'Pantoprazole', 'Viên'),
(26, 'Esomeprazole 20mg', 'Esomeprazole', 'Viên'),
(27, 'Alprazolam 0.5mg', 'Alprazolam', 'Viên'),
(28, 'Diazepam 5mg', 'Diazepam', 'Viên'),
(29, 'Domperidone 10mg', 'Domperidone', 'Viên'),
(30, 'Spiramycin 3MIU', 'Spiramycin', 'Viên'),
(31, 'Rifampicin 300mg', 'Rifampicin', 'Viên'),
(32, 'Isoniazid 300mg', 'Isoniazid', 'Viên'),
(33, 'Pyrazinamide 500mg', 'Pyrazinamide', 'Viên'),
(34, 'Ethambutol 400mg', 'Ethambutol', 'Viên'),
(35, 'Methotrexate 2.5mg', 'Methotrexate', 'Viên'),
(36, 'Allopurinol 100mg', 'Allopurinol', 'Viên'),
(37, 'Colchicine 0.5mg', 'Colchicine', 'Viên'),
(38, 'Levothyroxine 50mcg', 'Levothyroxine', 'Viên'),
(39, 'Carbimazole 5mg', 'Carbimazole', 'Viên'),
(40, 'Glimepiride 2mg', 'Glimepiride', 'Viên'),
(41, 'Gliclazide 30mg', 'Gliclazide', 'Viên'),
(42, 'Pioglitazone 15mg', 'Pioglitazone', 'Viên'),
(43, 'Sitagliptin 50mg', 'Sitagliptin', 'Viên'),
(44, 'Linagliptin 5mg', 'Linagliptin', 'Viên'),
(45, 'Bisoprolol 5mg', 'Bisoprolol', 'Viên'),
(46, 'Metoprolol 50mg', 'Metoprolol', 'Viên'),
(47, 'Propranolol 40mg', 'Propranolol', 'Viên'),
(48, 'Verapamil 80mg', 'Verapamil', 'Viên'),
(49, 'Diltiazem 60mg', 'Diltiazem', 'Viên'),
(50, 'Nitroglycerin 2.6mg', 'Nitroglycerin', 'Viên'),
(51, 'Warfarin 2mg', 'Warfarin', 'Viên'),
(52, 'Aspirin 81mg', 'Acetylsalicylic Acid', 'Viên'),
(53, 'Clopidogrel 75mg', 'Clopidogrel', 'Viên'),
(54, 'Dabigatran 110mg', 'Dabigatran', 'Viên'),
(55, 'Rivaroxaban 10mg', 'Rivaroxaban', 'Viên'),
(56, 'Apixaban 5mg', 'Apixaban', 'Viên'),
(57, 'Rosuvastatin 10mg', 'Rosuvastatin', 'Viên'),
(58, 'Hydrochlorothiazide 25mg', 'Hydrochlorothiazide', 'Viên'),
(59, 'Spironolactone 25mg', 'Spironolactone', 'Viên'),
(60, 'Indapamide 1.5mg', 'Indapamide', 'Viên'),
(61, 'Telmisartan 40mg', 'Telmisartan', 'Viên'),
(62, 'Valsartan 80mg', 'Valsartan', 'Viên'),
(63, 'Olmesartan 20mg', 'Olmesartan', 'Viên'),
(64, 'Ramipril 5mg', 'Ramipril', 'Viên'),
(65, 'Perindopril 4mg', 'Perindopril', 'Viên'),
(66, 'Candesartan 8mg', 'Candesartan', 'Viên'),
(67, 'Irbesartan 150mg', 'Irbesartan', 'Viên'),
(68, 'Trimetazidine 20mg', 'Trimetazidine', 'Viên'),
(69, 'Ivabradine 5mg', 'Ivabradine', 'Viên'),
(70, 'Digoxin 0.25mg', 'Digoxin', 'Viên'),
(71, 'Folic Acid 5mg', 'Folic Acid', 'Viên'),
(72, 'Ferrous Sulfate 200mg', 'Ferrous Sulfate', 'Viên'),
(73, 'Cyanocobalamin 500mcg', 'Vitamin B12', 'Viên'),
(74, 'Thiamine 100mg', 'Vitamin B1', 'Viên'),
(75, 'Pyridoxine 50mg', 'Vitamin B6', 'Viên'),
(76, 'Calcium Carbonate 500mg', 'Calcium Carbonate', 'Viên'),
(77, 'Cholecalciferol 1000IU', 'Vitamin D3', 'Viên'),
(78, 'Magnesium Oxide 250mg', 'Magnesium Oxide', 'Viên'),
(79, 'Zinc Sulfate 50mg', 'Zinc Sulfate', 'Viên'),
(80, 'Ascorbic Acid 500mg', 'Vitamin C', 'Viên'),
(81, 'Alpha Tocopherol 400IU', 'Vitamin E', 'Viên'),
(82, 'Riboflavin 10mg', 'Vitamin B2', 'Viên'),
(83, 'Nicotinamide 100mg', 'Vitamin B3', 'Viên'),
(84, 'Biotin 500mcg', 'Biotin', 'Viên'),
(85, 'Pantothenic Acid 100mg', 'Vitamin B5', 'Viên'),
(86, 'Levocetirizine 5mg', 'Levocetirizine', 'Viên'),
(87, 'Montelukast 10mg', 'Montelukast', 'Viên'),
(88, 'Ketotifen 1mg', 'Ketotifen', 'Viên'),
(89, 'Mebendazole 500mg', 'Mebendazole', 'Viên'),
(90, 'Albendazole 400mg', 'Albendazole', 'Viên'),
(91, 'Doxycycline 100mg', 'Doxycycline', 'Viên'),
(92, 'Minocycline 100mg', 'Minocycline', 'Viên'),
(93, 'Erythromycin 250mg', 'Erythromycin', 'Viên'),
(94, 'Levofloxacin 500mg', 'Levofloxacin', 'Viên'),
(95, 'Moxifloxacin 400mg', 'Moxifloxacin', 'Viên'),
(96, 'Linezolid 600mg', 'Linezolid', 'Viên'),
(97, 'Vancomycin 500mg', 'Vancomycin', 'Viên'),
(98, 'Meropenem 500mg', 'Meropenem', 'Viên'),
(99, 'Imipenem 500mg', 'Imipenem', 'Viên'),
(100, 'Ceftriaxone 1g', 'Ceftriaxone', 'Viên');

-- --------------------------------------------------------

--
-- Table structure for table `donthuoc`
--

CREATE TABLE `donthuoc` (
  `DonThuocID` int(11) NOT NULL,
  `LichKhamID` int(11) NOT NULL,
  `ThuocID` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `HuongDanSuDung` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `donthuoc`
--

INSERT INTO `donthuoc` (`DonThuocID`, `LichKhamID`, `ThuocID`, `SoLuong`, `HuongDanSuDung`) VALUES
(1, 5, 48, 5, 'uống sau ăn sáng'),
(2, 5, 52, 20, 'uống sau ăn trưa'),
(3, 5, 84, 10, 'uống sau ăn tối'),
(4, 4, 76, 100, ''),
(5, 1, 17, 50, ''),
(6, 3, 17, 50, '');

-- --------------------------------------------------------

--
-- Table structure for table `lichkham`
--

CREATE TABLE `lichkham` (
  `LichKhamID` int(11) NOT NULL,
  `BacSiID` int(11) NOT NULL,
  `BenhNhanID` int(11) NOT NULL,
  `ThoiGianKham` datetime NOT NULL,
  `TrangThai` enum('ChoXacNhan','DaXacNhan','DaHoanThanh','DaHuy') NOT NULL DEFAULT 'ChoXacNhan',
  `LyDoKham` text DEFAULT NULL,
  `GhiChuCuaBacSi` text DEFAULT NULL,
  `NgayDatLich` datetime DEFAULT current_timestamp(),
  `TrieuChung` text DEFAULT NULL,
  `ChuanDoan` text DEFAULT NULL,
  `PhacDoDieuTri` text DEFAULT NULL,
  `LoiDanKeDon` text DEFAULT NULL,
  `NgayTaiKham` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichkham`
--

INSERT INTO `lichkham` (`LichKhamID`, `BacSiID`, `BenhNhanID`, `ThoiGianKham`, `TrangThai`, `LyDoKham`, `GhiChuCuaBacSi`, `NgayDatLich`, `TrieuChung`, `ChuanDoan`, `PhacDoDieuTri`, `LoiDanKeDon`, `NgayTaiKham`) VALUES
(1, 1, 2, '2025-07-06 08:00:00', 'DaHoanThanh', 'Khám tổng quát', '', '2025-07-05 22:15:30', 'Mệt mỏi nhẹ', 'Bình thường', '', NULL, '2025-07-24'),
(2, 1, 2, '2025-07-07 09:30:00', 'ChoXacNhan', 'Khám tim mạch', NULL, '2025-07-05 22:15:30', 'Đau ngực, hồi hộp', NULL, NULL, NULL, NULL),
(3, 1, 2, '2025-07-08 14:00:00', 'DaHoanThanh', 'Khám da liễu', '', '2025-07-05 22:15:30', 'Nổi mẩn đỏ', 'Bình thường\r\n', '', NULL, NULL),
(4, 1, 2, '2025-07-09 10:15:00', 'DaHoanThanh', 'Khám tiêu hóa', '', '2025-07-05 22:15:30', 'Đau bụng âm ỉ', 'Bình thường', '', NULL, '2025-07-10'),
(5, 1, 2, '2025-07-10 16:00:00', 'DaHoanThanh', 'Khám mắt', 'Không bỏ lượt uống', '2025-07-05 22:15:30', 'Nhìn mờ, chảy nước mắt', '', '', NULL, '2025-07-31'),
(6, 1, 2, '2025-07-07 15:00:00', 'ChoXacNhan', 'Kiểm tra tổng quát', NULL, '2025-07-06 12:55:34', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `lichlamviec`
--

CREATE TABLE `lichlamviec` (
  `LichLamViecID` int(11) NOT NULL,
  `BacSiID` int(11) NOT NULL,
  `NgayTrongTuan` int(11) NOT NULL COMMENT '0: Chủ Nhật, 1: Thứ Hai, ..., 6: Thứ Bảy',
  `GioBatDau` time NOT NULL,
  `GioKetThuc` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lichlamviec`
--

INSERT INTO `lichlamviec` (`LichLamViecID`, `BacSiID`, `NgayTrongTuan`, `GioBatDau`, `GioKetThuc`) VALUES
(0, 1, 1, '07:00:00', '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `UserID` int(11) NOT NULL,
  `HoTen` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `MatKhau` varchar(255) NOT NULL,
  `SoDienThoai` varchar(15) DEFAULT NULL,
  `VaiTro` enum('BacSi','BenhNhan','QuanTri') NOT NULL DEFAULT 'BenhNhan',
  `NgayTao` datetime DEFAULT current_timestamp(),
  `HoatDong` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`UserID`, `HoTen`, `Email`, `MatKhau`, `SoDienThoai`, `VaiTro`, `NgayTao`, `HoatDong`) VALUES
(1, 'nhom2', 'nhom2@gmail.com', '$2y$10$4CVJGTmr6r9U387D7tSnF.8I9suQb/tgQ0P7bYpkdjSPeyBUeVMXC', '0346861038', 'BacSi', '2025-07-05 10:28:12', 1),
(2, 'Trương Công Ước', 'truongconguoc89@gmail.com', '$2y$10$lyYqC0W6IHEXONURattGJOCrfZyZ/Hw2EffALVD4rQO24JWtUUBL.', '0333876785', 'BacSi', '2025-07-05 11:31:09', 1),
(4, 'benh nhan', 'benhnhan1@gmail.com', '$2y$10$XpfBOl5IXYxp3WgdL1K6EuTgKtRiLWh/7oC2GK52H3CTOhxZVXWy6', '0123456789', 'BenhNhan', '2025-07-05 12:13:58', 1),
(5, 'Admin', 'admin@gmail.com', '$2y$10$V9PHfB0AiYe0NUYsG8qWBeFYGyRryxCrD8eDVq6EyeZkFjp09FKR6', '0346861035', 'QuanTri', '2025-07-06 14:04:13', 1),
(6, 'Nguyễn Văn A', 'nguyenvana@gmail.com', '$2y$10$q9XgrZIY1bjVhL8XcrilN.oJYlLnifaX.CbCsOEiqRiiu1dJCLT.S', '0346861036', 'BenhNhan', '2025-07-06 17:37:39', 1),
(8, 'Phạm Thị Bích Ngọc', 'user8@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000001', 'BenhNhan', '2025-06-01 00:00:00', 1),
(9, 'Nguyễn Văn B', 'user9@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000002', 'BenhNhan', '2025-06-02 00:00:00', 1),
(10, 'Lê Thị C', 'user10@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000003', 'BenhNhan', '2025-06-03 00:00:00', 1),
(11, 'Trần Anh Dũng', 'user11@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000004', 'BenhNhan', '2025-06-04 00:00:00', 1),
(12, 'Đặng Thị Lan', 'user12@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000005', 'BenhNhan', '2025-06-05 00:00:00', 1),
(13, 'Lê Văn Tùng', 'user13@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000006', 'BenhNhan', '2025-06-06 00:00:00', 1),
(14, 'Hoàng Thị Mai', 'user14@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000007', 'BenhNhan', '2025-06-07 00:00:00', 1),
(15, 'Ngô Văn Huy', 'user15@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000008', 'BenhNhan', '2025-06-08 00:00:00', 1),
(16, 'Bùi Thị Hoa', 'user16@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000009', 'BenhNhan', '2025-06-09 00:00:00', 1),
(17, 'Đỗ Văn Nam', 'user17@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000010', 'BenhNhan', '2025-06-10 00:00:00', 1),
(18, 'Nguyễn Thị Hường', 'user18@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000011', 'BenhNhan', '2025-06-11 00:00:00', 1),
(19, 'Lê Minh Tâm', 'user19@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000012', 'BenhNhan', '2025-06-12 00:00:00', 1),
(20, 'Trần Thị Tuyết', 'user20@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000013', 'BenhNhan', '2025-06-13 00:00:00', 1),
(21, 'Nguyễn Đức Huy', 'user21@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000014', 'BenhNhan', '2025-06-14 00:00:00', 1),
(22, 'Phạm Thị Hòa', 'user22@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000015', 'BenhNhan', '2025-06-15 00:00:00', 1),
(23, 'Đinh Văn Phúc', 'user23@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000016', 'BenhNhan', '2025-06-16 00:00:00', 1),
(24, 'Vũ Thị Hằng', 'user24@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000017', 'BenhNhan', '2025-06-17 00:00:00', 1),
(25, 'Hoàng Văn Duy', 'user25@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000018', 'BenhNhan', '2025-06-18 00:00:00', 1),
(26, 'Nguyễn Thị Thắm', 'user26@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000019', 'BenhNhan', '2025-06-19 00:00:00', 1),
(27, 'Phạm Văn Hòa', 'user27@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000020', 'BenhNhan', '2025-06-20 00:00:00', 1),
(28, 'Trần Thị Minh', 'user28@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000021', 'BenhNhan', '2025-06-21 00:00:00', 1),
(29, 'Ngô Văn Phong', 'user29@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000022', 'BenhNhan', '2025-06-22 00:00:00', 1),
(30, 'Bùi Thị Xuân', 'user30@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000023', 'BenhNhan', '2025-06-23 00:00:00', 1),
(31, 'Vũ Văn Thanh', 'user31@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000024', 'BenhNhan', '2025-06-24 00:00:00', 1),
(32, 'Lý Thị Ngân', 'user32@gmail.com', '$2y$10$u1A2iQm4gTWhrM3rKeT.N.rKN.d3puUgxwzJkR5MKoEdfGSyy41HO', '0912000025', 'BenhNhan', '2025-06-25 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `thongtinsuckhoe`
--

CREATE TABLE `thongtinsuckhoe` (
  `ThongTinID` int(11) NOT NULL,
  `BenhNhanID` int(11) NOT NULL,
  `Loai` enum('Tiền sử bệnh','Dị ứng','Phẫu thuật') NOT NULL,
  `MoTa` varchar(255) NOT NULL,
  `GhiChu` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `thongtinsuckhoe`
--

INSERT INTO `thongtinsuckhoe` (`ThongTinID`, `BenhNhanID`, `Loai`, `MoTa`, `GhiChu`) VALUES
(1, 2, 'Tiền sử bệnh', 'Dị ứng với penicillin, Đã phẫu thuật ruột thừ năm 2010', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD PRIMARY KEY (`TokenID`),
  ADD UNIQUE KEY `Selector` (`Selector`),
  ADD KEY `fk_authtokens_user_idx` (`UserID`);

--
-- Indexes for table `bacsi`
--
ALTER TABLE `bacsi`
  ADD PRIMARY KEY (`BacSiID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD KEY `ChuyenKhoaID` (`ChuyenKhoaID`);

--
-- Indexes for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD PRIMARY KEY (`BenhNhanID`),
  ADD UNIQUE KEY `UserID` (`UserID`),
  ADD KEY `idx_benhnhan_sdt` (`SoDienThoai`);

--
-- Indexes for table `chitietdichvukham`
--
ALTER TABLE `chitietdichvukham`
  ADD PRIMARY KEY (`ChiTietID`),
  ADD KEY `fk_chitietdv_lichkham_idx` (`LichKhamID`),
  ADD KEY `fk_chitietdv_danhmuc_idx` (`DichVuID`);

--
-- Indexes for table `chuyenkhoa`
--
ALTER TABLE `chuyenkhoa`
  ADD PRIMARY KEY (`ChuyenKhoaID`),
  ADD UNIQUE KEY `TenChuyenKhoa` (`TenChuyenKhoa`);

--
-- Indexes for table `danhmucdichvu`
--
ALTER TABLE `danhmucdichvu`
  ADD PRIMARY KEY (`DichVuID`),
  ADD UNIQUE KEY `TenDichVu_UNIQUE` (`TenDichVu`);

--
-- Indexes for table `danhmucthuoc`
--
ALTER TABLE `danhmucthuoc`
  ADD PRIMARY KEY (`ThuocID`),
  ADD UNIQUE KEY `TenThuoc_UNIQUE` (`TenThuoc`);

--
-- Indexes for table `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD PRIMARY KEY (`DonThuocID`),
  ADD KEY `fk_donthuoc_lichkham_idx` (`LichKhamID`),
  ADD KEY `fk_donthuoc_danhmuc_idx` (`ThuocID`);

--
-- Indexes for table `lichkham`
--
ALTER TABLE `lichkham`
  ADD PRIMARY KEY (`LichKhamID`),
  ADD KEY `idx_lichkham_bacsi_thoigian` (`BacSiID`,`ThoiGianKham`),
  ADD KEY `idx_lichkham_benhnhan_thoigian` (`BenhNhanID`,`ThoiGianKham`);

--
-- Indexes for table `lichlamviec`
--
ALTER TABLE `lichlamviec`
  ADD UNIQUE KEY `unique_schedule` (`BacSiID`,`NgayTrongTuan`,`GioBatDau`);

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `SoDienThoai` (`SoDienThoai`);

--
-- Indexes for table `thongtinsuckhoe`
--
ALTER TABLE `thongtinsuckhoe`
  ADD PRIMARY KEY (`ThongTinID`),
  ADD KEY `BenhNhanID` (`BenhNhanID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  MODIFY `TokenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bacsi`
--
ALTER TABLE `bacsi`
  MODIFY `BacSiID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `benhnhan`
--
ALTER TABLE `benhnhan`
  MODIFY `BenhNhanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `chitietdichvukham`
--
ALTER TABLE `chitietdichvukham`
  MODIFY `ChiTietID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chuyenkhoa`
--
ALTER TABLE `chuyenkhoa`
  MODIFY `ChuyenKhoaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `danhmucdichvu`
--
ALTER TABLE `danhmucdichvu`
  MODIFY `DichVuID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `danhmucthuoc`
--
ALTER TABLE `danhmucthuoc`
  MODIFY `ThuocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `donthuoc`
--
ALTER TABLE `donthuoc`
  MODIFY `DonThuocID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `lichkham`
--
ALTER TABLE `lichkham`
  MODIFY `LichKhamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `thongtinsuckhoe`
--
ALTER TABLE `thongtinsuckhoe`
  MODIFY `ThongTinID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_tokens`
--
ALTER TABLE `auth_tokens`
  ADD CONSTRAINT `fk_authtokens_user` FOREIGN KEY (`UserID`) REFERENCES `nguoidung` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `bacsi`
--
ALTER TABLE `bacsi`
  ADD CONSTRAINT `bacsi_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `nguoidung` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `bacsi_ibfk_2` FOREIGN KEY (`ChuyenKhoaID`) REFERENCES `chuyenkhoa` (`ChuyenKhoaID`) ON DELETE SET NULL;

--
-- Constraints for table `benhnhan`
--
ALTER TABLE `benhnhan`
  ADD CONSTRAINT `benhnhan_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `nguoidung` (`UserID`) ON DELETE SET NULL;

--
-- Constraints for table `chitietdichvukham`
--
ALTER TABLE `chitietdichvukham`
  ADD CONSTRAINT `fk_chitietdv_danhmuc` FOREIGN KEY (`DichVuID`) REFERENCES `danhmucdichvu` (`DichVuID`),
  ADD CONSTRAINT `fk_chitietdv_lichkham` FOREIGN KEY (`LichKhamID`) REFERENCES `lichkham` (`LichKhamID`) ON DELETE CASCADE;

--
-- Constraints for table `donthuoc`
--
ALTER TABLE `donthuoc`
  ADD CONSTRAINT `fk_donthuoc_danhmuc` FOREIGN KEY (`ThuocID`) REFERENCES `danhmucthuoc` (`ThuocID`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_donthuoc_lichkham` FOREIGN KEY (`LichKhamID`) REFERENCES `lichkham` (`LichKhamID`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `lichkham`
--
ALTER TABLE `lichkham`
  ADD CONSTRAINT `lichkham_ibfk_1` FOREIGN KEY (`BacSiID`) REFERENCES `bacsi` (`BacSiID`) ON DELETE CASCADE,
  ADD CONSTRAINT `lichkham_ibfk_2` FOREIGN KEY (`BenhNhanID`) REFERENCES `benhnhan` (`BenhNhanID`) ON DELETE CASCADE;

--
-- Constraints for table `thongtinsuckhoe`
--
ALTER TABLE `thongtinsuckhoe`
  ADD CONSTRAINT `thongtinsuckhoe_ibfk_1` FOREIGN KEY (`BenhNhanID`) REFERENCES `benhnhan` (`BenhNhanID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
