CREATE TABLE IF NOT EXISTS  other_revenue (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	payment_date INT(11),
	category varchar(256) DEFAULT '' NOT NULL,
	item varchar(256) DEFAULT '' NOT NULL,
	amount varchar(256) DEFAULT '' NOT NULL,
	description varchar(400) DEFAULT '' NOT NULL,
	bank INT(11),
	transaction_code varchar(256),
	status INT(11),
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;