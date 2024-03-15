CREATE TABLE IF NOT EXISTS  shop_item (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	size_from  varchar(256)  DEFAULT '' NOT NULL, 
	size_to  varchar(256)  DEFAULT '' NOT NULL, 
	bp  varchar(256)  DEFAULT '' NOT NULL, 
	sp  varchar(256)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;