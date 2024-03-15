CREATE TABLE `return_book` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`return_date` INT(11) NULL DEFAULT NULL,
	`student` INT(11) NULL DEFAULT NULL,
	`book` VARCHAR(32) NOT NULL DEFAULT '',
	`remarks` TEXT NOT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
