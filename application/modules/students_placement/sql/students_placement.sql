CREATE TABLE students_placement (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
student  varchar(32)  DEFAULT '' NOT NULL, 
start_date  INT(11), 
position  varchar(32)  DEFAULT '' NOT NULL, 
class  varchar(32)  DEFAULT '' NOT NULL, 
duration  INT(11), 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
