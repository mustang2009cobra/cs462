delimiter $$

CREATE DATABASE `flower_shop` /*!40100 DEFAULT CHARACTER SET latin1 */$$

delimiter $$

use `flower_shop`$$

delimiter $$

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverId` int(11),
  `driverName` varchar(128),
  `driverPhoneNumber` varchar(128) NOT NULL,
  `shopESL` varchar(128),
  `driverESL` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `deliveryrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(11) NOT NULL,
  `shopName` varchar(128) NOT NULL,
  `shopAddress` varchar(128) NOT NULL,
  `shopPhoneNumber` varchar(128) NOT NULL,
  `deliveryAddress` varchar(128) NOT NULL,
  `pickupTime` varchar(128) NOT NULL,
  `deliveryTime` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `deliverybids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `deliveryRequestId` int(11) NOT NULL,
  `driverPhoneNumber` varchar(128) NOT NULL,
  `guildPhoneNumber` varchar(128) NOT NULL,
  `driverName` varchar(128) NOT NULL,
  `estimatedDeliveryTime` varchar(128) NOT NULL,
  `accepted` tinyint(1),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testowner", "man", "testowner", 1, "test")$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testguild", "man", "testguild", 0, "test")$$