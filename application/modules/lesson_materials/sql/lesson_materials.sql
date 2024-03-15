CREATE TABLE IF NOT EXISTS  lesson_materials (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	class  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	topic  varchar(256)  DEFAULT '' NOT NULL, 
	subtopic  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
	soft  text  , 
	comment  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;