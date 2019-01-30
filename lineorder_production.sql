-- MySQL dump 10.13  Distrib 5.5.58, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: lineorder_production
-- ------------------------------------------------------
-- Server version	5.5.58-0+deb8u1

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
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `deleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=90 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_altercost`
--

DROP TABLE IF EXISTS `order_altercost`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_altercost` (
  `orderid` int(11) DEFAULT NULL,
  `note` text,
  `amount` decimal(10,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_lineitems`
--

DROP TABLE IF EXISTS `order_lineitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_lineitems` (
  `orderid` int(11) DEFAULT NULL,
  `serviceid` smallint(6) DEFAULT NULL,
  `quantity` smallint(6) DEFAULT NULL,
  `cost` decimal(10,0) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_notes`
--

DROP TABLE IF EXISTS `order_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_notes` (
  `order_id` int(11) DEFAULT NULL,
  `note` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by` smallint(6) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `orderid` int(11) NOT NULL,
  `status` smallint(6) DEFAULT NULL,
  `ready_date` date DEFAULT NULL,
  `modified_by` smallint(6) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(255) DEFAULT NULL,
  `cust_contact_name` varchar(127) DEFAULT NULL,
  `cust_contact_phone` varchar(31) DEFAULT NULL,
  `cust_contact_email` varchar(127) DEFAULT NULL,
  `cust_contact_fax` varchar(31) DEFAULT NULL,
  `billing_address1` varchar(127) DEFAULT NULL,
  `billing_address2` varchar(127) DEFAULT NULL,
  `billing_city` varchar(127) DEFAULT NULL,
  `billing_state` varchar(31) DEFAULT NULL,
  `billing_zip` char(14) DEFAULT NULL,
  `onsite_contact_name` varchar(127) DEFAULT NULL,
  `onsite_contact_phone` varchar(31) DEFAULT NULL,
  `onsite_altcontact_name` varchar(127) DEFAULT NULL,
  `onsite_altcontact_phone` varchar(31) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `event_id` smallint(6) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `trans_id` char(64) DEFAULT NULL,
  `auth_code` char(8) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `location` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8658 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `orders_archive`
--

DROP TABLE IF EXISTS `orders_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders_archive` (
  `id` int(11) NOT NULL,
  `cust_name` varchar(255) DEFAULT NULL,
  `cust_contact_name` varchar(127) DEFAULT NULL,
  `cust_contact_phone` varchar(31) DEFAULT NULL,
  `cust_contact_email` varchar(127) DEFAULT NULL,
  `cust_contact_fax` varchar(31) DEFAULT NULL,
  `billing_address1` varchar(127) DEFAULT NULL,
  `billing_address2` varchar(127) DEFAULT NULL,
  `billing_city` varchar(127) DEFAULT NULL,
  `billing_state` varchar(31) DEFAULT NULL,
  `billing_zip` char(14) DEFAULT NULL,
  `onsite_contact_name` varchar(127) DEFAULT NULL,
  `onsite_contact_phone` varchar(31) DEFAULT NULL,
  `onsite_altcontact_name` varchar(127) DEFAULT NULL,
  `onsite_altcontact_phone` varchar(31) DEFAULT NULL,
  `createtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `event_id` smallint(6) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `trans_id` char(64) DEFAULT NULL,
  `auth_code` char(8) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `location` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `service_categories`
--

DROP TABLE IF EXISTS `service_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_categories` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  `recipients` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) DEFAULT NULL,
  `cost` decimal(10,0) DEFAULT NULL,
  `category` smallint(6) DEFAULT NULL,
  `addon` smallint(6) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `statustypes`
--

DROP TABLE IF EXISTS `statustypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `statustypes` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(31) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(80) DEFAULT NULL,
  `password` char(41) DEFAULT NULL,
  `userlevel` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visitor_info`
--

DROP TABLE IF EXISTS `visitor_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitor_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `emailaddr` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `cust_name` varchar(255) DEFAULT NULL,
  `cust_contact_name` varchar(127) DEFAULT NULL,
  `cust_contact_phone` varchar(31) DEFAULT NULL,
  `cust_contact_email` varchar(127) DEFAULT NULL,
  `cust_contact_fax` varchar(31) DEFAULT NULL,
  `billing_address1` varchar(127) DEFAULT NULL,
  `billing_address2` varchar(127) DEFAULT NULL,
  `billing_city` varchar(127) DEFAULT NULL,
  `billing_state` varchar(31) DEFAULT NULL,
  `billing_zip` varchar(14) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-26 19:44:21
