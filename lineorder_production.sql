-- MySQL dump 10.16  Distrib 10.1.37-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: lineorder_production
-- ------------------------------------------------------
-- Server version	10.1.37-MariaDB-0+deb9u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
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
) ENGINE=MyISAM AUTO_INCREMENT=92 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `order_altercost`
--

LOCK TABLES `order_altercost` WRITE;
/*!40000 ALTER TABLE `order_altercost` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_altercost` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `order_lineitems`
--

LOCK TABLES `order_lineitems` WRITE;
/*!40000 ALTER TABLE `order_lineitems` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_lineitems` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `order_notes`
--

LOCK TABLES `order_notes` WRITE;
/*!40000 ALTER TABLE `order_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_notes` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `orders_archive`
--

LOCK TABLES `orders_archive` WRITE;
/*!40000 ALTER TABLE `orders_archive` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders_archive` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_categories`
--

LOCK TABLES `service_categories` WRITE;
/*!40000 ALTER TABLE `service_categories` DISABLE KEYS */;
INSERT INTO `service_categories` VALUES (11,'Super DANK',1,NULL);
/*!40000 ALTER TABLE `service_categories` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (23,'Extra Dank',100,11,0,1);
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `statustypes`
--

LOCK TABLES `statustypes` WRITE;
/*!40000 ALTER TABLE `statustypes` DISABLE KEYS */;
/*!40000 ALTER TABLE `statustypes` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'initialize','*81BB39075BDAA57165C6A659AE72518F70F390CD',3);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `visitor_info`
--

LOCK TABLES `visitor_info` WRITE;
/*!40000 ALTER TABLE `visitor_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `visitor_info` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-29 22:56:43
