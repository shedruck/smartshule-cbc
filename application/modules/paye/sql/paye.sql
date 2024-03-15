CREATE TABLE IF NOT EXISTS  paye (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	range_from  varchar(256)  DEFAULT '' NOT NULL, 
	range_to  varchar(256)  DEFAULT '' NOT NULL, 
	tax  varchar(256)  DEFAULT '' NOT NULL, 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;