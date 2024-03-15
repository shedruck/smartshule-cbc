CREATE TABLE `fee_waivers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`date` INT(11) NULL DEFAULT NULL,
	`student` INT(11) ,
	`amount` float ,
	`year` INT(11) NULL DEFAULT NULL,
	`remarks` TEXT ,
	`created_by` INT(11) NULL DEFAULT NULL,
	`status` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
