-- MySQL dump 10.13  Distrib 5.7.27, for Linux (x86_64)
--
-- Host: localhost    Database: research-unmul
-- ------------------------------------------------------
-- Server version	5.7.27-0ubuntu0.18.04.1

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
-- Table structure for table `additional_output`
--

DROP TABLE IF EXISTS `additional_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uploader_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D7CE6DF16678C77` (`uploader_id`),
  KEY `IDX_9D7CE6DF40C1FEA7` (`year_id`),
  KEY `IDX_9D7CE6DF12469DE2` (`category_id`),
  CONSTRAINT `FK_9D7CE6DF12469DE2` FOREIGN KEY (`category_id`) REFERENCES `additional_output_category` (`id`),
  CONSTRAINT `FK_9D7CE6DF16678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_9D7CE6DF40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_output`
--

LOCK TABLES `additional_output` WRITE;
/*!40000 ALTER TABLE `additional_output` DISABLE KEYS */;
INSERT INTO `additional_output` VALUES (1,5,2,'Generic DNA Design Schema','3422','2019-06-28 09:08:44','2019-07-09 19:22:09','266be4f93f0d7d755e089bc856e6e667.xlsx',1),(2,5,2,'Yes','reere','2019-07-04 14:41:48','2019-07-04 14:41:48',NULL,1),(3,5,1,'Framework for Predicting Student Behavior','Framework for Predicting Student Behavior','2019-07-05 11:00:02','2019-07-05 11:00:02','67c6e998df21c82e264cfcd7d4252a43.png',1),(4,6,1,'DGRETGE','ERTERT','2019-07-10 15:55:08','2019-07-11 12:16:13','e5fa761e9846b789070975b96b18d44f.docx',1),(5,6,1,'Paripurna','wewe','2019-07-11 12:16:13','2019-07-11 12:16:13','1efacbb369b43d1a3c46f41e02dc17e0.png',1);
/*!40000 ALTER TABLE `additional_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `additional_output_category`
--

DROP TABLE IF EXISTS `additional_output_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_output_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `additional_output_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `additional_output_id` int(11) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E3E09EABA2D8762` (`lecturer_id`),
  KEY `IDX_3E3E09EAB103DEDD` (`additional_output_id`),
  CONSTRAINT `FK_3E3E09EAB103DEDD` FOREIGN KEY (`additional_output_id`) REFERENCES `additional_output` (`id`),
  CONSTRAINT `FK_3E3E09EABA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `additional_output_lecturer`
--

LOCK TABLES `additional_output_lecturer` WRITE;
/*!40000 ALTER TABLE `additional_output_lecturer` DISABLE KEYS */;
INSERT INTO `additional_output_lecturer` VALUES (2,5,1,2),(3,9,2,NULL),(4,5,2,NULL),(5,5,3,1),(6,6,4,1),(8,6,5,1),(9,13,5,2),(10,14,5,3);
/*!40000 ALTER TABLE `additional_output_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_id` int(11) DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number_of_pages` int(11) DEFAULT NULL,
  `publisher` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isbn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `edition` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `classification` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_CBE5A33140C1FEA7` (`year_id`),
  KEY `IDX_CBE5A33116678C77` (`uploader_id`),
  KEY `IDX_CBE5A33112469DE2` (`category_id`),
  CONSTRAINT `FK_CBE5A33112469DE2` FOREIGN KEY (`category_id`) REFERENCES `book_category` (`id`),
  CONSTRAINT `FK_CBE5A33116678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_CBE5A33140C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,1,5,'Laravel Framework',150,'FTIKOM Press','123','1','ab2bffa132dbffbdd0dca32020f77bc5.pdf','2019-06-26 08:33:22','2019-07-13 22:18:21',1,2),(2,2,5,'Python in Action',220,'MUP Press','123','1','1a297b7995d3f1439dfb2d99ade02130.pdf','2019-07-02 09:04:46','2019-07-03 14:31:23',1,3),(3,2,5,'Dasar Pemrograman dengan Menggunakan Python',150,'MUP Press','12344','1','a6ec4a880c9ce8cd60bab698c057a8b1.pdf','2019-07-05 10:19:53','2019-07-05 10:22:58',1,2),(4,4,6,'Yes',119,'12',NULL,NULL,'53bddded6f1c0c412295fa66df81d710.docx','2019-07-08 15:38:55','2019-07-10 16:27:29',1,1),(5,1,5,'Pengabdian',129,'MUP Press','123','1','4c19dfcb2436f41ae7cf491c825b306f.docx','2019-07-09 06:38:10','2019-07-13 22:06:19',2,1),(6,1,5,'X',10,'1','1','1','24676b7869e1f3186b836b08be399fb0.docx','2019-07-09 06:40:59','2019-07-13 22:05:55',2,1),(7,2,6,'sdf',22,'FTIKOM Press','123','1','6374c1cb14bb48de88d6aac129850fa3.docx','2019-07-10 16:27:29','2019-07-10 16:27:29',1,1);
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_category`
--

DROP TABLE IF EXISTS `book_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D30471FBA2D8762` (`lecturer_id`),
  KEY `IDX_D30471F16A2B381` (`book_id`),
  CONSTRAINT `FK_D30471F16A2B381` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `FK_D30471FBA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_lecturer`
--

LOCK TABLES `book_lecturer` WRITE;
/*!40000 ALTER TABLE `book_lecturer` DISABLE KEYS */;
INSERT INTO `book_lecturer` VALUES (5,10,1,1),(6,5,2,NULL),(7,5,3,1),(8,7,3,3),(9,6,3,2),(10,6,4,1),(11,5,4,2),(12,8,5,NULL),(13,10,6,NULL),(14,6,1,2),(16,6,7,NULL),(17,10,5,NULL);
/*!40000 ALTER TABLE `book_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service`
--

DROP TABLE IF EXISTS `community_service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_id` int(11) DEFAULT NULL,
  `uploader_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `funding_source` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `funding` double NOT NULL,
  `number_of_students` int(11) NOT NULL,
  `number_of_alumni` double NOT NULL,
  `number_of_staff` double NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C558F38140C1FEA7` (`year_id`),
  KEY `IDX_C558F38116678C77` (`uploader_id`),
  CONSTRAINT `FK_C558F38116678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_C558F38140C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service`
--

LOCK TABLES `community_service` WRITE;
/*!40000 ALTER TABLE `community_service` DISABLE KEYS */;
INSERT INTO `community_service` VALUES (2,1,6,'Peningkatan Hasil Panen Ikan dengan Produk X',1,1,'DRPM',150000,4,0,0,'f3af8e3c93399734caaf656f096214df.docx','2019-07-10 15:36:47','2019-07-10 15:36:47');
/*!40000 ALTER TABLE `community_service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service_lecturer`
--

DROP TABLE IF EXISTS `community_service_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_service_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `community_service_id` int(11) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6BDA3B54BA2D8762` (`lecturer_id`),
  KEY `IDX_6BDA3B54DC97DFFA` (`community_service_id`),
  CONSTRAINT `FK_6BDA3B54BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_6BDA3B54DC97DFFA` FOREIGN KEY (`community_service_id`) REFERENCES `community_service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service_lecturer`
--

LOCK TABLES `community_service_lecturer` WRITE;
/*!40000 ALTER TABLE `community_service_lecturer` DISABLE KEYS */;
INSERT INTO `community_service_lecturer` VALUES (3,6,2,1),(4,8,2,2);
/*!40000 ALTER TABLE `community_service_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `community_service_partner`
--

DROP TABLE IF EXISTS `community_service_partner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_service_partner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `community_service_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_entity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `increase_in_profit` double DEFAULT NULL,
  `funding_provision` double DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4E4C975ADC97DFFA` (`community_service_id`),
  CONSTRAINT `FK_4E4C975ADC97DFFA` FOREIGN KEY (`community_service_id`) REFERENCES `community_service` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_service_partner`
--

LOCK TABLES `community_service_partner` WRITE;
/*!40000 ALTER TABLE `community_service_partner` DISABLE KEYS */;
INSERT INTO `community_service_partner` VALUES (2,2,'Kelompok Tani Ikan Mujair','Budidaya Ikan Sungai',150000,0);
/*!40000 ALTER TABLE `community_service_partner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference`
--

DROP TABLE IF EXISTS `conference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uploader_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_of_conference` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_participation` int(11) NOT NULL,
  `conference_date` date NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_911533C816678C77` (`uploader_id`),
  KEY `IDX_911533C840C1FEA7` (`year_id`),
  CONSTRAINT `FK_911533C816678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_911533C840C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference`
--

LOCK TABLES `conference` WRITE;
/*!40000 ALTER TABLE `conference` DISABLE KEYS */;
INSERT INTO `conference` VALUES (1,5,1,'DNA Computing to Solve Vertex Covering Problem','ICoSNIKOM',1,'2018-11-23','Medan, Indonesia',3,'2019-06-27 08:06:33','2019-07-15 04:55:16','785af6bd3450640e0cf82e20d87d30b6.pdf',1),(2,5,2,'DNA Computing to Solve DCLP','IEEE Conference Series',1,'2014-09-27','Penang, Malaysia',3,'2019-07-01 06:03:42','2019-07-09 14:40:49','74a8f07c7c12e9a769106852905aa0d3.pdf',2),(3,5,1,'DNA Computing to Solve Vertex Cover Problem','ICoSNIKOM',1,'2018-11-28','Medan, Indonesia',3,'2019-07-05 10:48:17','2019-07-09 19:39:07','f7244c08ada2f28a1d6b5dc640dcd643.pdf',1),(4,6,1,'Konferensi Penelitian','International Conference on Research and Innovation',1,'2019-07-09','Samarinda, Indonesia',1,'2019-07-09 22:26:47','2019-07-10 15:51:29','cf09ce0e2d7d9c16007cc0b427fa2b43.png',1),(5,6,1,'sdfsd','sdfsdf',1,'2019-07-10','sdfsdf',1,'2019-07-10 15:51:29','2019-07-10 15:51:29','1fb93823877c01dfc8167d4e9d08c282.png',1);
/*!40000 ALTER TABLE `conference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference_lecturer`
--

DROP TABLE IF EXISTS `conference_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `conference_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D18E9767BA2D8762` (`lecturer_id`),
  KEY `IDX_D18E9767604B8382` (`conference_id`),
  CONSTRAINT `FK_D18E9767604B8382` FOREIGN KEY (`conference_id`) REFERENCES `conference` (`id`),
  CONSTRAINT `FK_D18E9767BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conference_lecturer`
--

LOCK TABLES `conference_lecturer` WRITE;
/*!40000 ALTER TABLE `conference_lecturer` DISABLE KEYS */;
INSERT INTO `conference_lecturer` VALUES (1,5,1),(2,5,2),(3,7,2),(4,7,1),(5,5,3),(6,6,3),(9,6,4),(10,6,5);
/*!40000 ALTER TABLE `conference_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conference_organizer`
--

DROP TABLE IF EXISTS `conference_organizer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conference_organizer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `level` smallint(6) NOT NULL,
  `place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `held_on` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D57820EBF8BD700D` (`unit_id`),
  KEY `IDX_D57820EB40C1FEA7` (`year_id`),
  CONSTRAINT `FK_D57820EB40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`),
  CONSTRAINT `FK_D57820EBF8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employment_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `partner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contract_value` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_165EC366F8BD700D` (`unit_id`),
  KEY `IDX_165EC36640C1FEA7` (`year_id`),
  CONSTRAINT `FK_165EC36640C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`),
  CONSTRAINT `FK_165EC366F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employment_contract`
--

LOCK TABLES `employment_contract` WRITE;
/*!40000 ALTER TABLE `employment_contract` DISABLE KEYS */;
INSERT INTO `employment_contract` VALUES (1,5,1,'Prog','Dinas Pendidikan Kota Samarinda','1234',1220,'2019-07-05 15:39:21','2019-07-05 15:39:21'),(2,6,2,'Pembuatan Aplikasi','Provinsi Kalimantan Timur','1234',1000000000,'2019-07-10 11:33:13','2019-07-10 12:23:06');
/*!40000 ALTER TABLE `employment_contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `information`
--

DROP TABLE IF EXISTS `information`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `information` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intellectual_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intellectual_property` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `classification` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1AEBA93940C1FEA7` (`year_id`),
  KEY `IDX_1AEBA93912469DE2` (`category_id`),
  KEY `IDX_1AEBA939F675F31B` (`author_id`),
  CONSTRAINT `FK_1AEBA93912469DE2` FOREIGN KEY (`category_id`) REFERENCES `intellectual_category` (`id`),
  CONSTRAINT `FK_1AEBA93940C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`),
  CONSTRAINT `FK_1AEBA939F675F31B` FOREIGN KEY (`author_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intellectual_property`
--

LOCK TABLES `intellectual_property` WRITE;
/*!40000 ALTER TABLE `intellectual_property` DISABLE KEYS */;
INSERT INTO `intellectual_property` VALUES (8,1,1,'Paten BIO','Rofilde Hasudungan',1,'45a02243b240b30af5302510d197f891.pdf',5,2),(9,1,1,'Paten Pengkodean DNA Design Schema secara generik','78903475',5,'f91c57e1f86177f3bf5214f48dea9f90.png',5,1),(10,1,2,'Paten IOIo','9euruere',5,'2f0044f2d0c1f06363d374ffb6459431.pdf',5,1),(12,1,2,'tSTING','SDFNKSAD',5,'26ce9b15b992b11c48a1eccea2c759c4.docx',5,1),(13,1,2,'323','2323',5,'44d9754382009595917ffe4792567518.docx',6,1),(14,1,1,'sdfdsf','dfdf',5,'3d019c34a187b08c35833aad2cd72eb6.pdf',6,1),(15,1,1,'tESING','LIJSAFLDS',5,'2994d722c9db9546c1cc924cc62855d6.png',7,1),(16,1,1,'Extract X','sdfsdf',5,'74b8cfecc8a980886ec65401b02add87.pdf',6,1),(17,1,1,'ASDFDSAF','1234',5,'0e21ee26f5b41bbe97067bafcf63237d.docx',6,1);
/*!40000 ALTER TABLE `intellectual_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `intellectual_property_lecturer`
--

DROP TABLE IF EXISTS `intellectual_property_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intellectual_property_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `order_number` int(11) NOT NULL,
  `intellectual_property_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AE754D18BA2D8762` (`lecturer_id`),
  KEY `IDX_AE754D185E62765` (`intellectual_property_id`),
  CONSTRAINT `FK_AE754D185E62765` FOREIGN KEY (`intellectual_property_id`) REFERENCES `intellectual_property` (`id`),
  CONSTRAINT `FK_AE754D18BA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `intellectual_property_lecturer`
--

LOCK TABLES `intellectual_property_lecturer` WRITE;
/*!40000 ALTER TABLE `intellectual_property_lecturer` DISABLE KEYS */;
INSERT INTO `intellectual_property_lecturer` VALUES (1,5,2,NULL),(2,5,1,NULL),(3,5,1,8),(9,10,1,10),(10,8,2,NULL),(12,5,1,12),(13,5,2,NULL),(14,5,3,NULL),(15,6,1,13),(16,6,1,14),(18,5,1,9),(19,6,1,15),(20,6,1,16),(21,6,1,17),(22,8,2,9),(23,8,2,10),(24,10,2,12);
/*!40000 ALTER TABLE `intellectual_property_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal`
--

DROP TABLE IF EXISTS `journal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uploader_id` int(11) DEFAULT NULL,
  `year_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_of_journal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `volume` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `classification` int(11) NOT NULL,
  `abstract` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `pages` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C1A7E74D16678C77` (`uploader_id`),
  KEY `IDX_C1A7E74D40C1FEA7` (`year_id`),
  CONSTRAINT `FK_C1A7E74D16678C77` FOREIGN KEY (`uploader_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_C1A7E74D40C1FEA7` FOREIGN KEY (`year_id`) REFERENCES `year` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal`
--

LOCK TABLES `journal` WRITE;
/*!40000 ALTER TABLE `journal` DISABLE KEYS */;
INSERT INTO `journal` VALUES (1,6,5,'Generic DNA Encoding Design Schema to Solve Combinatorial Problems','Journal of Sciece',1,1,'http://wdssd','348734761034908337edc373a935f014.jpg',1,'Genetic Algorithm (GA) is a search-based optimization technique based on the principles of Genetics and Natural Selection. It is frequently used to find optimal or near-optimal solutions to difficult problems which otherwise would take a lifetime to solve. It is frequently used to solve optimization problems, in research, and in machine learning.',1,'1-10','12343434X','2019-06-26 18:23:06','2019-07-14 15:32:17'),(2,5,1,'Identifikasi Faktor dalam Prestasi Mahasiswa dengan Menggunakan Algoritma Pohon Keputusan','Jurnal Teknologi dan Informasi',1,1,'http://juri','3d934013f93e43e0d3c7a262da45cbe1.docx',2,'blalbalb',2,'1-10','dsdsds','2019-07-05 10:35:21','2019-07-09 14:10:29'),(3,5,1,'Yes','Journal Social Science',1,1,'http://google.com','ed14f4b59e6d8e3e9c5873f7b5a28273.docx',1,'12',1,'1-10','123','2019-07-05 16:41:15','2019-07-05 16:41:15'),(4,5,1,'Budaya dan Politik','Journal Ilmu Politik dan Sosial',1,1,'http://google.com','ae4076f9587351946a19a6f609d09880.pdf',1,'vvdfd',2,'1-10','14','2019-07-05 16:44:27','2019-07-05 16:44:27'),(5,5,1,'EFIKASI VAKSIN Pseumulvacc® PADA BUDIDAYA IKAN NILA (Oreochromis niloticus) DI KABUPATEN KUTAI KARTANEGARA','Journal Ilmu Perikanan Tropis',22,1,NULL,'d37371c4bd6e95998dfd7d0b57603b0b.pdf',1,'The aim of this study was to evaluate the eficacy of Pseumulvacc® vaccine and effect of vaccine to tilapia growth and survival rate (SR) on tilapia aquaculture in Kutai Kartanegara, East Kalimantan. This vaccine has made from Pseudomonas sp. (EP-01) inactivated used formalin 3%. Bacteria of Pseudomonas sp. isolated from sick and die tilapia in Loa Kulu, Kutai Kartanegara. The fish used in this study was tilapia (Oreochromis niloticus) weight ±11 g and length ±7,5 cm, the research done in 3 method, immersion, feed and control. The density of bacteria vaccine in 3 method ware 108 CFU/mL\r\nfor immersion, 104 CFU/mL for feed and no added vaccine in control method. Immersion method procedure begins dips tilapia with vaccine for 30 minutes (5-10 of fish/L). While vaccine by feed method begins by mixing the vaccine with feed (1 mL / g feed). Mixing feed gave to tilapia for 14 days with 2 times daily, then the fish reared for 30 days. The observed parameters ware survival rate (SR), relative percent survival (RPS), and growth (weight and length of fish). The result of this study shown that Pseumulvacc® survival rate (SR) in immersion method was 52,8% and by feed method was 29,5%. Relative percent survival (RPS) of each research ware 40,9% by immersion and 11,7% by feed. The best growth in this research is feed method rate by 28,33 g/month than immersion method 16,33 g/month.',2,'30-35','1412-2006','2019-07-05 17:04:13','2019-07-13 08:33:44'),(6,6,3,'DSDS','SADFASDF',1,1,'SDAFASD','b71110e2f8e1ddfa79847ff54e3446bb.docx',1,'FSDAFAS',1,'ASDFASDF','SDFSADF','2019-07-06 01:00:21','2019-07-11 15:37:32'),(7,5,1,'tesing','1',1,1,'1','d7ea097fa3679056db4e9523f87d1592.docx',2,'sdfsfs',1,'12','1','2019-07-08 16:32:26','2019-07-08 16:32:26'),(8,6,1,'tesing','Jourmal Inter',1,1,'1','8de3c795b3ac44cb3f0812c1e8adfa50.xcf',1,'sdf',1,'11','1','2019-07-10 15:48:30','2019-07-11 15:37:32'),(9,6,1,'SDFDSF','SDFSD',1,1,'SDF','322688dfffed0b029fdded3376eac8d4.pdf',1,'SAFDFSD',1,'11','SDFDS','2019-07-10 15:49:28','2019-07-11 15:37:32');
/*!40000 ALTER TABLE `journal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_lecturer`
--

DROP TABLE IF EXISTS `journal_lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lecturer_id` int(11) DEFAULT NULL,
  `journal_id` int(11) DEFAULT NULL,
  `order_number` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C47FFCFFBA2D8762` (`lecturer_id`),
  KEY `IDX_C47FFCFF478E8802` (`journal_id`),
  CONSTRAINT `FK_C47FFCFF478E8802` FOREIGN KEY (`journal_id`) REFERENCES `journal` (`id`),
  CONSTRAINT `FK_C47FFCFFBA2D8762` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_lecturer`
--

LOCK TABLES `journal_lecturer` WRITE;
/*!40000 ALTER TABLE `journal_lecturer` DISABLE KEYS */;
INSERT INTO `journal_lecturer` VALUES (1,5,1,1),(2,17,2,1),(3,6,2,2),(4,7,1,2),(5,8,3,1),(6,6,3,2),(7,10,4,1),(8,8,4,2),(9,6,5,1),(10,5,6,1),(11,5,NULL,1),(12,6,6,2),(13,6,8,1),(14,6,9,1),(15,10,1,3),(16,10,5,2),(17,8,1,NULL);
/*!40000 ALTER TABLE `journal_lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lecturer`
--

DROP TABLE IF EXISTS `lecturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lecturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `affiliation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `functional` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_14CF5146F8BD700D` (`unit_id`),
  KEY `IDX_14CF514661220EA6` (`creator_id`),
  CONSTRAINT `FK_14CF514661220EA6` FOREIGN KEY (`creator_id`) REFERENCES `lecturer` (`id`),
  CONSTRAINT `FK_14CF5146F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lecturer`
--

LOCK TABLES `lecturer` WRITE;
/*!40000 ALTER TABLE `lecturer` DISABLE KEYS */;
INSERT INTO `lecturer` VALUES (5,NULL,'198604072014343','1107048601','Rofilde Hasudungan',2,'2019-06-23 14:13:21','2019-07-15 09:32:33','Universitas Muhammadiyah Kalimantan Timur','65e49acc894a3a3db1058ca457f8981c.png',3,NULL,0),(6,6,'198001042006042003','123','Dr. Esti Handayani Hardi',3,'2019-06-24 23:12:14','2019-07-14 14:59:47','Universitas Mulawarman','7a32f68e52410fbb717e6c1839bdd97b.jpg',1,NULL,4),(7,NULL,NULL,NULL,'Rohani Abu Bakar',3,'2019-07-01 05:57:47','2019-07-15 04:55:16','Univerisiti Malaysia Pahang',NULL,2,NULL,0),(8,3,'197503312005011002',NULL,'Sonny Sudiar, S.IP., M.A',2,'2019-07-03 17:48:43','2019-07-15 05:48:09','Universitas Mulawarman','78072689a628bc452f15fbc8f5819b3b.jpg',1,NULL,4),(9,NULL,NULL,NULL,'Dr. Mazlina Abdul Majid',3,'2019-07-04 14:41:14','2019-07-11 11:31:23','Universiti Malaysia Pahang',NULL,2,NULL,0),(10,3,'197701082006041001',NULL,'Jauchar B., S.IP., M,Si',2,'2019-07-05 16:43:11','2019-07-14 15:32:17','Universitas Mulawarman',NULL,1,NULL,3),(11,NULL,NULL,NULL,'Rozlina Abdul Mazid',NULL,'2019-07-11 11:29:47','2019-07-11 11:29:47','Universiti Malaysia Pahang',NULL,2,NULL,0),(13,NULL,NULL,NULL,'Dina',NULL,'2019-07-11 12:15:37','2019-07-11 12:24:12','Kwundong University',NULL,2,6,0),(14,NULL,NULL,NULL,'Liza Mayer',NULL,'2019-07-11 12:15:54','2019-07-11 12:24:12','Kansas University',NULL,2,6,0),(15,NULL,NULL,NULL,'Rex',NULL,'2019-07-11 12:24:12','2019-07-11 12:24:12','Universitas Padjajaran',NULL,2,6,0),(16,14,NULL,NULL,'Dr. Fahrul Agus',3,'2019-07-15 04:56:26','2019-07-15 04:56:26','Universitas Mulawarman',NULL,1,NULL,4),(17,1,NULL,NULL,'Donny Donanto, M.P',2,'2019-07-15 04:56:57','2019-07-15 09:32:33','Universitas Mulawarman',NULL,1,NULL,2),(18,13,'195407171988031001',NULL,'Dr. H. Mursalim, M.Hum',3,'2019-07-15 05:01:07','2019-07-15 05:01:07','Universitas Mulawarman',NULL,1,NULL,0),(19,2,'196206301993032002',NULL,'Isna Yuningsih, SE., MM.,Ak., CA',1,'2019-07-15 05:01:45','2019-07-15 05:01:45','Universitas Mulawarman',NULL,1,NULL,0),(20,11,'198303222006041001',NULL,'Insan Tajali Nur, SH, MH',1,'2019-07-15 05:02:49','2019-07-15 05:02:49','Universitas Mulawarman',NULL,1,NULL,0),(21,10,'196007271992032002',NULL,'Dra. Siti Badrah, M.Kes',2,'2019-07-15 05:03:18','2019-07-15 05:03:33','Universitas Mulawarman',NULL,1,NULL,0),(22,7,'197512172005011005',NULL,'Dr. Shalaho Dina Devy, ST., M.Eng',3,'2019-07-15 05:04:27','2019-07-15 05:04:27','Universitas Mulawarman',NULL,1,NULL,0),(23,8,'197712132000122001',NULL,'Dr. Noor Hindryawati, M.Si',1,'2019-07-15 05:04:54','2019-07-15 05:04:54','Universitas Mulawarman',NULL,1,NULL,0),(24,4,'197404121998021001',NULL,'Erwin, Phd',1,'2019-07-15 05:05:40','2019-07-15 05:05:40','Universitas Mulawarman',NULL,1,NULL,0),(25,9,'197606052005012003',NULL,'Dr. dr. Swandari Paramita, M.Kes',1,'2019-07-15 05:06:39','2019-07-15 05:06:39','Universitas Mulawarman',NULL,1,NULL,0),(26,12,NULL,NULL,'Dr. La Ode Rijai',3,'2019-07-15 05:07:18','2019-07-15 05:07:18','Universitas Mulawarman',NULL,1,NULL,0),(27,5,NULL,NULL,'Prof. Dr. Lambang Subagiyo M.Si',3,'2019-07-15 05:16:54','2019-07-15 05:16:54','Universitas Mulawarman',NULL,1,NULL,5);
/*!40000 ALTER TABLE `lecturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
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
INSERT INTO `migration_versions` VALUES ('20190201104853','2019-02-01 10:49:17'),('20190202082506','2019-02-02 08:25:31'),('20190202084914','2019-02-02 08:49:39'),('20190606141219','2019-06-06 14:12:33'),('20190606143310','2019-06-06 14:33:22'),('20190611123238','2019-06-11 12:33:03'),('20190611123611','2019-06-11 12:37:04'),('20190612022655','2019-06-12 02:28:15'),('20190617101031','2019-06-17 10:10:54'),('20190617112538','2019-06-17 11:25:47'),('20190617114811','2019-06-17 11:48:19'),('20190617220130','2019-06-17 22:01:37'),('20190620195640','2019-06-20 19:56:58'),('20190620204826','2019-06-20 20:48:45'),('20190620210323','2019-06-20 21:03:34'),('20190620211232','2019-06-20 21:12:49'),('20190621002250','2019-06-21 00:23:29'),('20190623060804','2019-06-23 06:08:26'),('20190623061006','2019-06-23 06:10:11'),('20190623061130','2019-06-23 06:11:42'),('20190625015124','2019-06-25 01:51:35'),('20190625015622','2019-06-25 01:56:34'),('20190625230134','2019-06-25 23:01:45'),('20190625230425','2019-06-25 23:04:36'),('20190626071652','2019-06-26 07:17:08'),('20190626074637','2019-06-26 07:46:57'),('20190626074817','2019-06-26 07:48:27'),('20190626230925','2019-06-26 23:09:41'),('20190628001028','2019-06-28 00:10:42'),('20190628085029','2019-06-28 08:51:40'),('20190630214852','2019-06-30 21:49:11'),('20190630215115','2019-06-30 21:54:27'),('20190701071725','2019-07-01 07:18:01'),('20190701082137','2019-07-01 08:21:43'),('20190703015628','2019-07-03 01:56:36'),('20190705070145','2019-07-05 07:01:50'),('20190705072257','2019-07-05 07:23:03'),('20190708082557','2019-07-08 08:26:05'),('20190710022223','2019-07-10 02:22:28'),('20190710025607','2019-07-10 02:56:13'),('20190710025824','2019-07-10 02:58:28'),('20190711031519','2019-07-11 03:15:28'),('20190711032905','2019-07-11 03:29:11'),('20190711040820','2019-07-11 04:08:25'),('20190713004738','2019-07-13 00:47:44');
/*!40000 ALTER TABLE `migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci,
  `is_published` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `post_type` int(11) NOT NULL,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_92ED7784F8BD700D` (`unit_id`),
  CONSTRAINT `FK_92ED7784F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `program`
--

LOCK TABLES `program` WRITE;
/*!40000 ALTER TABLE `program` DISABLE KEYS */;
/*!40000 ALTER TABLE `program` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abbreviation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'Fakultas Pertanian','FTNI'),(2,'Fakultas Ekonomi dan Bisnis','FEB'),(3,'Fakultas Ilmu Sosial dan Ilmu Politik','FISIP'),(4,'Fakultas Kehutanan','FHUT'),(5,'Fakultas Keguruan dan Ilmu Pendidikan','FKIP'),(6,'Fakultas Perikanan dan Ilmu Kelautan','FPIK'),(7,'Fakultas Teknik','FTEK'),(8,'Fakultas Matematika dan Ilmu Pengetahuan Alam','FMIPA'),(9,'Fakultas Kedokteran','FDOK'),(10,'Fakultas Kesehatan Masyarakat','FKES'),(11,'Fakultas Hukum','FHUM'),(12,'Fakultas Farmasi','FFAR'),(13,'Fakultas Ilmu Budaya','FIB'),(14,'Ilmu Komputer dan Teknologi Informasi','FKTI');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_8D93D649F8BD700D` (`unit_id`),
  CONSTRAINT `FK_8D93D649F8BD700D` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'198604072014343','admin',NULL),(2,'198001042006042003','1',NULL),(3,'1234','1234',NULL),(4,'445','445',6),(5,'197503312005011002','197503312005011002',3);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `user_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`roles_id`),
  KEY `IDX_54FCD59FA76ED395` (`user_id`),
  KEY `IDX_54FCD59F38C751C4` (`roles_id`),
  CONSTRAINT `FK_54FCD59F38C751C4` FOREIGN KEY (`roles_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_54FCD59FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES (1,1),(1,2),(1,3),(1,5),(2,2),(2,3),(3,8),(4,6),(4,8),(5,2),(5,3);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `year`
--

DROP TABLE IF EXISTS `year`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `year` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
INSERT INTO `year` VALUES (1,'2018','Tahun 2018','2019-07-15 04:55:16','2019-06-21 04:51:41'),(2,'2019','tahun 2019','2019-07-10 16:27:29','2019-06-21 04:52:01'),(3,'2005',NULL,'2019-07-10 15:46:50','2019-07-06 00:19:57'),(4,'2006',NULL,'2019-07-10 15:46:16','2019-07-06 00:20:01'),(5,'2007',NULL,'2019-07-14 15:32:17','2019-07-06 00:20:13'),(6,'2008',NULL,'2019-07-06 00:20:19','2019-07-06 00:20:19'),(7,'2009',NULL,'2019-07-06 00:20:23','2019-07-06 00:20:23'),(8,'2010',NULL,'2019-07-06 00:20:33','2019-07-06 00:20:33'),(9,'2011',NULL,'2019-07-06 00:20:38','2019-07-06 00:20:38'),(10,'2012',NULL,'2019-07-06 00:20:42','2019-07-06 00:20:42'),(11,'2013',NULL,'2019-07-06 00:20:46','2019-07-06 00:20:46'),(12,'2014',NULL,'2019-07-06 00:20:50','2019-07-06 00:20:50'),(13,'2015',NULL,'2019-07-06 00:20:54','2019-07-06 00:20:54'),(14,'2016',NULL,'2019-07-06 00:20:59','2019-07-06 00:20:59'),(15,'2017',NULL,'2019-07-06 00:21:03','2019-07-06 00:21:03');
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

-- Dump completed on 2019-09-11 15:02:11
