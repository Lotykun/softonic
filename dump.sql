-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: symfony_db
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `application`
--

DROP TABLE IF EXISTS `application`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` int NOT NULL,
  `total_downloads` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `developer_id` int DEFAULT NULL,
  `application_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_A45BDDC164DD9267` (`developer_id`),
  CONSTRAINT `FK_A45BDDC164DD9267` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=204 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
/*!40000 ALTER TABLE `application` DISABLE KEYS */;
INSERT INTO `application` VALUES (1,'VLC','2.4.0','http://vlc.en.softonic.com','Simply the best multi-format media player','Free (GPL)','https://screenshots.en.sftcdn.net/en/scrn/25000/25339/vlc-media-player-11-100x100.png',8,'5784268','2022-06-15 15:18:17','2022-06-17 12:09:37',1,3075333),(2,'Ares','2.4.0','http://ares.en.softonic.com','Fast and unlimited P2P file sharing','Free (GPL)','https://screenshots.en.sftcdn.net/en/scrn/21000/21824/ares-14-100x100.png',8,'4741260','2022-06-15 16:50:11','2022-06-15 16:50:11',2,21824),(3,'Nero','10.4.3','http://nero.en.softonic.com','The ultimate PC multimedia suite','Trial','https://screenshots.en.sftcdn.net/en/scrn/7000/7595/thumbnail_1444824132-100x100.png',8,'6239531','2022-06-15 16:51:27','2022-06-15 16:57:50',3,62465);
/*!40000 ALTER TABLE `application` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_compatible`
--

DROP TABLE IF EXISTS `application_compatible`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_compatible` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `application_compatible_name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=262 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_compatible`
--

LOCK TABLES `application_compatible` WRITE;
/*!40000 ALTER TABLE `application_compatible` DISABLE KEYS */;
INSERT INTO `application_compatible` VALUES (1,'Windows 10','2022-06-15 15:13:56','2022-06-15 15:13:56'),(2,'Windows 2000','2022-06-15 16:50:11','2022-06-15 16:50:11'),(3,'Windows XP','2022-06-15 16:50:11','2022-06-15 16:50:11'),(4,'Windows Vista','2022-06-15 16:50:11','2022-06-15 16:50:11'),(5,'Windows 7','2022-06-15 16:50:11','2022-06-15 16:50:11'),(6,'Windows 8','2022-06-15 16:50:11','2022-06-15 16:50:11');
/*!40000 ALTER TABLE `application_compatible` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `application_compatibles`
--

DROP TABLE IF EXISTS `application_compatibles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `application_compatibles` (
  `application_id` int NOT NULL,
  `application_compatible_id` int NOT NULL,
  PRIMARY KEY (`application_id`,`application_compatible_id`),
  KEY `IDX_2DE6B3B3E030ACD` (`application_id`),
  KEY `IDX_2DE6B3B68BC8DE2` (`application_compatible_id`),
  CONSTRAINT `FK_2DE6B3B3E030ACD` FOREIGN KEY (`application_id`) REFERENCES `application` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_2DE6B3B68BC8DE2` FOREIGN KEY (`application_compatible_id`) REFERENCES `application_compatible` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application_compatibles`
--

LOCK TABLES `application_compatibles` WRITE;
/*!40000 ALTER TABLE `application_compatibles` DISABLE KEYS */;
INSERT INTO `application_compatibles` VALUES (1,1),(2,2),(2,3),(2,4),(2,5),(2,6),(3,1),(3,6);
/*!40000 ALTER TABLE `application_compatibles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `developer`
--

DROP TABLE IF EXISTS `developer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `developer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `developer_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=270 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `developer`
--

LOCK TABLES `developer` WRITE;
/*!40000 ALTER TABLE `developer` DISABLE KEYS */;
INSERT INTO `developer` VALUES (1,'VideoLan','http://www.videolan.org/','2022-06-15 15:13:25','2022-06-17 12:09:37',801),(2,'AresGalaxy','https://aresgalaxy.io/','2022-06-15 16:50:11','2022-06-15 16:50:11',23),(3,'Nero AG','http://www.nero.com/','2022-06-15 16:51:27','2022-06-15 16:55:33',241);
/*!40000 ALTER TABLE `developer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20220614150340','2022-06-14 15:04:12',65),('DoctrineMigrations\\Version20220614182348','2022-06-14 18:23:58',102),('DoctrineMigrations\\Version20220614190836','2022-06-14 19:09:11',473),('DoctrineMigrations\\Version20220614194950','2022-06-14 19:49:53',71),('DoctrineMigrations\\Version20220614195247','2022-06-14 19:52:52',62),('DoctrineMigrations\\Version20220615150019','2022-06-15 15:00:44',137),('DoctrineMigrations\\Version20220615150911','2022-06-15 15:09:15',111);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra`
--

DROP TABLE IF EXISTS `extra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `xml` varchar(16000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra`
--

LOCK TABLES `extra` WRITE;
/*!40000 ALTER TABLE `extra` DISABLE KEYS */;
/*!40000 ALTER TABLE `extra` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-17 12:37:26
