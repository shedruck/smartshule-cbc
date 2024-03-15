CREATE TABLE IF NOT EXISTS  custom_receipts (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	supplier  varchar(256)  DEFAULT '' NOT NULL, 
	supplier_email  varchar(256)  DEFAULT '' NOT NULL, 
	supplier_phone  varchar(256)  DEFAULT '' NOT NULL, 
	item  varchar(256)  DEFAULT '' NOT NULL, 
	quantity  varchar(256)  DEFAULT '' NOT NULL, 
	unit_price  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;