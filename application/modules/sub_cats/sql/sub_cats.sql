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

-- Dumping structure for table setup.sub_cats
CREATE TABLE IF NOT EXISTS `sub_cats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(256) NOT NULL DEFAULT '',
  `parent` int(9) NOT NULL,
  `description` text,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Dumping data for table setup.sub_cats: ~12 rows (approximately)
/*!40000 ALTER TABLE `sub_cats` DISABLE KEYS */;
INSERT INTO `sub_cats` (`id`, `title`, `parent`, `description`, `created_by`, `modified_by`, `created_on`, `modified_on`) VALUES
	(1, 'Modelling', 12, '<font face="Arial, Verdana" size="2">Modelling</font>', 1, 1, 1412591315, 1412597314),
	(2, 'Painting', 12, '<font face="Arial, Verdana" size="2">Painting</font>', 1, NULL, 1412597230, NULL),
	(3, 'Drawing', 12, '<font face="Arial, Verdana" size="2">Drawing</font>', 1, NULL, 1412597252, NULL),
	(4, 'Tracing & Colouring', 12, '<font face="Arial, Verdana" size="2">Tracing &amp; Colouring</font>', 1, NULL, 1412597275, NULL),
	(5, 'Cutting & Sticking', 12, '<font face="Arial, Verdana" size="2">Cutting &amp; Sticking</font>', 1, NULL, 1412597295, NULL),
	(6, 'Reading', 13, '<font face="Arial, Verdana" size="2">Reading</font>', 1, NULL, 1412621123, NULL),
	(7, 'Spelling', 13, '<font face="Arial, Verdana" size="2">Spelling</font>', 1, NULL, 1412621157, NULL),
	(8, 'Patterns', 13, '<font face="Arial, Verdana" size="2">Patterns</font>', 1, NULL, 1412621251, NULL),
	(9, 'Counting Recognition', 14, '<font face="Arial, Verdana" size="2">Counting Recognition</font>', 1, NULL, 1412621315, NULL),
	(10, 'Writing', 14, '<font face="Arial, Verdana" size="2">Writing</font>', 1, NULL, 1412621370, NULL),
	(11, 'Simple Sums', 14, '<font face="Arial, Verdana" size="2">Simple Sums</font>', 1, NULL, 1412621403, NULL),
	(12, 'Number Value', 14, '<font face="Arial, Verdana" size="2">Number Value</font>', 1, NULL, 1412621426, NULL);
/*!40000 ALTER TABLE `sub_cats` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
