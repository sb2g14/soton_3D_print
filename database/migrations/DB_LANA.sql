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
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `hashed_password` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `fault_datas` (`id`, `printers_id`, `serial_number`, `users_id_created_issue`, `printer_status`, `users_id_resolved_issue`, `body`, `updated_at`, `created_at`, `title`, `users_name_created_issue`, `users_name_resolved_issue`, `resolved`, `days_out_of_order`, `message_resolved`) VALUES (20,2,63116,3,'Available',3,'Something happened with the printer','2017-07-29 16:45:24','2017-07-29 16:38:36','Something happened','Svitlana Braichenko','Svitlana Braichenko',1,0,'Printer found'),(21,1,63514,3,'Available',3,'Something happened with the printer','2017-07-29 17:43:10','2017-07-29 17:25:12','Printer broken','Svitlana Braichenko','Svitlana Braichenko',1,0,'Resolved issue'),(22,1,63514,3,'Available',3,'klfdzjzjbpsji','2017-07-29 17:45:00','2017-07-29 17:44:26','jsrhuhsfjil','Svitlana Braichenko','Svitlana Braichenko',1,0,'Resolved!'),(23,1,63514,3,'Broken',NULL,'New test issue','2017-07-29 17:48:52','2017-07-29 17:48:52','New test issue','Svitlana Braichenko',NULL,0,0,NULL);
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
INSERT INTO `fault_updates` (`id`, `users_id`, `users_name`, `fault_data_id`, `body`, `printer_status`, `created_at`, `updated_at`, `days_out_of_order`) VALUES (7,3,'Svitlana Braichenko',20,'Printer is stolen','Missing','2017-07-29 16:42:57','2017-07-29 16:42:57',0),(8,3,'Svitlana Braichenko',20,'Printer is stolen','Missing','2017-07-29 16:43:43','2017-07-29 16:43:43',0),(9,3,'Svitlana Braichenko',21,'Updatekjgld','Broken','2017-07-29 17:42:53','2017-07-29 17:42:53',0),(10,3,'Svitlana Braichenko',22,'lglhon kf','Signed out','2017-07-29 17:44:45','2017-07-29 17:44:45',0);
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
INSERT INTO `posts` (`id`, `user_id`, `title`, `body`, `created_at`, `updated_at`) VALUES (20,1,'Testing','test 1 for message','2017-07-29 19:01:11','2017-07-29 19:01:11'),(21,1,'Tstingissues','test 2 of messages','2017-07-29 19:01:43','2017-07-29 19:01:43');
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
INSERT INTO `printers` (`id`, `serial_no`, `printer_type`, `printer_status`, `created_at`, `updated_at`, `in_use`) VALUES (1,63514,'UP!','Broken',NULL,'2017-07-29 17:48:52',0),(2,63116,'UP!','Available',NULL,'2017-07-29 16:45:24',0),(3,82953,'UP Plus 2','Broken',NULL,'2017-07-29 17:43:18',0),(4,83908,'UP Plus 2','Available',NULL,'2017-07-29 14:06:47',0),(5,83906,'UP Plus 2','Broken',NULL,'2017-07-29 16:06:05',0),(6,80151,'UP Plus 2','Broken',NULL,'2017-07-29 14:07:27',0),(7,80210,'UP Plus 2','On Loan',NULL,NULL,0),(8,80211,'UP Plus 2','Available',NULL,'2017-07-29 13:46:45',0),(9,80213,'UP Plus 2','Broken',NULL,'2017-07-29 16:07:52',0),(10,80265,'UP Plus 2','Available',NULL,'2017-07-29 16:23:58',0),(11,80215,'UP Plus 2','Broken',NULL,'2017-07-29 16:08:53',0),(12,80222,'UP Plus 2','Broken',NULL,NULL,0),(13,80233,'UP Plus 2','Available',NULL,NULL,0),(14,80261,'UP Plus 2','Available',NULL,'2017-06-23 15:59:50',0),(15,80214,'UP Plus 2','Available',NULL,NULL,0),(16,82908,'UP Plus 2','Available',NULL,NULL,0),(17,84071,'UP Plus 2','Available',NULL,NULL,0),(18,84788,'UP Plus 2','Available',NULL,NULL,0),(19,83971,'UP Plus 2','Available',NULL,NULL,0),(20,84097,'UP Plus 2','Available',NULL,NULL,0),(21,63120,'UP!','Available',NULL,NULL,0),(22,84047,'UP Plus 2','Available',NULL,NULL,0),(23,82945,'UP Plus 2','Available',NULL,NULL,0),(24,503039,'UP BOX','Available',NULL,NULL,0),(25,503041,'UP BOX','Signed out',NULL,NULL,0),(26,503063,'UP BOX','Available',NULL,NULL,0),(27,503086,'UP BOX','Signed out',NULL,NULL,0),(28,503090,'UP BOX','Broken',NULL,NULL,0),(29,508733,'UP BOX','Available',NULL,NULL,0),(30,508579,'UP BOX','Broken',NULL,NULL,0),(31,508611,'UP BOX','Available',NULL,NULL,0),(32,464646446,'UP!','Available','2017-06-16 16:17:32','2017-06-25 10:59:52',0);
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
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `printing_datas`
--

LOCK TABLES `printing_datas` WRITE;
/*!40000 ALTER TABLE `printing_datas` DISABLE KEYS */;
INSERT INTO `printing_datas` (`id`, `printers_id`, `student_id`, `time`, `material_amount`, `price`, `paid`, `user_id`, `payment_category`, `use_case`, `cost_code`, `add_comment`, `successful`, `purpose`, `student_name`, `approved`, `created_at`, `updated_at`, `email`, `serial_no`, `month`, `approved_name`) VALUES (20,'2',123456789,'00:30:00',13.5,2.175,'No',9,NULL,'Demonstartor',NULL,NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-06-24 19:30:18','2017-06-24 19:39:39',NULL,NULL,NULL,NULL),(21,'8',123456789,'01:02:00',50,5.6,'No',9,NULL,'Test',NULL,NULL,'Yes','Use','Svitlana Braichenko','Success','2017-06-24 19:34:16','2017-07-02 10:45:13',NULL,NULL,NULL,NULL),(24,'3',123456789,'12:00:00',123,42.15,'No',9,NULL,'123456789',NULL,NULL,'No','Use','Svitlana','No','2017-07-01 12:34:23','2017-07-01 12:34:55',NULL,NULL,NULL,NULL),(25,'2',123456789,'00:01:00',39.1,2.01,'No',9,NULL,'123456789',NULL,NULL,'No','Use','Svitlana','No','2017-07-02 10:33:54','2017-07-02 10:35:15',NULL,NULL,NULL,NULL),(26,'2',123456789,'00:09:00',12.1,1.06,'No',9,NULL,'123456789',NULL,NULL,'No','Use','Svitlana','No','2017-07-02 12:19:35','2017-07-02 12:29:31',NULL,NULL,NULL,NULL),(27,'2',213456789,'01:02:00',100,8.1,'No',9,NULL,'123456789',NULL,NULL,'Yes','Use','Svitlana Braichenko','Success','2017-07-04 15:12:53','2017-07-06 18:02:49',NULL,NULL,NULL,NULL),(28,'2',213456789,'02:38:00',120,13.9,'No',9,NULL,'123456789',NULL,NULL,'No','Use','Svitlana Braichenko','No','2017-07-04 15:23:59','2017-07-06 18:02:46',NULL,NULL,NULL,NULL),(29,'3',123456789,'01:02:00',123,9.25,'No',9,NULL,'123456789',NULL,NULL,'Yes','Use','fdfdfd','Yes','2017-07-04 15:32:16','2017-07-07 16:39:21','sb2g14@soton.ac.uk',NULL,NULL,NULL),(30,'10',123,'01:01:00',123,9.2,'No',9,NULL,'Svitlana Braichenko',NULL,NULL,'Yes','Use','Svi 5','Yes','2017-07-04 15:33:46','2017-07-07 16:39:30','sb2g14@soton.ac.uk',NULL,NULL,NULL),(31,'2',12345678,'00:02:00',123,6.25,'No',9,NULL,'UAV','[510671104]',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-04 17:21:47','2017-07-17 13:06:42','sb2g14@soton.ac.uk',NULL,NULL,NULL),(32,'2',12345678,'00:01:00',12,0.65,'No',3,NULL,'123','',NULL,'Yes','Use','Svitlana Braichenko','Success','2017-07-04 17:22:35','2017-07-23 16:01:10','sb2g14@soton.ac.uk',NULL,NULL,NULL),(33,'2',12345678,'01:02:00',12,3.7,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-04 17:27:41','2017-07-17 12:58:56','sb2g14@soton.ac.uk',NULL,NULL,NULL),(38,'8',123456789,'01:02:00',12,3.7,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Success','2017-07-06 19:26:30','2017-07-07 16:37:00','sb2g14@soton.ac.uk',NULL,NULL,NULL),(39,'3',12345678,'02:01:00',12,6.65,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-07 13:12:18','2017-07-07 16:40:25','sb2g14@soton.ac.uk',NULL,NULL,NULL),(40,'4',12345678,'00:01:00',13,0.7,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-07 16:40:57','2017-07-07 16:41:04','sb2g14@soton.ac.uk',NULL,NULL,NULL),(41,'9',12345678,'04:02:00',14,12.8,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-07 16:42:27','2017-07-07 16:42:35','sb2g14@soton.ac.uk',NULL,NULL,NULL),(42,'11',12345678,'02:04:00',13,6.85,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-09 13:24:07','2017-07-09 13:24:15','sb2g14@soton.ac.uk',NULL,NULL,NULL),(44,'3',12345678,'00:01:00',12.1,0.66,'No',9,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-18 21:14:25','2017-07-18 21:15:28','sb2g14@soton.ac.uk',NULL,NULL,NULL),(46,'2',226545357,'01:02:00',12.1,3.71,'No',3,NULL,'UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-23 16:58:30','2017-07-23 16:58:45','sb2g14@soton.ac.uk',NULL,NULL,NULL),(48,'2',12345678,'00:05:00',12.1,0.86,'No',3,NULL,'Demonstrator','515665101',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 12:49:50','2017-07-29 12:50:20','sb2g14@soton.ac.uk',NULL,NULL,NULL),(49,'2',226545357,'02:03:00',13.1,6.81,'No',3,'postgraduate','UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 13:31:23','2017-07-29 13:52:55','sb2g14@soton.ac.uk',NULL,NULL,NULL),(50,'8',226545357,'00:05:00',13.1,0.91,'No',3,'postgraduate','Demonstrator','515665101',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 13:34:40','2017-07-29 13:52:59','sb2g14@soton.ac.uk',NULL,'7',NULL),(51,'4',226545357,'00:03:00',12.1,0.76,'No',3,'postgraduate','UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 13:51:56','2017-07-29 13:53:02','sb2g14@soton.ac.uk',83908,'2017/7',NULL),(52,'3',226545357,'00:10:00',12.1,1.11,'No',3,'postgraduate','UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 14:07:27','2017-07-29 15:52:50','sb2g14@soton.ac.uk',80151,'2017/7','Svitlana Braichenko'),(53,'3',226545357,'01:01:00',100,8.05,'No',3,'postgraduate','UAV','510671104',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 16:28:50','2017-07-29 16:30:03','sb2g14@soton.ac.uk',63116,'2017/7','Svitlana Braichenko'),(54,'2',226545357,'00:07:00',1.1,0.41,'No',3,'postgraduate','Demonstrator','515665101',NULL,'Yes','Use','Svitlana Braichenko','Yes','2017-07-29 17:07:10','2017-07-29 17:07:24','sb2g14@soton.ac.uk',82953,'2017/7','Svitlana Braichenko');
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
INSERT INTO `public_announcements` (`id`, `message`, `user_id`, `created_at`, `updated_at`) VALUES (1,'Message',0,'2017-07-29 19:19:02','2017-07-29 19:19:05'),(2,'Second message',0,'2017-07-29 19:20:21','2017-07-29 19:20:24');
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
INSERT INTO `staff` (`id`, `first_name`, `last_name`, `email`, `phone`, `created_at`, `role`, `updated_at`, `user_id`, `id_number`) VALUES (1,'Apostolos','Grammatikopoulos','ag3e15@soton.ac.uk','075819298485','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(2,'Chee','Hong Goh','chg1g13@soton.ac.uk','07851925072','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(4,'Erato','Kartaki','ek2e14@soton.ac.uk','07518990594','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(5,'Fulin ','Xie','fx1g12@soton.ac.uk','unknown','2017-03-26 18:26:11','unknown',NULL,NULL,NULL),(6,'Gianluca ','Cidonio','gc3e15@soton.ac.uk','unknown','2017-03-26 18:26:11','Lead Demonstrator',NULL,NULL,NULL),(7,'Jing  ','Tang','jt7g13@soton.ac.uk','07403797321','2017-03-26 18:26:11','Technical Manager',NULL,NULL,NULL),(8,'Katherine','Crawford','K.A.Crawford@soton.ac.uk','07510838851','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(9,'Lasse','Wollatz','L.Wollatz@soton.ac.uk','07418432954','2017-03-26 18:26:11','IT Manager',NULL,NULL,NULL),(10,'Luke','Muscutt','L.Muscutt@soton.ac.uk','07723325834','2017-03-26 18:26:11','PR Manager',NULL,NULL,NULL),(11,'Manuel','Ferreira','maf1v15@soton.ac.uk','unknown','2017-03-26 18:26:11','unknown',NULL,NULL,NULL),(12,'Matt','Potticary','m.potticary@soton.ac.uk','07972298383','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(13,'Patrick','Fenou Kengne','plfk1g13@soton.ac.uk','07729280929','2017-03-26 18:26:11','3D Hub Manager',NULL,NULL,NULL),(14,'Shenglong','Zhou','sz3g14@soton.ac.uk','07519533874','2017-03-26 18:26:11','Demonstrator',NULL,NULL,NULL),(15,'Yu','Pui-Hei','mcmicha320@gmail.com','unknown','2017-03-26 18:26:11','unknown',NULL,NULL,NULL),(16,'Svitlana','Braichenko','sb2g14@soton.ac.uk','07479052411','2017-07-29 19:41:02','IT','2017-07-29 18:41:02',1,NULL),(17,'Andrii','Iakovliev','ai1v14@soton.ac.uk','07479045846','2017-07-23 14:06:48','IT','2017-07-15 13:36:45',2,NULL),(18,'Hayk','Vasilyan','h.vasilyan@soton.ac.uk',NULL,'2017-07-23 18:54:31','IT','2017-07-23 17:54:31',6,12345678);
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'Svitlana Braichenko','sb2g14@soton.ac.uk','$2y$10$SaTgdZYLW5y2VtU.yH.yz.XiQgKqSL9wUmwZyODeBCCoNWts./7g2','tokQ17nKsRJNAjhyU52WJZ1nO3jPi3XLu3H0BVn2X2pC6uTiU50lMeZfyNMK','2017-07-29 18:41:02','2017-07-29 18:41:02');
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

-- Dump completed on 2017-07-29 21:09:46
