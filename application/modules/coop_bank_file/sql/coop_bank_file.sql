CREATE TABLE IF NOT EXISTS  coop_bank_file (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	transaction_date  varchar(256)  DEFAULT '' NOT NULL, 
	value_date  varchar(256)  DEFAULT '' NOT NULL, 
	channel_ref  varchar(256)  DEFAULT '' NOT NULL, 
	transaction_ref  varchar(256)  DEFAULT '' NOT NULL, 
	narative  varchar(256)  DEFAULT '' NOT NULL, 
	debit  varchar(256)  DEFAULT '' NOT NULL, 
	credit  varchar(256)  DEFAULT '' NOT NULL, 
	running_bal  varchar(256)  DEFAULT '' NOT NULL, 
	transaction_no  varchar(256)  DEFAULT '' NOT NULL, 
	admission_no  varchar(256)  DEFAULT '' NOT NULL, 
	student  varchar(256)  DEFAULT '' NOT NULL, 
	phone  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;