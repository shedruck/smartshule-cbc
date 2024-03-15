CREATE TABLE `crontab` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`exec` BLOB NOT NULL,
	`created_by` BLOB NULL,
	`modified_by` BLOB NULL,
	`created_on` BLOB NULL,
	`modified_on` BLOB NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
