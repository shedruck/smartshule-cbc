CREATE TABLE expenses (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
expense_date  INT(11), 
title  varchar(256)  DEFAULT '' NOT NULL, 
category  varchar(32)  DEFAULT '' NOT NULL, 
amount  varchar(256)  DEFAULT '' NOT NULL, 
person_responsible  varchar(32)  DEFAULT '' NOT NULL, 
receipt  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;