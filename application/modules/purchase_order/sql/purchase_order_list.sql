CREATE TABLE `purchase_order_list` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`purchase_id` INT(11) NULL DEFAULT NULL,
	`quantity` FLOAT NULL DEFAULT NULL,
	`unit_price` FLOAT NULL DEFAULT NULL,
	`description` VARCHAR(255) NOT NULL,
	`totals` FLOAT NULL DEFAULT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=73;
