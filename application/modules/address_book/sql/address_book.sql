CREATE TABLE address_book (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
address_book  varchar(32)  DEFAULT '' NOT NULL, 
title  varchar(256)  DEFAULT '' NOT NULL, 
category  varchar(32)  DEFAULT '' NOT NULL, 
company_name  varchar(256)  DEFAULT '' NOT NULL, 
website  varchar(256)  DEFAULT '' NOT NULL, 
address  varchar(256)  DEFAULT '' NOT NULL, 
email  varchar(256)  DEFAULT '' NOT NULL, 
phone  varchar(256)  DEFAULT '' NOT NULL, 
landline  varchar(256)  DEFAULT '' NOT NULL, 
city  varchar(256)  DEFAULT '' NOT NULL, 
country  varchar(32)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;