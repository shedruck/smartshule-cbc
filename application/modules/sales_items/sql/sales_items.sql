CREATE TABLE `sales_items` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`item_name` VARCHAR(256) NOT NULL DEFAULT '',
	`category` INT(11) NULL DEFAULT NULL,
	`description` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6;
