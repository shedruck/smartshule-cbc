CREATE TABLE IF NOT EXISTS  transition_profile (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	allergy  text  , 
	general_health  text  , 
	general_academic  text  , 
	feeding_habit  text  , 
	behaviour  text  , 
	co_curriculum   text  , 
	parental_involvement  text  , 
	transport  varchar(32)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;