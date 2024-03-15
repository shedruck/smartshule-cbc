-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.40 - MySQL Community Server (GPL) by Remi
-- Server OS:                    Linux
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table setup.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school` varchar(256) NOT NULL DEFAULT '',
  `postal_addr` varchar(256) NOT NULL DEFAULT '',
  `email` varchar(256) NOT NULL DEFAULT '',
  `tel` varchar(256) NOT NULL DEFAULT '',
  `cell` varchar(256) NOT NULL DEFAULT '',
  `motto` text NOT NULL,
  `document` varchar(256) NOT NULL DEFAULT '',
  `employees_time_in` varchar(256) NOT NULL DEFAULT '',
  `employees_time_out` varchar(256) NOT NULL DEFAULT '',
  `website` varchar(256) NOT NULL DEFAULT '',
  `fax` varchar(256) NOT NULL DEFAULT '',
  `town` varchar(256) NOT NULL DEFAULT '',
  `school_code` varchar(256) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `list_size` int(11) DEFAULT NULL,
  `message_initial` varchar(50) DEFAULT NULL,
  `pre_school` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Dumping data for table setup.settings: ~1 rows (approximately)
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` (`id`, `school`, `postal_addr`, `email`, `tel`, `cell`, `motto`, `document`, `website`, `fax`, `town`, `school_code`, `created_by`, `list_size`, `message_initial`, `pre_school`, `modified_by`, `created_on`, `modified_on`) VALUES
	(1, 'Smart Shule', 'Box 2000 - 00100 Nairobi', 'info@smartshule.com', '020-2000000', '0755054', 'Excel', 'logo981.png', '', '', 'Nairobi', '', NULL, 25, 'Hello', 0, 1, NULL, 1412850578);
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
