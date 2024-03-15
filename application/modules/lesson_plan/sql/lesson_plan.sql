CREATE TABLE IF NOT EXISTS  lesson_plan (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	teacher  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	day  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	lesson  text  , 
	activity  text  , 
	objective  text  , 
	materials  text  , 
	assignment  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;