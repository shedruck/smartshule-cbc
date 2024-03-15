CREATE TABLE IF NOT EXISTS  effort (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	value  varchar(256)  DEFAULT '' NOT NULL, 
	remarks  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;