CREATE TABLE IF NOT EXISTS  students_projects (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	level  varchar(256)  DEFAULT '' NOT NULL, 
	student  varchar(256)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	strand  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
	remarks  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;