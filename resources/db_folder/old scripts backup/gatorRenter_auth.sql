CREATE DATABASE IF NOT EXISTS mini;

USE mini;

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `address_line_1` varchar(255) DEFAULT NULL,
  `address_line_2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text,
  `sq_feet` double DEFAULT NULL,
  `nr_bedrooms` int(11) DEFAULT NULL,
  `nr_bathrooms` int(11) DEFAULT NULL,
  `nr_roommates` int(11) DEFAULT NULL,
  `floor` int(11) DEFAULT NULL,
  `private_room` tinyint(1) NOT NULL DEFAULT '1',
  `private_bath` tinyint(1) NOT NULL DEFAULT '1',
  `kitchen_in_apartment` tinyint(1) NOT NULL DEFAULT '1',
  `has_security_deposit` tinyint(1) DEFAULT NULL,
  `credit_score_check` tinyint(1) DEFAULT NULL,
  `monthly_rent` double DEFAULT NULL,
  `security_deposit` double DEFAULT NULL,
  `pictures` varchar(255) DEFAULT NULL,
  `available_since` date DEFAULT NULL,
  `lease_end_date` date DEFAULT NULL,
  `flagged` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

