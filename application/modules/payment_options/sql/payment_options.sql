CREATE TABLE IF NOT EXISTS  payment_options (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	account  varchar(256)  DEFAULT '' NOT NULL, 
	business_number  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;