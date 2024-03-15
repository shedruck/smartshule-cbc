CREATE TABLE IF NOT EXISTS  evideos (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	title  varchar(256)  DEFAULT '' NOT NULL, 
	level  varchar(256)  DEFAULT '' NOT NULL, 
	type  varchar(32)  DEFAULT '' NOT NULL, 
	subject  varchar(256)  DEFAULT '' NOT NULL, 
	topic  varchar(256)  DEFAULT '' NOT NULL, 
	preview_link  text  , 
	video_embed_code  text  , 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;