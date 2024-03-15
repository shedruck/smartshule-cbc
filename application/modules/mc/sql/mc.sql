CREATE TABLE IF NOT EXISTS  mc (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	level  varchar(256)  DEFAULT '' NOT NULL, 
	title  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	topic  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;