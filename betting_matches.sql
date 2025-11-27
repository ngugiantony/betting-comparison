-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: localhost    Database: betting
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `matches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `competition_id` int DEFAULT NULL,
  `sport_id` int NOT NULL,
  `bookmaker` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `home_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `away_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `match_time` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `odds_home` decimal(10,2) DEFAULT NULL,
  `odds_draw` decimal(10,2) DEFAULT NULL,
  `odds_away` decimal(10,2) DEFAULT NULL,
  `scraped_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `event_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_datetime` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_match` (`sport_id`,`home_name`,`away_name`,`scraped_at`),
  KEY `competition_id` (`competition_id`),
  CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`competition_id`) REFERENCES `competitions` (`id`),
  CONSTRAINT `matches_ibfk_2` FOREIGN KEY (`sport_id`) REFERENCES `sports` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2432 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `matches`
--

LOCK TABLES `matches` WRITE;
/*!40000 ALTER TABLE `matches` DISABLE KEYS */;
INSERT INTO `matches` VALUES (2358,NULL,1,'unibet','Liga MX','Quarts','2025-11-27 02:00:00',3.25,3.15,1.69,'2025-11-27 00:49:52','2025-11-27',NULL,'02:00:00'),(2359,NULL,1,'unibet','FC Juarez','Deportivo Toluca','2025-11-27 02:00:00',3.25,3.15,1.88,'2025-11-27 00:49:52','2025-11-27',NULL,'02:00:00'),(2360,NULL,1,'unibet','Atletico Nacional','Atletico Junior','2025-11-27 02:30:00',1.49,3.80,4.85,'2025-11-27 00:49:52','2025-11-27',NULL,'02:30:00'),(2361,NULL,1,'unibet','Monterrey','Club América','2025-11-27 04:05:00',2.49,3.00,2.35,'2025-11-27 00:49:52','2025-11-27',NULL,'04:05:00'),(2362,NULL,1,'unibet','Club Tijuana','Tigres','2025-11-27 06:00:00',3.15,3.25,1.88,'2025-11-27 00:49:52','2025-11-27',NULL,'06:00:00'),(2363,NULL,1,'unibet','Seoul E','Land FC','2025-11-27 11:00:00',1.90,3.20,3.12,'2025-11-27 00:49:52','2025-11-27',NULL,'11:00:00'),(2364,NULL,1,'unibet','AS Rome','FC Midtjylland','2025-11-27 18:45:00',1.43,4.60,6.50,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2365,NULL,1,'unibet','AZ Alkmaar','Shelbourne FC','2025-11-27 18:45:00',1.13,6.70,13.20,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2366,NULL,1,'unibet','Aston Villa','Young Boys Berne','2025-11-27 18:45:00',1.15,6.75,11.50,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2367,NULL,1,'unibet','FC Porto','Nice','2025-11-27 18:45:00',1.38,5.00,7.50,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2368,NULL,1,'unibet','FC Viktoria Plzen','Fribourg','2025-11-27 18:45:00',3.10,3.35,2.09,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2369,NULL,1,'unibet','Fenerbahce','Ferencvaros','2025-11-27 18:45:00',1.54,4.15,4.80,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2370,NULL,1,'unibet','Feyenoord','Celtic','2025-11-27 18:45:00',1.66,3.95,4.10,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2371,NULL,1,'unibet','Hamrun Spartans FC','Lincoln Red Imps FC','2025-11-27 18:45:00',1.56,3.85,4.75,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2372,NULL,1,'unibet','Omonia Nicosie','Dynamo Kiev','2025-11-27 18:45:00',2.02,3.45,3.08,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2373,NULL,1,'unibet','Universitatea Craiova','Mayence','2025-11-27 18:45:00',4.20,3.58,1.69,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2374,NULL,2,'unibet','Roland Garros','Compétition (F)','2026-01-31 10:00:00',3.00,5.00,9.00,'2025-11-27 00:49:52','2026-1-31',NULL,'10:00:00'),(2375,NULL,2,'unibet','Roland Garros','Compétition (H)','2025-11-27 11:00:00',2.50,NULL,2.50,'2025-11-27 00:49:52','2025-11-27',NULL,'11:00:00'),(2376,NULL,2,'unibet','Wimbledon','Compétition (F)','2025-11-27 09:00:00',3.50,3.50,9.00,'2025-11-27 00:49:52','2025-11-27',NULL,'09:00:00'),(2377,NULL,2,'unibet','Wimbledon','Compétition (H)','2025-11-27 09:00:00',2.00,2.50,9.00,'2025-11-27 00:49:52','2025-11-27',NULL,'09:00:00'),(2378,NULL,3,'unibet','New Orleans Pelicans','Memphis Grizzlies','2025-11-27 02:00:00',2.35,1.58,1.51,'2025-11-27 00:49:52','2025-11-27',NULL,'02:00:00'),(2379,NULL,3,'unibet','Golden State Warriors','Houston Rockets','2025-11-27 04:00:00',1.67,NULL,2.21,'2025-11-27 00:49:52','2025-11-27',NULL,'04:00:00'),(2380,NULL,3,'unibet','Portland Trail Blazers','San Antonio Spurs','2025-11-27 04:00:00',1.84,NULL,1.94,'2025-11-27 00:49:52','2025-11-27',NULL,'04:00:00'),(2381,NULL,3,'unibet','Sacramento Kings','Phoenix Suns','2025-11-27 04:00:00',2.48,NULL,1.52,'2025-11-27 00:49:52','2025-11-27',NULL,'04:00:00'),(2382,NULL,3,'unibet','Cameroun','Cap-Vert','2025-11-27 11:00:00',1.21,NULL,3.20,'2025-11-27 00:49:52','2025-11-27',NULL,'11:00:00'),(2383,NULL,3,'unibet','Cap','Vert','2025-11-27 00:00:00',1.21,NULL,3.20,'2025-11-27 00:49:52','2025-11-27',NULL,'00:00:00'),(2384,NULL,3,'unibet','Soudan du Sud','Libye','2025-11-27 14:00:00',1.01,NULL,6.90,'2025-11-27 00:49:52','2025-11-27',NULL,'14:00:00'),(2385,NULL,3,'unibet','Iran','Irak','2025-11-27 15:00:00',1.01,NULL,6.90,'2025-11-27 00:49:52','2025-11-27',NULL,'15:00:00'),(2386,NULL,3,'unibet','Arabie Saoudite','Inde','2025-11-27 17:00:00',1.01,NULL,6.90,'2025-11-27 00:49:52','2025-11-27',NULL,'17:00:00'),(2387,NULL,3,'unibet','Nigéria','Tunisie','2025-11-27 17:00:00',1.53,NULL,2.06,'2025-11-27 00:49:52','2025-11-27',NULL,'17:00:00'),(2388,NULL,3,'unibet','Qatar','Liban','2025-11-27 17:00:00',3.05,NULL,1.24,'2025-11-27 00:49:52','2025-11-27',NULL,'17:00:00'),(2389,NULL,3,'unibet','ZKK Student','BC Namur Capitale','2025-11-27 17:00:00',1.79,NULL,1.66,'2025-11-27 00:49:52','2025-11-27',NULL,'17:00:00'),(2390,NULL,3,'unibet','Grèce','Roumanie','2025-11-27 17:30:00',1.02,NULL,6.45,'2025-11-27 00:49:52','2025-11-27',NULL,'17:30:00'),(2391,NULL,3,'unibet','Jordanie','Syrie','2025-11-27 17:30:00',1.02,NULL,6.45,'2025-11-27 00:49:52','2025-11-27',NULL,'17:30:00'),(2392,NULL,3,'unibet','ACS Sepsi Sic','ASD Geas Basket','2025-11-27 18:00:00',2.80,NULL,1.24,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2393,NULL,3,'unibet','AZS UMCS Lublin','Cb Jairis','2025-11-27 18:00:00',2.01,NULL,1.51,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2394,NULL,4,'unibet','Angola','Kazakhstan','2025-11-27 18:00:00',1.01,24.50,7.35,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2395,NULL,4,'unibet','Roumanie','Croatie','2025-11-27 18:00:00',1.18,14.50,6.00,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2396,NULL,4,'unibet','Suisse','Iran','2025-11-27 18:00:00',1.01,23.50,26.50,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2397,NULL,4,'unibet','GOG Handbold','FC Barcelone','2025-11-27 18:45:00',7.50,13.20,1.07,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2398,NULL,4,'unibet','Szeged','Zagreb','2025-11-27 18:45:00',1.06,NULL,8.10,'2025-11-27 00:49:52','2025-11-27',NULL,'18:45:00'),(2399,NULL,4,'unibet','HSG Wetzlar','Rhein-Neckar Lowen','2025-11-27 19:00:00',3.75,NULL,1.30,'2025-11-27 00:49:52','2025-11-27',NULL,'19:00:00'),(2400,NULL,4,'unibet','Rhein','Neckar Lowen','2025-11-27 00:00:00',3.75,NULL,1.30,'2025-11-27 00:49:52','2025-11-27',NULL,'00:00:00'),(2401,NULL,4,'unibet','Danemark','Japon','2025-11-27 20:30:00',1.01,NULL,26.50,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2402,NULL,4,'unibet','Hongrie','Sénégal','2025-11-27 20:30:00',1.04,NULL,13.80,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2403,NULL,4,'unibet','Norvège','Corée du Sud','2025-11-27 20:30:00',1.01,NULL,25.50,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2404,NULL,4,'unibet','Suède','Tchéquie','2025-11-27 20:30:00',1.06,25.50,11.80,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2405,NULL,4,'unibet','Füchse Berlin','Veszprem','2025-11-27 20:45:00',1.43,8.60,3.08,'2025-11-27 00:49:52','2025-11-27',NULL,'20:45:00'),(2406,NULL,4,'unibet','Paris SG','Wisla Plock','2025-11-27 20:45:00',1.69,7.80,2.38,'2025-11-27 00:49:52','2025-11-27',NULL,'20:45:00'),(2407,NULL,4,'unibet','Sporting Clube Portugal','Kolstad','2025-11-27 20:45:00',1.02,15.50,10.50,'2025-11-27 00:49:52','2025-11-27',NULL,'20:45:00'),(2408,NULL,4,'unibet','Autriche','Egypte','2025-11-27 18:00:00',1.03,14.80,12.20,'2025-11-27 00:49:52','2025-11-27',NULL,'18:00:00'),(2409,NULL,4,'unibet','Pologne','Chine','2025-11-28 18:30:00',1.01,NULL,13.80,'2025-11-27 00:49:52','2025-11-28',NULL,'18:30:00'),(2410,NULL,4,'unibet','HC Erlangen','TVB Stuttgart','2025-11-27 19:00:00',1.55,7.50,2.70,'2025-11-27 00:49:52','2025-11-27',NULL,'19:00:00'),(2411,NULL,4,'unibet','Chartres','Saint-Raphaël','2025-11-27 20:00:00',3.12,8.15,1.41,'2025-11-27 00:49:52','2025-11-27',NULL,'20:00:00'),(2412,NULL,4,'unibet','Saint','Raphaël','2025-11-27 00:00:00',3.12,8.15,1.41,'2025-11-27 00:49:52','2025-11-27',NULL,'00:00:00'),(2413,NULL,4,'unibet','Limoges','Toulouse','2025-11-27 20:00:00',1.87,7.00,2.11,'2025-11-27 00:49:52','2025-11-27',NULL,'20:00:00'),(2414,NULL,4,'unibet','Montpellier','Tremblay-en-France','2025-11-27 20:00:00',1.08,15.20,7.25,'2025-11-27 00:49:52','2025-11-27',NULL,'20:00:00'),(2415,NULL,4,'unibet','Tremblay','en-France','2025-11-27 00:00:00',1.08,15.20,7.25,'2025-11-27 00:49:52','2025-11-27',NULL,'00:00:00'),(2416,NULL,4,'unibet','Nîmes','Dijon','2025-11-27 20:00:00',1.25,NULL,4.05,'2025-11-27 00:49:52','2025-11-27',NULL,'20:00:00'),(2417,NULL,4,'unibet','ThSV Eisenach','Kiel','2025-11-28 20:00:00',5.90,9.75,1.14,'2025-11-27 00:49:52','2025-11-28',NULL,'20:00:00'),(2418,NULL,4,'unibet','Bm Nava','BM Guadalajara','2025-11-27 20:30:00',1.25,9.80,4.10,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2419,NULL,4,'unibet','Espagne','Iles Féroé','2025-11-27 20:30:00',1.09,19.50,7.90,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2420,NULL,4,'unibet','Pays','Bas','2025-11-27 20:30:00',1.01,NULL,20.50,'2025-11-27 00:49:52','2025-11-27',NULL,'20:30:00'),(2421,NULL,14,'unibet','Milan','San Remo','2026-03-21 10:00:00',2.75,4.00,3.50,'2025-11-27 00:49:52','2026-3-21',NULL,'10:00:00'),(2422,NULL,14,'unibet','Milan','San Remo 2026','2025-11-27 10:00:00',2.75,4.00,9.00,'2025-11-27 00:49:52','2025-11-27',NULL,'10:00:00'),(2423,NULL,14,'unibet','Paris','Roubaix','2025-11-27 11:25:00',2.10,4.00,6.50,'2025-11-27 00:49:52','2025-11-27',NULL,'11:25:00'),(2424,NULL,14,'unibet','Paris','Roubaix 2026','2025-11-27 11:25:00',2.10,4.00,6.50,'2025-11-27 00:49:52','2025-11-27',NULL,'11:25:00'),(2425,NULL,14,'unibet','Tour de France','Classement Général','2025-11-27 12:00:00',1.35,NULL,3.50,'2025-11-27 00:49:52','2025-11-27',NULL,'12:00:00'),(2426,4,1,'parionssport','Atl.Nacional','Junior FC','2025-11-27 04:30:00',1.48,3.55,4.50,'2025-11-27 01:09:02','2025-11-27',NULL,'04:30:00'),(2427,NULL,6,'parionssport','Brive','Colomiers','2025-11-27 23:00:00',1.24,NULL,3.50,'2025-11-27 01:09:02','2025-11-27',NULL,'23:00:00'),(2428,NULL,6,'parionssport','Grenoble','Biarritz','2025-11-27 23:00:00',1.05,NULL,6.50,'2025-11-27 01:09:02','2025-11-27',NULL,'23:00:00'),(2429,NULL,7,'parionssport','THY','Avarca Menorca','2025-11-27 18:00:00',1.01,NULL,5.90,'2025-11-27 01:09:02','2025-11-27',NULL,'18:00:00'),(2430,24,7,'parionssport','Vakifbank','Le Cannet','2025-11-27 19:00:00',1.01,NULL,7.00,'2025-11-27 01:09:02','2025-11-27',NULL,'19:00:00'),(2431,24,7,'parionssport','SC Schweriner','Paris','2025-11-27 20:00:00',1.26,NULL,2.90,'2025-11-27 01:09:02','2025-11-27',NULL,'20:00:00');
/*!40000 ALTER TABLE `matches` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-27 18:39:40
