CREATE TABLE IF NOT EXISTS  verifiers (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	upi_number  varchar(256)  DEFAULT '' NOT NULL, 
	name  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	reason  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;