-- MariaDB dump 10.19  Distrib 10.11.6-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: material
-- ------------------------------------------------------
-- Server version	10.11.6-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_token`
--

DROP TABLE IF EXISTS `auth_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_token` (
  `token_hash` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `creation_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login_time` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_token`
--

LOCK TABLES `auth_token` WRITE;
/*!40000 ALTER TABLE `auth_token` DISABLE KEYS */;
INSERT INTO `auth_token` VALUES
('3090320d3735ac890a2c421c2642197911c08dbc4621a873dd7fb0dbd9a59ad5','test','2024-10-14 13:36:45',NULL),
('944e47dfcf8e9b56ebd1d667648f738b740a2f77512206b5c37698c8c33feb29','test','2024-10-14 13:40:04','2024-10-14 13:40:04'),
('f2663f7dd24f14ab49427e13693224121fc79a1d4edd6ab247e8001e1de0abf3','test','2024-10-14 13:41:24','2024-10-14 13:41:24'),
('a5687eb220a0814f3912af145e03c6cd6db9136a3bf309f82c8ab7db4a34999d','test','2024-10-23 05:14:39','2024-10-23 05:14:39'),
('a06789dc0dc2b095673240cf890dee276fc00f6b230eae2dfba84d3066c7929e','test','2024-10-23 05:19:54','2024-10-23 05:19:54'),
('a5c657481d747ad29736952a4a42747892c875c504f49cd036d4ae83a33962cf','test','2024-10-23 05:23:06','2024-10-23 05:23:06'),
('d41db838678a407f3eb4f0a222435c7a31c4a5ddb4c1d1813d854252cbb406bc','test','2024-10-23 05:23:47','2024-10-23 05:23:47'),
('8d12214276200abdf14d1888ba95cfcafb03607a91e829433829702cb306c08e','test','2024-10-23 05:25:40','2024-10-23 05:25:40'),
('b12750f95bc2b3a16c2bfbfef5791491cdd2374227cbe1a289c9a38b6906bf1b','test','2024-10-23 05:25:57','2024-10-23 05:25:57'),
('eab2757edc7ee3e0f84eaec51af94f96c2ba82923caaac22bf4ad8948e0bbfc3','test','2024-10-23 05:26:11','2024-10-23 05:26:11'),
('764b1111fa5b35e4c4da542cb8e12d2eafe11629acbb8da2bf8ef6b887f25256','test','2024-10-23 05:28:38','2024-10-23 05:28:38'),
('73d34979c892494a72232e68f5f73b88476d37b4a278897a08fd9592df4027cb','test','2024-10-23 05:41:33','2024-10-23 05:41:33'),
('b1b809543c8f961cecee359e61be58ba6322d5f174dda936d934e5c4a3b8e414','test','2024-10-23 05:41:44','2024-10-23 05:41:44'),
('8da2c24125592683601a28efad58077826fef77c8976b7002d697eb3482ecc36','test','2024-10-23 06:32:22','2024-10-23 06:32:22'),
('3a38a07d8e69e0ace93d470c33f02a1a16eda587a1e494887cd7f7addd9dd343','test','2024-10-23 06:32:40','2024-10-23 06:32:40');
/*!40000 ALTER TABLE `auth_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
('Robert\\Materialverwaltung\\Migrations\\Version20240930112633','2024-09-30 11:30:48',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `latest_login` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES
(1,'oliver','$2y$10$WDym7ODMmvCBha4L5VbiN.zE1P7B/m4rQ5OwVEb0a/b7iJzTAEytu',NULL),
(2,'robert','$2y$10$QHF0LVY9UHZuxzxen1XOD.t9qe2p5BETLK2FhVu02GY3T2vqeumsW',NULL),
(3,'frederick','2y$10$10M98mstsnie7cua67yq1uG1lKqBiO9zU3R/E6XiMDgjtF1iUIA6e',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-23  9:51:12
