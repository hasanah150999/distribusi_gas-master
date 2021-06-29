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

-- Dumping data for table db_distribusi.tb_agen: ~3 rows (approximately)
DELETE FROM `tb_agen`;
/*!40000 ALTER TABLE `tb_agen` DISABLE KEYS */;
INSERT INTO `tb_agen` (`id_agen`, `nama`, `alamat`, `no_reg`, `data_rfid`, `no_telepon`, `jumlah_pelanggan`, `jumlah_tabung`, `photo`, `jenis`, `create_date`, `change_date`) VALUES
	(1, 'Agen', 'Jalan Depok', 1, NULL, '878878873123', 7, 9, 'image_44803fab72bcac44fe428dc9180896cae724ae0a_d075d64f54d0d60ad49daf91fc32b5fa028e0491.png', 'A', '0000-00-00 00:00:00', '2021-05-27 16:23:24'),
	(37, 'Agus', 'Jalan', 2, NULL, NULL, 0, 0, NULL, 'A', '2021-05-24 09:21:42', '2021-05-24 09:21:42'),
	(38, 'Atuy', 'Jalan Jalan', 3, NULL, '08812345123', 0, 0, NULL, 'A', '2021-05-24 11:48:43', '2021-05-26 11:31:18'),
	(39, 'Ucok Ali', 'Jalan Jalan', 3, NULL, NULL, 0, 10, NULL, 'A', '2021-05-27 14:53:13', '2021-05-27 14:53:30');
/*!40000 ALTER TABLE `tb_agen` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
