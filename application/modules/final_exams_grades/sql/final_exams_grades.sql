CREATE TABLE IF NOT EXISTS  final_exams_grades (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	certificate_id  varchar(256)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	grade  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;