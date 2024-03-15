CREATE TABLE class_attendance (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
class_id  varchar(32)  DEFAULT '' NOT NULL, 
attendance_date  INT(11), 
title  varchar(32)  DEFAULT '' NOT NULL, 
student  varchar(32)  DEFAULT '' NOT NULL, 
status  varchar(32)  DEFAULT '' NOT NULL, 
temperature INT(11),
remarks  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;