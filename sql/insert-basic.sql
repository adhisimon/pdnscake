-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2011 at 11:39 PM
-- Server version: 5.0.77
-- PHP Version: 5.2.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pdns`
--

-- --------------------------------------------------------

--
-- Table structure for table `record_type_orders`
--

CREATE TABLE IF NOT EXISTS `record_type_orders` (
  `name` varchar(10) NOT NULL,
  `order` float NOT NULL default '0',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `record_type_orders`
--

INSERT INTO `record_type_orders` (`name`, `order`) VALUES
('SOA', 100),
('TXT', 95),
('NS', 90),
('A', 80),
('MX', 70);
