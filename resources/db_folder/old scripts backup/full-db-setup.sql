-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Nov 21, 2016 at 11:19 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/* 40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/* 40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/* 40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/* 40101 SET NAMES utf8mb4 */;

--
-- Database: `f16g08`
--


DROP procedure IF EXISTS `getUserDetail`;
DROP procedure IF EXISTS `updateUserDetail`;

DELIMITER $$
--
-- Procedures
--

CREATE DEFINER=`root`@`localhost` PROCEDURE `getUserDetail` (IN `uid` VARCHAR(25))  BEGIN
IF uid IS NULL THEN 
      Select * from users;
   ELSE
      Select * from users where uid = null;
   END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `updateUserDetail` (IN `email` VARCHAR(50), IN `first_name` VARCHAR(255), IN `last_name` VARCHAR(255), IN `address` VARCHAR(50), IN `city` VARCHAR(50))  BEGIN
	
    UPDATE 
		users u
	SET
		u.first_name = first_name,
        u.last_name = last_name,
        u.address = address,
        u.city = city
	WHERE
		u.email = email;
        
	SELECT
		*
	FROM
		users u
	WHERE
		u.email = email;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--
DROP TABLE IF EXISTS `apartments`;

CREATE TABLE `apartments` (
  `id` int(11) NOT NULL,
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
  `flagged` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`id`, `active`, `created_at`, `updated_at`, `address_line_1`, `address_line_2`, `city`, `state`, `country`, `zip`, `title`, `description`, `sq_feet`, `nr_bedrooms`, `nr_bathrooms`, `nr_roommates`, `floor`, `private_room`, `private_bath`, `kitchen_in_apartment`, `has_security_deposit`, `credit_score_check`, `monthly_rent`, `security_deposit`, `pictures`, `available_since`, `lease_end_date`, `flagged`) VALUES
(1, 1, '2016-10-20', '2016-10-20', '820 Serano Dr.', 'Apt 1E', 'San Francisco', 'CA', 'USA', '94132', 'Pacific Heights', 'Classic apartment (over 1600 square feet of living space) located in a high end building just 3 blocks to Fillmore Street retail and express transit to the Financial District.', 110.5, 2, 2, 4, 1, 0, 1, 1, 1, 0, 890, 890, 'http://crossfiremedia.realpage.com/ashtonsanfranciscogs/photos/ph1139_h800.jpg', '2016-10-20', '2016-10-20', 0),
(2, 1, '2016-10-20', '2016-10-20', '820 Serano Dr.', 'Apt 1E', 'San Francisco', 'CA', 'USA', '94132', '240 Carl St', 'Recently fully remodeled, furnished and decorated, this beautiful and cozy apartment has one bedroom, with a king size bed, nice and spacious living area with lots of natural lights, and one bathroom. The kitchen is very bright and will allow you to enjoy the sunshine for breakfast, lunch and dinner. It can accommodate up to 4 guests. The sofa bed in the living room is full size, and comfortable.', 110.5, 2, 2, 1, 1, 1, 1, 1, 1, 0, 1790, 1790, 'http://www.rentnema.com/img/residences/1024x500/studio-2.jpg', '2016-10-20', '2016-10-20', 0),
(3, 1, '2016-10-20', '2016-10-20', '820 Serano Dr.', 'Apt 1E', 'San Francisco', 'CA', 'USA', '94132', '610 Moraga St', '3 bed 2 baths near UCSF Medical Center, GGP & Irving St. VIDEO TOUR!! - Showing on Wednesday, 10/12 @ 12:00pm - 12:45pm!! 330 Hazelwood Ave, San Francisco, CA 94127. Must view the unit in person before submitting an application.', 110.5, 2, 2, 2, 1, 1, 1, 0, 1, 0, 900, 900, 'http://www.butlerarmsden.com/slideshowpro/p.php?a=RlQ/QGN+JkNsZX9tPjwvYXJtOj8lOjg6Nyo4MTAmKyU+KjQ/OycmNCY+Mj80LTsuPzoyOQ==&m=1299039889', '2016-10-20', '2016-10-20', 0),
(4, 1, '2016-10-20', '2016-10-20', '820 Serano Dr.', 'Apt 1E', 'San Francisco', 'CA', 'USA', '94132', 'Lake Street', 'Welcome to your new home! This updated apartment is located in the Inner Richmond. A Walker\'s Paradise with so many cafes, restaurants and shops all within a block or two. Excellent Transit Score with a number of Muncie lines right out your front door. Conveniently located to the Shuttle Stops along Park Presidio Blvd. Only a block off the biking and jogging trails in Mountain Lake Park and the Presidio Preserve.', 110.5, 2, 2, 3, 1, 0, 0, 1, 1, 0, 2200, 2200, 'http://cdn.freshome.com/wp-content/uploads/2014/10/architecture-beautiful-loft2.jpg', '2016-10-20', '2016-10-20', 0),
(5, 1, '2016-10-20', '2016-10-20', '820 Serano Dr.', 'Apt 1E', 'San Francisco', 'CA', 'USA', '94132', 'One Sansome Street', 'Welcome to your new home! This updated apartment is located in the Inner Richmond. A Walker\'s Paradise with so many cafes, restaurants and shops all within a block or two. Excellent Transit Score with a number of Muncie lines right out your front door. Conveniently located to the Shuttle Stops along Park Presidio Blvd. Only a block off the biking and jogging trails in Mountain Lake Park and the Presidio Preserve.', 110.5, 2, 2, 1, 1, 1, 0, 1, 1, 0, 1350, 2200, 'http://static3.businessinsider.com/image/54f0bb766bb3f7ee44cb781a-1200-800/lumina_double.jpg', '2016-10-20', '2016-10-20', 0),
(6, 1, '2016-10-20', '2016-10-20', '350 Octavia St.', 'Apt 4A', 'San Francisco', 'CA', 'USA', '94123', '174 Arch St', '3 beds 1 bath and large living room, gourmet kitchen, garage and large yard', 210.5, 1, 1, 2, 4, 1, 1, 1, 1, 0, 1150, 1150, 'http://cdn.freshome.com/wp-content/uploads/2015/10/12027616_931251766947575_3525523016876702425_n.jpg', '2016-10-20', '2016-10-20', 0),
(8, 1, '2016-10-20', '2016-10-20', '255 King St', 'Apt 4A', 'San Francisco', 'CA', 'USA', '94123', '255 King St', 'Avalon at Mission Bay located in San Francisco near the San Francisco Caltrain Station offers thoughtfully designed studio, 1, 2 and 3 bedroom apartments and town homes.', 410.5, 1, 1, 2, 4, 0, 1, 0, 1, 0, 1750, 1750, 'http://solairesf.com/wp-content/themes/solaire/inc/splash-picture.jpg', '2016-10-20', '2016-10-20', 0),
(9, 1, '2016-10-20', '2016-10-20', '1890 Broadway Street', 'Apt 4A', 'San Francisco', 'CA', 'USA', '94123', '1890 Broadway Street', 'To be placed on a waiting list for future vacancies, please email with full contact information including name, phone number, email and whether inquiring for a 1 or 2 bedroom apt. 1 BRs range from $4k-5K. 2 BRs range from $4,700-7k.', 410.5, 1, 1, 2, 4, 1, 1, 1, 1, 0, 1995, 1995, 'https://www.udr.com/uploadedImages/UDR3/Communities/Ashton_San_Francisco/images/AshtonSanFrancisco_PlanH_2010_LIV2_EL.jpg', '2016-10-20', '2016-10-20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_roles_id` int(11) DEFAULT NULL,
  `is_active` int(2) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `first_name`, `last_name`, `email`, `password`, `address`, `city`, `created`, `user_roles_id`, `is_active`) VALUES
(168, 'Chango', 'Linn', 'cli12@mail.sfsu.edu', '1234567890', '4092 Furth Circle', 'Singapore', '2014-08-31 23:21:20', 3, 1),
(169, 'Steven', 'Wadesh', 'swadesh@gmail.com', '1234567890', '4092 Furth Circle', 'Singapore', '2014-08-31 23:21:20', 3, 1),
(170, 'Ipanena', 'Sita', 'ipsita@gmail.com', '1111111111', '2, rue du Commerce', 'NYC', '2014-08-31 23:30:58', 3, 1),
(171, 'Trisha', 'Jackson', 'trisha@gmail.com', '2222222222', 'C/ Moralzarzal, 86', 'Burlingame', '2014-08-31 23:22:03', 2, 1),
(777, 'Manny', 'Einsteiger', 'admin@gb.de', 'admin16', 'Hochschule-Strasse 123', 'Fulda', '2016-11-21 13:14:21', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `role_name` varchar(100) NOT NULL,
  `role_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `role_name`, `role_description`) VALUES
(1, 'Administrator', 'Admin'),
(2, 'Landlord', 'owner of house'),
(3, 'Renter', 'Tenant, want to live');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_user_roles_idx` (`user_roles_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_UNIQUE` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=778;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_user_roles` FOREIGN KEY (`user_roles_id`) REFERENCES `user_roles` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

/* 40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/* 40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/* 40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
