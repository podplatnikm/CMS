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
-- Table structure for table `projekt_sodelujoci`
--

DROP TABLE IF EXISTS `projekt_sodelujoci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projekt_sodelujoci` (
  `idprojekt_sodelujoci` int(11) NOT NULL AUTO_INCREMENT,
  `tk_idprojekt` int(11) NOT NULL,
  `tk_idsodelujoci` int(11) NOT NULL,
  `stevilo_ur` int(11) NOT NULL,
  `naziv_dela` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idprojekt_sodelujoci`)
) ENGINE=MyISAM AUTO_INCREMENT=35126 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projekt_sodelujoci`
--

LOCK TABLES `projekt_sodelujoci` WRITE;
/*!40000 ALTER TABLE `projekt_sodelujoci` DISABLE KEYS */;
INSERT INTO `projekt_sodelujoci` VALUES (3,9,19,10,'Zbiratelj prijavnin in zreb'),(4,9,18,20,'Tekoča dela tekom lige'),(5,9,16,15,'Vsa Operativna dela'),(8,11,31,200,'Frontend'),(9,11,30,300,'Backend'),(10,12,22,70,'Oblikovanje in mastering'),(11,12,23,50,'Vse ostalo'),(12,12,26,50,'Mailto guy'),(13,12,30,50,'Vodja, vse'),(14,13,27,25,'Direktor grafike'),(15,13,24,40,'Vodja razvoja'),(16,13,25,80,'Kodiranje'),(17,14,29,200,'Dizajn'),(18,14,20,50,'Podpora in finiširanje'),(35125,14624,26,12,'sdfgsdfg'),(35124,14623,27,256,'Ostala dela 2'),(35123,14623,26,263,'Ostala dela 1'),(35122,14623,24,288,'UX master'),(35121,14623,23,250,'Dizajn'),(35120,14623,22,204,'Testiranje 2'),(35119,14623,21,240,'Testiranje 1'),(35118,14623,16,295,'Oblikovanje in mastering'),(35117,14623,19,285,'Vodja pogajanj'),(35116,14623,18,211,'Vodja razvoja'),(35115,14623,20,254,'Vodja dogovorov'),(35114,14622,30,299,'Developer'),(35113,14622,18,418,'PostProdukcija'),(35112,14622,27,349,'Producent'),(35111,14622,21,214,'Scenarist'),(35110,14622,31,452,'Dizajn'),(35109,14622,32,345,'Lučkar'),(35108,14622,19,239,'Vodja snemanja'),(35107,14621,23,40,'Dizajn'),(35106,14621,28,70,'Backend'),(35105,14621,31,60,'Frontend'),(35104,14620,29,50,'Odgovorni urednik'),(35103,14620,21,300,'Developer'),(35102,14619,28,331,'Testiranje'),(35101,14619,20,413,'Nadzor'),(35100,14619,18,287,'Oblikovanje'),(35099,14619,26,247,'Finiširanje'),(35098,14619,22,443,'Vodja predaje'),(35097,14619,29,457,'Vodja razvoja'),(35096,14619,27,369,'Vodja dogovorov'),(35095,14618,23,290,'Backend'),(35094,14618,24,270,'Dizajn'),(35093,14618,25,250,'UX master'),(35092,14617,27,50,'Finisiranje'),(35091,14617,32,250,'Razvoj'),(35090,14616,19,120,'Vodja razvoja'),(35088,14616,16,100,'Manager dogodkov'),(35089,14616,18,75,'Oblikovanje in mastering');
/*!40000 ALTER TABLE `projekt_sodelujoci` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-09 20:26:32
