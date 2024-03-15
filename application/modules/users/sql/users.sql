CREATE TABLE `users` (
	`id` INT(10) UNSIGNED  AUTO_INCREMENT,
	`group_id` BLOB ,
	`ip_address` BLOB ,
	`username` BLOB,
	`password` BLOB ,
	`salt` BLOB ,
	`admission_number` BLOB ,
	`email` BLOB ,
	`activation_code` BLOB ,
	`first_name` BLOB ,
	`last_name` BLOB ,
	`company` BLOB, 
	`phone` BLOB ,
	`forgotten_password_code` BLOB ,
	`remember_code` BLOB ,
	`created_on` BLOB, 
	`last_login` BLOB, 
	`active`BLOB, 
	`role` BLOB,
	`created_by` BLOB,
	`modified_by`BLOB,
	`modified_on` BLOB,
	`changed_on` blob NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB
ROW_FORMAT=COMPACT ;