CREATE TABLE add_stock (
id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
day  INT(11), 
product_id  varchar(32)  DEFAULT '' NOT NULL, 
quantity  varchar(256)  DEFAULT '' NOT NULL, 
unit_price  varchar(256)  DEFAULT '' NOT NULL, 
total  varchar(256)  DEFAULT '' NOT NULL, 
receipt  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;