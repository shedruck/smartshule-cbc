CREATE TABLE `purchase_order_payment` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`order_id` BLOB NOT NULL,
	`amount` BLOB NOT NULL,
	`date` BLOB NOT NULL,
	`account` BLOB NOT NULL,
	`created_by` BLOB NULL,
	`modified_by` BLOB NULL,
	`created_on` BLOB NULL,
	`modified_on` BLOB NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=40;
