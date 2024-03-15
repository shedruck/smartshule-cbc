CREATE TABLE items (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
item_name  varchar(256)  DEFAULT '' NOT NULL, 
category  varchar(32)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
reorder_level INT(11), 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;