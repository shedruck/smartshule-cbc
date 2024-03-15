CREATE TABLE books (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
title  varchar(256)  DEFAULT '' NOT NULL, 
author  varchar(256)  DEFAULT '' NOT NULL, 
publisher  varchar(256)  DEFAULT '' NOT NULL, 
year_published  varchar(256)  DEFAULT '' NOT NULL, 
isbn_number  varchar(256)  DEFAULT '' NOT NULL, 
category  INT(11), 
edition  varchar(256)  DEFAULT '' NOT NULL, 
pages  varchar(256)  DEFAULT '' NOT NULL, 
copyright  varchar(256)  DEFAULT '' NOT NULL, 
shelf  varchar(256)  DEFAULT '' NOT NULL, 
memo  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;