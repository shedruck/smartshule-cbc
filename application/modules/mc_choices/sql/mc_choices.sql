CREATE TABLE IF NOT EXISTS  mc_choices (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	question_id  varchar(256)  DEFAULT '' NOT NULL, 
	choice  varchar(256)  DEFAULT '' NOT NULL, 
	state  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;