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
-- Table structure for table `karakteristike_sodelujoci`
--

DROP TABLE IF EXISTS `karakteristike_sodelujoci`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karakteristike_sodelujoci` (
  `idkarakteristike_sodelujoci` int(11) NOT NULL AUTO_INCREMENT,
  `tk_id_sodelujoci` int(11) NOT NULL,
  `tk_id_karakteristike` int(11) NOT NULL,
  PRIMARY KEY (`idkarakteristike_sodelujoci`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karakteristike_sodelujoci`
--

LOCK TABLES `karakteristike_sodelujoci` WRITE;
/*!40000 ALTER TABLE `karakteristike_sodelujoci` DISABLE KEYS */;
INSERT INTO `karakteristike_sodelujoci` VALUES (16,16,18),(15,16,9),(14,16,7),(13,16,5),(17,17,5),(18,17,7),(19,17,9),(20,17,18),(21,18,2),(22,18,4),(23,18,8),(24,18,12),(25,18,18),(26,19,4),(27,19,6),(28,19,7),(29,19,8),(30,19,14),(31,19,16),(32,20,1),(33,20,2),(34,20,3),(35,20,10),(36,20,11),(37,20,13),(38,20,16),(39,21,3),(40,21,5),(41,21,10),(42,21,13),(43,21,14),(44,21,16),(45,21,18),(46,22,1),(47,22,4),(48,22,6),(49,22,7),(50,22,9),(51,22,17),(52,23,1),(53,23,2),(54,23,3),(55,23,7),(56,23,8),(57,23,9),(58,23,13),(59,23,17),(60,24,3),(61,24,4),(62,24,5),(63,24,6),(64,24,8),(65,24,10),(66,24,11),(67,24,15),(68,24,18),(69,25,2),(70,25,3),(71,25,4),(72,25,6),(73,25,7),(74,25,9),(75,25,14),(76,25,16),(77,25,18),(78,26,1),(79,26,2),(80,26,3),(81,26,4),(82,26,6),(83,26,7),(84,26,10),(85,26,18),(86,27,1),(87,27,2),(88,27,4),(89,27,7),(90,27,10),(91,27,13),(92,27,14),(93,27,16),(94,28,2),(95,28,4),(96,28,5),(97,28,7),(98,28,8),(99,28,10),(100,28,11),(101,28,13),(102,29,1),(103,29,2),(104,29,4),(105,29,7),(106,29,8),(107,29,12),(108,29,14),(109,29,16),(110,30,7),(111,30,8),(112,30,10),(113,30,13),(114,30,14),(115,30,15),(116,30,18),(117,31,1),(118,31,2),(119,31,3),(120,31,4),(121,31,6),(122,31,7),(123,31,8),(124,31,13),(125,31,16),(126,31,17),(127,31,18),(128,32,4),(129,32,5),(130,32,7),(131,32,8),(132,32,10),(133,32,11),(134,32,13);
/*!40000 ALTER TABLE `karakteristike_sodelujoci` ENABLE KEYS */;
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
