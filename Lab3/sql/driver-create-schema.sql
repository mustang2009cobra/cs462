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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `delivery_bids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverId` int(11) NOT NULL,
  `bidAccepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `ESLs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopName` varchar(128) NOT NULL,
  `shopAddress` varchar(128) NOT NULL,
  `shopESL` varchar(256) NOT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testdriver", "man", "testdriver", 1, "test")$$

delimiter $$

INSERT INTO `users` (firstName, lastName, email, admin, password) VALUES ("testowner", "man", "testowner", 0, "test")$$
