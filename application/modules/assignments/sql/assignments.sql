CREATE TABLE `assignments` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(256) NOT NULL DEFAULT '',
	`start_date` INT(11) NULL DEFAULT NULL,
	`end_date` INT(11) NULL DEFAULT NULL,
	`assignment` TEXT NOT NULL,
	`comment` TEXT NOT NULL,
	`document` VARCHAR(256) NOT NULL DEFAULT '',
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB ;
