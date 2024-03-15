CREATE TABLE IF NOT EXISTS  enotes (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	term  varchar(256)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	class  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
	soft  text  , 
	remarks  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;