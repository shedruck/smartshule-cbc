CREATE TABLE `leaving_certificate` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`ht_remarks` TEXT NULL,
	`pupil_conduct` TEXT NULL,
	`co_curricular` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`leaving_date` INT(11) NULL DEFAULT NULL,
	`student_id` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT
AUTO_INCREMENT=6;
