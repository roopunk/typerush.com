-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 11, 2012 at 09:08 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `roopunkc_typerunner`
--

-- --------------------------------------------------------

--
-- Table structure for table `para`
--

CREATE TABLE IF NOT EXISTS `para` (
  `id` int(60) NOT NULL AUTO_INCREMENT,
  `words` int(60) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `para`
--

INSERT INTO `para` (`id`, `words`, `content`) VALUES
(1, 21, 'It is not the literal past, the facts of history, that shape us, but images of the past embodied in language.'),
(3, 59, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce quam risus, interdum sed commodo condimentum, interdum eu nulla. Maecenas eleifend tempus iaculis. Vestibulum laoreet mattis ligula vel semper. Aliquam ornare quam in mi dictum nec vulputate mi dignissim. Aliquam in mauris vel nisi placerat iaculis. Integer lectus metus, gravida eget suscipit eget, lobortis vitae quam. Praesent adipiscing consequat sodales.');

-- --------------------------------------------------------

--
-- Table structure for table `run`
--

CREATE TABLE IF NOT EXISTS `run` (
  `id` int(60) NOT NULL AUTO_INCREMENT,
  `userid` varchar(100) NOT NULL,
  `paraid` int(60) NOT NULL,
  `time` int(60) NOT NULL,
  `wpm` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `run`
--

INSERT INTO `run` (`id`, `userid`, `paraid`, `time`, `wpm`) VALUES
(15, 'roopunk', 1, 24, 52.5),
(16, 'yo', 1, 24, 52.5),
(17, 'anonymous', 1, 33, 38.1818),
(18, 'anonymous', 1, 0, 0),
(19, 'anonymous', 1, 0, 0),
(20, 'anonymous', 1, 1, 1260),
(21, 'anonymous', 1, 1, 1260),
(22, 'anonymous', 1, 34, 37.0588),
(23, 'anonymous', 3, 172, 20.5814),
(24, 'anonymous', 1, 31, 40.6452),
(25, 'anonymous', 1, 26, 48.4615),
(26, 'anonymous', 1, 24, 52.5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(60) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
