-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: potager
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` VALUES (1,'15','Rue de la Paix','69005','Lyon'),(2,'12','Rue du Président Kennedy','69400','Villefranche-sur-Saône'),(3,'23','Avenue de la République','69430','Beaujeu'),(4,'6','Allée des Acacias','01090','Montmerle-sur-Saône'),(5,'8','Chemin des fougères','69380','Lissieu'),(13,NULL,NULL,NULL,NULL),(14,NULL,NULL,'69400','Lyon'),(17,NULL,NULL,NULL,NULL),(19,'6','rue','66666','Saint-Sauveur-en-Rue'),(20,'36','rue','63333','rue');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Fruits','fruits-668ba89137c27985147790.jpg',32993,'2024-05-25 10:39:26','2024-07-08 10:51:29','Fruits'),(2,'Légumes','legumes-668ba89997e25939618274.webp',38230,'2024-05-25 10:39:56','2024-07-08 10:51:37','Legumes'),(3,'Boissons','boissons-668ba89ea19ee196249473.webp',38706,'2024-05-25 10:41:47','2024-07-08 10:51:42','Boissons');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
INSERT INTO `doctrine_migration_versions` VALUES ('DoctrineMigrations\\Version20241030081203','2024-09-20 00:00:00',50),('DoctrineMigrations\\Version20241030082954','2024-10-30 08:30:51',28),('DoctrineMigrations\\Version20241105101720','2025-01-29 08:59:35',94),('DoctrineMigrations\\Version20250129114618','2025-01-29 11:46:28',117);
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messenger_messages`
--

LOCK TABLES `messenger_messages` WRITE;
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `producer`
--

DROP TABLE IF EXISTS `producer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `producer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `visitor_id` int DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_size` int NOT NULL,
  `address_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_976449DCF5B7AF75` (`address_id`),
  UNIQUE KEY `UNIQ_976449DC70BEE6D` (`visitor_id`),
  CONSTRAINT `FK_976449DC70BEE6D` FOREIGN KEY (`visitor_id`) REFERENCES `visitor` (`id`),
  CONSTRAINT `FK_976449DCF5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `producer`
--

LOCK TABLES `producer` WRITE;
/*!40000 ALTER TABLE `producer` DISABLE KEYS */;
INSERT INTO `producer` VALUES (3,'La Ferme Caladoise','lafermecaladoise@gmail.com','0689562456','2024-10-16 14:25:49','2024-10-29 12:40:06','En activité depuis 1970, La Ferme Caladoise est une entreprise familiale depuis trois générations. Ayant à cœur de fournir des produit de qualité, les légumes et fruits sont produits sur place.\'',2,'La-Ferme-Caladoise','lafermecaladoise-6720d7a6028b2381057186.jpg',54309,3),(4,'Légumes du jardin','legumesdujardin@gmail.com','0625323636','2024-10-23 08:06:00','2024-10-29 12:40:16','Légumes du jardin, c\'est des années de passion et d\'amour de la nature. Tous les produits de cette coopérative agricole à taille humaine, sont récoltés à la main dans la plus pur tradition française d\'antan.',5,'Legumes-du-jardin','legumesdujardin-6720d7b0caa69126703810.jpg',138866,4),(5,'Fruits du verger','fruitsduverger@gmail.com','0632353431','2024-10-24 08:33:16','2024-10-29 12:40:33','Vous aimez les fruits ? Vous allez adorer les fruits de nos vergers. Cueillis à la main, conditionnés par nos soins et pressez pour vous fournir les boissons les plus fruitées qui soit ainsi que les des fruits à consommer tel quel, Les fruits du verger, c\'est la référence lyonnaise.',10,'Fruits-du-verger','fruitsduverger-6720d7c10fde2400515042.jpg',150729,5);
/*!40000 ALTER TABLE `producer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_id` int DEFAULT NULL,
  `producer_id` int DEFAULT NULL,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_size` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `slug` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D34A04AD12469DE2` (`category_id`),
  KEY `IDX_D34A04AD89B658FE` (`producer_id`),
  CONSTRAINT `FK_D34A04AD12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE SET NULL,
  CONSTRAINT `FK_D34A04AD89B658FE` FOREIGN KEY (`producer_id`) REFERENCES `producer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (19,2,3,'Salade',1.3,'C\'est une salade','salade-6720d8a2d2a80200503285.webp',38442,'2024-07-30 12:10:50','2024-10-29 12:44:18','Salade'),(20,1,5,'Pommes',1.1,'La pomme est riche en pectine. C\'est aussi une source de vitamine C et d\'antioxydants. Elle stimule le système immunitaire.\r\nEnviron 5-6 pour faire un kilo.\r\nOrigine France.','pomme-6720d97566d22779123872.jpg',152636,'2024-07-30 14:13:59','2024-10-29 12:47:49','Pommes'),(21,3,3,'Jus de pommes',2.6,'Jus de pommes 100% naturel.','jusdepommes-6720d9f74b006534106067.webp',22722,'2024-07-30 14:23:24','2024-10-29 12:49:59','Jus-de-pommes'),(22,1,5,'Pêches',1.5,'Les pêches sont des fruits climatériques charnus, juteux et sucrés, avec une chair jaune, blanche, ou rouge (sanguine), une peau veloutée de couleur jaune ou orange plus ou moins lavée de rose-carmin à rose-saumon ou brune chez les sanguines, et un noyau dur, adhérent ou non.','peche-6720d9bd4370d784437133.webp',75334,'2024-07-30 14:29:21','2024-10-29 12:49:01','Peches'),(24,2,3,'Tomates',2,'La tomate se consomme comme un légume-fruit, crue ou cuite. Riche en eau, en antioxydant et de fibres. C\'est aussi une source de vitamine C. Autres avantages, elle est peu calorique.\r\nEnviron 6-7 pièces au kg.\r\nOrigine France','tomate-6720d8862999f998904364.jpg',271158,'2024-07-30 14:33:38','2024-10-29 12:43:50','Tomates'),(25,2,4,'Radis',2,'Toutes les parties de la plante sont comestibles, bien que sa racine pivot soit plus populaire. La peau et la chair du radis peuvent être de différentes couleurs, dont la plus courante est le rouge. Certaines variétés peuvent être bicolores, roses, violettes, vertes, blanches ou noires.','radis-6720d94c83904728277920.webp',65708,'2024-07-30 15:09:25','2024-11-02 17:13:32','Radis'),(26,1,5,'Poires',3.8,'La poire est une excellente source de fibres alimentaires et aussi riche en antioxydant. La poire conférence a la chair fine, juteuse et fondante avec une saveur légèrement acidulée.\r\nEnviron 7 poires pour faire un kilo.','poire-6720d935dc060640188970.jpg',4809,'2024-07-30 15:16:41','2024-10-29 12:46:45','Poires'),(28,3,3,'Jus de raisin',2.29,'Jus de raisin 100% Bio','jus-de-raisin-6720d8fd74a8b318018714.jpg',25989,'2024-10-24 07:20:48','2024-10-29 12:45:49','Jus-de-raisin'),(37,2,4,'Pommes de terre',1.99,'La pomme de terre ou patate est un tubercule comestible produit par l’espèce Solanum tuberosum, appartenant à la famille des solanacées. Le terme désigne également la plante elle-même, plante herbacée, vivace par ses tubercules mais toujours cultivée comme une culture annuelle.','pomme-de-terre-6720d8dfbe152302987310.jpg',64003,'2024-10-25 11:44:01','2024-10-29 12:45:19','Pommes-de-terre'),(38,3,4,'Jus de carotte',2.29,'Le jus de carotte est un jus produit à partir de carottes, souvent commercialisé comme boisson diététique. Il faut compter 450 g de carottes pour obtenir environ une tasse (235 mL) de jus.','jus-de-carotte-6720d917b4151399500784.jpg',36003,'2024-10-25 11:49:01','2024-10-29 12:46:15','Jus-de-carotte'),(41,2,4,'Artichaut',2.2,'Cette plante présente une tige dressée d\'une hauteur pouvant aller jusqu\'à 2 m, épaisse et cannelée, avec de grandes feuilles de tailles variables, et une tête. Lorsqu\'on laisse l\'artichaut se développer, il se forme à son sommet une magnifique fleur dont la couleur varie du bleu au violet.','artichaut-6720db5b07c35156599598.jpg',1312167,'2024-10-29 12:55:54','2025-01-29 09:23:47','Artichaut'),(42,2,3,'Betterave',1.4,'La betterave est un légume-racine, au même titre que la carotte et le navet. Riche en glucides, sa chair offre de bonnes teneurs en vitamines B9, minéraux et fibres.','betterave-6720db93234cd021479805.jpg',10425,'2024-10-29 12:56:51','2024-10-29 12:56:51','Betterave'),(43,1,5,'Framboises',20,'La framboise est un fruit rouge issu du framboisier (Rubus idaeus), un arbrisseau de la famille des rosacées. Selon qu\'il s\'agit de framboisiers sauvages ou cultivés, la framboise pèse de 4 à 10 g , mesure jusqu\'à 2,5 cm et compte de 40 à 80 drupéoles.','framboise-6720dbdae0c21397719959.webp',96700,'2024-10-29 12:58:02','2024-10-29 12:58:02','Framboises'),(44,1,3,'Pêche plate',2.13,'Les pêches plates sont caractérisées par leur peau duveteuse et une chair blanche ou jaune qui se détache facilement du noyau et bien sûr par leur forme aplatie si caractéristique. Elles sont délicieuses crues, mais aussi en crumble, tarte ou sorbet.','peche-plate-6720dc0b0b610100379689.jpg',221307,'2024-10-29 12:58:50','2024-10-29 12:58:51','Peche-plate'),(45,2,4,'Poireau',1.1,'Le Poireau est une plante vivace de 50 cm à 1 m de haut, glabre et à odeur forte. La tige est dressée, pleine, épaisse et cylindrique. Elle porte des feuilles glauques, longues, engainantes, dont le limbe est plié en gouttière. La base des feuilles emboîtées forme la partie blanche et enterrée de la fausse tige.','poireau-6720dc3e1185e793809247.jpg',57972,'2024-10-29 12:59:42','2024-10-29 12:59:42','Poireau');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discr` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  KEY `IDX_8D93D649F5B7AF75` (`address_id`),
  CONSTRAINT `FK_8D93D649F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin@admin.admin','[\"ROLE_ADMIN\"]','$2y$13$A.lwV.2CmjhpqKbFMadPXODo7lpvVo5WsgooQPHObNG7GIHh7vNmq','0232658265','visitor',1),(2,'assou@admin.admin','[\"ROLE_PRODUCER\", \"ROLE_USER\"]','$2y$13$qaAEbPUXqbB2OXlN6HPjUeKsvjoJLwOSUpWkodDCXar.wCc5UfhEi','0202020021','visitor',NULL),(5,'jdujardin@gmail.com','[\"ROLE_PRODUCER\"]','$2y$13$h3rgjvxH1N36vDyQKb8q..Eo1zrBTpS18gPSfi8YKUtbCSU/ysr0G','0336323535','visitor',2),(10,'toma@toma.toma','[\"ROLE_PRODUCER\"]','$2y$13$HmYJs.DMelocD/ebo6OGhODnl6XM61qy83uOKBKXNWJom/dWEFlLy','0632353632','visitor',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitor`
--

DROP TABLE IF EXISTS `visitor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `visitor` (
  `id` int NOT NULL,
  `firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `FK_CAE5E19FBF396750` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitor`
--

LOCK TABLES `visitor` WRITE;
/*!40000 ALTER TABLE `visitor` DISABLE KEYS */;
INSERT INTO `visitor` VALUES (1,'Admin','Admin',NULL),(2,'Assou','Mani','confirmed'),(5,'Jean','Dujardin','confirmed'),(10,'toma','toma','confirmed');
/*!40000 ALTER TABLE `visitor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-10  8:47:15
