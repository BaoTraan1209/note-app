-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: localhost    Database: note_app_2026
-- ------------------------------------------------------
-- Server version	9.7.0

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ 'b7c80c35-43e3-11f1-989e-98fa9b10cf32:1-4639';

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('notenest-cache-lengocbaotran2006123@gmail.com|127.0.0.1','i:1;',1778997884),('notenest-cache-lengocbaotran2006123@gmail.com|127.0.0.1:timer','i:1778997884;',1778997884);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
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
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_04_20_132433_create_notes_table',1),(5,'2026_05_10_113329_add_fields_to_users_table',1),(6,'2026_05_14_164023_add_deleted_at_to_notes_table',1),(7,'2026_05_14_211004_create_note_tags_table',1),(8,'2026_05_14_211250_create_note_note_tags_table',1),(9,'2026_05_14_230500_add_preferences_to_users_table',1),(10,'2026_05_14_231000_create_note_shares_table',1),(11,'2026_05_14_232000_add_font_size_to_notes_table',1),(12,'2026_05_14_233000_drop_color_from_notes_table',1),(13,'2026_05_15_010000_add_images_to_notes_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_note_tag`
--

DROP TABLE IF EXISTS `note_note_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note_note_tag` (
  `note_id` bigint unsigned NOT NULL,
  `note_tag_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`note_id`,`note_tag_id`),
  KEY `note_note_tag_note_tag_id_foreign` (`note_tag_id`),
  CONSTRAINT `note_note_tag_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `note_note_tag_note_tag_id_foreign` FOREIGN KEY (`note_tag_id`) REFERENCES `note_tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_note_tag`
--

LOCK TABLES `note_note_tag` WRITE;
/*!40000 ALTER TABLE `note_note_tag` DISABLE KEYS */;
INSERT INTO `note_note_tag` VALUES (1,1),(4,2);
/*!40000 ALTER TABLE `note_note_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_shares`
--

DROP TABLE IF EXISTS `note_shares`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note_shares` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint unsigned NOT NULL,
  `owner_id` bigint unsigned NOT NULL,
  `recipient_id` bigint unsigned NOT NULL,
  `permission` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'read',
  `last_viewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `note_shares_note_id_recipient_id_unique` (`note_id`,`recipient_id`),
  KEY `note_shares_owner_id_foreign` (`owner_id`),
  KEY `note_shares_recipient_id_foreign` (`recipient_id`),
  CONSTRAINT `note_shares_note_id_foreign` FOREIGN KEY (`note_id`) REFERENCES `notes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `note_shares_owner_id_foreign` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `note_shares_recipient_id_foreign` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_shares`
--

LOCK TABLES `note_shares` WRITE;
/*!40000 ALTER TABLE `note_shares` DISABLE KEYS */;
INSERT INTO `note_shares` VALUES (1,1,3,2,'edit',NULL,'2026-05-17 06:11:11','2026-05-17 06:11:33'),(3,1,3,5,'read',NULL,'2026-05-17 06:20:01','2026-05-17 06:20:01');
/*!40000 ALTER TABLE `note_shares` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `note_tags`
--

DROP TABLE IF EXISTS `note_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `note_tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `note_tags_name_created_by_unique` (`name`,`created_by`),
  KEY `note_tags_created_by_foreign` (`created_by`),
  CONSTRAINT `note_tags_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `note_tags`
--

LOCK TABLES `note_tags` WRITE;
/*!40000 ALTER TABLE `note_tags` DISABLE KEYS */;
INSERT INTO `note_tags` VALUES (1,'Study',3,'2026-05-17 06:31:28','2026-05-17 06:31:28'),(2,'GDFGDF',3,'2026-05-17 06:32:10','2026-05-17 06:32:10');
/*!40000 ALTER TABLE `note_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pinned_at` timestamp NULL DEFAULT NULL,
  `font_size` tinyint unsigned NOT NULL DEFAULT '16',
  `created_by` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notes_created_by_foreign` (`created_by`),
  CONSTRAINT `notes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,'Lập trình web','<div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAICBAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"a7qCn\" data-sfc-root=\"c\" jsuid=\"WhnYid_w\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-size: 20px; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">1. Front-end (Lập trình giao diện)<!--TgQPHd|[]--></div></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAICxAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc\" data-sfc-root=\"c\" jsuid=\"WhnYid_10\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACAsQAQ\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\">Đây là phần người dùng nhìn thấy và tương tác trực tiếp khi truy cập vào website.<!--TgQPHd|[]--></div></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIDxAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><ul class=\"KsbFXc U6u95\" jsaction=\"\" jscontroller=\"mPWODf\" data-sfc-root=\"c\" jsuid=\"WhnYid_17\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_18\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACA8QAQ\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_19\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_1a\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">HTML:<!--TgQPHd|[]--></span> Ngôn ngữ đánh dấu giúp định dạng cấu trúc, nội dung cơ bản của trang web (văn bản, hình ảnh, liên kết).<!--TgQPHd|[]--></span><!--TgQPHd|[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_1b\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACA8QAg\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1c\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_1d\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">CSS:<!--TgQPHd|[]--></span> Ngôn ngữ thiết kế giúp định kiểu, căn chỉnh bố cục, màu sắc và tạo giao diện bắt mắt, tương thích với mọi thiết bị (máy tính, điện thoại).<!--TgQPHd|[]--></span><!--TgQPHd|[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_1e\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACA8QAw\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1f\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_1g\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">JavaScript:<!--TgQPHd|[]--></span> Ngôn ngữ lập trình giúp trang web trở nên động và có tính tương tác (hiệu ứng, chuyển động, xử lý biểu mẫu, kết nối dữ liệu không cần tải lại trang).<!--TgQPHd|[]--></span><!--TgQPHd|[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_1h\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACA8QBA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1i\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_1j\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Frameworks &amp; Libraries:<!--TgQPHd|[]--></span> Các thư viện và bộ công cụ giúp viết mã nhanh hơn như <span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1k\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">React<!--TgQPHd|[]--></span>, <span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1l\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Vue.js<!--TgQPHd|[]--></span>, hoặc <span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_1m\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Angular</span></span><!--TgQPHd|[]--></li><!--TgQPHd|[]--></ul></div><div class=\"Fsg96\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;WhnYid_1v|npT2md\" jscontroller=\"KHhJQ\" data-sfc-root=\"c\" jsuid=\"WhnYid_1v\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|[]--></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIEBAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"a7qCn\" data-sfc-root=\"c\" jsuid=\"WhnYid_1w\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-size: 20px; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">2. Back-end (Lập trình hệ thống)<!--TgQPHd|[]--></div></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIERAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc\" data-sfc-root=\"c\" jsuid=\"WhnYid_20\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACBEQAQ\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\">Đây là phần \"hậu trường\" xử lý logic, quản lý dữ liệu, và vận hành các chức năng ẩn mà người dùng không trực tiếp nhìn thấy. [<a href=\"https://translate.google.com/translate?u=https://en.wikipedia.org/wiki/Web_development&amp;hl=vi&amp;sl=en&amp;tl=vi&amp;client=sge\">1</a><!--TgQPHd|[]--></div></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIFRAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><ul class=\"KsbFXc U6u95\" jsaction=\"\" jscontroller=\"mPWODf\" data-sfc-root=\"c\" jsuid=\"WhnYid_25\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_26\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACBUQAQ\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_27\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_28\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Ngôn ngữ lập trình:<!--TgQPHd|[]--></span> Các ngôn ngữ phổ biến xử lý phía máy chủ như <span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_29\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">PHP<!--TgQPHd|[]--></span>, <span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2a\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Node.js (JavaScript)<!--TgQPHd|[]--></span>, <span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2b\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Python<!--TgQPHd|[]--></span>, <span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2c\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Java<!--TgQPHd|[]--></span>, hoặc <span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2d\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">C#<!--TgQPHd|[]--></span>.<!--TgQPHd|[]--></span><!--TgQPHd|[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_2e\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACBUQAg\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_2f\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2g\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Cơ sở dữ liệu (Database):<!--TgQPHd|[]--></span> Nơi lưu trữ, quản lý và truy xuất thông tin người dùng, bài viết, sản phẩm... (phổ biến như MySQL, PostgreSQL, MongoDB).<!--TgQPHd|[]--></span><!--TgQPHd|[]--></li><li class=\"Z1qcYe\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"oSLmPe\" data-sfc-root=\"c\" jsuid=\"WhnYid_2h\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACBUQAw\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px 0px 12px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px 0px 12px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"T286Pc\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"fly6D\" data-sfc-root=\"c\" jsuid=\"WhnYid_2i\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"Yjhzub\" jsaction=\"\" jscontroller=\"zYmgkd\" data-sfc-root=\"c\" jsuid=\"WhnYid_2j\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 600; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">API (Application Programming Interface):<!--TgQPHd|[]--></span> Cầu nối giúp giao diện Front-end trao đổi dữ liệu với hệ thống Back-end.</span><!--TgQPHd|[]--></li><!--TgQPHd|[]--></ul></div><div class=\"Fsg96\" data-sfc-cp=\"\" jsaction=\"rcuQ6b:&amp;WhnYid_2r|npT2md\" jscontroller=\"KHhJQ\" data-sfc-root=\"c\" jsuid=\"WhnYid_2r\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><!--TgQPHd|[]--></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIFhAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"otQkpb\" aria-level=\"3\" role=\"heading\" data-animation-nesting=\"\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"a7qCn\" data-sfc-root=\"c\" jsuid=\"WhnYid_2s\" data-sfc-cb=\"\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 20px; font-weight: 600; margin: 24px 0px 12px; text-decoration: none; border-bottom: 0px rgb(0, 29, 53);\" style=\"font-size: 20px; margin: 24px 0px 12px; border-bottom: 0px rgb(0, 29, 53);\">3. Full-stack (Lập trình toàn diện)<!--TgQPHd|[]--></div></div><div data-bfc=\"\" class=\"\" data-ved=\"2ahUKEwiowvf817-UAxVgQPUHHadDEzcQi4wTegoIAggACAAIFxAA\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; margin: 0px; border-bottom: 0px rgb(10, 10, 10);\"><div class=\"n6owBd awi2gc Lem6n\" data-sfc-cp=\"\" jsaction=\"\" jscontroller=\"TDBkbc\" data-sfc-root=\"c\" jsuid=\"WhnYid_2w\" data-sfc-cb=\"\" data-hveid=\"CAIIAAgACBcQAQ\" data-processed=\"true\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 12px 0px 16px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 12px 0px 16px; border-bottom: 0px rgb(10, 10, 10);\"><span class=\"N9Q8Lc\" data-copy-service-computed-style=\"font-family: &quot;Google Sans&quot;, Arial, sans-serif; font-size: 16px; font-weight: 400; margin: 0px; text-decoration: none; border-bottom: 0px rgb(10, 10, 10);\" style=\"margin: 0px; border-bottom: 0px rgb(10, 10, 10);\">Là thuật ngữ chỉ các lập trình viên có thể đảm nhận cả công việc Front-end và Back-end để tự xây dựng một ứng dụng web hoàn chỉnh từ đầu đến cuối.</span> </div></div>',NULL,'$2y$12$wIvZfro4sKorQaQxdPRZB.w1psO5D11FBXD7SBkNBFsWNchNdvWIK',NULL,16,3,'2026-05-17 06:10:55','2026-05-17 06:25:58',NULL),(2,'sfasfsafsafas','ss',NULL,NULL,NULL,16,3,'2026-05-17 06:28:01','2026-05-17 06:28:37','2026-05-17 06:28:37'),(3,'sfasfsa',NULL,NULL,NULL,NULL,16,3,'2026-05-17 06:28:02','2026-05-17 06:28:33','2026-05-17 06:28:33'),(4,'dasadsad','dsadsadsa',NULL,NULL,NULL,16,3,'2026-05-17 06:31:37','2026-05-17 06:32:39','2026-05-17 06:32:39');
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
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
INSERT INTO `sessions` VALUES ('XO7IbtpzdnsCW0WN95KlzycVtcTas4T3iAbCdqmg',3,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiclJKVFNXN3pFYUowUnJMempMaWZpeXNRczV2VW10cFFGR0hlSFhIdCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6OToiZGFzaGJvYXJkIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MztzOjU6Im5vdGVzIjthOjE6e2k6MTthOjE6e3M6ODoidW5sb2NrZWQiO2I6MTt9fX0=',1778999594);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2026-05-17 05:42:47','$2y$12$bBFA3P5s1vBq89QwqdDaIOf5g/jUT3bwddleTd/E5R5sxNZzCDRwm','ucYGxlvolKNCooceZ2eo1VUuuotCKLhQ08PkrKk7yfvWAk6YiQVablRggVwN','2026-05-17 05:42:47','2026-05-17 05:42:47',NULL,NULL,NULL),(2,'Bao Traan','lengocbaotran2006123@gmail.com',NULL,'$2y$12$B5HkEmmUjxxUMtKde38hX.2yYLQg5uv3crECmLM3RnqrCcG0pnkwK',NULL,'2026-05-17 06:04:04','2026-05-17 06:04:04',NULL,NULL,NULL),(3,'Thai An','hoangthaian.7942@gmail.com',NULL,'$2y$12$jzeZD0KrK6Jpo27fBjsm8eJkZyNm.YGEVnOiL9AZkzmvQz1nTB0tu',NULL,'2026-05-17 06:05:06','2026-05-17 06:28:29',NULL,NULL,'{\"theme\": \"light\", \"default_view\": \"grid\"}'),(5,'Thai An','thaian5553979@gmail.com',NULL,'$2y$12$9UZEisoACAz0EKNdXHajrumtBZI3rg4pgUVhJBe7DjY7p4kf9I8QC',NULL,'2026-05-17 06:19:18','2026-05-17 06:19:18',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-17 13:41:01
