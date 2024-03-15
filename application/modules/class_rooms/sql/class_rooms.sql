CREATE TABLE class_rooms (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
name  varchar(256)  DEFAULT '' NOT NULL, 
capacity  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;