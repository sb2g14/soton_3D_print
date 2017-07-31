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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Blacklist`
--

LOCK TABLES `Blacklist` WRITE;
/*!40000 ALTER TABLE `Blacklist` DISABLE KEYS */;
INSERT INTO `Blacklist` (`Date_of_entry`, `Person_Name`, `User_Name`, `Student ID`, `Reason`, `Days Blocked`, `Days Remaining`, `id`) VALUES ('02/03/2015','William Kumordzie','wsk1g11',423378107,'Printer returned late',30,0,1),('04/03/2015','Adam Boxer','',424797642,'Printer returned late',30,0,2),('16/03/2015','Alex Davey','amd1g13',426241048,'Printer returned late',30,0,3),('25/03/2015','Mai Thanh Trung','ttm1m12',425930559,'Printer returned late',30,0,4),('25/03/2015','Jhimi Sherpa','js35g13',426171724,'Printer returned late',30,0,5),('25/03/2015','Chaitawya Aqarwal','cva1v12',426545578,'Printer returned late',30,0,6),('01/04/2015','Luoh Long Chan','llc1g13',426598094,'Printer returned delayed',15,0,7),('27/04/2015','Richard Jones','',425917323,'Printer returned with items missing (sensor cable + filament tube)',60,0,8),('27/04/2015','Nikesh Patek','np9g12',425402718,'Printer returned one month late+tweezer missing (said its at his home and that he will return it)',1800,1095,9),('27/04/2015','Nikesh Patek','np9g12',425902781,'usage of multiple IDs',1800,1095,10),('27/04/2015','Nikesh Patek','np9g12',427268519,'usage of multiple IDs',1800,1095,11),('27/04/2015','Faris Yusef','fbmy1g13',426357585,'Printer returned late',30,0,12),('29/04/2015','Morik Daramy','md9g13',425969749,'Printer returned late',480,0,13),('06/05/2015','Hirad Gouda','hg9g13',426219667,'Printer returned late',30,0,14),('06/05/2015','Jerome Carson','jac1g13',425916513,'Printer returned late',30,0,15),('11/05/2015','Matthew Telfer','mft1g13',426432315,'Retruned missing equipment',7,0,16),('11/05/2015','Marrie Willis','',425936069,'Returned missing equipment',7,0,17),('11/05/2015','Nur Hj Ismail','nini1e13',426070073,'Returned late',30,0,18),('11/05/2015','Emma Goy','elg1n12',426115638,'Printer returned late',30,0,19),('11/05/2015','Nur Hjlsmail','',426070073,'Returned late',30,0,20),('15/06/2016','Formula Student','mm3g14',427169847,'several prints not recorded properly and printing without permission',90,0,21);
/*!40000 ALTER TABLE `Blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fault_data`
--

DROP TABLE IF EXISTS `Fault_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Fault_data` (
  `Printer_ID` varchar(11) NOT NULL,
  `Serial_number` int(9) NOT NULL,
  `Date` date NOT NULL,
  `Demonstrater Sign` text,
  `Printer Status` text,
  `Repair Date` text NOT NULL,
  `Repair Demonstrater Sign` text,
  `Days Out of Order` int(11) NOT NULL,
  `id` int(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Fault_data_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fault_data`
--

LOCK TABLES `Fault_data` WRITE;
/*!40000 ALTER TABLE `Fault_data` DISABLE KEYS */;
INSERT INTO `Fault_data` (`Printer_ID`, `Serial_number`, `Date`, `Demonstrater Sign`, `Printer Status`, `Repair Date`, `Repair Demonstrater Sign`, `Days Out of Order`, `id`) VALUES ('Printer 9',80213,'2015-02-11','J. Van der Kindere','Broken','2015-02-16','C. Cooper',5,1),('Printer 10',80265,'2015-02-16','C. Cooper','Broken','2015-02-23','F. Zhang',7,2),('Printer 15',80214,'2015-02-11','J. Van der Kindere','Broken','2016-03-09','L. Muscutt',392,3),('Printer 19',83971,'2015-02-16','T. Standen','Broken','2015-02-23','J. Van der Kindere',7,4),('Printer 5',83906,'2015-02-10','J. Van der Kindere','Missing','2015-03-12','D. Newman',30,5),('Printer 7',80210,'2015-02-10','J. Van der Kindere','Missing','2015-07-01','L. Wollatz',141,6),('Printer 14',80261,'2015-02-16','J. Van der Kindere','Missing','1900-01-00','',775,7),('Printer 21',63120,'2015-02-20','L. Wollatz','Missing','2015-02-27','S. Yang',7,8),('Printer 6',80151,'2015-02-23','','Broken','2015-03-04','',9,9),('Printer 4',83908,'2015-02-23','L. Wollatz','Broken','2015-02-23','J. Van der Kindere',0,10),('Printer 3',82953,'2015-02-23','L. Wollatz','Broken','2015-02-23','J. Van der Kindere',0,11),('Printer 2',63116,'2015-03-02','D. Newman','Broken','2015-03-02','D. Newman',0,12),('Printer 4',83908,'2015-03-04','T. Standen','Broken','2015-03-04','T. Standen',0,13),('Printer 9',80213,'2015-03-04','S. Mestry','Broken','2015-03-09','S. Mestry',5,14),('Printer 10',80265,'2015-03-09','W. Keum','Broken','2015-04-29','J. Tang',51,15),('Printer 18',84788,'2015-03-09','W. Keum','Broken','2015-05-06','J. Tang',58,16),('Printer 3',82953,'2015-03-09','D. Newman','Broken','2015-03-11','D. Newman',2,17),('Printer 9',80213,'2015-03-09','J. Van der Kindere','Broken','2015-03-11','J. Van der Kindere',2,18),('Printer 12',80222,'2015-03-09','T. Standen','Broken','2015-03-11','T. Standen',2,19),('Printer 19',83971,'2015-03-09','J. Van der Kindere','Broken','2015-03-11','J. Van der Kindere',2,20),('Printer 3',82953,'2015-03-11','Y. Chen','Broken','2015-03-11','Y. Chen',0,21),('Printer 17',84071,'2015-03-11','D. Newman','Broken','2015-03-11','D. Newman',0,22),('Printer 17',84071,'2015-03-11','D. Newman','Broken','2015-03-18','S. Zhou',7,23),('Printer 6',80151,'2015-03-16','C. Cooper','Broken','2015-03-16','J. Van der Kindere',0,24),('Printer 6',80151,'2015-03-16','J. Van der Kindere','Broken','1900-01-00','',747,25),('Printer 21',63120,'2015-03-18','S. Mestry','Missing','2015-07-13','L. Wollatz',117,26),('Printer 8',80211,'2015-03-25','Y. Chen','Broken','2015-04-01','J. Van der Kindere',7,27),('Printer 13',80233,'2015-04-01','L. Wollatz','Broken','2015-04-01','J. Van der Kindere',0,28),('Printer 19',83971,'2015-04-01','C. Cooper','Broken','2015-04-29','J. Tang',28,29),('Printer 17',84071,'2015-04-01','C. Cooper','Broken','2015-04-15','J. Van der Kindere',14,30),('Printer 13',80233,'2015-04-22','W. Keum','Broken','2015-04-22','J. Tang',0,31),('Printer 8',80211,'2015-04-22','C. Cooper','Broken','2015-12-17','J. Tang',239,32),('Printer 13',80233,'2015-04-27','L. Wollatz','Broken','2015-10-14','T. Standen',170,33),('Printer 11',80215,'2015-04-29','S. Mestry','Broken','2015-05-06','A. Duranec',7,34),('Printer 4',83908,'2015-05-06','A. Duranec','Broken','2015-05-20','Y. Chen',14,35),('Printer 19',83971,'2015-05-06','A. Duranec','Broken','2015-05-11','J. Tang',5,36),('Printer 12',80222,'2015-05-11','C. Cooper','Broken','2015-05-20','Y. Chen',9,37),('Printer 16',82908,'2015-05-13','D. Newman','Broken','2015-05-20','Y. Chen',7,38),('Printer 2',63116,'2015-05-13','D. Newman','Broken','2015-05-13','J. Tang',0,39),('Printer 23',82945,'2015-06-01','L. Wollatz','Broken','2015-09-09','S. Mestry',100,40),('Printer 11',80215,'2015-06-01','L. Wollatz','Broken','2015-07-15','T. Standen',44,41),('Printer 22',84047,'2015-06-02','S. Mestry','Broken','2015-10-14','T. Standen',134,42),('Printer 17',84071,'2015-06-09','L. Wollatz','Missing','2015-06-10','L. Wollatz',1,43),('Printer 28',503090,'2015-06-09','S. Yang','Broken','2015-08-12','J. Tang',64,44),('Printer 1',63514,'2015-03-04','T. Standen','Missing','2015-06-24','S. Mestry',112,45),('Printer 5',83906,'2015-06-15','S. Yang','Missing','1900-01-00','',656,46),('Printer 10',80265,'2015-06-24','S. Mestry','Broken','2015-10-14','T. Standen',112,47),('Printer 19',83971,'2015-06-24','S. Mestry','Broken','2015-10-14','T. Standen',112,48),('Printer 18',84788,'2015-07-01','L. Wollatz','Broken','2015-09-09','S. Mestry',70,49),('Printer 20',84097,'2015-07-15','T. Standen','Broken','2015-09-02','S. Zhou',49,50),('Printer 11',80215,'2015-08-12','L. Muscutt','Broken','2015-09-02','C. Cooper',21,51),('Printer 11',80215,'2015-09-02','C. Cooper','Broken','2016-01-27','W. Keum',147,52),('Printer 18',84788,'2015-10-06','D. Newman','Broken','2015-10-14','T. Standen',8,53),('Printer 1',63514,'2015-10-07','L. Wollatz','Broken','2015-11-02','L. Muscutt',26,54),('Printer 23',82945,'2015-10-07','L. Wollatz','Broken','2015-10-14','T. Standen',7,55),('Printer 17',84071,'2015-10-07','D. Newman','Broken','2015-10-14','T. Standen',7,56),('Printer 9',80213,'2015-10-07','T. Standen','Broken','2015-10-14','T. Standen',7,57),('Printer 9',80213,'2015-10-14','T. Standen','Broken','2016-01-11','J. Tang',89,58),('Printer 13',80233,'2015-10-20','T. Standen','Broken','2015-11-02','L. Muscutt',13,59),('Printer 4',83908,'2015-10-21','L. Muscutt','Broken','2015-10-28','J. Tang',7,60),('Printer 20',84097,'2015-10-28','D. Newman','Broken','2016-01-27','W. Keum',91,61),('Printer 19',83971,'2015-10-28','D. Newman','Broken','2015-11-02','L. Muscutt',5,62),('Printer 19',83971,'2015-11-04','J. Nelson','Broken','2016-01-11','J. Tang',68,63),('Printer 4',83908,'2015-11-04','T. Standen','Broken','2016-01-11','J. Tang',68,64),('Printer 18',84788,'2015-11-04','D. Newman','Broken','2015-11-18','S. Zhou',14,65),('Printer 3',82953,'2015-11-11','D. Newman','Broken','2015-11-18','J. Tang',7,66),('Printer 17',84071,'2015-11-18','T. Standen','Broken','2015-11-18','S. Zhou',0,67),('Printer 1',63514,'2015-12-02','T. Standen','Broken','2015-12-09','L. Muscutt',7,68),('Printer 2',63116,'2015-12-02','T. Standen','Broken','2016-01-11','J. Tang',40,69),('Printer 3',82953,'2015-12-02','T. Standen','Broken','2016-01-11','J. Tang',40,70),('Printer 13',80233,'2015-12-02','T. Standen','Broken','2016-01-11','J. Tang',40,71),('Printer 17',84071,'2015-12-02','T. Standen','Broken','2016-01-11','J. Tang',40,72),('Printer 22',84047,'2015-12-02','T. Standen','Broken','2015-12-09','L. Muscutt',7,73),('Printer 10',80265,'2015-12-02','T. Standen','Broken','2015-12-09','L. Muscutt',7,74),('Printer 12',80222,'2015-12-02','T. Standen','Missing','2015-12-02','T. Standen',0,75),('Printer 24',503039,'2015-12-17','L. Wollatz','Missing','2016-01-11','J. Tang',25,76),('Printer 18',84788,'2016-01-12','M. Potticary','Broken','2016-01-27','W. Keum',15,77),('Printer 26',503063,'2016-01-13','G. Cidonio','Broken','2016-02-01','L. Wollatz',19,78),('Printer 19',83971,'2016-01-14','M. Potticary','Broken','2016-01-27','W. Keum',13,79),('Printer 13',80233,'2016-01-14','M. Potticary','Broken','2016-01-27','W. Keum',13,80),('Printer 10',80265,'2016-01-20','T. Standen','Broken','2016-01-27','W. Keum',7,81),('Printer 9',80213,'2016-01-20','K. Crawford','Broken','2016-01-27','W. Keum',7,82),('Printer 16',82908,'2016-01-27','W. Keum','Broken','2017-02-22','K. Crawford',392,83),('Printer 19',83971,'2016-02-03','J. Nelson','Broken','2016-02-10','W. Keum',7,84),('Printer 2',63116,'2016-02-03','K. Crawford','Broken','2016-02-24','L. Muscutt',21,85),('Printer 4',83908,'2016-02-03','K. Crawford','Broken','2016-02-10','L. Wollatz',7,86),('Printer 20',84097,'2016-02-10','M. Potticary','Broken','2016-02-10','W. Keum',0,87),('Printer 26',503063,'2016-02-10','M. Potticary','Broken','2016-04-13','T. Standen',63,88),('Printer 10',80265,'2016-02-10','M. Potticary','Broken','2016-02-17','J. Nelson',7,89),('Printer 11',80215,'2016-02-10','M. Potticary','Broken','2016-02-17','J. Nelson',7,90),('Printer 22',84047,'2016-02-17','K. Crawford','Broken','2016-02-17','K. Crawford',0,91),('Printer 13',80233,'2016-02-17','J. Nelson','Broken','2016-02-24','E. Kartaki',7,92),('Printer 22',84047,'2016-02-24','K. Crawford','Broken','2016-03-09','L. Muscutt',14,93),('Printer 19',83971,'2016-03-02','L. Muscutt','Broken','2016-03-02','L. Muscutt',0,94),('Printer 13',80233,'2016-03-02','K. Crawford','Broken','2016-03-09','L. Muscutt',7,95),('Printer 19',83971,'2016-03-09','M. Potticary','Broken','2016-03-09','L. Muscutt',0,96),('Printer 10',80265,'2016-03-09','L. Muscutt','Broken','2016-03-09','L. Muscutt',0,97),('Printer 19',83971,'2016-03-09','L. Muscutt','Broken','2016-03-09','L. Muscutt',0,98),('Printer 19',83971,'2016-03-11','A. De Grazia','Broken','2016-05-04','K. Crawford',54,99),('Printer 23',82945,'2016-03-11','J. Nelson','Broken','2016-03-16','J. Nelson',5,100),('Printer 8',80211,'2016-03-11','J. Nelson','Broken','2016-03-16','L. Muscutt',5,101),('Printer 22',84047,'2016-03-11','J. Nelson','Broken','2016-03-11','J. Nelson',0,102),('Printer 3',82953,'2016-03-11','J. Nelson','Broken','2016-03-16','J. Nelson',5,103),('Printer 4',83908,'2016-03-11','J. Nelson','Broken','2016-03-11','J. Nelson',0,104),('Printer 15',80214,'2016-03-11','J. Nelson','Broken','2016-03-16','L. Muscutt',5,105),('Printer 8',80211,'2016-03-23','M. Ferreira','Broken','2016-05-04','L. Wollatz',42,106),('Printer 13',80233,'2016-03-23','E. Kartaki','Broken','2016-04-20','M. Potticary',28,107),('Printer 15',80214,'2016-03-23','J. Nelson','Broken','2016-05-04','L. Wollatz',42,108),('Printer 31',508611,'2016-04-13','M. Potticary','Broken','2016-11-01','K. Crawford',202,109),('Printer 26',503063,'2016-04-20','M. Potticary','Broken','2016-04-27','L. Wollatz',7,110),('Printer 15',80214,'2016-05-04','L. Wollatz','Broken','2016-05-04','M. Ferreira',0,111),('Printer 13',80233,'2016-05-04','K. Crawford','Broken','2016-05-04','M. Ferreira',0,112),('Printer 24',503039,'2016-06-06','J. Tang','Broken','2016-06-08','P. Fenou Kenjne',2,113),('Printer 13',80233,'2016-06-08','M. Ferreira','Broken','2017-03-22','S. Zhou',287,114),('Printer 18',84788,'2016-06-08','L. Wollatz','Broken','2017-01-23','L. Muscutt',229,115),('Printer 29',508733,'2016-06-08','S. Zhou','Broken','2016-06-08','S. Zhou',0,116),('Printer 29',508733,'2016-06-15','P. Fenou Kenjne','Broken','2016-06-22','P. Fenou Kengne',7,117),('Printer 30',508579,'2016-07-28','L. Wollatz','Broken','1900-01-00','',247,118),('Printer 15',80214,'2016-10-12','F. Xie','Broken','1900-01-00','',171,119),('Printer 21',63120,'2016-11-02','K. Crawford','Broken','2016-11-01','S. Zhou',-1,120),('Printer 1',63514,'2016-11-02','K. Crawford','Broken','2017-01-25','L. Muscutt',84,121),('Printer 12',80222,'2016-11-02','A. Grammatikopoulos','Broken','2017-01-25','L. Muscutt',84,122),('Printer 3',82953,'2016-11-02','K. Crawford','Broken','2016-11-23','S. Zhou',21,123),('Printer 17',84071,'2016-11-02','K. Crawford','Broken','2016-11-02','S. Zhou',0,124),('Printer 19',83971,'2016-11-02','A. Grammatikopoulos','Broken','2017-01-18','F. Xie',77,125),('Printer 17',84071,'2016-11-02','L. Muscutt','Broken','2017-01-25','M. Ferreira',84,126),('Printer 8',80211,'2016-11-09','K. Crawford','Broken','2017-03-01','S. Zhou',112,127),('Printer 26',503063,'2016-11-09','S. Zhou','Broken','2016-11-09','S. Zhou',0,128),('Printer 28',503090,'2016-11-09','S. Zhou','Broken','1900-01-00','',143,129),('Printer 21',63120,'2016-12-14','K. Crawford','Broken','2017-01-25','L. Muscutt',42,130),('Printer 4',83908,'2017-01-25','','Broken','2017-01-25','L. Muscutt',0,131),('Printer 20',84097,'2017-01-25','S. Zhou','Broken','2017-01-25','L. Muscutt',0,132),('Printer 11',80215,'2017-01-25','L. Muscutt','Broken','2017-01-25','L. Muscutt',0,133),('Printer 17',84071,'2017-01-25','L. Muscutt','Broken','2017-01-25','L. Muscutt',0,134),('Printer 20',84097,'2017-01-25','L. Muscutt','Broken','2017-02-01','L. Muscutt',7,135),('Printer 22',84047,'2017-02-01','L. Muscutt','Broken','2017-02-01','L. Muscutt',0,136),('Printer 22',84047,'2017-02-08','L. Muscutt','Broken','2017-02-22','K. Crawford',14,137),('Printer 3',82953,'2017-02-22','K. Crawford','Broken','2017-02-22','K. Crawford',0,138),('Printer 12',80222,'2017-03-15','A. Grammatikopoulos','Broken','2017-03-15','S. Zhou',0,139),('Printer 8',80211,'2017-03-15','A. Grammatikopoulos','Broken','2017-03-15','S. Zhou',0,140),('Printer 12',80222,'2017-03-22','S. Zhou','Broken','1900-01-00','',10,141);
/*!40000 ALTER TABLE `Fault_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Fault_data_comments`
--

DROP TABLE IF EXISTS `Fault_data_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Fault_data_comments` (
  `Issue` text,
  `Comment` text,
  `Days_out_of_order` int(5) NOT NULL,
  `id` int(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Fault_data_comments_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=142 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Fault_data_comments`
--

LOCK TABLES `Fault_data_comments` WRITE;
/*!40000 ALTER TABLE `Fault_data_comments` DISABLE KEYS */;
INSERT INTO `Fault_data_comments` (`Issue`, `Comment`, `Days_out_of_order`, `id`) VALUES ('','',5,1),('','',7,2),('extruder assembly missing (previous note: Loose platform support on the right guide of the structure for printer 15 \"15/05/2014\")','',392,3),('','',7,4),('','found to be on loan',30,5),('','Was returned to Chris - probably the one previously used for software test in B25',141,6),('with professor?','',775,7),('','found to be on loan',7,8),('Faulty extruder motor','',9,9),('nozzle blocked','',0,10),('nozzle only extruding from maintenance','',0,11),('nozzle blocked- put in filament','',0,12),('User spoke to Shoufeng - apparently working but sparks. Needs proper maintenance','',0,13),('Nozzle blocked','',5,14),('Nozzle blocked (nozzel assembly missing!)','',51,15),('Nozzle broken (nozzle assembly missing!)','',58,16),('','',2,17),('Nozzle Blocked- PLA','clogged nozzle',2,18),('','',2,19),('','',2,20),('','',0,21),('Not extruding properly with ABS (heating issue??)','',0,22),('Not printing correctly with ABS, very loud fan, possible heating element issue','no problem found',7,23),('Printing in very poor quality. ','Nozzle too big, use with lowest z resoltuion',0,24),('Doersn\'t heat up nozzle','',747,25),('Cooper and I  can\'t find it ','Found to be with Maurice Jones',117,26),('Nozzle Blocked','wasn\'t broken',7,27),('platform too hot - platform temperature shows reading of above 300','heating element repaired temporarily',0,28),('Nozzle was missing when we started our shift: not logged by anyone else','',28,29),('Blocked nozzle: have put in acetone','',14,30),('Nozzle blocked','',0,31),('Fan problems','',239,32),(' wire for powering the platform heating element is burned through - temporary fix from before prevented another shortcut but now again the platform isn\'t heating up...','',170,33),('Nozzle blocked','',7,34),('The board doesnt heat up','',14,35),('nozzle broken','',5,36),('Raft is not attaching to perf board correctly. I\'m not sure if it is because the board is not heating properly or because the nozzle is really dirty (on the exterior) which keeps pulling the raft away. ','',9,37),('Motor making a clunking noise and not extruding','',7,38),('Nozzle is overheating','fixed',0,39),('unaware of issue but marked as broken - please check','assumed to be working',100,40),('unaware but marked as broken - please check...','Tested and seemed to be working.',44,41),('Nozzle blocked','',134,42),('printer was not found in ws this afternoon. No Loan form has been completed','given on loan to rocket GDP but no form filled (people fromåÊgroup said they did so)',1,43),('material leaks out of printer','It is working now',64,44),('Printer not found (maybe the one in B25? or on Loan by Mohammed Vaezi?)','was on Loan',112,45),('missing since easter (return from loan by rrnp2g13 to be confirmed) recently spotted in Building 5','',656,46),('PLA Sedimentation in the nozzle ','',112,47),('PLA sedimentation in the nozzle','',112,48),('blocked with PLA','',70,49),('Filament not extruding','',49,50),('Making lots of clicking sounds ','',21,51),('Print failed filament did not lay properly','',147,52),('Blocked nozzle','',8,53),('platform not steady due to movement of platform support rod','',26,54),('not connecting properly to the computer','',7,55),('Blocked nozzle (PLA)','',7,56),('Blocked nozzle (PLA)','',7,57),('Printer withdrawing but not extruding filament. Clicking sound.','',89,58),('Platform not heating properly. Intermittent cable connection issues probably the cause.','Platform now heating',13,59),('Platform not heating','',7,60),('Motor is broken, filament would not withdraw','',91,61),('Nozzle blocked. ABS. Nozzle in acetone.','unblocked nozzle, replaced fan with one from printer 9 which is already broken',5,62),('Nozzle blocked and placed in acetone - no replacement nozzle found.','',68,63),('Platform not heating','',68,64),('filament stops extruding after five layers, repeatedly. Extrudes fine in tests.','',14,65),('Step motor broken','',7,66),('Nozzle not heating properly. ','',0,67),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet. åÊ','',7,68),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','',40,69),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','',40,70),('Blocked Nozzle, now in acetone- Muscutt 09/12/2015','',40,71),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','',40,72),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','',7,73),('Unsure - Was in cupboard marked as broken when arrived for shift but not entered on spreadsheet.  ','',7,74),('Could not find printer in cupboard. In purple folder, theåÊonly \'open\' loan form suggested it was taken in July but had last been updated in October 2015 on the spreadsheet. ','',0,75),('Up Box not in workshop - no loan form completed on or offline (with Shoufeng)','',25,76),('Blocked Nozle','nozzle fixed',15,77),('Found a printer w/ not heating nozzle from previous sessions. StudentsåÊand Tim Wolman have issues printing because the printer is not heating up.','repaired by Chris - calibration sensor is still broken but printer is able to print again',19,78),('Not extruding material','',13,79),('Not recognised by computer','',13,80),('Marked as broken when arrived for shift. ','',7,81),('nozel blocked ','',7,82),('lose y-axis belt','',392,83),('Not extruding','',7,84),('stepper motor does not feed filament ','',21,85),('leveling spring for base is inside x-axis arm ','Spring removed, printer put back together and bed leveled',7,86),('Blocked nozel not extruding','',0,87),('Z axis not alligned','No note on printer and seemed to be working',63,88),('Nozel blocked','Entire new nozzle head assembly installed, old head placed into box of broken bits',7,89),('Blocked nozel','Replaced nozzle, cleaned out stepper motor',7,90),('fan not working ','',0,91),('Printer bed does not heat up','',7,92),('nozel assembly is blocked ','Unblocked Nozzle',14,93),('Heating element wire snapped','Soldered heating element wire',0,94),('fixed but needs new nozzle','soldered loose connection in plate heating element and new nozzle',7,95),('Blocked Noozle','unblocked nozzle and heating block',0,96),('plate not heating','changed platform heating element - took the one from printer 6',0,97),('Platform not heating','Soldered loose connection in plate heating element and new fan',0,98),('filament locked inside the nozzle (NO withdraw and extrude)','',54,99),('Nozzle blocked, no replacement nozzles that can be put on (3 are bent and need to be drilled out by Chris).åÊ Put into cupboard without nozzle head','replaced nozzle',5,100),('Motion program, can not be found. refused to initialise','Oiled z-axis timing belt and linear slide',5,101),('Blocked nozzle, no replacements.åÊ 3 available nozzles need drilling as non round.åÊ Speak to Chris on Monday.','',0,102),('Blocked nozzle.','Replaced nozzle',5,103),('Blocked nozzle','',0,104),('Bed does not rise fully.åÊ Jams half way up','',5,105),('it wouldn\'t download the printing program','tested with small sample and worked',42,106),('it cannot withdraw','blocked motor material was removed',28,107),('Bed skips whilst traversing z axis','opened printer - no obvious obstructing parts. 3D printed guide one the left seems broken but not necessary for print - might cause problem in future. Printer tested and skipping stopped even after reassembly.',42,108),('Possible Sd card error','',202,109),('Gear not turning when extruding','works again',7,110),('printer broke again half way during the test print','Vertical rail clip was broken, it has been replaced and other 3 clips 3d printed.',0,111),('nozzle blocked','Nozzle was blocked. Replaced nozzle and fan support which had melted onto the nozzle.',0,112),('extruderåÊblocked','cleaned the gears',2,113),('platform heating element not working','',287,114),('nozzle too cool/ too hot erroråÊ- nozzle heating element and sensor loose and cable looks very dark (maybe burned)','',229,115),('Nozzle was jamed','',0,116),('not extruding during print','repaired',7,117),('Buttons not working -> boxed up in the workshop','',247,118),('Platform is stuck AND cannot load motion program','',171,119),('nozzel not extruding','',-1,120),('platform not moving properly','Cleaned thermometer and nozzle heating element',84,121),('Gives \"Cannot read printer parameters and \"Motion program not found\" errors','Switched on and off again',84,122),('stepper motor issue','',21,123),('not extruding','',0,124),('nozzle blocked','',77,125),('Y-axis timing belt loose','Replaced y-axis timing belt gear holder with costom made part',84,126),('SD card error & blocked nozzle','',112,127),('Nozzle blocked?','',0,128),('The nozzle was not heated up','',143,129),('plate moving too high during print blocking nozzel','',42,130),('','',0,131),('Nozzle issue','',0,132),('Z axiz loose','',0,133),('replaced z-axis guide','Replaced z-axis guide',0,134),('no nozzle','',7,135),('nozzle too hot','Replaced nozzle heating element',0,136),('printer not withdrawing','',14,137),('stepper motor blocked','',0,138),('Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','',0,139),('Print head misaligned/miscalibrated. \"Centre\" of platform not really centre. Printer tries to reach locations outside its maximum volume.','',0,140),('Frames vibrate a lot','',10,141);
/*!40000 ALTER TABLE `Fault_data_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Printer_status`
--

DROP TABLE IF EXISTS `Printer_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Printer_status` (
  `Printer_ID` varchar(11) NOT NULL,
  `Serial_Number` int(11) NOT NULL,
  `Printer_Type` text,
  `Printer_Status` text NOT NULL,
  `Updated_by` varchar(20) NOT NULL,
  `Update_date` date NOT NULL,
  `Last_Use` date DEFAULT NULL,
  `First_Use` date NOT NULL,
  `Last_Used_by` varchar(20) DEFAULT NULL,
  `Hours_Used` int(11) NOT NULL,
  `ABS_Used` text,
  `Availability` text,
  `Reliability` text,
  `id` int(9) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Printer_status_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Printer_status`
--

LOCK TABLES `Printer_status` WRITE;
/*!40000 ALTER TABLE `Printer_status` DISABLE KEYS */;
INSERT INTO `Printer_status` (`Printer_ID`, `Serial_Number`, `Printer_Type`, `Printer_Status`, `Updated_by`, `Update_date`, `Last_Use`, `First_Use`, `Last_Used_by`, `Hours_Used`, `ABS_Used`, `Availability`, `Reliability`, `id`) VALUES ('Printer 2',63116,'UP!','Available','P. Fenou Kengne','2016-07-11','2017-03-29','2014-02-04','alk1g15',1715,'3,803.7g','91%','96%',1),('Printer 21',63120,'UP!','Available','L. Muscutt','2017-01-25','2017-03-17','2015-02-27','jn5g13',2515,'1,681.3g','78%','95%',2),('Printer 1',63514,'UP!','Available','L. Muscutt','2017-01-25','2017-03-31','2014-02-04','cpps1g15',1908,'1,225.9','74%','94%',3),('Printer 6',80151,'UP Plus 2','Broken','J. Van der Kindere','2015-03-16','2015-03-25','2014-01-05','md9g13',1000,'1,358.1g','35%','93%',4),('Printer 7',80210,'UP Plus 2','On Loan','S. Yang','2015-07-13','2015-07-13','2014-03-04','Alexios Charalambous',4,'62.9g','87%','100%',5),('Printer 8',80211,'UP Plus 2','Available','S. Zhou','2017-03-15','2017-03-29','2014-01-05','jjp2g15',1969,'3,066.0g','59%','92%',6),('Printer 9',80213,'UP Plus 2','Available','W. Keum','2016-01-27','2017-03-29','2014-11-19','aoa1g15',2079,'5,286.5g','77%','95%',7),('Printer 15',80214,'UP Plus 2','Broken','F. Xie','2016-10-12','2016-10-12','2014-03-04','lw6g10',1589,'433.5g','46%','67%',8),('Printer 11',80215,'UP Plus 2','Available','L. Muscutt','2017-01-25','2017-03-22','2014-01-02','an1g15',1131,'3,730.7g','77%','94%',9),('Printer 12',80222,'UP Plus 2','Broken','S. Zhou','2017-03-22','2017-03-22','2014-03-04','jd13g13',5383,'4,525.9g','71%','95%',10),('Printer 13',80233,'UP Plus 2','Available','S. Zhou','2017-03-22','2017-03-31','2014-03-13','cl14g15',1467,'4,022.9g','44%','87%',11),('Printer 14',80261,'UP Plus 2','Missing','J. Van der Kindere','2015-02-16',NULL,'2015-02-16',NULL,0,'0.0g','0%',NULL,12),('Printer 10',80265,'UP Plus 2','Available','P. Fenou Kengne','2016-10-16','2016-10-20','2014-03-04','a.wong',652,'2,139.6','81%','89%',13),('Printer 16',82908,'UP Plus 2','Available','K. Crawford','2017-02-22','2017-02-22','2014-02-04','tn1g13',3513,'2,755.8g','65%','98%',14),('Printer 23',82945,'UP Plus 2','Available','P. Fenou Kengne','2017-03-10','2017-03-29','2015-05-13','dfb1g14',6934,'1,568.2g','84%','94%',15),('Printer 3',82953,'UP Plus 2','Available','K. Crawford','2017-02-22','2017-03-29','2014-02-04','dfb1g14',1890,'8,339.0g','88%','96%',16),('Printer 5',83906,'UP Plus 2','Missing','S. Yang','2015-06-15','2015-06-15','2014-01-05','rrpn2g13',2401,'1,382.3g','34%','100%',17),('Printer 4',83908,'UP Plus 2','Available','L. Muscutt','2017-01-25','2017-03-29','2014-02-04','cl14g15',2265,'3,735.8g','86%','93%',18),('Printer 19',83971,'UP Plus 2','Available','S. Zhou','2016-11-02','2017-03-22','2014-03-04','bas1g14',1466,'5,268.5g','66%','86%',19),('Printer 22',84047,'UP Plus 2','Available','K. Crawford','2017-02-22','2017-03-29','2015-02-18','am13g14',1802,'5,230.3g','78%','94%',20),('Printer 17',84071,'UP Plus 2','Available','L. Muscutt','2017-01-25','2017-03-22','2015-02-11','jp13g14',2155,'5,108.4g','80%','92%',21),('Printer 20',84097,'UP Plus 2','Available','L. Muscutt','2017-02-01','2017-03-22','2015-02-17','jle1g14',2021,'5,729.5g','81%','96%',22),('Printer 18',84788,'UP Plus 2','Available','L. Muscutt','2017-01-23','2017-03-22','2015-02-11','dh6g14',1653,'3,784.0g','49%','93%',23),('Printer 24',503039,'UP BOX','Available','P. Fenou Kengne','2016-06-08','2016-12-07','2015-06-17','pt4g14',592,'8,101.4g','96%','98%',24),('Printer 25',503041,'UP BOX','Signed out','L. Wollatz','2015-05-27','2015-08-19','2015-07-01','ry1e14',38,'363.3g','100%','100%',25),('Printer 26',503063,'UP BOX','Available','S. Zhou','2016-11-09','2017-01-23','2015-08-12','lem1g12',377,'5,675.8g','85%','91%',26),('Printer 27',503086,'UP BOX','Signed out','L. Wollatz','2015-05-27','2015-08-19','2015-07-01','ky1g14',43,'330.3g','100%','100%',27),('Printer 28',503090,'UP BOX','Broken','S. Zhou','2016-11-09','2016-11-09','2015-06-09','ag3e15',20,'8,162.9g','69%','97%',28),('Printer 30',508579,'UP BOX','Broken','L. Wollatz','2016-07-28','2016-07-28','2016-02-24','pmb1g13',140,'1,581.4g','39%','94%',29),('Printer 31',508611,'UP BOX','Available','K. Crawford','2016-11-01','2017-03-29','2016-02-24','tyh1g13',141,'1,730.5g','50%','94%',30),('Printer 29',508733,'UP BOX','Available','P. Fenou Kengne','2016-06-22','2017-02-22','2016-02-24','Michael Reeson',219,'2,669.6g','98%','92%',31);
/*!40000 ALTER TABLE `Printer_status` ENABLE KEYS */;
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
  `message` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
INSERT INTO `announcements` (`id`, `user_id`, `message`, `created_at`, `updated_at`) VALUES (4,5,'Testing announcements 2','2017-07-30 15:06:59','2017-07-30 15:06:59');
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
  `posts_id` int(11) NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` (`id`, `posts_id`, `body`, `created_at`, `updated_at`, `user_id`) VALUES (12,10,'Testing comments','2017-07-30 15:05:52','2017-07-30 15:05:52',5),(13,11,'Testing comments 2','2017-07-30 15:06:37','2017-07-30 15:06:37',5);
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
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_codes`
--

LOCK TABLES `cost_codes` WRITE;
/*!40000 ALTER TABLE `cost_codes` DISABLE KEYS */;
INSERT INTO `cost_codes` (`id`, `shortage`, `cost_code`, `aproving_member_of_staff`, `expires`, `holder`, `description`, `created_at`, `updated_at`) VALUES (1,'FEEG1001-AERO',510671104,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(2,'FEEG1001-MECH',510671108,'Shoufeng Yang','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 12:10:49',NULL),(3,'FEEG2001-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(4,'FEEG2001-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(5,'FEEG2001-MECH',510312110,'Tim Woolman','2017-09-27','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL),(6,'FEEG6013-ACOU',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(7,'FEEG6013-AMAT',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(8,'FEEG6013-AERO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(9,'FEEG6013-AUTO',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(10,'FEEG6013-BIOM',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(11,'FEEG6013-CIVI',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(12,'FEEG6013-INTE',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(13,'FEEG6013-MANA',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(14,'FEEG6013-MECH',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(15,'FEEG6013-SPAC',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(16,'FEEG6013-ENRG',510667101,'Tim Woolman','2017-09-27','Anna Barney','FEE Group Design Projects','2017-05-07 12:10:49',NULL),(17,'FEEG6013-MARI',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(18,'FEEG6013-SHIP',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(19,'FEEG6013-YACH',510667103,'Tim Woolman','2017-09-27','Ming-Yi Tan','FEE Group Design Projects Ship Science','2017-05-07 12:10:49',NULL),(20,'FEEG6013-KEAN',510667102,'Tim Woolman','2017-09-27','Andrew Keane','FEE Group Design Projects Andrew Keane','2017-05-07 12:10:49',NULL),(21,'FEEG3003-ACOU',510671102,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(22,'FEEG3003-AUDI',510671103,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Audiology','2017-05-07 12:10:49',NULL),(23,'FEEG3003-AERO',510671104,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(24,'FEEG3003-CIVI',510671105,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Civil and Environmental','2017-05-07 12:10:49',NULL),(25,'FEEG3003-ENER',510671106,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Energy','2017-05-07 12:10:49',NULL),(26,'FEEG3003-ENVI',510671107,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Environmental Science','2017-05-07 12:10:49',NULL),(27,'FEEG3003-MECH',510671108,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Mechanical Engineering','2017-05-07 12:10:49',NULL),(28,'FEEG3003-MARI',510671109,'Tim Woolman','2017-09-27','Anna Barney','FEE UG Projects - Maritime Engineering','2017-05-07 12:10:49',NULL),(29,'SPEAKER',510671102,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Acoustical Engineering','2017-05-07 12:10:49',NULL),(30,'UAV',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(31,'QUADCOPTER',510671104,'Mohamed Torbati','2017-06-01','Anna Barney','FEE UG Projects - Aerospace Engineering','2017-05-07 12:10:49',NULL),(32,'EUROBOT',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL),(33,'RESPSYS',510312110,'Mohamed Torbati','2017-06-01','Anna Barney','FEE Education - Mechanical Engineering','2017-05-07 12:10:49',NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fault_updates`
--

LOCK TABLES `fault_updates` WRITE;
/*!40000 ALTER TABLE `fault_updates` DISABLE KEYS */;
/*!40000 ALTER TABLE `fault_updates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `loan_printers`
--

DROP TABLE IF EXISTS `loan_printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `loan_printers` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `Printer_ID` varchar(15) NOT NULL,
  `Serial_number` int(15) NOT NULL,
  `Loan_Start` date NOT NULL,
  `Loan_End` date NOT NULL,
  `Request_id` varchar(20) NOT NULL,
  `Approved_id` varchar(20) NOT NULL,
  `Comments` text,
  `Actual_return` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `loan_printers_id_uindex` (`id`),
  UNIQUE KEY `loan_printers_Printer_ID_uindex` (`Printer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `loan_printers`
--

LOCK TABLES `loan_printers` WRITE;
/*!40000 ALTER TABLE `loan_printers` DISABLE KEYS */;
/*!40000 ALTER TABLE `loan_printers` ENABLE KEYS */;
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
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'2017_04_25_194247_create_posts_table',1),(10,'2017_04_25_194247_create_posts_table',1),(16,'2014_10_12_000000_create_users_table',2),(17,'2014_10_12_100000_create_password_resets_table',2),(18,'2017_07_01_113150_create_announcements_table',2),(19,'2017_07_12_145959_create_permission_tables',2),(20,'2017_07_29_190414_create_public_announcements_table',2);
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
INSERT INTO `model_has_roles` (`role_id`, `model_id`, `model_type`) VALUES (2,5,'App\\User'),(3,6,'App\\User'),(4,7,'App\\User'),(5,8,'App\\User'),(6,9,'App\\User');
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (3,'users_manage','web','2017-07-30 13:31:44','2017-07-30 13:31:44'),(4,'staff_manage','web','2017-07-30 13:34:22','2017-07-30 13:34:22'),(5,'issues_manage','web','2017-07-30 13:34:53','2017-07-30 13:34:53'),(6,'jobs_manage','web','2017-07-30 13:35:28','2017-07-30 13:35:28'),(7,'printers_manage','web','2017-07-30 13:35:38','2017-07-30 13:35:38'),(8,'PublicPostsAndAnnouncements','web','2017-07-30 13:36:14','2017-07-30 13:38:31'),(9,'jobs_request','web','2017-07-30 13:36:44','2017-07-30 13:36:44'),(10,'PrivatePostsAndAnnouncements','web','2017-07-30 13:38:49','2017-07-30 13:38:49');
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
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `body`, `created_at`, `updated_at`, `user_id`) VALUES (10,'Testing issues1','Testing issues','2017-07-30 15:05:43','2017-07-30 15:05:43',5),(11,'Testing issues 2','Testing issues','2017-07-30 15:06:08','2017-07-30 15:06:08',5);
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
  `in_use` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printers`
--

LOCK TABLES `printers` WRITE;
/*!40000 ALTER TABLE `printers` DISABLE KEYS */;
INSERT INTO `printers` (`id`, `serial_no`, `printer_type`, `printer_status`, `created_at`, `updated_at`, `in_use`) VALUES (1,63514,'UP!','Broken',NULL,'2017-07-21 15:44:07',0),(2,63116,'UP!','Available',NULL,'2017-07-19 08:30:41',0),(3,82953,'UP Plus 2','Broken',NULL,'2017-07-30 11:22:20',0),(4,83908,'UP Plus 2','Available',NULL,NULL,0),(5,83906,'UP Plus 2','Missing',NULL,NULL,0),(6,80151,'UP Plus 2','Available',NULL,'2017-07-19 10:26:23',0),(7,80210,'UP Plus 2','On Loan',NULL,NULL,0),(8,80211,'UP Plus 2','Available',NULL,NULL,0),(9,80213,'UP Plus 2','Available',NULL,NULL,0),(10,80265,'UP Plus 2','Available',NULL,NULL,0),(11,80215,'UP Plus 2','Available',NULL,NULL,0),(12,80222,'UP Plus 2','Broken',NULL,NULL,0),(13,80233,'UP Plus 2','Available',NULL,NULL,0),(14,80261,'UP Plus 2','Available',NULL,NULL,0),(15,80214,'UP Plus 2','Available',NULL,NULL,0),(16,82908,'UP Plus 2','Available',NULL,NULL,0),(17,84071,'UP Plus 2','Available',NULL,NULL,0),(18,84788,'UP Plus 2','Available',NULL,NULL,0),(19,83971,'UP Plus 2','Available',NULL,NULL,0),(20,84097,'UP Plus 2','Available',NULL,NULL,0),(21,63120,'UP!','Available',NULL,NULL,0),(22,84047,'UP Plus 2','Available',NULL,NULL,0),(23,82945,'UP Plus 2','Available',NULL,NULL,0),(24,503039,'UP BOX','Available',NULL,NULL,0),(25,503041,'UP BOX','Signed out',NULL,NULL,0),(26,503063,'UP BOX','Available',NULL,NULL,0),(27,503086,'UP BOX','Signed out',NULL,NULL,0),(28,503090,'UP BOX','Broken',NULL,NULL,0),(29,508733,'UP BOX','Available',NULL,NULL,0),(30,508579,'UP BOX','Broken',NULL,NULL,0),(31,508611,'UP BOX','Available',NULL,NULL,0);
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
  `succsessfull` enum('Yes','No') NOT NULL,
  `purpose` enum('Use','Loan') NOT NULL,
  `student_name` varchar(30) DEFAULT NULL,
  `approved` enum('Yes','No','Waiting','Success') DEFAULT 'Waiting',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `email` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `public_announcements`
--

LOCK TABLES `public_announcements` WRITE;
/*!40000 ALTER TABLE `public_announcements` DISABLE KEYS */;
/*!40000 ALTER TABLE `public_announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `repair_printers`
--

DROP TABLE IF EXISTS `repair_printers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `repair_printers` (
  `id` int(9) NOT NULL AUTO_INCREMENT,
  `Printer_id` varchar(11) NOT NULL,
  `Serial_number` int(15) NOT NULL,
  `Date_broken` datetime NOT NULL,
  `Date_repared` datetime NOT NULL,
  `Failure_reported_id` varchar(20) NOT NULL,
  `Reparing_id` varchar(20) DEFAULT NULL,
  `Comments` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `repair_printers_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `repair_printers`
--

LOCK TABLES `repair_printers` WRITE;
/*!40000 ALTER TABLE `repair_printers` DISABLE KEYS */;
/*!40000 ALTER TABLE `repair_printers` ENABLE KEYS */;
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
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES (3,2),(4,3),(5,3),(6,3),(7,3),(8,3),(10,3),(5,4),(6,4),(9,4),(10,4),(9,5),(10,5),(9,6),(10,6);
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
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES (2,'administrator','web','2017-07-30 13:31:44','2017-07-30 13:31:44'),(3,'LeadDemonstrator','web','2017-07-30 13:37:48','2017-07-30 14:50:04'),(4,'Demonstrator','web','2017-07-30 13:40:40','2017-07-30 13:40:40'),(5,'NewDemonstrator','web','2017-07-30 13:41:18','2017-07-30 13:41:18'),(6,'OldDemonstrator','web','2017-07-30 13:41:50','2017-07-30 13:41:50');
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
  `title` varchar(10) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `id_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` (`id`, `title`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `role`, `updated_at`, `user_id`, `id_number`) VALUES (1,NULL,'Apostolos','Grammatikopoulos','ag3e15@soton.ac.uk','075819298485','2017-03-31 19:30:20','Demonstrator',NULL,NULL,NULL),(2,NULL,'Chee','Hong Goh','chg1g13@soton.ac.uk','07851925072','2017-03-31 19:30:20','Demonstrator',NULL,NULL,NULL),(3,'Dr','Shoufeng ','Yang','s.yang@soton.ac.uk',NULL,'2017-03-31 19:30:20','Co-Coordinator',NULL,NULL,NULL),(4,NULL,'Erato','Kartaki','ek2e14@soton.ac.uk','07518990594','2017-03-31 19:30:20','Demonstrator',NULL,NULL,NULL),(5,NULL,'Fulin ','Xie','fx1g12@soton.ac.uk',NULL,'2017-03-31 19:30:20',NULL,NULL,NULL,NULL),(6,NULL,'Gianluca ','Cidonio','gc3e15@soton.ac.uk',NULL,'2017-03-31 19:30:20',NULL,NULL,6,NULL),(7,NULL,'Jing  ','Tang','jt7g13@soton.ac.uk','07403797321','2017-03-31 19:30:20','Technical Manager',NULL,7,NULL),(8,NULL,'Katherine','Crawford','K.A.Crawford@soton.ac.uk','07510838851','2017-03-31 19:30:20','Demonstrator',NULL,8,NULL),(9,NULL,'Lasse','Wollatz','L.Wollatz@soton.ac.uk','07418432954','2017-03-31 19:30:20','IT Manager','2017-07-19 10:48:35',4,NULL),(10,NULL,'Luke','Muscutt','L.Muscutt@soton.ac.uk','07723325834','2017-03-31 19:30:20','PR Manager',NULL,NULL,NULL),(11,NULL,'Manuel','Ferreira','maf1v15@soton.ac.uk',NULL,'2017-03-31 19:30:20',NULL,NULL,NULL,NULL),(12,NULL,'Matt','Potticary','m.potticary@soton.ac.uk','07972298383','2017-03-31 19:30:20','Demonstrator',NULL,NULL,NULL),(13,NULL,'Patrick','Fenou Kengne','plfk1g13@soton.ac.uk','07729280929','2017-03-31 19:30:20','3D Hub Manager',NULL,NULL,NULL),(14,NULL,'Shenglong','Zhou','sz3g14@soton.ac.uk','07519533874','2017-03-31 19:30:20','Demonstrator',NULL,NULL,NULL),(15,NULL,'Yu','Pui-Hei','mcmicha320@gmail.com',NULL,'2017-03-31 19:30:20',NULL,NULL,NULL,NULL),(17,NULL,'Admin','Admin','ai1v14@soton.ac.uk','07479045846','2017-07-30 15:13:39','administrator',NULL,5,27459898),(18,NULL,'LeadDemonstrator','Lead','LD@soton.ac.uk',NULL,'2017-07-30 15:17:05',NULL,NULL,NULL,NULL),(19,NULL,'Demonstrator1','Dem','D1@soton.ac.uk',NULL,'2017-07-30 15:17:05',NULL,NULL,NULL,NULL),(20,NULL,'NewDemonstrator1','New','ND1@soton.ac.uk',NULL,'2017-07-30 15:17:05',NULL,NULL,NULL,NULL),(21,NULL,'OldDemonstrator1','Old','ND1@soton.ac.uk',NULL,'2017-07-30 15:17:05',NULL,NULL,NULL,NULL);
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
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5,'Admin','ai1v14@soton.ac.uk','$2y$10$P9uYX7nEXADt1tO8Tt2GdueVnuoxd2BPfX4gbueGyIjlZJiEqS2fC','f6INies8duXBphVqRgOeiUEtzRdSgfN0dicKo8njALqIZbYQ226gYKosf9KX','2017-07-30 13:31:44','2017-07-30 13:31:44'),(6,'LeadDemonstrator','LD@soton.ac.uk','$2y$10$JERDrcffJObag0cs4bEkpee.xiwBD.PoMcfnoSxFIFCAKn25rzxu2','07bcVw2ecUyEYYLP0UOmhRJwmJiIM1Eelt9HaD60akbEQ1DmPsIqJvNckuIA','2017-07-30 13:43:54','2017-07-30 13:43:54'),(7,'Demonstrator1','D1@soton.ac.uk','$2y$10$4DRAsquExQr1f9OWRFr4ROP./h95MGvarPkd4zeVrS9Zg6kinp1ty','lmQJCrYsjcdhiHOpwc7Q7NcF9Zw3ESdEOtTYqc40ZzL8bEoZVEYFOJl5wtO6','2017-07-30 13:44:23','2017-07-30 13:44:23'),(8,'NewDemonstrator1','ND1@soton.ac.uk','$2y$10$aSirAeTSUXXqn.aVstCNt.ahNYZI5eZFZwFyin9atEe9Uv8wrSmWS','KEBqvkIsjuesJ8vkD4iKd7rNTRMQ5b50yaXt3zFRGA8d7EdIuEppDCyX7PX2','2017-07-30 13:44:57','2017-07-30 13:44:57'),(9,'OldDemonstrator1','OD1@soton.ac.uk','$2y$10$C8b6NszOZ9WF9m0N10ELYuki0vUzoMcDjD47VR13JyX3FS.yNzLpi',NULL,'2017-07-30 13:45:30','2017-07-30 13:45:30');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `welcome`
--

DROP TABLE IF EXISTS `welcome`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `welcome` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `welcome`
--

LOCK TABLES `welcome` WRITE;
/*!40000 ALTER TABLE `welcome` DISABLE KEYS */;
/*!40000 ALTER TABLE `welcome` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-30 17:11:17
