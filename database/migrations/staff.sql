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
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `role` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `role`, `updated_at`, `user_id`, `id_number`) VALUES (1,'Apostolos','Grammatikopoulos','ag3e15@soton.ac.uk','075819298485','2017-03-26 17:26:11','Demonstrator',NULL,NULL,NULL),(2,'Chee','Hong Goh','chg1g13@soton.ac.uk','07851925072','2017-03-26 17:26:11','Demonstrator',NULL,NULL,NULL),(4,'Erato','Kartaki','ek2e14@soton.ac.uk','07518990594','2017-03-26 17:26:11','Demonstrator',NULL,NULL,NULL),(5,'Fulin ','Xie','fx1g12@soton.ac.uk','unknown','2017-03-26 17:26:11','unknown',NULL,NULL,NULL),(6,'Gianluca ','Cidonio','gc3e15@soton.ac.uk','unknown','2017-03-26 17:26:11','Lead Demonstrator',NULL,NULL,NULL),(7,'Jing  ','Tang','jt7g13@soton.ac.uk','07403797321','2017-03-26 17:26:11','Technical Manager',NULL,NULL,NULL),(8,'Katherine','Crawford','K.A.Crawford@soton.ac.uk','07510838851','2017-03-26 17:26:11','Demonstrator',NULL,NULL,NULL),(9,'Lasse','Wollatz','L.Wollatz@soton.ac.uk','07418432954','2017-03-26 17:26:11','IT Manager',NULL,NULL,NULL),(10,'Luke','Muscutt','L.Muscutt@soton.ac.uk','07723325834','2017-03-26 17:26:11','PR Manager',NULL,NULL,NULL),(11,'Manuel','Ferreira','maf1v15@soton.ac.uk','unknown','2017-08-01 15:49:56','Demonstrator',NULL,NULL,NULL),(12,'Matt','Potticary','m.potticary@soton.ac.uk','07972298383','2017-03-26 17:26:11','Demonstrator',NULL,NULL,NULL),(13,'Patrick','Fenou Kengne','plfk1g13@soton.ac.uk','07729280929','2017-03-26 17:26:11','3D Hub Manager',NULL,NULL,NULL),(14,'Shenglong','Zhou','sz3g14@soton.ac.uk','07519533874','2017-07-31 11:04:55','Demonstrator',NULL,9,NULL),(15,'Yu','Pui-Hei','phy1g13@soton.ac.uk','unknown','2017-08-04 12:53:29','unknown',NULL,8,NULL),(16,'Svitlana','Braichenko','sb2g14@soton.ac.uk','07479052411','2017-07-31 11:04:55','IT','2017-07-29 17:41:02',5,NULL),(17,'Andrii','Iakovliev','ai1v14@soton.ac.uk','07479045846','2017-07-31 11:04:55','IT','2017-07-30 11:08:23',6,NULL),(18,'Hayk','Vasilyan','h.vasilyan@soton.ac.uk','unknown','2017-08-01 15:49:56','IT','2017-07-23 16:54:31',7,12345678),(19,'Charalambos ','Rossides','c.rossides@soton.ac.uk','07544336771','2017-08-01 15:33:39','Demonstrator','2017-08-01 15:34:02',NULL,NULL),(20,'Chris','Malcolm','C.Malcom@soton.ac.uk','unknown','2017-08-04 12:53:29','Technician','2017-08-01 15:36:02',NULL,NULL),(21,'Daniel','Wallace','djw1g12@soton.ac.uk','07948683455','2017-08-01 15:42:39','Demonstrator','2017-08-01 15:37:31',NULL,NULL),(22,'Dr. Shoufeng','Yang','s.yang@soton.ac.uk','unknown','2017-08-01 15:39:08','Coordinator',NULL,NULL,NULL),(23,'Dr. Tim','Woolman','T.Woolman@soton.ac.uk','2380592844','2017-08-01 15:42:39','Co-Coordinator',NULL,NULL,NULL),(24,'Gerardo','Espindola','Gerardo.Espindola@soton.ac.uk','07477313948','2017-08-01 15:42:39','Demonstrator',NULL,NULL,NULL),(25,'Horacio','Rodriguez','hafr1g13@soton.ac.uk','07472080461','2017-08-01 15:43:42','Demonstrator',NULL,NULL,NULL),(27,'Hossam','Ragheb','har1g15@soton.ac.uk','07413734010','2017-08-01 15:45:59','Demonstrator',NULL,NULL,NULL),(28,'Jennifer','Bramley','j.l.bramley@soton.ac.uk','07896217552','2017-08-01 15:45:59','Demonstrator',NULL,NULL,NULL),(29,'Shahir','Yusuf','symy1g12@soton.ac.uk','07707994194','2017-08-01 15:49:56','Demonstrator',NULL,NULL,NULL),(31,'Takfarinas','Medjnoun','tm1y13@soton.ac.uk ','07440396813','2017-08-04 12:53:29','Demonstrator',NULL,NULL,27293629),(32,'Andrew','Everitt','notknown@soton.ac.uk','07477392223','2017-08-04 12:53:29','3D Hub Assistant',NULL,NULL,NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-04 13:57:52
