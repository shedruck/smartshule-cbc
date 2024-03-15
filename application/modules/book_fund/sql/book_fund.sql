CREATE TABLE book_fund (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
title  varchar(256)  DEFAULT '' NOT NULL, 
category  varchar(32)  DEFAULT '' NOT NULL, 
pages  varchar(256)  DEFAULT '' NOT NULL, 
author  varchar(256)  DEFAULT '' NOT NULL, 
edition  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;