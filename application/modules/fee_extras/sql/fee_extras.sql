CREATE TABLE IF NOT EXISTS  fee_extras (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	ftype  varchar(32)  DEFAULT '' NOT NULL, 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;