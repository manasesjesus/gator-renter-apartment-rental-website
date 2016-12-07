-- MySQL dump 10.13  Distrib 5.5.46, for Linux (x86_64)
--
-- Host: localhost    Database: heroku_34339c2e1bdc646
-- ------------------------------------------------------
-- Server version	5.5.46-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `apartments`
--

DROP TABLE IF EXISTS `apartments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
  `available_since` date DEFAULT NULL,
  `lease_end_date` date DEFAULT NULL,
  `flagged` tinyint(1) NOT NULL DEFAULT '0',
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `owner_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `apartments`
--

LOCK TABLES `apartments` WRITE;
/*!40000 ALTER TABLE `apartments` DISABLE KEYS */;
INSERT INTO `apartments` VALUES (1,1,'2016-10-20','2016-10-20','820 Serano Dr.','Apt 1E','San Francisco','CA','USA','94132','Pacific Heights','Classic apartment (over 1600 square feet of living space) located in a high end building just 3 blocks to Fillmore Street retail and express transit to the Financial District.',110.5,2,2,4,1,0,1,1,1,0,890,890,'2016-10-20','2016-10-20',0,37.718706,-122.483174,1),(2,1,'2016-10-20','2016-10-20','820 Serano Dr.','Apt 1E','San Francisco','CA','USA','94132','240 Carl St','Recently fully remodeled, furnished and decorated, this beautiful and cozy apartment has one bedroom, with a king size bed, nice and spacious living area with lots of natural lights, and one bathroom. The kitchen is very bright and will allow you to enjoy the sunshine for breakfast, lunch and dinner. It can accommodate up to 4 guests. The sofa bed in the living room is full size, and comfortable.',110.5,2,2,1,1,1,1,1,1,0,1790,1790,'2016-10-20','2016-10-20',0,37.717149,-122.475771,NULL),(3,1,'2016-10-20','2016-10-20','820 Serano Dr.','Apt 1E','San Francisco','CA','USA','94132','610 Moraga St','3 bed 2 baths near UCSF Medical Center, GGP & Irving St. VIDEO TOUR!! - Showing on Wednesday, 10/12 @ 12:00pm - 12:45pm!! 330 Hazelwood Ave, San Francisco, CA 94127. Must view the unit in person before submitting an application.',110.5,2,2,2,1,1,1,0,1,0,900,900,'2016-10-20','2016-10-20',0,37.723795,-122.474269,NULL),(4,1,'2016-10-20','2016-10-20','820 Serano Dr.','Apt 1E','San Francisco','CA','USA','94132','Lake Street','Welcome to your new home! This updated apartment is located in the Inner Richmond. A Walker\'s Paradise with so many cafes, restaurants and shops all within a block or two. Excellent Transit Score with a number of Muncie lines right out your front door. Conveniently located to the Shuttle Stops along Park Presidio Blvd. Only a block off the biking and jogging trails in Mountain Lake Park and the Presidio Preserve.',110.5,2,2,3,1,0,0,1,1,0,2200,2200,'2016-10-20','2016-10-20',0,37.720218,-122.497848,NULL),(5,1,'2016-10-20','2016-10-20','820 Serano Dr.','Apt 1E','San Francisco','CA','USA','94132','One Sansome Street','Welcome to your new home! This updated apartment is located in the Inner Richmond. A Walker\'s Paradise with so many cafes, restaurants and shops all within a block or two. Excellent Transit Score with a number of Muncie lines right out your front door. Conveniently located to the Shuttle Stops along Park Presidio Blvd. Only a block off the biking and jogging trails in Mountain Lake Park and the Presidio Preserve.',110.5,2,2,1,1,1,0,1,1,0,1350,2200,'2016-10-20','2016-10-20',0,37.731296,-122.497848,NULL),(6,1,'2016-10-20','2016-10-20','350 Octavia St.','Apt 4A','San Francisco','CA','USA','94123','174 Arch St','3 beds 1 bath and large living room, gourmet kitchen, garage and large yard',210.5,1,1,2,4,1,1,1,1,0,1150,1150,'2016-10-20','2016-10-20',0,37.736243,-122.501549,NULL),(8,1,'2016-10-20','2016-10-20','255 King St','Apt 4A','San Francisco','CA','USA','94123','255 King St','Avalon at Mission Bay located in San Francisco near the San Francisco Caltrain Station offers thoughtfully designed studio, 1, 2 and 3 bedroom apartments and town homes.',410.5,1,1,2,4,0,1,0,1,0,1750,1750,'2016-10-20','2016-10-20',0,37.787111,-122.444105,NULL),(9,1,'2016-10-20','2016-10-20','1890 Broadway Street','Apt 4A','San Francisco','CA','USA','94123','1890 Broadway Street','To be placed on a waiting list for future vacancies, please email with full contact information including name, phone number, email and whether inquiring for a 1 or 2 bedroom apt. 1 BRs range from $4k-5K. 2 BRs range from $4,700-7k.',410.5,1,1,2,4,1,1,1,1,0,1995,1995,'2016-10-20','2016-10-20',0,37.754125,-122.47687,NULL),(11,1,'2016-11-26','2016-11-26','22 West Portal',NULL,'San Francisco','CA','USA','94233','West Portal Apartment','This is a description',750,1,2,1,1,1,1,1,1,0,1200,1500,'2016-11-26','2017-11-27',0,37.7406088,-122.4661935,1);
/*!40000 ALTER TABLE `apartments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictures` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `apartment_id` int(11) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=223 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pictures`
--

LOCK TABLES `pictures` WRITE;
/*!40000 ALTER TABLE `pictures` DISABLE KEYS */;
INSERT INTO `pictures` VALUES (2,9,'ph1139_h800.jpg'),(12,2,'studio-2.jpg'),(22,11,'p.jpeg'),(32,4,'architecture-beautiful-loft2.jpg'),(42,5,'lumina_double.jpg'),(52,6,'12027616_931251766947575_3525523016876702425_n.jpg'),(62,8,'splash-picture.jpg'),(72,202,'AshtonSanFrancisco_PlanH_2010_LIV2_EL.jpg');
/*!40000 ALTER TABLE `pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'alex@gmail.com','1234567890','4092 Furth Circle','Singapore','2014-08-31 18:21:20'),(2,'ipsita@gmail.com','1111111111','2, rue du Commerce','NYC','2014-08-31 18:30:58'),(3,'trisha@gmail.com','2222222222','C/ Moralzarzal, 86','Burlingame','2014-08-31 18:22:03'),(12,'cli12@mail.sfsu.edu','1234567890','4092 Furth Circle','Singapore','2014-08-31 18:21:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-12-06  8:06:55
