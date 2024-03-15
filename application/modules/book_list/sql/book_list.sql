CREATE TABLE IF NOT EXISTS  book_list (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	thumbnail  varchar(256)  DEFAULT '' NOT NULL, 
	class  varchar(32)  DEFAULT '' NOT NULL, 
	subject  varchar(32)  DEFAULT '' NOT NULL, 
	book_name  varchar(256)  DEFAULT '' NOT NULL, 
	publisher  varchar(256)  DEFAULT '' NOT NULL, 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;