CREATE TABLE IF NOT EXISTS  give_items (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	date  INT(11), 
	item  varchar(32)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
	given_to  varchar(32)  DEFAULT '' NOT NULL, 
	comment  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;