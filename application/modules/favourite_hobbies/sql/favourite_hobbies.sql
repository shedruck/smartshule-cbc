CREATE TABLE IF NOT EXISTS  favourite_hobbies (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	student  varchar(256)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	languages_spoken  text  , 
	hobbies  text  , 
	favourite_subjects  text  , 
	favourite_books  text  , 
	favourite_food  text  , 
	favourite_bible_verse  text  , 
	favourite_cartoon  text  , 
	favourite_career  text  , 
	others  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;