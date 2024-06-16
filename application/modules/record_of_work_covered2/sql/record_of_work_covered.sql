CREATE TABLE IF NOT EXISTS  record_of_work_covered (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	year  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	week  varchar(256)  DEFAULT '' NOT NULL, 
	date  INT(11), 
	strand  varchar(256)  DEFAULT '' NOT NULL, 
	substrand  varchar(256)  DEFAULT '' NOT NULL, 
	work_covered  text  , 
	reflection  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;