-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: projektopia
-- ------------------------------------------------------
-- Server version	5.7.14

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
-- Table structure for table `strosek`
--

DROP TABLE IF EXISTS `strosek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `strosek` (
  `idStrosek` int(11) NOT NULL AUTO_INCREMENT,
  `tk_idprojekt` int(11) NOT NULL,
  `ime` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `dejanski_strosek` int(11) NOT NULL,
  PRIMARY KEY (`idStrosek`)
) ENGINE=MyISAM AUTO_INCREMENT=24887 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `strosek`
--

LOCK TABLES `strosek` WRITE;
/*!40000 ALTER TABLE `strosek` DISABLE KEYS */;
INSERT INTO `strosek` VALUES (9,9,'Ostali stroski',150),(8,9,'Zreb - pogostitev',100),(7,9,'Najem telovadnice',300),(13,11,'Plače',5000),(14,11,'Dodatna oprema',800),(15,11,'Tekoči stroški',1000),(16,12,'Teambuilding',20),(17,12,'Hrana',50),(18,12,'Oprema',100),(19,13,'Plače',2000),(20,13,'Plakati',30),(21,13,'Grafična oprema in materijali',200),(22,14,'Testni printi',150),(23,14,'Špricari',20),(24,14,'Potni stroški',60),(24886,14624,'sdfgsdfgsd',-50),(24885,14624,'dfsgsdf',100),(24884,14623,'Sekundarni',20000),(24883,14623,'Generali',50000),(24882,14622,'Ostali',1000),(24881,14622,'Najemi',3000),(24880,14622,'Oprema',5000),(24879,14622,'Plače',18000),(24878,14621,'Ostali',300),(24877,14621,'Plače',2000),(24876,14620,'Ostali',300),(24875,14620,'Plače',3000),(24874,14619,'Ostali',1500),(24873,14619,'Računovodstvo',2000),(24872,14619,'Potni stroški',600),(24871,14619,'Oprema',3000),(24870,14619,'Teambuilding',1500),(24869,14619,'Najem testerskega podjetja',2000),(24868,14619,'Plače',30000),(24867,14619,'outsourcing',2000),(24866,14618,'Podnajemniki',1500),(24865,14618,'Sestanki',150),(24864,14618,'Testiranje',400),(24863,14618,'Zaključek',150),(24862,14618,'Teambuilding',500),(24861,14618,'Plače',9000),(24860,14617,'Potni stroski',100),(24859,14617,'Meetingi',250),(24858,14616,'Ostalo',125),(24857,14616,'Sestanki',50),(24856,14616,'Oprema',200),(24855,14616,'Plače',5000);
/*!40000 ALTER TABLE `strosek` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-09 20:26:25
