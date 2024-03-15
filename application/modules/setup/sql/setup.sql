CREATE TABLE setup (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
name  varchar(256)  DEFAULT '' NOT NULL, 
dayt  INT(11), 
public INT(1) NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;