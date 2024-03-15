CREATE TABLE transport (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
title  varchar(256)  DEFAULT '' NOT NULL, 
description  text  DEFAULT '' NOT NULL, 
created_by INT(11), 
modified_by INT(11), 
created_on INT(11) , 
modified_on INT(11) 
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

ALTER TABLE `transport_routes` DROP `route_name`, DROP `max_time_estimate`, DROP `variable_cost`, DROP `description`;
ALTER TABLE `transport_routes` ADD `one_way_charge` INT NOT NULL AFTER `name`, ADD `two_way_charge` INT NOT NULL AFTER `one_way_charge`;