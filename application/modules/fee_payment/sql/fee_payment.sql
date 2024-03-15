CREATE TABLE fee_payment (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
payment_date  INT(11), 
reg_no  varchar(256)  DEFAULT '' NOT NULL, 
amount  varchar(256)  DEFAULT '' NOT NULL, 
bank_slip  varchar(256)  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;