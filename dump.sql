-- MySQL dump 10.16  Distrib 10.1.19-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.19-MariaDB

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
-- Table structure for table `active_sessions`
--

DROP TABLE IF EXISTS `active_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `active_sessions` (
  `userID` int(10) unsigned NOT NULL,
  `IPAddress` varchar(30) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `dateAndTime` datetime DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  KEY `activeSessions_fk1` (`userID`),
  CONSTRAINT `activeSessions_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `active_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_logs`
--

DROP TABLE IF EXISTS `archive_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_logs` (
  `userID` int(10) unsigned NOT NULL,
  `login` varchar(30) NOT NULL,
  `IPAddress` varchar(30) DEFAULT NULL,
  `browser` varchar(100) DEFAULT NULL,
  `dateAndTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_logs`
--

LOCK TABLES `archive_logs` WRITE;
/*!40000 ALTER TABLE `archive_logs` DISABLE KEYS */;
INSERT INTO `archive_logs` VALUES (1,'anka','::1','Chrome','2017-02-22 15:08:39'),(4,'jan','::1','Chrome','2017-02-22 16:57:30'),(1,'anka','::1','Chrome','2017-02-22 17:16:46'),(4,'jan','::1','Chrome','2017-02-22 17:17:24'),(1,'anka','::1','Chrome','2017-02-22 17:17:43'),(4,'jan','::1','Chrome','2017-02-22 17:32:05'),(1,'anka','::1','Chrome','2017-02-22 17:32:19'),(1,'anka','::1','Chrome','2017-02-22 17:47:27'),(1,'anka','::1','Chrome','2017-02-23 15:21:02'),(2,'justyna','::1','Chrome','2017-02-23 17:24:26'),(1,'anka','::1','Chrome','2017-02-23 19:12:26'),(3,'gosia','::1','Chrome','2017-02-24 19:20:00'),(2,'justyna','::1','Chrome','2017-02-24 20:09:33'),(1,'anka','::1','Chrome','2017-02-24 20:09:51'),(3,'gosia','::1','Chrome','2017-02-24 20:10:10'),(4,'jan','::1','Chrome','2017-02-24 21:52:58'),(4,'jan','::1','Chrome','2017-02-24 22:05:23'),(5,'piotr','::1','Chrome','2017-02-24 22:19:53'),(4,'jan','::1','Chrome','2017-02-25 16:08:06'),(4,'jan','::1','Chrome','2017-02-25 16:35:32'),(4,'jan','::1','Chrome','2017-02-26 19:03:16'),(1,'anka','::1','Chrome','2017-02-26 20:34:31'),(1,'anka','::1','Chrome','2017-02-26 20:34:44'),(1,'anka','::1','Chrome','2017-02-26 20:35:53'),(1,'anka','::1','Chrome','2017-02-26 20:37:54'),(4,'jan','::1','Chrome','2017-02-26 20:40:19'),(3,'gosia','::1','Chrome','2017-02-26 20:40:33'),(2,'justyna','::1','Chrome','2017-02-26 20:41:39'),(1,'anka','::1','Chrome','2017-02-26 20:42:19'),(4,'jan','::1','Chrome','2017-02-26 20:48:20'),(1,'anka','::1','Chrome','2017-02-26 20:52:34'),(4,'jan','::1','Chrome','2017-02-26 20:53:12'),(6,'adam','::1','Chrome','2017-02-26 20:58:28'),(1,'anka','::1','Chrome','2017-02-26 20:59:05'),(4,'jan','::1','Chrome','2017-02-26 20:59:22'),(4,'jan','::1','Chrome','2017-02-26 21:03:01'),(2,'justyna','::1','Chrome','2017-02-26 21:03:15'),(4,'jan','::1','Chrome','2017-02-26 21:04:23'),(4,'jan','::1','Chrome','2017-02-26 21:04:57'),(4,'jan','::1','Chrome','2017-02-26 21:07:18'),(5,'piotr','::1','Chrome','2017-02-26 21:11:34'),(4,'jan','::1','Chrome','2017-02-26 21:11:55'),(4,'jan','::1','IE','2017-03-02 16:58:43'),(4,'jan','::1','IE','2017-03-02 17:02:03'),(4,'jan','::1','Chrome','2017-03-02 17:07:27'),(1,'anka','::1','Chrome','2017-03-02 17:26:52'),(4,'jan','::1','Chrome','2017-03-02 17:27:58'),(1,'anka','::1','Chrome','2017-03-02 17:28:33'),(4,'jan','::1','Chrome','2017-03-02 17:29:19'),(1,'anka','::1','Chrome','2017-03-02 17:31:28'),(4,'jan','::1','Chrome','2017-03-02 17:31:43'),(1,'anka','::1','Chrome','2017-03-02 18:45:44'),(4,'jan','::1','Chrome','2017-03-02 18:47:19'),(4,'jan','::1','Chrome','2017-03-02 18:48:36'),(1,'anka','::1','Chrome','2017-03-02 18:48:46'),(4,'jan','::1','Chrome','2017-03-02 18:49:31'),(4,'jan','::1','Chrome','2017-03-03 16:50:19'),(1,'anka','::1','Chrome','2017-03-03 18:00:47'),(4,'jan','::1','Chrome','2017-03-03 18:01:19'),(4,'jan','::1','Chrome','2017-03-12 22:38:29'),(4,'jan','::1','Chrome','2017-03-12 22:38:49'),(4,'jan','::1','Chrome','2017-03-12 22:39:22'),(5,'piotr','::1','Chrome','2017-03-12 22:39:46'),(4,'jan','::1','Chrome','2017-03-12 22:40:19'),(4,'jan','::1','Chrome','2017-03-12 22:40:48'),(4,'jan','::1','Chrome','2017-03-13 15:12:15'),(1,'anka','::1','Chrome','2017-03-13 15:30:41'),(4,'jan','::1','Chrome','2017-03-13 15:31:44'),(4,'jan','::1','Chrome','2017-03-13 16:22:34'),(4,'jan','::1','Chrome','2017-03-13 16:39:26'),(4,'jan','::1','Chrome','2017-03-13 16:42:34'),(4,'jan','::1','Chrome','2017-03-13 18:41:38'),(4,'jan','::1','Chrome','2017-03-13 19:03:51'),(4,'jan','::1','Chrome','2017-03-13 19:07:34'),(5,'piotr','::1','Chrome','2017-03-13 19:09:52'),(4,'jan','::1','Chrome','2017-03-13 19:27:29'),(4,'jan','::1','Chrome','2017-03-13 19:43:23'),(1,'anka','::1','Chrome','2017-03-13 19:44:21'),(4,'jan','::1','Chrome','2017-03-13 19:44:44'),(1,'anka','::1','Chrome','2017-03-13 20:07:37'),(4,'jan','::1','Chrome','2017-03-13 20:08:11'),(3,'gosia','::1','Chrome','2017-03-13 20:09:18'),(6,'adam','::1','Chrome','2017-03-13 20:09:51'),(4,'jan','::1','Chrome','2017-03-13 20:45:23'),(4,'jan','::1','Chrome','2017-03-14 16:42:43'),(4,'jan','::1','Chrome','2017-03-14 17:19:18'),(4,'jan','::1','Chrome','2017-03-17 16:23:39'),(9,'admin','::1','Chrome','2017-03-17 16:30:07'),(9,'admin','::1','Chrome','2017-03-17 17:08:07'),(9,'admin','::1','Chrome','2017-03-17 17:13:41'),(11,'jan','::1','Chrome','2017-03-17 17:20:44'),(9,'admin','::1','Chrome','2017-03-17 17:21:57'),(13,'hubert','::1','Chrome','2017-03-17 17:25:17'),(12,'adam','::1','Chrome','2017-03-17 17:27:34'),(11,'jan','::1','Chrome','2017-03-17 17:34:08'),(11,'jan','::1','Chrome','2017-03-17 17:36:15'),(9,'admin','::1','Chrome','2017-03-17 17:36:44'),(12,'adam','::1','Chrome','2017-03-17 17:42:27'),(9,'admin','::1','Chrome','2017-03-17 17:44:33'),(9,'admin','::1','Chrome','2017-03-17 18:55:32'),(9,'admin','::1','Chrome','2017-03-17 19:30:12'),(13,'hubert','::1','Chrome','2017-03-17 19:39:33'),(9,'admin','::1','Chrome','2017-03-17 20:00:42'),(11,'jan','::1','Chrome','2017-03-17 20:00:58'),(17,'login','::1','Chrome','2017-03-17 20:02:06'),(9,'admin','::1','Chrome','2017-03-17 20:02:20'),(9,'admin','::1','Chrome','2017-03-17 20:04:16'),(3,'gosia','::1','Chrome','2017-03-17 20:14:49'),(11,'jan','::1','Chrome','2017-03-17 20:15:38'),(9,'admin','::1','Chrome','2017-03-17 20:17:16'),(1,'anka','::1','Chrome','2017-03-17 20:18:15'),(9,'admin','::1','Chrome','2017-03-17 20:18:44'),(9,'admin','::1','Chrome','2017-03-17 22:20:41'),(9,'admin','::1','Chrome','2017-03-18 15:23:24'),(9,'admin','::1','Chrome','2017-03-18 17:17:21'),(13,'hubert','::1','Chrome','2017-03-18 19:13:16'),(9,'admin','::1','Chrome','2017-03-18 19:13:52'),(9,'admin','::1','Chrome','2017-03-18 21:35:32'),(9,'admin','::1','Chrome','2017-03-18 21:36:02'),(19,'admin','::1','Chrome','2017-03-18 22:08:56'),(19,'admin','::1','Chrome','2017-03-18 22:26:01'),(19,'admin','::1','Chrome','2017-03-18 22:30:20'),(19,'admin','::1','Chrome','2017-03-18 22:41:11'),(19,'admin','::1','Chrome','2017-03-18 23:28:16'),(24,'maria','::1','Chrome','2017-03-19 00:05:25'),(11,'jan','::1','Chrome','2017-03-19 00:05:42'),(19,'admin','::1','Chrome','2017-03-19 00:06:04'),(19,'admin','::1','Chrome','2017-03-19 00:08:34'),(11,'jan','::1','Chrome','2017-03-19 00:11:27'),(19,'admin','::1','Chrome','2017-03-19 00:11:42'),(19,'admin','::1','Chrome','2017-03-19 00:41:31'),(13,'hubert','::1','Chrome','2017-03-19 00:47:13'),(1,'anka','::1','Chrome','2017-03-19 00:47:59'),(19,'admin','::1','Chrome','2017-03-19 00:59:40'),(19,'admin','::1','Chrome','2017-03-19 01:01:47'),(19,'admin','::1','Chrome','2017-03-19 01:07:06'),(19,'admin','::1','Chrome','2017-03-19 01:17:54'),(19,'admin','::1','Chrome','2017-03-19 01:18:21'),(19,'admin','::1','Chrome','2017-03-19 01:18:58'),(19,'admin','::1','Chrome','2017-03-19 01:22:43'),(19,'admin','::1','Chrome','2017-03-19 15:51:42'),(1,'anka','::1','Chrome','2017-03-19 15:52:00'),(1,'anka','::1','Chrome','2017-03-19 17:29:03'),(19,'admin','::1','Chrome','2017-03-19 17:53:39'),(20,'maria','::1','Chrome','2017-03-19 17:55:23'),(20,'maria','::1','Chrome','2017-03-19 17:55:38'),(11,'jan','::1','Chrome','2017-03-19 17:55:47'),(19,'admin','::1','Chrome','2017-03-19 17:56:10'),(1,'anka','::1','Chrome','2017-03-19 17:56:30'),(11,'jan','::1','Chrome','2017-03-19 19:19:07'),(19,'admin','::1','Chrome','2017-03-19 19:19:22'),(1,'anka','::1','Chrome','2017-03-19 19:19:38'),(3,'gosia','::1','Chrome','2017-03-19 20:17:20'),(1,'anka','::1','Chrome','2017-03-19 20:17:39'),(1,'anka','::1','Chrome','2017-03-19 20:28:09'),(1,'anka','::1','Chrome','2017-03-19 20:53:16'),(1,'anka','::1','Chrome','2017-03-19 21:01:56'),(11,'jan','::1','Chrome','2017-03-19 22:36:34'),(1,'anka','::1','Chrome','2017-03-19 22:37:07'),(13,'hubert','::1','Chrome','2017-03-19 23:12:40'),(1,'anka','::1','Chrome','2017-03-19 23:14:21'),(19,'admin','::1','Chrome','2017-03-19 23:19:31'),(1,'anka','::1','Chrome','2017-03-19 23:19:57'),(19,'admin','::1','Chrome','2017-03-20 00:13:43'),(1,'anka','::1','Chrome','2017-03-20 00:13:54'),(11,'jan','::1','Chrome','2017-03-20 02:00:34'),(1,'anka','::1','Chrome','2017-03-20 02:01:06'),(11,'jan','::1','Chrome','2017-03-20 02:01:37'),(11,'jan','::1','Chrome','2017-03-20 02:21:31'),(11,'jan','::1','Chrome','2017-03-20 02:35:39'),(11,'jan','::1','Chrome','2017-03-20 03:01:16'),(13,'hubert','::1','Chrome','2017-03-20 03:10:41'),(12,'adam','::1','Chrome','2017-03-20 03:10:53'),(13,'hubert','::1','Chrome','2017-03-20 03:14:45'),(1,'anka','::1','Chrome','2017-03-20 03:39:07'),(11,'jan','::1','Chrome','2017-03-20 03:45:25'),(1,'anka','::1','Chrome','2017-03-20 03:45:46'),(11,'jan','::1','Chrome','2017-03-20 03:48:49'),(11,'jan','::1','Chrome','2017-03-20 03:49:38'),(1,'anka','::1','Chrome','2017-03-20 03:49:50'),(1,'anka','::1','Chrome','2017-03-20 03:50:29'),(1,'anka','::1','Chrome','2017-03-20 03:51:34'),(1,'anka','::1','Chrome','2017-03-20 03:55:10'),(19,'admin','::1','Chrome','2017-03-20 03:55:27'),(11,'jan','::1','Chrome','2017-03-20 03:56:17'),(13,'hubert','::1','Chrome','2017-03-20 03:58:20'),(11,'jan','::1','Chrome','2017-03-20 04:11:27'),(19,'admin','::1','Chrome','2017-03-20 04:12:17'),(1,'anka','::1','Chrome','2017-03-20 04:13:06'),(1,'anka','::1','Chrome','2017-03-20 04:18:50'),(11,'jan','::1','Chrome','2017-03-20 04:19:22'),(1,'anka','::1','Chrome','2017-03-20 04:22:33'),(11,'jan','::1','Chrome','2017-03-20 04:22:45'),(19,'admin','::1','Chrome','2017-03-20 04:23:04'),(11,'jan','::1','Chrome','2017-03-20 04:23:23'),(1,'anka','::1','Chrome','2017-03-20 04:37:19'),(19,'admin','::1','Chrome','2017-03-20 04:37:54'),(1,'anka','::1','Chrome','2017-03-20 04:38:08'),(11,'jan','::1','Chrome','2017-03-20 17:02:49'),(1,'anka','::1','Chrome','2017-03-20 17:04:25'),(19,'admin','::1','Chrome','2017-03-20 17:04:44'),(1,'anka','::1','Chrome','2017-03-20 17:05:13'),(11,'jan','::1','Chrome','2017-03-20 17:05:53'),(11,'jan','::1','Chrome','2017-03-20 17:06:44'),(13,'hubert','::1','Chrome','2017-03-20 17:07:38'),(1,'anka','::1','Chrome','2017-03-20 17:09:47'),(12,'adam','::1','Chrome','2017-03-20 17:33:33'),(12,'adam','::1','Chrome','2017-03-20 17:35:26'),(13,'hubert','::1','Chrome','2017-03-20 17:37:36'),(11,'jan','::1','Chrome','2017-03-20 19:15:07'),(11,'jan','::1','Chrome','2017-03-20 19:40:40'),(11,'jan','::1','Chrome','2017-03-20 19:41:58'),(11,'jan','::1','Chrome','2017-03-20 19:48:47'),(11,'jan','::1','Chrome','2017-03-20 19:50:56'),(11,'jan','::1','Chrome','2017-03-20 19:51:38'),(12,'adam','::1','Chrome','2017-03-20 19:58:10'),(13,'hubert','::1','Chrome','2017-03-20 19:58:33'),(11,'jan','::1','Chrome','2017-03-20 20:05:23'),(11,'jan','::1','Chrome','2017-03-20 20:07:07'),(11,'jan','::1','Chrome','2017-03-20 20:14:54'),(13,'hubert','::1','Chrome','2017-03-20 20:15:09'),(11,'jan','::1','Chrome','2017-03-20 20:15:19'),(1,'anka','::1','Chrome','2017-03-20 20:16:08'),(11,'jan','::1','Chrome','2017-03-20 20:22:20'),(13,'hubert','::1','Chrome','2017-03-20 20:41:02'),(12,'adam','::1','Chrome','2017-03-20 20:41:17'),(1,'anka','::1','Chrome','2017-03-20 20:42:08'),(3,'gosia','::1','Chrome','2017-03-20 20:42:19'),(2,'justyna','::1','Chrome','2017-03-20 20:42:48'),(11,'jan','::1','Chrome','2017-03-20 20:43:19'),(11,'jan','::1','Chrome','2017-03-20 20:52:44'),(1,'anka','::1','Chrome','2017-03-20 20:55:54'),(19,'admin','::1','Chrome','2017-03-20 21:01:42'),(1,'anka','::1','Chrome','2017-03-20 21:01:59'),(1,'anka','::1','Chrome','2017-03-20 21:07:28'),(1,'anka','::1','Chrome','2017-03-20 21:09:18'),(19,'admin','::1','Chrome','2017-03-20 21:19:47'),(11,'jan','::1','Chrome','2017-03-20 21:48:04'),(11,'jan','::1','Chrome','2017-03-20 21:49:24'),(13,'hubert','::1','Chrome','2017-03-20 21:52:43'),(11,'jan','::1','Chrome','2017-03-20 21:57:55'),(11,'jan','::1','Chrome','2017-03-20 22:12:09'),(1,'anka','::1','Chrome','2017-03-20 22:13:26'),(11,'jan','::1','Chrome','2017-03-20 22:46:23'),(12,'adam','::1','Chrome','2017-03-20 22:47:21'),(12,'adam','::1','Chrome','2017-03-20 22:48:45'),(13,'hubert','::1','Chrome','2017-03-20 22:48:56'),(11,'jan','::1','Chrome','2017-03-20 22:49:43'),(11,'jan','::1','Chrome','2017-03-20 22:51:53'),(3,'gosia','::1','Chrome','2017-03-20 23:01:20'),(19,'admin','::1','Chrome','2017-03-20 23:11:42'),(1,'anka','::1','Chrome','2017-03-20 23:37:13'),(11,'jan','::1','Chrome','2017-03-20 23:52:32'),(19,'admin','::1','Chrome','2017-03-21 00:36:04'),(19,'admin','::1','Chrome','2017-03-21 00:37:20'),(19,'admin','::1','Chrome','2017-03-21 10:05:24'),(1,'anka','::1','Chrome','2017-03-21 10:06:15'),(11,'jan','::1','Chrome','2017-03-21 10:06:50'),(11,'jan','::1','Chrome','2017-03-21 10:28:02'),(1,'anka','::1','Chrome','2017-03-21 10:29:46'),(20,'artur','::1','Chrome','2017-03-21 10:33:54'),(1,'anka','::1','Chrome','2017-03-21 10:38:54'),(20,'artur','::1','Chrome','2017-03-21 10:40:11'),(19,'admin','::1','Chrome','2017-03-21 10:45:19'),(20,'artur','::1','Chrome','2017-03-21 10:48:53'),(19,'admin','::1','Chrome','2017-03-21 10:51:08');
/*!40000 ALTER TABLE `archive_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `archive_visits`
--

DROP TABLE IF EXISTS `archive_visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archive_visits` (
  `archiveVisitID` int(10) unsigned NOT NULL,
  `patientID` int(10) unsigned NOT NULL,
  `dieticianID` int(10) unsigned NOT NULL,
  `visitDate` date NOT NULL,
  `visitHour` time NOT NULL,
  KEY `dieticianID_index` (`dieticianID`),
  KEY `patientID_index` (`patientID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/*!50100 PARTITION BY HASH (year(visitDate))
PARTITIONS 4 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archive_visits`
--

LOCK TABLES `archive_visits` WRITE;
/*!40000 ALTER TABLE `archive_visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `archive_visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dietician`
--

DROP TABLE IF EXISTS `dietician`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dietician` (
  `dieticianID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `personalIdentityNumber` varchar(20) NOT NULL,
  `dateOfBirth` date NOT NULL,
  `pathToImage` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`dieticianID`),
  UNIQUE KEY `userID_index` (`userID`),
  UNIQUE KEY `pathToImage` (`pathToImage`),
  CONSTRAINT `dietician_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietician`
--

LOCK TABLES `dietician` WRITE;
/*!40000 ALTER TABLE `dietician` DISABLE KEYS */;
INSERT INTO `dietician` VALUES (1,1,'90052441235','1990-05-24','img/Anna Juraszczyk.png'),(2,2,'88123084512','1988-12-30','img/Justyna Krupczyk.png'),(3,3,'75020545876','1975-02-05','img/Małgorzata Łachman.png');
/*!40000 ALTER TABLE `dietician` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `checkTheDateOfDieticianBirth` BEFORE INSERT ON `dietician`


 FOR EACH ROW begin





	if NEW.dateOfBirth > curdate()





    then





        signal sqlstate '45000'





        set message_text = 'Date of birth is invalid! You cannot add the date in the future!';





    end if;





end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `dieticians`
--

DROP TABLE IF EXISTS `dieticians`;
/*!50001 DROP VIEW IF EXISTS `dieticians`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `dieticians` (
  `dieticianID` tinyint NOT NULL,
  `userID` tinyint NOT NULL,
  `PESEL` tinyint NOT NULL,
  `dateOfBirth` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `login` tinyint NOT NULL,
  `pathToImage` tinyint NOT NULL,
  `salt` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `measurement`
--

DROP TABLE IF EXISTS `measurement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `measurement` (
  `measurementID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patientID` int(10) unsigned NOT NULL,
  `measurementDate` date NOT NULL,
  `bodyMass` float unsigned NOT NULL,
  `thePercentageOfFat` int(3) unsigned NOT NULL,
  `thePercentageOfWater` int(3) unsigned NOT NULL,
  `BMI` float unsigned NOT NULL,
  PRIMARY KEY (`measurementID`),
  KEY `patientID_index` (`patientID`),
  CONSTRAINT `measurement_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurement`
--

LOCK TABLES `measurement` WRITE;
/*!40000 ALTER TABLE `measurement` DISABLE KEYS */;
INSERT INTO `measurement` VALUES (5,9,'2017-03-20',69,52,54,23.88),(6,7,'2017-03-20',109,73,50,29.88),(8,7,'2017-03-11',130,80,60,31.91),(9,7,'2017-02-28',135,82,65,31.99),(10,7,'2017-02-22',125,80,59,30.29),(11,7,'2016-11-11',150,75,35,33.22),(12,8,'2017-03-19',75,55,35,23.21),(13,8,'2017-03-06',80,60,38,24.01),(14,8,'2017-01-15',90,65,45,28.22),(15,8,'2016-12-31',92,66,42,28.76),(16,8,'2016-11-26',95,69,50,29.22),(17,9,'2017-03-10',75,56,22,24.21),(18,9,'2017-03-01',77,60,22,24.78),(19,9,'2017-02-14',81,60,29,25.11),(20,9,'2017-01-31',88,69,32,26.16),(21,9,'2017-01-11',91,72,35,27.01),(22,10,'2017-03-21',52,67,59,23.42);
/*!40000 ALTER TABLE `measurement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `officehours`
--

DROP TABLE IF EXISTS `officehours`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `officehours` (
  `officeHoursID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dieticianID` int(10) unsigned NOT NULL,
  `dayOfTheWeek` int(1) unsigned NOT NULL,
  `starts_at` time NOT NULL,
  `ends_at` time NOT NULL,
  PRIMARY KEY (`officeHoursID`),
  KEY `dieticianID_index` (`dieticianID`),
  CONSTRAINT `officeHours_fk1` FOREIGN KEY (`dieticianID`) REFERENCES `dietician` (`dieticianID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officehours`
--

LOCK TABLES `officehours` WRITE;
/*!40000 ALTER TABLE `officehours` DISABLE KEYS */;
INSERT INTO `officehours` VALUES (6,2,2,'12:00:00','16:00:00'),(8,2,4,'16:00:00','20:00:00'),(26,3,2,'12:00:00','16:00:00'),(27,3,4,'16:00:00','20:00:00'),(36,1,0,'08:00:00','12:00:00'),(42,1,3,'12:00:00','16:00:00'),(43,3,5,'08:00:00','12:00:00'),(44,1,5,'12:00:00','16:00:00');
/*!40000 ALTER TABLE `officehours` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patient`
--

DROP TABLE IF EXISTS `patient`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patient` (
  `patientID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  PRIMARY KEY (`patientID`),
  UNIQUE KEY `userID_index` (`userID`),
  CONSTRAINT `patient_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (7,11),(8,12),(9,13),(10,20);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!50001 DROP VIEW IF EXISTS `patients`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `patients` (
  `patientID` tinyint NOT NULL,
  `userID` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `login` tinyint NOT NULL,
  `salt` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `firstName` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `lastName` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `salt` varchar(10) NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email_index` (`email`),
  UNIQUE KEY `login_index` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Anna','Juraszczyk','anka@wp.pl','anka','131282524a4384d62d2d7eeea7d7b8e57b3feeb2','umqQ06eko9'),(2,'Justyna','Krupczyk','justyna@o2.pl','justyna','320380d1a5f928392d89ef772b1191acd6460cf2','TqYYulCyDO'),(3,'Małgorzata','Łachman','gosia@gmail.com','gosia','34a76b055064be5d1be9a9e1d8d87538cc6981f3','Elo2VjoLNW'),(11,'Jan','Kowalski','jan.kowalski@wp.pl','jan','eda601c9a7b078fa309726e77d70e18a7c84a1af','CJ7Dji0S7J'),(12,'Adam','Malinowski','adasiek@interia.pl','adam','3c00c6f65b522933f33c79c7aa6c9e9610f3e068','AlEgaGOI4q'),(13,'Hubert','Adamiak','hubercik@gmail.com','hubert','ab343962e8aa59682f9353d113bc422582ebe7dd','2C9xWGLuA8'),(19,'Michał','Sroka','m4jk3ls@gmail.com','admin','3239f16c8e8b966a45d35c47355aca5dde800a3a','iuqyzMhnzB'),(20,'artur','niewiarowski','aniewiarowski@pk.edu.pl','artur','bf985ca46c914ea17439b50f4fc359f2a85740b5','oeJ5j5vzkf');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit` (
  `visitID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `patientID` int(10) unsigned NOT NULL,
  `dieticianID` int(10) unsigned DEFAULT NULL,
  `visitDate` date DEFAULT NULL,
  `visitHour` time DEFAULT NULL,
  PRIMARY KEY (`visitID`),
  KEY `dieticianID_index` (`dieticianID`),
  KEY `patientID_index` (`patientID`),
  CONSTRAINT `visit_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `visit_fk2` FOREIGN KEY (`dieticianID`) REFERENCES `dietician` (`dieticianID`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES (62,9,1,'2017-03-27','10:00:00'),(63,9,2,'2017-03-24','16:45:00'),(64,9,2,'2017-04-05','12:45:00'),(65,9,3,'2017-03-25','10:45:00'),(66,9,3,'2017-03-24','17:15:00'),(68,8,1,'2017-03-23','13:00:00'),(69,8,2,'2017-03-29','13:45:00'),(70,8,2,'2017-04-07','16:00:00'),(71,8,3,'2017-03-29','13:30:00'),(72,8,3,'2017-04-07','18:15:00'),(73,7,1,'2017-03-27','09:30:00'),(75,7,2,'2017-04-05','15:45:00'),(76,7,2,'2017-04-07','19:00:00'),(77,7,3,'2017-03-31','19:45:00'),(78,7,3,'2017-04-01','08:30:00'),(79,9,2,'2017-04-07','19:45:00'),(80,7,1,'2017-04-06','14:30:00'),(82,7,1,'2017-03-30','14:00:00'),(83,7,1,'2017-03-30','13:30:00'),(84,8,3,'2017-03-22','14:15:00'),(85,8,3,'2017-03-22','15:00:00'),(86,8,3,'2017-03-22','15:45:00'),(87,8,3,'2017-04-05','15:45:00'),(88,8,3,'2017-04-08','10:30:00'),(89,9,2,'2017-03-22','14:15:00'),(90,9,2,'2017-03-22','15:00:00'),(91,7,2,'2017-03-24','18:30:00'),(92,7,3,'2017-03-31','18:00:00'),(93,7,2,'2017-03-22','12:00:00'),(94,10,1,'2017-03-23','12:30:00'),(95,10,1,'2017-03-23','12:30:00');
/*!40000 ALTER TABLE `visit` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER dietary_center.ifDieticianAvailable





	BEFORE INSERT





	ON dietary_center.visit





	FOR EACH ROW





	begin





	if





	(





		(select oh.dayOfTheWeek from officehours oh where (oh.dieticianID = new.dieticianID) and (oh.dayOfTheWeek in (select weekday(new.visitDate)))) is null or





		((select new.visitHour) < (select starts_at from officehours oh where (oh.dieticianID = new.dieticianID) and (oh.dayOfTheWeek in (select weekday(new.visitDate))))) or





		((select new.visitHour) > (select subtime((select ends_at from officehours oh where (oh.dieticianID = new.dieticianID) and





		(oh.dayOfTheWeek in (select weekday(new.visitDate)))),'00:15:00')))





	) then





			signal sqlstate '45000'





			set message_text = 'Your dietician is not available at the specified time!';





	end if;





	end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Temporary table structure for view `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!50001 DROP VIEW IF EXISTS `visits`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `visits` (
  `visitID` tinyint NOT NULL,
  `patientID` tinyint NOT NULL,
  `userID` tinyint NOT NULL,
  `dieticianID` tinyint NOT NULL,
  `visitDate` tinyint NOT NULL,
  `visitHour` tinyint NOT NULL,
  `Name` tinyint NOT NULL,
  `email` tinyint NOT NULL,
  `login` tinyint NOT NULL,
  `salt` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Dumping events for database 'dietary_center'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `archiver` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8 */ ;;
/*!50003 SET character_set_results = utf8 */ ;;
/*!50003 SET collation_connection  = utf8_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_AUTO_VALUE_ON_ZERO' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = '+00:00' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`root`@`localhost`*/ /*!50106 EVENT `archiver` ON SCHEDULE EVERY 1 DAY STARTS '2017-03-20 22:45:53' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Moving visits from the past to archive_visits table' DO begin

	START TRANSACTION;

	insert into archive_visits select * from visit where visitDate < curdate();

	delete from visit where visitDate < curdate();

	COMMIT;

end */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'dietary_center'
--
/*!50003 DROP FUNCTION IF EXISTS `userName` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `userName`(user_id int(10)) RETURNS varchar(100) CHARSET utf8
begin

if (user_id <= 0) then

	signal sqlstate '45000'

	set message_text = 'ID number can not be a non-positive number!', mysql_errno = 1001;

end if;

return(select concat(firstName, ' ', lastName) from dietary_center.user where userID like user_id);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `bookVisit` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `bookVisit`()
begin

select * from dietary_center.dietician d join dietary_center.user u on (d.userID = u.userID);

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `incomingVisits` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `incomingVisits`(in user_id INT(10))
begin

if (user_id <= 0) then

	signal sqlstate '45000'

	set message_text = 'ID number can not be a non-positive number!', mysql_errno = 1001;

end if;

select visitDate, visitHour from dietary_center.visit where patientID in (select patientID from dietary_center.patient where userID like user_id) order by visitDate asc;

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `yourResults` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `yourResults`(in user_id INT(10))
begin

if (user_id <= 0) then

	signal sqlstate '45000'

	set message_text = 'ID number can not be a non-positive number!', mysql_errno = 1001;

end if;

select measurementDate as Date, bodyMass, thePercentageOfFat as fat, thePercentageOfWater as water, BMI

from measurement where patientID = (select patientID from patient where userID like user_id) order by Date desc;

end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Final view structure for view `dieticians`
--

/*!50001 DROP TABLE IF EXISTS `dieticians`*/;
/*!50001 DROP VIEW IF EXISTS `dieticians`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `dieticians` AS select `d`.`dieticianID` AS `dieticianID`,`d`.`userID` AS `userID`,`d`.`personalIdentityNumber` AS `PESEL`,`d`.`dateOfBirth` AS `dateOfBirth`,concat(`u`.`lastName`,' ',`u`.`firstName`) AS `Name`,`u`.`email` AS `email`,`u`.`login` AS `login`,`d`.`pathToImage` AS `pathToImage`,`u`.`salt` AS `salt` from (`dietician` `d` join `user` `u` on((`d`.`userID` = `u`.`userID`))) order by concat(`u`.`lastName`,' ',`u`.`firstName`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `patients`
--

/*!50001 DROP TABLE IF EXISTS `patients`*/;
/*!50001 DROP VIEW IF EXISTS `patients`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `patients` AS select `p`.`patientID` AS `patientID`,`p`.`userID` AS `userID`,concat(`u`.`lastName`,' ',`u`.`firstName`) AS `Name`,`u`.`email` AS `email`,`u`.`login` AS `login`,`u`.`salt` AS `salt` from (`patient` `p` join `user` `u` on((`p`.`userID` = `u`.`userID`))) order by concat(`u`.`lastName`,' ',`u`.`firstName`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `visits`
--

/*!50001 DROP TABLE IF EXISTS `visits`*/;
/*!50001 DROP VIEW IF EXISTS `visits`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `visits` AS select `v`.`visitID` AS `visitID`,`p`.`patientID` AS `patientID`,`p`.`userID` AS `userID`,`v`.`dieticianID` AS `dieticianID`,`v`.`visitDate` AS `visitDate`,`v`.`visitHour` AS `visitHour`,concat(`u`.`lastName`,' ',`u`.`firstName`) AS `Name`,`u`.`email` AS `email`,`u`.`login` AS `login`,`u`.`salt` AS `salt` from ((`visit` `v` join `patient` `p` on((`v`.`patientID` = `p`.`patientID`))) join `user` `u` on((`p`.`userID` = `u`.`userID`))) order by `v`.`visitDate`,`v`.`visitHour` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-23 18:56:19
