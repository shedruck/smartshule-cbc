CREATE TABLE IF NOT EXISTS  events (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(255)  DEFAULT '' NOT NULL, 
	date  varchar(255)  DEFAULT '' NOT NULL, 
	start  varchar(255)  DEFAULT '' NOT NULL, 
	end  varchar(255)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;