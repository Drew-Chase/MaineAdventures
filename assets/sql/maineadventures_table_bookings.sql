
-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE IF NOT EXISTS `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(40) NOT NULL,
  `lname` varchar(40) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `adults` int(11) NOT NULL,
  `children` int(11) NOT NULL,
  `pets` int(11) NOT NULL,
  `cabin` varchar(64) NOT NULL,
  `arrival` datetime NOT NULL,
  `departure` datetime NOT NULL,
  `seasonal` tinyint(1) NOT NULL,
  `payed` tinyint(1) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
