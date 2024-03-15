CREATE TABLE `record_salaries` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`salary_date` INT(11) NULL DEFAULT NULL,
	`employee` INT(11) NULL DEFAULT NULL,
	`basic_salary` FLOAT NULL DEFAULT NULL,
	`nhif` FLOAT NULL DEFAULT NULL,
	`total_deductions` FLOAT NULL DEFAULT NULL,
	`total_allowance` FLOAT NULL DEFAULT NULL,
	`bank_details` TEXT NOT NULL,
	`deductions` TEXT NOT NULL,
	`allowances` TEXT NOT NULL,
	`nhif_no` VARCHAR(255) NOT NULL,
	`nssf_no` VARCHAR(255) NOT NULL,
	`salary_method` VARCHAR(255) NOT NULL,
	`comment` TEXT NOT NULL,
	`created_by` INT(11) NULL DEFAULT NULL,
	`modified_by` INT(11) NULL DEFAULT NULL,
	`created_on` INT(11) NULL DEFAULT NULL,
	`modified_on` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=28;
