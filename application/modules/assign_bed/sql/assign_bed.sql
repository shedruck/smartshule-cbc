CREATE TABLE assign_bed (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
date_assigned  INT(11), 
student INT(11),  
school_calendar_id INT(11),  
bed  INT(11),  
comment  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;