CREATE TABLE IF NOT EXISTS  diary (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	activity  varchar(256)  DEFAULT '' NOT NULL, 
	date_  varchar(256)  DEFAULT '' NOT NULL, 
	teacher  varchar(256)  DEFAULT '' NOT NULL, 
	status  varchar(256)  DEFAULT '' NOT NULL, 
	verified  varchar(256)  DEFAULT '' NOT NULL, 
	teacher_comment  text  , 
	parent_comment  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;