CREATE TABLE `fee_class` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`fee_id` INT(11) NOT NULL,
	`class_id` INT(11) NOT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT;