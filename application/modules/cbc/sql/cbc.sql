-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.23-0ubuntu0.20.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table kindergates_kdg.cbc
CREATE TABLE IF NOT EXISTS `cbc` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class_id` int NOT NULL,
  `subject_id` int NOT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_assess
CREATE TABLE IF NOT EXISTS `cbc_assess` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` int DEFAULT NULL,
  `student` int DEFAULT NULL,
  `term` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `subject` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_assess_strands
CREATE TABLE IF NOT EXISTS `cbc_assess_strands` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assess_id` int DEFAULT NULL,
  `strand` int DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_assess_sub
CREATE TABLE IF NOT EXISTS `cbc_assess_sub` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assess_id` int DEFAULT NULL,
  `strand` int DEFAULT NULL,
  `sub_strand` int DEFAULT NULL,
  `rating` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `remarks` text,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_assess_tasks
CREATE TABLE IF NOT EXISTS `cbc_assess_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `assess_id` int DEFAULT NULL,
  `strand` int DEFAULT NULL,
  `sub_strand` int DEFAULT NULL,
  `task` int DEFAULT NULL,
  `rating` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_la
CREATE TABLE IF NOT EXISTS `cbc_la` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `subject` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_map
CREATE TABLE IF NOT EXISTS `cbc_map` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` int DEFAULT NULL,
  `term` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `subject` int DEFAULT NULL,
  `strands` longtext,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_subjects
CREATE TABLE IF NOT EXISTS `cbc_subjects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `priority` tinyint DEFAULT NULL,
  `cat` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_summ
CREATE TABLE IF NOT EXISTS `cbc_summ` (
  `id` int NOT NULL AUTO_INCREMENT,
  `class` int DEFAULT NULL,
  `student` int DEFAULT NULL,
  `term` int DEFAULT NULL,
  `year` int DEFAULT NULL,
  `gen_remarks` text,
  `tr_remarks` text,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_summ_score
CREATE TABLE IF NOT EXISTS `cbc_summ_score` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cbc_id` int DEFAULT NULL,
  `subject` int DEFAULT NULL,
  `exam` int DEFAULT NULL,
  `rating` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_tasks
CREATE TABLE IF NOT EXISTS `cbc_tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `topic` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

-- Dumping structure for table kindergates_kdg.cbc_topics
CREATE TABLE IF NOT EXISTS `cbc_topics` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '',
  `strand` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `modified_by` int DEFAULT NULL,
  `created_on` int DEFAULT NULL,
  `modified_on` int DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
