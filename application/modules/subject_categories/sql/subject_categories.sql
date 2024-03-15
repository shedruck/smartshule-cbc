CREATE TABLE IF NOT EXISTS  subject_categories (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	subject  INT(9) NOT NULL, 
	category  varchar(32)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;