CREATE TABLE IF NOT EXISTS  non_teaching (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	middle_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	address  text  , 
	additionals  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;