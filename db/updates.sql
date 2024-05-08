ALTER TABLE `cbc_assess_tasks` ADD `status` INT NULL AFTER `assess_id`, ADD `session` TEXT NULL AFTER `status`;

ALTER TABLE cbc_assess_tasks
ADD COLUMN status INT(11) NULL DEFAULT NULL AFTER task,
ADD COLUMN session TEXT NULL AFTER status,
ADD COLUMN remarks TEXT NULL AFTER session;

DROP TABLE IF EXISTS `cbc_marks`;
CREATE TABLE IF NOT EXISTS `cbc_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sub` int(11) DEFAULT NULL,
  `exam` int(11) DEFAULT NULL,
  `student` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `class_grp` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `outof` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


ALTER TABLE `diary_uploads`
	CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL FIRST,
	ADD COLUMN `student` BLOB NULL AFTER `id`;