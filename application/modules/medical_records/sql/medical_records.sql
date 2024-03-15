CREATE TABLE IF NOT EXISTS  medical_records (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	date  INT(11), 
	student  varchar(32)  DEFAULT '' NOT NULL, 
	sickness  varchar(256)  DEFAULT '' NOT NULL, 
	action_taken  text  , 
	comment  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;