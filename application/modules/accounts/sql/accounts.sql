CREATE TABLE IF NOT EXISTS  accounts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	name  varchar(256)  DEFAULT '' NOT NULL, 
	code  varchar(256)  DEFAULT '' NOT NULL, 
	account_type  INT(9) NOT NULL, 
	tax  INT(9) NOT NULL, 
	balance  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;