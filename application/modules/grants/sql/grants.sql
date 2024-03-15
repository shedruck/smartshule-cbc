CREATE TABLE IF NOT EXISTS  grants (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	grant_type  varchar(32)  DEFAULT '' NOT NULL, 
	date  INT(11), 
	amount  varchar(256)  DEFAULT '' NOT NULL, 
	payment_method  varchar(32)  DEFAULT '' NOT NULL, 
	purpose  text  , 
	school_representative  varchar(256)  DEFAULT '' NOT NULL, 
	file  varchar(256)  DEFAULT '' NOT NULL, 
	contact_person  varchar(256)  DEFAULT '' NOT NULL, 
	contact_details  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;