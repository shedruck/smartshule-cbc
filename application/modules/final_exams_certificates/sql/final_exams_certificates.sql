CREATE TABLE IF NOT EXISTS  final_exams_certificates (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	certificate_type  varchar(256)  DEFAULT '' NOT NULL, 
	serial_number  varchar(256)  DEFAULT '' NOT NULL, 
	mean_grade  varchar(256)  DEFAULT '' NOT NULL, 
	points  varchar(256)  DEFAULT '' NOT NULL, 
	certificate  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;