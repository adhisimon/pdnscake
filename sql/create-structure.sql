-- phpMyAdmin SQL Dump
-- version 3.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 11, 2011 at 11:37 PM
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
-- Table structure for table `domains`
--

CREATE TABLE IF NOT EXISTS `domains` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `master` varchar(128) default NULL,
  `last_check` int(11) default NULL,
  `type` enum('NATIVE','MASTER','SLAVE') NOT NULL,
  `notified_serial` int(11) default NULL,
  `account` varchar(40) default NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name_index` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE IF NOT EXISTS `records` (
  `id` int(11) NOT NULL auto_increment,
  `domain_id` int(11) default NULL,
  `name` varchar(255) default NULL,
  `type` varchar(10) default NULL,
  `content` varchar(255) default NULL,
  `ttl` int(11) default '86400',
  `prio` int(11) default NULL,
  `change_date` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `rec_name_index` (`name`),
  KEY `nametype_index` (`name`,`type`),
  KEY `domain_id` (`domain_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=198 ;

-- --------------------------------------------------------

--
-- Table structure for table `record_type_orders`
--

CREATE TABLE IF NOT EXISTS `record_type_orders` (
  `name` varchar(10) NOT NULL,
  `order` float NOT NULL default '0',
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supermasters`
--

CREATE TABLE IF NOT EXISTS `supermasters` (
  `ip` varchar(25) NOT NULL,
  `nameserver` varchar(255) NOT NULL,
  `account` varchar(40) default NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `admin` tinyint(1) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
