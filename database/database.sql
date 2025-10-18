-- --------------------------------------------------------
-- Host:                         sg-shared01.dapanel.net
-- Server version:               10.6.23-MariaDB - MariaDB Server
-- Server OS:                    Linux
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for mikhaelf_db_kaldera
CREATE DATABASE IF NOT EXISTS `mikhaelf_db_kaldera` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `mikhaelf_db_kaldera`;

-- Dumping structure for table mikhaelf_db_kaldera.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.migrations: ~59 rows (approximately)
DELETE FROM `migrations`;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '20240101043322', 'App\\Database\\Migrations\\CreatePengaturanTable', 'default', 'App', 1748540062, 1),
	(2, '20240101055512', 'App\\Database\\Migrations\\CreatePengaturanThemeTable', 'default', 'App', 1748540062, 1),
	(3, '20250221135553', 'App\\Database\\Migrations\\CreateTblSessions', 'default', 'App', 1748540062, 1),
	(4, '20250526125512', 'App\\Database\\Migrations\\CreateTblPengaturanApi', 'default', 'App', 1748540062, 1),
	(5, '20250530002715', 'App\\Database\\Migrations\\CreateTblIonModules', 'default', 'App', 1748540062, 1),
	(6, '20181211100537', 'IonAuth\\Database\\Migrations\\Migration_Install_ion_auth', 'default', 'IonAuth', 1748540562, 2),
	(7, '20240101043322', 'App\\Database\\Migrations\\Migration_20240101043322_create_tbl_pengaturan', 'default', 'App', 1759141899, 3),
	(8, '20250101000000', 'App\\Database\\Migrations\\Migration_20250101000000_create_tbl_ion_actions', 'default', 'App', 1759141899, 3),
	(9, '20250101000001', 'App\\Database\\Migrations\\Migration_20250101000001_add_limit_to_tbl_pengaturan', 'default', 'App', 1759141899, 3),
	(10, '20250101000001', 'App\\Database\\Migrations\\Migration_20250101000001_create_tbl_ion_permissions', 'default', 'App', 1759141899, 3),
	(11, '20250526125512', 'App\\Database\\Migrations\\CreateTblLinks', 'default', 'App', 1759141899, 3),
	(12, '2025-09-17-000001', 'App\\Database\\Migrations\\CreateTfkMaster', 'default', 'App', 1759141899, 3),
	(13, '2025-09-17-000002', 'App\\Database\\Migrations\\CreateTfkDetail', 'default', 'App', 1759141899, 3),
	(14, '2025-09-17-000003', 'App\\Database\\Migrations\\AlterTfkDetailAddKeuReal', 'default', 'App', 1759141899, 3),
	(15, '2025-09-17-000004', 'App\\Database\\Migrations\\AlterTfkDetailAddYear', 'default', 'App', 1759141899, 3),
	(16, '2025-09-18-010053', 'App\\Database\\Migrations\\AddRealisasiFieldsToTfkDetail', 'default', 'App', 1759141899, 3),
	(17, '2025-09-18-050929', 'App\\Database\\Migrations\\CreateTblTfkSavedData', 'default', 'App', 1759141899, 3),
	(18, '2025-09-18-051134', 'App\\Database\\Migrations\\CreateTblFiskal', 'default', 'App', 1759141899, 3),
	(19, '2025-09-22-000001', 'App\\Database\\Migrations\\CreateTblGender', 'default', 'App', 1759141899, 3),
	(20, '2025-09-22-000002', 'App\\Database\\Migrations\\AlterTblGenderAddMonth', 'default', 'App', 1759141899, 3),
	(21, '2025-09-22-000101', 'App\\Database\\Migrations\\CreateTblManajemenRisiko', 'default', 'App', 1759141899, 3),
	(22, '2025-09-22-000201', 'App\\Database\\Migrations\\CreateTblSdgs', 'default', 'App', 1759141899, 3),
	(23, '2025-09-22-000301', 'App\\Database\\Migrations\\CreateTblGulkin', 'default', 'App', 1759141899, 3),
	(24, '2025-09-22-000401', 'App\\Database\\Migrations\\CreateTblUploads', 'default', 'App', 1759141899, 3),
	(25, '2025-09-22-000501', 'App\\Database\\Migrations\\AlterTblLinksAddTipe', 'default', 'App', 1759141899, 3),
	(26, '2025-09-26-000003', 'App\\Database\\Migrations\\AddTahapanToTblFiskal', 'default', 'App', 1759141899, 3),
	(27, '2025-09-26-160705', 'App\\Database\\Migrations\\CreateBelanjaAnggaran', 'default', 'App', 1759141899, 3),
	(28, '2025-09-26-161200', 'App\\Database\\Migrations\\CreateBelanjaInput', 'default', 'App', 1759141900, 3),
	(29, '2025-09-26-163000', 'App\\Database\\Migrations\\AddIdBelanjaToBelanjaInput', 'default', 'App', 1759141900, 3),
	(30, '2025-09-27-000001', 'App\\Database\\Migrations\\CreatePendapatan', 'default', 'App', 1759141900, 3),
	(31, '2025-09-27-000002', 'App\\Database\\Migrations\\CreatePendapatanInput', 'default', 'App', 1759141900, 3),
	(32, '2025-09-27-054330', 'App\\Database\\Migrations\\CreateTblIndikatorMeta', 'default', 'App', 1759141900, 3),
	(33, '2025-09-27-055110', 'App\\Database\\Migrations\\CreateIndikatorMetaTable', 'default', 'App', 1759141900, 3),
	(34, '2025-09-27-110909', 'App\\Database\\Migrations\\CreateIndikatorInputTable', 'default', 'App', 1759141900, 3),
	(35, '2025-09-27-115708', 'App\\Database\\Migrations\\CreatePbjTable', 'default', 'App', 1759141900, 3),
	(36, '2025-09-27-120351', 'App\\Database\\Migrations\\CreatePbjPdnTable', 'default', 'App', 1759141900, 3),
	(37, '2025-09-27-121229', 'App\\Database\\Migrations\\CreatePbjProgresTable', 'default', 'App', 1759141900, 3),
	(38, '2025-09-27-122839', 'App\\Database\\Migrations\\CreateBanmasHibahTable', 'default', 'App', 1759141900, 3),
	(39, '2025-09-27-124540', 'App\\Database\\Migrations\\CreateBanmasBansosTable', 'default', 'App', 1759141900, 3),
	(40, '2025-09-27-124543', 'App\\Database\\Migrations\\CreateBanmasBsTable', 'default', 'App', 1759141900, 3),
	(41, '2025-09-27-132547', 'App\\Database\\Migrations\\CreatePgTable', 'default', 'App', 1759141900, 3),
	(42, '2025-09-27-140927', 'App\\Database\\Migrations\\CreateMUkpTable', 'default', 'App', 1759141900, 3),
	(43, '2025-09-27-152545', 'App\\Database\\Migrations\\AlterBanmasHibahTableMakeNamaHibahNullable', 'default', 'App', 1759141900, 3),
	(44, '2025-09-27-154951', 'App\\Database\\Migrations\\AddAvatarToUsers', 'default', 'App', 1759142065, 4),
	(45, '2025-09-28-073407', 'App\\Database\\Migrations\\CreateMUnitKerjaTable', 'default', 'App', 1759142065, 4),
	(46, '2025-09-29-000001', 'App\\Database\\Migrations\\AddDokColumnsToBanmasHibah', 'default', 'App', 1759142065, 4),
	(47, '2025-09-29-000002', 'App\\Database\\Migrations\\RemoveJenisHibahColumn', 'default', 'App', 1759142982, 5),
	(48, '2025-09-29-000003', 'App\\Database\\Migrations\\AddDokColumnsToBanmasBansos', 'default', 'App', 1759154490, 6),
	(49, '2025-09-29-000004', 'App\\Database\\Migrations\\AddDokColumnsToBanmasBs', 'default', 'App', 1759154490, 6),
	(50, '20251004022231', 'App\\Database\\Migrations\\CreateTblBanmas', 'default', 'App', 1759544606, 7),
	(51, '2025-10-04-052404', 'App\\Database\\Migrations\\CreateProkonsTable', 'default', 'App', 1759555466, 8),
	(52, '2025-10-04-053953', 'App\\Database\\Migrations\\OptimizeUnitKerjaTable', 'default', 'App', 1759556406, 9),
	(53, '2025-10-04-060000', 'App\\Database\\Migrations\\CreateTblPt', 'default', 'App', 1759558290, 10),
	(54, '2025-10-04-100000', 'App\\Database\\Migrations\\AddVerifikasiStatusToIndikatorInput', 'default', 'App', 1759575482, 11),
	(55, '2025-10-04-110000', 'App\\Database\\Migrations\\CreateTblIndikatorVerif', 'default', 'App', 1759576087, 12),
	(56, '2025-10-04-120000', 'App\\Database\\Migrations\\CreateTblIndikatorHtl', 'default', 'App', 1759579217, 13),
	(57, '2025-10-04-130000', 'App\\Database\\Migrations\\AddFileFieldsToTblPbjProgres', 'default', 'App', 1759643046, 14),
	(58, '2025-10-04-140000', 'App\\Database\\Migrations\\AddVerifikasiFieldsToTblPbjProgres', 'default', 'App', 1759643889, 15),
	(59, '2025-10-04-150000', 'App\\Database\\Migrations\\AddFeedbackFieldsToTblPbjProgres', 'default', 'App', 1759644253, 16);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_banmas
DROP TABLE IF EXISTS `tbl_banmas`;
CREATE TABLE IF NOT EXISTS `tbl_banmas` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `nama_hibah` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai_hibah` bigint(20) DEFAULT 0,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `tipe` int(11) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_path_dok` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_name_dok` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_banmas: ~18 rows (approximately)
DELETE FROM `tbl_banmas`;
INSERT INTO `tbl_banmas` (`id`, `tahun`, `bulan`, `nama_hibah`, `deskripsi`, `nilai_hibah`, `status`, `tipe`, `file_path`, `file_path_dok`, `file_name`, `file_name_dok`, `file_size`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(4, 2025, 1, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417597.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 122747, 2, '2025-10-14 11:53:17', '2025-10-14 11:53:17', '2025-10-14 11:53:29'),
	(5, 2025, 1, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417605.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 236235, 2, '2025-10-14 11:53:25', '2025-10-14 11:53:25', '2025-10-14 11:53:33'),
	(6, 2025, 2, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417623.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 134223, 2, '2025-10-14 11:53:43', '2025-10-14 11:53:43', '2025-10-14 11:53:54'),
	(7, 2025, 2, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417630.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 129666, 2, '2025-10-14 11:53:50', '2025-10-14 11:53:50', '2025-10-14 11:53:57'),
	(8, 2025, 3, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417646.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 134103, 2, '2025-10-14 11:54:06', '2025-10-14 11:54:06', '2025-10-14 11:54:18'),
	(9, 2025, 3, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417653.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 135011, 2, '2025-10-14 11:54:13', '2025-10-14 11:54:13', '2025-10-14 11:54:21'),
	(10, 2025, 4, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417672.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 135640, 2, '2025-10-14 11:54:32', '2025-10-14 11:54:32', '2025-10-14 11:54:44'),
	(11, 2025, 4, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417680.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 135759, 2, '2025-10-14 11:54:40', '2025-10-14 11:54:40', '2025-10-14 11:54:47'),
	(12, 2025, 5, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417701.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 134474, 2, '2025-10-14 11:55:01', '2025-10-14 11:55:01', '2025-10-14 11:55:12'),
	(13, 2025, 5, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417708.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 136410, 2, '2025-10-14 11:55:08', '2025-10-14 11:55:08', '2025-10-14 11:55:16'),
	(16, 2025, 6, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417840.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 169105, 2, '2025-10-14 11:57:20', '2025-10-14 11:57:20', '2025-10-14 11:57:31'),
	(17, 2025, 6, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417847.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 136232, 2, '2025-10-14 11:57:27', '2025-10-14 11:57:27', '2025-10-14 11:57:34'),
	(18, 2025, 7, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417864.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 168269, 2, '2025-10-14 11:57:44', '2025-10-14 11:57:44', '2025-10-14 11:57:56'),
	(19, 2025, 7, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417872.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 134508, 2, '2025-10-14 11:57:52', '2025-10-14 11:57:52', '2025-10-14 11:57:59'),
	(20, 2025, 8, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417888.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 168411, 2, '2025-10-14 11:58:08', '2025-10-14 11:58:08', '2025-10-14 11:58:20'),
	(21, 2025, 8, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417896.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 135078, 2, '2025-10-14 11:58:16', '2025-10-14 11:58:16', '2025-10-14 11:58:23'),
	(22, 2025, 9, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/banmas/2025/2025_hibah_1760417912.pdf', 'https://bit.ly/admhibah2025', '1. Hibah.pdf', 'https://bit.ly/admhibah2025', 168894, 2, '2025-10-14 11:58:32', '2025-10-14 11:58:32', '2025-10-14 11:58:45'),
	(23, 2025, 9, 'Barang', 'Upload data Barang', 0, 'Belum Diperiksa', 2, 'file/banmas/2025/2025_barang_1760417921.pdf', 'https://bit.ly/admhibah2025', '3. Barang yang diserahkan kepada masyarakat.pdf', 'https://bit.ly/admhibah2025', 134365, 2, '2025-10-14 11:58:41', '2025-10-14 11:58:41', '2025-10-14 11:58:49');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_banmas_bansos
DROP TABLE IF EXISTS `tbl_banmas_bansos`;
CREATE TABLE IF NOT EXISTS `tbl_banmas_bansos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `jenis_bansos` varchar(100) NOT NULL,
  `nama_bansos` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai_bansos` bigint(20) DEFAULT 0,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `catatan_kendala` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `feedback_unit_kerja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`feedback_unit_kerja`)),
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path_dok` varchar(255) DEFAULT NULL,
  `file_name_dok` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_banmas_bansos: ~0 rows (approximately)
DELETE FROM `tbl_banmas_bansos`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_banmas_bs
DROP TABLE IF EXISTS `tbl_banmas_bs`;
CREATE TABLE IF NOT EXISTS `tbl_banmas_bs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `jenis_barang` varchar(100) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai_barang` bigint(20) DEFAULT 0,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `catatan_kendala` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `feedback_unit_kerja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`feedback_unit_kerja`)),
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path_dok` varchar(255) DEFAULT NULL,
  `file_name_dok` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan_jenis_barang` (`tahun`,`bulan`,`jenis_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_banmas_bs: ~0 rows (approximately)
DELETE FROM `tbl_banmas_bs`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_banmas_hibah
DROP TABLE IF EXISTS `tbl_banmas_hibah`;
CREATE TABLE IF NOT EXISTS `tbl_banmas_hibah` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `nama_hibah` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai_hibah` bigint(20) DEFAULT 0,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `catatan_kendala` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `feedback_unit_kerja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`feedback_unit_kerja`)),
  `file_path` varchar(500) DEFAULT NULL,
  `file_path_dok` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_name_dok` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan_jenis_hibah` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_banmas_hibah: ~0 rows (approximately)
DELETE FROM `tbl_banmas_hibah`;
INSERT INTO `tbl_banmas_hibah` (`id`, `tahun`, `bulan`, `nama_hibah`, `deskripsi`, `nilai_hibah`, `status`, `catatan_kendala`, `rencana_tindak_lanjut`, `feedback_unit_kerja`, `file_path`, `file_path_dok`, `file_name`, `file_name_dok`, `file_size`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 2025, 9, NULL, NULL, 0, 'Belum Diperiksa', 'Tidak ada kendala', 'Monitoring', '{"1":{"unit_kerja":"Kanit","alasan_saran":"1"},"2":{"unit_kerja":"Kasat","alasan_saran":"2"},"3":{"unit_kerja":"Danru","alasan_saran":"3"}}', 'file/bantuan/hibah/1759142335_b9a0cf80b13f8ca98f25.pdf', 'file/bantuan/hibah/1759143361_06a54923c2eeeac6372e.xlsx', 'Proposal.pdf', 'UAT Form - Add-on Karkulator Ekspedisi.xlsx', 24588, 2, '2025-09-29 17:56:01', '2025-09-29 17:38:55', '2025-09-29 17:56:01');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_belanja_anggaran
DROP TABLE IF EXISTS `tbl_belanja_anggaran`;
CREATE TABLE IF NOT EXISTS `tbl_belanja_anggaran` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` year(4) NOT NULL COMMENT 'Year of the anggaran data',
  `tahapan` varchar(100) NOT NULL COMMENT 'penetapan | pergeseran | perubahan',
  `pegawai` decimal(20,2) NOT NULL DEFAULT 0.00,
  `barang_jasa` decimal(20,2) NOT NULL DEFAULT 0.00,
  `hibah` decimal(20,2) NOT NULL DEFAULT 0.00,
  `bansos` decimal(20,2) NOT NULL DEFAULT 0.00,
  `modal` decimal(20,2) NOT NULL DEFAULT 0.00,
  `total` decimal(20,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_tahun_tahapan_unique` (`tahun`,`tahapan`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_belanja_anggaran: ~2 rows (approximately)
DELETE FROM `tbl_belanja_anggaran`;
INSERT INTO `tbl_belanja_anggaran` (`id`, `tahun`, `tahapan`, `pegawai`, `barang_jasa`, `hibah`, `bansos`, `modal`, `total`, `created_at`, `updated_at`) VALUES
	(1, '2025', 'penetapan', 40424875000.00, 22656464000.00, 1269000000.00, 0.00, 208020000.00, 64558359000.00, '2025-09-30 09:02:16', '2025-10-16 23:54:24'),
	(2, '2026', 'penetapan', 34000000.00, 0.00, 0.00, 0.00, 0.00, 34000000.00, '2025-09-30 12:02:49', '2025-09-30 12:02:49'),
	(3, '2025', 'pergeseran', 40424875000.00, 18306172000.00, 1269000000.00, 0.00, 205520000.00, 60205567000.00, '2025-10-14 13:20:07', '2025-10-14 13:20:40'),
	(4, '2025', 'perubahan', 35955100000.00, 18373096000.00, 1269000000.00, 0.00, 138596000.00, 55735792000.00, '2025-10-14 13:21:09', '2025-10-14 13:22:26');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_belanja_input
DROP TABLE IF EXISTS `tbl_belanja_input`;
CREATE TABLE IF NOT EXISTS `tbl_belanja_input` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_belanja` int(11) unsigned DEFAULT NULL COMMENT 'Foreign key to tbl_belanja_anggaran',
  `tahun` year(4) NOT NULL COMMENT 'Year of the input data',
  `tahapan` varchar(100) NOT NULL COMMENT 'penetapan | pergeseran | perubahan',
  `bulan` tinyint(2) NOT NULL COMMENT 'Month number 1-12',
  `pegawai_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Pegawai - Anggaran',
  `pegawai_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Pegawai - Realisasi',
  `barang_jasa_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Barang dan Jasa - Anggaran',
  `barang_jasa_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Barang dan Jasa - Realisasi',
  `hibah_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Hibah - Anggaran',
  `hibah_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Hibah - Realisasi',
  `bansos_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Bantuan Sosial - Anggaran',
  `bansos_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Bantuan Sosial - Realisasi',
  `modal_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Modal - Anggaran',
  `modal_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Belanja Modal - Realisasi',
  `total_anggaran` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Total Anggaran',
  `total_realisasi` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Total Realisasi',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_tahun_tahapan_bulan_unique` (`tahun`,`tahapan`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_belanja_input: ~19 rows (approximately)
DELETE FROM `tbl_belanja_input`;
INSERT INTO `tbl_belanja_input` (`id`, `id_belanja`, `tahun`, `tahapan`, `bulan`, `pegawai_anggaran`, `pegawai_realisasi`, `barang_jasa_anggaran`, `barang_jasa_realisasi`, `hibah_anggaran`, `hibah_realisasi`, `bansos_anggaran`, `bansos_realisasi`, `modal_anggaran`, `modal_realisasi`, `total_anggaran`, `total_realisasi`, `created_at`, `updated_at`) VALUES
	(1, 1, '2025', 'penetapan', 9, 40424875000.00, 26332341355.00, 22656464000.00, 13504666555.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 208020000.00, 57873000.00, 64558359000.00, 41089427500.00, '2025-09-30 09:05:24', '2025-10-16 23:54:46'),
	(2, 1, '2025', 'penetapan', 1, 40424875000.00, 2299091372.00, 22656464000.00, 1416745623.00, 1269000000.00, 0.00, 0.00, 0.00, 208020000.00, 20670000.00, 64558359000.00, 3736506995.00, '2025-10-14 13:32:11', '2025-10-14 13:33:17'),
	(3, 3, '2025', 'pergeseran', 1, 40424875000.00, 2299091372.00, 18306172000.00, 1416745623.00, 1269000000.00, 0.00, 0.00, 0.00, 205520000.00, 20670000.00, 60205567000.00, 3736506995.00, '2025-10-14 13:32:19', '2025-10-14 13:33:26'),
	(4, 4, '2025', 'perubahan', 1, 35955100000.00, 2299091372.00, 18373096000.00, 1416745623.00, 1269000000.00, 0.00, 0.00, 0.00, 138596000.00, 20670000.00, 55735792000.00, 3736506995.00, '2025-10-14 13:32:28', '2025-10-14 13:33:33'),
	(5, 1, '2025', 'penetapan', 2, 40424875000.00, 4600043206.00, 22656464000.00, 3274977460.00, 1269000000.00, 0.00, 0.00, 0.00, 208020000.00, 20670000.00, 64558359000.00, 7895690666.00, '2025-10-14 13:34:13', '2025-10-14 13:35:13'),
	(6, 3, '2025', 'pergeseran', 2, 40424875000.00, 4600043206.00, 18306172000.00, 3274977460.00, 1269000000.00, 0.00, 0.00, 0.00, 205520000.00, 20670000.00, 60205567000.00, 7895690666.00, '2025-10-14 13:34:19', '2025-10-14 13:35:21'),
	(7, 4, '2025', 'perubahan', 2, 35955100000.00, 4600043206.00, 18373096000.00, 3274977460.00, 1269000000.00, 0.00, 0.00, 0.00, 138596000.00, 20670000.00, 55735792000.00, 7895690666.00, '2025-10-14 13:34:31', '2025-10-14 13:35:37'),
	(8, 4, '2025', 'perubahan', 3, 35955100000.00, 9367665537.00, 18373096000.00, 5173075869.00, 1269000000.00, 79774888.00, 0.00, 0.00, 138596000.00, 24420000.00, 55735792000.00, 14644936294.00, '2025-10-14 13:36:16', '2025-10-14 13:38:04'),
	(9, 3, '2025', 'pergeseran', 3, 40424875000.00, 9367665537.00, 18306172000.00, 5173075869.00, 1269000000.00, 79774888.00, 0.00, 0.00, 205520000.00, 24420000.00, 60205567000.00, 14644936294.00, '2025-10-14 13:36:25', '2025-10-14 13:37:48'),
	(10, 1, '2025', 'penetapan', 3, 40424875000.00, 9367665537.00, 22656464000.00, 5173075869.00, 1269000000.00, 79774888.00, 0.00, 0.00, 208020000.00, 24420000.00, 64558359000.00, 14644936294.00, '2025-10-14 13:36:32', '2025-10-14 13:37:40'),
	(11, 4, '2025', 'perubahan', 4, 35955100000.00, 11680889071.00, 18373096000.00, 6353844204.00, 1269000000.00, 198442888.00, 0.00, 0.00, 138596000.00, 32820000.00, 55735792000.00, 18265996163.00, '2025-10-14 13:38:53', '2025-10-14 13:40:37'),
	(12, 3, '2025', 'pergeseran', 4, 40424875000.00, 11680889071.00, 18306172000.00, 6353844204.00, 1269000000.00, 198442888.00, 0.00, 0.00, 205520000.00, 32820000.00, 60205567000.00, 18265996163.00, '2025-10-14 13:39:06', '2025-10-14 13:40:27'),
	(13, 1, '2025', 'penetapan', 4, 40424875000.00, 11680889071.00, 22656464000.00, 6353844204.00, 1269000000.00, 198442888.00, 0.00, 0.00, 208020000.00, 32820000.00, 64558359000.00, 18265996163.00, '2025-10-14 13:39:15', '2025-10-14 13:40:19'),
	(14, 4, '2025', 'perubahan', 5, 35955100000.00, 13994014736.00, 18373096000.00, 7804953430.00, 1269000000.00, 763327628.00, 0.00, 0.00, 138596000.00, 44220000.00, 55735792000.00, 22606515794.00, '2025-10-14 13:41:23', '2025-10-14 13:42:55'),
	(15, 3, '2025', 'pergeseran', 5, 40424875000.00, 13994014736.00, 18306172000.00, 7804953430.00, 1269000000.00, 763327628.00, 0.00, 0.00, 205520000.00, 44220000.00, 60205567000.00, 22606515794.00, '2025-10-14 13:41:31', '2025-10-14 13:42:47'),
	(16, 1, '2025', 'penetapan', 5, 40424875000.00, 13994014736.00, 22656464000.00, 7804953430.00, 1269000000.00, 763327628.00, 0.00, 0.00, 208020000.00, 44220000.00, 64558359000.00, 22606515794.00, '2025-10-14 13:41:39', '2025-10-14 13:42:40'),
	(17, 4, '2025', 'perubahan', 6, 35955100000.00, 18788665388.00, 18373096000.00, 9443878801.00, 1269000000.00, 1040419628.00, 0.00, 0.00, 138596000.00, 44220000.00, 55735792000.00, 29317183817.00, '2025-10-14 13:44:36', '2025-10-14 13:46:14'),
	(18, 3, '2025', 'pergeseran', 6, 40424875000.00, 18788665388.00, 18306172000.00, 9443878801.00, 1269000000.00, 1040419628.00, 0.00, 0.00, 205520000.00, 44220000.00, 60205567000.00, 29317183817.00, '2025-10-14 13:44:44', '2025-10-14 13:46:06'),
	(19, 1, '2025', 'penetapan', 6, 40424875000.00, 18788665388.00, 22656464000.00, 9443878801.00, 1269000000.00, 1040419628.00, 0.00, 0.00, 208020000.00, 44220000.00, 64558359000.00, 29317183817.00, '2025-10-14 13:44:53', '2025-10-14 13:45:58'),
	(20, 4, '2025', 'perubahan', 7, 35955100000.00, 21509041846.00, 18373096000.00, 11439193040.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 138596000.00, 57873000.00, 55735792000.00, 34200654476.00, '2025-10-14 13:46:48', '2025-10-14 13:48:29'),
	(21, 3, '2025', 'pergeseran', 7, 40424875000.00, 21509041846.00, 18306172000.00, 11439193040.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 205520000.00, 57873000.00, 60205567000.00, 34200654476.00, '2025-10-14 13:46:55', '2025-10-14 13:48:20'),
	(22, 1, '2025', 'penetapan', 7, 40424875000.00, 21509041846.00, 22656464000.00, 11439193040.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 208020000.00, 57873000.00, 64558359000.00, 34200654476.00, '2025-10-14 13:47:02', '2025-10-14 13:48:13'),
	(23, 4, '2025', 'perubahan', 8, 35955100000.00, 23920149598.00, 18373096000.00, 12494400662.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 138596000.00, 57873000.00, 55735792000.00, 37666969850.00, '2025-10-14 13:49:02', '2025-10-14 13:50:36'),
	(24, 3, '2025', 'pergeseran', 8, 40424875000.00, 23920149598.00, 18306172000.00, 12494400662.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 205520000.00, 57873000.00, 60205567000.00, 37666969850.00, '2025-10-14 13:49:10', '2025-10-14 13:50:24'),
	(25, 1, '2025', 'penetapan', 8, 40424875000.00, 23920149598.00, 22656464000.00, 12494400662.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 208020000.00, 57873000.00, 64558359000.00, 37666969850.00, '2025-10-14 13:49:17', '2025-10-14 13:50:17'),
	(26, 4, '2025', 'perubahan', 9, 35955100000.00, 26332341355.00, 18373096000.00, 13504666555.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 138596000.00, 57873000.00, 55735792000.00, 41089427500.00, '2025-10-14 13:51:25', '2025-10-14 13:52:47'),
	(27, 3, '2025', 'pergeseran', 9, 40424875000.00, 26332341355.00, 18306172000.00, 13504666555.00, 1269000000.00, 1194546590.00, 0.00, 0.00, 205520000.00, 57873000.00, 60205567000.00, 41089427500.00, '2025-10-14 13:51:32', '2025-10-14 13:52:55');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_fiskal
DROP TABLE IF EXISTS `tbl_fiskal`;
CREATE TABLE IF NOT EXISTS `tbl_fiskal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int(11) unsigned NOT NULL COMMENT 'Reference to tbl_target_fisik_keu_master',
  `tipe` enum('0','1','2','3','4','5','6','7','8','9','10') NOT NULL DEFAULT '0' COMMENT '0-10 enum, 1 for target fisik keuangan',
  `tahun` year(4) NOT NULL COMMENT 'Year of the data',
  `bulan` enum('jan','feb','mar','apr','mei','jun','jul','ags','sep','okt','nov','des') NOT NULL COMMENT 'Month abbreviation',
  `tahapan` enum('penetapan','pergeseran','perubahan') DEFAULT 'penetapan' COMMENT 'Tahapan APBD: penetapan|pergeseran|perubahan',
  `target_fisik` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Fisik (%)',
  `target_keuangan` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Keuangan (%)',
  `realisasi_fisik` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Fisik (%)',
  `realisasi_keuangan` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Keuangan (%)',
  `realisasi_fisik_prov` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Fisik Provinsi (%)',
  `realisasi_keuangan_prov` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Keuangan Provinsi (%)',
  `deviasi_fisik` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Deviasi Fisik (%) - calculated field',
  `deviasi_keuangan` decimal(20,2) NOT NULL DEFAULT 0.00 COMMENT 'Deviasi Keuangan (%) - calculated field',
  `analisa` text DEFAULT NULL COMMENT 'Analisa text',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_master_tipe_year_month_tahapan` (`master_id`,`tipe`,`tahun`,`bulan`,`tahapan`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_fiskal: ~80 rows (approximately)
DELETE FROM `tbl_fiskal`;
INSERT INTO `tbl_fiskal` (`id`, `master_id`, `tipe`, `tahun`, `bulan`, `tahapan`, `target_fisik`, `target_keuangan`, `realisasi_fisik`, `realisasi_keuangan`, `realisasi_fisik_prov`, `realisasi_keuangan_prov`, `deviasi_fisik`, `deviasi_keuangan`, `analisa`, `created_at`, `updated_at`) VALUES
	(1, 1, '1', '2026', 'jan', 'penetapan', 2000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(2, 1, '1', '2026', 'feb', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(3, 1, '1', '2026', 'mar', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(4, 1, '1', '2026', 'apr', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(5, 1, '1', '2026', 'mei', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(6, 1, '1', '2026', 'jun', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(7, 1, '1', '2026', 'jul', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(8, 1, '1', '2026', 'sep', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(9, 1, '1', '2026', 'okt', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(10, 1, '1', '2026', 'nov', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(11, 1, '1', '2026', 'des', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 11:34:50', '2025-09-30 11:34:50'),
	(12, 1, '1', '2025', 'jan', 'penetapan', 5.91, 5.82, 6.77, 6.88, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 14:05:04'),
	(13, 1, '1', '2025', 'feb', 'penetapan', 12.29, 11.95, 15.26, 14.17, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 14:16:59'),
	(14, 1, '1', '2025', 'mar', 'penetapan', 23.14, 22.29, 27.72, 26.27, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 14:32:52'),
	(15, 1, '1', '2025', 'apr', 'penetapan', 30.45, 29.23, 35.21, 32.77, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 14:35:14'),
	(16, 1, '1', '2025', 'mei', 'penetapan', 38.37, 37.25, 43.03, 40.56, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 14:40:49'),
	(17, 1, '1', '2025', 'jun', 'penetapan', 50.23, 49.58, 55.72, 52.60, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 15:00:21'),
	(18, 1, '1', '2025', 'jul', 'penetapan', 61.32, 60.56, 63.59, 61.36, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 15:01:55'),
	(19, 1, '1', '2025', 'sep', 'penetapan', 74.02, 73.34, 76.66, 73.72, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 15:05:03'),
	(20, 1, '1', '2025', 'okt', 'penetapan', 80.51, 80.01, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 12:56:35'),
	(21, 1, '1', '2025', 'nov', 'penetapan', 86.57, 86.15, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 12:56:35'),
	(22, 1, '1', '2025', 'des', 'penetapan', 100.00, 100.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-09-30 19:58:25', '2025-10-14 11:35:50'),
	(23, 1, '1', '2021', 'jan', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(24, 1, '1', '2021', 'feb', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(25, 1, '1', '2021', 'mar', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(26, 1, '1', '2021', 'apr', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(27, 1, '1', '2021', 'mei', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(28, 1, '1', '2021', 'jun', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(29, 1, '1', '2021', 'jul', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(30, 1, '1', '2021', 'sep', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(31, 1, '1', '2021', 'okt', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(32, 1, '1', '2021', 'nov', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(33, 1, '1', '2021', 'des', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:48', '2025-10-07 19:45:48'),
	(34, 1, '1', '2022', 'jan', 'penetapan', 888.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(35, 1, '1', '2022', 'feb', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(36, 1, '1', '2022', 'mar', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(37, 1, '1', '2022', 'apr', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(38, 1, '1', '2022', 'mei', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(39, 1, '1', '2022', 'jun', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(40, 1, '1', '2022', 'jul', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(41, 1, '1', '2022', 'sep', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(42, 1, '1', '2022', 'okt', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(43, 1, '1', '2022', 'nov', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(44, 1, '1', '2022', 'des', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:45:56', '2025-10-07 19:45:56'),
	(45, 1, '1', '2023', 'jan', 'penetapan', 9000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(46, 1, '1', '2023', 'feb', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(47, 1, '1', '2023', 'mar', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(48, 1, '1', '2023', 'apr', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(49, 1, '1', '2023', 'mei', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(50, 1, '1', '2023', 'jun', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(51, 1, '1', '2023', 'jul', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(52, 1, '1', '2023', 'sep', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(53, 1, '1', '2023', 'okt', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(54, 1, '1', '2023', 'nov', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(55, 1, '1', '2023', 'des', 'penetapan', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 19:46:10', '2025-10-07 19:46:10'),
	(56, 1, '1', '2025', 'ags', 'penetapan', 67.66, 67.00, 69.96, 67.58, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:34:21', '2025-10-15 07:04:11'),
	(59, 1, '1', '2025', 'jan', 'pergeseran', 6.21, 6.16, 6.77, 6.70, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:07:11'),
	(60, 1, '1', '2025', 'feb', 'pergeseran', 13.95, 13.11, 15.26, 14.17, 0.00, 24.33, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:17:27'),
	(61, 1, '1', '2025', 'mar', 'pergeseran', 24.97, 24.22, 27.72, 26.27, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:27:24'),
	(62, 1, '1', '2025', 'apr', 'pergeseran', 31.56, 30.41, 35.21, 32.77, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:35:38'),
	(63, 1, '1', '2025', 'mei', 'pergeseran', 39.27, 38.06, 43.03, 40.56, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:39:50'),
	(64, 1, '1', '2025', 'jun', 'pergeseran', 50.96, 50.52, 55.72, 52.60, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 14:59:59'),
	(65, 1, '1', '2025', 'jul', 'pergeseran', 61.56, 60.97, 63.59, 61.36, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 15:01:30'),
	(66, 1, '1', '2025', 'sep', 'pergeseran', 73.88, 73.39, 76.66, 73.72, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 15:04:28'),
	(67, 1, '1', '2025', 'okt', 'pergeseran', 80.09, 79.80, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 13:02:23'),
	(68, 1, '1', '2025', 'nov', 'pergeseran', 85.92, 85.85, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 13:02:23'),
	(69, 1, '1', '2025', 'des', 'pergeseran', 100.00, 100.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:51:55', '2025-10-14 13:02:23'),
	(70, 1, '1', '2025', 'jan', 'perubahan', 6.66, 6.61, 6.77, 6.70, 0.00, 0.00, 0.00, 0.00, '', '2025-10-07 20:57:58', '2025-10-14 14:07:03'),
	(71, 1, '1', '2025', 'feb', 'perubahan', 15.05, 14.05, 15.26, 14.17, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 14:18:06'),
	(72, 1, '1', '2025', 'mar', 'perubahan', 26.82, 25.79, 27.72, 26.27, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 14:27:49'),
	(73, 1, '1', '2025', 'apr', 'perubahan', 33.85, 32.16, 35.21, 32.77, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 14:36:00'),
	(74, 1, '1', '2025', 'mei', 'perubahan', 41.67, 39.82, 43.03, 40.56, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 14:36:45'),
	(75, 1, '1', '2025', 'jun', 'perubahan', 55.04, 53.66, 55.72, 52.60, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 14:59:28'),
	(76, 1, '1', '2025', 'jul', 'perubahan', 62.58, 61.14, 63.59, 61.36, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 15:01:08'),
	(77, 1, '1', '2025', 'sep', 'perubahan', 75.93, 74.32, 76.66, 73.72, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 15:03:46'),
	(78, 1, '1', '2025', 'okt', 'perubahan', 82.96, 81.60, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 13:07:01'),
	(79, 1, '1', '2025', 'nov', 'perubahan', 90.13, 89.72, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-16 23:53:22'),
	(80, 1, '1', '2025', 'des', 'perubahan', 100.00, 100.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 13:07:01', '2025-10-14 13:07:01'),
	(81, 1, '1', '2025', 'ags', 'pergeseran', 67.77, 67.13, 69.96, 67.58, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 23:39:30', '2025-10-15 07:04:51'),
	(82, 1, '1', '2025', 'ags', 'perubahan', 69.32, 67.51, 69.96, 67.58, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-14 23:41:33', '2025-10-15 07:05:26'),
	(83, 1, '1', '2023', 'ags', 'penetapan', 78.96, 45.36, 45.68, 68.35, 0.00, 0.00, 0.00, 0.00, NULL, '2025-10-16 07:04:15', '2025-10-16 07:04:48');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_gender
DROP TABLE IF EXISTS `tbl_gender`;
CREATE TABLE IF NOT EXISTS `tbl_gender` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `month` char(2) NOT NULL DEFAULT '01',
  `uraian` varchar(255) NOT NULL,
  `fupload` varchar(255) DEFAULT NULL COMMENT 'Relative path to uploaded file',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_gender: ~0 rows (approximately)
DELETE FROM `tbl_gender`;
INSERT INTO `tbl_gender` (`id`, `year`, `month`, `uraian`, `fupload`, `created_at`, `updated_at`) VALUES
	(4, '2023', '12', 'Gender Analysis Pathway (GAP) Lismur', '/file/4/gender_4_1760686693.pdf', '2025-10-17 14:38:13', '2025-10-17 14:38:13'),
	(5, '2023', '10', 'Gender Analysis Pathway (GAP) EBT 2024', '/file/5/gender_5_1760686757.pdf', '2025-10-17 14:39:17', '2025-10-17 14:39:17'),
	(6, '2023', '10', 'Gender Budget Statement EBT 2024', '/file/6/gender_6_1760686818.pdf', '2025-10-17 14:40:18', '2025-10-17 14:40:18'),
	(7, '2023', '12', 'Gender Budget Statement (GBS) Lismur 2024', '/file/7/gender_7_1760686864.pdf', '2025-10-17 14:41:04', '2025-10-17 14:41:04'),
	(8, '2025', '02', 'Laporan Pengarusutamaan Gender (PUG) Tahun 2024', '/file/8/gender_8_1760687057.pdf', '2025-10-17 14:44:17', '2025-10-17 14:44:17');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_gulkin
DROP TABLE IF EXISTS `tbl_gulkin`;
CREATE TABLE IF NOT EXISTS `tbl_gulkin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `month` char(2) NOT NULL DEFAULT '01',
  `uraian` varchar(255) NOT NULL,
  `fupload` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_gulkin: ~13 rows (approximately)
DELETE FROM `tbl_gulkin`;
INSERT INTO `tbl_gulkin` (`id`, `year`, `month`, `uraian`, `fupload`, `created_at`, `updated_at`) VALUES
	(9, '2025', '02', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Februari', '/file/gulkin/9/gulkin_9_1760496446.xlsx', NULL, '2025-10-15 09:47:26'),
	(10, '2025', '03', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Maret', '/file/gulkin/10/gulkin_10_1760496575.xlsx', NULL, '2025-10-15 09:49:35'),
	(11, '2025', '04', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan April', '/file/gulkin/11/gulkin_11_1760496714.xlsx', NULL, '2025-10-15 09:51:54'),
	(12, '2025', '05', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Mei', '/file/gulkin/12/gulkin_12_1760496768.xlsx', NULL, '2025-10-15 09:52:48'),
	(13, '2025', '06', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Juni', '/file/gulkin/13/gulkin_13_1760496889.xlsx', NULL, '2025-10-15 09:54:49'),
	(14, '2025', '07', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Juli', '/file/gulkin/14/gulkin_14_1760496935.xlsx', NULL, '2025-10-15 09:55:35'),
	(15, '2025', '08', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Agustus', '/file/gulkin/15/gulkin_15_1760496966.xlsx', NULL, '2025-10-15 09:56:06'),
	(16, '2025', '09', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan September', '/file/gulkin/16/gulkin_16_1760497018.xlsx', NULL, '2025-10-15 09:56:58'),
	(17, '2024', '08', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Agustus', '/file/gulkin/17/gulkin_17_1760497503.xlsx', NULL, '2025-10-15 10:05:03'),
	(18, '2024', '09', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan September', '/file/gulkin/18/gulkin_18_1760497635.xlsx', NULL, '2025-10-15 10:07:15'),
	(19, '2024', '10', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Oktober', '/file/gulkin/19/gulkin_19_1760497664.xlsx', NULL, '2025-10-15 10:07:44'),
	(20, '2024', '11', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan November', '/file/gulkin/20/gulkin_20_1760497684.xlsx', NULL, '2025-10-15 10:08:04'),
	(21, '2024', '12', 'Laporan Rencana Aksi Tahunan (RAT) Penanggulangan Kemiskinan Bulan Desember', '/file/gulkin/21/gulkin_21_1760497708.xlsx', NULL, '2025-10-15 10:08:28');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_indikator_htl
DROP TABLE IF EXISTS `tbl_indikator_htl`;
CREATE TABLE IF NOT EXISTS `tbl_indikator_htl` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `indikator_input_id` int(11) unsigned DEFAULT NULL,
  `tahun` int(4) NOT NULL,
  `triwulan` int(1) NOT NULL,
  `jenis_indikator` varchar(100) NOT NULL,
  `nama_verifikator` varchar(255) NOT NULL,
  `hasil_tindak_lanjut_status` enum('Belum','Sudah') NOT NULL DEFAULT 'Belum',
  `hasil_tindak_lanjut_file` varchar(500) DEFAULT NULL,
  `hasil_tindak_lanjut_file_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_indikator_htl_indikator_input_id_foreign` (`indikator_input_id`),
  KEY `idx_htl_unique` (`tahun`,`triwulan`,`jenis_indikator`,`nama_verifikator`),
  CONSTRAINT `tbl_indikator_htl_indikator_input_id_foreign` FOREIGN KEY (`indikator_input_id`) REFERENCES `tbl_indikator_input` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_indikator_htl: ~0 rows (approximately)
DELETE FROM `tbl_indikator_htl`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_indikator_input
DROP TABLE IF EXISTS `tbl_indikator_input`;
CREATE TABLE IF NOT EXISTS `tbl_indikator_input` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `triwulan` int(1) NOT NULL,
  `jenis_indikator` varchar(100) NOT NULL,
  `catatan_indikator` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `status_verifikasi_bidang` enum('Belum Diperiksa','Sesuai','Tidak Sesuai') NOT NULL DEFAULT 'Belum Diperiksa' COMMENT 'Status verifikasi dari bidang',
  `tanggal_verifikasi` datetime DEFAULT NULL COMMENT 'Tanggal verifikasi dilakukan',
  `verifikasi_by` int(11) DEFAULT NULL COMMENT 'ID user yang melakukan verifikasi',
  `file_catatan_path` varchar(500) DEFAULT NULL,
  `file_catatan_name` varchar(255) DEFAULT NULL,
  `file_catatan_size` bigint(20) DEFAULT NULL,
  `file_rencana_path` varchar(500) DEFAULT NULL,
  `file_rencana_name` varchar(255) DEFAULT NULL,
  `file_rencana_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_triwulan_jenis_indikator` (`tahun`,`triwulan`,`jenis_indikator`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_indikator_input: ~14 rows (approximately)
DELETE FROM `tbl_indikator_input`;
INSERT INTO `tbl_indikator_input` (`id`, `tahun`, `triwulan`, `jenis_indikator`, `catatan_indikator`, `rencana_tindak_lanjut`, `status_verifikasi_bidang`, `tanggal_verifikasi`, `verifikasi_by`, `file_catatan_path`, `file_catatan_name`, `file_catatan_size`, `file_rencana_path`, `file_rencana_name`, `file_rencana_size`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 2025, 1, 'tujuan', '', NULL, 'Sesuai', '2025-10-15 06:49:06', 2, 'file/indikator/input/1760424694_5f39608c5b7b1e62c7c0.pdf', 'Tujuan OPD.pdf', 144581, 'public/file/indikator/input/1759421577_22db6a064afbd3599a73.pdf', 'SURAT PERJANJIAN RAHASIA MAXVEL.pdf_20251002_165555_0000-1.pdf', 90521, 2, '2025-10-14 13:51:34', '2025-09-30 20:06:44', '2025-10-15 06:49:06'),
	(2, 2025, 1, 'sasaran', '', NULL, 'Sesuai', '2025-10-15 06:49:00', 2, 'file/indikator/input/1760424708_37bcf87d4f41147894b9.pdf', 'Sasaran OPD.pdf', 159028, NULL, NULL, NULL, 2, '2025-10-14 13:51:48', '2025-10-04 17:57:16', '2025-10-15 06:49:00'),
	(3, 2025, 1, 'program', '', NULL, 'Sesuai', '2025-10-15 06:49:08', 2, 'file/indikator/input/1760424715_77f91a02fd0c1cec3757.pdf', 'Program Urusan ESDM.pdf', 455381, NULL, NULL, NULL, 2, '2025-10-14 13:51:55', '2025-10-14 13:51:55', '2025-10-15 06:49:08'),
	(4, 2025, 1, 'kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:49:10', 2, 'file/indikator/input/1760424726_9834a9ed3c80f922b416.pdf', 'Kegiatan Urusan ESDM.pdf', 734353, NULL, NULL, NULL, 2, '2025-10-14 13:52:06', '2025-10-14 13:52:06', '2025-10-15 06:49:10'),
	(5, 2025, 1, 'sub_kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:49:12', 2, 'file/indikator/input/1760424735_570f4346d81aa236509c.pdf', 'Sub Kegiatan Urusan ESDM.pdf', 1755091, NULL, NULL, NULL, 2, '2025-10-14 13:52:15', '2025-10-14 13:52:15', '2025-10-15 06:49:12'),
	(6, 2025, 2, 'tujuan', '', NULL, 'Sesuai', '2025-10-15 06:49:16', 2, 'file/indikator/input/1760485462_7bcb1aaadcbc147982b4.pdf', 'Cetak Tujuan OPD.pdf', 147618, NULL, NULL, NULL, 2, '2025-10-15 06:44:22', '2025-10-15 06:44:22', '2025-10-15 06:49:16'),
	(7, 2025, 2, 'sasaran', '', NULL, 'Sesuai', '2025-10-15 06:49:18', 2, 'file/indikator/input/1760485468_fac57d6e664d06e810ad.pdf', 'Cetak Sasaran OPD.pdf', 163494, NULL, NULL, NULL, 2, '2025-10-15 06:44:28', '2025-10-15 06:44:28', '2025-10-15 06:49:18'),
	(8, 2025, 2, 'program', '', NULL, 'Sesuai', '2025-10-15 06:49:20', 2, 'file/indikator/input/1760485476_c3db09893b6cdfcfa1e3.pdf', 'Program Urusan ESDM.pdf', 445212, NULL, NULL, NULL, 2, '2025-10-15 06:44:36', '2025-10-15 06:44:36', '2025-10-15 06:49:20'),
	(9, 2025, 2, 'kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:49:21', 2, 'file/indikator/input/1760485485_2c537a6492aa3205dbd9.pdf', 'Kegiatan Urusan ESDM.pdf', 742284, NULL, NULL, NULL, 2, '2025-10-15 06:44:45', '2025-10-15 06:44:45', '2025-10-15 06:49:21'),
	(10, 2025, 2, 'sub_kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:49:23', 2, 'file/indikator/input/1760485491_8a2cea8e48ed8129b2ad.pdf', 'Sub Kegiatan Urusan ESDM.pdf', 1748493, NULL, NULL, NULL, 2, '2025-10-15 06:44:51', '2025-10-15 06:44:51', '2025-10-15 06:49:23'),
	(11, 2025, 3, 'tujuan', '', NULL, 'Sesuai', '2025-10-15 06:50:07', 2, 'file/indikator/input/1760485776_3f35b96aa8bd21a6d4ff.pdf', 'Cetak Tujuan OPD.pdf', 142805, NULL, NULL, NULL, 2, '2025-10-15 06:49:36', '2025-10-15 06:49:36', '2025-10-15 06:50:07'),
	(12, 2025, 3, 'sasaran', '', NULL, 'Sesuai', '2025-10-15 06:50:09', 2, 'file/indikator/input/1760485782_c52c77aebf4e72ac78fd.pdf', 'Cetak Sasaran OPD.pdf', 163494, NULL, NULL, NULL, 2, '2025-10-15 06:49:42', '2025-10-15 06:49:42', '2025-10-15 06:50:09'),
	(13, 2025, 3, 'program', '', NULL, 'Sesuai', '2025-10-15 06:50:11', 2, 'file/indikator/input/1760485788_dafa232766765d75d5ff.pdf', 'Program Urusan ESDM.pdf', 437914, NULL, NULL, NULL, 2, '2025-10-15 06:49:48', '2025-10-15 06:49:48', '2025-10-15 06:50:11'),
	(14, 2025, 3, 'kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:50:12', 2, 'file/indikator/input/1760485794_8c2b21beb9c77b1b4e52.pdf', 'Kegiatan Urusan ESDM.pdf', 792833, NULL, NULL, NULL, 2, '2025-10-15 06:49:54', '2025-10-15 06:49:54', '2025-10-15 06:50:12'),
	(15, 2025, 3, 'sub_kegiatan', '', NULL, 'Sesuai', '2025-10-15 06:50:14', 2, 'file/indikator/input/1760485800_865aa34e265ad355f48d.pdf', 'Sub Kegiatan Urusan ESDM.pdf', 1734876, NULL, NULL, NULL, 2, '2025-10-15 06:50:00', '2025-10-15 06:50:00', '2025-10-15 06:50:14');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_indikator_meta
DROP TABLE IF EXISTS `tbl_indikator_meta`;
CREATE TABLE IF NOT EXISTS `tbl_indikator_meta` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `jenis_indikator` varchar(100) NOT NULL,
  `nama_indikator` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis_indikator` (`jenis_indikator`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_indikator_meta: ~2 rows (approximately)
DELETE FROM `tbl_indikator_meta`;
INSERT INTO `tbl_indikator_meta` (`id`, `jenis_indikator`, `nama_indikator`, `deskripsi`, `file_path`, `file_name`, `file_size`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 'sasaran', 'Indikator Sasaran', '\n\nDefinisi Operasional:\n', '/file/indikator/1759288847_b177c45b9fe737345d06.pdf', 'IT risk management interrelatioinship based on strategy implementation.pdf', 282607, 2, '2025-10-01 10:20:47', '2025-10-01 10:20:47', '2025-10-01 10:20:47'),
	(2, 'sasaran', 'Indikator Sasaran', '\n\nDefinisi Operasional:\n', '/file/indikator/1759560002_e9ce45cc1540da722100.pdf', 'sample.pdf', 18810, 2, '2025-10-04 13:40:02', '2025-10-04 13:40:02', '2025-10-04 13:40:02'),
	(3, 'tujuan', 'Indikator Tujuan', '\n\nDefinisi Operasional:\n', '/file/indikator/1760424014_36c5b5cf5dcda05b2176.pdf', '1. Hibah.pdf', 168894, 2, '2025-10-14 13:40:14', '2025-10-14 13:40:14', '2025-10-14 13:40:14');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_indikator_verif
DROP TABLE IF EXISTS `tbl_indikator_verif`;
CREATE TABLE IF NOT EXISTS `tbl_indikator_verif` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `indikator_input_id` int(11) unsigned DEFAULT NULL COMMENT 'Foreign key to tbl_indikator_input',
  `tahun` int(4) NOT NULL COMMENT 'Tahun data',
  `triwulan` int(1) NOT NULL COMMENT 'Triwulan (1-4)',
  `jenis_indikator` varchar(100) NOT NULL COMMENT 'Jenis indikator',
  `nama_verifikator` varchar(255) NOT NULL COMMENT 'Nama verifikator/bidang',
  `hasil_verifikasi_status` enum('Belum','Sudah') NOT NULL DEFAULT 'Belum' COMMENT 'Status hasil verifikasi',
  `hasil_verifikasi_file` varchar(500) DEFAULT NULL COMMENT 'Path file hasil verifikasi',
  `hasil_verifikasi_file_name` varchar(255) DEFAULT NULL COMMENT 'Nama file hasil verifikasi',
  `rencana_tindak_lanjut_status` enum('Belum','Sudah') NOT NULL DEFAULT 'Belum' COMMENT 'Status rencana tindak lanjut',
  `rencana_tindak_lanjut_file` varchar(500) DEFAULT NULL COMMENT 'Path file rencana tindak lanjut',
  `rencana_tindak_lanjut_file_name` varchar(255) DEFAULT NULL COMMENT 'Nama file rencana tindak lanjut',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_periode` (`tahun`,`triwulan`,`jenis_indikator`),
  KEY `idx_indikator_input` (`indikator_input_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_indikator_verif: ~12 rows (approximately)
DELETE FROM `tbl_indikator_verif`;
INSERT INTO `tbl_indikator_verif` (`id`, `indikator_input_id`, `tahun`, `triwulan`, `jenis_indikator`, `nama_verifikator`, `hasil_verifikasi_status`, `hasil_verifikasi_file`, `hasil_verifikasi_file_name`, `rencana_tindak_lanjut_status`, `rencana_tindak_lanjut_file`, `rencana_tindak_lanjut_file_name`, `created_at`, `updated_at`) VALUES
	(1, 1, 2025, 1, 'tujuan', 'Sekretariat', 'Sudah', 'file/indikator/hasil-htl/1759756376_a-beautiful-picture-of-the-eiffel-tower-in-paris-the-capital-of-france-with-a-wonderful-background-in-wonderful-natural-colors-photo.jpg', 'a-beautiful-picture-of-the-eiffel-tower-in-paris-the-capital-of-france-with-a-wonderful-background-in-wonderful-natural-colors-photo.jpg', 'Sudah', 'file/indikator/verifikator/1759578170_ad4329a7b7cf548bd00b.pdf', 'sample.pdf', '2025-10-06 20:12:56', '2025-10-06 20:12:56'),
	(2, 1, 2025, 1, 'tujuan', 'Bidang Minerba', 'Belum', 'file/indikator/hasil-htl/1759756390_a-beautiful-picture-of-the-eiffel-tower-in-paris-the-capital-of-france-with-a-wonderful-background-in-wonderful-natural-colors-photo.jpg', 'a-beautiful-picture-of-the-eiffel-tower-in-paris-the-capital-of-france-with-a-wonderful-background-in-wonderful-natural-colors-photo.jpg', 'Belum', NULL, NULL, '2025-10-06 20:13:10', '2025-10-06 20:13:10'),
	(3, 1, 2025, 1, 'tujuan', 'Bidang GAT', 'Belum', NULL, NULL, 'Belum', NULL, NULL, '2025-10-04 18:42:18', '2025-10-04 18:42:18'),
	(4, 1, 2025, 1, 'tujuan', 'Bidang EBT', 'Belum', NULL, NULL, 'Belum', NULL, NULL, '2025-10-04 18:42:18', '2025-10-04 18:42:18'),
	(5, 1, 2025, 1, 'tujuan', 'Bidang Gatrik', 'Belum', NULL, NULL, 'Belum', NULL, NULL, '2025-10-04 18:42:18', '2025-10-04 18:42:18'),
	(7, NULL, 2025, 3, 'tujuan', 'Bid. Minerba', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760492110_e6bc86255a59642b2c34.pdf', '1. PDRB.pdf', '2025-10-15 08:35:10', '2025-10-15 08:35:10'),
	(8, NULL, 2025, 3, 'tujuan', 'Bid. GAT', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760492172_50bca2a4c70cce12abeb.pdf', '2. IPAT.pdf', '2025-10-15 08:36:12', '2025-10-15 08:36:12'),
	(9, NULL, 2025, 3, 'tujuan', 'Bid. EBT', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760492190_89beb3f915a9b43778ad.pdf', '3. Indeks Ketahanan Energi.pdf', '2025-10-15 08:36:30', '2025-10-15 08:36:30'),
	(10, NULL, 2025, 3, 'tujuan', 'Sekretariat', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760492201_90af299b9b59ba6f5f69.pdf', '4. Indeks RB.pdf', '2025-10-15 08:36:41', '2025-10-15 08:36:41'),
	(11, NULL, 2025, 3, 'sasaran', 'Bidang Minerba', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760492995_cb05343f78d2d1c387d4.pdf', '1. GMP.pdf', '2025-10-15 08:49:55', '2025-10-15 08:49:55'),
	(12, NULL, 2025, 3, 'sasaran', 'Bidang GAT', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760493002_e1dc04e8c7a0d4578d85.pdf', '2. Indeks Ketersediaan Air Tanah.pdf', '2025-10-15 08:50:02', '2025-10-15 08:50:02'),
	(13, NULL, 2025, 3, 'sasaran', 'Bidang EBT', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760493009_0eee6a6d20244fa0894c.pdf', '3. Bauran Energi.pdf', '2025-10-15 08:50:09', '2025-10-15 08:50:09'),
	(14, NULL, 2025, 3, 'sasaran', 'Bidang Gatrik', 'Belum', NULL, NULL, 'Sudah', 'file/indikator/verifikator/1760493016_dcf79b1c8efc2c597008.pdf', '4. Konsumsi listrik perkapita.pdf', '2025-10-15 08:50:16', '2025-10-15 08:50:16');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_actions
DROP TABLE IF EXISTS `tbl_ion_actions`;
CREATE TABLE IF NOT EXISTS `tbl_ion_actions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT 'Action name: create, read, update, delete, etc.',
  `description` varchar(255) DEFAULT NULL COMMENT 'Description of the action',
  `is_active` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'Whether action is active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_actions: ~11 rows (approximately)
DELETE FROM `tbl_ion_actions`;
INSERT INTO `tbl_ion_actions` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
	(1, 'create', 'Create new records', '1', '2025-09-29 10:31:39', NULL),
	(2, 'read', 'Read/view records', '1', '2025-09-29 10:31:39', NULL),
	(3, 'read_all', 'Read all records (not just own)', '1', '2025-09-29 10:31:39', NULL),
	(4, 'update', 'Update records', '1', '2025-09-29 10:31:39', NULL),
	(5, 'update_all', 'Update all records (not just own)', '1', '2025-09-29 10:31:39', NULL),
	(6, 'delete', 'Delete records', '1', '2025-09-29 10:31:39', NULL),
	(7, 'delete_all', 'Delete all records (not just own)', '1', '2025-09-29 10:31:39', NULL),
	(8, 'export', 'Export data', '1', '2025-09-29 10:31:39', NULL),
	(9, 'import', 'Import data', '1', '2025-09-29 10:31:39', NULL),
	(10, 'approve', 'Approve records', '1', '2025-09-29 10:31:39', NULL),
	(11, 'reject', 'Reject records', '1', '2025-09-29 10:31:39', NULL);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_groups
DROP TABLE IF EXISTS `tbl_ion_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_groups: ~16 rows (approximately)
DELETE FROM `tbl_ion_groups`;
INSERT INTO `tbl_ion_groups` (`id`, `name`, `description`) VALUES
	(1, 'root', 'Root - Highest Level Access'),
	(2, 'superadmin', 'Super Administrator'),
	(3, 'internal', 'Internal'),
	(4, 'sekretariat', 'Cabang Dinas ESDM Wilayah Solo'),
	(5, 'minerba', 'Cabang Dinas ESDM Wilayah Kendeng Muria'),
	(6, 'ketenagalistrikan', 'Cabang Dinas ESDM Wilayah Serayu Utara'),
	(7, 'energi_baru', 'Cabang Dinas ESDM Wilayah Serayu Selatan'),
	(8, 'geologi_air', 'Cabang Dinas ESDM Wilayah Slamet Utara'),
	(9, 'ungaran_telomoyo', 'Cabang Dinas ESDM Wilayah Ungaran Telomoyo'),
	(10, 'kendeng_selatan', 'Cabang Dinas ESDM Wilayah Kendeng Selatan'),
	(11, 'sewu_lawu', 'Cabang Dinas ESDM Wilayah Sewu Lawu'),
	(12, 'slamet_selatan', 'Cabang Dinas ESDM Wilayah Slamet Selatan'),
	(13, 'semarang_demak', 'Cabang Dinas ESDM Wilayah Semarang Demak'),
	(14, 'merapi', 'Cabang Dinas ESDM Wilayah Merapi'),
	(15, 'serayu_tengah', 'Cabang Dinas ESDM Wilayah Serayu Tengah'),
	(16, 'lab_esdm', 'Laboratorium ESDM');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_login_attempts
DROP TABLE IF EXISTS `tbl_ion_login_attempts`;
CREATE TABLE IF NOT EXISTS `tbl_ion_login_attempts` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) DEFAULT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_login_attempts: ~0 rows (approximately)
DELETE FROM `tbl_ion_login_attempts`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_modules
DROP TABLE IF EXISTS `tbl_ion_modules`;
CREATE TABLE IF NOT EXISTS `tbl_ion_modules` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT 'Untuk modul dengan sub-menu',
  `name` varchar(100) NOT NULL COMMENT 'Nama modul (ex: Barang, Kategori)',
  `route` varchar(100) NOT NULL COMMENT 'ex: Master/Item',
  `icon` varchar(100) DEFAULT NULL,
  `is_menu` enum('0','1') NOT NULL DEFAULT '1' COMMENT 'tampil di sidebar',
  `is_active` enum('0','1') NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `default_permissions` text DEFAULT NULL COMMENT 'JSON: {"create":true,"read_all":true}',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_modules: ~20 rows (approximately)
DELETE FROM `tbl_ion_modules`;
INSERT INTO `tbl_ion_modules` (`id`, `parent_id`, `name`, `route`, `icon`, `is_menu`, `is_active`, `sort_order`, `default_permissions`) VALUES
	(1, 0, 'Master Data', 'Master', 'fas fa-database', '1', '1', 1, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"export":true,"import":true}'),
	(2, 1, 'Item/Barang', 'Master/Item', 'fas fa-box', '1', '1', 1, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"export":true,"import":true}'),
	(3, 1, 'Kategori', 'Master/Kategori', 'fas fa-tags', '1', '1', 2, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(4, 1, 'Supplier', 'Master/Supplier', 'fas fa-truck', '1', '1', 3, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(5, 1, 'Pelanggan', 'Master/Pelanggan', 'fas fa-users', '1', '1', 4, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(6, 1, 'Karyawan', 'Master/Karyawan', 'fas fa-user-tie', '1', '1', 5, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(7, 1, 'Gudang', 'Master/Gudang', 'fas fa-warehouse', '1', '1', 6, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(8, 0, 'Transaksi', 'Transaksi', 'fas fa-exchange-alt', '1', '1', 2, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"approve":true,"reject":true}'),
	(9, 8, 'Pembelian', 'Transaksi/Pembelian', 'fas fa-shopping-cart', '1', '1', 1, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"approve":true,"reject":true}'),
	(10, 8, 'Penjualan', 'Transaksi/Penjualan', 'fas fa-cash-register', '1', '1', 2, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"approve":true,"reject":true}'),
	(11, 0, 'Gudang', 'Gudang', 'fas fa-boxes', '1', '1', 3, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(12, 11, 'Input Stok', 'Gudang/InputStok', 'fas fa-plus-square', '1', '1', 1, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(13, 11, 'Inventori', 'Gudang/Inventori', 'fas fa-clipboard-list', '1', '1', 2, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true,"export":true}'),
	(14, 0, 'Laporan', 'Laporan', 'fas fa-chart-bar', '1', '1', 4, '{"read":true,"read_all":true,"export":true}'),
	(15, 14, 'Laporan Outlet', 'Laporan/Outlet', 'fas fa-store', '1', '1', 1, '{"read":true,"read_all":true,"export":true}'),
	(16, 14, 'Laporan Penjualan', 'Laporan/Penjualan', 'fas fa-chart-line', '1', '1', 2, '{"read":true,"read_all":true,"export":true}'),
	(17, 0, 'Pengaturan', 'Pengaturan', 'fas fa-cog', '1', '1', 5, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(18, 17, 'Modul', 'Pengaturan/Modules', 'fas fa-puzzle-piece', '1', '1', 1, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(19, 17, 'Printer', 'Pengaturan/Printer', 'fas fa-print', '1', '1', 2, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}'),
	(20, 17, 'PU Menu', 'Pengaturan/PuMenu', 'fas fa-list', '1', '1', 3, '{"create":true,"read":true,"read_all":true,"update":true,"update_all":true,"delete":true,"delete_all":true}');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_permissions
DROP TABLE IF EXISTS `tbl_ion_permissions`;
CREATE TABLE IF NOT EXISTS `tbl_ion_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` int(11) unsigned NOT NULL COMMENT 'Reference to tbl_ion_modules.id',
  `action_id` int(11) unsigned NOT NULL COMMENT 'Reference to tbl_ion_actions.id',
  `group_id` int(11) unsigned DEFAULT NULL COMMENT 'Reference to groups.id (null for user-specific)',
  `user_id` int(11) unsigned DEFAULT NULL COMMENT 'Reference to users.id (null for group-specific)',
  `is_granted` enum('0','1') NOT NULL DEFAULT '1' COMMENT '1 = granted, 0 = denied',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_id_action_id_group_id_user_id` (`module_id`,`action_id`,`group_id`,`user_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_permissions: ~0 rows (approximately)
DELETE FROM `tbl_ion_permissions`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_users
DROP TABLE IF EXISTS `tbl_ion_users`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `pin` varchar(6) DEFAULT NULL COMMENT 'PIN for additional authentication',
  `email` varchar(254) NOT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile` varchar(160) DEFAULT NULL,
  `tipe` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 => karyawan, 2 => anggota',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `activation_selector` (`activation_selector`),
  UNIQUE KEY `forgotten_password_selector` (`forgotten_password_selector`),
  UNIQUE KEY `remember_selector` (`remember_selector`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_users: ~15 rows (approximately)
DELETE FROM `tbl_ion_users`;
INSERT INTO `tbl_ion_users` (`id`, `ip_address`, `username`, `password`, `pin`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `profile`, `tipe`) VALUES
	(1, '127.0.0.1', 'root', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'root@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1268889823, 1, 'Root', 'User', 'ADMIN', '', '', '1'),
	(2, '127.0.0.1', 'superadmin', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', '123456', 'superadmin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1760761013, 1, 'Superadmin', 'SS', '123456789', '', 'public/file/profile/avatar_2_1759926555.png', '1'),
	(3, '127.0.0.1', 'user_sekretariat', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'sekretariat@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Sekretariat', NULL, 'ADMIN', NULL, NULL, '1'),
	(4, '127.0.0.1', 'user_minerba', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'minerba@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Minerba', NULL, 'ADMIN', NULL, NULL, '1'),
	(5, '127.0.0.1', 'user_tnglistrik', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'ketenagalistrikan@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Ketenagalistrikan', NULL, 'ADMIN', NULL, NULL, '1'),
	(6, '127.0.0.1', 'user_energi', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'energi_baru@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Energi Baru', NULL, 'ADMIN', NULL, NULL, '1'),
	(7, '127.0.0.1', 'user_geologi', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'geologi_air@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Geologi Air', NULL, 'ADMIN', NULL, NULL, '1'),
	(8, '127.0.0.1', 'user_ungaran', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'ungaran_telomoyo@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Ungaran Telomoyo', NULL, 'ADMIN', NULL, NULL, '1'),
	(9, '127.0.0.1', 'kendeng_selatan', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'kendeng_selatan@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Kendeng Selatan', NULL, 'ADMIN', NULL, NULL, '1'),
	(10, '127.0.0.1', 'sewu_lawu', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'sewu_lawu@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Sewu Lawu', NULL, 'ADMIN', NULL, NULL, '1'),
	(11, '127.0.0.1', 'slamet_selatan', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'slamet_selatan@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Slamet Selatan', NULL, 'ADMIN', NULL, NULL, '1'),
	(12, '127.0.0.1', 'semarang_demak', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'semarang_demak@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Semarang Demak', NULL, 'ADMIN', NULL, NULL, '1'),
	(13, '127.0.0.1', 'merapi', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'merapi@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Merapi', NULL, 'ADMIN', NULL, NULL, '1'),
	(14, '127.0.0.1', 'serayu_tengah', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'serayu_tengah@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Serayu Tengah', NULL, 'ADMIN', NULL, NULL, '1'),
	(15, '127.0.0.1', 'lab_esdm', '$2y$10$gQoEoZYp8Rz2iK9m.c1nZOQ3mJy53.Bb89WoV4m9/RxUTRVpY2FGW', NULL, 'lab_esdm@admin.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1758465619, NULL, 1, 'Laboratorium ESDM', NULL, 'ADMIN', NULL, NULL, '1');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_ion_users_groups
DROP TABLE IF EXISTS `tbl_ion_users_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tbl_ion_users_groups_user_id_foreign` (`user_id`),
  KEY `tbl_ion_users_groups_group_id_foreign` (`group_id`),
  CONSTRAINT `tbl_ion_users_groups_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `tbl_ion_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tbl_ion_users_groups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `tbl_ion_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_ion_users_groups: ~15 rows (approximately)
DELETE FROM `tbl_ion_users_groups`;
INSERT INTO `tbl_ion_users_groups` (`id`, `user_id`, `group_id`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(3, 3, 2),
	(4, 4, 2),
	(5, 5, 2),
	(6, 6, 2),
	(7, 7, 2),
	(8, 8, 2),
	(9, 9, 2),
	(10, 10, 2),
	(11, 11, 2),
	(12, 12, 2),
	(13, 13, 2),
	(14, 14, 2),
	(15, 15, 2);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_links
DROP TABLE IF EXISTS `tbl_links`;
CREATE TABLE IF NOT EXISTS `tbl_links` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `links` varchar(255) NOT NULL COMMENT 'https://<domain>',
  `tipe` tinyint(1) NOT NULL DEFAULT 1,
  `keterangan` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0=nonaktif, 1=aktif',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_links: ~2 rows (approximately)
DELETE FROM `tbl_links`;
INSERT INTO `tbl_links` (`id`, `name`, `links`, `tipe`, `keterangan`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'kjhkjh', 'https://barra.co.id', 2, 'kjhkjh', '1', '2025-10-07 19:03:11', '2025-10-07 19:03:19', '2025-10-07 19:03:19'),
	(2, 'test', 'https://google.com', 2, '', '1', '2025-10-07 19:03:33', '2025-10-07 19:03:39', '2025-10-07 19:03:39'),
	(3, 'ESDM GIS Infrastruktur', 'https://esdmjateng.gis.co.id/', 1, '', '1', '2025-10-14 14:54:40', '2025-10-14 14:54:40', NULL),
	(4, 'Mikhael Felian Waskito', 'https://www.google.com', 2, '', '1', '2025-10-17 00:08:36', '2025-10-17 00:08:48', '2025-10-17 00:08:48'),
	(5, 'ESDM Feedback', 'https://sites.google.com/view/esdm-inovations/beranda', 2, 'Sarana penyampaian inovasi, saran, kritik', '1', '2025-10-18 11:03:44', '2025-10-18 11:03:44', NULL);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_manajemen_risiko
DROP TABLE IF EXISTS `tbl_manajemen_risiko`;
CREATE TABLE IF NOT EXISTS `tbl_manajemen_risiko` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `month` char(2) NOT NULL DEFAULT '01',
  `uraian` varchar(255) NOT NULL,
  `fupload` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_manajemen_risiko: ~4 rows (approximately)
DELETE FROM `tbl_manajemen_risiko`;
INSERT INTO `tbl_manajemen_risiko` (`id`, `year`, `month`, `uraian`, `fupload`, `created_at`, `updated_at`) VALUES
	(1, '2025', '01', 'Laporan Pengelolaan Risiko Semester II Tahun 2024', '/file/risiko/1/risiko_1_1760515671.pdf', '2025-10-15 15:07:51', '2025-10-15 15:07:51'),
	(2, '2025', '07', 'Laporan Pengelolaan Risiko Semester I Tahun 2025', '/file/risiko/2/risiko_2_1760515732.pdf', '2025-10-15 15:08:52', '2025-10-15 15:08:52'),
	(3, '2025', '01', 'Berita Acara Hasil Evaluasi Pengelolaan Risiko Semester II Tahun 2024', '/file/risiko/3/risiko_3_1760516311.pdf', '2025-10-15 15:18:31', '2025-10-15 15:18:31'),
	(4, '2025', '08', 'Berita Acara Hasil Evaluasi Pengelolaan Risiko Semester I Tahun 2025', '/file/risiko/4/risiko_4_1760516436.pdf', '2025-10-15 15:20:36', '2025-10-15 15:20:36');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_m_ukp
DROP TABLE IF EXISTS `tbl_m_ukp`;
CREATE TABLE IF NOT EXISTS `tbl_m_ukp` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kode_ukp` varchar(50) NOT NULL,
  `nama_ukp` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `kepala_ukp` varchar(255) DEFAULT NULL,
  `nip_kepala` varchar(50) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') NOT NULL DEFAULT 'Aktif',
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode_ukp` (`kode_ukp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_m_ukp: ~0 rows (approximately)
DELETE FROM `tbl_m_ukp`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_m_unit_kerja
DROP TABLE IF EXISTS `tbl_m_unit_kerja`;
CREATE TABLE IF NOT EXISTS `tbl_m_unit_kerja` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `kode_unit_kerja` varchar(50) NOT NULL,
  `nama_unit_kerja` varchar(255) NOT NULL COMMENT 'Nama unit kerja untuk display utama',
  `alamat` text DEFAULT NULL COMMENT 'Alamat lengkap unit kerja',
  `telepon` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kepala_unit_kerja` varchar(255) DEFAULT NULL,
  `nip_kepala` varchar(50) DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif') DEFAULT 'Aktif' COMMENT 'Status unit kerja',
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kode_unit_kerja` (`kode_unit_kerja`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_m_unit_kerja: ~12 rows (approximately)
DELETE FROM `tbl_m_unit_kerja`;
INSERT INTO `tbl_m_unit_kerja` (`id`, `kode_unit_kerja`, `nama_unit_kerja`, `alamat`, `telepon`, `email`, `kepala_unit_kerja`, `nip_kepala`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
	(10, 'UK001', 'Cabdin Wil. Solo', '', '', '', '', '', 'Aktif', '', '2025-10-14 11:59:08', '2025-10-14 11:59:08'),
	(11, 'UK002', 'Cabdin Wil. Kendeng Muria', '', '', '', '', '', 'Aktif', '', '2025-10-14 11:59:23', '2025-10-14 11:59:23'),
	(12, 'UK003', 'Cabdin Wil. Serayu Utara', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:00:19', '2025-10-14 12:00:19'),
	(13, 'UK004', 'Cabdin Wil. Serayu Selatan', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:00:26', '2025-10-14 12:00:26'),
	(15, 'UK005', 'Cabdin Wil. Slamet Utara', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:00:45', '2025-10-14 12:00:45'),
	(17, 'UK007', 'Cabdin Wil. Ungaran Telomoyo', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:00:57', '2025-10-16 06:51:21'),
	(18, 'UK008', 'Cabdin Wil. Kendeng Selatan', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:01:03', '2025-10-16 06:52:52'),
	(19, 'UK009', 'Cabdin Wil. Sewu Lawu', '', '', '', '', '', 'Aktif', '', '2025-10-14 12:01:09', '2025-10-16 06:53:11'),
	(29, 'UK009', 'Cabdin Wil. Slamet Selatan', '', '', '', '', '', 'Aktif', '', '2025-10-16 06:47:34', '2025-10-16 06:47:34'),
	(30, 'UK010', 'Cabdin Wil. Serayu Tengah', '', '', '', '', '', 'Aktif', '', '2025-10-16 06:48:36', '2025-10-16 06:48:36'),
	(31, 'UK011', 'Cabdin Wil. Merapi', '', '', '', '', '', 'Aktif', '', '2025-10-16 06:48:44', '2025-10-16 06:48:44'),
	(32, 'UK012', 'Cabdin Wil. Semarang Demak', '', '', '', '', '', 'Aktif', '', '2025-10-16 06:48:50', '2025-10-16 06:48:50');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pbj
DROP TABLE IF EXISTS `tbl_pbj`;
CREATE TABLE IF NOT EXISTS `tbl_pbj` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `rup_tender_pagu` bigint(20) DEFAULT 0,
  `rup_tender_realisasi` bigint(20) DEFAULT 0,
  `rup_epurchasing_pagu` bigint(20) DEFAULT 0,
  `rup_epurchasing_realisasi` bigint(20) DEFAULT 0,
  `rup_nontender_pagu` bigint(20) DEFAULT 0,
  `rup_nontender_realisasi` bigint(20) DEFAULT 0,
  `swakelola_pagu` bigint(20) DEFAULT 0,
  `swakelola_realisasi` bigint(20) DEFAULT 0,
  `keterangan_tender` text DEFAULT NULL,
  `keterangan_epurchasing` text DEFAULT NULL,
  `keterangan_nontender` text DEFAULT NULL,
  `keterangan_swakelola` text DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pbj: ~0 rows (approximately)
DELETE FROM `tbl_pbj`;
INSERT INTO `tbl_pbj` (`id`, `tahun`, `bulan`, `rup_tender_pagu`, `rup_tender_realisasi`, `rup_epurchasing_pagu`, `rup_epurchasing_realisasi`, `rup_nontender_pagu`, `rup_nontender_realisasi`, `swakelola_pagu`, `swakelola_realisasi`, `keterangan_tender`, `keterangan_epurchasing`, `keterangan_nontender`, `keterangan_swakelola`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 2025, 1, 0, 0, 9959124000, 224430530, 5567002000, 114374953, 8822408000, 22169000, '-', '-', '-', '-', 2, '2025-10-15 11:01:04', '2025-10-15 10:21:24', '2025-10-15 11:01:04'),
	(2, 2025, 2, 0, 0, 9957874000, 434110972, 5688252000, 231387762, 8702408000, 124961500, '-', '-', '-', '-', 2, '2025-10-15 12:18:36', '2025-10-15 12:18:25', '2025-10-15 12:18:36'),
	(3, 2025, 3, 0, 0, 9143506000, 621023550, 5034259000, 300774450, 5602927000, 275704850, '-', '-', '-', '-', 2, '2025-10-15 12:20:34', '2025-10-15 12:20:34', '2025-10-15 12:20:34'),
	(4, 2025, 4, 0, 0, 9082866000, 866380950, 5094899000, 460399839, 5602927000, 519818200, '-', '-', '-', '-', 2, '2025-10-15 12:22:46', '2025-10-15 12:22:46', '2025-10-15 12:22:46'),
	(5, 2025, 5, 0, 0, 9082866000, 1533662714, 5094899000, 611373737, 5602927000, 690326200, '-', '-', 'Unit kerja yang belum melakukan pencatatan non tender/realisasi non tender masih 0%:\n-	Bidang GAT;\n-	Bidang Ketenagalistrikan;\n-	Cabang Dinas Serayu Selatan;\n-	Cabang Dinas Slamet Utara;\n-	Cabang Dinas Kendeng Selatan;\n-	Cabang Dinas Slamet Selatan;\n-	Cabang Dinas Serayu Tengah;\n-	Cabang Dinas Semarang Demak.', 'Unit kerja yang belum melakukan pencatatan swakelola:\n-	Bidang GAT;\n-	Bidang Minerba;\n-	Bidang Ketenagalistrikan;\n-	Cabang Dinas Serayu Selatan;\n-	Cabang Dinas Slamet Utara;\n-	Cabang Dinas Kendeng Selatan;\n-	Cabang Dinas Slamet Selatan;\n-	Cabang Dinas Serayu Tengah;\n-	Cabang Dinas Semarang Demak.', 2, '2025-10-15 14:04:16', '2025-10-15 13:59:42', '2025-10-15 14:04:16'),
	(6, 2025, 6, 0, 0, 9326301000, 1390254900, 4648264000, 756390805, 5806127000, 787384200, '-', '-', 'Unit kerja yang belum melakukan pencatatan non tender/realisasi non tender masih 0%:\n-	Bidang GAT;\n-	Bidang Ketenagalistrikan;\n-	Cabang Dinas Serayu Selatan;\n-	Cabang Dinas Slamet Utara;\n-	Cabang Dinas Kendeng Selatan;\n-	Cabang Dinas Slamet Selatan;\n-	Cabang Dinas Serayu Tengah;\n-	Cabang Dinas Semarang Demak.', 'Unit kerja yang belum melakukan pencatatan swakelola:\n-	Bidang GAT;\n-	Bidang Minerba;\n-	Bidang Ketenagalistrikan;\n-	Cabang Dinas Serayu Selatan;\n-	Cabang Dinas Slamet Utara;\n-	Cabang Dinas Kendeng Selatan;\n-	Cabang Dinas Slamet Selatan;\n-	Cabang Dinas Serayu Tengah;\n-	Cabang Dinas Semarang Demak.', 2, '2025-10-15 14:03:57', '2025-10-15 14:03:12', '2025-10-15 14:03:57'),
	(7, 2025, 7, 0, 0, 9350278000, 1896255140, 4624287000, 1637243107, 5806127000, 2371203543, '-', '-', 'Unit kerja yang dengan realisasi non tender <50%:\n-	Sekretariat;\n-	Bidang Geologi dan Air Tanah;\n-	Bidang Ketenagalistrikan (pekerjaan belum dilaksanakan);\n-	Cabdin Wil. Solo;\n-	Cabdin Wil. Kendeng Muria;\n-	Cabdin Wil. Serayu Utara;\n-	Cabdin Wil. Serayu Selatan;\n-	Cabdin Wil. Slamet Utara;\n-	Cabdin Wil. Kendeng Selatan;\n-	Cabdin Wil. Sewu Lawu;\n-	Cabdin Wil. Slamet Selatan;\n-	UPT Laboratorium;\n-	Cabdin Wil. Serayu Tengah;\n-	Cabdin Wil. Merapi;\n-	Cabdin Wil. Semarang Demak.', 'Unit kerja yang dengan realisasi pencatatan swakelola <50%:\n-	Sekretariat;\n-	Bidang Geologi dan Air Tanah;\n-	Bidang Mineral dan Batubara;\n-	Bidang Energi Baru Terbarukan;\n-	Cabdin Wil. Solo;\n-	Cabdin Wil. Kendeng Muria;\n-	Cabdin Wil. Slamet Utara\n-	Cabdin Wil. Kendeng Selatan;\n-	Cabdin Wil. Sewu Lawu;\n-	UPT Laboratorium;\n-	Cabdin Wil. Serayu Tengah;\n-	Cabdin Wil. Merapi;\n-	Cabdin Wil. Semarang Demak.\n', 2, '2025-10-15 14:12:12', '2025-10-15 14:12:12', '2025-10-15 14:12:12'),
	(8, 2025, 8, 0, 0, 9400278000, 3548174705, 4574287000, 2116771523, 5806127000, 3647448937, '-', '-', 'Unit kerja yang dengan realisasi non tender <50%:\n-	Bidang Geologi dan Air Tanah;\n-	Bidang Ketenagalistrikan;\n-	Cabdin Wil. Serayu Utara;\n-	Cabdin Wil. Serayu Selatan;\n-	Cabdin Wil. Slamet Utara;\n-	Cabdin Wil. Kendeng Selatan;\n-	Cabdin Wil. Sewu Lawu;\n-	Cabdin Wil. Slamet Selatan;\n-	UPT Laboratorium;\n-	Cabdin Wil. Merapi;\n-	Cabdin Wil. Semarang Demak.', 'Unit kerja yang dengan realisasi pencatatan swakelola <50%:\n-	Bidang Energi Baru Terbarukan;\n-	Cabdin Wil. Solo;\n-	Cabdin Wil. Kendeng Muria;\n-	Cabdin Wil. Sewu Lawu;\n-	Cabdin Wil. Serayu Tengah.', 2, '2025-10-15 14:34:41', '2025-10-15 14:34:17', '2025-10-15 14:34:41'),
	(9, 2025, 9, 0, 0, 9350830750, 3656979905, 4868886250, 2156690715, 5586413000, 3683158522, '-', '-', 'Unit kerja yang dengan realisasi non tender <60%:\n-	Sekretariat\n-	Cabdin Wil. Solo;\n-	Cabdin Wil. Serayu Utara;\n-	Cabdin Wil. Serayu Selatan;\n-	Cabdin Wil. Slamet Utara;\n-	Cabdin Wil. Ungaran Telomoyo;\n-	Cabdin Wil. Kendeng Selatan;\n-	Cabdin Wil. Sewu Lawu;\n-	Cabdin Wil. Slamet Selatan;\n-	UPT Laboratorium;\n-	Cabdin Wil. Merapi;\n-	Cabdin Wil. Semarang Demak.', 'Unit kerja yang dengan realisasi pencatatan swakelola <60%:\n-	Sekretariat\n-	Bidang Energi Baru Terbarukan;\n-	Cabdin Wil. Solo;\n-	Cabdin Wil. Kendeng Muria;\n-	Cabdin Wil. Kendeng Selatan;\n-	Cabdin Wil. Sewu Lawu;\n-	Cabdin Wil. Serayu Tengah;\n-	Cabdin Wil. Semarang Demak.', 2, '2025-10-15 14:38:08', '2025-10-15 14:38:08', '2025-10-15 14:38:08');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pbj_pdn
DROP TABLE IF EXISTS `tbl_pbj_pdn`;
CREATE TABLE IF NOT EXISTS `tbl_pbj_pdn` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `pagu_rup_tagging_pdn` bigint(20) DEFAULT 0,
  `realisasi_pdn` bigint(20) DEFAULT 0,
  `indeks` decimal(10,2) DEFAULT 0.00,
  `keterangan` text DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pbj_pdn: ~0 rows (approximately)
DELETE FROM `tbl_pbj_pdn`;
INSERT INTO `tbl_pbj_pdn` (`id`, `tahun`, `bulan`, `pagu_rup_tagging_pdn`, `realisasi_pdn`, `indeks`, `keterangan`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 2025, 1, 15014550000, 338805483, 2.26, '-	Telah mengajukan permohonan sebagaimana surat Kepala Dinas ESDM Prov. Jateng Nomor 000.3.1/10025 tanggal 30 Desember 2024 perihal Permohonan Persetujuan Pengadaan Bahan/Reagen, Peralatan, dan Perlengkapan Laboratorium Impor dan Non TKDN. \n-	Telah terbit hasil reviu melalui surat Gubernur Jawa Tengah Nomor 700/088/W.KPD/2025 tanggal 17 Januari 2025 perihal Laporan Hasil Reviu atas Pengadaan Barang Non TKDN Tahun 2025 pada Dinas Energi dan Sumber Daya Mineral Provinsi Jawa Tengah.', 2, '2025-10-15 14:40:52', '2025-10-15 14:40:52', '2025-10-15 14:40:52'),
	(2, 2025, 2, 15134550000, 665158404, 4.39, '-	Telah terbit hasil reviu melalui surat Gubernur Jawa Tengah Nomor 000.3/218  tanggal 9 Februari 2025 perihal Hasil Reviu atas Pengadaan Barang Non TKDN Tahun 2025 pada Dinas Energi dan Sumber Daya Mineral Provinsi Jawa Tengah.', 2, '2025-10-15 14:41:59', '2025-10-15 14:41:59', '2025-10-15 14:41:59'),
	(3, 2025, 3, 13690686000, 905199428, 6.61, '-', 2, '2025-10-15 14:43:40', '2025-10-15 14:43:40', '2025-10-15 14:43:40'),
	(4, 2025, 4, 13690686000, 1227818598, 8.97, '-', 2, '2025-10-15 14:44:29', '2025-10-15 14:44:29', '2025-10-15 14:44:29'),
	(5, 2025, 5, 13690686000, 2019523058, 14.75, '-', 2, '2025-10-15 14:45:49', '2025-10-15 14:45:49', '2025-10-15 14:45:49'),
	(6, 2025, 6, 13500186000, 2795202658, 20.70, '-', 2, '2025-10-15 14:50:07', '2025-10-15 14:49:04', '2025-10-15 14:50:07'),
	(7, 2025, 7, 13500186000, 4518963396, 33.47, '-', 2, '2025-10-15 14:51:22', '2025-10-15 14:51:22', '2025-10-15 14:51:22'),
	(8, 2025, 8, 13500186000, 5316568073, 39.38, '-', 2, '2025-10-15 14:53:15', '2025-10-15 14:53:15', '2025-10-15 14:53:15'),
	(9, 2025, 9, 13822328000, 5447584481, 39.41, '-', 2, '2025-10-15 14:54:25', '2025-10-15 14:54:25', '2025-10-15 14:54:25');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pbj_progres
DROP TABLE IF EXISTS `tbl_pbj_progres`;
CREATE TABLE IF NOT EXISTS `tbl_pbj_progres` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `catatan_kendala` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `feedback_unit_kerja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`feedback_unit_kerja`)),
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` int(11) unsigned DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_verifikasi` enum('Belum Diperiksa','Sesuai','Tidak Sesuai') DEFAULT 'Belum Diperiksa',
  `catatan_tambahan` text DEFAULT NULL,
  `verifikasi_by` int(11) unsigned DEFAULT NULL,
  `verifikasi_at` datetime DEFAULT NULL,
  `feedback_by` int(11) unsigned DEFAULT NULL,
  `feedback_at` datetime DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pbj_progres: ~9 rows (approximately)
DELETE FROM `tbl_pbj_progres`;
INSERT INTO `tbl_pbj_progres` (`id`, `tahun`, `bulan`, `status`, `catatan_kendala`, `rencana_tindak_lanjut`, `feedback_unit_kerja`, `file_path`, `file_name`, `file_size`, `keterangan`, `status_verifikasi`, `catatan_tambahan`, `verifikasi_by`, `verifikasi_at`, `feedback_by`, `feedback_at`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(1, 2025, 10, 'Belum Diperiksa', 'uiui', 'uyiuyiyu', '[]', 'file/pbj/progres/2025/pbj_progres_2025_10_1759643172.pdf', 'sample.pdf', 18810, 'hghgfhgfh', 'Belum Diperiksa', NULL, 2, '2025-10-05 13:00:51', 2, '2025-10-05 13:23:29', 2, '2025-10-16 23:58:33', '2025-10-05 12:42:26', '2025-10-16 23:58:33'),
	(2, 2025, 3, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_3_1760515147.pdf', 'Monitoring pengadaan Maret 2025.pdf', 54058, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 14:59:07', '2025-10-15 14:56:14', '2025-10-15 14:59:07'),
	(3, 2025, 4, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_4_1760515022.pdf', 'Monit Pengadaan April 2025.pdf', 56810, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 14:57:02', '2025-10-15 14:57:02', '2025-10-15 14:57:02'),
	(4, 2025, 5, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_5_1760515116.pdf', 'Monitoring pengadaan Mei 2025.pdf', 55246, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 14:58:36', '2025-10-15 14:58:36', '2025-10-15 14:58:36'),
	(5, 2025, 6, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_6_1760515189.pdf', 'Monitoring pengadaan Juni 2025.pdf', 55485, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 14:59:49', '2025-10-15 14:59:49', '2025-10-15 14:59:49'),
	(6, 2025, 7, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_7_1760515228.pdf', 'Monit Progress PBJ Juli 2025.pdf', 55295, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 15:00:28', '2025-10-15 15:00:28', '2025-10-15 15:00:28'),
	(7, 2025, 9, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_9_1760515348.pdf', 'Monitoring Pengadaan September 2025.pdf', 56024, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 15:02:28', '2025-10-15 15:02:28', '2025-10-15 15:02:28'),
	(8, 2025, 1, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_1_1760516711.pdf', 'MONITRG PENGADAAN POK  JAN 25.pdf', 46077, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 15:25:11', '2025-10-15 15:25:11', '2025-10-15 15:25:11'),
	(9, 2025, 2, 'Belum Diperiksa', NULL, NULL, NULL, 'file/pbj/progres/2025/pbj_progres_2025_2_1760516728.pdf', 'MONITRNG PENGADAAN POK FEB 25.pdf', 125208, '', 'Belum Diperiksa', NULL, NULL, NULL, NULL, NULL, 2, '2025-10-15 15:25:28', '2025-10-15 15:25:28', '2025-10-15 15:25:28');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pendapatan
DROP TABLE IF EXISTS `tbl_pendapatan`;
CREATE TABLE IF NOT EXISTS `tbl_pendapatan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL COMMENT 'Tahun anggaran',
  `tahapan` varchar(50) NOT NULL COMMENT 'Tahapan APBD (penetapan, pergeseran, perubahan)',
  `retribusi_penyewaan` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
  `retribusi_laboratorium` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
  `retribusi_alat` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
  `hasil_kerjasama` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Hasil Kerja Sama Pemanfaatan BMD',
  `penerimaan_komisi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Penerimaan Komisi, Potongan, atau Bentuk Lain',
  `sewa_ruang_koperasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Sewa Ruang Koperasi',
  `total` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total pendapatan',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tahun_tahapan` (`tahun`,`tahapan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pendapatan: ~2 rows (approximately)
DELETE FROM `tbl_pendapatan`;
INSERT INTO `tbl_pendapatan` (`id`, `tahun`, `tahapan`, `retribusi_penyewaan`, `retribusi_laboratorium`, `retribusi_alat`, `hasil_kerjasama`, `penerimaan_komisi`, `sewa_ruang_koperasi`, `total`, `created_at`, `updated_at`) VALUES
	(1, 2025, 'penetapan', 25200000.00, 850000000.00, 780000000.00, 1655429000.00, 0.00, 1200000.00, 3311829000.00, '2025-10-08 19:52:19', '2025-10-16 23:55:27'),
	(2, 2025, 'pergeseran', 25200000.00, 850000000.00, 780000000.00, 1655429000.00, 0.00, 1200000.00, 3311829000.00, '2025-10-15 07:17:38', '2025-10-15 07:19:18'),
	(3, 2025, 'perubahan', 25200000.00, 850000000.00, 807000000.00, 1655429000.00, 0.00, 1200000.00, 3338829000.00, '2025-10-15 07:17:48', '2025-10-15 07:56:46');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pendapatan_input
DROP TABLE IF EXISTS `tbl_pendapatan_input`;
CREATE TABLE IF NOT EXISTS `tbl_pendapatan_input` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL COMMENT 'Tahun anggaran',
  `tahapan` varchar(50) NOT NULL COMMENT 'Tahapan APBD (penetapan, pergeseran, perubahan)',
  `bulan` int(2) NOT NULL COMMENT 'Bulan (1-12)',
  `retribusi_penyewaan_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
  `retribusi_penyewaan_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Retribusi Pemanfaatan Aset Daerah - Penyewaan Tanah dan Bangunan',
  `retribusi_laboratorium_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
  `retribusi_laboratorium_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Retribusi Pemanfaatan Aset Daerah - Pemakaian Laboratorium',
  `retribusi_alat_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
  `retribusi_alat_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Retribusi Pemanfaatan Aset Daerah - Pemakaian Alat (Drone dan Camera Hole)',
  `hasil_kerjasama_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Hasil Kerja Sama Pemanfaatan BMD',
  `hasil_kerjasama_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Hasil Kerja Sama Pemanfaatan BMD',
  `penerimaan_komisi_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Penerimaan Komisi, Potongan, atau Bentuk Lain',
  `penerimaan_komisi_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Penerimaan Komisi, Potongan, atau Bentuk Lain',
  `sewa_ruang_koperasi_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Target Sewa Ruang Koperasi',
  `sewa_ruang_koperasi_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Realisasi Sewa Ruang Koperasi',
  `total_target` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total target',
  `total_realisasi` decimal(15,2) NOT NULL DEFAULT 0.00 COMMENT 'Total realisasi',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tahun_tahapan_bulan` (`tahun`,`tahapan`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pendapatan_input: ~10 rows (approximately)
DELETE FROM `tbl_pendapatan_input`;
INSERT INTO `tbl_pendapatan_input` (`id`, `tahun`, `tahapan`, `bulan`, `retribusi_penyewaan_target`, `retribusi_penyewaan_realisasi`, `retribusi_laboratorium_target`, `retribusi_laboratorium_realisasi`, `retribusi_alat_target`, `retribusi_alat_realisasi`, `hasil_kerjasama_target`, `hasil_kerjasama_realisasi`, `penerimaan_komisi_target`, `penerimaan_komisi_realisasi`, `sewa_ruang_koperasi_target`, `sewa_ruang_koperasi_realisasi`, `total_target`, `total_realisasi`, `created_at`, `updated_at`) VALUES
	(1, 2025, 'penetapan', 9, 25200000.00, 2025000.00, 850000000.00, 53223000.00, 780000000.00, 81452500.00, 1655429000.00, 128155000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 264855500.00, '2025-10-08 19:53:21', '2025-10-16 23:55:34'),
	(2, 2025, 'penetapan', 1, 25200000.00, 1950000.00, 850000000.00, 48636000.00, 780000000.00, 48952500.00, 1655429000.00, 0.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 99538500.00, '2025-10-14 13:34:33', '2025-10-15 07:21:24'),
	(3, 2025, 'pergeseran', 1, 25200000.00, 1950000.00, 850000000.00, 48636000.00, 780000000.00, 48952500.00, 1655429000.00, 0.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 99538500.00, '2025-10-15 07:21:40', '2025-10-15 07:22:30'),
	(4, 2025, 'perubahan', 1, 25200000.00, 1950000.00, 850000000.00, 48636000.00, 780000000.00, 48952500.00, 1655429000.00, 0.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 99538500.00, '2025-10-15 07:21:48', '2025-10-15 07:22:42'),
	(5, 2025, 'penetapan', 2, 25200000.00, 1950000.00, 850000000.00, 29618000.00, 780000000.00, 268544250.00, 1655429000.00, 120877000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 420989250.00, '2025-10-15 07:25:27', '2025-10-15 07:25:27'),
	(6, 2025, 'pergeseran', 2, 25200000.00, 1950000.00, 850000000.00, 29618000.00, 780000000.00, 268544250.00, 1655429000.00, 120877000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 420989250.00, '2025-10-15 07:25:50', '2025-10-15 07:28:15'),
	(7, 2025, 'perubahan', 2, 25200000.00, 1950000.00, 850000000.00, 29618000.00, 780000000.00, 268544250.00, 1655429000.00, 120877000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 420989250.00, '2025-10-15 07:25:59', '2025-10-15 07:28:25'),
	(8, 2025, 'penetapan', 3, 25200000.00, 1950000.00, 850000000.00, 53012000.00, 780000000.00, 71430000.00, 1655429000.00, 0.00, 0.00, 3500000.00, 1200000.00, 0.00, 3311829000.00, 129892000.00, '2025-10-15 07:30:13', '2025-10-15 07:30:13'),
	(9, 2025, 'pergeseran', 3, 25200000.00, 1950000.00, 850000000.00, 53012000.00, 780000000.00, 71430000.00, 1655429000.00, 0.00, 0.00, 3500000.00, 1200000.00, 0.00, 3311829000.00, 129892000.00, '2025-10-15 07:31:17', '2025-10-15 07:31:17'),
	(10, 2025, 'perubahan', 3, 25200000.00, 1950000.00, 850000000.00, 53012000.00, 780000000.00, 71430000.00, 1655429000.00, 0.00, 0.00, 3500000.00, 1200000.00, 0.00, 3311829000.00, 129892000.00, '2025-10-15 07:31:51', '2025-10-15 07:31:51'),
	(11, 2025, 'penetapan', 4, 25200000.00, 2550000.00, 850000000.00, 32531000.00, 780000000.00, 55690000.00, 1655429000.00, 75066000.00, 0.00, 7500.00, 1200000.00, 0.00, 3311829000.00, 165844500.00, '2025-10-15 07:33:56', '2025-10-15 07:33:56'),
	(12, 2025, 'pergeseran', 4, 25200000.00, 2550000.00, 850000000.00, 32531000.00, 780000000.00, 55690000.00, 1655429000.00, 75066000.00, 0.00, 7500.00, 1200000.00, 0.00, 3311829000.00, 165844500.00, '2025-10-15 07:34:38', '2025-10-15 07:34:38'),
	(13, 2025, 'perubahan', 4, 25200000.00, 2550000.00, 850000000.00, 32531000.00, 780000000.00, 55690000.00, 1655429000.00, 75066000.00, 0.00, 7500.00, 1200000.00, 0.00, 3311829000.00, 165844500.00, '2025-10-15 07:35:35', '2025-10-15 07:35:35'),
	(14, 2025, 'penetapan', 5, 25200000.00, 1950000.00, 850000000.00, 44053000.00, 780000000.00, 134662500.00, 1655429000.00, 780487000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 961152500.00, '2025-10-15 07:36:42', '2025-10-15 07:36:42'),
	(15, 2025, 'pergeseran', 5, 25200000.00, 1950000.00, 850000000.00, 44053000.00, 780000000.00, 134662500.00, 1655429000.00, 780487000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 961152500.00, '2025-10-15 07:37:26', '2025-10-15 07:37:26'),
	(16, 2025, 'perubahan', 5, 25200000.00, 1950000.00, 850000000.00, 44053000.00, 780000000.00, 134662500.00, 1655429000.00, 780487000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 961152500.00, '2025-10-15 07:38:13', '2025-10-15 07:38:13'),
	(17, 2025, 'penetapan', 6, 25200000.00, 2025000.00, 850000000.00, 70148000.00, 780000000.00, 84997500.00, 1655429000.00, 84811000.00, 0.00, 0.00, 1200000.00, 1200000.00, 3311829000.00, 243181500.00, '2025-10-15 07:40:33', '2025-10-15 07:40:33'),
	(18, 2025, 'pergeseran', 6, 25200000.00, 2025000.00, 850000000.00, 70148000.00, 780000000.00, 84997500.00, 1655429000.00, 84811000.00, 0.00, 0.00, 1200000.00, 1200000.00, 3311829000.00, 243181500.00, '2025-10-15 07:41:16', '2025-10-15 07:41:16'),
	(19, 2025, 'perubahan', 6, 25200000.00, 2025000.00, 850000000.00, 70148000.00, 780000000.00, 84997500.00, 1655429000.00, 84811000.00, 0.00, 0.00, 1200000.00, 1200000.00, 3311829000.00, 243181500.00, '2025-10-15 07:42:30', '2025-10-15 07:42:30'),
	(20, 2025, 'penetapan', 7, 25200000.00, 2025000.00, 850000000.00, 48388000.00, 780000000.00, 131952500.00, 1655429000.00, 125000000.00, 0.00, 7500000.00, 1200000.00, 0.00, 3311829000.00, 314865500.00, '2025-10-15 07:45:30', '2025-10-15 07:47:18'),
	(21, 2025, 'pergeseran', 7, 25200000.00, 2025000.00, 850000000.00, 48388000.00, 780000000.00, 131952500.00, 1655429000.00, 125000000.00, 0.00, 7500000.00, 1200000.00, 0.00, 3311829000.00, 314865500.00, '2025-10-15 07:47:02', '2025-10-15 07:47:02'),
	(22, 2025, 'perubahan', 7, 25200000.00, 2025000.00, 850000000.00, 48388000.00, 780000000.00, 131952500.00, 1655429000.00, 125000000.00, 0.00, 7500000.00, 1200000.00, 0.00, 3311829000.00, 314865500.00, '2025-10-15 07:48:00', '2025-10-15 07:48:00'),
	(23, 2025, 'penetapan', 8, 25200000.00, 2025000.00, 850000000.00, 64426000.00, 780000000.00, 176224750.00, 1655429000.00, 126060000.00, 0.00, 2000.00, 1200000.00, 0.00, 3311829000.00, 368737750.00, '2025-10-15 07:49:51', '2025-10-15 07:49:51'),
	(24, 2025, 'pergeseran', 8, 25200000.00, 2025000.00, 850000000.00, 64426000.00, 780000000.00, 176224750.00, 1655429000.00, 126060000.00, 0.00, 2000.00, 1200000.00, 0.00, 3311829000.00, 368737750.00, '2025-10-15 07:50:41', '2025-10-15 07:50:41'),
	(25, 2025, 'perubahan', 8, 25200000.00, 2025000.00, 850000000.00, 64426000.00, 780000000.00, 176224750.00, 1655429000.00, 126060000.00, 0.00, 2000.00, 1200000.00, 0.00, 3311829000.00, 368737750.00, '2025-10-15 07:51:35', '2025-10-15 07:51:35'),
	(26, 2025, 'pergeseran', 9, 25200000.00, 2025000.00, 850000000.00, 53223000.00, 780000000.00, 81452500.00, 1655429000.00, 128155000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 264855500.00, '2025-10-15 07:55:10', '2025-10-15 07:55:10'),
	(27, 2025, 'perubahan', 9, 25200000.00, 2025000.00, 850000000.00, 53223000.00, 780000000.00, 81452500.00, 1655429000.00, 128155000.00, 0.00, 0.00, 1200000.00, 0.00, 3311829000.00, 264855500.00, '2025-10-15 07:56:04', '2025-10-15 07:56:04');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pengaturan
DROP TABLE IF EXISTS `tbl_pengaturan`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `judul` varchar(100) DEFAULT NULL,
  `judul_app` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `theme` varchar(50) DEFAULT NULL,
  `pagination_limit` int(11) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo_header` varchar(255) DEFAULT NULL,
  `ppn` int(2) DEFAULT NULL,
  `limit` decimal(10,2) DEFAULT NULL COMMENT 'Limit pengaturan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pengaturan: ~0 rows (approximately)
DELETE FROM `tbl_pengaturan`;
INSERT INTO `tbl_pengaturan` (`id`, `updated_at`, `judul`, `judul_app`, `alamat`, `deskripsi`, `kota`, `url`, `theme`, `pagination_limit`, `favicon`, `logo`, `logo_header`, `ppn`, `limit`) VALUES
	(1, '2025-09-17 11:57:33', 'KALDERA', 'KALDERA', 'Jl. Raya No. 1', '-', 'semarang', 'http://localhost/p57-kaldera', 'quirk', 10, '', 'public/file/app/logo_only.png', 'public/file/app/logo_header.png', 11, NULL);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pengaturan_api
DROP TABLE IF EXISTS `tbl_pengaturan_api`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_api` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `id_pengaturan` int(11) unsigned DEFAULT NULL,
  `nama` varchar(100) NOT NULL,
  `pub_key` text DEFAULT NULL,
  `priv_key` text DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id_pengaturan` (`id_pengaturan`),
  CONSTRAINT `FK_pengaturan_api` FOREIGN KEY (`id_pengaturan`) REFERENCES `tbl_pengaturan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table untuk menyimpan pengaturan API';

-- Dumping data for table mikhaelf_db_kaldera.tbl_pengaturan_api: ~2 rows (approximately)
DELETE FROM `tbl_pengaturan_api`;
INSERT INTO `tbl_pengaturan_api` (`id`, `created_at`, `updated_at`, `id_pengaturan`, `nama`, `pub_key`, `priv_key`, `status`) VALUES
	(1, '2025-05-29 17:37:38', NULL, 1, 'Recaptcha 3', '6LfGMLMqAAAAAFiFBRqO_VRv_R9aihfNzGp7SBb1', '6LfGMLMqAAAAAPk13LbbBWB7v1aBdrjnn3CCD6nB', '1'),
	(2, '2025-05-29 17:37:38', NULL, 1, 'Chat GPT', NULL, NULL, '1');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pengaturan_theme
DROP TABLE IF EXISTS `tbl_pengaturan_theme`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_theme` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_pengaturan` int(11) unsigned DEFAULT NULL,
  `nama` varchar(50) DEFAULT NULL,
  `path` varchar(160) DEFAULT NULL,
  `status` int(11) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `id_pengaturan` (`id_pengaturan`),
  CONSTRAINT `FK_pengaturan_theme` FOREIGN KEY (`id_pengaturan`) REFERENCES `tbl_pengaturan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pengaturan_theme: ~2 rows (approximately)
DELETE FROM `tbl_pengaturan_theme`;
INSERT INTO `tbl_pengaturan_theme` (`id`, `id_pengaturan`, `nama`, `path`, `status`) VALUES
	(1, 1, 'Quirk Admin Theme', 'quirk', 0),
	(2, 1, 'Admin LTE 3', 'admin-lte-3', 1);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pg
DROP TABLE IF EXISTS `tbl_pg`;
CREATE TABLE IF NOT EXISTS `tbl_pg` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `indikator` varchar(500) NOT NULL,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `catatan_kendala` text DEFAULT NULL,
  `rencana_tindak_lanjut` text DEFAULT NULL,
  `feedback_unit_kerja` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`feedback_unit_kerja`)),
  `file_path` varchar(500) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pg: ~0 rows (approximately)
DELETE FROM `tbl_pg`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_prokons
DROP TABLE IF EXISTS `tbl_prokons`;
CREATE TABLE IF NOT EXISTS `tbl_prokons` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL,
  `bulan` int(2) NOT NULL,
  `nama_hibah` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai_hibah` bigint(20) NOT NULL DEFAULT 0,
  `status` enum('Sesuai','Tidak Sesuai','Belum Diperiksa') NOT NULL DEFAULT 'Belum Diperiksa',
  `tipe` int(11) DEFAULT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `file_path_dok` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_name_dok` varchar(255) DEFAULT NULL,
  `file_size` bigint(20) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tahun_bulan` (`tahun`,`bulan`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_prokons: ~7 rows (approximately)
DELETE FROM `tbl_prokons`;
INSERT INTO `tbl_prokons` (`id`, `tahun`, `bulan`, `nama_hibah`, `deskripsi`, `nilai_hibah`, `status`, `tipe`, `file_path`, `file_path_dok`, `file_name`, `file_name_dok`, `file_size`, `uploaded_by`, `uploaded_at`, `created_at`, `updated_at`) VALUES
	(2, 2025, 1, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416573.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 270490, 2, '2025-10-14 11:36:13', '2025-10-14 11:36:13', '2025-10-14 11:38:26'),
	(3, 2025, 2, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416791.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 275699, 2, '2025-10-14 11:39:51', '2025-10-14 11:39:51', '2025-10-14 11:39:56'),
	(4, 2025, 3, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416806.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 277436, 2, '2025-10-14 11:40:06', '2025-10-14 11:40:06', '2025-10-14 11:40:11'),
	(5, 2025, 4, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416822.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 274877, 2, '2025-10-14 11:40:22', '2025-10-14 11:40:22', '2025-10-14 11:40:48'),
	(6, 2025, 5, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416872.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 296573, 2, '2025-10-14 11:41:12', '2025-10-14 11:41:12', '2025-10-14 11:41:16'),
	(7, 2025, 6, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416886.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 294948, 2, '2025-10-14 11:41:26', '2025-10-14 11:41:26', '2025-10-14 11:41:51'),
	(8, 2025, 7, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760416993.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 337092, 2, '2025-10-14 11:43:13', '2025-10-14 11:43:13', '2025-10-14 11:43:31'),
	(9, 2025, 8, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760417265.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 336987, 2, '2025-10-14 11:47:45', '2025-10-14 11:47:45', '2025-10-14 11:49:41'),
	(10, 2025, 9, 'Hibah', 'Upload data Hibah', 0, 'Belum Diperiksa', 0, 'file/prokons/2025/2025_hibah_1760417564.pdf', 'https://bit.ly/jaskon25', 'Jasa Konsultansi.pdf', 'https://bit.ly/jaskon25', 275113, 2, '2025-10-14 11:52:44', '2025-10-14 11:52:44', '2025-10-14 11:52:50');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_pt
DROP TABLE IF EXISTS `tbl_pt`;
CREATE TABLE IF NOT EXISTS `tbl_pt` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tahun` int(4) NOT NULL COMMENT 'Tahun data',
  `bulan` int(2) NOT NULL COMMENT 'Bulan data (1-12)',
  `sektor` varchar(50) NOT NULL DEFAULT 'minerba' COMMENT 'Sektor: minerba, gat, gatrik, ebt',
  `unit_kerja_id` int(11) unsigned DEFAULT NULL COMMENT 'ID dari tbl_m_unit_kerja',
  `unit_kerja_nama` varchar(255) NOT NULL COMMENT 'Nama unit kerja',
  `permohonan_masuk` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah permohonan masuk',
  `masih_proses` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah yang masih proses',
  `disetujui` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah yang disetujui',
  `dikembalikan` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah yang dikembalikan',
  `ditolak` int(11) NOT NULL DEFAULT 0 COMMENT 'Jumlah yang ditolak',
  `keterangan` text DEFAULT NULL COMMENT 'Keterangan tambahan',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_pt_periode` (`tahun`,`bulan`,`sektor`,`unit_kerja_id`),
  KEY `idx_sektor` (`sektor`),
  KEY `idx_unit_kerja` (`unit_kerja_id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_pt: ~100 rows (approximately)
DELETE FROM `tbl_pt`;
INSERT INTO `tbl_pt` (`id`, `tahun`, `bulan`, `sektor`, `unit_kerja_id`, `unit_kerja_nama`, `permohonan_masuk`, `masih_proses`, `disetujui`, `dikembalikan`, `ditolak`, `keterangan`, `created_at`, `updated_at`) VALUES
	(1, 2025, 10, 'minerba', 1, 'Cabdin Wil. Kendeng Muria', 1, 1, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(2, 2025, 10, 'minerba', 2, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(3, 2025, 10, 'minerba', 3, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(4, 2025, 10, 'minerba', 4, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(5, 2025, 10, 'minerba', 5, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(6, 2025, 10, 'minerba', 6, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(7, 2025, 10, 'minerba', 7, 'Dinas Energi dan Sumber Daya Mineral', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(8, 2025, 10, 'minerba', 8, 'Badan Perencanaan Pembangunan Daerah', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(9, 2025, 10, 'minerba', 9, 'Dinas Lingkungan Hidup', 0, 0, 0, 0, 0, '', '2025-10-04 13:15:13', '2025-10-04 13:15:13'),
	(10, 2025, 10, 'gat', 1, 'Cabdin Wil. Kendeng Muria', 1, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(11, 2025, 10, 'gat', 2, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(12, 2025, 10, 'gat', 3, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(13, 2025, 10, 'gat', 4, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(14, 2025, 10, 'gat', 5, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(15, 2025, 10, 'gat', 6, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(16, 2025, 10, 'gat', 7, 'Dinas Energi dan Sumber Daya Mineral', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(17, 2025, 10, 'gat', 8, 'Badan Perencanaan Pembangunan Daerah', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(18, 2025, 10, 'gat', 9, 'Dinas Lingkungan Hidup', 0, 0, 0, 0, 0, '', '2025-10-04 13:27:17', '2025-10-04 13:27:17'),
	(19, 2025, 10, 'gatrik', 1, 'Cabdin Wil. Kendeng Muria', 1, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(20, 2025, 10, 'gatrik', 2, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(21, 2025, 10, 'gatrik', 3, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(22, 2025, 10, 'gatrik', 4, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(23, 2025, 10, 'gatrik', 5, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(24, 2025, 10, 'gatrik', 6, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(25, 2025, 10, 'gatrik', 7, 'Dinas Energi dan Sumber Daya Mineral', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(26, 2025, 10, 'gatrik', 8, 'Badan Perencanaan Pembangunan Daerah', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(27, 2025, 10, 'gatrik', 9, 'Dinas Lingkungan Hidup', 0, 0, 0, 0, 0, '', '2025-10-04 13:29:33', '2025-10-04 13:29:33'),
	(28, 2025, 3, 'ebt', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(29, 2025, 3, 'ebt', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(30, 2025, 3, 'ebt', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(31, 2025, 3, 'ebt', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(32, 2025, 3, 'ebt', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(33, 2025, 3, 'ebt', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(34, 2025, 3, 'ebt', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(35, 2025, 3, 'ebt', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(36, 2025, 3, 'ebt', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(37, 2025, 3, 'ebt', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(38, 2025, 3, 'ebt', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(39, 2025, 3, 'ebt', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-16 06:55:58', '2025-10-16 07:14:26'),
	(40, 2025, 1, 'ebt', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(41, 2025, 1, 'ebt', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(42, 2025, 1, 'ebt', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(43, 2025, 1, 'ebt', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(44, 2025, 1, 'ebt', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(45, 2025, 1, 'ebt', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(46, 2025, 1, 'ebt', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(47, 2025, 1, 'ebt', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(48, 2025, 1, 'ebt', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(49, 2025, 1, 'ebt', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(50, 2025, 1, 'ebt', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(51, 2025, 1, 'ebt', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-16 07:00:15', '2025-10-16 07:13:59'),
	(52, 2025, 2, 'ebt', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(53, 2025, 2, 'ebt', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(54, 2025, 2, 'ebt', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(55, 2025, 2, 'ebt', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(56, 2025, 2, 'ebt', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(57, 2025, 2, 'ebt', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(58, 2025, 2, 'ebt', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(59, 2025, 2, 'ebt', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(60, 2025, 2, 'ebt', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(61, 2025, 2, 'ebt', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(62, 2025, 2, 'ebt', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(63, 2025, 2, 'ebt', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 9, 0, 0, '', '2025-10-16 07:01:01', '2025-10-16 07:14:12'),
	(64, 2025, 10, 'minerba', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(65, 2025, 10, 'minerba', 11, 'Cabdin Wil. Kendeng Muria', 1, 1, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(66, 2025, 10, 'minerba', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(67, 2025, 10, 'minerba', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(68, 2025, 10, 'minerba', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(69, 2025, 10, 'minerba', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(70, 2025, 10, 'minerba', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(71, 2025, 10, 'minerba', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(72, 2025, 10, 'minerba', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(73, 2025, 10, 'minerba', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(74, 2025, 10, 'minerba', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(75, 2025, 10, 'minerba', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-16 07:06:04', '2025-10-17 00:01:22'),
	(76, 2025, 10, 'minerba', 34, 'cabdin xyz', 7, 8, 9, 1, 4, 'revisi RHK', '2025-10-16 07:06:04', '2025-10-16 07:06:04'),
	(77, 2025, 6, 'ebt', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(78, 2025, 6, 'ebt', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(79, 2025, 6, 'ebt', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(80, 2025, 6, 'ebt', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(81, 2025, 6, 'ebt', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(82, 2025, 6, 'ebt', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(83, 2025, 6, 'ebt', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(84, 2025, 6, 'ebt', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(85, 2025, 6, 'ebt', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(86, 2025, 6, 'ebt', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(87, 2025, 6, 'ebt', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(88, 2025, 6, 'ebt', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-16 07:08:15', '2025-10-16 07:14:39'),
	(89, 2025, 9, 'ebt', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(90, 2025, 9, 'ebt', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(91, 2025, 9, 'ebt', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(92, 2025, 9, 'ebt', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(93, 2025, 9, 'ebt', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(94, 2025, 9, 'ebt', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(95, 2025, 9, 'ebt', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(96, 2025, 9, 'ebt', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(97, 2025, 9, 'ebt', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(98, 2025, 9, 'ebt', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(99, 2025, 9, 'ebt', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(100, 2025, 9, 'ebt', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-16 07:11:41', '2025-10-16 07:13:44'),
	(101, 2025, 9, 'minerba', 10, 'Cabdin Wil. Solo', 7, 1, 6, 0, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(102, 2025, 9, 'minerba', 11, 'Cabdin Wil. Kendeng Muria', 19, 0, 17, 2, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(103, 2025, 9, 'minerba', 12, 'Cabdin Wil. Serayu Utara', 6, 0, 6, 1, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(104, 2025, 9, 'minerba', 13, 'Cabdin Wil. Serayu Selatan', 8, 0, 5, 3, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(105, 2025, 9, 'minerba', 15, 'Cabdin Wil. Slamet Utara', 17, 0, 17, 0, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(106, 2025, 9, 'minerba', 17, 'Cabdin Wil. Ungaran Telomoyo', 9, 0, 7, 2, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(107, 2025, 9, 'minerba', 18, 'Cabdin Wil. Kendeng Selatan', 24, 0, 24, 0, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(108, 2025, 9, 'minerba', 19, 'Cabdin Wil. Sewu Lawu', 9, 0, 9, 0, 0, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(109, 2025, 9, 'minerba', 29, 'Cabdin Wil. Slamet Selatan', 26, 8, 7, 6, 5, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(110, 2025, 9, 'minerba', 30, 'Cabdin Wil. Serayu Tengah', 26, 0, 8, 17, 1, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(111, 2025, 9, 'minerba', 31, 'Cabdin Wil. Merapi', 94, 0, 42, 44, 8, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(112, 2025, 9, 'minerba', 32, 'Cabdin Wil. Semarang Demak', 17, 0, 12, 2, 3, '', '2025-10-16 07:19:48', '2025-10-16 07:19:54'),
	(113, 2025, 9, 'gat', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(114, 2025, 9, 'gat', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(115, 2025, 9, 'gat', 12, 'Cabdin Wil. Serayu Utara', 82, 0, 82, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(116, 2025, 9, 'gat', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(117, 2025, 9, 'gat', 15, 'Cabdin Wil. Slamet Utara', 135, 0, 115, 20, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(118, 2025, 9, 'gat', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(119, 2025, 9, 'gat', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(120, 2025, 9, 'gat', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(121, 2025, 9, 'gat', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(122, 2025, 9, 'gat', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(123, 2025, 9, 'gat', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(124, 2025, 9, 'gat', 32, 'Cabdin Wil. Semarang Demak', 74, 0, 74, 0, 0, '', '2025-10-16 07:23:04', '2025-10-16 07:23:04'),
	(125, 2025, 9, 'gatrik', 10, 'Cabdin Wil. Solo', 67, 0, 67, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(126, 2025, 9, 'gatrik', 11, 'Cabdin Wil. Kendeng Muria', 66, 0, 66, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(127, 2025, 9, 'gatrik', 12, 'Cabdin Wil. Serayu Utara', 70, 0, 70, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(128, 2025, 9, 'gatrik', 13, 'Cabdin Wil. Serayu Selatan', 15, 0, 15, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(129, 2025, 9, 'gatrik', 15, 'Cabdin Wil. Slamet Utara', 27, 0, 26, 1, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(130, 2025, 9, 'gatrik', 17, 'Cabdin Wil. Ungaran Telomoyo', 54, 0, 54, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(131, 2025, 9, 'gatrik', 18, 'Cabdin Wil. Kendeng Selatan', 20, 0, 20, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(132, 2025, 9, 'gatrik', 19, 'Cabdin Wil. Sewu Lawu', 22, 0, 22, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(133, 2025, 9, 'gatrik', 29, 'Cabdin Wil. Slamet Selatan', 33, 0, 33, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(134, 2025, 9, 'gatrik', 30, 'Cabdin Wil. Serayu Tengah', 12, 0, 12, 0, 0, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(135, 2025, 9, 'gatrik', 31, 'Cabdin Wil. Merapi', 48, 3, 44, 0, 1, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(136, 2025, 9, 'gatrik', 32, 'Cabdin Wil. Semarang Demak', 112, 0, 89, 16, 7, '', '2025-10-16 07:25:02', '2025-10-16 07:25:02'),
	(137, 2025, 6, 'gatrik', 10, 'Cabdin Wil. Solo', 50, 0, 50, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(138, 2025, 6, 'gatrik', 11, 'Cabdin Wil. Kendeng Muria', 28, 0, 28, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(139, 2025, 6, 'gatrik', 12, 'Cabdin Wil. Serayu Utara', 60, 0, 60, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(140, 2025, 6, 'gatrik', 13, 'Cabdin Wil. Serayu Selatan', 10, 0, 10, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(141, 2025, 6, 'gatrik', 15, 'Cabdin Wil. Slamet Utara', 21, 0, 20, 1, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(142, 2025, 6, 'gatrik', 17, 'Cabdin Wil. Ungaran Telomoyo', 12, 0, 11, 1, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(143, 2025, 6, 'gatrik', 18, 'Cabdin Wil. Kendeng Selatan', 7, 0, 7, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(144, 2025, 6, 'gatrik', 19, 'Cabdin Wil. Sewu Lawu', 14, 0, 12, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(145, 2025, 6, 'gatrik', 29, 'Cabdin Wil. Slamet Selatan', 24, 0, 24, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(146, 2025, 6, 'gatrik', 30, 'Cabdin Wil. Serayu Tengah', 9, 0, 9, 0, 0, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(147, 2025, 6, 'gatrik', 31, 'Cabdin Wil. Merapi', 31, 0, 30, 0, 1, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(148, 2025, 6, 'gatrik', 32, 'Cabdin Wil. Semarang Demak', 73, 0, 52, 16, 5, '', '2025-10-16 07:27:02', '2025-10-16 07:27:02'),
	(149, 2025, 6, 'gat', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(150, 2025, 6, 'gat', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(151, 2025, 6, 'gat', 12, 'Cabdin Wil. Serayu Utara', 47, 0, 47, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(152, 2025, 6, 'gat', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(153, 2025, 6, 'gat', 15, 'Cabdin Wil. Slamet Utara', 76, 0, 61, 15, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(154, 2025, 6, 'gat', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(155, 2025, 6, 'gat', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(156, 2025, 6, 'gat', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(157, 2025, 6, 'gat', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(158, 2025, 6, 'gat', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(159, 2025, 6, 'gat', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(160, 2025, 6, 'gat', 32, 'Cabdin Wil. Semarang Demak', 56, 0, 56, 0, 0, '', '2025-10-16 07:27:52', '2025-10-16 07:27:52'),
	(161, 2025, 6, 'minerba', 10, 'Cabdin Wil. Solo', 4, 0, 3, 1, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(162, 2025, 6, 'minerba', 11, 'Cabdin Wil. Kendeng Muria', 12, 0, 12, 0, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(163, 2025, 6, 'minerba', 12, 'Cabdin Wil. Serayu Utara', 6, 0, 5, 1, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(164, 2025, 6, 'minerba', 13, 'Cabdin Wil. Serayu Selatan', 5, 0, 1, 4, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(165, 2025, 6, 'minerba', 15, 'Cabdin Wil. Slamet Utara', 11, 0, 11, 0, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(166, 2025, 6, 'minerba', 17, 'Cabdin Wil. Ungaran Telomoyo', 7, 0, 5, 2, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(167, 2025, 6, 'minerba', 18, 'Cabdin Wil. Kendeng Selatan', 16, 0, 16, 0, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(168, 2025, 6, 'minerba', 19, 'Cabdin Wil. Sewu Lawu', 4, 0, 4, 0, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(169, 2025, 6, 'minerba', 29, 'Cabdin Wil. Slamet Selatan', 18, 1, 6, 9, 2, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(170, 2025, 6, 'minerba', 30, 'Cabdin Wil. Serayu Tengah', 15, 8, 5, 2, 0, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(171, 2025, 6, 'minerba', 31, 'Cabdin Wil. Merapi', 39, 5, 17, 15, 2, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(172, 2025, 6, 'minerba', 32, 'Cabdin Wil. Semarang Demak', 12, 0, 8, 38, 4, '', '2025-10-16 07:30:10', '2025-10-16 07:30:10'),
	(173, 2025, 3, 'minerba', 10, 'Cabdin Wil. Solo', 3, 0, 2, 1, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(174, 2025, 3, 'minerba', 11, 'Cabdin Wil. Kendeng Muria', 5, 0, 4, 1, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(175, 2025, 3, 'minerba', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(176, 2025, 3, 'minerba', 13, 'Cabdin Wil. Serayu Selatan', 3, 0, 1, 2, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(177, 2025, 3, 'minerba', 15, 'Cabdin Wil. Slamet Utara', 6, 0, 6, 0, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(178, 2025, 3, 'minerba', 17, 'Cabdin Wil. Ungaran Telomoyo', 3, 0, 2, 1, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(179, 2025, 3, 'minerba', 18, 'Cabdin Wil. Kendeng Selatan', 12, 0, 10, 2, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(180, 2025, 3, 'minerba', 19, 'Cabdin Wil. Sewu Lawu', 2, 0, 2, 0, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(181, 2025, 3, 'minerba', 29, 'Cabdin Wil. Slamet Selatan', 10, 0, 2, 7, 1, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(182, 2025, 3, 'minerba', 30, 'Cabdin Wil. Serayu Tengah', 8, 0, 4, 4, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(183, 2025, 3, 'minerba', 31, 'Cabdin Wil. Merapi', 21, 7, 8, 5, 1, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(184, 2025, 3, 'minerba', 32, 'Cabdin Wil. Semarang Demak', 9, 0, 6, 3, 0, '', '2025-10-16 07:32:25', '2025-10-16 07:32:25'),
	(185, 2025, 3, 'gat', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(186, 2025, 3, 'gat', 11, 'Cabdin Wil. Kendeng Muria', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(187, 2025, 3, 'gat', 12, 'Cabdin Wil. Serayu Utara', 19, 0, 19, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(188, 2025, 3, 'gat', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(189, 2025, 3, 'gat', 15, 'Cabdin Wil. Slamet Utara', 46, 0, 24, 21, 1, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(190, 2025, 3, 'gat', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(191, 2025, 3, 'gat', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(192, 2025, 3, 'gat', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(193, 2025, 3, 'gat', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(194, 2025, 3, 'gat', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(195, 2025, 3, 'gat', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(196, 2025, 3, 'gat', 32, 'Cabdin Wil. Semarang Demak', 24, 0, 24, 0, 0, '', '2025-10-16 07:33:23', '2025-10-16 07:33:23'),
	(197, 2025, 3, 'gatrik', 10, 'Cabdin Wil. Solo', 35, 0, 35, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(198, 2025, 3, 'gatrik', 11, 'Cabdin Wil. Kendeng Muria', 13, 0, 13, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(199, 2025, 3, 'gatrik', 12, 'Cabdin Wil. Serayu Utara', 6, 0, 6, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(200, 2025, 3, 'gatrik', 13, 'Cabdin Wil. Serayu Selatan', 7, 0, 6, 1, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(201, 2025, 3, 'gatrik', 15, 'Cabdin Wil. Slamet Utara', 16, 0, 16, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(202, 2025, 3, 'gatrik', 17, 'Cabdin Wil. Ungaran Telomoyo', 9, 0, 8, 1, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(203, 2025, 3, 'gatrik', 18, 'Cabdin Wil. Kendeng Selatan', 5, 0, 5, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(204, 2025, 3, 'gatrik', 19, 'Cabdin Wil. Sewu Lawu', 7, 0, 5, 2, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(205, 2025, 3, 'gatrik', 29, 'Cabdin Wil. Slamet Selatan', 11, 0, 11, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(206, 2025, 3, 'gatrik', 30, 'Cabdin Wil. Serayu Tengah', 4, 0, 4, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(207, 2025, 3, 'gatrik', 31, 'Cabdin Wil. Merapi', 16, 0, 16, 0, 0, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(208, 2025, 3, 'gatrik', 32, 'Cabdin Wil. Semarang Demak', 50, 0, 35, 10, 5, '', '2025-10-16 07:35:38', '2025-10-16 07:35:38'),
	(209, 2025, 10, 'gatrik', 10, 'Cabdin Wil. Solo', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(210, 2025, 10, 'gatrik', 11, 'Cabdin Wil. Kendeng Muria', 1, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(211, 2025, 10, 'gatrik', 12, 'Cabdin Wil. Serayu Utara', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(212, 2025, 10, 'gatrik', 13, 'Cabdin Wil. Serayu Selatan', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(213, 2025, 10, 'gatrik', 15, 'Cabdin Wil. Slamet Utara', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(214, 2025, 10, 'gatrik', 17, 'Cabdin Wil. Ungaran Telomoyo', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(215, 2025, 10, 'gatrik', 18, 'Cabdin Wil. Kendeng Selatan', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(216, 2025, 10, 'gatrik', 19, 'Cabdin Wil. Sewu Lawu', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(217, 2025, 10, 'gatrik', 29, 'Cabdin Wil. Slamet Selatan', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(218, 2025, 10, 'gatrik', 30, 'Cabdin Wil. Serayu Tengah', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(219, 2025, 10, 'gatrik', 31, 'Cabdin Wil. Merapi', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52'),
	(220, 2025, 10, 'gatrik', 32, 'Cabdin Wil. Semarang Demak', 0, 0, 0, 0, 0, '', '2025-10-17 00:02:52', '2025-10-17 00:02:52');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_sdgs
DROP TABLE IF EXISTS `tbl_sdgs`;
CREATE TABLE IF NOT EXISTS `tbl_sdgs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `year` year(4) NOT NULL,
  `month` char(2) NOT NULL DEFAULT '01',
  `uraian` varchar(255) NOT NULL,
  `fupload` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_sdgs: ~2 rows (approximately)
DELETE FROM `tbl_sdgs`;
INSERT INTO `tbl_sdgs` (`id`, `year`, `month`, `uraian`, `fupload`, `created_at`, `updated_at`) VALUES
	(2, '2025', '09', 'Matrik RAD SDGs Jateng Tahun 2025-2029', '/file/sdgs/2/sdgs_2_1760517138.pdf', '2025-10-15 15:32:18', '2025-10-15 15:32:18'),
	(3, '2025', '05', 'Pengisian Capaian Data Laporan Evaluasi Pelaksanaan TPB/SDGs Jawa Tengah Tahun 2024', '/file/sdgs/3/sdgs_3_1760517277.pdf', '2025-10-15 15:34:37', '2025-10-15 15:34:37');

-- Dumping structure for table mikhaelf_db_kaldera.tbl_sessions
DROP TABLE IF EXISTS `tbl_sessions`;
CREATE TABLE IF NOT EXISTS `tbl_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT 0,
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Table untuk menyimpan session data';

-- Dumping data for table mikhaelf_db_kaldera.tbl_sessions: ~159 rows (approximately)
DELETE FROM `tbl_sessions`;
INSERT INTO `tbl_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
	('kaldera_session:028398ae3214892b1fa15cb4430cb4c1', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932313837363b6b616c646572615f746f6b656e7c733a33323a223538383138643535353635346337366332643437343435666136323861666336223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393231353435223b6c6173745f636865636b7c693a313735393932313837363b),
	('kaldera_session:067c0bd9e5bd26efaa8862efd5535b90', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932323831363b6b616c646572615f746f6b656e7c733a33323a223538383138643535353635346337366332643437343435666136323861666336223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393231353435223b6c6173745f636865636b7c693a313735393932313837363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:098b43bc526c9bd75eab39571ca3d531', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303435373532383b6b616c646572615f746f6b656e7c733a33323a223931376163636335356537303030373431323165326564653563353337343535223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b),
	('kaldera_session:09e9442c68ef73ac110caf17b07b29af', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323032393b6b616c646572615f746f6b656e7c733a33323a223433613436393135633835383631383032373463303034623662633734373535223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131393538223b6c6173745f636865636b7c693a313736303431323032393b),
	('kaldera_session:0b91cc9c1edb3cfc1025fab6a9a842df', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531333638353b6b616c646572615f746f6b656e7c733a33323a226539393530386564656664616538663631303532326331306234633137393537223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:0cdcec495af5571bcc3c1119a8edfc73', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303435323239333b6b616c646572615f746f6b656e7c733a33323a226539316136643935323030356332316438663761306366653262303735643031223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:13a1aed8311a1a00339c942f9e15d5ef', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303032343230313b6b616c646572615f746f6b656e7c733a33323a223638316362363764653864336434356234376539626463326565613833343931223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b),
	('kaldera_session:1408ee2bce165cbc74f94be6b01d3305', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303135323235313b6b616c646572615f746f6b656e7c733a33323a223165386638353135633937306430303263323136313930666538643431303036223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b),
	('kaldera_session:15ae9e867a457ae4552889c045fd0167', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439393334313b6b616c646572615f746f6b656e7c733a33323a223537353963663066643331663330363234663964626537373236353630613662223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:16ee366d0c457cd55c5d5c85feb43c7a', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393735353232333b6b616c646572615f746f6b656e7c733a33323a223836333166633239623835356531333766363338323538303334393265663863223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363530333038223b6c6173745f636865636b7c693a313735393735343539313b),
	('kaldera_session:1794c37f5e65d8c65464cc0e0af54ded', '151.115.98.203', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438353237353b6b616c646572615f746f6b656e7c733a33323a226131303134336533623865393934356436383363383064336635643136623036223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:1d22feeb89111b4e20487b49a000701f', '151.115.98.203', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438363230383b6b616c646572615f746f6b656e7c733a33323a226131303134336533623865393934356436383363383064336635643136623036223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f72656b6170223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:1d6d251f573d34033cc2c081dbf30f25', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373730383b6b616c646572615f746f6b656e7c733a33323a223537353963663066643331663330363234663964626537373236353630613662223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b),
	('kaldera_session:1f3bd62dd98898d82cc04260c563a5ca', '66.96.233.187', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303736313031333b6b616c646572615f746f6b656e7c733a33323a223164386339636134303137613364306664336133353231346336363230613562223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630373539313931223b6c6173745f636865636b7c693a313736303736313031333b),
	('kaldera_session:1ff9f42581a5da33e1f280c2a3cf49e2', '182.2.44.55', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439343133313b6b616c646572615f746f6b656e7c733a33323a223666346663343834373738303732393236343066373233386436626165666235223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:214a16763f7ea0b953ae666915d66d25', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537313836323b6b616c646572615f746f6b656e7c733a33323a223139323733343462633832653832656234393536383236646136343364383236223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b),
	('kaldera_session:21d5563d1eeae1508b7c39b360b25f5e', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432373430333b6b616c646572615f746f6b656e7c733a33323a226338313938303531643832393739616237303632636437633463363864613163223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:222f3f5aa143f1c32c17bc406be237db', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432333132303b6b616c646572615f746f6b656e7c733a33323a223430356539363862303563373565656561393566343135353739616231333839223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:230bf548c77ce6c3095d9233c8e17904', '114.10.127.125', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303433383535353b6b616c646572615f746f6b656e7c733a33323a226230383130333361646331616530306566623538633564316462613731663864223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:237a3797aa637cc9f6208a5b3f0812ab', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834363437373b6b616c646572615f746f6b656e7c733a33323a223636623465646165303937323065323061343966636662643838323333353164223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b),
	('kaldera_session:25139f33532bd5b3cf8435e9841d8ee2', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363934333b6b616c646572615f746f6b656e7c733a33323a226638316366643162376234316263326131643264633035363936346163303030223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:2569544dab26c1c628bc5d658ec7c67d', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303534373833333b6b616c646572615f746f6b656e7c733a33323a226236356531376163636466626133386435643635316361663764616337393262223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353235343734223b6c6173745f636865636b7c693a313736303534373833333b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:2621bce4707f9ca51898b2418860b938', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393833393538383b6b616c646572615f746f6b656e7c733a33323a223030343533343937303039363935633235653461643566336265636561393735223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b),
	('kaldera_session:26fab3fd5d2fcde182a430a4ad7de052', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432353133373b6b616c646572615f746f6b656e7c733a33323a226233633261666630613061336331636531333664373034623036316531333665223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343230393031223b6c6173745f636865636b7c693a313736303432353133363b),
	('kaldera_session:27493834e87c0892b402b2dcfc47a244', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538383131373b6b616c646572615f746f6b656e7c733a33323a226532306136616339653263633534356331323836383663616537343733636337223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:2a3c66539707b44b7736995e889b2e99', '158.140.166.44', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353437343b6b616c646572615f746f6b656e7c733a33323a226465373335666631376130636664343734333935643961303332366432653563223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353136343539223b6c6173745f636865636b7c693a313736303532353437343b),
	('kaldera_session:2dc2abbca7479c213ec212f74ad7a1c8', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432353133373b6b616c646572615f746f6b656e7c733a33323a226233633261666630613061336331636531333664373034623036316531333665223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343230393031223b6c6173745f636865636b7c693a313736303432353133363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:2ea15067d686d80853e63bf32f177eb3', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303638363132383b6b616c646572615f746f6b656e7c733a33323a223832313735663534373130656461373032363535633663313066623463366664223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363333353436223b6c6173745f636865636b7c693a313736303638363132383b),
	('kaldera_session:3011a42e5e55fddec34093195cc8de05', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393735343539313b6b616c646572615f746f6b656e7c733a33323a223836333166633239623835356531333766363338323538303334393265663863223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363530333038223b6c6173745f636865636b7c693a313735393735343539313b),
	('kaldera_session:301341d70542a16f299cf66027a3e419', '66.249.83.130', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353630363b6b616c646572615f746f6b656e7c733a33323a223539316565333333333462393538663464666464623936376533376164346662223b6572726f727c733a33303a2253696c616b616e206c6f67696e207465726c6562696820646168756c7521223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
	('kaldera_session:3133e9dc5927e9ea7d7f2d449b4ae70f', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834363437373b6b616c646572615f746f6b656e7c733a33323a223365373435373031633466383838616431613163373361343863383530613530223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:31d9e222063ddcd0ecb8e9281d4f4536', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439333133373b6b616c646572615f746f6b656e7c733a33323a223965623161366565336332616633306663326531623232356532386266336636223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b),
	('kaldera_session:33426e169acd324535e009717fa8a01e', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439323135303b6b616c646572615f746f6b656e7c733a33323a223730653762656531336364623564623335346465346538333661336361366131223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b),
	('kaldera_session:342afb9a65b90525a7d02e0e98bed9bd', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313833303b6b616c646572615f746f6b656e7c733a33323a223161656237356633613765373766316465306664656131393061636231356438223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630303537393738223b6c6173745f636865636b7c693a313736303431313833303b),
	('kaldera_session:364fb646550ef04a9eb23c83866def04', '66.249.66.162', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538373033333b6b616c646572615f746f6b656e7c733a33323a226465613361373836666634633762633962656139303739653436303333336564223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:36b7fc67166a08bf26a721c4251136ce', '151.115.98.203', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438363831313b6b616c646572615f746f6b656e7c733a33323a226263653134373132336664653466656164313637313262623036663738653465223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f72656b6170223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:3800a0e8ea65fdd437ff9bcb8e5d62f3', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363535363b6b616c646572615f746f6b656e7c733a33323a223537353963663066643331663330363234663964626537373236353630613662223b5f63695f70726576696f75735f75726c7c733a34373a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f67756c6b696e3f796561723d32303235223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:390c352bc063799b052014b74f8684fd', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432383835303b6b616c646572615f746f6b656e7c733a33323a226463333131383031656663656664333139653661613536623932396633316330223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:3b39f75a34d4700c445b858ee487a337', '182.2.37.54', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313430343b6b616c646572615f746f6b656e7c733a33323a226362653263306535356133303965643562383066356630633464353461333162223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:3bb98a6a2ea6e9acc7df4e73ad546626', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431353236373b6b616c646572615f746f6b656e7c733a33323a226239396262623264633763636334306633316364626336643338313966343364223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343133383435223b6c6173745f636865636b7c693a313736303431353236373b),
	('kaldera_session:3c51740f90950365890dd1557df84c27', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431303335373b6b616c646572615f746f6b656e7c733a33323a223738356632323939623734333135333936376164633737373936353339363436223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:3c5dd894e48b18c86816ff6b26dd42d8', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303035373938313b6b616c646572615f746f6b656e7c733a33323a223637643263356164373864643935663130666462636236666666643136316230223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630303234323039223b6c6173745f636865636b7c693a313736303035373937383b),
	('kaldera_session:3cd8b48f992a3bfafa487a56c16491b4', '114.10.8.64', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532343434333b6b616c646572615f746f6b656e7c733a33323a226362616639663632626233336165633238313964663663346263336161306530223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343937363930223b6c6173745f636865636b7c693a313736303531343034363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:3ef4aee5b3ffc49aba1b3e62d2f1f8ef', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834313134343b6b616c646572615f746f6b656e7c733a33323a226639663166633632313436313831353263663034356262326139633638333463223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:3ff67f6a17fa5c5b1f33455e52d30144', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303435393536323b6b616c646572615f746f6b656e7c733a33323a223361643561363030373063653364376338653339656566313263616665343339223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:441ec92d5603703f87c61673a360ec50', '114.10.8.64', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531343034363b6b616c646572615f746f6b656e7c733a33323a223161323336346539643037346436656165623539666534663737383538396364223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343937363930223b6c6173745f636865636b7c693a313736303531343034363b),
	('kaldera_session:44bc581ecb4be0f00767ba92f46036a8', '82.145.215.206', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432373137343b6b616c646572615f746f6b656e7c733a33323a223235366630386431346265386530383637373764303838643738303363656138223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:450b6cbf4282364778cb4db8200b780e', '158.140.166.44', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353437343b6b616c646572615f746f6b656e7c733a33323a223037636263343635626233376433333237313538633966353932303061383236223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353136343539223b6c6173745f636865636b7c693a313736303532353437343b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:45c3b5ff7d779aced7def4801893d8e1', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393833383137373b6b616c646572615f746f6b656e7c733a33323a223131666163343439396364643135333034366165363030373038326638646666223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b),
	('kaldera_session:468c89820484f61de6d04923a1881c18', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431333834353b6b616c646572615f746f6b656e7c733a33323a223062313862386661363238656136613631383835333732663735346563666261223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343132303937223b6c6173745f636865636b7c693a313736303431333834353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:4a2fd4ba25bb41c873bde5e2744b18ea', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432303930313b6b616c646572615f746f6b656e7c733a33323a223430356539363862303563373565656561393566343135353739616231333839223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b),
	('kaldera_session:4d3fff86be1ca86772562db1a666db7a', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932383333313b6b616c646572615f746f6b656e7c733a33323a223630383236313233366133363338363566393230663561303537393230656330223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235343238223b6c6173745f636865636b7c693a313735393932373732383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:4e88f2f8e19b4eb410e8da45dd02d544', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438393339333b6b616c646572615f746f6b656e7c733a33323a226266623466346466353635623566666337333762363736326536636237366563223b5f63695f70726576696f75735f75726c7c733a37333a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70656e6461706174616e2f696e7075743f62756c616e3d38267461686170616e3d70656e65746170616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:4f3f2aac4e194ffb95bd559b19e10f41', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432323330343b6b616c646572615f746f6b656e7c733a33323a223430356539363862303563373565656561393566343135353739616231333839223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:4f6747bfdac56124289210f76b66de8c', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313433393b6b616c646572615f746f6b656e7c733a33323a223931306535633665343039656231663264373338316362366130323438383736223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:5062d81b07ad338404ee18df0363e8e2', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439353036393b6b616c646572615f746f6b656e7c733a33323a223965623161366565336332616633306663326531623232356532386266336636223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:507c4b2c8920cb603add81bf4b90a7c5', '82.21.147.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323039373b6b616c646572615f746f6b656e7c733a33323a226662613764363135616162323432386438336431666335303563396264643035223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343132303239223b6c6173745f636865636b7c693a313736303431323039373b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:51206b4bdf1f5c3fd04c43f270c7064e', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432383730393b6b616c646572615f746f6b656e7c733a33323a223531363330336133373836353235376663313766646339336539656335636435223b5f63695f70726576696f75735f75726c7c733a35383a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f72656b61703f7461686170616e3d70657275626168616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:51a8a99876705b4db491577951179233', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932333439353b6b616c646572615f746f6b656e7c733a33323a223538383138643535353635346337366332643437343435666136323861666336223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393231353435223b6c6173745f636865636b7c693a313735393932313837363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:52ef7bc1bc7e30d4b6e30a1718a4c386', '::1', 4294967295, _binary 0x6b616c646572615f746f6b656e7c733a33323a223839313662323863396465613531336166303730613435646333303561313734223b5f5f63695f6c6173745f726567656e65726174657c693a313735393635353734363b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363432303531223b6c6173745f636865636b7c693a313735393635303330383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:53180e6bab0dea82f63843a66f51b356', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432383031343b6b616c646572615f746f6b656e7c733a33323a226533316633306238626463303934393433623732353830336364313562616235223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:540a8551ff54bc8c759ea499101668b4', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432343038353b6b616c646572615f746f6b656e7c733a33323a226131616163656334633732336365373139323165373164326665653036376236223b5f63695f70726576696f75735f75726c7c733a37303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f62656c616e6a612f696e7075743f62756c616e3d35267461686170616e3d70657275626168616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:5610ef0613f252e6e3691f51a78c26a7', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932353035363b6b616c646572615f746f6b656e7c733a33323a223762626438396265303533313863653763313839666465623331643864656266223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393231383736223b6c6173745f636865636b7c693a313735393932353035363b),
	('kaldera_session:5710356968901411d5249c2560eb89e3', '66.249.66.161', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538333931343b6b616c646572615f746f6b656e7c733a33323a226334636162376431363765363661613834646465383463323438653633353733223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:58a7f90abf314347399115a934bbe93c', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438383730303b6b616c646572615f746f6b656e7c733a33323a226466313464313534646339386231333237346534653839393863636233333732223b5f63695f70726576696f75735f75726c7c733a37333a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70656e6461706174616e2f696e7075743f62756c616e3d35267461686170616e3d70657275626168616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:5a691a8e704a82793f4fecd6655a40d2', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373037363b6b616c646572615f746f6b656e7c733a33323a223230356230666234666462353365656239613166313664363266326236366138223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:5a9505972622ef1c09a5fad365af6c13', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439313738343b6b616c646572615f746f6b656e7c733a33323a223261646631643864306339663039376432613863646664643732646232376562223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323735223b6c6173745f636865636b7c693a313736303439313738343b),
	('kaldera_session:5ad920b42060274b1f6d2d13aac1477a', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438363035373b6b616c646572615f746f6b656e7c733a33323a223634636634366161343438346538336633646130316337353861663636663132223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b),
	('kaldera_session:5be5121515161a2e6576410ab342f430', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439343031323b6b616c646572615f746f6b656e7c733a33323a223965623161366565336332616633306663326531623232356532386266336636223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:5c51809c7fbc8662353795c642775f61', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303534373832323b6b616c646572615f746f6b656e7c733a33323a226632666365633362306638626336613865313333373866353939343638393366223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:5d125451320d1db851b887243a28b1fa', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439323535393b6b616c646572615f746f6b656e7c733a33323a223261646631643864306339663039376432613863646664643732646232376562223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323735223b6c6173745f636865636b7c693a313736303439313738343b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:6064952bc597b7b225fb2cbba5e5b3af', '82.21.147.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323039373b6b616c646572615f746f6b656e7c733a33323a226662613764363135616162323432386438336431666335303563396264643035223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343132303239223b6c6173745f636865636b7c693a313736303431323039373b),
	('kaldera_session:652d7e85fe9d80fbb7e9c9dea82ed6bf', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431333834353b6b616c646572615f746f6b656e7c733a33323a223062313862386661363238656136613631383835333732663735346563666261223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343132303937223b6c6173745f636865636b7c693a313736303431333834353b),
	('kaldera_session:6598335afa3dd8f3404a890e82f5a5d2', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531343334393b6b616c646572615f746f6b656e7c733a33323a223031383565613064363332373265663834643063316638613664393934613239223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:66359864cba40e802bd94d53434284a8', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834333736353b6b616c646572615f746f6b656e7c733a33323a223332306339386531303930386330663261373530366334306163636561353766223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:666d54f63ce206f94c8273f64ab0f241', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439333938373b6b616c646572615f746f6b656e7c733a33323a226632343465336631333464346364383663663263613636616362613336313630223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323735223b6c6173745f636865636b7c693a313736303439313738343b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:66d977193cd0a0aa0d0c6e3208f5dd56', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932363337323b6b616c646572615f746f6b656e7c733a33323a226131303962396132356366323965666537373338643961363738643133383433223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235303536223b6c6173745f636865636b7c693a313735393932353432383b),
	('kaldera_session:6af6ecf8ba1cf00774e904308fda72fc', '66.249.83.129', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323133323b6b616c646572615f746f6b656e7c733a33323a226565393633653439353638616130623031643634653036623133313561353938223b6572726f727c733a33303a2253696c616b616e206c6f67696e207465726c6562696820646168756c7521223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a34313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f617574682f6c6f67696e223b),
	('kaldera_session:6bc076f34c3a200161d30b3ca224aa6f', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932343137313b6b616c646572615f746f6b656e7c733a33323a223538383138643535353635346337366332643437343435666136323861666336223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393231353435223b6c6173745f636865636b7c693a313735393932313837363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:6ca6985e3a1b6764df77c3321c3632d0', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303032343230393b6b616c646572615f746f6b656e7c733a33323a226537643739623864333437666630613332646639383936313033306635353166223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393237373238223b6c6173745f636865636b7c693a313736303032343230393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:6e37f1f4947bff4e18f609814ecd44db', '182.2.44.55', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439343133323b6b616c646572615f746f6b656e7c733a33323a226132333039326661643861363566386632313831613938356264633330373230223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:724c4ecf55a8da8d6c9084e6ac753892', '151.115.98.201', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432323738343b6b616c646572615f746f6b656e7c733a33323a226565353630613064616137323661633664626566636461663533386132666533223b5f63695f70726576696f75735f75726c7c733a34353a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f62656c616e6a612f6d6173746572223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:725be0db826d54fd00b16f90f59049b4', '::1', 4294967295, _binary 0x6b616c646572615f746f6b656e7c733a33323a223663306234666633663665323431353864366166323937356462303731316238223b5f5f63695f6c6173745f726567656e65726174657c693a313735393635353734363b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363432303531223b6c6173745f636865636b7c693a313735393635303330383b),
	('kaldera_session:7326e7a5ea56ed6cea4c2a13a107f754', '66.249.83.129', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323039323b6b616c646572615f746f6b656e7c733a33323a223136613663646161343633613438353965376662393636366463373638383661223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:76b0c4a7927d35d0d3d11e9f0152ce0d', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393933303338393b6b616c646572615f746f6b656e7c733a33323a223630383236313233366133363338363566393230663561303537393230656330223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235343238223b6c6173745f636865636b7c693a313735393932373732383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:770781c83e8eaa1a7702a002871850f0', '104.28.251.245', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537333338303b6b616c646572615f746f6b656e7c733a33323a223236393535653763303433663965313561373066326233303661353537636665223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:779f9f13f860208a3dcae87dd694ed9e', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363331313b6b616c646572615f746f6b656e7c733a33323a223731343736376266316637386563383439356565386665366232333136393365223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:78de584708dafe0c845a4dcb1131b2f4', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313833303b6b616c646572615f746f6b656e7c733a33323a223161656237356633613765373766316465306664656131393061636231356438223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630303537393738223b6c6173745f636865636b7c693a313736303431313833303b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:7aaf5d9d4b7ea383d6cc474a4447243c', '202.43.172.4', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431333736313b6b616c646572615f746f6b656e7c733a33323a226131383934346365663261333061653138393461656365633337383436663339223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:7b0998c7cfd5a0044240e85e1a299d18', '66.96.233.187', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303736313031333b6b616c646572615f746f6b656e7c733a33323a223164386339636134303137613364306664336133353231346336363230613562223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630373539313931223b6c6173745f636865636b7c693a313736303736313031333b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:7bace4469e78a9d915ad189df18d199b', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303032343230393b6b616c646572615f746f6b656e7c733a33323a226537643739623864333437666630613332646639383936313033306635353166223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393237373238223b6c6173745f636865636b7c693a313736303032343230393b),
	('kaldera_session:7bda1dc4c1c9868b4fb781a1f038629d', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313439363b6b616c646572615f746f6b656e7c733a33323a223132383134626639306566333561376635633739323063643238643162396536223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:81573cceb4e352437c27b3b2012cf8a5', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363934333b6b616c646572615f746f6b656e7c733a33323a223731306238313331363039333432383233373263636638656237653639663535223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:815d6ca243000f3fe65fee2c91986a1c', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432383730393b6b616c646572615f746f6b656e7c733a33323a223232383132333335633338363033346135633136613936313032333866656662223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f696e707574223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:81c4029fdf9c5827467aa0f5a194d102', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431373831383b6b616c646572615f746f6b656e7c733a33323a223933343337613339646566313435333963633962303434323938353336303535223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343133383435223b6c6173745f636865636b7c693a313736303431353236373b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:83694180dc27c912ee344321684349ff', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303534373833333b6b616c646572615f746f6b656e7c733a33323a223861656666646161653363373136356137313565656638616466353231643764223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353235343734223b6c6173745f636865636b7c693a313736303534373833333b),
	('kaldera_session:85f4e10a90ad91d9872da3ccf0c2cad6', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531313435393b6b616c646572615f746f6b656e7c733a33323a226231363663653631396130643265373261663466303831333664323461356661223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:86e8c8308ca823b029de31d2b906e9f1', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303436303138393b6b616c646572615f746f6b656e7c733a33323a223439663634336638666132376334343032616461653033373630666634666336223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:86edb5e039ae9ac7d55be904181698fb', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932353432383b6b616c646572615f746f6b656e7c733a33323a226438376564653061623139376330633037373766326666646263363738316166223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235303536223b6c6173745f636865636b7c693a313735393932353432383b),
	('kaldera_session:87a51e79ef6efbb05d566645e0e96eb5', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303435323239333b6b616c646572615f746f6b656e7c733a33323a223066666666613836306466366538343161366531396464376231323134343765223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b),
	('kaldera_session:87b8cbaf7c48a52e7d00684bd9391250', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432363037393b6b616c646572615f746f6b656e7c733a33323a226338313938303531643832393739616237303632636437633463363864613163223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b),
	('kaldera_session:87e4d906bc081db1ef97dfb39cf3d89e', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432333437343b6b616c646572615f746f6b656e7c733a33323a226362353731646331663132313032663363376636313230653965663961366661223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f696e707574223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:88e9c7bf2500ccdacdc6cbaafa8dbabc', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432313635323b6b616c646572615f746f6b656e7c733a33323a223430356539363862303563373565656561393566343135353739616231333839223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:8c1f16917836022ba0f3fe769cbde412', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439353830353b6b616c646572615f746f6b656e7c733a33323a226239386536383830613731396666396663316361656139373731376237346535223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b),
	('kaldera_session:8d8b5791b0962b89a23cccd6c1a95ccb', '103.164.114.106', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303436313933363b6b616c646572615f746f6b656e7c733a33323a223961646661353334396663633139386135393334613863323165633133336336223b5f63695f70726576696f75735f75726c7c733a34383a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70742d6d696e657262612f6d6173746572223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343235313336223b6c6173745f636865636b7c693a313736303433383536353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:8dc94052bade73c12741dba8343d316b', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431303335373b6b616c646572615f746f6b656e7c733a33323a223236646563623764343261643037656230386131376339353830386634613838223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:8e6b25a0e9f1a054dca17023224dc98b', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303436303138393b6b616c646572615f746f6b656e7c733a33323a223439663634336638666132376334343032616461653033373630666634666336223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b),
	('kaldera_session:9071347e5892e72fd87507d54ccfd821', '66.249.83.129', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323039323b6b616c646572615f746f6b656e7c733a33323a226462393335373037373135366366646336366539396663303962306339306234223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:9140abf650e4a2739e1f70f56c7e0c38', '182.2.44.55', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439343033323b6b616c646572615f746f6b656e7c733a33323a223431616639303963663965613638363861373637666436333362623137346565223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:91513ea003bc7abda87767e2da07ab33', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303530353339373b6b616c646572615f746f6b656e7c733a33323a226534383265366138653137383836653634386562663131313930326335666130223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:94bb63595748e2e66755f8d7d6b96b9d', '103.164.114.106', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432373137323b6b616c646572615f746f6b656e7c733a33323a223139386332363737373037356462613230323466323161383463666562316236223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:95463d41a086d72f12831b1e45287461', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373639303b6b616c646572615f746f6b656e7c733a33323a226431343434623533316231396632303833386435306239393138336136323531223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:95b60dae9332f2f951a8b93c2796bf32', '66.249.83.128', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353534353b6b616c646572615f746f6b656e7c733a33323a223262313038316566626465333564643361643030386664386336633034366663223b5f63695f70726576696f75735f75726c7c733a34313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f617574682f6c6f67696e223b),
	('kaldera_session:97515779327e684838e8260bf22a85d4', '66.249.83.130', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353534353b6b616c646572615f746f6b656e7c733a33323a223364316662343563356666363230396333663632343863663633616233313161223b6572726f727c733a33303a2253696c616b616e206c6f67696e207465726c6562696820646168756c7521223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226e6577223b7d),
	('kaldera_session:99f4e2d704334daf3c17f07f8224dfa2', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303638363735373b6b616c646572615f746f6b656e7c733a33323a226434663134303563353866343737373564353730383730313135633136313863223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363333353436223b6c6173745f636865636b7c693a313736303638363132383b),
	('kaldera_session:9ab775e0df3b6ec5b79367623c5052d0', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303633343136333b6b616c646572615f746f6b656e7c733a33323a223165623961623434656231643163666566366234373064623661393833663362223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353732383932223b6c6173745f636865636b7c693a313736303633333534363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:9b6c5e72b57651da5811d21641c937ec', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432343638373b6b616c646572615f746f6b656e7c733a33323a226134653565363830376337623462303034376163383362656262613466613531223b5f63695f70726576696f75735f75726c7c733a37303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f62656c616e6a612f696e7075743f62756c616e3d39267461686170616e3d70657275626168616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:9bf3c341d7ae70af5d458331a8b88a61', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438383037383b6b616c646572615f746f6b656e7c733a33323a223763636465393431663665663965356638323133643861623734383735363139223b5f63695f70726576696f75735f75726c7c733a37333a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70656e6461706174616e2f696e7075743f62756c616e3d32267461686170616e3d70657275626168616e223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:9cf5a32f54c7602dcb6eacdc8b88bf01', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431363533323b6b616c646572615f746f6b656e7c733a33323a223530386633643039373437363836663237306566383963623130343033346465223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343133383435223b6c6173745f636865636b7c693a313736303431353236373b),
	('kaldera_session:9ee607b994960741599dd38f3964c8f2', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393933303338393b6b616c646572615f746f6b656e7c733a33323a223630383236313233366133363338363566393230663561303537393230656330223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235343238223b6c6173745f636865636b7c693a313735393932373732383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:9fc5414cf779262643fe0473bcbc210c', '66.249.66.161', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538353538333b6b616c646572615f746f6b656e7c733a33323a223334376435386631363930386233303239373565656338633865383438323931223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:a0b58286f232a011aabc00d1a52aabed', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432363732343b6b616c646572615f746f6b656e7c733a33323a226338313938303531643832393739616237303632636437633463363864613163223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:a10a05c06c331602cafd9d704056f3c0', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323032393b6b616c646572615f746f6b656e7c733a33323a223433613436393135633835383631383032373463303034623662633734373535223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131393538223b6c6173745f636865636b7c693a313736303431323032393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:a47de8abb76f86e37c558910c07d34e3', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432333937323b6b616c646572615f746f6b656e7c733a33323a226238613236346532393335336465333564663236323762396565306334663964223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f72656b6170223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:a5f7c49cdd8dfdd4a6c7f2b5b61bba0f', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373039323b6b616c646572615f746f6b656e7c733a33323a223265346537386338633838393161343161353665656532303337333337613338223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:a7e0e1e4bad1598b0f959c2c434fd95c', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439353830343b6b616c646572615f746f6b656e7c733a33323a226363613266343163356466633032616231303137366536343133626538356265223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:a8a3ae18934292b00d6f915c0363c40c', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537343631313b6b616c646572615f746f6b656e7c733a33323a223833663066396630316265353931343364366532353239366234666262363637223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b),
	('kaldera_session:a962da6f9239300a2ed1725ef39b40e2', '66.249.83.128', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532353630303b6b616c646572615f746f6b656e7c733a33323a226562643762373266343865343337333132666232316130643863396465383238223b6572726f727c733a33303a2253696c616b616e206c6f67696e207465726c6562696820646168756c7521223b5f5f63695f766172737c613a313a7b733a353a226572726f72223b733a333a226f6c64223b7d5f63695f70726576696f75735f75726c7c733a34313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f617574682f6c6f67696e223b),
	('kaldera_session:a96411a74127e37f69f6eea04e311de5', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432313134363b6b616c646572615f746f6b656e7c733a33323a223165646130306461326464343237333831636333336639623765303133643537223b5f63695f70726576696f75735f75726c7c733a33393a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f64617461223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:a97a2591ba3b57b1bca9d172dbcdae04', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393735353838323b6b616c646572615f746f6b656e7c733a33323a223064363964333061333565633566343634313162363865353131353166383963223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363530333038223b6c6173745f636865636b7c693a313735393735343539313b),
	('kaldera_session:aa4d8ab78b7f30d76de92ca7769800f6', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432383835303b6b616c646572615f746f6b656e7c733a33323a226463333131383031656663656664333139653661613536623932396633316330223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:aac0e046a64880dfaedb7638f4cbf9bb', '212.83.148.205', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432363235363b6b616c646572615f746f6b656e7c733a33323a223732303636343264323765636437303461383635643336396563346534616666223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:ae2458d7d2ef85d3e29f171cd75e8bfd', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439363434363b6b616c646572615f746f6b656e7c733a33323a223034623131653039336231303736666339373865306466356237326338383162223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b),
	('kaldera_session:af2045b359e2e8abad52b13cc8436ff9', '151.115.98.201', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432323033343b6b616c646572615f746f6b656e7c733a33323a223663653137616538303738373931363061613766636665393264383366633865223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:af9e796ca1a94c644241d66a3ce634c1', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303633333534363b6b616c646572615f746f6b656e7c733a33323a223861636539653261373164626562666161353133656338656131393138303233223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353732383932223b6c6173745f636865636b7c693a313736303633333534363b),
	('kaldera_session:afde391b55acbaf8b73eb9b346bc6e04', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313634343b6b616c646572615f746f6b656e7c733a33323a226263343835323835333232613635353266653161373162363466653934353662223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:b09bcca004930accdd506cb0bda3ff75', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431353839363b6b616c646572615f746f6b656e7c733a33323a226239396262623264633763636334306633316364626336643338313966343364223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343133383435223b6c6173745f636865636b7c693a313736303431353236373b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:b0aa516776b9ec64c39e552227b9ce89', '82.145.215.206', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432373137353b6b616c646572615f746f6b656e7c733a33323a223462346230623939666232663935373930616535336434376538663039343761223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:b1a725d34f515f73d79754a5e0263246', '182.2.44.55', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439343133323b6b616c646572615f746f6b656e7c733a33323a226537666536633563383639336230346564323061323366636436303436653536223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:b3dd1770553d870e233c97d81d058d51', '151.115.98.201', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431313935383b6b616c646572615f746f6b656e7c733a33323a223962663831323463303733373665316634653036356530396434383965613864223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b),
	('kaldera_session:b61c3998d899650a46558908737a35a1', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432343537393b6b616c646572615f746f6b656e7c733a33323a226536316161636263623161353033623138653331386431373139616161313930223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343135323637223b6c6173745f636865636b7c693a313736303432303930313b),
	('kaldera_session:b62a087d903cf016fa85ee511f7d3ade', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363435393b6b616c646572615f746f6b656e7c733a33323a226661636637343361616334353235633663616436326638363262353936653636223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353134303436223b6c6173745f636865636b7c693a313736303531363435393b),
	('kaldera_session:b646e3937883fa1141e4c7fadd323dd7', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393735353838323b6b616c646572615f746f6b656e7c733a33323a223836333166633239623835356531333766363338323538303334393265663863223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363530333038223b6c6173745f636865636b7c693a313735393735343539313b),
	('kaldera_session:b6c8536ca2fc4e6e8f790f9e56b23705', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438393339333b6b616c646572615f746f6b656e7c733a33323a226535633062353133326638376336633163663363346638303733366531643066223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:b78772f925fb3084e074a8e7d68365e2', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537333235333b6b616c646572615f746f6b656e7c733a33323a226465646535393836383737313636663131623734376238333862653230656162223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:b996d10c640d1dd5bfd41e44aab1a65c', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531353637313b6b616c646572615f746f6b656e7c733a33323a226664663932356536666234663531326163616565383563626566613462633039223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:b9e370533ae75fc1121b23280b087e46', '114.10.8.64', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303532343434333b6b616c646572615f746f6b656e7c733a33323a226362616639663632626233336165633238313964663663346263336161306530223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343937363930223b6c6173745f636865636b7c693a313736303531343034363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:ba181314187fd8d8a0a7e34ae653b8c9', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537333938393b6b616c646572615f746f6b656e7c733a33323a223030323737303462636232393639326262613938386333656336333234316235223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b),
	('kaldera_session:bb7994b126d70f09c8d90e07658477de', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303035373938313b6b616c646572615f746f6b656e7c733a33323a223637643263356164373864643935663130666462636236666666643136316230223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630303234323039223b6c6173745f636865636b7c693a313736303035373937383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:bb87e7629f2e298387a699b403501478', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373130323b6b616c646572615f746f6b656e7c733a33323a223965623161366565336332616633306663326531623232356532386266336636223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:be096375fa0ef19a519f7dee6255b08f', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932373238313b6b616c646572615f746f6b656e7c733a33323a223335363764373962643061303066663739643532393132636337363232393335223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235303536223b6c6173745f636865636b7c693a313735393932353432383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:c012a14abf5a3c5f50e447f945b45de6', '182.2.47.152', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303735333932313b6b616c646572615f746f6b656e7c733a33323a223634336439383938666139383962363365633266356239376163313031646636223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:c0ec9a6416bafdf34bd28d509648fa80', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393833383937333b6b616c646572615f746f6b656e7c733a33323a223163646430393539343639643034386666316331346530363535353238353332223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:c775161d7234bc5b3ae6a314e776bb45', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531343939343b6b616c646572615f746f6b656e7c733a33323a223632303039656163353462363932626339633731353438613436616334353866223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:c9811ef4abdabd50fe361c5cf204477f', '66.249.83.130', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431323039333b6b616c646572615f746f6b656e7c733a33323a223134613762623461363230313334656662663232343836623864626537653263223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:cb9f705ae85e373a53de1717399a5d37', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834353832323b6b616c646572615f746f6b656e7c733a33323a223534653661623664393730323135656130323735386336323730636163653263223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b),
	('kaldera_session:cbf14667dae3e33d839f86eda681507d', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531323333383b6b616c646572615f746f6b656e7c733a33323a223435623965643766373638326331616639643932356261623639323463306238223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343935383035223b6c6173745f636865636b7c693a313736303439373639303b),
	('kaldera_session:cc7b45ce25b5eb3580b93bee346bfdcf', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303638363735373b6b616c646572615f746f6b656e7c733a33323a223562663735343131346335343032313239636231626463626334353138376437223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363333353436223b6c6173745f636865636b7c693a313736303638363132383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:ccc6c50cb929e2179a584fd1941ea819', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834353039343b6b616c646572615f746f6b656e7c733a33323a226166643030613931303665303165343863393165613333356539343536363965223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:d0bdfe13e297cdc68133ed7d0b1daedf', '114.10.8.64', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531333536363b6b616c646572615f746f6b656e7c733a33323a223932336165643432326636333463613465613633643030653438373964633837223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:d0fdcad3f8ee6c4ae56567522b6fea65', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431373230313b6b616c646572615f746f6b656e7c733a33323a226532313364313561333230653564353331613864366162653039636461306164223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343133383435223b6c6173745f636865636b7c693a313736303431353236373b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:d3392622fe0d8fe21efd1ccd51d3de40', '125.161.54.2', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303632343734323b6b616c646572615f746f6b656e7c733a33323a223162356135346563363735363163336564353566626464366339323839636265223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:d505275c65dc91bb1879bbc6b4644ac8', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303431333630393b6b616c646572615f746f6b656e7c733a33323a223962663831323463303733373665316634653036356530396434383965613864223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343131383330223b6c6173745f636865636b7c693a313736303431313935383b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:d56c952da63716e05bd30a7ac1b984a3', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531383536343b6b616c646572615f746f6b656e7c733a33323a226665353833316639633534626636616135343163373430366665336437376332223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:da1311401df0b9d1bddf6715f838517f', '103.148.201.130', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303433383536353b6b616c646572615f746f6b656e7c733a33323a226133646336623436376239393733666362373139663563653635363733646664223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343235313336223b6c6173745f636865636b7c693a313736303433383536353b),
	('kaldera_session:da560cb56d9950130ca87833c080750e', '103.164.114.106', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303436313933363b6b616c646572615f746f6b656e7c733a33323a223961646661353334396663633139386135393334613863323165633133336336223b5f63695f70726576696f75735f75726c7c733a34383a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70742d6d696e657262612f6d6173746572223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343235313336223b6c6173745f636865636b7c693a313736303433383536353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:db7a18e4a0735c748d653710973680d0', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393833383137393b6b616c646572615f746f6b656e7c733a33323a223561363761316536393835663939376463633030646365313234383161353965223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b),
	('kaldera_session:dddc18d83bd4a7aec02df2924f801402', '66.96.233.187', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303736303734363b6b616c646572615f746f6b656e7c733a33323a223663396265633732323963613566316465333531393231336361303163333838223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363836313238223b6c6173745f636865636b7c693a313736303735393139313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:de00e13907ed5dcf7df183796fc269de', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438353234353b6b616c646572615f746f6b656e7c733a33323a223366376566376364393430346338333336306666353365626238386162303730223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b),
	('kaldera_session:dfacb1944a428de6fcd9ac88680dcd9c', '114.10.18.248', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303435383838363b6b616c646572615f746f6b656e7c733a33323a223766363566306362366166626164323333616338333635323264316535316465223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343338353635223b6c6173745f636865636b7c693a313736303435323239333b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:e2e77e5e3a246d6f5c69216a2068fd4c', '66.96.233.187', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303735393739323b6b616c646572615f746f6b656e7c733a33323a226236366137326631386638373931333738313230353139646139333164333131223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363836313238223b6c6173745f636865636b7c693a313736303735393139313b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:e337da8828b2a0f5fdcdc526d65fb132', '103.215.25.85', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531363535363b6b616c646572615f746f6b656e7c733a33323a223537353963663066643331663330363234663964626537373236353630613662223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343931373834223b6c6173745f636865636b7c693a313736303439353830353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:e7f881d016523c805a5e4264778c5ad3', '104.28.219.244', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537323839323b6b616c646572615f746f6b656e7c733a33323a226435303334363066396463646562333866306263666264656434326565343764223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353731383632223b6c6173745f636865636b7c693a313736303537323839323b),
	('kaldera_session:e9cb9ac76363c04ccaa3e822bc9b557a', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439373130323b6b616c646572615f746f6b656e7c733a33323a223965623161366565336332616633306663326531623232356532386266336636223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343532323933223b6c6173745f636865636b7c693a313736303438353234353b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:ecf916d4c59f4955f8ccbfadbb49ed3c', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303438373433343b6b616c646572615f746f6b656e7c733a33323a223535656564626631346135316661633830316236333039623132353261353239223b5f63695f70726576696f75735f75726c7c733a34383a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f70656e6461706174616e2f6d6173746572223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323435223b6c6173745f636865636b7c693a313736303438353237353b),
	('kaldera_session:ee771e53c2cac4b32da433ad25ee34c7', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303439333938373b6b616c646572615f746f6b656e7c733a33323a226632343465336631333464346364383663663263613636616362613336313630223b5f63695f70726576696f75735f75726c7c733a33373a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f67656e646572223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343835323735223b6c6173745f636865636b7c693a313736303439313738343b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:ef265053127413ed4049f4bc10b54474', '103.148.201.130', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303436313234343b6b616c646572615f746f6b656e7c733a33323a223936333539386336326136346463353233323863623131343965643835326666223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f74666b2f696e707574223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630343235313336223b6c6173745f636865636b7c693a313736303433383536353b),
	('kaldera_session:f4d1a0c7345b507a72d2d690ad2a0c62', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393834333038383b6b616c646572615f746f6b656e7c733a33323a223961326264393935366637373036633431333736313663643631623638616636223b5f63695f70726576696f75735f75726c7c733a33383a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539373534353931223b6c6173745f636865636b7c693a313735393833383137393b),
	('kaldera_session:f59bdc1ac173bb9cb8ebaa39567c048d', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538383131373b6b616c646572615f746f6b656e7c733a33323a226532306136616339653263633534356331323836383663616537343733636337223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:f72261388bec7908fe5af57931a274d1', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303537323535393b6b616c646572615f746f6b656e7c733a33323a226464656436396432303961396664633639636631613135323033333230663937223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353437383333223b6c6173745f636865636b7c693a313736303537313836323b),
	('kaldera_session:f7661a9bff11fb96eaf6df6d9f371617', '149.113.106.117', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303633343136333b6b616c646572615f746f6b656e7c733a33323a226465363933393764626334653333633038393436396339666135333563646163223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353732383932223b6c6173745f636865636b7c693a313736303633333534363b5f5f63695f766172737c613a303a7b7d),
	('kaldera_session:f9b189cb18160ad16a1340bc498a37be', '66.96.233.187', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303735393139313b6b616c646572615f746f6b656e7c733a33323a226236366137326631386638373931333738313230353139646139333164333131223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630363836313238223b6c6173745f636865636b7c693a313736303735393139313b),
	('kaldera_session:f9e31e4506729e4ad0ce07b86f639760', '103.107.244.194', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303531383535353b6b616c646572615f746f6b656e7c733a33323a226164623131303933326235343765663233636231316330333562386438386336223b5f63695f70726576696f75735f75726c7c733a34303a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f64617368626f617264223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373630353134303436223b6c6173745f636865636b7c693a313736303531363435393b),
	('kaldera_session:fa9f4e7d77cc0747b5c70c708ab7c7aa', '212.83.148.205', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303432363234353b6b616c646572615f746f6b656e7c733a33323a223637363664653664386663313261323037633834373764306239353937633033223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b),
	('kaldera_session:fd2fb397dab9179529c46363c1cf90a8', '::1', 4294967295, _binary 0x6b616c646572615f746f6b656e7c733a33323a223663306234666633663665323431353864366166323937356462303731316238223b5f5f63695f6c6173745f726567656e65726174657c693a313735393635303330383b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539363432303531223b6c6173745f636865636b7c693a313735393635303330383b),
	('kaldera_session:fe556cc7dbc65d2b2acd0cdb728385f9', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932343835393b6b616c646572615f746f6b656e7c733a33323a223465316333373234613338326364643034396632303464373531636234653133223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b),
	('kaldera_session:ff0ab08f183c22c6e3415beb4d9a9f7d', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932313534353b6b616c646572615f746f6b656e7c733a33323a223738323764656632393535356539643663373238366639656131336230303131223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539383338313739223b6c6173745f636865636b7c693a313735393932313534353b),
	('kaldera_session:ff5fe0d4eced0f2174e2e5aff77f10d6', '::1', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313735393932373732383b6b616c646572615f746f6b656e7c733a33323a226231326663636336326335303534373737323735653533386533363165326534223b5f63695f70726576696f75735f75726c7c733a32393a22687474703a2f2f6c6f63616c686f73742f7035372d6b616c646572612f223b6964656e746974797c733a31303a22737570657261646d696e223b757365726e616d657c733a31303a22737570657261646d696e223b656d61696c7c733a32303a22737570657261646d696e4061646d696e2e636f6d223b757365725f69647c733a313a2232223b6f6c645f6c6173745f6c6f67696e7c733a31303a2231373539393235343238223b6c6173745f636865636b7c693a313735393932373732383b),
	('kaldera_session:ff93a2f506c687d59b6271e0e43f918a', '66.249.66.160', 4294967295, _binary 0x5f5f63695f6c6173745f726567656e65726174657c693a313736303538363239343b6b616c646572615f746f6b656e7c733a33323a223039316530383932396265313865353434613439383065313862653031653066223b5f63695f70726576696f75735f75726c7c733a33313a2268747470733a2f2f6b616c646572612e746967657261736f66742e636f6d2f223b);

-- Dumping structure for table mikhaelf_db_kaldera.tbl_target_fisik_keu_detail
DROP TABLE IF EXISTS `tbl_target_fisik_keu_detail`;
CREATE TABLE IF NOT EXISTS `tbl_target_fisik_keu_detail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `master_id` int(11) unsigned NOT NULL,
  `bulan` varchar(3) NOT NULL,
  `fisik` decimal(5,2) NOT NULL DEFAULT 0.00,
  `keu` decimal(5,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `keu_real` decimal(5,2) DEFAULT 0.00,
  `tahun` int(4) DEFAULT 2025,
  `realisasi_fisik` decimal(5,2) DEFAULT 0.00 COMMENT 'Realisasi Fisik (%)',
  `realisasi_fisik_prov` decimal(5,2) DEFAULT 0.00 COMMENT 'Realisasi Fisik Provinsi (%)',
  `realisasi_keu_prov` decimal(5,2) DEFAULT 0.00 COMMENT 'Realisasi Keuangan Provinsi (%)',
  `analisa` text DEFAULT NULL COMMENT 'Analisa',
  PRIMARY KEY (`id`),
  KEY `tbl_target_fisik_keu_detail_master_id_foreign` (`master_id`),
  CONSTRAINT `tbl_target_fisik_keu_detail_master_id_foreign` FOREIGN KEY (`master_id`) REFERENCES `tbl_target_fisik_keu_master` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_target_fisik_keu_detail: ~0 rows (approximately)
DELETE FROM `tbl_target_fisik_keu_detail`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_target_fisik_keu_master
DROP TABLE IF EXISTS `tbl_target_fisik_keu_master`;
CREATE TABLE IF NOT EXISTS `tbl_target_fisik_keu_master` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(150) NOT NULL,
  `tahapan` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_target_fisik_keu_master: ~0 rows (approximately)
DELETE FROM `tbl_target_fisik_keu_master`;

-- Dumping structure for table mikhaelf_db_kaldera.tbl_uploads
DROP TABLE IF EXISTS `tbl_uploads`;
CREATE TABLE IF NOT EXISTS `tbl_uploads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table mikhaelf_db_kaldera.tbl_uploads: ~2 rows (approximately)
DELETE FROM `tbl_uploads`;
INSERT INTO `tbl_uploads` (`id`, `id_user`, `name`, `keterangan`, `file`, `created_at`, `updated_at`) VALUES
	(2, 2, 'LKjIP 2024', '', 'file/laporan/2/file/laporan_2_1760416469.pdf', '2025-10-14 11:34:29', '2025-10-14 11:34:29'),
	(3, 2, 'Laporan Hibah Bansos 2024', '', 'file/laporan/3/file/laporan_3_1760416532.pdf', '2025-10-14 11:35:32', '2025-10-14 11:35:32');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
