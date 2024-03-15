CREATE TABLE IF NOT EXISTS  enquiries (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	date  INT(11), 
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	dob  INT(11), 
	gender  varchar(32)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	class  varchar(256)  DEFAULT '' NOT NULL, 
	know_about  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;