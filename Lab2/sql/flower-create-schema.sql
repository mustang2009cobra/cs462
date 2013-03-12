delimiter $$

CREATE DATABASE `flower_shop` /*!40100 DEFAULT CHARACTER SET latin1 */$$

delimiter $$

use `flower_shop`$$

delimiter $$

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverId` int(11) NOT NULL,
  `driverName` varchar(128) NOT NULL,
  `driverAddress` varchar(128) NOT NULL,
  `driverESL` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `deliveryrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(11) NOT NULL,
  `shopName` varchar(128) NOT NULL,
  `shopAddress` varchar(128) NOT NULL,
  `deliveryAddress` varchar(128) NOT NULL,
  `pickupTime` varchar(128) NOT NULL,
  `deliveryTime` varchar(128) NOT NULL,
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

