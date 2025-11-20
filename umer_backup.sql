-- MySQL dump 10.13  Distrib 8.0.35, for Linux (x86_64)
--
-- Host: 192.168.10.10    Database: umer
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `exam_attempts`
--

DROP TABLE IF EXISTS `exam_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_attempts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint unsigned NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL DEFAULT '0',
  `total_questions` int NOT NULL,
  `started_at` timestamp NOT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_attempts_exam_id_foreign` (`exam_id`),
  CONSTRAINT `exam_attempts_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exam_attempts`
--

LOCK TABLES `exam_attempts` WRITE;
/*!40000 ALTER TABLE `exam_attempts` DISABLE KEYS */;
INSERT INTO `exam_attempts` VALUES (1,1,'a0296888-1151-46bb-b84d-58d5fe909326',1,2,'2025-10-20 21:52:03','2025-10-20 21:52:19','2025-10-20 21:52:03','2025-10-20 21:52:19'),(2,1,'a0296888-1151-46bb-b84d-58d5fe909326',0,1,'2025-10-20 22:15:15',NULL,'2025-10-20 22:15:15','2025-10-20 22:15:15'),(3,1,'a0296888-1151-46bb-b84d-58d5fe909326',1,2,'2025-10-20 22:15:51','2025-10-20 22:18:15','2025-10-20 22:15:51','2025-10-20 22:18:15'),(4,1,'a0296888-1151-46bb-b84d-58d5fe909326',0,1,'2025-10-20 22:20:58',NULL,'2025-10-20 22:20:58','2025-10-20 22:20:58'),(5,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 16:27:06',NULL,'2025-10-21 16:27:06','2025-10-21 16:27:06'),(6,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 16:28:09','2025-10-21 16:28:52','2025-10-21 16:28:09','2025-10-21 16:28:52'),(7,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 16:29:08','2025-10-21 16:30:15','2025-10-21 16:29:08','2025-10-21 16:30:15'),(8,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-21 16:33:07',NULL,'2025-10-21 16:33:07','2025-10-21 16:33:07'),(9,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 16:43:30',NULL,'2025-10-21 16:43:30','2025-10-21 16:43:30'),(10,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 19:01:01',NULL,'2025-10-21 19:01:01','2025-10-21 19:01:01'),(11,1,'a02af712-d177-41af-8b17-f4693001df6a',1,1,'2025-10-21 19:17:57','2025-10-21 19:18:30','2025-10-21 19:17:57','2025-10-21 19:18:30'),(12,1,'a02af712-d177-41af-8b17-f4693001df6a',3,2,'2025-10-21 19:18:53','2025-10-21 19:19:48','2025-10-21 19:18:53','2025-10-21 19:19:48'),(13,1,'a02af712-d177-41af-8b17-f4693001df6a',0,2,'2025-10-21 19:32:59','2025-10-21 19:34:20','2025-10-21 19:32:59','2025-10-21 19:34:20'),(14,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:30:53',NULL,'2025-10-22 00:30:53','2025-10-22 00:30:53'),(15,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:34:23',NULL,'2025-10-22 00:34:23','2025-10-22 00:34:23'),(16,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:34:31',NULL,'2025-10-22 00:34:31','2025-10-22 00:34:31'),(17,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:34:49',NULL,'2025-10-22 00:34:49','2025-10-22 00:34:49'),(18,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:34:54',NULL,'2025-10-22 00:34:54','2025-10-22 00:34:54'),(19,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:39:14',NULL,'2025-10-22 00:39:14','2025-10-22 00:39:14'),(20,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:39:23',NULL,'2025-10-22 00:39:23','2025-10-22 00:39:23'),(21,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:39:35','2025-10-22 00:39:47','2025-10-22 00:39:35','2025-10-22 00:39:47'),(22,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:45:20',NULL,'2025-10-22 00:45:20','2025-10-22 00:45:20'),(23,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:49:03',NULL,'2025-10-22 00:49:03','2025-10-22 00:49:03'),(24,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 00:53:41','2025-10-22 00:55:05','2025-10-22 00:53:41','2025-10-22 00:55:05'),(25,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 01:04:01','2025-10-22 01:04:17','2025-10-22 01:04:01','2025-10-22 01:04:17'),(26,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 01:09:31',NULL,'2025-10-22 01:09:31','2025-10-22 01:09:31'),(27,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 01:09:46',NULL,'2025-10-22 01:09:46','2025-10-22 01:09:46'),(28,1,'a02af712-d177-41af-8b17-f4693001df6a',0,1,'2025-10-22 01:10:11',NULL,'2025-10-22 01:10:11','2025-10-22 01:10:11');
/*!40000 ALTER TABLE `exam_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exams`
--

DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `exams` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_marks` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exams_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exams`
--

LOCK TABLES `exams` WRITE;
/*!40000 ALTER TABLE `exams` DISABLE KEYS */;
INSERT INTO `exams` VALUES (1,'Mathematics Exam 2024','mathematics-exam-2024',3,1,'2025-10-20 21:50:50','2025-10-20 21:50:57');
/*!40000 ALTER TABLE `exams` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `guardians`
--

DROP TABLE IF EXISTS `guardians`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `guardians` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` decimal(8,2) DEFAULT '0.00',
  `debit` decimal(8,2) DEFAULT '0.00',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `guardians_user_id_foreign` (`user_id`),
  CONSTRAINT `guardians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guardians`
--

LOCK TABLES `guardians` WRITE;
/*!40000 ALTER TABLE `guardians` DISABLE KEYS */;
INSERT INTO `guardians` VALUES ('a0296888-1b34-4f50-8033-f10de9d4d720','a0296888-1151-46bb-b84d-58d5fe909326',NULL,0.00,0.00,NULL,'2025-10-20 21:51:18','2025-10-20 21:51:18'),('a02af715-0d24-4495-bba4-85a2030b8252','a02af712-d177-41af-8b17-f4693001df6a',NULL,0.00,0.00,NULL,'2025-10-21 16:25:44','2025-10-21 16:25:44'),('a02b61ff-f358-408b-998b-a1ae68cb65f4','a02b61fd-4b04-4076-97d6-643d94a9f3f7',NULL,0.00,0.00,NULL,'2025-10-21 21:24:42','2025-10-21 21:24:42');
/*!40000 ALTER TABLE `guardians` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2014_10_12_100000_create_password_resets_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2023_05_24_125742_create_guardians_table',1),(7,'2023_05_24_134728_create_subscription_plans_table',1),(8,'2023_07_02_181703_create_sms_table',1),(9,'2023_07_06_133107_add_first_login_to_users_table',1),(10,'2025_10_16_204328_create_questions_subjects_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `questions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_a` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_answer` enum('A','B','C','D') COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marks` int NOT NULL DEFAULT '1',
  `is_timed` tinyint(1) NOT NULL DEFAULT '0',
  `time_limit` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_exam_id_foreign` (`exam_id`),
  KEY `questions_subject_id_foreign` (`subject_id`),
  CONSTRAINT `questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `questions_subject_id_foreign` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (1,1,1,'What is 2+2?','3','4','5','6','B','questions/q1.jpg',1,0,NULL,'2025-10-20 21:50:57','2025-10-20 21:50:57'),(2,1,2,'What is H2O?','Water','Air','Fire','Earth','A',NULL,2,1,45,'2025-10-20 21:50:57','2025-10-20 21:50:57');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sms`
--

DROP TABLE IF EXISTS `sms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sms` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `external_ref` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recipient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'quiz',
  `pass_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `delivery_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `status_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sms_external_ref_unique` (`external_ref`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sms`
--

LOCK TABLES `sms` WRITE;
/*!40000 ALTER TABLE `sms` DISABLE KEYS */;
/*!40000 ALTER TABLE `sms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `subjects_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Math','MATH','2025-10-20 21:50:57','2025-10-20 21:50:57'),(2,'Science','SCIENCE','2025-10-20 21:50:57','2025-10-20 21:50:57');
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription_plans`
--

DROP TABLE IF EXISTS `subscription_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subscription_plans` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `validity` int NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription_plans`
--

LOCK TABLES `subscription_plans` WRITE;
/*!40000 ALTER TABLE `subscription_plans` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription_plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_question_history`
--

DROP TABLE IF EXISTS `user_question_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_question_history` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_id` bigint unsigned NOT NULL,
  `exam_id` bigint unsigned NOT NULL,
  `user_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_correct` tinyint(1) DEFAULT NULL,
  `answered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_question_history_exam_id_foreign` (`exam_id`),
  KEY `user_question_history_user_id_question_id_exam_id_index` (`user_id`,`question_id`,`exam_id`),
  CONSTRAINT `user_question_history_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_question_history`
--

LOCK TABLES `user_question_history` WRITE;
/*!40000 ALTER TABLE `user_question_history` DISABLE KEYS */;
INSERT INTO `user_question_history` VALUES (1,'a0296888-1151-46bb-b84d-58d5fe909326',1,1,'B',1,'2025-10-20 22:18:15','2025-10-20 21:52:19','2025-10-20 22:18:15'),(2,'a0296888-1151-46bb-b84d-58d5fe909326',2,1,'B',0,'2025-10-20 22:18:15','2025-10-20 21:52:19','2025-10-20 22:18:15'),(3,'a02af712-d177-41af-8b17-f4693001df6a',1,1,'D',0,'2025-10-22 01:04:17','2025-10-21 16:28:52','2025-10-22 01:04:17'),(4,'a02af712-d177-41af-8b17-f4693001df6a',2,1,NULL,0,'2025-10-21 19:34:20','2025-10-21 16:28:52','2025-10-21 19:34:20');
/*!40000 ALTER TABLE `user_question_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` enum('parent','student','teacher','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `centy_plus_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centy_plus_otp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `centy_plus_otp_verified` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `centy_plus_otp_sent_at` timestamp NULL DEFAULT NULL,
  `centy_plus_otp_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_login` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('a02967fe-17d9-4290-badd-d651f751c288','admin','admin@admin.com','0711637755',NULL,'admin',NULL,NULL,'0',NULL,NULL,'$2y$10$nChmBiqxnS5ovrwdMQHHiOG.Nj2pKfR17XWsKEatjYz7KPzrpIOlu','R503EuIgwpAcK8w7KzWRdFEXFz7AP4YzBpFqzHvBDsViH5vqTMWWifegMZEr','2025-10-20 21:49:49','2025-10-20 21:49:49',0),('a0296888-1151-46bb-b84d-58d5fe909326','ANTONY MWANGI NGUGI','ngugiantony1@Gmail.com','0700000809',NULL,'parent','CNT-0700000809',NULL,'0',NULL,NULL,'$2y$10$qbJPr0E36fy3VHkDq0aK5.VsvCHnfzXQkzvuPZnzoIhEDsGOj8/XG','8tO0f40QDN0sZTN5VGFh6PhtKkvFKfgO34RZKhWRNBSs43ZrqlAR99vydhCU','2025-10-20 21:51:18','2025-10-20 21:51:18',1),('a02af712-d177-41af-8b17-f4693001df6a','ANTONY MWANGI NGUGI','ngugiantony17@Gmail.com','0700000809',NULL,'parent','CNT-0700000809',NULL,'0',NULL,NULL,'$2y$10$xb7F9Ygk1GpZdqc5PJhnt.hQ54e1X4exKPhIyR33NFMUQSYXYVQ3.','GuwYOY1n0ZWyGtNzqYdU6tVq4dcAADoxsIc4IuIOFNnWjHamnxtnGoHe21gi','2025-10-21 16:25:44','2025-10-21 16:25:44',1),('a02b61fd-4b04-4076-97d6-643d94a9f3f7','ANTONY MWANGI NGUGI','ngugiantony81@Gmail.com','0757145390',NULL,'parent','CNT-0757145390',NULL,'0',NULL,NULL,'$2y$10$GvgHJT.m3aAXe1Qg55o/qe5WIUB0E66LcVYmKIORbZ8evYXsZ6wny','fAvAsKjz5apWexNr02Kgi9T4H9ASvpullGglQTIJcH21GitjSsTcvtdlePEV','2025-10-21 21:24:41','2025-10-21 21:24:41',1);
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

-- Dump completed on 2025-10-22  1:20:18
