CREATE TABLE IF NOT EXISTS  appraisal_targets (
	id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	term  varchar(32)  DEFAULT '' NOT NULL, 
	year  varchar(256)  DEFAULT '' NOT NULL, 
	target  varchar(256)  DEFAULT '' NOT NULL, 
	description  text  , 
	created_by INT(11), 
	modified_by INT(11), 
	created_on INT(11) , 
	modified_on INT(11) 
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `appraisal_results` (
  `appraisal_id` int(11) NOT NULL,
  `target` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `teacher` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT NULL,
  `appraisee_rate` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_on` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `modified_on` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;