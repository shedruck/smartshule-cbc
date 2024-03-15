CREATE TABLE IF NOT EXISTS  staff_clearance (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	date  INT(11), 
	department  varchar(32)  DEFAULT '' NOT NULL, 
	cleared  varchar(256)  DEFAULT '' NOT NULL, 
	charge  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;