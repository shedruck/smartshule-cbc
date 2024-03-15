CREATE TABLE `invoices` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`term` INT(11) NULL DEFAULT NULL,
	`invoice_no`  varchar(256) NOT NULL DEFAULT '' ,
	`fee_id` INT(11) NULL DEFAULT NULL,
	`student_id` INT(11) NULL DEFAULT NULL,
	`next_invoice_date` INT(11) NULL DEFAULT NULL,
	`check` INT(11) NULL DEFAULT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;
