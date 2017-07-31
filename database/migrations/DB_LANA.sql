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
-- Table structure for table `Blacklist`
--

DROP TABLE IF EXISTS `Blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Blacklist` (
  `Date_of_entry` varchar(10) NOT NULL,
  `Person_Name` varchar(30) NOT NULL,
  `User_Name` char(10) DEFAULT NULL,
  `Student ID` int(11) DEFAULT NULL,
  `Reason` text,
  `Days Blocked` int(11) DEFAULT NULL,
  `Days Remaining` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Recording Sheet | Soton 3D Printing - Blacklist_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blacklist`
--

LOCK TABLES `Blacklist` WRITE;
/*!40000 ALTER TABLE `Blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `Blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recording Sheet - Soton 3D Printing - Fault Data`
--

DROP TABLE IF EXISTS `Recording Sheet - Soton 3D Printing - Fault Data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recording Sheet - Soton 3D Printing - Fault Data` (
  `printers_id` text,
  `serial_number` int(11) DEFAULT NULL,
  `users_name_created_issue` text,
  `printer_status` text,
  `body` text,
  `users_name_resolved_issue` text,
  `message_resolved` text,
  `days_out_of_order` int(11) DEFAULT NULL,
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `resolved` tinyint(4) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=148 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recording Sheet - Soton 3D Printing - Fault Data`
--

LOCK TABLES `Recording Sheet - Soton 3D Printing - Fault Data` WRITE;
/*!40000 ALTER TABLE `Recording Sheet - Soton 3D Printing - Fault Data` DISABLE KEYS */;
INSERT INTO `Recording Sheet - Soton 3D Printing - Fault Data` (`printers_id`, `serial_number`, `users_name_created_issue`, `printer_status`, `body`, `users_name_resolved_issue`, `message_resolved`, `days_out_of_order`, `id`, `resolved`, `created_at`, `updated_at`) VALUES ('Printer 9',80213,'J. Van der Kindere','Broken','','C. Cooper','',5,1,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'C. Cooper','Broken','','F. Zhang','',7,2,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 15',80214,'J. Van der Kindere','Broken','extruder assembly missing (previous note: Loose platform support on the right guide of the structure for printer 15 \"15/05/2014\")','L. Muscutt','',392,3,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'T. Standen','Broken','','J. Van der Kindere','',7,4,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 5',83906,'J. Van der Kindere','Missing','','D. Newman','found to be on loan',30,5,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 7',80210,'J. Van der Kindere','Missing','','L. Wollatz','Was returned to Chris - probably the one previously used for software test in B25',141,6,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 14',80261,'J. Van der Kindere','Missing','with professor?','','',892,7,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 21',63120,'L. Wollatz','Missing','','S. Yang','found to be on loan',7,8,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 6',80151,'','Broken','Faulty extruder motor','','',9,9,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'L. Wollatz','Broken','nozzle blocked','J. Van der Kindere','',0,10,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'L. Wollatz','Broken','nozzle only extruding from maintenance','J. Van der Kindere','',0,11,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 2',63116,'D. Newman','Broken','nozzle blocked- put in filament','D. Newman','',0,12,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'T. Standen','Broken','User spoke to Shoufeng - apparently working but sparks. Needs proper maintenance','T. Standen','',0,13,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 9',80213,'S. Mestry','Broken','Nozzle blocked','S. Mestry','',5,14,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'W. Keum','Broken','Nozzle blocked (nozzel assembly missing!)','J. Tang','',51,15,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'W. Keum','Broken','Nozzle broken (nozzle assembly missing!)','J. Tang','',58,16,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'D. Newman','Broken','','D. Newman','',2,17,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 9',80213,'J. Van der Kindere','Broken','Nozzle Blocked- PLA','J. Van der Kindere','clogged nozzle',2,18,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'T. Standen','Broken','','T. Standen','',2,19,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'J. Van der Kindere','Broken','','J. Van der Kindere','',2,20,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'Y. Chen','Broken','','Y. Chen','',0,21,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'D. Newman','Broken','Not extruding properly with ABS (heating issue??)','D. Newman','',0,22,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'D. Newman','Broken','Not printing correctly with ABS, very loud fan, possible heating element issue','S. Zhou','no problem found',7,23,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 6',80151,'C. Cooper','Broken','Printing in very poor quality. ','J. Van der Kindere','Nozzle too big, use with lowest z resoltuion',0,24,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 6',80151,'J. Van der Kindere','Broken','Doersn\'t heat up nozzle','','',864,25,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 21',63120,'S. Mestry','Missing','Cooper and I  can\'t find it ','L. Wollatz','Found to be with Maurice Jones',117,26,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'Y. Chen','Broken','Nozzle Blocked','J. Van der Kindere','wasn\'t broken',7,27,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'L. Wollatz','Broken','platform too hot - platform temperature shows reading of above 300','J. Van der Kindere','heating element repaired temporarily',0,28,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'C. Cooper','Broken','Nozzle was missing when we started our shift: not logged by anyone else','J. Tang','',28,29,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'C. Cooper','Broken','Blocked nozzle: have put in acetone','J. Van der Kindere','',14,30,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'W. Keum','Broken','Nozzle blocked','J. Tang','',0,31,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'C. Cooper','Broken','Fan problems','J. Tang','',239,32,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'L. Wollatz','Broken',' wire for powering the platform heating element is burned through - temporary fix from before prevented another shortcut but now again the platform isn\'t heating up...','T. Standen','',170,33,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'S. Mestry','Broken','Nozzle blocked','A. Duranec','',7,34,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'A. Duranec','Broken','The board doesnt heat up','Y. Chen','',14,35,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'A. Duranec','Broken','nozzle broken','J. Tang','',5,36,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'C. Cooper','Broken','Raft is not attaching to perf board correctly. I\'m not sure if it is because the board is not heating properly or because the nozzle is really dirty (on the exterior) which keeps pulling the raft away. ','Y. Chen','',9,37,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 16',82908,'D. Newman','Broken','Motor making a clunking noise and not extruding','Y. Chen','',7,38,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 2',63116,'D. Newman','Broken','Nozzle is overheating','J. Tang','fixed',0,39,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 23',82945,'L. Wollatz','Broken','unaware of issue but marked as broken - please check','S. Mestry','assumed to be working',100,40,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'L. Wollatz','Broken','unaware but marked as broken - please check...','T. Standen','Tested and seemed to be working.',44,41,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'S. Mestry','Broken','Nozzle blocked','T. Standen','',134,42,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'L. Wollatz','Missing','printer was not found in ws this afternoon. No Loan form has been completed','L. Wollatz','given on loan to rocket GDP but no form filled (people from group said they did so)',1,43,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 28',503090,'S. Yang','Broken','material leaks out of printer','J. Tang','It is working now',64,44,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 1',63514,'T. Standen','Missing','Printer not found (maybe the one in B25? or on Loan by Mohammed Vaezi?)','S. Mestry','was on Loan',112,45,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 5',83906,'S. Yang','Missing','missing since easter (return from loan by rrnp2g13 to be confirmed) recently spotted in Building 5','','',773,46,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'S. Mestry','Broken','PLA Sedimentation in the nozzle ','T. Standen','',112,47,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'S. Mestry','Broken','PLA sedimentation in the nozzle','T. Standen','',112,48,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'L. Wollatz','Broken','blocked with PLA','S. Mestry','',70,49,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'T. Standen','Broken','Filament not extruding','S. Zhou','',49,50,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'L. Muscutt','Broken','Making lots of clicking sounds ','C. Cooper','',21,51,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'C. Cooper','Broken','Print failed filament did not lay properly','W. Keum','',147,52,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'D. Newman','Broken','Blocked nozzle','T. Standen','',8,53,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 1',63514,'L. Wollatz','Broken','platform not steady due to movement of platform support rod','L. Muscutt','',26,54,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 23',82945,'L. Wollatz','Broken','not connecting properly to the computer','T. Standen','',7,55,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'D. Newman','Broken','Blocked nozzle (PLA)','T. Standen','',7,56,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 9',80213,'T. Standen','Broken','Blocked nozzle (PLA)','T. Standen','',7,57,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 9',80213,'T. Standen','Broken','Printer withdrawing but not extruding filament. Clicking sound.','J. Tang','',89,58,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'T. Standen','Broken','Platform not heating properly. Intermittent cable connection issues probably the cause.','L. Muscutt','Platform now heating',13,59,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'L. Muscutt','Broken','Platform not heating','J. Tang','',7,60,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'D. Newman','Broken','Motor is broken, filament would not withdraw','W. Keum','',91,61,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'D. Newman','Broken','Nozzle blocked. ABS. Nozzle in acetone.','L. Muscutt','unblocked nozzle, replaced fan with one from printer 9 which is already broken',5,62,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'J. Nelson','Broken','Nozzle blocked and placed in acetone - no replacement nozzle found.','J. Tang','',68,63,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'T. Standen','Broken','Platform not heating','J. Tang','',68,64,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'D. Newman','Broken','filament stops extruding after five layers, repeatedly. Extrudes fine in tests.','S. Zhou','',14,65,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'D. Newman','Broken','Step motor broken','J. Tang','',7,66,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'T. Standen','Broken','Nozzle not heating properly. ','S. Zhou','',0,67,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 1',63514,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','L. Muscutt','',7,68,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 2',63116,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','J. Tang','',40,69,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','J. Tang','',40,70,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'T. Standen','Broken','Blocked Nozzle, now in acetone- Muscutt 09/12/2015','J. Tang','',40,71,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','J. Tang','',40,72,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','L. Muscutt','',7,73,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'T. Standen','Broken','Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','L. Muscutt','',7,74,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'T. Standen','Missing','Could not find printer in cupboard. In purple folder, the only \'open\' loan form suggested it was taken in July but had last been updated in October 2015 on the spreadsheet. ','T. Standen','',0,75,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 24',503039,'L. Wollatz','Missing','Up Box not in workshop - no loan form completed on or offline (with Shoufeng)','J. Tang','',25,76,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'M. Potticary','Broken','Blocked Nozle','W. Keum','nozzle fixed',15,77,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 26',503063,'G. Cidonio','Broken','Found a printer w/ not heating nozzle from previous sessions. Students and Tim Wolman have issues printing because the printer is not heating up.','L. Wollatz','repaired by Chris - calibration sensor is still broken but printer is able to print again',19,78,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'M. Potticary','Broken','Not extruding material','W. Keum','',13,79,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'M. Potticary','Broken','Not recognised by computer','W. Keum','',13,80,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'T. Standen','Broken','Marked as broken when arrived for shift. ','W. Keum','',7,81,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 9',80213,'K. Crawford','Broken','nozel blocked ','W. Keum','',7,82,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 16',82908,'W. Keum','Broken','lose y-axis belt','K. Crawford','',392,83,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'J. Nelson','Broken','Not extruding','W. Keum','',7,84,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 2',63116,'K. Crawford','Broken','stepper motor does not feed filament ','L. Muscutt','',21,85,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'K. Crawford','Broken','leveling spring for base is inside x-axis arm ','L. Wollatz','Spring removed, printer put back together and bed leveled',7,86,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'M. Potticary','Broken','Blocked nozel not extruding','W. Keum','',0,87,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 26',503063,'M. Potticary','Broken','Z axis not alligned','T. Standen','No note on printer and seemed to be working',63,88,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'M. Potticary','Broken','Nozel blocked','J. Nelson','Entire new nozzle head assembly installed, old head placed into box of broken bits',7,89,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'M. Potticary','Broken','Blocked nozel','J. Nelson','Replaced nozzle, cleaned out stepper motor',7,90,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'K. Crawford','Broken','fan not working ','K. Crawford','',0,91,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'J. Nelson','Broken','Printer bed does not heat up','E. Kartaki','',7,92,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'K. Crawford','Broken','nozel assembly is blocked ','L. Muscutt','Unblocked Nozzle',14,93,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'L. Muscutt','Broken','Heating element wire snapped','L. Muscutt','Soldered heating element wire',0,94,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'K. Crawford','Broken','fixed but needs new nozzle','L. Muscutt','soldered loose connection in plate heating element and new nozzle',7,95,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'M. Potticary','Broken','Blocked Noozle','L. Muscutt','unblocked nozzle and heating block',0,96,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 10',80265,'L. Muscutt','Broken','plate not heating','L. Muscutt','changed platform heating element - took the one from printer 6',0,97,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'L. Muscutt','Broken','Platform not heating','L. Muscutt','Soldered loose connection in plate heating element and new fan',0,98,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'A. De Grazia','Broken','filament locked inside the nozzle (NO withdraw and extrude)','K. Crawford','',54,99,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 23',82945,'J. Nelson','Broken','Nozzle blocked, no replacement nozzles that can be put on (3 are bent and need to be drilled out by Chris).  Put into cupboard without nozzle head','J. Nelson','replaced nozzle',5,100,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'J. Nelson','Broken','Motion program, can not be found. refused to initialise','L. Muscutt','Oiled z-axis timing belt and linear slide',5,101,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'J. Nelson','Broken','Blocked nozzle, no replacements.  3 available nozzles need drilling as non round.  Speak to Chris on Monday.','J. Nelson','',0,102,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'J. Nelson','Broken','Blocked nozzle.','J. Nelson','Replaced nozzle',5,103,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'J. Nelson','Broken','Blocked nozzle','J. Nelson','',0,104,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 15',80214,'J. Nelson','Broken','Bed does not rise fully.  Jams half way up','L. Muscutt','',5,105,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'M. Ferreira','Broken','it wouldn\'t download the printing program','L. Wollatz','tested with small sample and worked',42,106,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'E. Kartaki','Broken','it cannot withdraw','M. Potticary','blocked motor material was removed',28,107,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 15',80214,'J. Nelson','Broken','Bed skips whilst traversing z axis','L. Wollatz','opened printer - no obvious obstructing parts. 3D printed guide one the left seems broken but not necessary for print - might cause problem in future. Printer tested and skipping stopped even after reassembly.',42,108,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 31',508611,'M. Potticary','Broken','Possible Sd card error','K. Crawford','',202,109,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 26',503063,'M. Potticary','Broken','Gear not turning when extruding','L. Wollatz','works again',7,110,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 15',80214,'L. Wollatz','Broken','printer broke again half way during the test print','M. Ferreira','Vertical rail clip was broken, it has been replaced and other 3 clips 3d printed.',0,111,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'K. Crawford','Broken','nozzle blocked','M. Ferreira','Nozzle was blocked. Replaced nozzle and fan support which had melted onto the nozzle.',0,112,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 24',503039,'J. Tang','Broken','extruder blocked','P. Fenou Kenjne','cleaned the gears',2,113,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 13',80233,'M. Ferreira','Broken','platform heating element not working','S. Zhou','',287,114,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 18',84788,'L. Wollatz','Broken','nozzle too cool/ too hot error - nozzle heating element and sensor loose and cable looks very dark (maybe burned)','L. Muscutt','',229,115,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 29',508733,'S. Zhou','Broken','Nozzle was jamed','S. Zhou','',0,116,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 29',508733,'P. Fenou Kenjne','Broken','not extruding during print','P. Fenou Kengne','repaired',7,117,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 30',508579,'L. Wollatz','Broken','Buttons not working -> boxed up in the workshop','','',364,118,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 15',80214,'F. Xie','Broken','Platform is stuck AND cannot load motion program','','',288,119,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 21',63120,'K. Crawford','Broken','nozzel not extruding','S. Zhou','',-1,120,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 1',63514,'K. Crawford','Broken','platform not moving properly','L. Muscutt','Cleaned thermometer and nozzle heating element',84,121,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'A. Grammatikopoulos','Broken','Gives \"Cannot read printer parameters and \"Motion program not found\" errors','L. Muscutt','Switched on and off again',84,122,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'K. Crawford','Broken','stepper motor issue','S. Zhou','',21,123,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'K. Crawford','Broken','not extruding','S. Zhou','',0,124,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 19',83971,'A. Grammatikopoulos','Broken','nozzle blocked','F. Xie','',77,125,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'L. Muscutt','Broken','Y-axis timing belt loose','M. Ferreira','Replaced y-axis timing belt gear holder with costom made part',84,126,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'K. Crawford','Broken','SD card error & blocked nozzle','S. Zhou','',112,127,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 26',503063,'S. Zhou','Broken','Nozzle blocked?','S. Zhou','',0,128,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 28',503090,'S. Zhou','Broken','The nozzle was not heated up','','',260,129,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 21',63120,'K. Crawford','Broken','plate moving too high during print blocking nozzel','L. Muscutt','',42,130,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'','Broken','','L. Muscutt','',0,131,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'S. Zhou','Broken','Nozzle issue','L. Muscutt','',0,132,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 11',80215,'L. Muscutt','Broken','Z axiz loose','L. Muscutt','',0,133,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'L. Muscutt','Broken','replaced z-axis guide','L. Muscutt','Replaced z-axis guide',0,134,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'L. Muscutt','Broken','no nozzle','L. Muscutt','',7,135,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'L. Muscutt','Broken','nozzle too hot','L. Muscutt','Replaced nozzle heating element',0,136,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'L. Muscutt','Broken','printer not withdrawing','K. Crawford','',14,137,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'K. Crawford','Broken','stepper motor blocked','K. Crawford','',0,138,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'A. Grammatikopoulos','Broken','Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','S. Zhou','',0,139,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 8',80211,'A. Grammatikopoulos','Broken','Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','S. Zhou','',0,140,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 12',80222,'S. Zhou','Broken','Frames vibrate a lot','','',127,141,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 17',84071,'A. Grammatikopoulos','Broken','Takes ages to heat up (something of the order of 15 minutes), then does not print at all.','K. Crawford','',7,142,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'K. Crawford','Broken','stepper motor jammed ','K. Crawford','',0,143,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 22',84047,'K. Crawford','Broken','nozzle blocked','K. Crawford','',0,144,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 3',82953,'K. Crawford','Broken','heating too high and not extruding ','F. Xie','Replaced the extruder',77,145,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 4',83908,'T. Medjnoun','Broken','Blocked extruder ','','',-70,146,1,'2017-07-30 17:12:58','2017-07-30 17:12:58'),('Printer 20',84097,'T. Medjnoun','Broken','Blocked extruder','','',22,147,1,'2017-07-30 17:12:58','2017-07-30 17:12:58');
/*!40000 ALTER TABLE `Recording Sheet - Soton 3D Printing - Fault Data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_codes`
--

LOCK TABLES `cost_codes` WRITE;
/*!40000 ALTER TABLE `cost_codes` DISABLE KEYS */;
INSERT INTO `cost_codes` (`id`, `shortage`, `cost_code`, `aproving_member_of_staff`, `expires`, `holder`, `description`, `created_at`, `updated_at`) VALUES (1,'FEEG1001-AERO',510671104,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 13:10:49',NULL),(2,'FEEG1001-MECH',510671108,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 13:10:49',NULL),(3,'FEEG2001-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 13:10:49',NULL),(4,'FEEG2001-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 13:10:49',NULL),(5,'FEEG2001-MECH',510312110,'Tim Woolman','2017-09-27','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 13:10:49',NULL),(6,'FEEG6013-ACOU',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(7,'FEEG6013-AMAT',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(8,'FEEG6013-AERO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(9,'FEEG6013-AUTO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(10,'FEEG6013-BIOM',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(11,'FEEG6013-CIVI',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(12,'FEEG6013-INTE',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(13,'FEEG6013-MANA',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(14,'FEEG6013-MECH',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(15,'FEEG6013-SPAC',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(16,'FEEG6013-ENRG',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 13:10:49',NULL),(17,'FEEG6013-MARI',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 13:10:49',NULL),(18,'FEEG6013-SHIP',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 13:10:49',NULL),(19,'FEEG6013-YACH',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 13:10:49',NULL),(20,'FEEG6013-KEAN',510667102,'Tim Woolman','2017-09-27','Andrew Keane','FEE Group Design Projects Andrew Keane','2017-05-07 13:10:49',NULL),(21,'FEEG3003-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 13:10:49',NULL),(22,'FEEG3003-AUDI',510671103,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Audiology','2017-05-07 13:10:49',NULL),(23,'FEEG3003-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 13:10:49',NULL),(24,'FEEG3003-CIVI',510671105,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Civil and Environmental','2017-05-07 13:10:49',NULL),(25,'FEEG3003-ENER',510671106,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Energy','2017-05-07 13:10:49',NULL),(26,'FEEG3003-ENVI',510671107,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Environmental Science','2017-05-07 13:10:49',NULL),(27,'FEEG3003-MECH',510671108,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 13:10:49',NULL),(28,'FEEG3003-MARI',510671109,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Maritime Engineering','2017-05-07 13:10:49',NULL),(29,'SPEAKER',510671102,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 13:10:49',NULL),(30,'UAV',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 13:10:49',NULL),(31,'QUADCOPTER',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 13:10:49',NULL),(32,'EUROBOT',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 13:10:49',NULL),(33,'RESPSYS',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 13:10:49',NULL),(34,'Demonstrator',515665101,'Shoufeng Yang','2017-09-22','Shoufeng Yang',NULL,'2017-07-28 12:37:39',NULL);
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
  PRIMARY KEY (`id`),
  KEY `fault_datas_printers__fk` (`printers_id`),
  CONSTRAINT `fault_datas_printers__fk` FOREIGN KEY (`printers_id`) REFERENCES `printers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_datas`
--

LOCK TABLES `fault_datas` WRITE;
/*!40000 ALTER TABLE `fault_datas` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_updates`
--

LOCK TABLES `fault_updates` WRITE;
/*!40000 ALTER TABLE `fault_updates` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2017_04_25_194247_create_posts_table',1),(16,'2014_10_12_000000_create_users_table',2),(17,'2014_10_12_100000_create_password_resets_table',2),(18,'2017_07_01_113150_create_announcements_table',2),(19,'2017_07_12_145959_create_permission_tables',2),(20,'2017_07_29_190414_create_public_announcements_table',2);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
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
  `serial_no` int(9) NOT NULL,
  `printer_type` varchar(20) DEFAULT NULL,
  `printer_status` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `in_use` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` (`id`, `serial_no`, `printer_type`, `printer_status`, `created_at`, `updated_at`, `in_use`) VALUES (1,63514,'UP!','Broken',NULL,'2017-07-29 17:48:52',0),(2,63116,'UP!','Available',NULL,'2017-07-29 16:45:24',0),(3,82953,'UP Plus 2','Broken',NULL,'2017-07-30 11:58:32',0),(4,83908,'UP Plus 2','Available',NULL,'2017-07-29 14:06:47',0),(5,83906,'UP Plus 2','Broken',NULL,'2017-07-30 12:01:17',0),(6,80151,'UP Plus 2','Broken',NULL,'2017-07-29 14:07:27',0),(7,80210,'UP Plus 2','On Loan',NULL,NULL,0),(8,80211,'UP Plus 2','Available',NULL,'2017-07-29 13:46:45',0),(9,80213,'UP Plus 2','Broken',NULL,'2017-07-29 16:07:52',0),(10,80265,'UP Plus 2','Available',NULL,'2017-07-29 16:23:58',0),(11,80215,'UP Plus 2','Broken',NULL,'2017-07-29 16:08:53',0),(12,80222,'UP Plus 2','Broken',NULL,NULL,0),(13,80233,'UP Plus 2','Available',NULL,NULL,0),(14,80261,'UP Plus 2','Available',NULL,'2017-06-23 15:59:50',0),(15,80214,'UP Plus 2','Available',NULL,NULL,0),(16,82908,'UP Plus 2','Available',NULL,NULL,0),(17,84071,'UP Plus 2','Available',NULL,NULL,0),(18,84788,'UP Plus 2','Available',NULL,NULL,0),(19,83971,'UP Plus 2','Available',NULL,NULL,0),(20,84097,'UP Plus 2','Available',NULL,NULL,0),(21,63120,'UP!','Available',NULL,NULL,0),(22,84047,'UP Plus 2','Available',NULL,NULL,0),(23,82945,'UP Plus 2','Available',NULL,NULL,0),(24,503039,'UP BOX','Available',NULL,NULL,0),(25,503041,'UP BOX','Signed out',NULL,NULL,0),(26,503063,'UP BOX','Available',NULL,NULL,0),(27,503086,'UP BOX','Signed out',NULL,NULL,0),(28,503090,'UP BOX','Broken',NULL,NULL,0),(29,508733,'UP BOX','Available',NULL,NULL,0),(30,508579,'UP BOX','Broken',NULL,NULL,0),(31,508611,'UP BOX','Available',NULL,NULL,0),(32,464646446,'UP!','Available','2017-06-16 16:17:32','2017-06-25 10:59:52',0);
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printing_datas`
--

LOCK TABLES `printing_datas` WRITE;
/*!40000 ALTER TABLE `printing_datas` DISABLE KEYS */;
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
  `message` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_announcements`
--

LOCK TABLES `public_announcements` WRITE;
/*!40000 ALTER TABLE `public_announcements` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
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
  `id_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `role`, `updated_at`, `user_id`, `id_number`) VALUES (1,'Apostolos','Grammatikopoulos','ag3e15@soton.ac.uk','075819298485','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(2,'Chee','Hong Goh','chg1g13@soton.ac.uk','07851925072','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(4,'Erato','Kartaki','ek2e14@soton.ac.uk','07518990594','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(5,'Fulin ','Xie','fx1g12@soton.ac.uk','unknown','2017-03-26 18:26:11','unknown',NULL,NULL,NULL),(6,'Gianluca ','Cidonio','gc3e15@soton.ac.uk','unknown','2017-03-26 18:26:11','Lead Demonstrator',NULL,NULL,NULL),(7,'Jing  ','Tang','jt7g13@soton.ac.uk','07403797321','2017-03-26 18:26:11','Technical Manager',NULL,NULL,NULL),(8,'Katherine','Crawford','K.A.Crawford@soton.ac.uk','07510838851','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(9,'Lasse','Wollatz','L.Wollatz@soton.ac.uk','07418432954','2017-03-26 18:26:11','IT Manager',NULL,NULL,NULL),(10,'Luke','Muscutt','L.Muscutt@soton.ac.uk','07723325834','2017-03-26 18:26:11','PR Manager',NULL,NULL,NULL),(11,'Manuel','Ferreira','maf1v15@soton.ac.uk','unknown','2017-03-26 18:26:11','unknown',NULL,NULL,NULL),(12,'Matt','Potticary','m.potticary@soton.ac.uk','07972298383','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(13,'Patrick','Fenou Kengne','plfk1g13@soton.ac.uk','07729280929','2017-03-26 18:26:11','3D Hub Manager',NULL,NULL,NULL),(14,'Shenglong','Zhou','sz3g14@soton.ac.uk','07519533874','2017-07-30 16:44:46','Demonstrator',NULL,9,NULL),(15,'Yu','Pui-Hei','mcmicha320@gmail.com','unknown','2017-07-30 16:44:46','unknown',NULL,8,NULL),(16,'Svitlana','Braichenko','sb2g14@soton.ac.uk','07479052411','2017-07-30 16:44:46','IT','2017-07-29 18:41:02',5,NULL),(17,'Andrii','Iakovliev','ai1v14@soton.ac.uk','07479045846','2017-07-30 16:44:46','IT','2017-07-30 12:08:23',6,NULL),(18,'Hayk','Vasilyan','h.vasilyan@soton.ac.uk',NULL,'2017-07-30 16:44:46','IT','2017-07-23 17:54:31',7,12345678);
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5,'Admin','sb2g14@soton.ac.uk','$2y$10$P9uYX7nEXADt1tO8Tt2GdueVnuoxd2BPfX4gbueGyIjlZJiEqS2fC','f6INies8duXBphVqRgOeiUEtzRdSgfN0dicKo8njALqIZbYQ226gYKosf9KX','2017-07-30 12:31:44','2017-07-30 12:31:44'),(6,'LeadDemonstrator','LD@soton.ac.uk','$2y$10$JERDrcffJObag0cs4bEkpee.xiwBD.PoMcfnoSxFIFCAKn25rzxu2','07bcVw2ecUyEYYLP0UOmhRJwmJiIM1Eelt9HaD60akbEQ1DmPsIqJvNckuIA','2017-07-30 12:43:54','2017-07-30 12:43:54'),(7,'Demonstrator1','D1@soton.ac.uk','$2y$10$4DRAsquExQr1f9OWRFr4ROP./h95MGvarPkd4zeVrS9Zg6kinp1ty','lmQJCrYsjcdhiHOpwc7Q7NcF9Zw3ESdEOtTYqc40ZzL8bEoZVEYFOJl5wtO6','2017-07-30 12:44:23','2017-07-30 12:44:23'),(8,'NewDemonstrator1','ND1@soton.ac.uk','$2y$10$aSirAeTSUXXqn.aVstCNt.ahNYZI5eZFZwFyin9atEe9Uv8wrSmWS','KEBqvkIsjuesJ8vkD4iKd7rNTRMQ5b50yaXt3zFRGA8d7EdIuEppDCyX7PX2','2017-07-30 12:44:57','2017-07-30 12:44:57'),(9,'OldDemonstrator1','OD1@soton.ac.uk','$2y$10$C8b6NszOZ9WF9m0N10ELYuki0vUzoMcDjD47VR13JyX3FS.yNzLpi',NULL,'2017-07-30 12:45:30','2017-07-30 12:45:30');
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

-- Dump completed on 2017-07-30 18:17:52
