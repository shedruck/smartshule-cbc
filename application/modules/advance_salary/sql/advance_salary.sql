CREATE TABLE advance_salary (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
employee  varchar(256)  DEFAULT '' NOT NULL, 
advance_date  INT(11), 
amount  varchar(256)  DEFAULT '' NOT NULL, 
comment  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;