delimiter $$

CREATE DATABASE `driver_site` /*!40100 DEFAULT CHARACTER SET latin1 */$$

delimiter $$

use `driver_site`$$

delimiter $$

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` varchar(128) NOT NULL,
  `lastName` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `password` varchar(128) NOT NULL,
  `foursquareToken` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `checkins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lat` varchar(128),
  `lng` varchar(128),
  `createTime` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `delivery_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiveTime` int(11) NOT NULL,
  `eventId` varchar(128) NOT NULL,
  `shopPhoneNumber` varchar(128) NOT NULL,
  `guildPhoneNumber` varchar(128) NOT NULL,
  `shopAddress` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `esls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopName` varchar(128),
  `shopAddress` varchar(128),
  `shopPhoneNumber` varchar(128) NOT NULL,
  `shopESL` varchar(256),
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testdriver", "man", "testdriver", 1, "test")$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testowner", "man", "testowner", 0, "test")$$