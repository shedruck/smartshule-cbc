-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.8 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for sms_sys
CREATE DATABASE IF NOT EXISTS `sms_sys` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `sms_sys`;


-- Dumping structure for table sms_sys.class_timetable_list
CREATE TABLE IF NOT EXISTS `class_timetable_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL DEFAULT '0',
  `subject` int(11) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `room` varchar(32) NOT NULL DEFAULT '',
  `teacher` varchar(32) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- Dumping data for table sms_sys.class_timetable_list: ~18 rows (approximately)
/*!40000 ALTER TABLE `class_timetable_list` DISABLE KEYS */;
INSERT INTO `class_timetable_list` (`id`, `class_id`, `subject`, `start_time`, `end_time`, `room`, `teacher`, `created_by`, `modified_by`, `created_on`, `modified_on`) VALUES
	(29, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732118, NULL),
	(30, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732118, NULL),
	(31, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732118, NULL),
	(32, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732118, NULL),
	(33, 2, 0, 0, 0, '0', '0', 3, NULL, 1394732478, NULL),
	(34, 2, 0, 0, 0, '0', '0', 3, NULL, 1394732478, NULL),
	(35, 2, 0, 0, 0, '0', '0', 3, NULL, 1394732478, NULL),
	(36, 2, 0, 0, 0, '0', '0', 3, NULL, 1394732478, NULL),
	(37, 2, 0, 0, 0, '0', '0', 3, NULL, 1394732478, NULL),
	(38, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732838, NULL),
	(39, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732838, NULL),
	(40, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732838, NULL),
	(41, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732838, NULL),
	(42, 1, 0, 0, 0, '0', '0', 3, NULL, 1394732838, NULL),
	(43, 1, 0, 0, 0, '0', '0', 3, NULL, 1394733695, NULL),
	(44, 1, 0, 0, 0, '0', '0', 3, NULL, 1394733695, NULL),
	(45, 1, 0, 0, 0, '0', '0', 3, NULL, 1394733695, NULL),
	(46, 1, 0, 0, 0, '0', '0', 3, NULL, 1394733695, NULL),
	(47, 1, 0, 0, 0, '0', '0', 3, NULL, 1394792865, NULL),
	(48, 1, 0, 0, 0, '0', '0', 3, NULL, 1394792865, NULL),
	(49, 1, 0, 0, 0, '0', '0', 3, NULL, 1394792865, NULL),
	(50, 1, 0, 0, 0, '0', '0', 3, NULL, 1394792865, NULL);
/*!40000 ALTER TABLE `class_timetable_list` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
