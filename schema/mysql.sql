create table if not exists `block`
(
    `id` int(10) not null auto_increment,
    `tree` int(10),
    `lft` int(10) not null,
    `rgt` int(10) not null,
    `depth` int(10) not null,
    
    `active` tinyint(1) default 1,
    `alias` varchar(100) default null,
    `title` varchar(100) default null,

    `enableAlias` boolean default null,
    `enableImage` boolean default null,
    `enableLead` boolean default null,
    `enableText` boolean default null,
    `enableLink` boolean default null,
    `imageWidth` int(10) default null,
    `imageHeight` int(10) default null,

    `image` varchar(200) default null,
    `thumb` varchar(200) default null,
    `lead` varchar(200) default null,
    `text` text,
    `url` varchar(200) default null,
    `linkLabel` varchar(100) default null,
    primary key (`id`),
    key `alias` (`alias`)
) engine InnoDB;
