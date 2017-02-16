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
  PRIMARY KEY (`dieticianID`),
  UNIQUE KEY `userID_index` (`userID`),
  CONSTRAINT `dietician_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietician`
--

LOCK TABLES `dietician` WRITE;
/*!40000 ALTER TABLE `dietician` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `officehours`
--

LOCK TABLES `officehours` WRITE;
/*!40000 ALTER TABLE `officehours` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patient`
--

LOCK TABLES `patient` WRITE;
/*!40000 ALTER TABLE `patient` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supplement`
--

LOCK TABLES `supplement` WRITE;
/*!40000 ALTER TABLE `supplement` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visit`
--

LOCK TABLES `visit` WRITE;
/*!40000 ALTER TABLE `visit` DISABLE KEYS */;
/*!40000 ALTER TABLE `visit` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `ifDieticianAvailable` BEFORE INSERT ON `visit`
 FOR EACH ROW begin

    if(((select dayofweek(new.visitDate))!=(select oh.dayOfTheWeek from officehours oh where oh.dieticianID = new.dieticianID)) or

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

-- Dump completed on 2017-02-17  0:00:37
