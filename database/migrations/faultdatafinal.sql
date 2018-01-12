<<<<<<< HEAD
=======
use `3dprint_workshop`;
>>>>>>> 8e931742db872215f50d34257477f6b857365534
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
-- Table structure for table `fault_datas`
--

DROP TABLE IF EXISTS `fault_datas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fault_datas` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `printers_id` int(11) NOT NULL,
  `serial_number` int(9) NOT NULL,
  `staff_id_created_issue` int(11) DEFAULT NULL,
  `printer_status` text,
  `staff_id_resolved_issue` int(11) DEFAULT NULL,
  `body` text,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL,
  `title` text,
  `resolved` tinyint(1) NOT NULL DEFAULT '0',
  `message_resolved` text,
  `resolved_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fault_datas_printers__fk` (`printers_id`),
  CONSTRAINT `fault_datas_printers__fk` FOREIGN KEY (`printers_id`) REFERENCES `printers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=160 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_datas`
--

LOCK TABLES `fault_datas` WRITE;
/*!40000 ALTER TABLE `fault_datas` DISABLE KEYS */;
INSERT INTO `fault_datas` (`id`, `printers_id`, `serial_number`, `staff_id_created_issue`, `printer_status`, `staff_id_resolved_issue`, `body`, `updated_at`, `created_at`, `title`, `resolved`, `message_resolved`, `resolved_at`) VALUES (1,9,80213,43,'Broken',40,'','2018-01-12 13:31:51','2015-02-11 00:00:00',NULL,1,'','2015-02-16 00:00:00'),(2,10,80265,40,'Broken',41,'','2018-01-12 13:31:51','2015-02-16 00:00:00',NULL,1,'','2015-02-23 00:00:00'),(3,15,80214,43,'Broken',26,'extruder assembly missing (previous note: Loose platform support on the right guide of the structure for printer 15 \"15/05/2014\")','2018-01-12 13:31:51','2015-02-11 00:00:00',NULL,1,'','2016-03-09 00:00:00'),(4,19,83971,54,'Broken',43,'','2018-01-12 13:31:51','2015-02-16 00:00:00',NULL,1,'','2015-02-23 00:00:00'),(5,5,83906,43,'Missing',39,'','2018-01-12 13:31:51','2015-02-10 00:00:00',NULL,1,'found to be on loan','2015-03-12 00:00:00'),(6,7,80210,43,'Missing',7,'','2018-01-12 13:31:51','2015-02-10 00:00:00',NULL,1,'Was returned to Chris - probably the one previously used for software test in B25','2015-06-30 22:00:00'),(7,14,80261,43,'Missing',NULL,'with professor?','2018-01-12 13:32:08','2015-02-10 13:15:32',NULL,0,'',NULL),(8,21,63120,7,'Missing',22,'','2018-01-12 13:32:32','2015-02-20 00:00:00',NULL,1,'found to be on loan','2015-02-27 00:00:00'),(9,6,80151,64,'Broken',64,'Faulty extruder motor','2018-01-12 13:32:32','2015-02-23 00:00:00',NULL,1,'','2015-03-04 00:00:00'),(10,4,83908,7,'Broken',43,'nozzle blocked','2018-01-12 13:32:32','2015-02-23 00:00:00',NULL,1,'','2015-02-23 00:00:00'),(11,3,82953,7,'Broken',43,'nozzle only extruding from maintenance','2018-01-12 13:32:32','2015-02-23 00:00:00',NULL,1,'','2015-02-23 00:00:00'),(12,2,63116,39,'Broken',39,'nozzle blocked- put in filament','2018-01-12 13:32:32','2015-03-02 00:00:00',NULL,1,'','2015-03-02 00:00:00'),(13,4,83908,54,'Broken',54,'User spoke to Shoufeng - apparently working but sparks. Needs proper maintenance','2018-01-12 13:32:32','2015-03-04 00:00:00',NULL,1,'','2015-03-04 00:00:00'),(14,9,80213,52,'Broken',52,'Nozzle blocked','2018-01-12 13:32:32','2015-03-04 00:00:00',NULL,1,'','2015-03-09 00:00:00'),(15,10,80265,55,'Broken',24,'Nozzle blocked (nozzel assembly missing!)','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'','2015-04-28 22:00:00'),(16,18,84788,55,'Broken',24,'Nozzle broken (nozzle assembly missing!)','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'','2015-05-05 22:00:00'),(17,3,82953,39,'Broken',39,'','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'','2015-03-11 00:00:00'),(18,9,80213,43,'Broken',43,'Nozzle Blocked- PLA','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'clogged nozzle','2015-03-11 00:00:00'),(19,12,80222,39,'Broken',39,'','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'','2015-03-11 00:00:00'),(20,19,83971,43,'Broken',43,'','2018-01-12 13:32:32','2015-03-09 00:00:00',NULL,1,'','2015-03-11 00:00:00'),(21,3,82953,58,'Broken',58,'','2018-01-12 13:32:32','2015-03-11 00:00:00',NULL,1,'','2015-03-11 00:00:00'),(22,17,84071,39,'Broken',39,'Not extruding properly with ABS (heating issue??)','2018-01-12 13:32:32','2015-03-11 00:00:00',NULL,1,'','2015-03-11 00:00:00'),(23,17,84071,39,'Broken',28,'Not printing correctly with ABS, very loud fan, possible heating element issue','2018-01-12 13:32:32','2015-03-11 00:00:00',NULL,1,'no problem found','2015-03-18 00:00:00'),(24,6,80151,40,'Broken',43,'Printing in very poor quality. ','2018-01-12 13:32:32','2015-03-16 00:00:00',NULL,1,'Nozzle too big, use with lowest z resoltuion','2015-03-16 00:00:00'),(25,6,80151,43,'Broken',NULL,'Doesn\'t heat up nozzle','2018-01-12 13:33:04','2015-03-16 00:00:00',NULL,0,'',NULL),(26,21,63120,52,'Missing',7,'Cooper and I  can\'t find it ','2018-01-12 13:33:03','2015-03-18 00:00:00',NULL,1,'Found to be with Maurice Jones','2015-07-12 22:00:00'),(27,8,80211,58,'Broken',43,'Nozzle Blocked','2018-01-12 13:33:04','2015-03-25 00:00:00',NULL,1,'wasn\'t broken','2015-03-31 22:00:00'),(28,13,80233,7,'Broken',43,'platform too hot - platform temperature shows reading of above 300','2018-01-12 13:33:04','2015-03-31 22:00:00',NULL,1,'heating element repaired temporarily','2015-03-31 22:00:00'),(29,19,83971,40,'Broken',24,'Nozzle was missing when we started our shift: not logged by anyone else','2018-01-12 13:33:04','2015-03-31 22:00:00',NULL,1,'','2015-04-28 22:00:00'),(30,17,84071,40,'Broken',43,'Blocked nozzle: have put in acetone','2018-01-12 13:33:04','2015-03-31 22:00:00',NULL,1,'','2015-04-14 22:00:00'),(31,13,80233,55,'Broken',24,'Nozzle blocked','2018-01-12 13:33:04','2015-04-21 22:00:00',NULL,1,'','2015-04-21 22:00:00'),(32,8,80211,40,'Broken',24,'Fan problems','2018-01-12 13:33:03','2015-04-21 22:00:00',NULL,1,'','2015-12-17 00:00:00'),(33,13,80233,7,'Broken',54,' wire for powering the platform heating element is burned through - temporary fix from before prevented another shortcut but now again the platform isn\'t heating up...','2018-01-12 13:33:04','2015-04-26 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(34,11,80215,52,'Broken',35,'Nozzle blocked','2018-01-12 13:33:04','2015-04-28 22:00:00',NULL,1,'','2015-05-05 22:00:00'),(35,4,83908,35,'Broken',58,'The board doesnt heat up','2018-01-12 13:33:04','2015-05-05 22:00:00',NULL,1,'','2015-05-19 22:00:00'),(36,19,83971,35,'Broken',24,'nozzle broken','2018-01-12 13:33:04','2015-05-05 22:00:00',NULL,1,'','2015-05-10 22:00:00'),(37,12,80222,40,'Broken',58,'Raft is not attaching to perf board correctly. I\'m not sure if it is because the board is not heating properly or because the nozzle is really dirty (on the exterior) which keeps pulling the raft away. ','2018-01-12 13:33:04','2015-05-10 22:00:00',NULL,1,'','2015-05-19 22:00:00'),(38,16,82908,39,'Broken',58,'Motor making a clunking noise and not extruding','2018-01-12 13:33:04','2015-05-12 22:00:00',NULL,1,'','2015-05-19 22:00:00'),(39,2,63116,39,'Broken',24,'Nozzle is overheating','2018-01-12 13:33:04','2015-05-12 22:00:00',NULL,1,'fixed','2015-05-12 22:00:00'),(40,23,82945,7,'Broken',52,'unaware of issue but marked as broken - please check','2018-01-12 13:33:04','2015-05-31 22:00:00',NULL,1,'assumed to be working','2015-09-08 22:00:00'),(41,11,80215,7,'Broken',54,'unaware but marked as broken - please check...','2018-01-12 13:33:03','2015-05-31 22:00:00',NULL,1,'Tested and seemed to be working.','2015-07-14 22:00:00'),(42,22,84047,52,'Broken',54,'Nozzle blocked','2018-01-12 13:33:04','2015-06-01 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(43,17,84071,7,'Missing',7,'printer was not found in ws this afternoon. No Loan form has been completed','2018-01-12 13:33:03','2015-06-08 22:00:00',NULL,1,'given on loan to rocket GDP but no form filled (people from group said they did so)','2015-06-09 22:00:00'),(44,28,503090,22,'Broken',24,'material leaks out of printer','2018-01-12 13:33:03','2015-06-08 22:00:00',NULL,1,'It is working now','2015-08-11 22:00:00'),(45,1,63514,54,'Missing',52,'Printer not found (maybe the one in B25? or on Loan by Mohammed Vaezi?)','2018-01-12 13:33:04','2015-03-04 00:00:00',NULL,1,'was on Loan','2015-06-23 22:00:00'),(46,5,83906,24,'Missing',22,'missing since easter (return from loan by rrnp2g13 to be confirmed) recently spotted in Building 5','2018-01-12 13:33:04','2015-06-14 22:00:00',NULL,0,'',NULL),(47,10,80265,52,'Broken',54,'PLA Sedimentation in the nozzle ','2018-01-12 13:33:52','2015-06-23 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(48,19,83971,52,'Broken',54,'PLA sedimentation in the nozzle','2018-01-12 13:33:52','2015-06-23 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(49,18,84788,7,'Broken',52,'blocked with PLA','2018-01-12 13:33:52','2015-06-30 22:00:00',NULL,1,'','2015-09-08 22:00:00'),(50,20,84097,54,'Broken',28,'Filament not extruding','2018-01-12 13:33:52','2015-07-14 22:00:00',NULL,1,'','2015-09-01 22:00:00'),(51,11,80215,26,'Broken',40,'Making lots of clicking sounds ','2018-01-12 13:33:52','2015-08-11 22:00:00',NULL,1,'','2015-09-01 22:00:00'),(52,11,80215,40,'Broken',55,'Print failed filament did not lay properly','2018-01-12 13:33:52','2015-09-01 22:00:00',NULL,1,'','2016-01-27 00:00:00'),(53,18,84788,39,'Broken',54,'Blocked nozzle','2018-01-12 13:33:52','2015-10-05 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(54,1,63514,7,'Broken',26,'platform not steady due to movement of platform support rod','2018-01-12 13:33:52','2015-10-06 22:00:00',NULL,1,'','2015-11-02 00:00:00'),(55,23,82945,7,'Broken',54,'not connecting properly to the computer','2018-01-12 13:33:52','2015-10-06 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(56,17,84071,39,'Broken',54,'Blocked nozzle (PLA)','2018-01-12 13:33:52','2015-10-06 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(57,9,80213,54,'Broken',54,'Blocked nozzle (PLA)','2018-01-12 13:33:52','2015-10-06 22:00:00',NULL,1,'','2015-10-13 22:00:00'),(58,9,80213,54,'Broken',24,'Printer withdrawing but not extruding filament. Clicking sound.','2018-01-12 13:33:52','2015-10-13 22:00:00',NULL,1,'','2016-01-11 00:00:00'),(59,13,80233,54,'Broken',26,'Platform not heating properly. Intermittent cable connection issues probably the cause.','2018-01-12 13:33:52','2015-10-19 22:00:00',NULL,1,'Platform now heating','2015-11-02 00:00:00'),(60,4,83908,26,'Broken',24,'Platform not heating','2018-01-12 13:33:52','2015-10-20 22:00:00',NULL,1,'','2015-10-28 00:00:00'),(61,20,84097,39,'Broken',55,'Motor is broken, filament would not withdraw','2018-01-12 13:33:52','2015-10-28 00:00:00',NULL,1,'','2016-01-27 00:00:00'),(62,19,83971,39,'Broken',26,'Nozzle blocked. ABS. Nozzle in acetone.','2018-01-12 13:33:52','2015-10-28 00:00:00',NULL,1,'unblocked nozzle, replaced fan with one from printer 9 which is already broken','2015-11-02 00:00:00'),(63,19,83971,44,'Broken',24,'Nozzle blocked and placed in acetone - no replacement nozzle found.','2018-01-12 13:33:52','2015-11-04 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(64,4,83908,54,'Broken',24,'Platform not heating','2018-01-12 13:33:52','2015-11-04 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(65,18,84788,39,'Broken',28,'filament stops extruding after five layers, repeatedly. Extrudes fine in tests.','2018-01-12 13:33:52','2015-11-04 00:00:00',NULL,1,'','2015-11-18 00:00:00'),(66,3,82953,39,'Broken',24,'Step motor broken','2018-01-12 13:33:52','2015-11-11 00:00:00',NULL,1,'','2015-11-18 00:00:00'),(67,17,84071,54,'Broken',28,'Nozzle not heating properly. ','2018-01-12 13:33:52','2015-11-18 00:00:00',NULL,1,'','2015-11-18 00:00:00'),(68,1,63514,54,'Broken',26,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2015-12-09 00:00:00'),(69,2,63116,54,'Broken',24,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(70,3,82953,54,'Broken',24,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(71,13,80233,54,'Broken',24,'Blocked Nozzle, now in acetone- Muscutt 09/12/2015','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(72,17,84071,54,'Broken',24,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(73,22,84047,54,'Broken',26,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2015-12-09 00:00:00'),(74,10,80265,54,'Broken',26,'Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2015-12-09 00:00:00'),(75,12,80222,54,'Missing',54,'Could not find printer in cupboard. In purple folder, the only \'open\' loan form suggested it was taken in July but had last been updated in October 2015 on the spreadsheet. ','2018-01-12 13:33:52','2015-12-02 00:00:00',NULL,1,'','2015-12-02 00:00:00'),(76,24,503039,7,'Missing',24,'Up Box not in workshop - no loan form completed on or offline (with Shoufeng)','2018-01-12 13:33:52','2015-12-17 00:00:00',NULL,1,'','2016-01-11 00:00:00'),(77,18,84788,27,'Broken',55,'Blocked Nozle','2018-01-12 13:33:52','2016-01-12 00:00:00',NULL,1,'nozzle fixed','2016-01-27 00:00:00'),(78,26,503063,8,'Broken',7,'Found a printer w/ not heating nozzle from previous sessions. Students and Tim Wolman have issues printing because the printer is not heating up.','2018-01-12 13:33:52','2016-01-13 00:00:00',NULL,1,'repaired by Chris - calibration sensor is still broken but printer is able to print again','2016-02-01 00:00:00'),(79,19,83971,27,'Broken',55,'Not extruding material','2018-01-12 13:33:52','2016-01-14 00:00:00',NULL,1,'','2016-01-27 00:00:00'),(80,13,80233,27,'Broken',55,'Not recognised by computer','2018-01-12 13:33:52','2016-01-14 00:00:00',NULL,1,'','2016-01-27 00:00:00'),(81,10,80265,54,'Broken',55,'Marked as broken when arrived for shift. ','2018-01-12 13:33:52','2016-01-20 00:00:00',NULL,1,'','2016-01-27 00:00:00'),(82,9,80213,10,'Broken',55,'nozel blocked ','2018-01-12 13:33:52','2016-01-20 00:00:00',NULL,1,'','2016-01-27 00:00:00'),(83,16,82908,55,'Broken',10,'lose y-axis belt','2018-01-12 13:33:52','2016-01-27 00:00:00',NULL,1,'','2017-02-22 00:00:00'),(84,19,83971,44,'Broken',55,'Not extruding','2018-01-12 13:33:52','2016-02-03 00:00:00',NULL,1,'','2016-02-10 00:00:00'),(85,2,63116,10,'Broken',26,'stepper motor does not feed filament ','2018-01-12 13:33:52','2016-02-03 00:00:00',NULL,1,'','2016-02-24 00:00:00'),(86,4,83908,10,'Broken',7,'leveling spring for base is inside x-axis arm ','2018-01-12 13:33:52','2016-02-03 00:00:00',NULL,1,'Spring removed, printer put back together and bed leveled','2016-02-10 00:00:00'),(87,20,84097,27,'Broken',55,'Blocked nozel not extruding','2018-01-12 13:33:52','2016-02-10 00:00:00',NULL,1,'','2016-02-10 00:00:00'),(88,26,503063,27,'Broken',54,'Z axis not alligned','2018-01-12 13:33:52','2016-02-10 00:00:00',NULL,1,'No note on printer and seemed to be working','2016-04-12 22:00:00'),(89,10,80265,27,'Broken',44,'Nozel blocked','2018-01-12 13:33:52','2016-02-10 00:00:00',NULL,1,'Entire new nozzle head assembly installed, old head placed into box of broken bits','2016-02-17 00:00:00'),(90,11,80215,27,'Broken',44,'Blocked nozel','2018-01-12 13:33:52','2016-02-10 00:00:00',NULL,1,'Replaced nozzle, cleaned out stepper motor','2016-02-17 00:00:00'),(91,22,84047,10,'Broken',10,'fan not working ','2018-01-12 13:33:52','2016-02-17 00:00:00',NULL,1,'','2016-02-17 00:00:00'),(92,13,80233,44,'Broken',19,'Printer bed does not heat up','2018-01-12 13:33:52','2016-02-17 00:00:00',NULL,1,'','2016-02-24 00:00:00'),(93,22,84047,10,'Broken',26,'nozel assembly is blocked ','2018-01-12 13:33:52','2016-02-24 00:00:00',NULL,1,'Unblocked Nozzle','2016-03-09 00:00:00'),(94,19,83971,26,'Broken',26,'Heating element wire snapped','2018-01-12 13:33:52','2016-03-02 00:00:00',NULL,1,'Soldered heating element wire','2016-03-02 00:00:00'),(95,13,80233,10,'Broken',26,'fixed but needs new nozzle','2018-01-12 13:33:52','2016-03-02 00:00:00',NULL,1,'soldered loose connection in plate heating element and new nozzle','2016-03-09 00:00:00'),(96,19,83971,27,'Broken',26,'Blocked Noozle','2018-01-12 13:33:52','2016-03-09 00:00:00',NULL,1,'unblocked nozzle and heating block','2016-03-09 00:00:00'),(97,10,80265,26,'Broken',26,'plate not heating','2018-01-12 13:33:52','2016-03-09 00:00:00',NULL,1,'changed platform heating element - took the one from printer 6','2016-03-09 00:00:00'),(98,19,83971,26,'Broken',26,'Platform not heating','2018-01-12 13:33:52','2016-03-09 00:00:00',NULL,1,'Soldered loose connection in plate heating element and new fan','2016-03-09 00:00:00'),(99,19,83971,36,'Broken',10,'filament locked inside the nozzle (NO withdraw and extrude)','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'','2016-05-03 22:00:00'),(100,23,82945,44,'Broken',44,'Nozzle blocked, no replacement nozzles that can be put on (3 are bent and need to be drilled out by Chris).  Put into cupboard without nozzle head','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'replaced nozzle','2016-03-16 00:00:00'),(101,8,80211,44,'Broken',26,'Motion program, can not be found. refused to initialise','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'Oiled z-axis timing belt and linear slide','2016-03-16 00:00:00'),(102,22,84047,44,'Broken',44,'Blocked nozzle, no replacements.  3 available nozzles need drilling as non round.  Speak to Chris on Monday.','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'','2016-03-11 00:00:00'),(103,3,82953,44,'Broken',44,'Blocked nozzle.','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'Replaced nozzle','2016-03-16 00:00:00'),(104,4,83908,44,'Broken',44,'Blocked nozzle','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'','2016-03-11 00:00:00'),(105,15,80214,44,'Broken',26,'Bed does not rise fully.  Jams half way up','2018-01-12 13:33:52','2016-03-11 00:00:00',NULL,1,'','2016-03-16 00:00:00'),(106,8,80211,25,'Broken',7,'it wouldn\'t download the printing program','2018-01-12 13:33:52','2016-03-23 00:00:00',NULL,1,'tested with small sample and worked','2016-05-03 22:00:00'),(107,13,80233,19,'Broken',27,'it cannot withdraw','2018-01-12 13:33:52','2016-03-23 00:00:00',NULL,1,'blocked motor material was removed','2016-04-19 22:00:00'),(108,15,80214,44,'Broken',7,'Bed skips whilst traversing z axis','2018-01-12 13:33:52','2016-03-23 00:00:00',NULL,1,'opened printer - no obvious obstructing parts. 3D printed guide one the left seems broken but not necessary for print - might cause problem in future. Printer tested and skipping stopped even after reassembly.','2016-05-03 22:00:00'),(109,31,508611,27,'Broken',10,'Possible Sd card error','2018-01-12 13:33:52','2016-04-12 22:00:00',NULL,1,'','2016-11-01 00:00:00'),(110,26,503063,27,'Broken',7,'Gear not turning when extruding','2018-01-12 13:33:52','2016-04-19 22:00:00',NULL,1,'works again','2016-04-26 22:00:00'),(111,15,80214,7,'Broken',25,'printer broke again half way during the test print','2018-01-12 13:33:52','2016-05-03 22:00:00',NULL,1,'Vertical rail clip was broken, it has been replaced and other 3 clips 3d printed.','2016-05-03 22:00:00'),(112,13,80233,10,'Broken',25,'nozzle blocked','2018-01-12 13:33:52','2016-05-03 22:00:00',NULL,1,'Nozzle was blocked. Replaced nozzle and fan support which had melted onto the nozzle.','2016-05-03 22:00:00'),(113,24,503039,24,'Broken',30,'extruder blocked','2018-01-12 13:33:52','2016-06-05 22:00:00',NULL,1,'cleaned the gears','2016-06-07 22:00:00'),(114,13,80233,25,'Broken',28,'platform heating element not working','2018-01-12 13:33:52','2016-06-07 22:00:00',NULL,1,'','2017-03-22 00:00:00'),(115,18,84788,7,'Broken',26,'nozzle too cool/ too hot error - nozzle heating element and sensor loose and cable looks very dark (maybe burned)','2018-01-12 13:33:52','2016-06-07 22:00:00',NULL,1,'','2017-01-23 00:00:00'),(116,29,508733,28,'Broken',28,'Nozzle was jamed','2018-01-12 13:33:52','2016-06-07 22:00:00',NULL,1,'','2016-06-07 22:00:00'),(117,29,508733,30,'Broken',30,'not extruding during print','2018-01-12 13:33:52','2016-06-14 22:00:00',NULL,1,'repaired','2016-06-21 22:00:00'),(118,30,508579,7,'Broken',13,'Buttons not working -> boxed up in the workshop','2018-01-12 12:17:37','2016-07-27 22:00:00',NULL,1,'Buttons working,','2017-11-08 10:33:04'),(119,15,80214,21,'Broken',NULL,'Platform is stuck AND cannot load motion program','2018-01-12 13:34:01','2016-10-11 22:00:00',NULL,0,'',NULL),(120,21,63120,10,'Broken',28,'nozzel not extruding','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'','2016-11-01 00:00:00'),(121,1,63514,10,'Broken',26,'platform not moving properly','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'Cleaned thermometer and nozzle heating element','2017-01-25 00:00:00'),(122,12,80222,12,'Broken',26,'Gives \"Cannot read printer parameters and \"Motion program not found\" errors','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'Switched on and off again','2017-01-25 00:00:00'),(123,3,82953,10,'Broken',28,'stepper motor issue','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'','2016-11-23 00:00:00'),(124,17,84071,10,'Broken',28,'not extruding','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'','2016-11-02 00:00:00'),(125,19,83971,12,'Broken',21,'nozzle blocked','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'','2017-01-18 00:00:00'),(126,17,84071,26,'Broken',25,'Y-axis timing belt loose','2018-01-12 13:34:28','2016-11-02 00:00:00',NULL,1,'Replaced y-axis timing belt gear holder with costom made part','2017-01-25 00:00:00'),(127,8,80211,10,'Broken',28,'SD card error & blocked nozzle','2018-01-12 13:34:28','2016-11-09 00:00:00',NULL,1,'','2017-03-01 00:00:00'),(128,26,503063,28,'Broken',28,'Nozzle blocked?','2018-01-12 13:34:28','2016-11-09 00:00:00',NULL,1,'','2016-11-09 00:00:00'),(129,28,503090,28,'Broken',13,'The nozzle was not heated up','2018-01-12 13:34:28','2016-11-09 00:00:00',NULL,1,'Replaced extruder PCB and ribbon cable. White ribbon cable had 2 bent pins which were unbent.','2017-10-07 15:35:22'),(130,21,63120,10,'Broken',26,'plate moving too high during print blocking nozzel','2018-01-12 13:34:28','2016-12-14 00:00:00',NULL,1,'','2017-01-25 00:00:00'),(131,4,83908,64,'Broken',26,'','2018-01-12 13:34:28','2017-01-25 00:00:00',NULL,1,'','2017-01-25 00:00:00'),(132,20,84097,28,'Broken',26,'Nozzle issue','2018-01-12 13:34:28','2017-01-25 00:00:00',NULL,1,'','2017-01-25 00:00:00'),(133,11,80215,26,'Broken',26,'Z axiz loose','2018-01-12 13:34:28','2017-01-25 00:00:00',NULL,1,'','2017-01-25 00:00:00'),(134,17,84071,26,'Broken',26,'replaced z-axis guide','2018-01-12 13:34:28','2017-01-25 00:00:00',NULL,1,'Replaced z-axis guide','2017-01-25 00:00:00'),(135,20,84097,26,'Broken',26,'no nozzle','2018-01-12 13:34:28','2017-01-25 00:00:00',NULL,1,'','2017-02-01 00:00:00'),(136,22,84047,26,'Broken',26,'nozzle too hot','2018-01-12 13:34:28','2017-02-01 00:00:00',NULL,1,'Replaced nozzle heating element','2017-02-01 00:00:00'),(137,22,84047,26,'Broken',26,'printer not withdrawing','2018-01-12 13:34:28','2017-02-08 00:00:00',NULL,1,'','2017-02-22 00:00:00'),(138,3,82953,10,'Broken',10,'stepper motor blocked','2018-01-12 13:34:28','2017-02-22 00:00:00',NULL,1,'','2017-02-22 00:00:00'),(139,12,80222,12,'Broken',28,'Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','2018-01-12 13:34:28','2017-03-15 00:00:00',NULL,1,'','2017-03-15 00:00:00'),(140,8,80211,12,'Broken',28,'Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','2018-01-12 13:34:28','2017-03-15 00:00:00',NULL,1,'','2017-03-15 00:00:00'),(141,12,80222,28,'Broken',NULL,'Frames vibrate a lot','2018-01-12 13:34:33','2017-03-22 00:00:00',NULL,0,'',NULL),(142,17,84071,12,'Broken',10,'Takes ages to heat up (something of the order of 15 minutes), then does not print at all.','2018-01-12 13:35:23','2017-04-11 22:00:00',NULL,1,'','2017-04-18 22:00:00'),(143,3,82953,10,'Broken',10,'stepper motor jammed ','2018-01-12 13:35:23','2017-04-18 22:00:00',NULL,1,'','2017-04-18 22:00:00'),(144,22,84047,10,'Broken',10,'nozzle blocked','2018-01-12 13:35:23','2017-04-18 22:00:00',NULL,1,'','2017-04-18 22:00:00'),(145,3,82953,10,'Broken',21,'heating too high and not extruding ','2018-01-12 13:35:23','2017-04-25 22:00:00',NULL,1,'Replaced the extruder','2017-07-11 22:00:00'),(146,4,83908,15,'Broken',16,'Blocked extruder ','2018-01-12 13:35:23','2017-05-09 22:00:00',NULL,1,'Printer had been fixed in the interim between entering into the old system and finding it on the new system. Logged by Daniel Wallace (as was the last update, although it says T. Medjnoun!)','2017-05-09 22:00:00'),(147,20,84097,15,'Broken',16,'Blocked extruder','2018-01-12 13:35:23','2017-07-04 22:00:00',NULL,1,'Printer fixed before today but not logged as such. Tested fully working','2017-07-04 22:00:00'),(149,24,503039,13,'Broken',NULL,'Multiple extruders and nozzles tried, did not fix issue. Sometimes prints for a couple minutes but will almost always jam.','2018-01-12 12:17:37','2017-08-09 07:57:24','Not extruding',0,NULL,'2017-08-09 07:57:24'),(150,29,508733,13,'Broken',NULL,'Multiple extruders tried. Extruder PCB replaced. Ribbon cable replaced.','2018-01-12 12:17:37','2017-08-09 08:03:59','Extruder stepper motor not turning',0,NULL,'2017-08-09 08:03:59'),(151,18,84788,14,'Available',16,'Nose needs cleaning, not  extruding material. noise coming from nozzle every attempt to extrude.','2018-01-12 12:17:36','2017-08-09 13:05:34','Not extruding material.',1,'Hot end was blocked - exchanged heater block and nozzle with a set from the acetone jar. Tested, fully working.','2017-08-23 11:40:16'),(152,16,82908,16,'Broken',NULL,'Printer has no bed assembly or extruder assembly.','2018-01-12 12:17:37','2017-08-23 12:01:20','Cannibalised for parts',0,NULL,'2017-08-23 12:01:20'),(153,3,82953,16,'Available',16,'The head of one bed levelling screw has sheared off, leaving just the shaft of the screw in place. The shaft will need to be drilled out or gripped with mole grips and unscrewed. A new screw and spring are required.','2018-01-12 12:17:37','2017-08-23 12:23:45','Bed levelling screw and spring',1,'Old screw removed, new one fitted','2017-08-30 12:55:53'),(154,8,80211,16,'Missing',NULL,'Printer must be signed out if it is working and not in B13.','2018-01-12 12:17:36','2017-08-30 10:12:43','Printer not in cupboard',0,NULL,'2017-08-30 10:12:43'),(155,10,80265,16,'Missing',NULL,'Printer must be signed out on website if it is working and not in the cupboard in B13','2018-01-12 12:17:36','2017-08-30 10:14:08','Printer not in cupboard',0,NULL,'2017-08-30 10:14:08'),(156,31,508611,13,'Broken',NULL,'Potential fixes. New Thermistor, new white ribbon cable','2018-01-12 12:17:37','2017-10-10 09:28:14','Print head temperature error',0,NULL,'2017-10-10 09:28:14'),(157,26,503063,13,'Broken',NULL,'Filament jams more often than not making long prints unfeasible if there is a significant amount of retraction, ie vases work of. Also temp reads to hot','2018-01-12 12:17:37','2017-11-08 10:22:00','Extrusion Problems',0,NULL,'2017-11-08 10:22:00'),(158,4,83908,22,'Available',16,'For some reason, even after initializing many times, the platform temperature appeared to be really high c.a. 300C, that was not the case, the platform was cold. But the software did not allow the print to carry on...','2018-01-12 12:17:37','2017-11-15 14:15:36','Strange Platform temperature',1,'One lead of the bed thermistor had been pulled out of the PCB under the bed assembly. I resoldered it back on and reinforced the other connection with a bit more solder. \r\n\r\nPrinter now working with confirmed test print.','2018-01-10 13:46:01'),(159,19,83971,9,'Available',16,'This printer came up with an error message saying that the nozzle was too hot. Printing was stopped and I turned the printer off and on again. It then extruded fine but then after the first couple raft layers it made knocking noises and no filament was extruded. I think the nozzle may need cleaning?','2018-01-12 12:17:37','2018-01-10 11:53:44','It would not print and made knocking sounds',1,'Replaced nozzle and left blocked one in acetone. Confirm print success with new nozzle','2018-01-10 12:25:36');
/*!40000 ALTER TABLE `fault_datas` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-12 16:16:10
