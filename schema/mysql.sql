create table if not exists `BlockGroup`
(
	`id` int(10) not null auto_increment,
	`alias` varchar(100) default null,
	`title` varchar(100) default null,
	`imageWidth` int(10) not null,
	`imageHeight` int(10) not null,
	primary key (`id`),
	key `alias` (`alias`)
) engine InnoDB;
create table if not exists `Block`
(
	`id` int(10) not null auto_increment,
	`group_id` int(10) not null,
	`active` tinyint(1) default 1,
	`image` varchar(200) default null,
	`thumb` varchar(200) default null,
	`title` varchar(100) default null,
	`text` text,
	`url` varchar(200) default null,
	`linkLabel` varchar(100) default null,
	primary key (`id`),
	key `group_id` (`group_id`)
) engine InnoDB;
