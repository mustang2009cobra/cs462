delimiter $$

CREATE TABLE `deliveryrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ownerId` int(11) NOT NULL,
  `shopName` varchar(128) NOT NULL,
  `shopAddress` varchar(128) NOT NULL,
  `deliveryAddress` varchar(128) NOT NULL,
  `deliveryTime` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1$$

