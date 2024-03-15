                CREATE TABLE IF NOT EXISTS  exams (
 	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(256) NOT NULL DEFAULT '',
	`grading` INT(11) NOT NULL,
	`term` INT(11) NOT NULL,
	`year` INT(11) NOT NULL,
	`start_date` INT(11) NULL DEFAULT NULL,
	`end_date` INT(11) NULL DEFAULT NULL,
	`recording_end_date` int(11) DEFAULT NULL,
	`description` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
                )
                COLLATE='utf8_general_ci'
                ENGINE=InnoDB;