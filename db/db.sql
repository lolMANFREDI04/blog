CREATE DATABASE  IF NOT EXISTS `borg`;
USE `borg`;

--
-- Table structure for table `commenti`
--

DROP TABLE IF EXISTS `commenti`;

CREATE TABLE `commenti` (
  `id` int NOT NULL AUTO_INCREMENT,
  `testo` varchar(255) NOT NULL,
  `data_commento` varchar(255) NOT NULL,
  `id_utente` int NOT NULL,
  `id_post` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_post` (`id_post`),
  KEY `id_utente` (`id_utente`),
  CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`),
  CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`)
);


--
-- Dumping data for table `commenti`
--

LOCK TABLES `commenti` WRITE;

INSERT INTO `commenti` VALUES (6,'ciao','2024-05-17 10:47:59',18,4);

UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;

CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_utente` int NOT NULL,
  `id_post` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_post` (`id_post`),
  CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`),
  CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`)
);

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;

UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;

CREATE TABLE `login` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `passworld` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
);

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;

INSERT INTO `login` VALUES (18,'fortnitesciopp@gmail.com','lol','Coccodrillo.00'),(19,'lociceromanfredi.9@gmail.com','Manfredi Lo Cicero','Alfabeto.00');

UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titolo` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `descrizione` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `media` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_utente` int NOT NULL,
  `data_post` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`)
);

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;

INSERT INTO `post` VALUES (4,'VHGCMV','TFJHC','media/Immagine 2024-01-18 180857.png',18,'2024-05-17 10:47:49'),(6,'casv','','media/Mom Meets Peter Dinklage..?.mp4',18,'2024-05-17 10:55:02');

UNLOCK TABLES;

--
-- Table structure for table `userdata`
--

DROP TABLE IF EXISTS `userdata`;

CREATE TABLE `userdata` (
  `id` int NOT NULL AUTO_INCREMENT,
  `banner` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `descrizione` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `idUser` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`),
  CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `login` (`id`)
);

--
-- Dumping data for table `userdata`
--

LOCK TABLES `userdata` WRITE;

INSERT INTO `userdata` VALUES (4,'banner/WIN_20231023_14_24_42_Pro.jpg','',18),(5,'banner/default.png',NULL,19);

UNLOCK TABLES;

-- Dump completed on 2024-05-17 19:05:56
