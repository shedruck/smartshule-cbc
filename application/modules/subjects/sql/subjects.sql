CREATE TABLE IF NOT EXISTS  subjects (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	short_name  varchar(256)  DEFAULT '' NOT NULL, 
	sub_units INT(11), 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;