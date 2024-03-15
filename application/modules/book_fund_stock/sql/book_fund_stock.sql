CREATE TABLE `book_fund_stock` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`purchase_date` INT(11) NULL DEFAULT NULL,
	`book_id` INT(11) NULL DEFAULT NULL,
	`quantity` VARCHAR(256) NOT NULL DEFAULT '',
	`receipt` VARCHAR(256) NOT NULL DEFAULT '',
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=6;
