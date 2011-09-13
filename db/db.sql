-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2011 at 02:49 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `translation`
--
CREATE DATABASE `translation` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `translation`;

-- --------------------------------------------------------

--
-- Table structure for table `assign`
--

CREATE TABLE IF NOT EXISTS `assign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membersID` int(11) NOT NULL,
  `projectID` int(11) NOT NULL,
  `languageID` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `assign`
--

INSERT INTO `assign` (`id`, `membersID`, `projectID`, `languageID`, `name`) VALUES
(15, 2, 12, 0, ''),
(2, 2, 2, 2, 'nome2'),
(16, 2, 5, 0, ''),
(13, 1, 12, 0, ''),
(17, 2, 14, 0, ''),
(12, 1, 1, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE IF NOT EXISTS `language` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `language`) VALUES
(1, 'ITA'),
(2, 'ENG'),
(3, 'FRA');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `login` varchar(100) NOT NULL DEFAULT '',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `level` int(11) NOT NULL,
  `language` int(11) DEFAULT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_id`, `firstname`, `lastname`, `login`, `passwd`, `level`, `language`) VALUES
(1, 'Jatinder', 'Thind', 'phpsense', 'ba018360fc26e0cc2e929b8e071f052d', 0, NULL),
(2, 'gino', 'pilotino', 'gino', '09ad68ccea425181b0f3384a47eb0ee7', 2, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `languageID` int(11) NOT NULL,
  `parent.mess.ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `message`, `languageID`, `parent.mess.ID`) VALUES
(1, 'giuseppefdsfdsfdsfds', 1, NULL),
(2, 'bau bau en', 2, 1),
(3, 'bau bau fr', 3, 1),
(4, 'ffffffff', 1, NULL),
(5, 'ssssssssss', 1, NULL),
(6, '', 2, 1),
(7, '', 3, 1),
(8, '', 2, 0),
(9, '', 3, 0),
(10, '', 2, 0),
(11, '', 3, 0),
(12, '', 2, 0),
(13, '', 3, 0),
(14, 'addamory', 1, NULL),
(15, '', 2, 14),
(16, '', 3, 14),
(17, 'mess1 progbello', 1, NULL),
(18, 'dsadddddd\n1 Eng', 2, 17),
(19, 'dsddddd1\n1.2 fra', 3, 17),
(20, 'mess2 progbello', 1, NULL),
(21, '', 2, 20),
(22, '', 3, 20),
(23, 'mess3 progmbello', 1, NULL),
(24, '', 2, 23),
(25, '', 3, 23),
(26, 'mess4progbello', 1, NULL),
(27, '', 2, 26),
(28, '', 3, 26);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent.message.ID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `parent.message.ID`, `name`) VALUES
(5, 0, 'aaaaaaaaaaaaaaa'),
(14, 0, 'progettobello'),
(12, 0, 'canepazzo');

-- --------------------------------------------------------

--
-- Table structure for table `projectAssoc`
--

CREATE TABLE IF NOT EXISTS `projectAssoc` (
  `projID` int(11) NOT NULL,
  `parent.message.ID` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projectAssoc`
--

INSERT INTO `projectAssoc` (`projID`, `parent.message.ID`) VALUES
(1, 2),
(5, 1),
(12, 0),
(5, 0),
(5, 0),
(5, 14),
(14, 17),
(14, 20),
(14, 23),
(14, 26);
