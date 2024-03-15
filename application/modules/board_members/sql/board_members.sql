CREATE TABLE IF NOT EXISTS  board_members (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	file  varchar(256)  DEFAULT '' NOT NULL, 
	title  varchar(256)  DEFAULT '' NOT NULL, 
	first_name  varchar(256)  DEFAULT '' NOT NULL, 
	last_name  varchar(256)  DEFAULT '' NOT NULL, 
	gender  varchar(32)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	email  varchar(256)  DEFAULT '' NOT NULL, 
	position  varchar(256)  DEFAULT '' NOT NULL, 
	date_joined  INT(11), 
	profile  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;