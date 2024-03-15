CREATE TABLE `sales_items_stock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`purchase_date` INT(11) NULL DEFAULT NULL,
	`item_id` INT(11) NULL DEFAULT NULL,
	`quantity` FLOAT NULL DEFAULT NULL,
	`unit_price` FLOAT NULL DEFAULT NULL,
	`total` FLOAT NULL DEFAULT NULL,
	`person_responsible` INT(11) NULL DEFAULT NULL,
	`receipt` VARCHAR(256) NOT NULL DEFAULT '',
	`description` TEXT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=7;
