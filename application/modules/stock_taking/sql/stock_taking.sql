CREATE TABLE stock_taking (
id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
stock_date  INT(11), 
product_id  varchar(32)  DEFAULT '' NOT NULL, 
closing_stock  varchar(256)  DEFAULT '' NOT NULL, 
selling_price  varchar(256)  DEFAULT '' NOT NULL, 
comment  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;