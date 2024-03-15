CREATE TABLE IF NOT EXISTS  audit_logs (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	module  varchar(256)  DEFAULT '' NOT NULL, 
	items_id  varchar(256)  DEFAULT '' NOT NULL, 
	transaction_type  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;