-- MySQL dump 10.13  Distrib 5.6.35, for osx10.9 (x86_64)
--
-- Host: 127.0.0.1    Database: 3dprint_workshop
-- ------------------------------------------------------
-- Server version	5.6.35

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
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(20) DEFAULT NULL,
  `printer_type` varchar(20) DEFAULT NULL,
  `printer_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `in_use` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` (`id`, `serial_no`, `printer_type`, `printer_status`, `created_at`, `updated_at`, `in_use`) VALUES (1,'63514','UP!','Available','2014-01-01 14:08:00','2018-01-10 11:10:37',0),(2,'63116','UP!','Available','2014-01-01 14:08:00','2017-11-29 14:36:44',0),(3,'82953','UP Plus 2','Available','2014-01-05 14:08:21','2017-11-30 16:30:13',0),(4,'83908','UP Plus 2','Available','2014-01-05 14:08:21','2018-01-10 13:43:03',0),(5,'83906','UP Plus 2','Missing','2014-01-05 14:08:21',NULL,0),(6,'80151','UP Plus 2','Broken','2014-01-01 14:08:00','2017-10-07 16:02:19',0),(7,'80210','UP Plus 2','Missing','2014-01-01 14:08:00','2017-10-07 16:08:25',0),(8,'80211','UP Plus 2','Missing','2014-01-01 14:08:00','2017-08-30 11:12:43',0),(9,'80213','UP Plus 2','Available','2014-01-01 14:08:00','2017-12-06 11:59:53',0),(10,'80265','UP Plus 2','Missing','2014-01-05 14:08:21','2017-08-30 11:14:08',0),(11,'80215','UP Plus 2','Available','2014-01-01 14:08:00',NULL,0),(12,'80222','UP Plus 2','Broken','2014-01-01 14:08:00',NULL,0),(13,'80233','UP Plus 2','Available','2014-01-01 14:08:00','2017-12-06 13:31:04',0),(14,'80261','UP Plus 2','Missing','2014-01-01 14:08:00','2017-08-30 12:47:25',0),(15,'80214','UP Plus 2','Broken','2014-01-01 14:08:00','2017-10-07 17:23:05',0),(16,'82908','UP Plus 2','Broken','2014-01-05 14:08:21','2017-08-23 13:01:20',0),(17,'84071','UP Plus 2','Available','2015-02-11 14:09:51','2017-11-12 16:52:42',0),(18,'84788','UP Plus 2','Available','2015-02-11 14:09:51','2017-12-13 11:24:40',0),(19,'83971','UP Plus 2','Available','2014-01-05 14:08:21','2018-01-10 12:25:36',0),(20,'84097','UP Plus 2','Available','2015-02-11 14:09:51','2017-11-29 12:29:43',0),(21,'63120','UP!','Available','2014-01-01 14:08:00','2017-11-29 15:45:02',0),(22,'84047','UP Plus 2','Available','2015-02-11 14:09:51','2018-01-10 11:15:06',0),(23,'82945','UP Plus 2','Available','2014-01-05 14:08:21','2018-01-10 11:13:08',0),(24,'503039','UP BOX','Broken','2015-06-17 13:11:20','2017-08-09 08:57:24',0),(25,'503041','UP BOX','Signed out','2015-06-17 13:11:20',NULL,0),(26,'503063','UP BOX','Missing','2015-06-17 13:11:20','2018-01-10 13:51:54',0),(27,'503086','UP BOX','Signed out','2015-06-17 13:11:20',NULL,0),(28,'503090','UP BOX','Available','2015-06-17 13:11:20','2017-08-30 14:34:34',0),(29,'508733','UP BOX','Broken','2016-02-24 14:12:37','2017-08-09 09:03:59',0),(30,'508579','UP BOX','Available','2016-02-24 14:12:37','2017-11-08 10:33:42',0),(31,'508611','UP BOX','Missing','2016-02-24 14:12:37','2018-01-10 13:52:54',0),(32,'656000007-2','Malyan M200','Available',NULL,'2018-01-05 12:16:44',0);
/*!40000 ALTER TABLE `printers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-12 14:13:28
