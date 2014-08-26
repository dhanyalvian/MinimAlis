-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: minimalis
-- ------------------------------------------------------
-- Server version	5.5.38-0ubuntu0.14.04.1

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
-- Table structure for table `config_data`
--

DROP TABLE IF EXISTS `config_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `config_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `config_data`
--

LOCK TABLES `config_data` WRITE;
/*!40000 ALTER TABLE `config_data` DISABLE KEYS */;
INSERT INTO `config_data` VALUES (1,'app_title','MinimAlis');
/*!40000 ALTER TABLE `config_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigation`
--

DROP TABLE IF EXISTS `navigation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `navigation` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `controller` varchar(30) DEFAULT NULL,
  `title` varchar(30) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `parent` int(3) NOT NULL DEFAULT '0',
  `display` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0->hidden;1->visible',
  `icon` varchar(25) DEFAULT NULL,
  `status` int(1) DEFAULT '1' COMMENT '1->enable; 0->disable',
  `sort` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `navigation`
--

LOCK TABLES `navigation` WRITE;
/*!40000 ALTER TABLE `navigation` DISABLE KEYS */;
INSERT INTO `navigation` VALUES (1,'dashboard','Dashboard','dashboard',0,1,NULL,1,1),(2,'forms','Forms','#',0,1,NULL,1,2),(3,'basic_forms','Basic Forms','forms/basic_forms',2,1,'fa-file-o',1,1),(4,'extended_forms','Extended Forms','forms/extended_forms',2,1,'fa-file-text-o',1,2),(5,'validation','Validation','forms/validation',2,1,'fa-file-text',1,3),(6,'wizard','Wizard','forms/wizard',2,1,'fa-magic',1,4),(7,'components','Components','#',0,1,NULL,1,3),(8,'glyphicons','Glyphicons','components/glyphicons',7,1,'fa-windows',1,1),(9,'dropdowns','Dropdowns','#',7,1,'fa-bars',1,2),(10,'button_groups','Button Groups','#',7,1,'fa-keyboard-o',1,3),(11,'button_dropdowns','Button Dropdowns','#',7,1,NULL,1,4),(12,'input_groups','Input Groups','#',7,1,NULL,1,5),(13,'navs','Navs','#',7,1,NULL,1,6),(14,'navbar','Navbar','#',7,1,NULL,1,7),(15,'breadcrumbs','Breadcrumbs','#',7,1,'fa-angle-double-right',1,8),(16,'pagination','Pagination','#',7,1,'fa-forward',1,9),(17,'labels','Labels','#',7,1,'fa-tags',1,10),(18,'badges','Badges','#',7,1,'fa-foursquare',1,11);
/*!40000 ALTER TABLE `navigation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `module` text NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0->inactive;1->active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Super Admin','Super Admin','*','0000-00-00 00:00:00','0000-00-00 00:00:00',1),(2,'Administrator','Administrator','3,32,33,4,41,42,43,44,45,46,75,5,51,52','0000-00-00 00:00:00','2014-01-08 04:53:10',1),(3,'Account Executive','Account Executive','1,3,31,32,33','0000-00-00 00:00:00','2013-12-05 05:53:42',1),(4,'Customer Service','Customer Service','1,3,31,32,33,5,51,52,6,61,62','2013-11-18 15:48:22','2013-12-09 22:58:18',1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(26) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(3) NOT NULL,
  `date_created` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0->inactive;1->active',
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'dhanyalvian','Dhany Noor Alfian','c44a471bd78cc6c2fea32b9fe028d30a',1,'0000-00-00 00:00:00','2013-12-21 04:57:03',1),(3,'taufik','Taufik Ramdani','e807f1fcf82d132f9bb018ca6738a19f',2,'0000-00-00 00:00:00','2013-12-09 22:42:19',1),(4,'zaenal','M. Zaenal M.','e807f1fcf82d132f9bb018ca6738a19f',2,'0000-00-00 00:00:00','2013-12-09 23:12:58',1),(6,'andhy','Andhy S.','25d55ad283aa400af464c76d713c07ad',2,'2013-12-05 05:50:37','2013-12-16 05:51:39',1);
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

-- Dump completed on 2014-08-26 18:20:17
