CREATE TABLE disciplinary (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
date_reported  INT(11), 
culprit  varchar(32)  DEFAULT '' NOT NULL, 
reported_by  varchar(32)  DEFAULT '' NOT NULL, 
others  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
action_taken  varchar(256)  DEFAULT '' NOT NULL, 
comment  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
