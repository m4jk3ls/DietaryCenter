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
-- Table structure for table `aktywne_sesje`
--

DROP TABLE IF EXISTS `aktywne_sesje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aktywne_sesje` (
  `Numer ID` int(10) unsigned NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Adres IP` varchar(30) DEFAULT NULL,
  `Przeglądarka` varchar(100) DEFAULT NULL,
  `Data i czas` datetime DEFAULT NULL,
  `Token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aktywne_sesje`
--

LOCK TABLES `aktywne_sesje` WRITE;
/*!40000 ALTER TABLE `aktywne_sesje` DISABLE KEYS */;
/*!40000 ALTER TABLE `aktywne_sesje` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badania_posrednie`
--

DROP TABLE IF EXISTS `badania_posrednie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `badania_posrednie` (
  `id_badPosrednie` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pacjent` int(10) unsigned NOT NULL,
  `dataBadania` date NOT NULL,
  `masaCiala_kg` float unsigned NOT NULL,
  `procentTluszczu` int(3) unsigned NOT NULL,
  `procentWody` int(3) unsigned NOT NULL,
  `wskaznikBMI` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id_badPosrednie`),
  KEY `badania_posrednie_ibfk_1` (`id_pacjent`),
  CONSTRAINT `badania_posrednie_ibfk_1` FOREIGN KEY (`id_pacjent`) REFERENCES `pacjent` (`id_pacjent`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badania_posrednie`
--

LOCK TABLES `badania_posrednie` WRITE;
/*!40000 ALTER TABLE `badania_posrednie` DISABLE KEYS */;
/*!40000 ALTER TABLE `badania_posrednie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dietetyk`
--

DROP TABLE IF EXISTS `dietetyk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dietetyk` (
  `id_dietetyk` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_uzytkownik` int(10) unsigned NOT NULL,
  `id_wiecej_info` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_dietetyk`),
  UNIQUE KEY `id_uzytkownik` (`id_uzytkownik`),
  UNIQUE KEY `id_wiecej_info` (`id_wiecej_info`),
  CONSTRAINT `dietetyk_ibfk_1` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownik` (`id_uzytkownik`) ON UPDATE CASCADE,
  CONSTRAINT `dietetyk_ibfk_2` FOREIGN KEY (`id_wiecej_info`) REFERENCES `wiecej_info_dietetyk` (`id_wiecej_info`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dietetyk`
--

LOCK TABLES `dietetyk` WRITE;
/*!40000 ALTER TABLE `dietetyk` DISABLE KEYS */;
/*!40000 ALTER TABLE `dietetyk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `godziny_przyjec`
--

DROP TABLE IF EXISTS `godziny_przyjec`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `godziny_przyjec` (
  `id_godzinyPrzyjec` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_dietetyk` int(10) unsigned NOT NULL,
  `dzienTygodnia` int(1) unsigned NOT NULL,
  `godz_od` time NOT NULL,
  `godz_do` time NOT NULL,
  PRIMARY KEY (`id_godzinyPrzyjec`),
  KEY `id_dietetyk` (`id_dietetyk`),
  CONSTRAINT `godziny_przyjec_ibfk_1` FOREIGN KEY (`id_dietetyk`) REFERENCES `dietetyk` (`id_dietetyk`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `godziny_przyjec`
--

LOCK TABLES `godziny_przyjec` WRITE;
/*!40000 ALTER TABLE `godziny_przyjec` DISABLE KEYS */;
/*!40000 ALTER TABLE `godziny_przyjec` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logowanie_archiwum`
--

DROP TABLE IF EXISTS `logowanie_archiwum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logowanie_archiwum` (
  `Numer ID` int(10) unsigned NOT NULL,
  `Login` varchar(30) NOT NULL,
  `Adres IP` varchar(30) DEFAULT NULL,
  `Przeglądarka` varchar(100) DEFAULT NULL,
  `Data i czas` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logowanie_archiwum`
--

LOCK TABLES `logowanie_archiwum` WRITE;
/*!40000 ALTER TABLE `logowanie_archiwum` DISABLE KEYS */;
/*!40000 ALTER TABLE `logowanie_archiwum` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pacjent`
--

DROP TABLE IF EXISTS `pacjent`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pacjent` (
  `id_pacjent` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_uzytkownik` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_pacjent`),
  UNIQUE KEY `id_uzytkownik` (`id_uzytkownik`),
  CONSTRAINT `pacjent_ibfk_1` FOREIGN KEY (`id_uzytkownik`) REFERENCES `uzytkownik` (`id_uzytkownik`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pacjent`
--

LOCK TABLES `pacjent` WRITE;
/*!40000 ALTER TABLE `pacjent` DISABLE KEYS */;
/*!40000 ALTER TABLE `pacjent` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesja`
--

DROP TABLE IF EXISTS `profesja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesja` (
  `id_profesja` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_dietetyk` int(10) unsigned DEFAULT NULL,
  `nazwa` varchar(100) NOT NULL,
  PRIMARY KEY (`id_profesja`),
  KEY `id_dietetyk` (`id_dietetyk`),
  CONSTRAINT `profesja_ibfk_1` FOREIGN KEY (`id_dietetyk`) REFERENCES `dietetyk` (`id_dietetyk`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesja`
--

LOCK TABLES `profesja` WRITE;
/*!40000 ALTER TABLE `profesja` DISABLE KEYS */;
/*!40000 ALTER TABLE `profesja` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suplement`
--

DROP TABLE IF EXISTS `suplement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suplement` (
  `id_suplement` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(100) NOT NULL,
  `cena` float NOT NULL,
  PRIMARY KEY (`id_suplement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suplement`
--

LOCK TABLES `suplement` WRITE;
/*!40000 ALTER TABLE `suplement` DISABLE KEYS */;
/*!40000 ALTER TABLE `suplement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uzytkownik`
--

DROP TABLE IF EXISTS `uzytkownik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uzytkownik` (
  `id_uzytkownik` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imie` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(30) NOT NULL,
  `login` varchar(30) NOT NULL,
  `haslo` text NOT NULL,
  `salt` varchar(10) NOT NULL,
  PRIMARY KEY (`id_uzytkownik`),
  UNIQUE KEY `login` (`login`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uzytkownik`
--

LOCK TABLES `uzytkownik` WRITE;
/*!40000 ALTER TABLE `uzytkownik` DISABLE KEYS */;
/*!40000 ALTER TABLE `uzytkownik` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wiecej_info_dietetyk`
--

DROP TABLE IF EXISTS `wiecej_info_dietetyk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiecej_info_dietetyk` (
  `id_wiecej_info` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pesel` varchar(20) NOT NULL,
  `dataUrodzenia` date NOT NULL,
  `telefon` varchar(20) NOT NULL,
  `ulica` varchar(30) DEFAULT NULL,
  `nrBudynku` varchar(10) NOT NULL,
  `nrLokalu` varchar(10) DEFAULT NULL,
  `miejscowosc` varchar(30) NOT NULL,
  `kodPocztowy` varchar(10) NOT NULL,
  `poczta` varchar(30) NOT NULL,
  PRIMARY KEY (`id_wiecej_info`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wiecej_info_dietetyk`
--

LOCK TABLES `wiecej_info_dietetyk` WRITE;
/*!40000 ALTER TABLE `wiecej_info_dietetyk` DISABLE KEYS */;
/*!40000 ALTER TABLE `wiecej_info_dietetyk` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER centrum_dietetyczne.sprawdzanieDatyUrodzenia_dietetyk

	BEFORE INSERT

	ON centrum_dietetyczne.wiecej_info_dietetyk

	FOR EACH ROW

begin





	if NEW.dataUrodzenia > curdate()	





	then





		signal sqlstate '45000'





		set message_text = 'Data urodzenia jest nieprawidlowa';





	end if;





end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `wizyta`
--

DROP TABLE IF EXISTS `wizyta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wizyta` (
  `id_wizyta` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pacjent` int(10) unsigned NOT NULL,
  `id_dietetyk` int(10) unsigned NOT NULL,
  `id_suplement` int(10) unsigned DEFAULT NULL,
  `dataWizyty` date NOT NULL,
  `cenaWizyty_zl` float unsigned NOT NULL,
  `godzinaWizyty` time NOT NULL,
  PRIMARY KEY (`id_wizyta`),
  KEY `id_pacjent` (`id_pacjent`),
  KEY `id_dietetyk` (`id_dietetyk`),
  KEY `id_suplement` (`id_suplement`),
  CONSTRAINT `wizyta_ibfk_1` FOREIGN KEY (`id_pacjent`) REFERENCES `pacjent` (`id_pacjent`) ON UPDATE CASCADE,
  CONSTRAINT `wizyta_ibfk_2` FOREIGN KEY (`id_dietetyk`) REFERENCES `dietetyk` (`id_dietetyk`) ON UPDATE CASCADE,
  CONSTRAINT `wizyta_ibfk_3` FOREIGN KEY (`id_suplement`) REFERENCES `suplement` (`id_suplement`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wizyta`
--

LOCK TABLES `wizyta` WRITE;
/*!40000 ALTER TABLE `wizyta` DISABLE KEYS */;
/*!40000 ALTER TABLE `wizyta` ENABLE KEYS */;
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
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger dostepnoscDietetyka before insert on wizyta





for each row





begin





    if(((select dayofweek(new.dataWizyty)) !=





        (select gp.dzienTygodnia from godziny_przyjec gp where gp.id_dietetyk = new.id_dietetyk)) or





            (select new.godzinaWizyty < (select godz_od from godziny_przyjec)) or





                (select new.godzinaWizyty > (select godz_do from godziny_przyjec)))





    then





        signal sqlstate '45000'





        set message_text = 'Dietetyk nie dyzuruje w podany dzien i o podanej godzinie';





    end if;





end */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `wizyta_archiwum`
--

DROP TABLE IF EXISTS `wizyta_archiwum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wizyta_archiwum` (
  `id_wizyta_archiwum` int(10) unsigned NOT NULL,
  `id_pacjent` int(10) unsigned NOT NULL,
  `id_dietetyk` int(10) unsigned NOT NULL,
  `id_suplement` int(10) unsigned DEFAULT NULL,
  `dataWizyty` date NOT NULL,
  `cenaWizyty_zl` float unsigned NOT NULL,
  `godzinaWizyty` time NOT NULL,
  KEY `id_pacjent` (`id_pacjent`),
  KEY `id_dietetyk` (`id_dietetyk`),
  KEY `id_suplement` (`id_suplement`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
/*!50100 PARTITION BY HASH (year(dataWizyty))
PARTITIONS 4 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wizyta_archiwum`
--

LOCK TABLES `wizyta_archiwum` WRITE;
/*!40000 ALTER TABLE `wizyta_archiwum` DISABLE KEYS */;
/*!40000 ALTER TABLE `wizyta_archiwum` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-28 21:00:00
