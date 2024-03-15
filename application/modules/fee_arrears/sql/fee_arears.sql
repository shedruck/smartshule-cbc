CREATE TABLE IF NOT EXISTS  fee_arrears (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	term  varchar(256)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;