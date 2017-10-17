-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (armv7l)
--
-- Host: localhost    Database: 3dprint_workshop
-- ------------------------------------------------------
-- Server version	5.5.57-0+deb8u1

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
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,1,'This is the initial production version of the Workshop online managing application. This version still has multiple bugs and the first update intended to resolve most of them will soon be released. In the meantime, you are kindly asked to test the application as much as possible and report any noticed bugs to the development team using email addresses provided in the footer. We are looking forward to your feedback!','2017-08-03 19:17:02','2017-08-03 19:17:02'),(3,1,'Students should fill their details on the website and request jobs.\r\nThey should NOT start the print until you accept the job!\r\nAs they won’t be aware of this new procedure, please do point them at the website as they get to the workshop!','2017-08-04 18:46:15','2017-08-04 18:46:15'),(4,1,'The statuses of all printers and issues associated with them have been brought into order with the current state of affairs. There is one exception with printer 7 though. \r\n\r\nWe have also introduced access to the website using encrypted protocol https. In order to start using it type https://3dprint.clients.soton.ac.uk and proceed by ignoring all warnings, that your web browser might issue.','2017-10-08 20:10:18','2017-10-08 20:10:18');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `posts_id` int(11) NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (12,16,151,'Hot end was blocked - exchanged heater block and nozzle with a set from the acetone jar. Tested, fully working.','2017-08-23 12:40:16','2017-08-23 12:40:16'),(13,16,146,'Printer is working. Leaving ticket on system for now so IT can resolve issue with date stamping. Days out of order stated negative 70 as of 23.08.17.','2017-08-23 12:48:06','2017-08-23 12:48:06'),(14,16,146,'Printer had been fixed in the interim between entering into the old system and finding it on the new system. Logged by Daniel Wallace (as was the last update, although it says T. Medjnoun!)','2017-08-23 12:54:12','2017-08-23 12:54:12'),(15,16,147,'Printer fixed before today but not logged as such. Tested fully working','2017-08-23 12:58:37','2017-08-23 12:58:37'),(16,16,25,'Printer has been cannibalised for parts. Currently missing extruder assembly and one levelling screw','2017-08-23 13:00:27','2017-08-23 13:00:27'),(17,16,141,'Printer has been cannibalised for parts. No extruder assembly or bed.','2017-08-23 13:03:52','2017-08-23 13:03:52'),(18,16,25,'Printer no longer in cupboard','2017-08-30 11:10:06','2017-08-30 11:10:06'),(19,16,153,'Old screw removed, new one fitted','2017-08-30 13:55:53','2017-08-30 13:55:53'),(20,13,129,'Replaced extruder PCB and ribbon cable. White ribbon cable had 2 bent pins which were unbent.','2017-08-30 14:34:34','2017-08-30 14:34:34'),(21,13,156,'Working extruder assembly tested in printer including rainbow ribbon cable, did not fix issue. Therefore it is not the thermistor.','2017-10-10 10:32:16','2017-10-10 10:32:16');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cost_codes`
--

DROP TABLE IF EXISTS `cost_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost_codes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shortage` varchar(15) NOT NULL,
  `cost_code` int(11) NOT NULL,
  `aproving_member_of_staff` varchar(15) NOT NULL,
  `expires` date NOT NULL,
  `holder` varchar(15) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_codes`
--

LOCK TABLES `cost_codes` WRITE;
/*!40000 ALTER TABLE `cost_codes` DISABLE KEYS */;
INSERT INTO `cost_codes` VALUES (1,'FEEG1001-AERO',510671104,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(2,'FEEG1001-MECH',510671108,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 12:10:49',NULL),(3,'FEEG2001-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(4,'FEEG2001-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(5,'FEEG2001-MECH',510312110,'Tim Woolman','2017-09-27','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL),(6,'FEEG6013-ACOU',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(7,'FEEG6013-AMAT',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(8,'FEEG6013-AERO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(9,'FEEG6013-AUTO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(10,'FEEG6013-BIOM',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(11,'FEEG6013-CIVI',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(12,'FEEG6013-INTE',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(13,'FEEG6013-MANA',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(14,'FEEG6013-MECH',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(15,'FEEG6013-SPAC',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(16,'FEEG6013-ENRG',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(17,'FEEG6013-MARI',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(18,'FEEG6013-SHIP',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(19,'FEEG6013-YACH',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(20,'FEEG6013-KEAN',510667102,'Tim Woolman','2017-09-27','Andrew Keane','FEE Group Design Projects Andrew Keane','2017-05-07 12:10:49',NULL),(21,'FEEG3003-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(22,'FEEG3003-AUDI',510671103,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Audiology','2017-05-07 12:10:49',NULL),(23,'FEEG3003-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(24,'FEEG3003-CIVI',510671105,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Civil and Environmental','2017-05-07 12:10:49',NULL),(25,'FEEG3003-ENER',510671106,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Energy','2017-05-07 12:10:49',NULL),(26,'FEEG3003-ENVI',510671107,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Environmental Science','2017-05-07 12:10:49',NULL),(27,'FEEG3003-MECH',510671108,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 12:10:49',NULL),(28,'FEEG3003-MARI',510671109,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Maritime Engineering','2017-05-07 12:10:49',NULL),(29,'SPEAKER',510671102,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(30,'UAV',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(31,'QUADCOPTER',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(32,'EUROBOT',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL),(33,'RESPSYS',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL),(34,'Demonstrator',515665101,'Shoufeng Yang','2017-09-22','Shoufeng Yang',NULL,'2017-07-28 11:37:39',NULL),(35,'Francesco Giorg',516228101,'Andrew Everitt','0000-00-00','','personal cost code','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `cost_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fault_datas`
--

DROP TABLE IF EXISTS `fault_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fault_datas` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `printers_id` int(11) NOT NULL,
  `serial_number` int(9) NOT NULL,
  `users_id_created_issue` int(11) DEFAULT NULL,
  `printer_status` text,
  `users_id_resolved_issue` int(11) DEFAULT NULL,
  `body` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `title` text,
  `users_name_created_issue` text,
  `users_name_resolved_issue` text,
  `resolved` tinyint(1) NOT NULL DEFAULT '0',
  `days_out_of_order` int(11) DEFAULT '0',
  `message_resolved` text,
  `Date` text,
  `Repair_Date` text,
  PRIMARY KEY (`id`),
  KEY `fault_datas_printers__fk` (`printers_id`),
  CONSTRAINT `fault_datas_printers__fk` FOREIGN KEY (`printers_id`) REFERENCES `printers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_datas`
--

LOCK TABLES `fault_datas` WRITE;
/*!40000 ALTER TABLE `fault_datas` DISABLE KEYS */;
INSERT INTO `fault_datas` VALUES (1,9,80213,NULL,'Broken',NULL,'','2017-08-01 12:56:12','0000-00-00 00:00:00',NULL,'J. Van der Kindere','C. Cooper',1,5,'','11/02/2015','16/02/2015'),(2,10,80265,NULL,'Broken',NULL,'','2017-08-01 12:56:13','0000-00-00 00:00:00',NULL,'C. Cooper','F. Zhang',1,7,'','16/02/2015','23/02/2015'),(3,15,80214,NULL,'Broken',NULL,'extruder assembly missing (previous note: Loose platform support on the right guide of the structure for printer 15 \"15/05/2014\")','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Van der Kindere','L. Muscutt',1,392,'','11/02/2015','09/03/2016'),(4,19,83971,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Van der Kindere',1,7,'','16/02/2015','23/02/2015'),(5,5,83906,NULL,'Missing',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Van der Kindere','D. Newman',1,30,'found to be on loan','10/02/2015','12/03/2015'),(6,7,80210,NULL,'Missing',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Van der Kindere','L. Wollatz',1,141,'Was returned to Chris - probably the one previously used for software test in B25','10/02/2015','01/07/2015'),(7,14,80261,NULL,'Missing',NULL,'with professor?','2017-10-07 17:18:11','2015-02-10 00:00:00',NULL,'J. Van der Kindere','',0,892,'',NULL,''),(8,21,63120,NULL,'Missing',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','S. Yang',1,7,'found to be on loan','20/02/2015','27/02/2015'),(9,6,80151,NULL,'Broken',NULL,'Faulty extruder motor','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'','',1,9,'','23/02/2015','04/03/2015'),(10,4,83908,NULL,'Broken',NULL,'nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','J. Van der Kindere',1,0,'','23/02/2015','23/02/2015'),(11,3,82953,NULL,'Broken',NULL,'nozzle only extruding from maintenance','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','J. Van der Kindere',1,0,'','23/02/2015','23/02/2015'),(12,2,63116,NULL,'Broken',NULL,'nozzle blocked- put in filament','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','D. Newman',1,0,'','02/03/2015','02/03/2015'),(13,4,83908,NULL,'Broken',NULL,'User spoke to Shoufeng - apparently working but sparks. Needs proper maintenance','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','T. Standen',1,0,'','04/03/2015','04/03/2015'),(14,9,80213,NULL,'Broken',NULL,'Nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','S. Mestry',1,5,'','04/03/2015','09/03/2015'),(15,10,80265,NULL,'Broken',NULL,'Nozzle blocked (nozzel assembly missing!)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'W. Keum','J. Tang',1,51,'','09/03/2015','29/04/2015'),(16,18,84788,NULL,'Broken',NULL,'Nozzle broken (nozzle assembly missing!)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'W. Keum','J. Tang',1,58,'','09/03/2015','06/05/2015'),(17,3,82953,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','D. Newman',1,2,'','09/03/2015','11/03/2015'),(18,9,80213,NULL,'Broken',NULL,'Nozzle Blocked- PLA','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Van der Kindere','J. Van der Kindere',1,2,'clogged nozzle','09/03/2015','11/03/2015'),(19,12,80222,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','T. Standen',1,2,'','09/03/2015','11/03/2015'),(20,19,83971,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Van der Kindere','J. Van der Kindere',1,2,'','09/03/2015','11/03/2015'),(21,3,82953,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'Y. Chen','Y. Chen',1,0,'','11/03/2015','11/03/2015'),(22,17,84071,NULL,'Broken',NULL,'Not extruding properly with ABS (heating issue??)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','D. Newman',1,0,'','11/03/2015','11/03/2015'),(23,17,84071,NULL,'Broken',NULL,'Not printing correctly with ABS, very loud fan, possible heating element issue','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','S. Zhou',1,7,'no problem found','11/03/2015','18/03/2015'),(24,6,80151,NULL,'Broken',NULL,'Printing in very poor quality. ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','J. Van der Kindere',1,0,'Nozzle too big, use with lowest z resoltuion','16/03/2015','16/03/2015'),(25,6,80151,NULL,'Broken',NULL,'Doersn\'t heat up nozzle','2017-10-07 17:15:23','2015-03-16 00:00:00',NULL,'J. Van der Kindere','',0,864,'',NULL,''),(26,21,63120,NULL,'Missing',NULL,'Cooper and I  can\'t find it ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','L. Wollatz',1,117,'Found to be with Maurice Jones','18/03/2015','13/07/2015'),(27,8,80211,NULL,'Broken',NULL,'Nozzle Blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'Y. Chen','J. Van der Kindere',1,7,'wasn\'t broken','25/03/2015','01/04/2015'),(28,13,80233,NULL,'Broken',NULL,'platform too hot - platform temperature shows reading of above 300','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','J. Van der Kindere',1,0,'heating element repaired temporarily','01/04/2015','01/04/2015'),(29,19,83971,NULL,'Broken',NULL,'Nozzle was missing when we started our shift: not logged by anyone else','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','J. Tang',1,28,'','01/04/2015','29/04/2015'),(30,17,84071,NULL,'Broken',NULL,'Blocked nozzle: have put in acetone','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','J. Van der Kindere',1,14,'','01/04/2015','15/04/2015'),(31,13,80233,NULL,'Broken',NULL,'Nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'W. Keum','J. Tang',1,0,'','22/04/2015','22/04/2015'),(32,8,80211,NULL,'Broken',NULL,'Fan problems','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','J. Tang',1,239,'','22/04/2015','17/12/2015'),(33,13,80233,NULL,'Broken',NULL,' wire for powering the platform heating element is burned through - temporary fix from before prevented another shortcut but now again the platform isn\'t heating up...','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','T. Standen',1,170,'','27/04/2015','14/10/2015'),(34,11,80215,NULL,'Broken',NULL,'Nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','A. Duranec',1,7,'','29/04/2015','06/05/2015'),(35,4,83908,NULL,'Broken',NULL,'The board doesnt heat up','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Duranec','Y. Chen',1,14,'','06/05/2015','20/05/2015'),(36,19,83971,NULL,'Broken',NULL,'nozzle broken','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Duranec','J. Tang',1,5,'','06/05/2015','11/05/2015'),(37,12,80222,NULL,'Broken',NULL,'Raft is not attaching to perf board correctly. I\'m not sure if it is because the board is not heating properly or because the nozzle is really dirty (on the exterior) which keeps pulling the raft away. ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','Y. Chen',1,9,'','11/05/2015','20/05/2015'),(38,16,82908,NULL,'Broken',NULL,'Motor making a clunking noise and not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','Y. Chen',1,7,'','13/05/2015','20/05/2015'),(39,2,63116,NULL,'Broken',NULL,'Nozzle is overheating','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','J. Tang',1,0,'fixed','13/05/2015','13/05/2015'),(40,23,82945,NULL,'Broken',NULL,'unaware of issue but marked as broken - please check','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','S. Mestry',1,100,'assumed to be working','01/06/2015','09/09/2015'),(41,11,80215,NULL,'Broken',NULL,'unaware but marked as broken - please check...','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','T. Standen',1,44,'Tested and seemed to be working.','01/06/2015','15/07/2015'),(42,22,84047,NULL,'Broken',NULL,'Nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','T. Standen',1,134,'','02/06/2015','14/10/2015'),(43,17,84071,NULL,'Missing',NULL,'printer was not found in ws this afternoon. No Loan form has been completed','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','L. Wollatz',1,1,'given on loan to rocket GDP but no form filled (people from group said they did so)','09/06/2015','10/06/2015'),(44,28,503090,NULL,'Broken',NULL,'material leaks out of printer','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Yang','J. Tang',1,64,'It is working now','09/06/2015','12/08/2015'),(45,1,63514,NULL,'Missing',NULL,'Printer not found (maybe the one in B25? or on Loan by Mohammed Vaezi?)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','S. Mestry',1,112,'was on Loan','04/03/2015','24/06/2015'),(46,5,83906,NULL,'Missing',NULL,'missing since easter (return from loan by rrnp2g13 to be confirmed) recently spotted in Building 5','2017-10-07 17:12:06','2015-06-14 23:00:00',NULL,'S. Yang','',0,773,'',NULL,''),(47,10,80265,NULL,'Broken',NULL,'PLA Sedimentation in the nozzle ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','T. Standen',1,112,'','24/06/2015','14/10/2015'),(48,19,83971,NULL,'Broken',NULL,'PLA sedimentation in the nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Mestry','T. Standen',1,112,'','24/06/2015','14/10/2015'),(49,18,84788,NULL,'Broken',NULL,'blocked with PLA','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','S. Mestry',1,70,'','01/07/2015','09/09/2015'),(50,20,84097,NULL,'Broken',NULL,'Filament not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','S. Zhou',1,49,'','15/07/2015','02/09/2015'),(51,11,80215,NULL,'Broken',NULL,'Making lots of clicking sounds ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','C. Cooper',1,21,'','12/08/2015','02/09/2015'),(52,11,80215,NULL,'Broken',NULL,'Print failed filament did not lay properly','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'C. Cooper','W. Keum',1,147,'','02/09/2015','27/01/2016'),(53,18,84788,NULL,'Broken',NULL,'Blocked nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','T. Standen',1,8,'','06/10/2015','14/10/2015'),(54,1,63514,NULL,'Broken',NULL,'platform not steady due to movement of platform support rod','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','L. Muscutt',1,26,'','07/10/2015','02/11/2015'),(55,23,82945,NULL,'Broken',NULL,'not connecting properly to the computer','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','T. Standen',1,7,'','07/10/2015','14/10/2015'),(56,17,84071,NULL,'Broken',NULL,'Blocked nozzle (PLA)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','T. Standen',1,7,'','07/10/2015','14/10/2015'),(57,9,80213,NULL,'Broken',NULL,'Blocked nozzle (PLA)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','T. Standen',1,7,'','07/10/2015','14/10/2015'),(58,9,80213,NULL,'Broken',NULL,'Printer withdrawing but not extruding filament. Clicking sound.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,89,'','14/10/2015','11/01/2016'),(59,13,80233,NULL,'Broken',NULL,'Platform not heating properly. Intermittent cable connection issues probably the cause.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','L. Muscutt',1,13,'Platform now heating','20/10/2015','02/11/2015'),(60,4,83908,NULL,'Broken',NULL,'Platform not heating','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','J. Tang',1,7,'','21/10/2015','28/10/2015'),(61,20,84097,NULL,'Broken',NULL,'Motor is broken, filament would not withdraw','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','W. Keum',1,91,'','28/10/2015','27/01/2016'),(62,19,83971,NULL,'Broken',NULL,'Nozzle blocked. ABS. Nozzle in acetone.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','L. Muscutt',1,5,'unblocked nozzle, replaced fan with one from printer 9 which is already broken','28/10/2015','02/11/2015'),(63,19,83971,NULL,'Broken',NULL,'Nozzle blocked and placed in acetone - no replacement nozzle found.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','J. Tang',1,68,'','04/11/2015','11/01/2016'),(64,4,83908,NULL,'Broken',NULL,'Platform not heating','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,68,'','04/11/2015','11/01/2016'),(65,18,84788,NULL,'Broken',NULL,'filament stops extruding after five layers, repeatedly. Extrudes fine in tests.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','S. Zhou',1,14,'','04/11/2015','18/11/2015'),(66,3,82953,NULL,'Broken',NULL,'Step motor broken','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'D. Newman','J. Tang',1,7,'','11/11/2015','18/11/2015'),(67,17,84071,NULL,'Broken',NULL,'Nozzle not heating properly. ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','S. Zhou',1,0,'','18/11/2015','18/11/2015'),(68,1,63514,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','L. Muscutt',1,7,'','02/12/2015','09/12/2015'),(69,2,63116,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,40,'','02/12/2015','11/01/2016'),(70,3,82953,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,40,'','02/12/2015','11/01/2016'),(71,13,80233,NULL,'Broken',NULL,'Blocked Nozzle, now in acetone- Muscutt 09/12/2015','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,40,'','02/12/2015','11/01/2016'),(72,17,84071,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','J. Tang',1,40,'','02/12/2015','11/01/2016'),(73,22,84047,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','L. Muscutt',1,7,'','02/12/2015','09/12/2015'),(74,10,80265,NULL,'Broken',NULL,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','L. Muscutt',1,7,'','02/12/2015','09/12/2015'),(75,12,80222,NULL,'Missing',NULL,'Could not find printer in cupboard. In purple folder, the only \'open\' loan form suggested it was taken in July but had last been updated in October 2015 on the spreadsheet. ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','T. Standen',1,0,'','02/12/2015','02/12/2015'),(76,24,503039,NULL,'Missing',NULL,'Up Box not in workshop - no loan form completed on or offline (with Shoufeng)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','J. Tang',1,25,'','17/12/2015','11/01/2016'),(77,18,84788,NULL,'Broken',NULL,'Blocked Nozle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','W. Keum',1,15,'nozzle fixed','12/01/2016','27/01/2016'),(78,26,503063,NULL,'Broken',NULL,'Found a printer w/ not heating nozzle from previous sessions. Students and Tim Wolman have issues printing because the printer is not heating up.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'G. Cidonio','L. Wollatz',1,19,'repaired by Chris - calibration sensor is still broken but printer is able to print again','13/01/2016','01/02/2016'),(79,19,83971,NULL,'Broken',NULL,'Not extruding material','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','W. Keum',1,13,'','14/01/2016','27/01/2016'),(80,13,80233,NULL,'Broken',NULL,'Not recognised by computer','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','W. Keum',1,13,'','14/01/2016','27/01/2016'),(81,10,80265,NULL,'Broken',NULL,'Marked as broken when arrived for shift. ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'T. Standen','W. Keum',1,7,'','20/01/2016','27/01/2016'),(82,9,80213,NULL,'Broken',NULL,'nozel blocked ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','W. Keum',1,7,'','20/01/2016','27/01/2016'),(83,16,82908,NULL,'Broken',NULL,'lose y-axis belt','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'W. Keum','K. Crawford',1,392,'','27/01/2016','22/02/2017'),(84,19,83971,NULL,'Broken',NULL,'Not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','W. Keum',1,7,'','03/02/2016','10/02/2016'),(85,2,63116,NULL,'Broken',NULL,'stepper motor does not feed filament ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Muscutt',1,21,'','03/02/2016','24/02/2016'),(86,4,83908,NULL,'Broken',NULL,'leveling spring for base is inside x-axis arm ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Wollatz',1,7,'Spring removed, printer put back together and bed leveled','03/02/2016','10/02/2016'),(87,20,84097,NULL,'Broken',NULL,'Blocked nozel not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','W. Keum',1,0,'','10/02/2016','10/02/2016'),(88,26,503063,NULL,'Broken',NULL,'Z axis not alligned','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','T. Standen',1,63,'No note on printer and seemed to be working','10/02/2016','13/04/2016'),(89,10,80265,NULL,'Broken',NULL,'Nozel blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','J. Nelson',1,7,'Entire new nozzle head assembly installed, old head placed into box of broken bits','10/02/2016','17/02/2016'),(90,11,80215,NULL,'Broken',NULL,'Blocked nozel','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','J. Nelson',1,7,'Replaced nozzle, cleaned out stepper motor','10/02/2016','17/02/2016'),(91,22,84047,NULL,'Broken',NULL,'fan not working ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','K. Crawford',1,0,'','17/02/2016','17/02/2016'),(92,13,80233,NULL,'Broken',NULL,'Printer bed does not heat up','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','E. Kartaki',1,7,'','17/02/2016','24/02/2016'),(93,22,84047,NULL,'Broken',NULL,'nozel assembly is blocked ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Muscutt',1,14,'Unblocked Nozzle','24/02/2016','09/03/2016'),(94,19,83971,NULL,'Broken',NULL,'Heating element wire snapped','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'Soldered heating element wire','02/03/2016','02/03/2016'),(95,13,80233,NULL,'Broken',NULL,'fixed but needs new nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Muscutt',1,7,'soldered loose connection in plate heating element and new nozzle','02/03/2016','09/03/2016'),(96,19,83971,NULL,'Broken',NULL,'Blocked Noozle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','L. Muscutt',1,0,'unblocked nozzle and heating block','09/03/2016','09/03/2016'),(97,10,80265,NULL,'Broken',NULL,'plate not heating','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'changed platform heating element - took the one from printer 6','09/03/2016','09/03/2016'),(98,19,83971,NULL,'Broken',NULL,'Platform not heating','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'Soldered loose connection in plate heating element and new fan','09/03/2016','09/03/2016'),(99,19,83971,NULL,'Broken',NULL,'filament locked inside the nozzle (NO withdraw and extrude)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. De Grazia','K. Crawford',1,54,'','11/03/2016','04/05/2016'),(100,23,82945,NULL,'Broken',NULL,'Nozzle blocked, no replacement nozzles that can be put on (3 are bent and need to be drilled out by Chris).  Put into cupboard without nozzle head','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','J. Nelson',1,5,'replaced nozzle','11/03/2016','16/03/2016'),(101,8,80211,NULL,'Broken',NULL,'Motion program, can not be found. refused to initialise','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','L. Muscutt',1,5,'Oiled z-axis timing belt and linear slide','11/03/2016','16/03/2016'),(102,22,84047,NULL,'Broken',NULL,'Blocked nozzle, no replacements.  3 available nozzles need drilling as non round.  Speak to Chris on Monday.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','J. Nelson',1,0,'','11/03/2016','11/03/2016'),(103,3,82953,NULL,'Broken',NULL,'Blocked nozzle.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','J. Nelson',1,5,'Replaced nozzle','11/03/2016','16/03/2016'),(104,4,83908,NULL,'Broken',NULL,'Blocked nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','J. Nelson',1,0,'','11/03/2016','11/03/2016'),(105,15,80214,NULL,'Broken',NULL,'Bed does not rise fully.  Jams half way up','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','L. Muscutt',1,5,'','11/03/2016','16/03/2016'),(106,8,80211,NULL,'Broken',NULL,'it wouldn\'t download the printing program','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Ferreira','L. Wollatz',1,42,'tested with small sample and worked','23/03/2016','04/05/2016'),(107,13,80233,NULL,'Broken',NULL,'it cannot withdraw','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'E. Kartaki','M. Potticary',1,28,'blocked motor material was removed','23/03/2016','20/04/2016'),(108,15,80214,NULL,'Broken',NULL,'Bed skips whilst traversing z axis','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Nelson','L. Wollatz',1,42,'opened printer - no obvious obstructing parts. 3D printed guide one the left seems broken but not necessary for print - might cause problem in future. Printer tested and skipping stopped even after reassembly.','23/03/2016','04/05/2016'),(109,31,508611,NULL,'Broken',NULL,'Possible Sd card error','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','K. Crawford',1,202,'','13/04/2016','01/11/2016'),(110,26,503063,NULL,'Broken',NULL,'Gear not turning when extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Potticary','L. Wollatz',1,7,'works again','20/04/2016','27/04/2016'),(111,15,80214,NULL,'Broken',NULL,'printer broke again half way during the test print','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','M. Ferreira',1,0,'Vertical rail clip was broken, it has been replaced and other 3 clips 3d printed.','04/05/2016','04/05/2016'),(112,13,80233,NULL,'Broken',NULL,'nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','M. Ferreira',1,0,'Nozzle was blocked. Replaced nozzle and fan support which had melted onto the nozzle.','04/05/2016','04/05/2016'),(113,24,503039,NULL,'Broken',NULL,'extruder blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'J. Tang','P. Fenou Kenjne',1,2,'cleaned the gears','06/06/2016','08/06/2016'),(114,13,80233,NULL,'Broken',NULL,'platform heating element not working','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'M. Ferreira','S. Zhou',1,287,'','08/06/2016','22/03/2017'),(115,18,84788,NULL,'Broken',NULL,'nozzle too cool/ too hot error - nozzle heating element and sensor loose and cable looks very dark (maybe burned)','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Wollatz','L. Muscutt',1,229,'','08/06/2016','23/01/2017'),(116,29,508733,NULL,'Broken',NULL,'Nozzle was jamed','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Zhou','S. Zhou',1,0,'','08/06/2016','08/06/2016'),(117,29,508733,NULL,'Broken',NULL,'not extruding during print','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'P. Fenou Kenjne','P. Fenou Kengne',1,7,'repaired','15/06/2016','22/06/2016'),(118,30,508579,NULL,'Broken',NULL,'Buttons not working -> boxed up in the workshop','2017-10-07 17:37:20','2016-07-27 23:00:00',NULL,'L. Wollatz','',0,364,'',NULL,''),(119,15,80214,NULL,'Broken',NULL,'Platform is stuck AND cannot load motion program','2017-10-07 17:24:38','2016-10-11 23:00:00',NULL,'F. Xie','',0,288,'',NULL,''),(120,21,63120,NULL,'Broken',NULL,'nozzel not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','S. Zhou',1,-1,'','02/11/2016','01/11/2016'),(121,1,63514,NULL,'Broken',NULL,'platform not moving properly','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Muscutt',1,84,'Cleaned thermometer and nozzle heating element','02/11/2016','25/01/2017'),(122,12,80222,NULL,'Broken',NULL,'Gives \"Cannot read printer parameters and \"Motion program not found\" errors','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Grammatikopoulos','L. Muscutt',1,84,'Switched on and off again','02/11/2016','25/01/2017'),(123,3,82953,NULL,'Broken',NULL,'stepper motor issue','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','S. Zhou',1,21,'','02/11/2016','23/11/2016'),(124,17,84071,NULL,'Broken',NULL,'not extruding','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','S. Zhou',1,0,'','02/11/2016','02/11/2016'),(125,19,83971,NULL,'Broken',NULL,'nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Grammatikopoulos','F. Xie',1,77,'','02/11/2016','18/01/2017'),(126,17,84071,NULL,'Broken',NULL,'Y-axis timing belt loose','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','M. Ferreira',1,84,'Replaced y-axis timing belt gear holder with costom made part','02/11/2016','25/01/2017'),(127,8,80211,NULL,'Broken',NULL,'SD card error & blocked nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','S. Zhou',1,112,'','09/11/2016','01/03/2017'),(128,26,503063,NULL,'Broken',NULL,'Nozzle blocked?','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Zhou','S. Zhou',1,0,'','09/11/2016','09/11/2016'),(129,28,503090,NULL,'Broken',13,'The nozzle was not heated up','2017-10-07 17:35:22','2016-11-09 00:00:00',NULL,'S. Zhou','Andrew Everitt',1,736968,'Replaced extruder PCB and ribbon cable. White ribbon cable had 2 bent pins which were unbent.',NULL,''),(130,21,63120,NULL,'Broken',NULL,'plate moving too high during print blocking nozzel','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','L. Muscutt',1,42,'','14/12/2016','25/01/2017'),(131,4,83908,NULL,'Broken',NULL,'','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'','L. Muscutt',1,0,'','25/01/2017','25/01/2017'),(132,20,84097,NULL,'Broken',NULL,'Nozzle issue','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'S. Zhou','L. Muscutt',1,0,'','25/01/2017','25/01/2017'),(133,11,80215,NULL,'Broken',NULL,'Z axiz loose','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'','25/01/2017','25/01/2017'),(134,17,84071,NULL,'Broken',NULL,'replaced z-axis guide','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'Replaced z-axis guide','25/01/2017','25/01/2017'),(135,20,84097,NULL,'Broken',NULL,'no nozzle','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,7,'','25/01/2017','01/02/2017'),(136,22,84047,NULL,'Broken',NULL,'nozzle too hot','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','L. Muscutt',1,0,'Replaced nozzle heating element','01/02/2017','01/02/2017'),(137,22,84047,NULL,'Broken',NULL,'printer not withdrawing','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'L. Muscutt','K. Crawford',1,14,'','08/02/2017','22/02/2017'),(138,3,82953,NULL,'Broken',NULL,'stepper motor blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','K. Crawford',1,0,'','22/02/2017','22/02/2017'),(139,12,80222,NULL,'Broken',NULL,'Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Grammatikopoulos','S. Zhou',1,0,'','15/03/2017','15/03/2017'),(140,8,80211,NULL,'Broken',NULL,'Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Grammatikopoulos','S. Zhou',1,0,'','15/03/2017','15/03/2017'),(141,12,80222,NULL,'Broken',NULL,'Frames vibrate a lot','2017-10-07 17:21:28','2017-03-22 00:00:00',NULL,'S. Zhou','',0,127,'',NULL,''),(142,17,84071,NULL,'Broken',NULL,'Takes ages to heat up (something of the order of 15 minutes), then does not print at all.','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'A. Grammatikopoulos','K. Crawford',1,7,'','12/04/2017','19/04/2017'),(143,3,82953,NULL,'Broken',NULL,'stepper motor jammed ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','K. Crawford',1,0,'','19/04/2017','19/04/2017'),(144,22,84047,NULL,'Broken',NULL,'nozzle blocked','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','K. Crawford',1,0,'','19/04/2017','19/04/2017'),(145,3,82953,NULL,'Broken',NULL,'heating too high and not extruding ','2017-08-01 12:53:14','0000-00-00 00:00:00',NULL,'K. Crawford','F. Xie',1,77,'Replaced the extruder','26/04/2017','12/07/2017'),(146,4,83908,NULL,'Broken',16,'Blocked extruder ','2017-10-07 17:53:58','2017-05-09 23:00:00',NULL,'T. Medjnoun','Daniel Wallace',1,736961,'Printer had been fixed in the interim between entering into the old system and finding it on the new system. Logged by Daniel Wallace (as was the last update, although it says T. Medjnoun!)',NULL,''),(147,20,84097,NULL,'Broken',16,'Blocked extruder','2017-10-07 17:28:28','2017-07-04 23:00:00',NULL,'T. Medjnoun','Daniel Wallace',1,736961,'Printer fixed before today but not logged as such. Tested fully working',NULL,''),(149,24,503039,13,'Broken',NULL,'Multiple extruders and nozzles tried, did not fix issue. Sometimes prints for a couple minutes but will almost always jam.','2017-08-09 08:57:24','2017-08-09 08:57:24','Not extruding','Andrew Everitt',NULL,0,0,NULL,NULL,NULL),(150,29,508733,13,'Broken',NULL,'Multiple extruders tried. Extruder PCB replaced. Ribbon cable replaced.','2017-08-09 09:03:59','2017-08-09 09:03:59','Extruder stepper motor not turning','Andrew Everitt',NULL,0,0,NULL,NULL,NULL),(151,18,84788,14,'Available',16,'Nose needs cleaning, not  extruding material. noise coming from nozzle every attempt to extrude.','2017-08-23 12:40:16','2017-08-09 14:05:34','Not extruding material.','Gerardo Espindola','Daniel Wallace',1,13,'Hot end was blocked - exchanged heater block and nozzle with a set from the acetone jar. Tested, fully working.',NULL,NULL),(152,16,82908,16,'Broken',NULL,'Printer has no bed assembly or extruder assembly.','2017-08-23 13:01:20','2017-08-23 13:01:20','Cannibalised for parts','Daniel Wallace',NULL,0,0,NULL,NULL,NULL),(153,3,82953,16,'Available',16,'The head of one bed levelling screw has sheared off, leaving just the shaft of the screw in place. The shaft will need to be drilled out or gripped with mole grips and unscrewed. A new screw and spring are required.','2017-08-30 13:55:53','2017-08-23 13:23:45','Bed levelling screw and spring','Daniel Wallace','Daniel Wallace',1,7,'Old screw removed, new one fitted',NULL,NULL),(154,8,80211,16,'Missing',NULL,'Printer must be signed out if it is working and not in B13.','2017-08-30 11:12:43','2017-08-30 11:12:43','Printer not in cupboard','Daniel Wallace',NULL,0,0,NULL,NULL,NULL),(155,10,80265,16,'Missing',NULL,'Printer must be signed out on website if it is working and not in the cupboard in B13','2017-08-30 11:14:08','2017-08-30 11:14:08','Printer not in cupboard','Daniel Wallace',NULL,0,0,NULL,NULL,NULL),(156,31,508611,13,'Broken',NULL,'Potential fixes. New Thermistor, new white ribbon cable','2017-10-10 10:28:14','2017-10-10 10:28:14','Print head temperature error','Andrew Everitt',NULL,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `fault_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fault_updates`
--

DROP TABLE IF EXISTS `fault_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fault_updates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `users_name` text NOT NULL,
  `fault_data_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `printer_status` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `days_out_of_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fault_updates_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_updates`
--

LOCK TABLES `fault_updates` WRITE;
/*!40000 ALTER TABLE `fault_updates` DISABLE KEYS */;
INSERT INTO `fault_updates` VALUES (6,25,'Svitlana Braichenko',12,'Checking issue updates','Broken','2017-07-04 20:54:01','2017-07-04 20:54:01',0),(7,25,'Svitlana Braichenko',12,'I did something but clearly didn\'t work','Broken','2017-07-28 12:35:56','2017-07-28 12:35:56',23),(8,16,'Daniel Wallace',146,'Printer is working. Leaving ticket on system for now so IT can resolve issue with date stamping. Days out of order stated negative 70 as of 23.08.17.','Broken','2017-08-23 12:48:06','2017-08-23 12:48:06',736961),(9,16,'Daniel Wallace',25,'Printer has been cannibalised for parts. Currently missing extruder assembly and one levelling screw','Broken','2017-08-23 13:00:27','2017-08-23 13:00:27',736961),(10,16,'Daniel Wallace',141,'Printer has been cannibalised for parts. No extruder assembly or bed.','Broken','2017-08-23 13:03:52','2017-08-23 13:03:52',736961),(11,16,'Daniel Wallace',25,'Printer no longer in cupboard','Missing','2017-08-30 11:10:06','2017-08-30 11:10:06',736968),(12,13,'Andrew Everitt',156,'Working extruder assembly tested in printer including rainbow ribbon cable, did not fix issue. Therefore it is not the thermistor.','Broken','2017-10-10 10:32:16','2017-10-10 10:32:16',0);
/*!40000 ALTER TABLE `fault_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',2),(3,'2017_07_01_113150_create_announcements_table',3),(4,'2017_07_12_145959_create_permission_tables',3),(5,'2017_07_29_190414_create_public_announcements_table',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,1,'App\\User'),(1,2,'App\\User'),(2,3,'App\\User'),(3,4,'App\\User'),(4,5,'App\\User'),(5,6,'App\\User'),(1,7,'App\\User'),(3,8,'App\\User'),(3,9,'App\\User'),(2,10,'App\\User'),(3,11,'App\\User'),(2,12,'App\\User'),(3,13,'App\\User'),(6,13,'App\\User'),(3,14,'App\\User'),(3,15,'App\\User'),(3,16,'App\\User'),(3,17,'App\\User');
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('sb2g14@soton.ac.uk','$2y$10$pFzaEHbTzWQnx/UxChLVoOB8ImXwy5Kt8OZXxttpdi/EIaF06l7be','2017-08-04 16:48:36');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'users_manage','web','2017-07-31 14:54:24','2017-07-31 14:54:24'),(2,'staff_manage','web','2017-08-03 13:41:41','2017-08-03 13:41:41'),(3,'issues_manage','web','2017-08-03 13:41:53','2017-08-03 13:41:53'),(4,'jobs_manage','web','2017-08-03 13:42:05','2017-08-03 13:42:05'),(5,'printers_manage','web','2017-08-03 13:42:19','2017-08-03 13:42:19'),(6,'PublicPostsAndAnnouncements','web','2017-08-03 13:42:29','2017-08-03 13:42:29'),(7,'jobs_request','web','2017-08-03 13:42:37','2017-08-03 13:42:37'),(8,'PrivatePostsAndAnnouncements','web','2017-08-03 13:42:46','2017-08-03 13:42:46');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (23,13,'Not extruding','Multiple extruders and nozzles tried, did not fix issue. Sometimes prints for a couple minutes but will almost always jam.','2017-08-09 08:57:24','2017-08-09 08:57:24'),(24,13,'Extruder stepper motor not turning','Multiple extruders tried. Extruder PCB replaced. Ribbon cable replaced.','2017-08-09 09:03:59','2017-08-09 09:03:59'),(25,14,'Not extruding material.','Nose needs cleaning, not  extruding material. noise coming from nozzle every attempt to extrude.','2017-08-09 14:05:34','2017-08-09 14:05:34'),(26,16,'Cannibalised for parts','Printer has no bed assembly or extruder assembly.','2017-08-23 13:01:20','2017-08-23 13:01:20'),(27,16,'Bed levelling screw and spring','The head of one bed levelling screw has sheared off, leaving just the shaft of the screw in place. The shaft will need to be drilled out or gripped with mole grips and unscrewed. A new screw and spring are required.','2017-08-23 13:23:45','2017-08-23 13:23:45'),(28,16,'Printer not in cupboard','Printer must be signed out if it is working and not in B13.','2017-08-30 11:12:43','2017-08-30 11:12:43'),(29,16,'Printer not in cupboard','Printer must be signed out on website if it is working and not in the cupboard in B13','2017-08-30 11:14:08','2017-08-30 11:14:08'),(30,13,'Print head temperature error','Potential fixes. New Thermistor, new white ribbon cable','2017-10-10 10:28:14','2017-10-10 10:28:14');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printers`
--

DROP TABLE IF EXISTS `printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` int(11) NOT NULL,
  `printer_type` varchar(20) DEFAULT NULL,
  `printer_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `in_use` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` VALUES (1,63514,'UP!','Available',NULL,'2017-08-11 11:50:19',0),(2,63116,'UP!','Available',NULL,'2017-08-04 12:19:57',0),(3,82953,'UP Plus 2','Available',NULL,'2017-08-30 13:55:53',0),(4,83908,'UP Plus 2','Available',NULL,'2017-09-22 13:07:49',0),(5,83906,'UP Plus 2','Missing',NULL,NULL,0),(6,80151,'UP Plus 2','Broken',NULL,'2017-10-07 16:02:19',0),(7,80210,'UP Plus 2','Missing',NULL,'2017-10-07 16:08:25',0),(8,80211,'UP Plus 2','Missing',NULL,'2017-08-30 11:12:43',0),(9,80213,'UP Plus 2','Available',NULL,NULL,0),(10,80265,'UP Plus 2','Missing',NULL,'2017-08-30 11:14:08',0),(11,80215,'UP Plus 2','Available',NULL,NULL,0),(12,80222,'UP Plus 2','Broken',NULL,NULL,0),(13,80233,'UP Plus 2','Available',NULL,'2017-09-20 16:23:31',0),(14,80261,'UP Plus 2','Missing',NULL,'2017-08-30 12:47:25',0),(15,80214,'UP Plus 2','Broken',NULL,'2017-10-07 17:23:05',0),(16,82908,'UP Plus 2','Broken',NULL,'2017-08-23 13:01:20',0),(17,84071,'UP Plus 2','Available',NULL,NULL,0),(18,84788,'UP Plus 2','Available',NULL,'2017-09-20 16:23:31',0),(19,83971,'UP Plus 2','Available',NULL,'2017-08-09 12:31:31',0),(20,84097,'UP Plus 2','Available',NULL,'2017-09-13 14:07:55',0),(21,63120,'UP!','Available',NULL,'2017-08-09 13:17:33',0),(22,84047,'UP Plus 2','Available',NULL,'2017-08-25 16:31:37',0),(23,82945,'UP Plus 2','Available',NULL,'2017-08-30 13:55:28',0),(24,503039,'UP BOX','Broken',NULL,'2017-08-09 08:57:24',0),(25,503041,'UP BOX','Signed out',NULL,NULL,0),(26,503063,'UP BOX','Available',NULL,'2017-08-23 07:41:26',0),(27,503086,'UP BOX','Signed out',NULL,NULL,0),(28,503090,'UP BOX','Available',NULL,'2017-08-30 14:34:34',0),(29,508733,'UP BOX','Broken',NULL,'2017-08-09 09:03:59',0),(30,508579,'UP BOX','Broken',NULL,NULL,0),(31,508611,'UP BOX','Broken',NULL,'2017-10-10 10:28:14',0);
/*!40000 ALTER TABLE `printers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `printing_datas`
--

DROP TABLE IF EXISTS `printing_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `printing_datas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `printers_id` varchar(30) NOT NULL,
  `student_id` int(11) NOT NULL,
  `time` time DEFAULT NULL,
  `material_amount` float unsigned NOT NULL,
  `price` float unsigned DEFAULT NULL,
  `paid` enum('Yes','No','NA') NOT NULL DEFAULT 'NA',
  `user_id` int(11) DEFAULT NULL,
  `payment_category` varchar(20) DEFAULT NULL,
  `use_case` varchar(30) NOT NULL,
  `cost_code` varchar(30) DEFAULT NULL,
  `add_comment` varchar(255) DEFAULT NULL,
  `successful` enum('Yes','No') NOT NULL,
  `purpose` enum('Use','Loan') NOT NULL,
  `student_name` varchar(30) DEFAULT NULL,
  `approved` enum('Yes','No','Waiting','Success') DEFAULT 'Waiting',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` text,
  `serial_no` int(11) DEFAULT NULL,
  `month` text,
  `approved_name` text,
  `Date` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=118 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printing_datas`
--

LOCK TABLES `printing_datas` WRITE;
/*!40000 ALTER TABLE `printing_datas` DISABLE KEYS */;
INSERT INTO `printing_datas` VALUES (67,'3',426727889,'01:44:00',15.3,5.97,'No',12,'undergraduate','Cost Code','516228101',NULL,'Yes','Use','Matt Lisle','Success','2017-08-09 09:28:18','2017-08-09 10:54:00','ml12g14@soton.ac.uk',82953,'2017/8','Apostolos Grammatikopoulos',NULL),(68,'21',426727889,'01:06:00',12.1,0.35,'No',12,'undergraduate','Cost Code','516228101',NULL,'No','Use','Matt Lisle','No','2017-08-09 09:31:44','2017-08-09 09:38:30','ml12g14@soton.ac.uk',63120,'2017/8','Apostolos Grammatikopoulos',NULL),(71,'21',426727889,'01:22:00',12.1,4.71,'No',12,'undergraduate','Cost Code','516228101',NULL,'Yes','Use','Matt Lisle','Yes','2017-08-09 09:50:27','2017-08-09 09:50:45','ml12g14@soton.ac.uk',63120,'2017/8','Apostolos Grammatikopoulos',NULL),(72,'31',28731727,'07:00:00',37,22.85,'No',13,'undergraduate','Cost Code','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-09 09:57:20','2017-08-09 11:06:30','jfm1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(73,'26',28731727,'00:36:00',50,0,'No',13,'undergraduate','Cost Code','510672104',NULL,'No','Use','Joel Flores Mora','No','2017-08-09 10:01:37','2017-08-09 11:41:54','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(75,'3',426727889,'00:58:00',5.3,3.17,'No',14,'undergraduate','Cost Code - approved','516228101',NULL,'Yes','Use','Matt Lisle','Success','2017-08-09 11:07:56','2017-08-09 12:30:16','ml12g14@soton.ac.uk',82953,'2017/8','Gerardo Espindola',NULL),(76,'26',28731727,'00:25:00',15,0,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'No','Use','Joel Flores Mora','No','2017-08-09 11:47:21','2017-08-09 12:12:40','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(77,'19',226618877,'00:07:00',12.6,0.35,'No',14,'postgraduate','Cost Code - unknown','515840103','Project: Southampton Sailing Robot Team\r\nProf. Stephen R Turnode','No','Use','Sophia Schillai','No','2017-08-09 12:19:04','2017-08-09 12:31:31','sms4g13@soton.ac.uk',83971,'2017/8','Gerardo Espindola',NULL),(78,'26',28731727,'01:45:00',3,5.4,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Success','2017-08-09 12:25:36','2017-08-09 14:03:14','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(79,'3',426727889,'01:04:00',6.2,3.51,'No',14,'undergraduate','Cost Code - approved','516228101',NULL,'Yes','Use','Matt Lisle','Success','2017-08-09 12:31:09','2017-08-09 14:06:45','ml12g14@soton.ac.uk',82953,'2017/8','Gerardo Espindola',NULL),(81,'23',227440818,'00:16:00',50,0,'No',13,'postgraduate','Cost Code - unknown','511019264',NULL,'No','Use','Mohammed Saliem','No','2017-08-09 13:34:23','2017-08-09 14:03:26','aje2g15@soton.ac.uk',82945,'2017/8','Andrew Everitt',NULL),(82,'4',226538571,'01:40:00',13.1,5.66,'No',14,'postgraduate','Cost Code - unknown','511019290',NULL,'Yes','Use','Nan Zhou','Yes','2017-08-09 13:39:45','2017-08-09 13:40:05','Nan.Zhou@soton.ac.uk',83908,'2017/8','Gerardo Espindola',NULL),(83,'3',426727889,'04:16:00',58.9,15.75,'No',13,'undergraduate','Cost Code - approved','516228101',NULL,'Yes','Use','Matt Lisle','Yes','2017-08-09 14:12:35','2017-08-09 14:14:09','ml12g14@soton.ac.uk',82953,'2017/8','Andrew Everitt',NULL),(84,'26',28731727,'07:40:00',50,25.5,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-09 14:13:50','2017-08-09 14:14:15','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(85,'23',227440818,'01:40:00',50,7.5,'No',13,'postgraduate','Cost Code - unknown','511019264',NULL,'Yes','Use','Mohammed Saliem','Success','2017-08-09 14:27:19','2017-08-10 11:21:08','aje2g15@soton.ac.uk',82945,'2017/8','Andrew Everitt',NULL),(86,'26',28731727,'06:40:00',12,20.6,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-10 12:32:51','2017-08-10 12:34:38','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(87,'31',28731727,'06:07:00',11,20.6,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-10 12:34:18','2017-08-10 12:37:09','jfm1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(88,'26',28731727,'06:40:00',12,0,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'No','Use','Joel Flores Mora','Yes','2017-08-10 16:50:34','2017-08-14 11:40:00','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(90,'31',28731727,'04:00:00',5,12.25,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-14 11:49:59','2017-08-14 11:50:46','jfm1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(91,'26',28731727,'04:00:00',5,12.25,'No',13,'undergraduate','Cost Code - unknown','510672104',NULL,'Yes','Use','Joel Flores Mora','Yes','2017-08-14 11:50:36','2017-08-14 12:42:20','jfm1n15@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(92,'26',26732297,'00:39:00',4.7,2.19,'No',13,'undergraduate','Cost Code - unknown','502490105',NULL,'Yes','Use','Robert Winn','Success','2017-08-15 08:11:25','2017-08-15 08:18:56','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(93,'31',26732297,'04:46:00',33,15.95,'No',13,'undergraduate','Cost Code - unknown','502490105',NULL,'Yes','Use','Robert Winn','Yes','2017-08-15 08:13:15','2017-08-15 08:14:13','rcw1g14@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(94,'26',26732297,'05:26:00',36,18.1,'No',13,'undergraduate','Cost Code - unknown','502490105',NULL,'Yes','Use','Robert Winn','Yes','2017-08-15 08:23:58','2017-08-15 10:13:29','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(95,'20',227898466,'03:02:00',30.2,10.61,'No',2,'postgraduate','Cost Code - unknown','504596101',NULL,'Yes','Use','YANAN WANG','Yes','2017-08-16 09:17:06','2017-08-22 12:48:18','yw3n14@soton.ac.uk',84097,'2017/8','Svitlana Braichenko',NULL),(96,'4',227898466,'03:02:00',30.2,10.61,'No',2,'postgraduate','Cost Code - unknown','504596101',NULL,'Yes','Use','YANAN WANG','Yes','2017-08-16 10:14:47','2017-08-22 12:48:22','yw3n14@soton.ac.uk',83908,'2017/8','Svitlana Braichenko',NULL),(97,'22',328579933,'00:59:00',12.3,3.57,'No',2,'masters','Cost Code - unknown','510672108',NULL,'Yes','Use','Rogelio Navarro Arroyo','Yes','2017-08-16 12:24:31','2017-08-22 12:48:26','rna1n15@soton.ac.uk',84047,'2017/8','Svitlana Braichenko',NULL),(98,'26',426732297,'15:00:00',200,0,'No',13,'undergraduate','Cost Code - unknown','502490105','Part: Bottom 3','No','Use','Robert Winn','Yes','2017-08-17 09:37:21','2017-08-18 08:52:04','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(99,'31',426732297,'03:45:00',30,0,'No',13,'undergraduate','Cost Code - unknown','502490105','Part: Top 1','No','Use','Robert Winn','Yes','2017-08-17 09:41:33','2017-08-17 14:20:43','rcw1g14@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(100,'26',426732297,'09:00:00',66,30.3,'No',13,'undergraduate','Cost Code - unknown','502490105','Part: Bottom 3','Yes','Use','Robert Winn','Yes','2017-08-18 10:02:51','2017-08-18 10:04:20','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(101,'26',426732297,'09:10:00',66,30.8,'No',13,'undergraduate','Cost Code - unknown','502490105','Part: Bottom 3','Yes','Use','Robert Winn','Yes','2017-08-18 10:03:48','2017-08-18 10:04:37','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(102,'26',227898466,'03:00:00',30,10.5,'No',13,'postgraduate','Cost Code - unknown','511019291',NULL,'Yes','Use','YANAN WANG','Yes','2017-08-18 12:11:27','2017-08-18 12:13:00','yw3n14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(103,'31',328428528,'06:08:00',60,21.4,'No',13,'masters','Cost Code - unknown','509301101',NULL,'Yes','Use','Colin Whiteley','Success','2017-08-18 12:12:48','2017-08-18 13:30:13','cw1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(104,'31',328428528,'06:00:00',30,18.05,'No',13,'masters','Cost Code - unknown','509301101',NULL,'Yes','Use','Colin Whiteley','Yes','2017-08-18 13:32:21','2017-08-18 13:32:49','cw1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(105,'31',328428528,'06:03:00',30,19.65,'No',13,'masters','Cost Code - unknown','509301101','Part: Arm mount','Yes','Use','Colin Whiteley','Success','2017-08-22 10:46:01','2017-08-22 10:46:47','cw1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(106,'31',328428528,'06:03:00',30,19.65,'No',13,'masters','Cost Code - unknown','509301101','Part: Arm Mount','Yes','Use','Colin Whiteley','Success','2017-08-22 10:47:57','2017-08-22 10:48:36','cw1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(107,'31',328428528,'00:22:00',30,0,'No',13,'masters','Cost Code - unknown','509301101','Part: Arm mount','No','Use','Colin Whiteley','No','2017-08-22 10:50:32','2017-08-22 11:13:23','cw1n15@soton.ac.uk',508611,'2017/8','Andrew Everitt',NULL),(108,'26',426732297,'12:19:00',60,39.95,'No',13,'undergraduate','Cost Code - unknown','502490105','Part: Bottom 3','Yes','Use','Robert Winn','Yes','2017-08-22 11:21:32','2017-08-22 11:21:47','rcw1g14@soton.ac.uk',503063,'2017/8','Andrew Everitt',NULL),(109,'20',12652226,'02:00:00',27.7,7.39,'No',12,'staff','Cost Code - unknown','515043101',NULL,'Yes','Use','Artur Lidtke','Yes','2017-08-23 09:03:06','2017-08-23 09:09:51','akl1g09@soton.ac.uk',84097,'2017/8','Apostolos Grammatikopoulos',NULL),(110,'23',226648067,'00:30:00',7.4,1.87,'No',16,'postgraduate','Cost Code - unknown','511019286',NULL,'Yes','Use','Olanipekun Kolade','Yes','2017-08-30 12:54:20','2017-08-30 13:01:37','kao1e13@soton.ac.uk',82945,'2017/8','Daniel Wallace',NULL),(111,'4',225611682,'03:51:00',61,11.55,'No',16,'postgraduate','Cost Code - unknown','502761136',NULL,'No','Use','Bethan Linscott','No','2017-09-13 12:25:45','2017-09-13 16:17:36','bl7g12@soton.ac.uk',83908,'2017/9','Daniel Wallace',NULL),(112,'20',225611682,'01:32:00',24.4,5.82,'No',16,'postgraduate','Cost Code - unknown','502761136',NULL,'Yes','Use','Bethan Linscott','Yes','2017-09-13 12:27:39','2017-09-13 12:27:53','bl7g12@soton.ac.uk',84097,'2017/9','Daniel Wallace',NULL),(113,'18',428353803,'00:37:00',1.6,1.93,'No',16,'undergraduate','Cost Code - unknown','517560101',NULL,'Yes','Use','Maria Stagno Navarra','Yes','2017-09-20 13:48:16','2017-09-20 13:49:31','msn1g16@soton.ac.uk',84788,'2017/9','Daniel Wallace',NULL),(114,'13',428353803,'00:06:00',1,0.35,'No',16,'undergraduate','Cost Code - unknown','517560101',NULL,'Yes','Use','Maria Stagno Navarra','Yes','2017-09-20 14:13:48','2017-09-20 14:42:19','msn1g16@soton.ac.uk',80233,'2017/9','Daniel Wallace',NULL),(115,'18',428353803,'00:13:00',1.3,0.72,'No',16,'undergraduate','Cost Code - unknown','517560101',NULL,'Yes','Use','Maria Stagno Navarra','Yes','2017-09-20 14:27:55','2017-09-20 14:42:26','msn1g16@soton.ac.uk',84788,'2017/9','Daniel Wallace',NULL),(116,'13',428353803,'00:07:00',1,0.4,'No',16,'undergraduate','Cost Code - unknown','517560101',NULL,'Yes','Use','Maria Stagno Navarra','Yes','2017-09-20 14:36:18','2017-09-20 14:42:14','msn1g16@soton.ac.uk',80233,'2017/9','Daniel Wallace',NULL),(117,'4',225611682,'04:00:00',61,15.05,'No',16,'postgraduate','Cost Code - unknown','502761136',NULL,'Yes','Use','Bethan Linscott','Yes','2017-09-21 09:07:10','2017-09-21 09:07:18','bl7g12@soton.ac.uk',83908,'2017/9','Daniel Wallace',NULL);
/*!40000 ALTER TABLE `printing_datas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `public_announcements`
--

DROP TABLE IF EXISTS `public_announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `public_announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8mb4_unicode_ci,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_announcements`
--

LOCK TABLES `public_announcements` WRITE;
/*!40000 ALTER TABLE `public_announcements` DISABLE KEYS */;
INSERT INTO `public_announcements` VALUES (1,'This is the initial production version of the Workshop online managing application. This version still has multiple bugs and the first update intended to resolve most of them will soon be released. In the meantime, you are kindly asked to test the application as much as possible and report any noticed bugs to the development team using email addresses provided in the footer. We are looking forward to your feedback!',1,'2017-08-03 19:20:48','2017-08-03 19:20:48'),(2,'The statuses of all printers and issues associated with them have been brought into order with the current state of affairs. There is one exception with printer 7 though. \r\n\r\nWe have also introduced access to the website using encrypted protocol https. In order to start using it type https://3dprint.clients.soton.ac.uk and proceed by ignoring all warnings, that your web browser might issue.',1,'2017-10-08 20:10:18','2017-10-08 20:10:18');
/*!40000 ALTER TABLE `public_announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(2,2),(3,2),(4,2),(5,2),(6,2),(7,2),(8,2),(3,3),(4,3),(7,3),(8,3),(4,4),(7,4),(8,4),(7,5),(8,5);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrator','web','2017-07-31 14:54:24','2017-07-31 14:54:24'),(2,'LeadDemonstrator','web','2017-08-03 13:46:45','2017-08-03 13:46:45'),(3,'Demonstrator','web','2017-08-03 14:02:04','2017-08-03 14:02:04'),(4,'NewDemonstrator','web','2017-08-03 14:02:21','2017-08-03 14:02:21'),(5,'OldDemonstrator','web','2017-08-03 14:02:33','2017-08-03 14:02:33'),(6,'3dhubs_manager','web','2017-08-09 10:58:49','2017-08-09 10:58:49');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

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
  `student_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Andrii','Iakovliev','ai1v14@soton.ac.uk','07479045846','2017-10-13 16:49:47','IT','2017-08-07 10:48:00',1,27459292),(2,'Svitlana','Braichenko','sb2g14@soton.ac.uk','07479052411','2017-10-13 16:13:11','IT','2017-08-04 17:30:23',2,226545357),(7,'Lasse','Wollatz','L.Wollatz@soton.ac.uk','07584344821','2017-10-13 16:52:50','IT Manager','2017-08-23 12:36:20',7,224360643),(8,'Gianluca','Cidonio','gc3e15@soton.ac.uk','07492545655','2017-10-13 16:54:44','Demonstrator','2017-09-27 15:57:52',8,228080785),(9,'Jennifer','Bramley','j.l.bramley@soton.ac.uk','07896217552','2017-10-13 17:01:01','Demonstrator','2017-08-07 09:10:57',9,222688951),(10,'Katherine','Crawford','K.A.Crawford@soton.ac.uk','07510838851','2017-10-13 16:57:39','Lead Demonstrator','2017-09-27 15:55:24',10,226403633),(11,'Charalambos ','Rossides','c.rossides@soton.ac.uk','07544336771','2017-10-13 17:01:36','Demonstrator','2017-08-07 12:24:49',11,229123119),(12,'Apostolos','Grammatikopoulos','ag3e15@soton.ac.uk','75819298485','2017-10-13 17:00:22','Lead Demonstrator','2017-09-27 15:55:09',12,228216911),(13,'Andrew','Everitt','aje2g15@soton.ac.uk','07477392223','2017-10-13 17:02:44','3D Hub Manager','2017-08-09 08:51:26',13,427682838),(14,'Gerardo','Espindola','Gerardo.Espindola@soton.ac.uk','07477313948','2017-10-13 17:04:31','Demonstrator','2017-08-09 11:13:31',14,227456412),(15,'Takfarinas','Medjnoun','tm1y13@soton.ac.uk','07440396813','2017-10-13 17:05:14','Demonstrator','2017-08-16 16:55:15',15,227293629),(16,'Daniel','Wallace','djw1g12@soton.ac.uk','07948683455','2017-10-13 17:05:41','Demonstrator','2017-08-23 11:57:17',16,225257307),(17,'Hossam','Ragheb','har1g15@soton.ac.uk','07413734010','2017-10-13 17:06:00','Demonstrator','2017-09-20 10:38:45',17,228217497),(18,'Hayk','Vasilyan','h.vasilyan@soton.ac.uk','unknown','2017-08-23 15:54:11','Former member','2017-08-05 19:00:08',NULL,12345678),(19,'Erato','Kartaki','ek2e14@soton.ac.uk','07518990594','2017-10-13 17:07:40','Former member','2017-08-05 19:00:31',NULL,NULL),(20,'Chris','Malcolm','C.Malcom@soton.ac.uk','unknown','2017-08-04 11:53:29','Technician','2017-08-01 14:36:02',NULL,NULL),(21,'Fulin ','Xie','fx1g12@soton.ac.uk','unknown','2017-10-13 17:08:12','unknown',NULL,NULL,NULL),(22,'Dr. Shoufeng','Yang','s.yang@soton.ac.uk','23805928697','2017-09-28 11:29:48','Coordinator','2017-09-28 11:29:48',NULL,1000001),(23,'Dr. Tim','Woolman','T.Woolman@soton.ac.uk','02380592844','2017-09-28 11:30:32','Co-Coordinator','2017-09-28 11:30:32',NULL,1000002),(24,'Jing','Tang','jt7g13@soton.ac.uk','07403797321','2017-10-13 16:52:35','Technical Manager','2017-10-13 10:30:56',NULL,226474972),(25,'Manuel','Ferreira','maf1v15@soton.ac.uk','unknown','2017-10-13 16:58:28','Former member','2017-08-05 18:59:41',NULL,NULL),(26,'Luke','Muscutt','L.Muscutt@soton.ac.uk','07723325834','2017-10-13 16:56:09','PR Manager','2017-10-13 10:33:23',NULL,225747983),(27,'Matt','Potticary','m.potticary@soton.ac.uk','07972298383','2017-10-13 16:59:29','Former member','2017-08-05 18:59:59',NULL,NULL),(28,'Shenglong','Zhou','sz3g14@soton.ac.uk','07519533874','2017-10-13 17:03:17','Demonstrator',NULL,NULL,NULL),(29,'Yu','Pui-Hei','phy1g13@soton.ac.uk','unknown','2017-10-13 17:04:45','unknown',NULL,NULL,NULL),(30,'Patrick','Fenou Kengne','plfk1g13@soton.ac.uk','07729280929','2017-10-13 17:09:07','Former member','2017-09-27 15:59:12',NULL,40000001),(31,'Chee','Hong Goh','chg1g13@soton.ac.uk','07851925072','2017-10-13 17:09:17','Demonstrator',NULL,NULL,NULL),(32,'Horacio','Rodriguez','hafr1g13@soton.ac.uk','07472080461','2017-10-13 17:09:28','Demonstrator',NULL,NULL,NULL),(33,'Shahir','Yusuf','symy1g12@soton.ac.uk','07707994194','2017-10-13 17:09:38','Demonstrator',NULL,NULL,NULL),(34,'A.','Martinez','unknown','unknown','2017-10-13 17:29:10','Former member',NULL,NULL,NULL),(35,'Ana-Marija','Duranec','unknown','unknown','2017-10-13 17:30:26','Former member',NULL,NULL,NULL),(36,'Antinio','De Grazia','unknown','unknown','2017-10-13 17:31:20','Former member',NULL,NULL,NULL),(37,'Brittany','Hill','unknown','unknown','2017-10-13 17:32:44','Former member',NULL,NULL,NULL),(38,'Bob','Mack','unknown','unknown','2017-10-13 17:33:05','Former member',NULL,NULL,NULL),(39,'Dani','Newman','unknown','unknown','2017-10-13 17:36:31','Former member',NULL,NULL,NULL),(40,'Dr. Catriona','Cooper','unknown','unknown','2017-10-13 17:38:07','Former member',NULL,NULL,NULL),(41,'Feifei','Zhang','unknown','unknown','2017-10-13 17:43:28','Former member',NULL,NULL,NULL),(42,'Geqi','Qi','unknown','unknown','2017-10-13 17:45:11','Former member',NULL,NULL,NULL),(43,'Jacques','Van der Kindere','unknown','unknown','2017-10-13 17:46:00','Former member',NULL,NULL,NULL),(44,'James','Nelson','unknown','unknown','2017-10-13 17:46:25','Former member',NULL,NULL,NULL),(45,'Jianhao','Xiong','unknown','unknown','2017-10-13 17:46:55','Former member',NULL,NULL,NULL),(46,'John','Vasi','unknown','unknown','2017-10-13 17:48:24','Former member',NULL,NULL,NULL),(47,'Kate','Rogers','unknown','unknown','2017-10-13 17:48:50','Former member',NULL,NULL,NULL),(48,'Peter','Campbell','unknown','unknown','2017-10-13 17:56:41','Former member',NULL,NULL,NULL),(49,'Ping','Lu','unknown','unknown','2017-10-13 17:57:10','Former member',NULL,NULL,NULL),(50,'Quentin','Francois','unknown','unknown','2017-10-13 17:57:43','Former member',NULL,NULL,NULL),(51,'Rene','Kaufmann','unknown','unknown','2017-10-13 17:58:10','Former member',NULL,NULL,NULL),(52,'Samiksha','Mestry','unknown','unknown','2017-10-13 17:59:22','Former member',NULL,NULL,NULL),(53,'Thomas','Hainaut','unknown','unknown','2017-10-13 18:00:14','Former member',NULL,NULL,NULL),(54,'Tyra','Standen','unknown','unknown','2017-10-13 18:00:50','Former member',NULL,NULL,NULL),(55,'Wei','Keum','unknown','unknown','2017-10-13 18:01:16','Former member',NULL,NULL,NULL),(56,'Will','Ashley','unknown','unknown','2017-10-13 18:01:36','Former member',NULL,NULL,NULL),(57,'Xiaoru','Sun','unknown','unknown','2017-10-13 18:03:30','Former member',NULL,NULL,NULL),(58,'Yiyang','Chen','unknown','unknown','2017-10-13 18:04:11','Former member',NULL,NULL,NULL);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','ai1v14@soton.ac.uk','$2y$10$AL2ZB1NzcJASOMLPZAhu8O2jcP5pGdfh./hhKW1yi70rR6xCxD9FS','FQ7sMMQSZc9rvdWn0tNJzIOBeuqvwhdNaSdZWOo7KQfFUv6pMfWyUwBrV4pq','2017-07-31 14:54:24','2017-08-05 11:50:39'),(2,'Svitlana Braichenko','sb2g14@soton.ac.uk','$2y$10$eKgk7jaw/RQ1eFLMZ9CloOAVBfyCa0ZnY7Sx7uUjn7po.Fsr3RawG','76rLTIBLjioNri1uYVrRn66PZ5tqQkGVQQxkqgRcdYROdPghYwCQfQ3CL45U','2017-08-03 12:07:36','2017-08-03 12:07:36'),(3,'LeadDemonstrator','LD@soton.ac.uk','$2y$10$8ONdFHxAc6NCgR1/8HAU5.Y2O4w1b/hpXpMbe.eBRM/.jVEur6sfC','SMNO1vsgDsu60vnkn1ag1DYNXs96UA5Bo0GTIS9TL0Z21UtU0x4OSGzu8zvg','2017-08-03 13:50:07','2017-08-03 13:50:07'),(4,'Demonstrator1','D1@soton.ac.uk','$2y$10$eN6G6gYbv/bEiXyL9QZgqOIyoqY8///u/TxwCoB.jlf/qMIx9yCIC','BEREFILDhzAA0FKmDlAf0a81VbtsclcoDD3fUqvCFNpQGeNEGfgemRdy5ZQC','2017-08-03 14:03:23','2017-08-03 14:03:23'),(5,'NewDemonstrator1','ND1@soton.ac.uk','$2y$10$NXO.Gpi/Y.ISIS5dX4lOh.Rd9oTZcKB1hEzrBiZumTw1eDBwIv.RC',NULL,'2017-08-03 14:03:43','2017-08-03 14:03:43'),(6,'OldDemonstrator1','OD1@soton.ac.uk','$2y$10$jAzV624DSTYMUbwWiIaEVuoP1lW/od1AXMGrv5Rl4u.2NjkZ2uDq2','nGncfSn6StJKvlIXGAuJv686USWP18CX4YH9z5N2JwEUoRD86N8ngRSp0mUC','2017-08-03 14:04:05','2017-08-03 14:04:05'),(7,'Lasse Wollatz','L.Wollatz@soton.ac.uk','$2y$10$Vptq7ULy6uJNH7Xp/n0m0Ooz/RSp8jUZo0Oiaxg1Zh.awBHN4txh2','C3j5G5dZooQUjteWW8SqbwEkRwKSiXOGQEKFdHMwRfMtHc7dgZNHJo9jXpGe','2017-08-04 09:47:20','2017-08-04 09:47:20'),(8,'Gianluca Cidonio','gc3e15@soton.ac.uk','$2y$10$KCN5i78CGcgGH.oM1lh2XupXBs4/N2QKKbP04JjAYR50VP4E7OvgW',NULL,'2017-08-05 12:37:26','2017-08-05 12:37:26'),(9,'Jenny Bramley','j.l.bramley@soton.ac.uk','$2y$10$ma4XtWdA/gNQ9/fgeAsBlObT8ckwZv9CXayzqf0J1GB/Rc9Y3s1zG','qL6y8wlNwLexYVCWIcQ1WNdZqpNW6Wm7FVmXRx5jskW8F3bBTtGNkk8bWtbZ','2017-08-07 09:10:57','2017-08-07 09:10:57'),(10,'Katherine Crawford','K.A.Crawford@soton.ac.uk','$2y$10$fCDGtuQrQ6F5HQnsLfCxlurLX7O//T2v0SmHvx.FRUFG.jNQG5xDu',NULL,'2017-08-07 11:50:40','2017-08-07 11:50:40'),(11,'Charalambos Rossides','c.rossides@soton.ac.uk','$2y$10$M8GVA/mpa1NLCxGZP3KT2OIdvkAZ9i5VZxDFmgVUv1cvm7.51n9Qm','Iim9QoHVeyHaq9yrBpcr6QDYKSJ5BTZMdKgudLWVU5gGs3haDmwwOx1sKB5R','2017-08-07 12:24:49','2017-08-07 12:24:49'),(12,'Apostolos Grammatikopoulos','ag3e15@soton.ac.uk','$2y$10$b5DsweJx2NEC5e5C89K6vOPxokr3kIauY2ghcCtKEOBVVdOHAVWei',NULL,'2017-08-09 08:24:35','2017-08-09 08:24:35'),(13,'Andrew Everitt','aje2g15@soton.ac.uk','$2y$10$9cTeSzZ8BDJ5OS9vjQLZL.tSNaBfOq86ftJwpJwJcvY8/5XdeWmbq','5u9WXSzNsRrO4U1Ps4DQG4vS4VDGTXKJaTCjKlFd7YFsnTVSQe2ph6L1ql5V','2017-08-09 08:51:26','2017-08-17 09:34:44'),(14,'Gerardo Espindola','Gerardo.Espindola@soton.ac.uk','$2y$10$8NxqshC8RgZjjplNEPEmvebWUZXzCx8uZ/1wiRcOxiIKm27l1FEXW','l6lKwAWMmunOsgFJ3vuYG9helX4pm0vzj31APvFw3A44nBdt976k4tgetTHh','2017-08-09 11:13:31','2017-08-09 11:13:31'),(15,'Takfarinas Medjnoun','tm1y13@soton.ac.uk','$2y$10$zuj7BEZ079t/z1w/K1lGN.BA6KboXgEWTVgSj4LtQuL34EWQ.L5Ne','iIutXwTio0CNb6qxDNqEyYyJdzsMJE0hqBuAqVGbbZKK6dEEt0ZwKC2LOrpH','2017-08-16 16:55:15','2017-08-16 17:20:49'),(16,'Daniel Wallace','djw1g12@soton.ac.uk','$2y$10$cjK3Ya2CbWGOzDzMsrZquOE3EB9v3sAyfUTvb21fgoxIAIkaRtflC','wUmrq3mI5Sy8a3B1Gi6adBhk3M5mRnwWh8yuNr5Ir2KjK5qUdgZ4prUnSpat','2017-08-23 11:57:17','2017-08-23 11:57:17'),(17,'Hossam Ragheb','har1g15@soton.ac.uk','$2y$10$TpthPhNfGcFjUwO2eCVuHOt..aOAjRrOn3ERuFqsTkyiEf0TTCfnS','4XojCYuAV3ZG6ihTqwj7cJpIgfEn4Ks2ZQ9pAaRODZHmHNRXLyMhKy9dwY4A','2017-09-20 10:38:45','2017-09-20 10:38:45');
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

-- Dump completed on 2017-10-14 20:28:04
