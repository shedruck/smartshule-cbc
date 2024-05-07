DROP TABLE IF EXISTS `igcse`;
CREATE TABLE IF NOT EXISTS `igcse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `igcse`
	CHANGE COLUMN `name` `title` VARCHAR(256) NULL DEFAULT '' COLLATE 'utf8_general_ci' AFTER `id`,
	ADD COLUMN `term` INT NULL DEFAULT NULL AFTER `title`,
	ADD COLUMN `year` INT NULL DEFAULT NULL AFTER `term`,
	ADD COLUMN `cats_weight` INT NULL DEFAULT NULL AFTER `year`,
	ADD COLUMN `main_weight` INT NULL DEFAULT NULL AFTER `cats_weight`,
	ADD COLUMN `description` TEXT NULL AFTER `main_weight`;

CREATE TABLE IF NOT EXISTS `igcse_exams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `igcse_exams`
	CHANGE COLUMN `name` `title` TEXT NULL COLLATE 'utf8_general_ci' AFTER `id`,
	ADD COLUMN `term` INT NULL DEFAULT NULL AFTER `title`,
	ADD COLUMN `year` INT NULL DEFAULT NULL AFTER `term`,
	ADD COLUMN `start_date` INT NULL DEFAULT NULL AFTER `year`,
	ADD COLUMN `end_date` INT NULL DEFAULT NULL AFTER `start_date`,
	ADD COLUMN `recording_end` INT NULL DEFAULT NULL AFTER `end_date`,
	ADD COLUMN `description` TEXT NULL AFTER `recording_end`;

ALTER TABLE `igcse_exams`
	ADD COLUMN `tid` INT(11) NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `igcse_exams`
	ADD COLUMN `type` INT(11) NULL DEFAULT NULL AFTER `tid`;

CREATE TABLE IF NOT EXISTS `gs_grades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grade_id` int(11) NOT NULL,
  `grade` text NOT NULL,
  `minimum_marks` int(11) DEFAULT NULL,
  `maximum_marks` int(11) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `igcse_marks_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `exams_id` int(11) NOT NULL,
  `subject` int(11) NOT NULL,
  `marks` int(11) NOT NULL,
  `remarks` varchar(255) NOT NULL,
  `out_of` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci ROW_FORMAT=DYNAMIC;

ALTER TABLE `igcse_marks_list`
	ADD COLUMN `student` INT(11) NOT NULL AFTER `subject`;

  ALTER TABLE `igcse_marks_list`
	ADD COLUMN `type` INT(11) NOT NULL AFTER `exams_id`;

ALTER TABLE `igcse_marks_list`
	ADD COLUMN `tid` INT(11) NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `igcse_marks_list`
	ADD COLUMN `class` INT(11) NULL DEFAULT NULL AFTER `tid`,
	ADD COLUMN `class_group` INT(11) NULL DEFAULT NULL AFTER `class`;

CREATE TABLE IF NOT EXISTS `igcse_computed_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `igcse_computed_marks`
	CHANGE COLUMN `name` `tid` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `id`,
	ADD COLUMN `cats_score` INT NULL DEFAULT NULL AFTER `tid`,
	ADD COLUMN `main_score` INT NULL DEFAULT NULL AFTER `cats_score`,
	ADD COLUMN `student` INT NULL DEFAULT NULL AFTER `main_score`,
	ADD COLUMN `subject` INT NULL DEFAULT NULL AFTER `student`,
	ADD COLUMN `total` INT NULL DEFAULT NULL AFTER `subject`,
	ADD COLUMN `grade` INT NULL DEFAULT NULL AFTER `total`,
	ADD COLUMN `stream_rank` INT NULL DEFAULT NULL AFTER `grade`,
	ADD COLUMN `ovr_rank` INT NULL DEFAULT NULL AFTER `stream_rank`,
	ADD COLUMN `grading` INT NULL DEFAULT NULL AFTER `ovr_rank`;

ALTER TABLE `igcse_computed_marks`
	ADD COLUMN `class` INT(11) NULL DEFAULT NULL AFTER `tid`,
	ADD COLUMN `class_group` INT(11) NULL DEFAULT NULL AFTER `class`;

ALTER TABLE `igcse_computed_marks`
	ADD COLUMN `dev` TEXT NULL AFTER `grading`;

ALTER TABLE `igcse_computed_marks`
	ADD COLUMN `comment` TEXT NULL AFTER `grade`;

ALTER TABLE `igcse_computed_marks`
	CHANGE COLUMN `grade` `grade` TEXT NULL AFTER `total`;

ALTER TABLE `igcse_computed_marks`
	CHANGE COLUMN `stream_rank` `stream_rank` TEXT NULL AFTER `comment`,
	CHANGE COLUMN `ovr_rank` `ovr_rank` TEXT NULL AFTER `stream_rank`;

CREATE TABLE IF NOT EXISTS `igcse_final_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL DEFAULT '',
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `igcse_final_results`
	CHANGE COLUMN `name` `tid` INT NULL DEFAULT NULL COLLATE 'utf8_general_ci' AFTER `id`,
	ADD COLUMN `class_group` INT NULL DEFAULT NULL AFTER `tid`,
	ADD COLUMN `class` INT NULL DEFAULT NULL AFTER `class_group`,
	ADD COLUMN `total` INT NULL DEFAULT NULL AFTER `class`,
	ADD COLUMN `mean_mark` INT NULL DEFAULT NULL AFTER `total`,
	ADD COLUMN `mean_grade` TEXT NULL AFTER `mean_mark`,
	ADD COLUMN `str_pos` INT NULL DEFAULT NULL AFTER `mean_grade`,
	ADD COLUMN `ovr_pos` INT NULL DEFAULT NULL AFTER `str_pos`,
	ADD COLUMN `outof` INT NULL DEFAULT NULL AFTER `ovr_pos`,
	ADD COLUMN `student` INT NULL DEFAULT NULL AFTER `outof`;

ALTER TABLE `igcse_final_results`
	ADD COLUMN `total_points` INT(11) NULL DEFAULT NULL AFTER `total`;

ALTER TABLE `igcse_computed_marks`
	ADD COLUMN `points` INT(11) NULL DEFAULT NULL AFTER `total`;
ALTER TABLE `igcse_final_results`
	CHANGE COLUMN `total_points` `points` INT(11) NULL DEFAULT NULL AFTER `total`;

ALTER TABLE `igcse_final_results`
	ADD COLUMN `points_outof` INT(11) NULL DEFAULT NULL AFTER `outof`;

ALTER TABLE `igcse_final_results`
	ADD COLUMN `gid` INT(11) NULL DEFAULT NULL AFTER `student`;

ALTER TABLE `igcse_marks_list`
	ADD COLUMN `gid` INT(11) NULL AFTER `out_of`;
  ALTER TABLE `igcse_final_results`
	ADD COLUMN `trs_comment` VARCHAR(100) NULL DEFAULT NULL AFTER `student`,
	ADD COLUMN `prin_comment` VARCHAR(100) NULL DEFAULT NULL AFTER `trs_comment`;
ALTER TABLE `igcse_final_results`
	ADD COLUMN `commentedby` INT(11) NULL DEFAULT NULL AFTER `prin_comment`;
