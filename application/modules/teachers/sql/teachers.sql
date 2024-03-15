CREATE TABLE `teachers` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`user_id` BLOB NULL,
	`status` BLOB NULL,
	`designation` BLOB NULL,
	`created_by` BLOB NULL,
	`modified_by` BLOB NULL,
	`created_on` BLOB NULL,
	`modified_on` BLOB NULL,
	PRIMARY KEY (`id`)
)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;