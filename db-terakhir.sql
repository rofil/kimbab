-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: research-unmul
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

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
-- Table structure for table `additional_output`
--

DROP TABLE IF EXISTS `additional_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `additional_output` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uploader_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D7CE6DF16678C77` (`uploader_id`),
  KEY `IDX_9D7CE6DF40C1FEA7` (`year_id`),
  KEY `IDX_9D7CE6DF12469DE2` (`category_id`),
  CONSTRAINT `FK_9D7CE6DF12469DE2` FOREIGN KEY (`category_id`) REFERENCES `additional_output_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_9D7CE6DF16678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_9D7CE6DF40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_output`
--

LOCK TABLES `additional_output` WRITE;
/*!40000 ALTER TABLE `additional_output` DISABLE KEYS */;
INSERT INTO `additional_output` VALUES (1,5,2,'Generic DNA Design Schema','3422','2019-06-28 09:08:44','2019-09-25 01:43:17','266be4f93f0d7d755e089bc856e6e667.xlsx',1),(2,5,2,'Yes','reere','2019-07-04 14:41:48','2019-07-04 14:41:48',NULL,1),(3,5,1,'Framework for Predicting Student Behavior','Framework for Predicting Student Behavior','2019-07-05 11:00:02','2019-07-05 11:00:02','67c6e998df21c82e264cfcd7d4252a43.png',1),(4,6,1,'Model Keramba','ERTERT','2019-07-10 15:55:08','2019-09-24 16:16:33','e5fa761e9846b789070975b96b18d44f.docx',1),(5,6,1,'Paripurna','wewe','2019-07-11 12:16:13','2019-09-24 16:16:33','1efacbb369b43d1a3c46f41e02dc17e0.png',1),(6,5,1,'asd','asdas','2019-09-25 01:00:08','2019-09-25 01:18:38','4c30ecb4f771dbc0f1fb49509796f136.xls',1),(7,5,1,'werwer','werwer','2019-09-25 01:43:34','2019-09-25 01:43:34','ea82c1b78dea06da4d79bfe608eeea22.docx',1);
/*!40000 ALTER TABLE `additional_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `additional_output_category`
--

DROP TABLE IF EXISTS `additional_output_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `additional_output_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_output_category`
--

LOCK TABLES `additional_output_category` WRITE;
/*!40000 ALTER TABLE `additional_output_category` DISABLE KEYS */;
INSERT INTO `additional_output_category` VALUES (1,'Model','Model'),(2,'Prototype',NULL),(3,'TTG',NULL),(4,'Kebijakan',NULL),(5,'Karya Seni',NULL),(6,'Desain',NULL);
/*!40000 ALTER TABLE `additional_output_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `additional_output_lecturer`
--

DROP TABLE IF EXISTS `additional_output_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `additional_output_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `additional_output_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E3E09EABA2D8762` (`lecturer_id`),
  KEY `IDX_3E3E09EAB103DEDD` (`additional_output_id`),
  CONSTRAINT `FK_3E3E09EAB103DEDD` FOREIGN KEY (`additional_output_id`) REFERENCES `additional_output` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_3E3E09EABA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_output_lecturer`
--

LOCK TABLES `additional_output_lecturer` WRITE;
/*!40000 ALTER TABLE `additional_output_lecturer` DISABLE KEYS */;
INSERT INTO `additional_output_lecturer` VALUES (3,9,2),(4,5,2),(5,5,3),(6,6,4),(8,6,5),(9,13,5),(10,14,5),(12,5,1),(13,NULL,6),(14,5,7);
/*!40000 ALTER TABLE `additional_output_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_id` int DEFAULT NULL,
  `uploader_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_pages` int DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `classification` int NOT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A33140C1FEA7` (`year_id`),
  KEY `IDX_CBE5A33116678C77` (`uploader_id`),
  KEY `IDX_CBE5A33112469DE2` (`category_id`),
  CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `book_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CBE5A33116678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_CBE5A33140C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,1,5,'Laravel Framework',150,'FTIKOM Press','123','1','ab2bffa132dbffbdd0dca32020f77bc5.pdf','2019-06-26 08:33:22','2019-09-25 01:12:20',1,2),(2,2,5,'Python in Action',220,'MUP Press','123','1','1a297b7995d3f1439dfb2d99ade02130.pdf','2019-07-02 09:04:46','2019-07-03 14:31:23',1,3),(3,2,5,'Dasar Pemrograman dengan Menggunakan Python',150,'MUP Press','12344','1','a6ec4a880c9ce8cd60bab698c057a8b1.pdf','2019-07-05 10:19:53','2019-09-25 01:11:57',1,2),(5,1,5,'Pengabdian',129,'MUP Press','123','1','4c19dfcb2436f41ae7cf491c825b306f.docx','2019-07-09 06:38:10','2019-07-13 22:06:19',2,1),(6,1,5,'X',10,'1','1','1','24676b7869e1f3186b836b08be399fb0.docx','2019-07-09 06:40:59','2019-09-25 01:35:33',2,1),(8,1,5,'QWQW',1,NULL,NULL,NULL,'8d07d241b7b66e5398669fa48074db4c.doc','2019-09-25 01:36:00','2019-09-25 01:36:00',1,1),(9,1,5,'232',1,'1','1',NULL,'3fbc35142676b1d7c8e404c156c4234f.docx','2019-09-25 01:36:28','2019-09-25 01:36:28',2,1);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_category`
--

LOCK TABLES `book_category` WRITE;
/*!40000 ALTER TABLE `book_category` DISABLE KEYS */;
INSERT INTO `book_category` VALUES (1,'Monograf','Monograf'),(2,'Buku Ajar','Buku Ajar'),(3,'Buku Teks',NULL);
/*!40000 ALTER TABLE `book_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_lecturer`
--

DROP TABLE IF EXISTS `book_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `book_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `book_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D30471FBA2D8762` (`lecturer_id`),
  KEY `IDX_D30471F16A2B381` (`book_id`),
  CONSTRAINT `FK_D30471F16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_D30471FBA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_lecturer`
--

LOCK TABLES `book_lecturer` WRITE;
/*!40000 ALTER TABLE `book_lecturer` DISABLE KEYS */;
INSERT INTO `book_lecturer` VALUES (6,5,2),(7,5,3),(8,7,3),(12,8,5),(13,10,6),(14,6,1),(17,10,5),(19,5,8),(20,5,9);
/*!40000 ALTER TABLE `book_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service`
--

DROP TABLE IF EXISTS `community_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_service` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_id` int DEFAULT NULL,
  `uploader_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int NOT NULL,
  `level` int NOT NULL,
  `funding_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funding` double NOT NULL,
  `number_of_students` int NOT NULL,
  `number_of_alumni` double NOT NULL,
  `number_of_staff` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C558F38140C1FEA7` (`year_id`),
  KEY `IDX_C558F38116678C77` (`uploader_id`),
  CONSTRAINT `FK_C558F38116678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_C558F38140C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service`
--

LOCK TABLES `community_service` WRITE;
/*!40000 ALTER TABLE `community_service` DISABLE KEYS */;
INSERT INTO `community_service` VALUES (2,1,6,'Peningkatan Hasil Panen Ikan dengan Produk X',1,1,'DRPM',150000,4,0,0,'f3af8e3c93399734caaf656f096214df.docx','2019-07-10 15:36:47','2019-07-10 15:36:47'),(3,1,5,'asas',1,1,'11',1,1,1,1,'857c3d73420e887815749a3bc8918460.docx','2019-09-25 01:19:39','2019-09-25 01:19:39');
/*!40000 ALTER TABLE `community_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service_lecturer`
--

DROP TABLE IF EXISTS `community_service_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_service_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `community_service_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6BDA3B54BA2D8762` (`lecturer_id`),
  KEY `IDX_6BDA3B54DC97DFFA` (`community_service_id`),
  CONSTRAINT `FK_6BDA3B54BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_6BDA3B54DC97DFFA` FOREIGN KEY (`community_service_id`) REFERENCES `community_service` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service_lecturer`
--

LOCK TABLES `community_service_lecturer` WRITE;
/*!40000 ALTER TABLE `community_service_lecturer` DISABLE KEYS */;
INSERT INTO `community_service_lecturer` VALUES (3,6,2),(4,8,2),(5,6,3);
/*!40000 ALTER TABLE `community_service_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service_partner`
--

DROP TABLE IF EXISTS `community_service_partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `community_service_partner` (
  `id` int NOT NULL AUTO_INCREMENT,
  `community_service_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_entity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `increase_in_profit` double DEFAULT NULL,
  `funding_provision` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4E4C975ADC97DFFA` (`community_service_id`),
  CONSTRAINT `FK_4E4C975ADC97DFFA` FOREIGN KEY (`community_service_id`) REFERENCES `community_service` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service_partner`
--

LOCK TABLES `community_service_partner` WRITE;
/*!40000 ALTER TABLE `community_service_partner` DISABLE KEYS */;
INSERT INTO `community_service_partner` VALUES (2,2,'Kelompok Tani Ikan Mujair','Budidaya Ikan Sungai',150000,0),(3,3,'ewew','ewew',1,1);
/*!40000 ALTER TABLE `community_service_partner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference`
--

DROP TABLE IF EXISTS `conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conference` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uploader_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_of_conference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_participation` int NOT NULL,
  `conference_date` date NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` smallint NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_911533C816678C77` (`uploader_id`),
  KEY `IDX_911533C840C1FEA7` (`year_id`),
  CONSTRAINT `FK_911533C816678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_911533C840C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference`
--

LOCK TABLES `conference` WRITE;
/*!40000 ALTER TABLE `conference` DISABLE KEYS */;
INSERT INTO `conference` VALUES (1,5,1,'DNA Computing to Solve Vertex Covering Problem','ICoSNIKOM',1,'2018-11-23','Medan, Indonesia',3,'2019-06-27 08:06:33','2019-09-25 01:15:48','785af6bd3450640e0cf82e20d87d30b6.pdf',1),(2,5,2,'DNA Computing to Solve DCLP','IEEE Conference Series',1,'2014-09-27','Penang, Malaysia',3,'2019-07-01 06:03:42','2019-09-25 01:33:58','74a8f07c7c12e9a769106852905aa0d3.pdf',2),(3,5,1,'DNA Computing to Solve Vertex Cover Problem','ICoSNIKOM',1,'2018-11-28','Medan, Indonesia',3,'2019-07-05 10:48:17','2019-07-09 19:39:07','f7244c08ada2f28a1d6b5dc640dcd643.pdf',1),(4,5,1,'qqwq','qwqw',1,'2019-09-18','qwq',1,'2019-09-25 00:59:13','2019-09-25 00:59:13','55438da5572f73e585e34d6f9a2498af.docx',1);
/*!40000 ALTER TABLE `conference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference_lecturer`
--

DROP TABLE IF EXISTS `conference_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conference_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `conference_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D18E9767BA2D8762` (`lecturer_id`),
  KEY `IDX_D18E9767604B8382` (`conference_id`),
  CONSTRAINT `FK_D18E9767604B8382` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_D18E9767BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_lecturer`
--

LOCK TABLES `conference_lecturer` WRITE;
/*!40000 ALTER TABLE `conference_lecturer` DISABLE KEYS */;
INSERT INTO `conference_lecturer` VALUES (1,5,1),(2,5,2),(3,7,2),(5,5,3),(6,6,3),(7,5,4);
/*!40000 ALTER TABLE `conference_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference_organizer`
--

DROP TABLE IF EXISTS `conference_organizer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conference_organizer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` smallint NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `held_on` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D57820EBF8BD700D` (`unit_id`),
  KEY `IDX_D57820EB40C1FEA7` (`year_id`),
  CONSTRAINT `FK_D57820EB40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_D57820EBF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_organizer`
--

LOCK TABLES `conference_organizer` WRITE;
/*!40000 ALTER TABLE `conference_organizer` DISABLE KEYS */;
INSERT INTO `conference_organizer` VALUES (2,6,2,'International Conference on Fishery, Marine and Ocean',NULL,3,'Samarinda, Indonesia','2019-01-01','2019-07-10 11:13:30','2019-07-10 15:25:14'),(3,6,1,'Seminar Nasional Sungai Mahakam','Pemerintah Kota Samarinda',2,'Samarinda','2014-01-01','2019-07-10 15:24:56','2019-07-10 15:25:14');
/*!40000 ALTER TABLE `conference_organizer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract`
--

LOCK TABLES `contract` WRITE;
/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `document` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_draft` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employment_contract`
--

DROP TABLE IF EXISTS `employment_contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `employment_contract` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_value` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_165EC366F8BD700D` (`unit_id`),
  KEY `IDX_165EC36640C1FEA7` (`year_id`),
  CONSTRAINT `FK_165EC36640C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_165EC366F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment_contract`
--

LOCK TABLES `employment_contract` WRITE;
/*!40000 ALTER TABLE `employment_contract` DISABLE KEYS */;
INSERT INTO `employment_contract` VALUES (1,5,1,'Prog','Dinas Pendidikan Kota Samarinda','1234',1220,'2019-07-05 15:39:21','2019-07-05 15:39:21'),(2,6,2,'Pembuatan Aplikasi','Provinsi Kalimantan Timur','1234',1000000000,'2019-07-10 11:33:13','2019-07-10 12:23:06'),(3,15,1,'Kontrak kerja 1','Pemerintah Provinsi Kalimantan Timur','x/x/x/x/2018',10000000,'2019-09-21 05:22:06','2019-09-21 05:22:06');
/*!40000 ALTER TABLE `employment_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `information` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT '2019-02-01 00:00:00',
  `updated_at` datetime NOT NULL DEFAULT '2019-02-01 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `information`
--

LOCK TABLES `information` WRITE;
/*!40000 ALTER TABLE `information` DISABLE KEYS */;
INSERT INTO `information` VALUES (1,'Tentang Sistem Informasi Kinerja Penelitian dan Pengabdian','Tentang Kami',1,'2019-07-13 08:38:56','2019-07-13 08:38:56');
/*!40000 ALTER TABLE `information` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intellectual_category`
--

DROP TABLE IF EXISTS `intellectual_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intellectual_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intellectual_category`
--

LOCK TABLES `intellectual_category` WRITE;
/*!40000 ALTER TABLE `intellectual_category` DISABLE KEYS */;
INSERT INTO `intellectual_category` VALUES (1,'Paten Sederhana','Paten sederhana meliputi ???'),(2,'Hak Cipta','Pengakuan terhadap pembuatan sesuatu'),(3,'Paten','kjafasdfa');
/*!40000 ALTER TABLE `intellectual_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intellectual_property`
--

DROP TABLE IF EXISTS `intellectual_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intellectual_property` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` int DEFAULT NULL,
  `classification` smallint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1AEBA93940C1FEA7` (`year_id`),
  KEY `IDX_1AEBA93912469DE2` (`category_id`),
  KEY `IDX_1AEBA939F675F31B` (`author_id`),
  CONSTRAINT `FK_1AEBA93912469DE2` FOREIGN KEY (`category_id`) REFERENCES `intellectual_category` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_1AEBA93940C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_1AEBA939F675F31B` FOREIGN KEY (`author_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intellectual_property`
--

LOCK TABLES `intellectual_property` WRITE;
/*!40000 ALTER TABLE `intellectual_property` DISABLE KEYS */;
INSERT INTO `intellectual_property` VALUES (8,1,1,'Paten BIO','Rofilde Hasudungan',1,'45a02243b240b30af5302510d197f891.pdf',5,1),(9,1,1,'Paten Pengkodean DNA Design Schema secara generik','78903475',5,'f91c57e1f86177f3bf5214f48dea9f90.png',5,1),(10,1,2,'Paten IOIo','9euruere',5,'2f0044f2d0c1f06363d374ffb6459431.pdf',5,1),(13,1,2,'323','2323',5,'44d9754382009595917ffe4792567518.docx',6,1),(14,1,1,'sdfdsf','dfdf',5,'3d019c34a187b08c35833aad2cd72eb6.pdf',6,1),(15,1,1,'tESING','LIJSAFLDS',5,'2994d722c9db9546c1cc924cc62855d6.png',7,1),(16,13,1,'Extract X','sdfsdf',5,'74b8cfecc8a980886ec65401b02add87.pdf',6,1),(17,15,1,'ASDFDSAF','1234',5,'0e21ee26f5b41bbe97067bafcf63237d.docx',6,1),(19,1,1,'wew','wew',5,'43dbf85399ddb875da0dca048c701bf2.docx',5,1);
/*!40000 ALTER TABLE `intellectual_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intellectual_property_lecturer`
--

DROP TABLE IF EXISTS `intellectual_property_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `intellectual_property_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `intellectual_property_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AE754D18BA2D8762` (`lecturer_id`),
  KEY `IDX_AE754D185E62765` (`intellectual_property_id`),
  CONSTRAINT `FK_AE754D185E62765` FOREIGN KEY (`intellectual_property_id`) REFERENCES `intellectual_property` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_AE754D18BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intellectual_property_lecturer`
--

LOCK TABLES `intellectual_property_lecturer` WRITE;
/*!40000 ALTER TABLE `intellectual_property_lecturer` DISABLE KEYS */;
INSERT INTO `intellectual_property_lecturer` VALUES (1,5,NULL),(2,5,NULL),(9,10,10),(10,8,NULL),(13,5,NULL),(14,5,NULL),(15,6,13),(16,6,14),(19,6,15),(20,6,16),(21,6,17),(22,8,9),(23,8,10),(26,5,8),(27,5,19);
/*!40000 ALTER TABLE `intellectual_property_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `uploader_id` int DEFAULT NULL,
  `year_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_of_journal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int DEFAULT NULL,
  `number` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` int NOT NULL,
  `abstract` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int NOT NULL,
  `pages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C1A7E74D16678C77` (`uploader_id`),
  KEY `IDX_C1A7E74D40C1FEA7` (`year_id`),
  CONSTRAINT `FK_C1A7E74D16678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_C1A7E74D40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal`
--

LOCK TABLES `journal` WRITE;
/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
INSERT INTO `journal` VALUES (1,6,5,'Generic DNA Encoding Design Schema to Solve Combinatorial Problems','Journal of Sciece',1,1,'http://wdssd','348734761034908337edc373a935f014.jpg',1,'Genetic Algorithm (GA) is a search-based optimization technique based on the principles of Genetics and Natural Selection. It is frequently used to find optimal or near-optimal solutions to difficult problems which otherwise would take a lifetime to solve. It is frequently used to solve optimization problems, in research, and in machine learning.',1,'1-10','12343434X','2019-06-26 18:23:06','2019-07-14 15:32:17'),(2,5,1,'Identifikasi Faktor dalam Prestasi Mahasiswa dengan Menggunakan Algoritma Pohon Keputusan','Jurnal Teknologi dan Informasi',1,1,'http://juri','3d934013f93e43e0d3c7a262da45cbe1.docx',2,'blalbalb',2,'1-10','dsdsds','2019-07-05 10:35:21','2019-07-09 14:10:29'),(4,5,1,'Budaya dan Politik','Journal Ilmu Politik dan Sosial',1,1,'http://google.com','ae4076f9587351946a19a6f609d09880.pdf',1,'vvdfd',2,'1-10','14','2019-07-05 16:44:27','2019-09-25 01:13:58'),(5,5,1,'EFIKASI VAKSIN Pseumulvacc® PADA BUDIDAYA IKAN NILA (Oreochromis niloticus) DI KABUPATEN KUTAI KARTANEGARA','Journal Ilmu Perikanan Tropis',22,1,NULL,'d37371c4bd6e95998dfd7d0b57603b0b.pdf',1,'The aim of this study was to evaluate the eficacy of Pseumulvacc® vaccine and effect of vaccine to tilapia growth and survival rate (SR) on tilapia aquaculture in Kutai Kartanegara, East Kalimantan. This vaccine has made from Pseudomonas sp. (EP-01) inactivated used formalin 3%. Bacteria of Pseudomonas sp. isolated from sick and die tilapia in Loa Kulu, Kutai Kartanegara. The fish used in this study was tilapia (Oreochromis niloticus) weight ±11 g and length ±7,5 cm, the research done in 3 method, immersion, feed and control. The density of bacteria vaccine in 3 method ware 108 CFU/mL\r\nfor immersion, 104 CFU/mL for feed and no added vaccine in control method. Immersion method procedure begins dips tilapia with vaccine for 30 minutes (5-10 of fish/L). While vaccine by feed method begins by mixing the vaccine with feed (1 mL / g feed). Mixing feed gave to tilapia for 14 days with 2 times daily, then the fish reared for 30 days. The observed parameters ware survival rate (SR), relative percent survival (RPS), and growth (weight and length of fish). The result of this study shown that Pseumulvacc® survival rate (SR) in immersion method was 52,8% and by feed method was 29,5%. Relative percent survival (RPS) of each research ware 40,9% by immersion and 11,7% by feed. The best growth in this research is feed method rate by 28,33 g/month than immersion method 16,33 g/month.',2,'30-35','1412-2006','2019-07-05 17:04:13','2019-07-13 08:33:44'),(7,5,1,'tesing','1',1,1,'1','d7ea097fa3679056db4e9523f87d1592.docx',2,'sdfsfs',1,'12','1','2019-07-08 16:32:26','2019-07-08 16:32:26'),(8,5,1,'wew','1',NULL,NULL,NULL,'b4fa259d79d8a0821e692a28043fae46.docx',1,'ewew',1,'1',NULL,'2019-09-25 00:58:22','2019-09-25 00:58:22');
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_lecturer`
--

DROP TABLE IF EXISTS `journal_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lecturer_id` int DEFAULT NULL,
  `journal_id` int DEFAULT NULL,
  `order_number` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C47FFCFFBA2D8762` (`lecturer_id`),
  KEY `IDX_C47FFCFF478E8802` (`journal_id`),
  CONSTRAINT `FK_C47FFCFF478E8802` FOREIGN KEY (`journal_id`) REFERENCES `journal` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_C47FFCFFBA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_lecturer`
--

LOCK TABLES `journal_lecturer` WRITE;
/*!40000 ALTER TABLE `journal_lecturer` DISABLE KEYS */;
INSERT INTO `journal_lecturer` VALUES (1,5,1,1),(2,17,2,1),(3,6,2,2),(4,7,1,2),(7,10,4,1),(8,8,4,2),(9,6,5,1),(11,5,NULL,1),(15,10,1,3),(16,10,5,2),(17,8,1,NULL),(18,5,8,NULL);
/*!40000 ALTER TABLE `journal_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lecturer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `affiliation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint DEFAULT NULL,
  `creator_id` int DEFAULT NULL,
  `functional` int NOT NULL,
  `program_id` int DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expertises` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14CF5146F8BD700D` (`unit_id`),
  KEY `IDX_14CF514661220EA6` (`creator_id`),
  KEY `IDX_14CF51463EB8070A` (`program_id`),
  CONSTRAINT `FK_14CF51463EB8070A` FOREIGN KEY (`program_id`) REFERENCES `program` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_14CF514661220EA6` FOREIGN KEY (`creator_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_14CF5146F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer`
--

LOCK TABLES `lecturer` WRITE;
/*!40000 ALTER TABLE `lecturer` DISABLE KEYS */;
INSERT INTO `lecturer` VALUES (5,NULL,'198604072014343','1107048601','Rofilde Hasudungan, S.Kom., M.Sc',2,'2019-06-23 14:13:21','2019-09-25 01:43:34','Universitas Muhammadiyah Kalimantan Timur','b6df2349e567b441516482fcf813c470.png',2,NULL,1,NULL,NULL,NULL),(6,6,'198001042006042003','123','Dr. Esti Handayani Hardi',3,'2019-06-24 23:12:14','2019-10-10 04:53:45','Universitas Mulawarman','7a32f68e52410fbb717e6c1839bdd97b.jpg',1,NULL,4,NULL,'estieriyadi2011@gmail.com','Perikanan Air Tawar'),(7,NULL,NULL,NULL,'Rohani Abu Bakar',3,'2019-07-01 05:57:47','2019-09-25 01:33:58','Univerisiti Malaysia Pahang',NULL,2,NULL,0,NULL,NULL,NULL),(8,3,'197503312005011002',NULL,'Sonny Sudiar, S.IP., M.A',2,'2019-07-03 17:48:43','2019-09-25 01:16:56','Universitas Mulawarman','78072689a628bc452f15fbc8f5819b3b.jpg',1,NULL,4,NULL,NULL,NULL),(9,NULL,NULL,NULL,'Dr. Mazlina Abdul Majid',3,'2019-07-04 14:41:14','2019-07-11 11:31:23','Universiti Malaysia Pahang',NULL,2,NULL,0,NULL,NULL,NULL),(10,3,'197701082006041001',NULL,'Jauchar B., S.IP., M,Si',2,'2019-07-05 16:43:11','2019-09-25 01:35:33','Universitas Mulawarman',NULL,1,NULL,3,NULL,NULL,NULL),(11,NULL,NULL,NULL,'Rozlina Abdul Mazid',NULL,'2019-07-11 11:29:47','2019-07-11 11:29:47','Universiti Malaysia Pahang',NULL,2,NULL,0,NULL,NULL,NULL),(13,NULL,NULL,NULL,'Dina',NULL,'2019-07-11 12:15:37','2019-07-11 12:24:12','Kwundong University',NULL,2,6,0,NULL,NULL,NULL),(14,NULL,NULL,NULL,'Liza Mayer',NULL,'2019-07-11 12:15:54','2019-07-11 12:24:12','Kansas University',NULL,2,6,0,NULL,NULL,NULL),(15,NULL,NULL,NULL,'Rex',NULL,'2019-07-11 12:24:12','2019-07-11 12:24:12','Universitas Padjajaran',NULL,2,6,0,NULL,NULL,NULL),(16,14,NULL,NULL,'Dr. Fahrul Agus',3,'2019-07-15 04:56:26','2019-07-15 04:56:26','Universitas Mulawarman',NULL,1,NULL,4,NULL,NULL,NULL),(17,1,NULL,NULL,'Donny Donanto, M.P',2,'2019-07-15 04:56:57','2019-09-25 00:52:37','Universitas Mulawarman',NULL,1,NULL,2,NULL,NULL,NULL),(18,13,'195407171988031001',NULL,'Dr. H. Mursalim, M.Hum',3,'2019-07-15 05:01:07','2019-07-15 05:01:07','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(19,2,'196206301993032002',NULL,'Isna Yuningsih, SE., MM.,Ak., CA',1,'2019-07-15 05:01:45','2019-07-15 05:01:45','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(20,11,'198303222006041001',NULL,'Insan Tajali Nur, SH, MH',1,'2019-07-15 05:02:49','2019-07-15 05:02:49','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(21,10,'196007271992032002',NULL,'Dra. Siti Badrah, M.Kes',2,'2019-07-15 05:03:18','2019-07-15 05:03:33','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(22,7,'197512172005011005',NULL,'Dr. Shalaho Dina Devy, ST., M.Eng',3,'2019-07-15 05:04:27','2019-07-15 05:04:27','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(23,8,'197712132000122001',NULL,'Dr. Noor Hindryawati, M.Si',1,'2019-07-15 05:04:54','2019-07-15 05:04:54','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(24,4,'197404121998021001',NULL,'Erwin, Phd',1,'2019-07-15 05:05:40','2019-07-15 05:05:40','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(25,9,'197606052005012003',NULL,'Dr. dr. Swandari Paramita, M.Kes',1,'2019-07-15 05:06:39','2019-07-15 05:06:39','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(26,12,NULL,NULL,'Dr. La Ode Rijai',3,'2019-07-15 05:07:18','2019-07-15 05:07:18','Universitas Mulawarman',NULL,1,NULL,0,NULL,NULL,NULL),(27,5,NULL,NULL,'Prof. Dr. Lambang Subagiyo M.Si',3,'2019-07-15 05:16:54','2019-07-15 05:16:54','Universitas Mulawarman',NULL,1,NULL,5,NULL,NULL,NULL),(29,13,'198509182014041001',NULL,'Singgih Daru Kuncara,M.Hum.',NULL,'2019-09-12 17:05:22','2019-09-12 17:07:44','Fakultas Ilmu Budaya',NULL,2,29,3,NULL,NULL,NULL),(30,NULL,NULL,NULL,'Dr. Gupta Kuncara',NULL,'2019-09-12 17:07:26','2019-09-12 17:07:26','Universitas Hasanudin',NULL,2,29,5,NULL,NULL,NULL),(31,6,'197908232005012001',NULL,'Dr. Fitriyana,S.Pi,M.Si',NULL,'2019-09-23 08:40:08','2019-09-23 08:40:08','Fakultas Perikanan dan Ilmu Kelautan',NULL,NULL,NULL,0,2,NULL,NULL),(32,3,'195009101975032002',NULL,'Prof.Ir. Ratna Shanti, M.Sc.',3,'2019-09-23 08:41:40','2019-09-23 10:29:35','Universitas Mulwarman2','1c7de3fd2dc6be4011eed525f6118f59.png',1,NULL,5,3,NULL,NULL),(33,1,'195502201988031001',NULL,'Dr. Warsilan,M.T.',NULL,'2019-09-23 08:42:05','2019-09-23 08:43:18','Universitas Mulawarman',NULL,3,33,0,4,NULL,NULL),(34,6,'195808201984031004',NULL,'Prof. Dr. Ir. H. Helminuddin,M.M',NULL,'2019-09-23 08:46:18','2019-09-23 08:46:18','Universitas Mulawarman',NULL,1,NULL,0,2,NULL,NULL),(35,3,'195009101975032002',NULL,'Prof.Ir. Ratna Shanti,M.Sc.',1,'2019-09-23 09:14:05','2019-09-23 09:14:05','Fakultas Ilmu Sosial dan Ilmu Politik',NULL,1,NULL,0,NULL,NULL,NULL),(36,3,'195009101975032002',NULL,'Prof.Ir. Ratna Shanti, M.Sc.',1,'2019-09-23 09:15:39','2019-09-23 09:15:39','Fakultas Ilmu Sosial dan Ilmu Politik',NULL,1,NULL,0,NULL,NULL,NULL),(37,3,'1950091019750320021',NULL,'Prof.Ir. Ratna Shanti,M.Sc.',1,'2019-09-23 09:15:47','2019-09-23 10:07:57','Fakultas Ilmu Sosial dan Ilmu Politik','893e00be8b6bf89715a1c403354464de.png',1,NULL,5,NULL,NULL,NULL),(38,2,'196001141988031003',NULL,'Prof. Dr. H. Adam Idris,M.Si',NULL,'2019-09-23 11:10:09','2019-09-23 11:10:09','Universitas Mulawarman',NULL,1,NULL,0,5,NULL,NULL);
/*!40000 ALTER TABLE `lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration_versions`
--

LOCK TABLES `migration_versions` WRITE;
/*!40000 ALTER TABLE `migration_versions` DISABLE KEYS */;
INSERT INTO `migration_versions` VALUES ('20190201104853','2019-02-01 10:49:17'),('20190202082506','2019-02-02 08:25:31'),('20190202084914','2019-02-02 08:49:39'),('20190606141219','2019-06-06 14:12:33'),('20190606143310','2019-06-06 14:33:22'),('20190611123238','2019-06-11 12:33:03'),('20190611123611','2019-06-11 12:37:04'),('20190612022655','2019-06-12 02:28:15'),('20190617101031','2019-06-17 10:10:54'),('20190617112538','2019-06-17 11:25:47'),('20190617114811','2019-06-17 11:48:19'),('20190617220130','2019-06-17 22:01:37'),('20190620195640','2019-06-20 19:56:58'),('20190620204826','2019-06-20 20:48:45'),('20190620210323','2019-06-20 21:03:34'),('20190620211232','2019-06-20 21:12:49'),('20190621002250','2019-06-21 00:23:29'),('20190623060804','2019-06-23 06:08:26'),('20190623061006','2019-06-23 06:10:11'),('20190623061130','2019-06-23 06:11:42'),('20190625015124','2019-06-25 01:51:35'),('20190625015622','2019-06-25 01:56:34'),('20190625230134','2019-06-25 23:01:45'),('20190625230425','2019-06-25 23:04:36'),('20190626071652','2019-06-26 07:17:08'),('20190626074637','2019-06-26 07:46:57'),('20190626074817','2019-06-26 07:48:27'),('20190626230925','2019-06-26 23:09:41'),('20190628001028','2019-06-28 00:10:42'),('20190628085029','2019-06-28 08:51:40'),('20190630214852','2019-06-30 21:49:11'),('20190630215115','2019-06-30 21:54:27'),('20190701071725','2019-07-01 07:18:01'),('20190701082137','2019-07-01 08:21:43'),('20190703015628','2019-07-03 01:56:36'),('20190705070145','2019-07-05 07:01:50'),('20190705072257','2019-07-05 07:23:03'),('20190708082557','2019-07-08 08:26:05'),('20190710022223','2019-07-10 02:22:28'),('20190710025607','2019-07-10 02:56:13'),('20190710025824','2019-07-10 02:58:28'),('20190711031519','2019-07-11 03:15:28'),('20190711032905','2019-07-11 03:29:11'),('20190711040820','2019-07-11 04:08:25'),('20190713004738','2019-07-13 00:47:44'),('20190920031608','2019-09-20 03:16:13'),('20190922144832','2019-09-22 14:48:37'),('20190923002136','2019-09-23 00:21:41'),('20190923030453','2019-09-23 03:04:59'),('20190923084337','2019-09-23 08:43:43'),('20190923090718','2019-09-23 09:07:23'),('20190924081600','2019-09-24 08:16:06'),('20190924082218','2019-09-24 08:22:26'),('20191009204900','2019-10-09 20:49:07');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `post_type` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `program`
--

DROP TABLE IF EXISTS `program`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `program` (
  `id` int NOT NULL AUTO_INCREMENT,
  `unit_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784F8BD700D` (`unit_id`),
  CONSTRAINT `FK_92ED7784F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
INSERT INTO `program` VALUES (1,14,'TEKNIK INFORMATIKA'),(2,6,'AGROBISNIS PERIKANAN'),(3,3,'AGROEKOTEKNOLOGI'),(4,1,'EKONOMI PEMBANGUNAN'),(5,2,'ILMU PEMERINTAHAN');
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research`
--

DROP TABLE IF EXISTS `research`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year_id` int NOT NULL,
  `uploader_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funding_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funding` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_57EB50C240C1FEA7` (`year_id`),
  KEY `IDX_57EB50C216678C77` (`uploader_id`),
  CONSTRAINT `FK_57EB50C216678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_57EB50C240C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research`
--

LOCK TABLES `research` WRITE;
/*!40000 ALTER TABLE `research` DISABLE KEYS */;
INSERT INTO `research` VALUES (8,1,NULL,'Penelitian','1',1,'1'),(9,1,5,'Penelitian','LPPM',400000,'a81f459f77038eda1dbe8e6b485ccdbf.doc'),(10,1,5,'wqewew','we',1,'436d377b86c7b0df41a47090205316ab.pdf');
/*!40000 ALTER TABLE `research` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research_lecturer`
--

DROP TABLE IF EXISTS `research_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `research_lecturer` (
  `research_id` int NOT NULL,
  `lecturer_id` int NOT NULL,
  PRIMARY KEY (`research_id`,`lecturer_id`),
  KEY `IDX_E934068C7909E1ED` (`research_id`),
  KEY `IDX_E934068CBA2D8762` (`lecturer_id`),
  CONSTRAINT `FK_E934068C7909E1ED` FOREIGN KEY (`research_id`) REFERENCES `research` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `FK_E934068CBA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research_lecturer`
--

LOCK TABLES `research_lecturer` WRITE;
/*!40000 ALTER TABLE `research_lecturer` DISABLE KEYS */;
/*!40000 ALTER TABLE `research_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `researches_lecturers`
--

DROP TABLE IF EXISTS `researches_lecturers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `researches_lecturers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `research_id` int NOT NULL,
  `lecturer_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9B4785837909E1ED` (`research_id`),
  KEY `IDX_9B478583BA2D8762` (`lecturer_id`),
  CONSTRAINT `FK_9B4785837909E1ED` FOREIGN KEY (`research_id`) REFERENCES `research` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `FK_9B478583BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `researches_lecturers`
--

LOCK TABLES `researches_lecturers` WRITE;
/*!40000 ALTER TABLE `researches_lecturers` DISABLE KEYS */;
INSERT INTO `researches_lecturers` VALUES (1,8,6),(2,9,5),(3,9,17),(4,10,8);
/*!40000 ALTER TABLE `researches_lecturers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'ROLE_ADMIN'),(2,'ROLE_USER'),(3,'ROLE_LECTURER'),(4,'ROLE_OPERATOR'),(5,'ROLE_SUPER_ADMIN'),(6,'ROLE_UNIT'),(8,'ROLE_FACULTY');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `units` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_type` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Fakultas Pertanian','FTNI',1),(2,'Fakultas Ekonomi dan Bisnis','FEB',1),(3,'Fakultas Ilmu Sosial dan Ilmu Politik','FISIP',1),(4,'Fakultas Kehutanan','FHUT',1),(5,'Fakultas Keguruan dan Ilmu Pendidikan','FKIP',1),(6,'Fakultas Perikanan dan Ilmu Kelautan','FPIK',1),(7,'Fakultas Teknik','FTEK',1),(8,'Fakultas Matematika dan Ilmu Pengetahuan Alam','FMIPA',1),(9,'Fakultas Kedokteran','FDOK',1),(10,'Fakultas Kesehatan Masyarakat','FKES',1),(11,'Fakultas Hukum','FHUM',1),(12,'Fakultas Farmasi','FFAR',1),(13,'Fakultas Ilmu Budaya','FIB',1),(14,'Ilmu Komputer dan Teknologi Informasi','FKTI',1),(15,'Lembaga Penelitian dan Pengabdian Masyarakat','LP2M',3);
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D649F8BD700D` (`unit_id`),
  CONSTRAINT `FK_8D93D649F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'198604072014343','admin',NULL),(2,'198001042006042003','1',NULL),(3,'1234','1234',NULL),(4,'445','445',6),(5,'197503312005011002','197503312005011002',3),(10,'198509182014041001','malika0112156666',NULL),(11,'adminlp2m','lp2m2020',15),(12,'operatorlp2m','lp2m2020',15),(13,'197908232005012001','112131',NULL),(14,'195009101975032002','187346',NULL),(15,'195502201988031001','731042',NULL),(16,'195808201984031004','413857',NULL),(17,'196001141988031003','938276',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_roles` (
  `user_id` int NOT NULL,
  `roles_id` int NOT NULL,
  PRIMARY KEY (`user_id`,`roles_id`),
  KEY `IDX_54FCD59FA76ED395` (`user_id`),
  KEY `IDX_54FCD59F38C751C4` (`roles_id`),
  CONSTRAINT `FK_54FCD59F38C751C4` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `FK_54FCD59FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1),(1,2),(1,3),(1,5),(2,2),(2,3),(3,8),(4,6),(4,8),(5,2),(5,3),(10,1),(10,2),(10,3),(11,1),(11,2),(11,4),(11,5),(11,6),(12,1),(12,2),(12,4),(12,6),(13,1),(13,2),(13,3),(14,1),(14,2),(14,3),(15,1),(15,2),(15,3),(16,1),(16,2),(16,3),(17,1),(17,2),(17,3);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `year`
--

DROP TABLE IF EXISTS `year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `year` (
  `id` int NOT NULL AUTO_INCREMENT,
  `year` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `year`
--

LOCK TABLES `year` WRITE;
/*!40000 ALTER TABLE `year` DISABLE KEYS */;
INSERT INTO `year` VALUES (1,'2018','Tahun 2018','2019-09-25 01:43:34','2019-06-21 04:51:41'),(2,'2019','tahun 2019','2019-09-25 01:43:17','2019-06-21 04:52:01'),(3,'2005',NULL,'2019-09-20 11:44:35','2019-07-06 00:19:57'),(4,'2006',NULL,'2019-07-10 15:46:16','2019-07-06 00:20:01'),(5,'2007',NULL,'2019-07-14 15:32:17','2019-07-06 00:20:13'),(6,'2008',NULL,'2019-07-06 00:20:19','2019-07-06 00:20:19'),(7,'2009',NULL,'2019-07-06 00:20:23','2019-07-06 00:20:23'),(8,'2010',NULL,'2019-07-06 00:20:33','2019-07-06 00:20:33'),(9,'2011',NULL,'2019-07-06 00:20:38','2019-07-06 00:20:38'),(10,'2012',NULL,'2019-07-06 00:20:42','2019-07-06 00:20:42'),(11,'2013',NULL,'2019-07-06 00:20:46','2019-07-06 00:20:46'),(12,'2014',NULL,'2019-07-06 00:20:50','2019-07-06 00:20:50'),(13,'2015',NULL,'2019-09-20 11:44:16','2019-07-06 00:20:54'),(14,'2016',NULL,'2019-07-06 00:20:59','2019-07-06 00:20:59'),(15,'2017',NULL,'2019-09-20 11:44:35','2019-07-06 00:21:03');
/*!40000 ALTER TABLE `year` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-03-30 14:52:40
