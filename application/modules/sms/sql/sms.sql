CREATE TABLE sms (
id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
user_id  varchar(32)  DEFAULT '' NOT NULL, 
cc  varchar(32)  DEFAULT '' NOT NULL, 
subject  varchar(256)  DEFAULT '' NOT NULL, 
description  text , 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;