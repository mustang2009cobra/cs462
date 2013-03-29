delimiter $$

CREATE DATABASE `guild` /*!40100 DEFAULT CHARACTER SET latin1 */$$

delimiter $$

use `guild`$$

delimiter $$

CREATE TABLE `flower_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopUsername` varchar(128) NOT NULL,
  `shopName` varchar(128) NOT NULL,
  `shopPhoneNumber` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `shopESL` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverUsername` varchar(128) NOT NULL,
  `driverName` varchar(128) NOT NULL,
  `driverPhoneNumber` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `driverESL` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `bids_awarded` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driverPhoneNumber` varchar(128) NOT NULL,
  `shopAddress` varchar(128) NOT NULL,
  `shopPhoneNumber` varchar(128) NOT NULL,
  `deliveryAddress` varchar(128) NOT NULL,
  `pickupTime` varchar(128) NOT NULL,
  `deliveryTime` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `delivery_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `receiveTime` int(11) NOT NULL,
  `eventId` varchar(128) NOT NULL,
  `shopPhoneNumber` varchar(128) NOT NULL,
  `shopAddress` varchar(128),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `deliveries_picked_up` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$

delimiter $$

CREATE TABLE `deliveries_complete` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1$$
