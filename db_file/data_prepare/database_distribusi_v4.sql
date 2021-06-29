-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.11-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table db_distribusi.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(250) NOT NULL,
  `ip_address` varchar(50) NOT NULL,
  `timestamp` int(11) DEFAULT NULL,
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for function db_distribusi.func_rfid
DELIMITER //
CREATE FUNCTION `func_rfid`(`data_alat` BIGINT
) RETURNS varchar(250) CHARSET utf8mb4
BEGIN
	
	-- Deklarasi Variabel
	DECLARE message VARCHAR(100);
	DECLARE nama VARCHAR(150);
	DECLARE jenis CHAR(1);
	
	-- If agen
	IF(data_alat IN(SELECT pel.data_rfid FROM tb_pelanggan pel WHERE pel.data_rfid = data_alat))
		THEN 
			INSERT INTO `db_distribusi`.`tb_log_device` (`data_rfid`, `jenis_rfid`, `create_date`, `change_date`) 
				VALUES (data_alat, 'P', CURRENT_TIME(), CURRENT_TIME());
			SELECT pel.nama INTO nama FROM tb_pelanggan pel WHERE pel.data_rfid = data_alat LIMIT 1;
			SET message = 'Tapping Kartu: ';

			
	-- else if masyarakat
	ELSEIF(data_alat IN(SELECT ag.data_rfid FROM tb_agen ag WHERE ag.data_rfid = data_alat))
		THEN
			INSERT INTO `db_distribusi`.`tb_log_device` (`data_rfid`, `jenis_rfid`, `create_date`, `change_date`) 
				VALUES (data_alat, 'A', CURRENT_TIME(), CURRENT_TIME());
			SELECT ag.nama INTO nama FROM tb_agen ag WHERE ag.data_rfid = data_alat LIMIT 1;
			SET message = 'Tapping Kartu: ';
	ELSE
		INSERT INTO `db_distribusi`.`tb_log_device` (`data_rfid`, `jenis_rfid`, `create_date`, `change_date`) 
			VALUES (data_alat, 'N', CURRENT_TIME(), CURRENT_TIME());
		SET message = 'Tapping Kartu ';
		SET nama = 'Data Baru';
	END IF;
	
	RETURN CONCAT(message, nama);
END//
DELIMITER ;

-- Dumping structure for function db_distribusi.func_temp_rfid
DELIMITER //
CREATE FUNCTION `func_temp_rfid`(`data_alat` BIGINT
) RETURNS tinytext CHARSET utf8mb4
BEGIN
	
	INSERT INTO `db_distribusi`.tb_temp_rfid (`data_rfid`, `create_date`) 
		VALUES (data_alat, CURRENT_TIME());

	RETURN '';
	
END//
DELIMITER ;

-- Dumping structure for table db_distribusi.tb_agen
CREATE TABLE IF NOT EXISTS `tb_agen` (
  `id_agen` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_reg` int(10) NOT NULL,
  `data_rfid` bigint(20) NOT NULL,
  `no_telepon` varchar(50) DEFAULT NULL,
  `jumlah_pelanggan` bigint(20) NOT NULL DEFAULT 0,
  `jumlah_tabung` bigint(20) NOT NULL DEFAULT 0,
  `photo` varchar(250) DEFAULT NULL,
  `jenis` char(1) NOT NULL DEFAULT 'A',
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_agen`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_distribusi_agen
CREATE TABLE IF NOT EXISTS `tb_distribusi_agen` (
  `id_distribusi_agen` int(11) NOT NULL AUTO_INCREMENT,
  `id_agen` int(11) NOT NULL,
  `jumlah_tabung` bigint(20) NOT NULL,
  `tanggal_pengambilan` datetime NOT NULL,
  `status_pengambilan` varchar(50) NOT NULL,
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_distribusi_agen`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_distribusi_masyarakat
CREATE TABLE IF NOT EXISTS `tb_distribusi_masyarakat` (
  `id_distribusi_masyarakat` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL,
  `id_agen` int(11) NOT NULL,
  `jumlah_tabung` bigint(20) NOT NULL,
  `status_pembelian` varchar(50) NOT NULL DEFAULT '0',
  `tanggal_pembelian` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_distribusi_masyarakat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_jenis
CREATE TABLE IF NOT EXISTS `tb_jenis` (
  `id_jenis` int(11) NOT NULL,
  `nama` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_kabupaten
CREATE TABLE IF NOT EXISTS `tb_kabupaten` (
  `id_kab` char(4) NOT NULL,
  `id_prov` char(2) NOT NULL,
  `nama` tinytext NOT NULL,
  `id_jenis` int(11) NOT NULL,
  PRIMARY KEY (`id_kab`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_kecamatan
CREATE TABLE IF NOT EXISTS `tb_kecamatan` (
  `id_kec` char(6) NOT NULL,
  `id_kab` char(4) NOT NULL,
  `nama` tinytext NOT NULL,
  PRIMARY KEY (`id_kec`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_kelurahan
CREATE TABLE IF NOT EXISTS `tb_kelurahan` (
  `id_kel` char(10) NOT NULL,
  `id_kec` char(6) DEFAULT NULL,
  `nama` tinytext DEFAULT NULL,
  `id_jenis` int(11) NOT NULL,
  PRIMARY KEY (`id_kel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_log_device
CREATE TABLE IF NOT EXISTS `tb_log_device` (
  `id_log` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_rfid` bigint(20) NOT NULL DEFAULT 0,
  `jenis_rfid` enum('A','P','N') NOT NULL,
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_pelanggan
CREATE TABLE IF NOT EXISTS `tb_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  `alamat` text NOT NULL,
  `nik` varchar(50) NOT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `kelurahan` text DEFAULT NULL,
  `kecamatan` text DEFAULT NULL,
  `kab_kota` text DEFAULT NULL,
  `provinsi` text DEFAULT NULL,
  `data_rfid` bigint(20) NOT NULL,
  `jenis` char(1) NOT NULL DEFAULT 'P',
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_pengguna
CREATE TABLE IF NOT EXISTS `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL,
  `priviledge_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `profile_id` int(11) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`id_pengguna`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_priviledge
CREATE TABLE IF NOT EXISTS `tb_priviledge` (
  `priviledge_id` int(11) NOT NULL AUTO_INCREMENT,
  `priviledge_name` varchar(50) NOT NULL,
  `status` enum('A','D') NOT NULL,
  `create_date` datetime NOT NULL,
  `change_date` datetime NOT NULL,
  PRIMARY KEY (`priviledge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_provinsi
CREATE TABLE IF NOT EXISTS `tb_provinsi` (
  `id_prov` char(2) NOT NULL,
  `nama` tinytext NOT NULL,
  PRIMARY KEY (`id_prov`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

-- Dumping structure for table db_distribusi.tb_temp_rfid
CREATE TABLE IF NOT EXISTS `tb_temp_rfid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_rfid` bigint(20) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
