-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: wasteback
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `bulk_dispatches`
--

DROP TABLE IF EXISTS `bulk_dispatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bulk_dispatches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `material_id` bigint(20) unsigned NOT NULL,
  `recycling_partner_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned NOT NULL,
  `quantity_kg` decimal(10,2) NOT NULL,
  `price_per_kg` decimal(12,2) NOT NULL DEFAULT 0.00,
  `amount` decimal(14,2) NOT NULL DEFAULT 0.00,
  `truck_plate` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bulk_dispatches_reference_unique` (`reference`),
  KEY `bulk_dispatches_material_id_foreign` (`material_id`),
  KEY `bulk_dispatches_recycling_partner_id_foreign` (`recycling_partner_id`),
  KEY `bulk_dispatches_created_by_foreign` (`created_by`),
  CONSTRAINT `bulk_dispatches_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  CONSTRAINT `bulk_dispatches_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `bulk_dispatches_recycling_partner_id_foreign` FOREIGN KEY (`recycling_partner_id`) REFERENCES `recycling_partners` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bulk_dispatches`
--

LOCK TABLES `bulk_dispatches` WRITE;
/*!40000 ALTER TABLE `bulk_dispatches` DISABLE KEYS */;
INSERT INTO `bulk_dispatches` VALUES (1,'BD-261019-GXGDX',1,4,1,46.00,1000.00,46000.00,'UBK 424J',NULL,'2026-10-19 08:00:00','2026-10-19 08:00:00'),(2,'BD-261019-YV5NI',1,1,1,25.00,1000.00,25000.00,'UBK 421J',NULL,'2026-10-19 08:00:00','2026-10-19 08:00:00'),(3,'BD-261019-O8PFD',5,2,1,71.00,1450.00,102950.00,'UBK 422J',NULL,'2026-10-19 08:00:00','2026-10-19 08:00:00');
/*!40000 ALTER TABLE `bulk_dispatches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('wasteback-cache-5c785c036466adea360111aa28563bfd556b5fba','i:1;',1793252584),('wasteback-cache-5c785c036466adea360111aa28563bfd556b5fba:timer','i:1793252584;',1793252584);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_messages`
--

DROP TABLE IF EXISTS `contact_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contact_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_messages`
--

LOCK TABLES `contact_messages` WRITE;
/*!40000 ALTER TABLE `contact_messages` DISABLE KEYS */;
INSERT INTO `contact_messages` VALUES (1,'Kyomuhendo Ruth','ruth@example.com','0783000111','Collection in Kiwatule','Do you collect in Kiwatule? Our estate has a lot of plastic bottles every week.',0,'2026-10-29 05:40:23','2026-10-29 05:40:23');
/*!40000 ALTER TABLE `contact_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` enum('plastic','metal','paper','glass','ewaste') NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `bulk_threshold_kg` decimal(10,2) NOT NULL DEFAULT 500.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `materials_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (1,'PET Plastic Bottles','pet-plastic-bottles','plastic','Clear and coloured soda and water bottles. Rinse and remove the caps.','bottles_pile',600.00,1000.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(2,'Hard Plastic Containers','hard-plastic-containers','plastic','Jerrycans, basins, cooking oil and detergent containers (HDPE).','containers',800.00,800.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(3,'Soft Plastics and Sacks','soft-plastics-and-sacks','plastic','Clean polythene, sacks and plastic wrapping, kept dry.','plastic_bales',300.00,600.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(4,'Aluminium Cans','aluminium-cans','metal','Drink cans and clean aluminium pieces. Crush them to save space.','metal_parts',3500.00,300.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(5,'Iron and Steel Scrap','iron-and-steel-scrap','metal','Old iron sheets, rods, bicycle parts and broken tools.','scrap_metal',900.00,2000.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(6,'Copper Wire','copper-wire','metal','Stripped or unstripped copper cable and wire offcuts.','excavator',15000.00,10.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(7,'Cardboard','cardboard','paper','Flattened boxes and cartons. Must be dry.','cardboard',250.00,1500.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(8,'Office and Exercise Paper','office-and-exercise-paper','paper','White paper, old exercise books and newspapers.','paper_bales',400.00,800.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(9,'Glass Bottles','glass-bottles','glass','Beer, soda and spirit bottles, whole or broken, kept separate.','glass',150.00,2000.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13'),(10,'Electronic Scrap','electronic-scrap','ewaste','Old phones, chargers, radios and circuit boards.','ewaste',5000.00,200.00,1,'2026-10-29 05:40:13','2026-10-29 05:40:13');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_18_000100_create_materials_table',1),(5,'2026_10_18_000200_create_pickups_table',1),(6,'2026_10_18_000300_create_wallet_transactions_table',1),(7,'2026_10_18_000400_create_bulk_dispatches_table',1),(8,'2026_10_29_000000_add_sale_amount_to_bulk_dispatches',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pickup_items`
--

DROP TABLE IF EXISTS `pickup_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pickup_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pickup_id` bigint(20) unsigned NOT NULL,
  `material_id` bigint(20) unsigned NOT NULL,
  `estimated_kg` decimal(10,2) NOT NULL,
  `verified_kg` decimal(10,2) DEFAULT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pickup_items_pickup_id_foreign` (`pickup_id`),
  KEY `pickup_items_material_id_foreign` (`material_id`),
  CONSTRAINT `pickup_items_material_id_foreign` FOREIGN KEY (`material_id`) REFERENCES `materials` (`id`),
  CONSTRAINT `pickup_items_pickup_id_foreign` FOREIGN KEY (`pickup_id`) REFERENCES `pickups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pickup_items`
--

LOCK TABLES `pickup_items` WRITE;
/*!40000 ALTER TABLE `pickup_items` DISABLE KEYS */;
INSERT INTO `pickup_items` VALUES (1,1,5,19.00,16.20,900.00,'2026-09-16 06:00:00','2026-09-17 07:15:00'),(2,2,8,45.00,40.10,400.00,'2026-09-17 06:00:00','2026-09-18 08:15:00'),(3,3,10,2.00,1.80,5000.00,'2026-09-18 06:00:00','2026-09-19 09:15:00'),(4,4,5,35.00,31.90,900.00,'2026-09-19 06:00:00','2026-09-20 10:15:00'),(5,5,4,29.00,29.60,3500.00,'2026-09-20 06:00:00','2026-09-21 11:15:00'),(6,6,7,36.00,NULL,250.00,'2026-09-21 06:00:00','2026-09-21 06:00:00'),(7,7,1,58.00,60.30,600.00,'2026-09-22 06:00:00','2026-09-23 07:15:00'),(8,7,4,26.00,26.30,3500.00,'2026-09-22 06:00:00','2026-09-23 07:15:00'),(9,7,9,40.00,35.60,150.00,'2026-09-22 06:00:00','2026-09-23 07:15:00'),(10,8,2,22.00,21.30,800.00,'2026-09-23 06:00:00','2026-09-24 08:15:00'),(11,8,7,18.00,18.40,250.00,'2026-09-23 06:00:00','2026-09-24 08:15:00'),(12,8,9,21.00,21.00,150.00,'2026-09-23 06:00:00','2026-09-24 08:15:00'),(13,9,1,23.00,23.00,600.00,'2026-09-24 06:00:00','2026-09-25 09:15:00'),(14,9,9,14.00,13.40,150.00,'2026-09-24 06:00:00','2026-09-25 09:15:00'),(15,9,10,5.00,4.90,5000.00,'2026-09-24 06:00:00','2026-09-25 09:15:00'),(16,10,2,55.00,48.40,800.00,'2026-09-25 06:00:00','2026-09-26 10:15:00'),(17,10,8,57.00,49.60,400.00,'2026-09-25 06:00:00','2026-09-26 10:15:00'),(18,11,2,43.00,40.00,800.00,'2026-09-26 06:00:00','2026-09-27 11:15:00'),(19,11,6,2.00,1.80,15000.00,'2026-09-26 06:00:00','2026-09-27 11:15:00'),(20,11,9,9.00,8.80,150.00,'2026-09-26 06:00:00','2026-09-27 11:15:00'),(21,12,5,32.00,33.30,900.00,'2026-09-27 06:00:00','2026-09-28 12:15:00'),(22,12,9,21.00,18.90,150.00,'2026-09-27 06:00:00','2026-09-28 12:15:00'),(23,13,2,31.00,31.00,800.00,'2026-09-28 06:00:00','2026-09-29 07:15:00'),(24,14,10,5.00,4.50,5000.00,'2026-09-29 06:00:00','2026-09-30 08:15:00'),(25,15,7,34.00,29.60,250.00,'2026-09-30 06:00:00','2026-10-01 09:15:00'),(26,15,9,31.00,31.00,150.00,'2026-09-30 06:00:00','2026-10-01 09:15:00'),(27,16,5,30.00,31.50,900.00,'2026-10-01 06:00:00','2026-10-02 10:15:00'),(28,16,6,3.00,3.20,15000.00,'2026-10-01 06:00:00','2026-10-02 10:15:00'),(29,17,4,25.00,NULL,3500.00,'2026-10-02 06:00:00','2026-10-02 06:00:00'),(30,17,6,1.00,NULL,15000.00,'2026-10-02 06:00:00','2026-10-02 06:00:00'),(31,18,2,31.00,27.00,800.00,'2026-10-03 06:00:00','2026-10-04 12:15:00'),(32,19,2,33.00,35.60,800.00,'2026-10-04 06:00:00','2026-10-05 07:15:00'),(33,19,8,10.00,9.30,400.00,'2026-10-04 06:00:00','2026-10-05 07:15:00'),(34,19,9,39.00,40.60,150.00,'2026-10-04 06:00:00','2026-10-05 07:15:00'),(35,20,10,2.00,2.10,5000.00,'2026-10-05 06:00:00','2026-10-06 08:15:00'),(36,21,1,17.00,16.00,600.00,'2026-10-06 06:00:00','2026-10-07 09:15:00'),(37,21,6,3.00,2.90,15000.00,'2026-10-06 06:00:00','2026-10-07 09:15:00'),(38,22,4,9.00,9.40,3500.00,'2026-10-07 06:00:00','2026-10-08 10:15:00'),(39,23,3,53.00,54.60,300.00,'2026-10-08 06:00:00','2026-10-09 11:15:00'),(40,23,8,40.00,40.40,400.00,'2026-10-08 06:00:00','2026-10-09 11:15:00'),(41,23,9,49.00,44.60,150.00,'2026-10-08 06:00:00','2026-10-09 11:15:00'),(42,24,3,27.00,24.60,300.00,'2026-10-09 06:00:00','2026-10-10 12:15:00'),(43,24,5,29.00,30.20,900.00,'2026-10-09 06:00:00','2026-10-10 12:15:00'),(44,24,8,15.00,15.30,400.00,'2026-10-09 06:00:00','2026-10-10 12:15:00'),(45,25,9,12.00,11.40,150.00,'2026-10-10 06:00:00','2026-10-11 07:15:00'),(46,26,8,60.00,52.20,400.00,'2026-10-11 06:00:00','2026-10-12 08:15:00'),(47,27,7,12.00,12.80,250.00,'2026-10-12 06:00:00','2026-10-13 09:15:00'),(48,28,2,55.00,NULL,800.00,'2026-10-13 06:00:00','2026-10-13 06:00:00'),(49,28,8,29.00,NULL,400.00,'2026-10-13 06:00:00','2026-10-13 06:00:00'),(50,29,2,21.00,18.50,800.00,'2026-10-14 06:00:00','2026-10-15 11:15:00'),(51,29,3,49.00,52.90,300.00,'2026-10-14 06:00:00','2026-10-15 11:15:00'),(52,29,7,41.00,36.90,250.00,'2026-10-14 06:00:00','2026-10-15 11:15:00'),(53,30,3,36.00,37.10,300.00,'2026-10-15 06:00:00','2026-10-16 12:15:00'),(54,31,6,3.00,3.00,15000.00,'2026-10-16 06:00:00','2026-10-17 07:15:00'),(55,32,3,28.00,28.30,300.00,'2026-10-17 06:00:00','2026-10-18 08:15:00'),(56,33,8,33.00,35.60,400.00,'2026-10-18 06:00:00','2026-10-19 09:15:00'),(57,34,2,10.00,10.40,800.00,'2026-10-19 06:00:00','2026-10-20 10:15:00'),(58,34,5,32.00,28.80,900.00,'2026-10-19 06:00:00','2026-10-20 10:15:00'),(59,34,8,20.00,19.60,400.00,'2026-10-19 06:00:00','2026-10-20 10:15:00'),(60,35,4,17.00,16.20,3500.00,'2026-10-20 06:00:00','2026-10-21 11:15:00'),(61,36,6,2.00,2.00,15000.00,'2026-10-21 06:00:00','2026-10-22 12:15:00'),(62,36,9,51.00,51.50,150.00,'2026-10-21 06:00:00','2026-10-22 12:15:00'),(63,37,1,36.00,32.80,600.00,'2026-10-22 06:00:00','2026-10-23 07:15:00'),(64,37,3,14.00,12.00,300.00,'2026-10-22 06:00:00','2026-10-23 07:15:00'),(65,37,5,7.00,7.60,900.00,'2026-10-22 06:00:00','2026-10-23 07:15:00'),(66,38,7,26.00,25.00,250.00,'2026-10-23 06:00:00','2026-10-24 08:15:00'),(67,39,7,17.00,NULL,250.00,'2026-10-24 06:00:00','2026-10-24 06:00:00'),(68,40,7,43.00,40.00,250.00,'2026-10-25 06:00:00','2026-10-26 10:15:00'),(69,40,9,60.00,63.60,150.00,'2026-10-25 06:00:00','2026-10-26 10:15:00'),(70,41,9,22.00,19.80,150.00,'2026-10-26 06:00:00','2026-10-27 11:15:00'),(71,42,1,12.00,NULL,600.00,'2026-10-27 06:00:00','2026-10-27 06:00:00'),(72,42,8,15.00,NULL,400.00,'2026-10-27 06:00:00','2026-10-27 06:00:00'),(73,42,10,2.00,NULL,5000.00,'2026-10-27 06:00:00','2026-10-27 06:00:00'),(74,43,1,22.00,NULL,600.00,'2026-10-28 06:00:00','2026-10-28 06:00:00'),(75,44,5,25.00,NULL,900.00,'2026-10-29 06:00:00','2026-10-29 06:00:00'),(76,44,6,3.00,NULL,15000.00,'2026-10-29 06:00:00','2026-10-29 06:00:00'),(77,45,8,38.00,NULL,400.00,'2026-10-30 06:00:00','2026-10-30 06:00:00'),(78,46,1,18.00,NULL,600.00,'2026-10-31 06:00:00','2026-10-31 06:00:00'),(79,46,2,60.00,NULL,800.00,'2026-10-31 06:00:00','2026-10-31 06:00:00'),(80,46,7,44.00,NULL,250.00,'2026-10-31 06:00:00','2026-10-31 06:00:00');
/*!40000 ALTER TABLE `pickup_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pickups`
--

DROP TABLE IF EXISTS `pickups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pickups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `agent_id` bigint(20) unsigned DEFAULT NULL,
  `zone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `pickup_date` date NOT NULL,
  `time_slot` enum('morning','afternoon','evening') NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','assigned','collected','cancelled') NOT NULL DEFAULT 'pending',
  `estimated_total` decimal(12,2) NOT NULL DEFAULT 0.00,
  `verified_total` decimal(12,2) DEFAULT NULL,
  `assigned_at` timestamp NULL DEFAULT NULL,
  `collected_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pickups_reference_unique` (`reference`),
  KEY `pickups_user_id_foreign` (`user_id`),
  KEY `pickups_agent_id_foreign` (`agent_id`),
  CONSTRAINT `pickups_agent_id_foreign` FOREIGN KEY (`agent_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pickups_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pickups`
--

LOCK TABLES `pickups` WRITE;
/*!40000 ALTER TABLE `pickups` DISABLE KEYS */;
INSERT INTO `pickups` VALUES (1,'PU-260916-BOIXQ',5,2,'Banda','Banda Zone B, near the mosque','2026-09-17','morning',NULL,'collected',17100.00,14580.00,'2026-09-16 06:00:00','2026-09-17 07:15:00','2026-09-16 06:00:00','2026-09-17 07:15:00'),(2,'PU-260917-Y4HX6',6,2,'Banda','Banda Kansanga road, plot 14','2026-09-18','afternoon',NULL,'collected',18000.00,16040.00,'2026-09-17 06:00:00','2026-09-18 08:15:00','2026-09-17 06:00:00','2026-09-18 08:15:00'),(3,'PU-260918-KLRSG',7,3,'Kireka','Kireka Kamuli road','2026-09-19','evening',NULL,'collected',10000.00,9000.00,'2026-09-18 06:00:00','2026-09-19 09:15:00','2026-09-18 06:00:00','2026-09-19 09:15:00'),(4,'PU-260919-PVYVR',8,2,'Kyambogo','Kyambogo staff quarters, block C','2026-09-20','morning',NULL,'collected',31500.00,28710.00,'2026-09-19 06:00:00','2026-09-20 10:15:00','2026-09-19 06:00:00','2026-09-20 10:15:00'),(5,'PU-260920-KFAR4',9,4,'Nakawa','Nakawa housing estate','2026-09-21','afternoon',NULL,'collected',101500.00,103600.00,'2026-09-20 06:00:00','2026-09-21 11:15:00','2026-09-20 06:00:00','2026-09-21 11:15:00'),(6,'PU-260921-ZHMDT',10,NULL,'Kasokoso','Kasokoso trading centre','2026-09-22','evening',NULL,'cancelled',9000.00,NULL,NULL,NULL,'2026-09-21 06:00:00','2026-09-21 06:00:00'),(7,'PU-260922-DCF8G',11,2,'Ntinda','Ntinda Kigoowa','2026-09-23','morning',NULL,'collected',131800.00,133570.00,'2026-09-22 06:00:00','2026-09-23 07:15:00','2026-09-22 06:00:00','2026-09-23 07:15:00'),(8,'PU-260923-1DNZ6',12,3,'Bweyogerere','Bweyogerere Buto','2026-09-24','afternoon',NULL,'collected',25250.00,24790.00,'2026-09-23 06:00:00','2026-09-24 08:15:00','2026-09-23 06:00:00','2026-09-24 08:15:00'),(9,'PU-260924-N3EGO',5,2,'Banda','Banda Zone B, near the mosque','2026-09-25','evening',NULL,'collected',40900.00,40310.00,'2026-09-24 06:00:00','2026-09-25 09:15:00','2026-09-24 06:00:00','2026-09-25 09:15:00'),(10,'PU-260925-SIFFK',6,2,'Banda','Banda Kansanga road, plot 14','2026-09-26','morning',NULL,'collected',66800.00,58560.00,'2026-09-25 06:00:00','2026-09-26 10:15:00','2026-09-25 06:00:00','2026-09-26 10:15:00'),(11,'PU-260926-4YSLI',7,3,'Kireka','Kireka Kamuli road','2026-09-27','afternoon',NULL,'collected',65750.00,60320.00,'2026-09-26 06:00:00','2026-09-27 11:15:00','2026-09-26 06:00:00','2026-09-27 11:15:00'),(12,'PU-260927-FEQGH',8,4,'Kyambogo','Kyambogo staff quarters, block C','2026-09-28','evening',NULL,'collected',31950.00,32805.00,'2026-09-27 06:00:00','2026-09-28 12:15:00','2026-09-27 06:00:00','2026-09-28 12:15:00'),(13,'PU-260928-JGLJL',9,4,'Nakawa','Nakawa housing estate','2026-09-29','morning',NULL,'collected',24800.00,24800.00,'2026-09-28 06:00:00','2026-09-29 07:15:00','2026-09-28 06:00:00','2026-09-29 07:15:00'),(14,'PU-260929-EB1PH',10,3,'Kasokoso','Kasokoso trading centre','2026-09-30','afternoon',NULL,'collected',25000.00,22500.00,'2026-09-29 06:00:00','2026-09-30 08:15:00','2026-09-29 06:00:00','2026-09-30 08:15:00'),(15,'PU-260930-DUJ4X',11,4,'Ntinda','Ntinda Kigoowa','2026-10-01','evening',NULL,'collected',13150.00,12050.00,'2026-09-30 06:00:00','2026-10-01 09:15:00','2026-09-30 06:00:00','2026-10-01 09:15:00'),(16,'PU-261001-JNDAI',12,2,'Bweyogerere','Bweyogerere Buto','2026-10-02','morning',NULL,'collected',72000.00,76350.00,'2026-10-01 06:00:00','2026-10-02 10:15:00','2026-10-01 06:00:00','2026-10-02 10:15:00'),(17,'PU-261002-57LDP',5,NULL,'Banda','Banda Zone B, near the mosque','2026-10-03','afternoon',NULL,'cancelled',102500.00,NULL,NULL,NULL,'2026-10-02 06:00:00','2026-10-02 06:00:00'),(18,'PU-261003-A5R50',6,2,'Banda','Banda Kansanga road, plot 14','2026-10-04','evening',NULL,'collected',24800.00,21600.00,'2026-10-03 06:00:00','2026-10-04 12:15:00','2026-10-03 06:00:00','2026-10-04 12:15:00'),(19,'PU-261004-UUHR3',7,3,'Kireka','Kireka Kamuli road','2026-10-05','morning',NULL,'collected',36250.00,38290.00,'2026-10-04 06:00:00','2026-10-05 07:15:00','2026-10-04 06:00:00','2026-10-05 07:15:00'),(20,'PU-261005-7XVHD',8,3,'Kyambogo','Kyambogo staff quarters, block C','2026-10-06','afternoon',NULL,'collected',10000.00,10500.00,'2026-10-05 06:00:00','2026-10-06 08:15:00','2026-10-05 06:00:00','2026-10-06 08:15:00'),(21,'PU-261006-EBE35',9,4,'Nakawa','Nakawa housing estate','2026-10-07','evening',NULL,'collected',55200.00,53100.00,'2026-10-06 06:00:00','2026-10-07 09:15:00','2026-10-06 06:00:00','2026-10-07 09:15:00'),(22,'PU-261007-SV0SV',10,2,'Kasokoso','Kasokoso trading centre','2026-10-08','morning',NULL,'collected',31500.00,32900.00,'2026-10-07 06:00:00','2026-10-08 10:15:00','2026-10-07 06:00:00','2026-10-08 10:15:00'),(23,'PU-261008-6Q6U0',11,3,'Ntinda','Ntinda Kigoowa','2026-10-09','afternoon',NULL,'collected',39250.00,39230.00,'2026-10-08 06:00:00','2026-10-09 11:15:00','2026-10-08 06:00:00','2026-10-09 11:15:00'),(24,'PU-261009-ANV7X',12,4,'Bweyogerere','Bweyogerere Buto','2026-10-10','evening',NULL,'collected',40200.00,40680.00,'2026-10-09 06:00:00','2026-10-10 12:15:00','2026-10-09 06:00:00','2026-10-10 12:15:00'),(25,'PU-261010-PRGWN',5,2,'Banda','Banda Zone B, near the mosque','2026-10-11','morning',NULL,'collected',1800.00,1710.00,'2026-10-10 06:00:00','2026-10-11 07:15:00','2026-10-10 06:00:00','2026-10-11 07:15:00'),(26,'PU-261011-NWR3G',6,2,'Banda','Banda Kansanga road, plot 14','2026-10-12','afternoon',NULL,'collected',24000.00,20880.00,'2026-10-11 06:00:00','2026-10-12 08:15:00','2026-10-11 06:00:00','2026-10-12 08:15:00'),(27,'PU-261012-S9JQC',7,3,'Kireka','Kireka Kamuli road','2026-10-13','evening',NULL,'collected',3000.00,3200.00,'2026-10-12 06:00:00','2026-10-13 09:15:00','2026-10-12 06:00:00','2026-10-13 09:15:00'),(28,'PU-261013-U14VQ',8,NULL,'Kyambogo','Kyambogo staff quarters, block C','2026-10-14','morning',NULL,'cancelled',55600.00,NULL,NULL,NULL,'2026-10-13 06:00:00','2026-10-13 06:00:00'),(29,'PU-261014-MGMPI',9,4,'Nakawa','Nakawa housing estate','2026-10-15','afternoon',NULL,'collected',41750.00,39895.00,'2026-10-14 06:00:00','2026-10-15 11:15:00','2026-10-14 06:00:00','2026-10-15 11:15:00'),(30,'PU-261015-XKZBR',10,4,'Kasokoso','Kasokoso trading centre','2026-10-16','evening',NULL,'collected',10800.00,11130.00,'2026-10-15 06:00:00','2026-10-16 12:15:00','2026-10-15 06:00:00','2026-10-16 12:15:00'),(31,'PU-261016-QJN1L',11,2,'Ntinda','Ntinda Kigoowa','2026-10-17','morning',NULL,'collected',45000.00,45000.00,'2026-10-16 06:00:00','2026-10-17 07:15:00','2026-10-16 06:00:00','2026-10-17 07:15:00'),(32,'PU-261017-LO8TP',12,3,'Bweyogerere','Bweyogerere Buto','2026-10-18','afternoon',NULL,'collected',8400.00,8490.00,'2026-10-17 06:00:00','2026-10-18 08:15:00','2026-10-17 06:00:00','2026-10-18 08:15:00'),(33,'PU-261018-Q2FOY',5,2,'Banda','Banda Zone B, near the mosque','2026-10-19','evening',NULL,'collected',13200.00,14240.00,'2026-10-18 06:00:00','2026-10-19 09:15:00','2026-10-18 06:00:00','2026-10-19 09:15:00'),(34,'PU-261019-82FZW',6,2,'Banda','Banda Kansanga road, plot 14','2026-10-20','morning',NULL,'collected',44800.00,42080.00,'2026-10-19 06:00:00','2026-10-20 10:15:00','2026-10-19 06:00:00','2026-10-20 10:15:00'),(35,'PU-261020-ZQ1PK',7,3,'Kireka','Kireka Kamuli road','2026-10-21','afternoon',NULL,'collected',59500.00,56700.00,'2026-10-20 06:00:00','2026-10-21 11:15:00','2026-10-20 06:00:00','2026-10-21 11:15:00'),(36,'PU-261021-XBCT7',8,4,'Kyambogo','Kyambogo staff quarters, block C','2026-10-22','evening',NULL,'collected',37650.00,37725.00,'2026-10-21 06:00:00','2026-10-22 12:15:00','2026-10-21 06:00:00','2026-10-22 12:15:00'),(37,'PU-261022-LH4SU',9,4,'Nakawa','Nakawa housing estate','2026-10-23','morning',NULL,'collected',32100.00,30120.00,'2026-10-22 06:00:00','2026-10-23 07:15:00','2026-10-22 06:00:00','2026-10-23 07:15:00'),(38,'PU-261023-51VR3',10,3,'Kasokoso','Kasokoso trading centre','2026-10-24','afternoon',NULL,'collected',6500.00,6250.00,'2026-10-23 06:00:00','2026-10-24 08:15:00','2026-10-23 06:00:00','2026-10-24 08:15:00'),(39,'PU-261024-FTR9N',11,NULL,'Ntinda','Ntinda Kigoowa','2026-10-25','evening',NULL,'cancelled',4250.00,NULL,NULL,NULL,'2026-10-24 06:00:00','2026-10-24 06:00:00'),(40,'PU-261025-EUBJW',12,2,'Bweyogerere','Bweyogerere Buto','2026-10-26','morning',NULL,'collected',19750.00,19540.00,'2026-10-25 06:00:00','2026-10-26 10:15:00','2026-10-25 06:00:00','2026-10-26 10:15:00'),(41,'PU-261026-TXJEU',5,2,'Banda','Banda Zone B, near the mosque','2026-10-27','afternoon',NULL,'collected',3300.00,2970.00,'2026-10-26 06:00:00','2026-10-27 11:15:00','2026-10-26 06:00:00','2026-10-27 11:15:00'),(42,'PU-261027-JOX6O',6,NULL,'Banda','Banda Kansanga road, plot 14','2026-10-28','evening',NULL,'pending',23200.00,NULL,NULL,NULL,'2026-10-27 06:00:00','2026-10-27 06:00:00'),(43,'PU-261028-JT8XS',7,2,'Kireka','Kireka Kamuli road','2026-10-29','morning',NULL,'assigned',13200.00,NULL,'2026-10-28 06:00:00',NULL,'2026-10-28 06:00:00','2026-10-28 06:00:00'),(44,'PU-261029-PFA59',8,3,'Kyambogo','Kyambogo staff quarters, block C','2026-10-30','afternoon',NULL,'assigned',67500.00,NULL,'2026-10-29 06:00:00',NULL,'2026-10-29 06:00:00','2026-10-29 06:00:00'),(45,'PU-261030-C3WTS',9,NULL,'Nakawa','Nakawa housing estate','2026-10-31','evening',NULL,'pending',15200.00,NULL,NULL,NULL,'2026-10-30 06:00:00','2026-10-30 06:00:00'),(46,'PU-261031-QEH15',10,2,'Kasokoso','Kasokoso trading centre','2026-11-01','morning',NULL,'assigned',69800.00,NULL,'2026-10-31 06:00:00',NULL,'2026-10-31 06:00:00','2026-10-31 06:00:00');
/*!40000 ALTER TABLE `pickups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recycling_partners`
--

DROP TABLE IF EXISTS `recycling_partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recycling_partners` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `accepts` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recycling_partners`
--

LOCK TABLES `recycling_partners` WRITE;
/*!40000 ALTER TABLE `recycling_partners` DISABLE KEYS */;
INSERT INTO `recycling_partners` VALUES (1,'Kampala Plastics Recycling Plant','Namanve Industrial Park','+256 700 000 201','PET, HDPE, soft plastics','2026-10-29 05:40:13','2026-10-29 05:40:13'),(2,'Uganda Steel and Metal Works','Jinja Road Industrial Area','+256 700 000 202','Iron, steel, aluminium, copper','2026-10-29 05:40:13','2026-10-29 05:40:13'),(3,'Nile Paper Products','Kawempe, Kampala','+256 700 000 203','Cardboard and paper','2026-10-29 05:40:13','2026-10-29 05:40:13'),(4,'Coca-Cola Beverages Uganda','Namanve, Mukono','+256 700 000 204','PET bottles and aluminium cans','2026-10-29 05:40:13','2026-10-29 05:40:13');
/*!40000 ALTER TABLE `recycling_partners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('2041B2vvtjPi7i4Tb8ZOepNCF86qm222yrmQQExt',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Claude/4.29.0 Chrome/152.0.7977.167 Safari/537.36 MSIX','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVDJTcVcwSXNCVG11VUtWWXRCUVZxcGpZcDBuMVhZV211ZjdFaEFQRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAxMC9hYm91dCI7czo1OiJyb3V0ZSI7czo1OiJhYm91dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjQ6ImMwMTUwM2Q4ZTJhZTdkY2Q1YjE1NzlkZmYxZWU2MDhiNDk0YmYwYTc2NGFhMjRmNzViMWJhZjg3ZjFmMjNhYjEiO30=',1793252540);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `role` enum('household','agent','admin') NOT NULL DEFAULT 'household',
  `zone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `wallet_balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System Administrator','admin@wasteback.ug','0700000100','admin','Banda','WasteBack Office, Banda Stage',0.00,1,NULL,'$2y$12$yZjK3d02WUyc6iPtXbOLIe9DINZjtq/zoS3UVWcBi4LmH9r8TB7yS',NULL,'2026-10-29 05:40:14','2026-10-29 05:40:14'),(2,'Okello Brian','agent@wasteback.ug','0701000010','agent','Banda','Banda, Kampala',0.00,1,NULL,'$2y$12$vVU5rSpwS9c.vNZ3scZuqO6.nURXt7VKNr.7sJM8/xO2.iucNyTkS',NULL,'2026-10-29 05:40:15','2026-10-29 05:40:15'),(3,'Nansubuga Sarah','sarah.agent@wasteback.ug','0701000011','agent','Kireka','Kireka, Kampala',0.00,1,NULL,'$2y$12$NG7aXvGx.GSI4K19HZ0HzuetfwqbZJpf2OLHnceT1A2HpJ9lwopUS',NULL,'2026-10-29 05:40:15','2026-10-29 05:40:15'),(4,'Kato Ivan','ivan.agent@wasteback.ug','0701000012','agent','Nakawa','Nakawa, Kampala',0.00,1,NULL,'$2y$12$fM8mXI3vXsh6mH8WqGakMeAZ60hAV0d0Z1lCkL/1YYK0bkE7l51hm',NULL,'2026-10-29 05:40:16','2026-10-29 05:40:16'),(5,'Namubiru Grace','household@wasteback.ug','0772000010','household','Banda','Banda Zone B, near the mosque',73810.00,1,NULL,'$2y$12$S8QG8yCj2w4JDA8JCIg53uSgPz5e6/8eCDhFc7AHH.YMz7Nwn7Sia',NULL,'2026-10-29 05:40:17','2026-10-27 11:15:00'),(6,'Ssemwogerere Peter','peter@example.com','0772000011','household','Banda','Banda Kansanga road, plot 14',159160.00,1,NULL,'$2y$12$4bLbXf7YYA8UocEJJ7R8W.eDPlKJd2Ec/NTJ4rmvQ.kSGJ1q3KFre',NULL,'2026-10-29 05:40:17','2026-10-20 10:15:00'),(7,'Akello Mercy','mercy@example.com','0772000012','household','Kireka','Kireka Kamuli road',167510.00,1,NULL,'$2y$12$lvuCjtlx.VWgflfNDYxEZuCIHL2gbdylTbLSK8WLGdMWnSBWb1LXm',NULL,'2026-10-29 05:40:18','2026-10-21 11:15:00'),(8,'Mugisha Daniel','daniel@example.com','0772000013','household','Kyambogo','Kyambogo staff quarters, block C',20740.00,1,NULL,'$2y$12$fhTyDFSJT4L2iRdGJyCC4uCAEIdNqQh5V4SNc7DqTBCfi3zLI5K.i',NULL,'2026-10-29 05:40:19','2026-10-22 14:30:00'),(9,'Nalwoga Prossy','prossy@example.com','0772000014','household','Nakawa','Nakawa housing estate',251515.00,1,NULL,'$2y$12$OVZJ6qhMlKj6EfAGBMQahedBE01O7LOgUB0H5ToKhhw6wBAHvBw6i',NULL,'2026-10-29 05:40:19','2026-10-23 07:15:00'),(10,'Opolot Samuel','samuel@example.com','0772000015','household','Kasokoso','Kasokoso trading centre',72780.00,1,NULL,'$2y$12$45VbkyNWb7rZ8CXtzALQce92H6Zk1o1zUWOy0kOSejpe2oHOleqhW',NULL,'2026-10-29 05:40:20','2026-10-24 08:15:00'),(11,'Birungi Esther','esther@example.com','0772000016','household','Ntinda','Ntinda Kigoowa',229850.00,1,NULL,'$2y$12$x5D0iWFzs4dMlkSAsDshWu0/v55QAPUrU3GfUP1HlXSQpuRGuJblS',NULL,'2026-10-29 05:40:20','2026-10-17 07:15:00'),(12,'Wasswa Joseph','joseph@example.com','0772000017','household','Bweyogerere','Bweyogerere Buto',14850.00,1,NULL,'$2y$12$4dXR8vIoYmuVZTA7Egqf7OJ95Z3UVkFUvBm3CVS9BywzoHnFSmria',NULL,'2026-10-29 05:40:21','2026-10-26 14:30:00');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallet_transactions`
--

DROP TABLE IF EXISTS `wallet_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wallet_transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `pickup_id` bigint(20) unsigned DEFAULT NULL,
  `type` enum('credit','withdrawal') NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `balance_after` decimal(12,2) NOT NULL,
  `channel` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallet_transactions_reference_unique` (`reference`),
  KEY `wallet_transactions_user_id_foreign` (`user_id`),
  KEY `wallet_transactions_pickup_id_foreign` (`pickup_id`),
  CONSTRAINT `wallet_transactions_pickup_id_foreign` FOREIGN KEY (`pickup_id`) REFERENCES `pickups` (`id`) ON DELETE SET NULL,
  CONSTRAINT `wallet_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallet_transactions`
--

LOCK TABLES `wallet_transactions` WRITE;
/*!40000 ALTER TABLE `wallet_transactions` DISABLE KEYS */;
INSERT INTO `wallet_transactions` VALUES (1,'TX-260917-RXIYN',5,1,'credit',14580.00,14580.00,NULL,NULL,'Payment for pickup PU-260916-BOIXQ (16.2 kg)','2026-09-17 07:15:00','2026-09-17 07:15:00'),(2,'TX-260918-HWPET',6,2,'credit',16040.00,16040.00,NULL,NULL,'Payment for pickup PU-260917-Y4HX6 (40.1 kg)','2026-09-18 08:15:00','2026-09-18 08:15:00'),(3,'TX-260919-M5ENL',7,3,'credit',9000.00,9000.00,NULL,NULL,'Payment for pickup PU-260918-KLRSG (1.8 kg)','2026-09-19 09:15:00','2026-09-19 09:15:00'),(4,'TX-260920-LTYEX',8,4,'credit',28710.00,28710.00,NULL,NULL,'Payment for pickup PU-260919-PVYVR (31.9 kg)','2026-09-20 10:15:00','2026-09-20 10:15:00'),(5,'WD-260920-YX5SV',8,NULL,'withdrawal',17000.00,11710.00,'airtel','0772000013','Withdrawal to Airtel Money 0772000013 (simulated)','2026-09-20 14:30:00','2026-09-20 14:30:00'),(6,'TX-260921-M3LFS',9,5,'credit',103600.00,103600.00,NULL,NULL,'Payment for pickup PU-260920-KFAR4 (29.6 kg)','2026-09-21 11:15:00','2026-09-21 11:15:00'),(7,'TX-260923-RGGAR',11,7,'credit',133570.00,133570.00,NULL,NULL,'Payment for pickup PU-260922-DCF8G (122.2 kg)','2026-09-23 07:15:00','2026-09-23 07:15:00'),(8,'TX-260924-RVV6N',12,8,'credit',24790.00,24790.00,NULL,NULL,'Payment for pickup PU-260923-1DNZ6 (60.7 kg)','2026-09-24 08:15:00','2026-09-24 08:15:00'),(9,'WD-260924-DMHAU',12,NULL,'withdrawal',14000.00,10790.00,'airtel','0772000017','Withdrawal to Airtel Money 0772000017 (simulated)','2026-09-24 14:30:00','2026-09-24 14:30:00'),(10,'TX-260925-HIBRG',5,9,'credit',40310.00,54890.00,NULL,NULL,'Payment for pickup PU-260924-N3EGO (41.3 kg)','2026-09-25 09:15:00','2026-09-25 09:15:00'),(11,'TX-260926-HILUN',6,10,'credit',58560.00,74600.00,NULL,NULL,'Payment for pickup PU-260925-SIFFK (98.0 kg)','2026-09-26 10:15:00','2026-09-26 10:15:00'),(12,'TX-260927-IJS4W',7,11,'credit',60320.00,69320.00,NULL,NULL,'Payment for pickup PU-260926-4YSLI (50.6 kg)','2026-09-27 11:15:00','2026-09-27 11:15:00'),(13,'TX-260928-A65KR',8,12,'credit',32805.00,44515.00,NULL,NULL,'Payment for pickup PU-260927-FEQGH (52.2 kg)','2026-09-28 12:15:00','2026-09-28 12:15:00'),(14,'WD-260928-DFPGQ',8,NULL,'withdrawal',26000.00,18515.00,'airtel','0772000013','Withdrawal to Airtel Money 0772000013 (simulated)','2026-09-28 14:30:00','2026-09-28 14:30:00'),(15,'TX-260929-MACOM',9,13,'credit',24800.00,128400.00,NULL,NULL,'Payment for pickup PU-260928-JGLJL (31.0 kg)','2026-09-29 07:15:00','2026-09-29 07:15:00'),(16,'TX-260930-TKUS1',10,14,'credit',22500.00,22500.00,NULL,NULL,'Payment for pickup PU-260929-EB1PH (4.5 kg)','2026-09-30 08:15:00','2026-09-30 08:15:00'),(17,'TX-261001-VNTUR',11,15,'credit',12050.00,145620.00,NULL,NULL,'Payment for pickup PU-260930-DUJ4X (60.6 kg)','2026-10-01 09:15:00','2026-10-01 09:15:00'),(18,'TX-261002-JFOUW',12,16,'credit',76350.00,87140.00,NULL,NULL,'Payment for pickup PU-261001-JNDAI (34.7 kg)','2026-10-02 10:15:00','2026-10-02 10:15:00'),(19,'WD-261002-OAQOF',12,NULL,'withdrawal',52000.00,35140.00,'airtel','0772000017','Withdrawal to Airtel Money 0772000017 (simulated)','2026-10-02 14:30:00','2026-10-02 14:30:00'),(20,'TX-261004-1JFMP',6,18,'credit',21600.00,96200.00,NULL,NULL,'Payment for pickup PU-261003-A5R50 (27.0 kg)','2026-10-04 12:15:00','2026-10-04 12:15:00'),(21,'TX-261005-2GBRQ',7,19,'credit',38290.00,107610.00,NULL,NULL,'Payment for pickup PU-261004-UUHR3 (85.5 kg)','2026-10-05 07:15:00','2026-10-05 07:15:00'),(22,'TX-261006-FXKSH',8,20,'credit',10500.00,29015.00,NULL,NULL,'Payment for pickup PU-261005-7XVHD (2.1 kg)','2026-10-06 08:15:00','2026-10-06 08:15:00'),(23,'WD-261006-JNQKD',8,NULL,'withdrawal',17000.00,12015.00,'airtel','0772000013','Withdrawal to Airtel Money 0772000013 (simulated)','2026-10-06 14:30:00','2026-10-06 14:30:00'),(24,'TX-261007-8WQXX',9,21,'credit',53100.00,181500.00,NULL,NULL,'Payment for pickup PU-261006-EBE35 (18.9 kg)','2026-10-07 09:15:00','2026-10-07 09:15:00'),(25,'TX-261008-C41KT',10,22,'credit',32900.00,55400.00,NULL,NULL,'Payment for pickup PU-261007-SV0SV (9.4 kg)','2026-10-08 10:15:00','2026-10-08 10:15:00'),(26,'TX-261009-Y79OY',11,23,'credit',39230.00,184850.00,NULL,NULL,'Payment for pickup PU-261008-6Q6U0 (139.6 kg)','2026-10-09 11:15:00','2026-10-09 11:15:00'),(27,'TX-261010-TLLW4',12,24,'credit',40680.00,75820.00,NULL,NULL,'Payment for pickup PU-261009-ANV7X (70.1 kg)','2026-10-10 12:15:00','2026-10-10 12:15:00'),(28,'WD-261010-ZL1ZF',12,NULL,'withdrawal',45000.00,30820.00,'airtel','0772000017','Withdrawal to Airtel Money 0772000017 (simulated)','2026-10-10 14:30:00','2026-10-10 14:30:00'),(29,'TX-261011-4IHIM',5,25,'credit',1710.00,56600.00,NULL,NULL,'Payment for pickup PU-261010-PRGWN (11.4 kg)','2026-10-11 07:15:00','2026-10-11 07:15:00'),(30,'TX-261012-CRZNO',6,26,'credit',20880.00,117080.00,NULL,NULL,'Payment for pickup PU-261011-NWR3G (52.2 kg)','2026-10-12 08:15:00','2026-10-12 08:15:00'),(31,'TX-261013-UNV5Y',7,27,'credit',3200.00,110810.00,NULL,NULL,'Payment for pickup PU-261012-S9JQC (12.8 kg)','2026-10-13 09:15:00','2026-10-13 09:15:00'),(32,'TX-261015-KJ4AW',9,29,'credit',39895.00,221395.00,NULL,NULL,'Payment for pickup PU-261014-MGMPI (108.3 kg)','2026-10-15 11:15:00','2026-10-15 11:15:00'),(33,'TX-261016-886IQ',10,30,'credit',11130.00,66530.00,NULL,NULL,'Payment for pickup PU-261015-XKZBR (37.1 kg)','2026-10-16 12:15:00','2026-10-16 12:15:00'),(34,'TX-261017-UJJS2',11,31,'credit',45000.00,229850.00,NULL,NULL,'Payment for pickup PU-261016-QJN1L (3.0 kg)','2026-10-17 07:15:00','2026-10-17 07:15:00'),(35,'TX-261018-KTFEK',12,32,'credit',8490.00,39310.00,NULL,NULL,'Payment for pickup PU-261017-LO8TP (28.3 kg)','2026-10-18 08:15:00','2026-10-18 08:15:00'),(36,'WD-261018-CYACJ',12,NULL,'withdrawal',23000.00,16310.00,'airtel','0772000017','Withdrawal to Airtel Money 0772000017 (simulated)','2026-10-18 14:30:00','2026-10-18 14:30:00'),(37,'TX-261019-VNTR7',5,33,'credit',14240.00,70840.00,NULL,NULL,'Payment for pickup PU-261018-Q2FOY (35.6 kg)','2026-10-19 09:15:00','2026-10-19 09:15:00'),(38,'TX-261020-KK6OH',6,34,'credit',42080.00,159160.00,NULL,NULL,'Payment for pickup PU-261019-82FZW (58.8 kg)','2026-10-20 10:15:00','2026-10-20 10:15:00'),(39,'TX-261021-CEWSU',7,35,'credit',56700.00,167510.00,NULL,NULL,'Payment for pickup PU-261020-ZQ1PK (16.2 kg)','2026-10-21 11:15:00','2026-10-21 11:15:00'),(40,'TX-261022-Y3D2N',8,36,'credit',37725.00,49740.00,NULL,NULL,'Payment for pickup PU-261021-XBCT7 (53.5 kg)','2026-10-22 12:15:00','2026-10-22 12:15:00'),(41,'WD-261022-XNCVA',8,NULL,'withdrawal',29000.00,20740.00,'airtel','0772000013','Withdrawal to Airtel Money 0772000013 (simulated)','2026-10-22 14:30:00','2026-10-22 14:30:00'),(42,'TX-261023-CUJ8Y',9,37,'credit',30120.00,251515.00,NULL,NULL,'Payment for pickup PU-261022-LH4SU (52.4 kg)','2026-10-23 07:15:00','2026-10-23 07:15:00'),(43,'TX-261024-3AWZR',10,38,'credit',6250.00,72780.00,NULL,NULL,'Payment for pickup PU-261023-51VR3 (25.0 kg)','2026-10-24 08:15:00','2026-10-24 08:15:00'),(44,'TX-261026-DPXEY',12,40,'credit',19540.00,35850.00,NULL,NULL,'Payment for pickup PU-261025-EUBJW (103.6 kg)','2026-10-26 10:15:00','2026-10-26 10:15:00'),(45,'WD-261026-A9YCX',12,NULL,'withdrawal',21000.00,14850.00,'airtel','0772000017','Withdrawal to Airtel Money 0772000017 (simulated)','2026-10-26 14:30:00','2026-10-26 14:30:00'),(46,'TX-261027-HEICT',5,41,'credit',2970.00,73810.00,NULL,NULL,'Payment for pickup PU-261026-TXJEU (19.8 kg)','2026-10-27 11:15:00','2026-10-27 11:15:00');
/*!40000 ALTER TABLE `wallet_transactions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-29  8:42:26
