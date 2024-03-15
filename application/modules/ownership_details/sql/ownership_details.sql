CREATE TABLE IF NOT EXISTS  ownership_details (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	ownership  varchar(256)  DEFAULT '' NOT NULL, 
	proprietor  varchar(256)  DEFAULT '' NOT NULL, 
	ownership_type  varchar(256)  DEFAULT '' NOT NULL, 
	certificate_no  varchar(256)  DEFAULT '' NOT NULL, 
	town  varchar(256)  DEFAULT '' NOT NULL, 
	police_station  varchar(256)  DEFAULT '' NOT NULL, 
	health_facility  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;