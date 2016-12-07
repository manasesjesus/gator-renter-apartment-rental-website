USE mini;

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL UNIQUE,
  `password` varchar(200) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=187 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `email`, `password`, `address`, `city`, `created`) VALUES
(168, 'cli12@mail.sfsu.edu', '1234567890', '4092 Furth Circle','Singapore', '2014-08-31 18:21:20'),
(169, 'swadesh@gmail.com', '1234567890', '4092 Furth Circle', 'Singapore', '2014-08-31 18:21:20'),
(170, 'ipsita@gmail.com', '1111111111', '2, rue du Commerce', 'NYC', '2014-08-31 18:30:58'),
(171, 'trisha@gmail.com', '2222222222', 'C/ Moralzarzal, 86', 'Burlingame', '2014-08-31 18:22:03');
