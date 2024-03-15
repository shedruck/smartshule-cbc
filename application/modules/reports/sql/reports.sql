CREATE TABLE `reports` (
	`id` INT(9) NOT NULL AUTO_INCREMENT,
	`client_id` BLOB NOT NULL,
	`idate` BLOB NULL,
	`duedate` BLOB NULL,
	`offset` BLOB NULL,
	`description` BLOB NOT NULL,
	`created_by` BLOB NULL,
	`modified_by` BLOB NULL,
	`created_on` BLOB NULL,
	`modified_on` BLOB NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
