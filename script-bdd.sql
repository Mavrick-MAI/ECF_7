-- MySQL dump 10.13  Distrib 8.0.34, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: ecf_7
-- ------------------------------------------------------
-- Server version	8.0.34-0ubuntu0.20.04.1

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
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `libelle` (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `application`
--

LOCK TABLES `application` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `chef_de_projet`
--

DROP TABLE IF EXISTS `chef_de_projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chef_de_projet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_collaborateur` int NOT NULL,
  `boost_production` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_collaborateur` (`id_collaborateur`),
  CONSTRAINT `chef_projet_collaborateur_id_fk` FOREIGN KEY (`id_collaborateur`) REFERENCES `collaborateur` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chef_de_projet`
--

LOCK TABLES `chef_de_projet` WRITE;
INSERT INTO `chef_de_projet` VALUES (1,5,10),(2,4,20),(9,7,30);
UNLOCK TABLES;

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `raison_sociale` varchar(50) NOT NULL,
  `ridet` varchar(10) NOT NULL,
  `ss2i` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `ridet` (`ridet`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
INSERT INTO `client` VALUES (1,'Entreprise A','RIDET001',0),(2,'Société XYZ','RIDET002',1),(3,'Compagnie ABC','RIDET003',0),(4,'Startup 123','RIDET004',1),(5,'SARL EFGH','RIDET005',0),(6,'Corp Tech','RIDET006',1),(7,'Industrie Z','RIDET007',0),(8,'Agence KLM','RIDET008',1),(9,'Innovation SAS','RIDET009',0),(10,'Groupe QRS','RIDET010',1);
UNLOCK TABLES;

--
-- Table structure for table `collaborateur`
--

DROP TABLE IF EXISTS `collaborateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `collaborateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `niveau` enum('1','2','3') NOT NULL DEFAULT '1',
  `prime_embauche` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `collaborateur`
--

LOCK TABLES `collaborateur` WRITE;
INSERT INTO `collaborateur` VALUES (3,'Dupont','Jean','1',500),(4,'Martin','Sophie','2',800),(5,'Dubois','Pierre','1',500),(6,'Lefebvre','Marie','3',1000),(7,'Leclerc','Alexandre','2',800),(8,'Gagnon','Isabelle','1',500),(9,'Tremblay','Gabriel','2',800),(10,'Roy','Julie','1',500),(11,'Bouchard','Maxime','3',1000),(12,'Gauthier','Sarah','1',500);
UNLOCK TABLES;

--
-- Table structure for table `composant`
--

DROP TABLE IF EXISTS `composant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `composant` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_module` int DEFAULT NULL,
  `libelle` varchar(100) NOT NULL,
  `type` enum('1','2','3') NOT NULL DEFAULT '1',
  `charge` int NOT NULL,
  `progression` int,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `libelle` (`libelle`),
  KEY `composant_module_id_fk` (`id_module`),
  CONSTRAINT `composant_module_id_fk` FOREIGN KEY (`id_module`) REFERENCES `module` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `composant`
--

LOCK TABLES `composant` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `composition_equipe`
--

DROP TABLE IF EXISTS `composition_equipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `composition_equipe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_equipe` int NOT NULL,
  `id_developpeur` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `composition_equipe_developpeur_id_fk` (`id_developpeur`),
  KEY `composition_equipe_equipe_id_fk` (`id_equipe`),
  CONSTRAINT `composition_equipe_developpeur_id_fk` FOREIGN KEY (`id_developpeur`) REFERENCES `developpeur` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `composition_equipe_equipe_id_fk` FOREIGN KEY (`id_equipe`) REFERENCES `equipe` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=167 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `composition_equipe`
--

LOCK TABLES `composition_equipe` WRITE;
INSERT INTO `composition_equipe` VALUES (142,121,2),(143,121,5),(144,121,4),(158,131,1),(159,131,2),(165,134,5),(166,135,1);
UNLOCK TABLES;

--
-- Table structure for table `developpeur`
--

DROP TABLE IF EXISTS `developpeur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `developpeur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_collaborateur` int NOT NULL,
  `competence` enum('1','2','3') NOT NULL,
  `indice_production` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_collaborateur` (`id_collaborateur`),
  CONSTRAINT `developpeur_collaborateur_id_fk` FOREIGN KEY (`id_collaborateur`) REFERENCES `collaborateur` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `developpeur`
--

LOCK TABLES `developpeur` WRITE;
INSERT INTO `developpeur` VALUES (1,3,'1',10),(2,6,'3',20),(4,8,'2',7),(5,12,'3',30);
UNLOCK TABLES;

--
-- Table structure for table `equipe`
--

DROP TABLE IF EXISTS `equipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `equipe` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_chef_de_projet` int NOT NULL,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `equipe_chef_projet_id_fk` (`id_chef_de_projet`),
  CONSTRAINT `equipe_chef_projet_id_fk` FOREIGN KEY (`id_chef_de_projet`) REFERENCES `chef_de_projet` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipe`
--

LOCK TABLES `equipe` WRITE;
INSERT INTO `equipe` VALUES (121,2,'C\'est Comment'),(131,1,'C\'est Comment'),(134,9,'test modif'),(135,2,'BONJOUR');
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_application` int NOT NULL,
  `libelle` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `libelle` (`libelle`),
  KEY `module_application_id_fk` (`id_application`),
  CONSTRAINT `module_application_id_fk` FOREIGN KEY (`id_application`) REFERENCES `application` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
UNLOCK TABLES;

--
-- Table structure for table `projet`
--

DROP TABLE IF EXISTS `projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projet` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_client` int NOT NULL,
  `id_developpeur` int DEFAULT NULL,
  `id_chef_de_projet` int DEFAULT NULL,
  `type` enum('1','2','3') NOT NULL,
  `id_application` int DEFAULT NULL,
  `id_module` int DEFAULT NULL,
  `id_composant` int DEFAULT NULL,
  `prix` int NOT NULL,
  `statut` enum('0','1','2','3','4') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `projet_chef_de_projet_id_fk` (`id_chef_de_projet`),
  KEY `projet_developpeur_id_fk` (`id_developpeur`),
  KEY `projet_client_id_fk` (`id_client`),
  KEY `projet_application_id_fk` (`id_application`),
  KEY `projet_composant_id_fk` (`id_composant`),
  KEY `projet_module_id_fk` (`id_module`),
  CONSTRAINT `projet_application_id_fk` FOREIGN KEY (`id_application`) REFERENCES `application` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `projet_chef_de_projet_id_fk` FOREIGN KEY (`id_chef_de_projet`) REFERENCES `chef_de_projet` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `projet_client_id_fk` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `projet_composant_id_fk` FOREIGN KEY (`id_composant`) REFERENCES `composant` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `projet_developpeur_id_fk` FOREIGN KEY (`id_developpeur`) REFERENCES `developpeur` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `projet_module_id_fk` FOREIGN KEY (`id_module`) REFERENCES `module` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projet`
--

LOCK TABLES `projet` WRITE;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-29 17:43:05
