-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.36 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table sms_sys.passports
CREATE TABLE IF NOT EXISTS `passports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(1000) NOT NULL DEFAULT '',
  `filesize` double NOT NULL,
  `fpath` varchar(1000) NOT NULL,
  `created_on` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table sms_sys.passports: ~0 rows (approximately)
/*!40000 ALTER TABLE `passports` DISABLE KEYS */;
INSERT INTO `passports` (`id`, `filename`, `filesize`, `fpath`, `created_on`, `created_by`, `modified_on`, `modified_by`) VALUES
	(1, 'DonBlueEyeLo1.jpg', 47.38, 'student/2014/', 1402672496, 1, NULL, NULL),
	(2, 'duskByOcean.jpg', 44.43, 'student/2014/', 1402673526, 1, NULL, NULL);
/*!40000 ALTER TABLE `passports` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
