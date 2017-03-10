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
  CONSTRAINT `activeSessions_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `active_sessions`
--

LOCK TABLES `active_sessions` WRITE;
/*!40000 ALTER TABLE `active_sessions` DISABLE KEYS */;
INSERT INTO `active_sessions` VALUES (4,'::1','Chrome','2017-03-10 20:32:46','wlo9h7KtNsEcwpk9rAtH05kGcvBqtVvNPWM7HECe4ELvp2pLGnimmOD8pT9riJ250V2sZynndeKca1nLNy0oATPYuEzOZUrL3hbb');
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
INSERT INTO `archive_logs` VALUES (1,'anka','::1','Chrome','2017-02-22 15:08:39'),(4,'jan','::1','Chrome','2017-02-22 16:57:30'),(1,'anka','::1','Chrome','2017-02-22 17:16:46'),(4,'jan','::1','Chrome','2017-02-22 17:17:24'),(1,'anka','::1','Chrome','2017-02-22 17:17:43'),(4,'jan','::1','Chrome','2017-02-22 17:32:05'),(1,'anka','::1','Chrome','2017-02-22 17:32:19'),(1,'anka','::1','Chrome','2017-02-22 17:47:27'),(1,'anka','::1','Chrome','2017-02-23 15:21:02'),(2,'justyna','::1','Chrome','2017-02-23 17:24:26'),(1,'anka','::1','Chrome','2017-02-23 19:12:26'),(3,'gosia','::1','Chrome','2017-02-24 19:20:00'),(2,'justyna','::1','Chrome','2017-02-24 20:09:33'),(1,'anka','::1','Chrome','2017-02-24 20:09:51'),(3,'gosia','::1','Chrome','2017-02-24 20:10:10'),(4,'jan','::1','Chrome','2017-02-24 21:52:58'),(4,'jan','::1','Chrome','2017-02-24 22:05:23'),(5,'piotr','::1','Chrome','2017-02-24 22:19:53'),(4,'jan','::1','Chrome','2017-02-25 16:08:06'),(4,'jan','::1','Chrome','2017-02-25 16:35:32'),(4,'jan','::1','Chrome','2017-02-26 19:03:16'),(1,'anka','::1','Chrome','2017-02-26 20:34:31'),(1,'anka','::1','Chrome','2017-02-26 20:34:44'),(1,'anka','::1','Chrome','2017-02-26 20:35:53'),(1,'anka','::1','Chrome','2017-02-26 20:37:54'),(4,'jan','::1','Chrome','2017-02-26 20:40:19'),(3,'gosia','::1','Chrome','2017-02-26 20:40:33'),(2,'justyna','::1','Chrome','2017-02-26 20:41:39'),(1,'anka','::1','Chrome','2017-02-26 20:42:19'),(4,'jan','::1','Chrome','2017-02-26 20:48:20'),(1,'anka','::1','Chrome','2017-02-26 20:52:34'),(4,'jan','::1','Chrome','2017-02-26 20:53:12'),(6,'adam','::1','Chrome','2017-02-26 20:58:28'),(1,'anka','::1','Chrome','2017-02-26 20:59:05'),(4,'jan','::1','Chrome','2017-02-26 20:59:22'),(4,'jan','::1','Chrome','2017-02-26 21:03:01'),(2,'justyna','::1','Chrome','2017-02-26 21:03:15'),(4,'jan','::1','Chrome','2017-02-26 21:04:23'),(4,'jan','::1','Chrome','2017-02-26 21:04:57'),(4,'jan','::1','Chrome','2017-02-26 21:07:18'),(5,'piotr','::1','Chrome','2017-02-26 21:11:34'),(4,'jan','::1','Chrome','2017-02-26 21:11:55'),(4,'jan','::1','IE','2017-03-02 16:58:43'),(4,'jan','::1','IE','2017-03-02 17:02:03'),(4,'jan','::1','Chrome','2017-03-02 17:07:27'),(1,'anka','::1','Chrome','2017-03-02 17:26:52'),(4,'jan','::1','Chrome','2017-03-02 17:27:58'),(1,'anka','::1','Chrome','2017-03-02 17:28:33'),(4,'jan','::1','Chrome','2017-03-02 17:29:19'),(1,'anka','::1','Chrome','2017-03-02 17:31:28'),(4,'jan','::1','Chrome','2017-03-02 17:31:43'),(1,'anka','::1','Chrome','2017-03-02 18:45:44'),(4,'jan','::1','Chrome','2017-03-02 18:47:19'),(4,'jan','::1','Chrome','2017-03-02 18:48:36'),(1,'anka','::1','Chrome','2017-03-02 18:48:46'),(4,'jan','::1','Chrome','2017-03-02 18:49:31'),(4,'jan','::1','Chrome','2017-03-03 16:50:19'),(1,'anka','::1','Chrome','2017-03-03 18:00:47'),(4,'jan','::1','Chrome','2017-03-03 18:01:19'),(4,'jan','::1','Chrome','2017-03-10 20:32:46');
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
  `supplementID` int(10) unsigned DEFAULT NULL,
  `visitDate` date NOT NULL,
  `visitPrice` float unsigned NOT NULL,
  `visitHour` time NOT NULL,
  KEY `dieticianID_index` (`dieticianID`),
  KEY `patientID_index` (`patientID`),
  KEY `supplementID_index` (`supplementID`)
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
  CONSTRAINT `dietician_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE
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
  `BMI` int(3) unsigned NOT NULL,
  PRIMARY KEY (`measurementID`),
  KEY `patientID_index` (`patientID`),
  CONSTRAINT `measurement_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `measurement`
--

LOCK TABLES `measurement` WRITE;
/*!40000 ALTER TABLE `measurement` DISABLE KEYS */;
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
  CONSTRAINT `officeHours_fk1` FOREIGN KEY (`dieticianID`) REFERENCES `dietician` (`dieticianID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officehours`
--

LOCK TABLES `officehours` WRITE;
/*!40000 ALTER TABLE `officehours` DISABLE KEYS */;
INSERT INTO `officehours` VALUES (6,2,2,'12:00:00','16:00:00'),(8,2,4,'16:00:00','20:00:00'),(13,1,5,'08:00:00','12:00:00'),(26,3,2,'12:00:00','16:00:00'),(27,3,4,'16:00:00','20:00:00'),(29,3,0,'12:00:00','16:00:00'),(35,1,2,'12:00:00','16:00:00'),(36,1,0,'08:00:00','12:00:00'),(39,1,4,'16:00:00','20:00:00');
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
  CONSTRAINT `patient_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
INSERT INTO `patient` VALUES (1,4),(2,5),(3,6),(4,7),(5,8);
/*!40000 ALTER TABLE `patient` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supplement`
--

DROP TABLE IF EXISTS `supplement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplement` (
  `supplementID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`supplementID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplement`
--

LOCK TABLES `supplement` WRITE;
/*!40000 ALTER TABLE `supplement` DISABLE KEYS */;
INSERT INTO `supplement` VALUES (1,'Pertres',50);
/*!40000 ALTER TABLE `supplement` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Anna','Juraszczyk','anka@wp.pl','anka','131282524a4384d62d2d7eeea7d7b8e57b3feeb2','umqQ06eko9'),(2,'Justyna','Krupczyk','justyna@o2.pl','justyna','320380d1a5f928392d89ef772b1191acd6460cf2','TqYYulCyDO'),(3,'Małgorzata','Łachman','gosia@gmail.com','gosia','34a76b055064be5d1be9a9e1d8d87538cc6981f3','Elo2VjoLNW'),(4,'Jan','Kowalski','jan@o2.pl','jan','407d02bc07e0e76b884ec0b27d811b775ad3d434','8Vr4pfkMfm'),(5,'Piotr','Nowak','piotr@o2.pl','piotr','c78007d51a900be0bea9c6af9d88ac49eb09e25c','wNwZwKBRcA'),(6,'Adam','Król','adam@o2.pl','adam','e3a3ad3f06b88110b2efa10485bbef3ce2d58d6d','ay3Vp9gV91'),(7,'Mateusz','Nowakowski','mateusz@o2.pl','mateusz','c39c9a4b0290ba1d4cd62aa0ed6f6677f9d4b27d','n01oF22Scg'),(8,'Piotr','Żyła','piotrek@o2.pl','piotrek','77f4e9405f7eb43c5164b71d4a7b880008f1ff4c','NHMGnH48iW');
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
  `dieticianID` int(10) unsigned NOT NULL,
  `supplementID` int(10) unsigned DEFAULT NULL,
  `visitDate` date DEFAULT NULL,
  `visitPrice` float unsigned DEFAULT NULL,
  `visitHour` time DEFAULT NULL,
  PRIMARY KEY (`visitID`),
  KEY `dieticianID_index` (`dieticianID`),
  KEY `patientID_index` (`patientID`),
  KEY `supplementID_index` (`supplementID`),
  CONSTRAINT `visit_fk1` FOREIGN KEY (`patientID`) REFERENCES `patient` (`patientID`) ON UPDATE CASCADE,
  CONSTRAINT `visit_fk2` FOREIGN KEY (`dieticianID`) REFERENCES `dietician` (`dieticianID`) ON UPDATE CASCADE,
  CONSTRAINT `visit_fk3` FOREIGN KEY (`supplementID`) REFERENCES `supplement` (`supplementID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
INSERT INTO `visit` VALUES (2,4,2,1,'2017-03-15',95,'12:30:00'),(4,3,1,1,'2017-03-11',80,'09:45:00');
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

    if((select oh.dayOfTheWeek from officehours oh where oh.dieticianID = new.dieticianID and oh.dayOfTheWeek = (select weekday(new.visitDate))) is null or

        (select new.visitHour < (select starts_at from officehours)) or

        (select new.visitHour > (select ends_at from officehours)))

    then

        signal sqlstate '45000'

        set message_text = 'Your dietician is not available at the specified time!';

    end if;

end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-10 23:12:19
