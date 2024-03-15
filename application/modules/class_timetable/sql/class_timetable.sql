CREATE TABLE class_timetable (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
class_id   INT(11), 
calendar_id   INT(11), 
subject  varchar(32)  DEFAULT '' NOT NULL, 
end_date  INT(11), 
day_of_the_week  varchar(256)  DEFAULT '' NOT NULL, 
start_time  INT(11), 
end_time  INT(11), 
room  varchar(32)  DEFAULT '' NOT NULL, 
teacher  varchar(32)  DEFAULT '' NOT NULL, 
start_date  INT(11), 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;