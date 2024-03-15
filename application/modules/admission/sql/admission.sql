CREATE TABLE `admission` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`first_name` BLOB,
	`last_name` BLOB,
	`admission_number` BLOB,
	`dob` BLOB,
	`gender` BLOB,
	`status` BLOB,
	`email` BLOB ,
	`address` BLOB,
	`admission_date` BLOB,
	`class` BLOB,
	`stream` BLOB,
	`parent_fname` BLOB,
	`parent_lname` BLOB,
	`phone` BLOB,
	`parent_email` BLOB,
	`created_by` BLOB,
	`modified_by` BLOB,
	`created_on` BLOB,
	`modified_on` BLOB,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
ALTER TABLE `admission`  ADD `birth_cert_no` BLOB NOT NULL  AFTER `upi_number`;