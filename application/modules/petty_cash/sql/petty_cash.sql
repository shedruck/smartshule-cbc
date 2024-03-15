CREATE TABLE `petty_cash` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`petty_date` INT(11) NULL DEFAULT NULL,
	`description` VARCHAR(1000) NOT NULL DEFAULT '',
	`amount` FLOAT NOT NULL,
	`person` INT(9) NOT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;