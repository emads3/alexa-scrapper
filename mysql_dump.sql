-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: alexa
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.16.04.1-log

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
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` bigint(20) unsigned NOT NULL,
  `countries_names_id` bigint(20) unsigned NOT NULL,
  `percent_of_visits` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_website_id_countries_names_id_unique` (`website_id`,`countries_names_id`),
  KEY `countries_countries_names_id_foreign` (`countries_names_id`),
  CONSTRAINT `countries_countries_names_id_foreign` FOREIGN KEY (`countries_names_id`) REFERENCES `countries_names` (`id`),
  CONSTRAINT `countries_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries_names`
--

DROP TABLE IF EXISTS `countries_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries_names` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `countries_names_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries_names`
--

LOCK TABLES `countries_names` WRITE;
/*!40000 ALTER TABLE `countries_names` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries_names` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phinxlog`
--

DROP TABLE IF EXISTS `phinxlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phinxlog` (
  `version` bigint(20) NOT NULL,
  `migration_name` varchar(100) DEFAULT NULL,
  `start_time` timestamp NULL DEFAULT NULL,
  `end_time` timestamp NULL DEFAULT NULL,
  `breakpoint` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phinxlog`
--

LOCK TABLES `phinxlog` WRITE;
/*!40000 ALTER TABLE `phinxlog` DISABLE KEYS */;
INSERT INTO `phinxlog` VALUES (20200804075937,'Websites','2020-08-06 12:56:07','2020-08-06 12:56:07',0),(20200804090007,'SimilarWebsites','2020-08-06 12:56:07','2020-08-06 12:56:07',0),(20200804090600,'CountriesNames','2020-08-06 12:56:07','2020-08-06 12:56:07',0),(20200804090834,'Countries','2020-08-06 12:56:07','2020-08-06 12:56:07',0),(20200804091026,'Rankings','2020-08-06 12:56:07','2020-08-06 12:56:07',0),(20200804091201,'RankingsMonthly','2020-08-06 12:56:07','2020-08-06 12:56:08',0);
/*!40000 ALTER TABLE `phinxlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rankings`
--

DROP TABLE IF EXISTS `rankings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rankings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rankings_website_id_date_unique` (`website_id`,`date`),
  CONSTRAINT `rankings_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rankings`
--

LOCK TABLES `rankings` WRITE;
/*!40000 ALTER TABLE `rankings` DISABLE KEYS */;
/*!40000 ALTER TABLE `rankings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rankings_monthly`
--

DROP TABLE IF EXISTS `rankings_monthly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rankings_monthly` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `rank` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `rankings_monthly_website_id_date_unique` (`website_id`,`date`),
  CONSTRAINT `rankings_monthly_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rankings_monthly`
--

LOCK TABLES `rankings_monthly` WRITE;
/*!40000 ALTER TABLE `rankings_monthly` DISABLE KEYS */;
/*!40000 ALTER TABLE `rankings_monthly` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `similar_sites`
--

DROP TABLE IF EXISTS `similar_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `similar_sites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `website_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `overlap_score` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `similar_sites_website_id_name_unique` (`website_id`,`name`),
  CONSTRAINT `similar_sites_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `similar_sites`
--

LOCK TABLES `similar_sites` WRITE;
/*!40000 ALTER TABLE `similar_sites` DISABLE KEYS */;
/*!40000 ALTER TABLE `similar_sites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `websites`
--

DROP TABLE IF EXISTS `websites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `websites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `current_rank` int(11) DEFAULT NULL,
  `bounce_rate` decimal(8,2) DEFAULT NULL,
  `daily_pageviews_per_visitor` decimal(8,2) DEFAULT NULL,
  `daily_time_on_site` time DEFAULT NULL,
  `main_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `top_keywords` text COLLATE utf8_unicode_ci,
  `percent_search` decimal(8,2) DEFAULT NULL,
  `linking_websites` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `websites_domain_unique` (`domain`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `websites`
--

LOCK TABLES `websites` WRITE;
/*!40000 ALTER TABLE `websites` DISABLE KEYS */;
/*!40000 ALTER TABLE `websites` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-06 13:56:19
