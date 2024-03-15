CREATE TABLE hostel_beds (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
room_id  varchar(32)  DEFAULT '' NOT NULL, 
bed_number  varchar(256)  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;