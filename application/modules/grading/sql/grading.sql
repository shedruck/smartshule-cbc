CREATE TABLE grading (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
grading_system  varchar(32)  DEFAULT '' NOT NULL, 
grade  varchar(256)  DEFAULT '' NOT NULL, 
maximum_marks  varchar(256)  DEFAULT '' NOT NULL, 
minimum_marks  varchar(256)  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;