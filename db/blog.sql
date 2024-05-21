-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 21, 2024 alle 18:13
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Struttura della tabella `commenti`
--

CREATE TABLE IF NOT EXISTS `commenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `testo` varchar(255) NOT NULL,
  `data_commento` varchar(255) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_post` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `commenti`
--

INSERT INTO `commenti` (`id`, `testo`, `data_commento`, `id_utente`, `id_post`) VALUES
(1, 'koiph', '2024-05-17 20:43:54', 22, 8),
(3, 'giuseeeeeeeeee', '2024-05-18 09:00:29', 25, 8);

-- --------------------------------------------------------

--
-- Struttura della tabella `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `id_post` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`),
  KEY `id_post` (`id_post`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `likes`
--

INSERT INTO `likes` (`id`, `id_utente`, `id_post`) VALUES
(13, 23, 9),
(37, 22, 9),
(40, 25, 14),
(41, 25, 9),
(42, 25, 8),
(44, 25, 16);

-- --------------------------------------------------------

--
-- Struttura della tabella `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passworld` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `login`
--

INSERT INTO `login` (`id`, `email`, `username`, `passworld`) VALUES
(22, 'provaBlog1@gmail.com', 'provaBlo', 'provaBlog.1'),
(23, 'lolMANFREDI04ok@gmail.com', 'Coccodrillo', 'Animeworld: 0'),
(24, 'francescopolizzi080206@gmail.c', 'Pippobaudogay', 'Coccodrillo006$'),
(25, 'lociceromanfredi.9@gmail.com', 'Coccodrillo', 'Animeworld: 0');

-- --------------------------------------------------------

--
-- Struttura della tabella `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titolo` varchar(30) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `id_utente` int(11) NOT NULL,
  `data_post` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_utente` (`id_utente`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `post`
--

INSERT INTO `post` (`id`, `titolo`, `descrizione`, `media`, `id_utente`, `data_post`) VALUES
(8, 'hlukh', 'jlòoijh', 'media/20201213175850n562a.jpg', 22, '2024-05-17 20:43:45'),
(9, 'agra', 'fae\'fAE', NULL, 22, '2024-05-17 20:55:49'),
(14, 'new-post\'gva', '\'\'fef', 'media/supermavco.png', 22, '2024-05-17 22:51:58'),
(15, 'new-post', '', 'media/pagurro.jpg', 25, '2024-05-18 09:01:59'),
(16, 'dio cane', '', 'media/dario e la palestra.png', 25, '2024-05-18 09:03:06');

-- --------------------------------------------------------

--
-- Struttura della tabella `userdata`
--

CREATE TABLE IF NOT EXISTS `userdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` varchar(255) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `userdata`
--

INSERT INTO `userdata` (`id`, `banner`, `descrizione`, `idUser`) VALUES
(3, 'banner/20201213175850n562a.jpg', 'jkiì\'\'', 22),
(4, 'banner/default.png', NULL, 23),
(5, 'banner/Screenshot_2020-09-17 Deca-Dence Episodio 11 Streaming Download SUB ITA - AnimeWorld(1).png', 'la figa pelosa e bella ', 25);

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `commenti`
--
ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Limiti per la tabella `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Limiti per la tabella `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`);

--
-- Limiti per la tabella `userdata`
--
ALTER TABLE `userdata`
  ADD CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `login` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
