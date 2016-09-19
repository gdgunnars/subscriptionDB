#####################
## Create database ##
#####################

-- Database: `hfh_db`
#drop database if exists `hfh_db`;

create database `hfh_db` default CHARACTER SET utf8;

use hfh_db;
##################
## Create table ##
##################
#drop table if Exists Boxer;
#drop table if Exists Groups;
#drop table if Exists Payment_type;
#drop table if Exists Subscription_type;
#drop table if Exists Subscriptions;

create table `Boxer`(
	`ID` int not null auto_increment,
	`name` varchar(255),
	`kt` char(10),
	`phone` varchar(11),
	`email` varchar(255),
	`image` varchar(255),
	`active` bool,
	`rfid` char(10),
PRIMARY KEY (`ID`),
UNIQUE (`kt`, `rfid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table containing Boxers, and their information';

create table `Groups`(
	`ID` int not null auto_increment,
	`type` varchar(255),
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that keeps list of groups available';

create table `Payment_type`(
	`ID` int not null auto_increment,
	`type` varchar(255),
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that keeps list of payment methods';

create table `Subscription_type`(
	`ID` int not null auto_increment,
	`type` varchar(255),
PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that keeps list of subscriptions';

create table `Subscriptions`(
	`ID` int not null auto_increment,
    `boxer_ID` int not null,
    `group_ID` int not null,
    `payment_ID` int not null,
    `subscription_ID` int not null,
    `bought_date` date,
    `expires_date` date,
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that containts every purchase of a subscription';

create table `Comments`(
	`ID` int not null auto_increment,
    `boxer_ID` int not null,
    `comment` TEXT not null,
    `date` date,
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that containts a comment for an individual';

create table `Contacts`(
	`ID` int not null auto_increment,
    `boxer_ID` int not null,
    `name` varchar(255),
  	`phone` int,
    `email` varchar(255),
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that containts a comment for an individual';

create table `CheckInLog`(
	`ID` int not null auto_increment,
    `boxer_ID` int not null,
    `date_logged` DATE,
		`time_logged` TIME,
PRIMARY KEY (`ID`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table that keeps track of checkin for each day';

#show tables;

#################
## Alter Table ##
#################

## connect a Boxer to a subscription
alter table `Subscriptions`
add constraint constraint_fk_boxer foreign key (boxer_ID) references `Boxer`(`ID`);

## connect a group to subscription
alter table `Subscriptions`
add constraint constraint_fk_group foreign key (group_ID) references `Groups`(`ID`);

## connect a payment type to a Subscription
alter table `Subscriptions`
add constraint constraint_fk_payment foreign key (payment_ID) references `Payment_type`(`ID`);

## connect a subscription type to a Subscription
alter table `Subscriptions`
add constraint constraint_fk_subscription_type foreign key (subscription_ID) references `Subscription_type`(`ID`);

## connect a comment type to a Boxer
alter table `Comments`
add constraint constraint_fk_boxer_from_comments foreign key (boxer_ID) references `Boxer`(`ID`);

## connect a ContactInfo type to a Boxer
alter table `Contacts`
add constraint constraint_fk_contact_to_boxer foreign key (boxer_ID) references `Boxer`(`ID`);

## connect a checkin to a Boxer
alter table `CheckInLog`
	add constraint constraint_fk_checkIn_to_boxer foreign key (boxer_ID) references `Boxer`(`ID`);