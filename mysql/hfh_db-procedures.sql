#----------------------------
#----		Adding 		----
#----------------------------

###################
#### Add Boxer ####
###################

drop procedure IF Exists `add_boxer`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`add_boxer`(
	name varchar(255),
	kt int,
	phone int,
	email varchar (255),
	contact_name varchar(255),
	contact_phone int,
	contact_email varchar(255)
)
BEGIN
    insert into Boxer(name, kt, phone, email, contact_name, contact_phone, contact_email)
    values (name, kt, phone, email, contact_name, contact_phone, contact_email);
END $$
DELIMITER ;

##call add_boxer('GDG',2011892769, 6662999, 'gd@hfh.is','','','');
###################
#### Add Group ####
###################

drop procedure IF Exists `add_group`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`add_group`(
	type varchar(255)
)
BEGIN
    insert into Groups(type)
    values (type);
END $$
DELIMITER ;

#####################
#### Add Payment ####
#####################

drop procedure IF Exists `add_payment_type`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`add_payment_type`(
	type varchar(255)
)
BEGIN
    insert into Payment_type(type)
    values (type);
END $$
DELIMITER ;

##########################
#### Add Subscription ####
##########################

drop procedure IF Exists `add_subscription_type`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`add_subscription_type`(
	type varchar(255)
)
BEGIN
    insert into Subscription_type(type)
    values (type);
END $$
DELIMITER ;

drop procedure IF Exists `add_subscription`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`add_subscription`(
    boxer_ID int,
    group_ID int,
    payment_ID int,
    subscription_ID int,
    bought_date date,
    expires_date date
)
BEGIN
    insert into Subscriptions(boxer_ID, group_ID, payment_ID, subscription_ID, bought_date,expires_date)
    values (boxer_ID, group_ID, payment_ID, subscription_ID, bought_date,expires_date);
END $$
DELIMITER ;
#----------------------------
#----		lists 		----
#----------------------------

##########################
#### List all boxers  ####
##########################

drop procedure IF Exists `list_boxers`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_boxers`(
)
BEGIN
    select Boxer.ID, Boxer.Name, Boxer.kt, Boxer.phone, Boxer.email
	from Boxer
    order by Boxer.name asc;
END $$
DELIMITER ;

drop procedure IF Exists `list_full_boxer_info`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_full_boxer_info`(
)
BEGIN
    select Boxer.ID, Boxer.Name, Boxer.kt, Boxer.phone, Boxer.email, Boxer.contact_name, Boxer.contact_phone, Boxer.contact_email
	from Boxer
    order by Boxer.name asc;
END $$
DELIMITER ;

##########################
#### List all Groups  ####
##########################

drop procedure IF Exists `list_groups`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_groups`(
)
BEGIN
    select * from Groups
    order by Groups.type asc;
END $$
DELIMITER ;

############################
#### List all Payments  ####
############################

drop procedure IF Exists `list_payment_types`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_payment_types`(
)
BEGIN
    select * from Payment_type
    order by Payment_type.type asc;
END $$
DELIMITER ;

#####################################
#### List all Subscription type  ####
#####################################

drop procedure IF Exists `list_subscription_type`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_subscription_type`(
)
BEGIN
    select * from Subscription_type
    order by Subscription_type.type asc;
END $$
DELIMITER ;

#################################
#### List all Subscriptions  ####
#################################

drop procedure IF Exists `list_subscriptions`;

DELIMITER $$

use `hfh_db`$$
create procedure `hfh_db`.`list_subscriptions`(
)
BEGIN
select Subscriptions.ID, 
			Boxer.name, 
			Groups.type, 
			Payment_type.type, 
			Subscription_type.type, 
			Subscriptions.bought_date, 
			Subscriptions.expires_date
    from Subscriptions
		left join Boxer on Boxer.ID = Subscriptions.boxer_ID
		left join Groups on Groups.ID = Subscriptions.group_ID
		left join Payment_type on Payment_type.ID = Subscriptions.Payment_ID
		left join Subscription_type on Subscription_type.ID = Subscriptions.Subscription_ID
	order by Subscriptions.ID desc;
END $$
DELIMITER ;
#call list_subscriptions();

#---------------------
#----    delete   ----
#---------------------
######################
#### delete group ####
######################

drop procedure IF exists `delete_group`;

DELIMITER $$
use `hfh_db`$$
create procedure `hfh_db`.`delete_group`(
    id_delete int
)
BEGIN
    delete from Groups where id = id_delete;
END $$

########################
#### delete payment ####
########################

drop procedure IF exists `delete_payment_type`;

DELIMITER $$
use `hfh_db`$$
create procedure `hfh_db`.`delete_payment_type`(
    id_delete int
)
BEGIN
    delete from Payment_type where ID = id_delete;
END $$

#############################
#### delete Subscription ####
#############################

drop procedure IF exists `delete_subscription_type`;

DELIMITER $$
use `hfh_db`$$
create procedure `hfh_db`.`delete_subscription_type`(
    id_delete int
)
BEGIN
    delete from Subscription_type where ID = id_delete;
END $$


#---------------------
#----    search   ----
#---------------------

#########################
#### search by name  ####
#########################


select * from Boxer
    where name like '%g%';

#call add_subscription(1,1,1,1,'2016-04-03','2016-06-06');
#call add_subscription(2,1,3,3,'2016-03-03','2016-03-07');
#call update_subscription(1,1,'2015-10-11');
#call list_boxers();
#call list_payments();
#call add_boxer('Helga Valdís Björnsdóttir',0111913209,1,8670468,'helgavaldisb@gmail.com',1,2,'2015-08-8','n/a',0000000,'n/a');
