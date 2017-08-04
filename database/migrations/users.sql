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
INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (5,'Admin','ai1v14@soton.ac.uk','$2y$10$P9uYX7nEXADt1tO8Tt2GdueVnuoxd2BPfX4gbueGyIjlZJiEqS2fC','92WdCYFUM7x8j2KHu3hDHHy25VIQJB0YIAFYqVMFI6vfTF95KHDy6K78vTsa','2017-07-30 13:31:44','2017-07-30 13:31:44'),(6,'LeadDemonstrator','LD@soton.ac.uk','$2y$10$JERDrcffJObag0cs4bEkpee.xiwBD.PoMcfnoSxFIFCAKn25rzxu2','lCCAi3EHu89WMKQryk9do56586TEc8vYNew6vvR2R7UkZQgOw3AddLpYtm1l','2017-07-30 13:43:54','2017-07-30 13:43:54'),(7,'Demonstrator1','D1@soton.ac.uk','$2y$10$4DRAsquExQr1f9OWRFr4ROP./h95MGvarPkd4zeVrS9Zg6kinp1ty','jvCc4LuzyySKp0KYwbZlW8R10l06a1FTJYCGFdn6BoPDUSzMup8wGET8WQKk','2017-07-30 13:44:23','2017-07-30 13:44:23'),(8,'NewDemonstrator1','ND1@soton.ac.uk','$2y$10$aSirAeTSUXXqn.aVstCNt.ahNYZI5eZFZwFyin9atEe9Uv8wrSmWS','6l0zQtZDypltFLNrsGLW3Hp4yiZIGVxWFmnYysyqklbng82bKcHY0apIyb6z','2017-07-30 13:44:57','2017-07-30 13:44:57'),(9,'OldDemonstrator1','OD1@soton.ac.uk','$2y$10$C8b6NszOZ9WF9m0N10ELYuki0vUzoMcDjD47VR13JyX3FS.yNzLpi','oCt4J5Wq2sOXAYfusSZlcsBoTVHJzmm5bHEpen7lTdSfuH5Q1zzLFsMamvXe','2017-07-30 13:45:30','2017-07-30 13:45:30');
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

-- Dump completed on 2017-08-04 13:55:49
