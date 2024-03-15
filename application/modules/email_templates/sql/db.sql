create table if not exists email_templates(
id int not null auto_increment primary key,
					`title` varchar(250),
										`slug` varchar(250),
										`description` text,
										`content` text,
					
`status` enum('draft','live') collate utf8_unicode_ci NOT NULL default 'draft',
created_by int,
created_on int,
modified_on int,
modified_by int
)