-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mag 14, 2024 alle 04:02
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

-- --------------------------------------------------------

--
-- Struttura della tabella `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passworld` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `login`
--

INSERT INTO `login` (`id`, `email`, `username`, `passworld`) VALUES
(1, 'fortnitesciopp@gmail.com', 'lol', 'lol'),
(3, 'lociceromanfredi.9@gmail.com', 'lol', 'lol'),
(4, 'lolMANFREDI04ok@gmail.com', 'lol', ''),
(5, 'francsmanuel@msn.com', 'dsgsg', ''),
(6, 'svgsv@sgsv.vos', 'lol', 'Eddddddddfdg.34'),
(7, 'sjhf@hdk.com', 'khfds', ''),
(8, 'ciao@gmail.com', 'ciao', ''),
(9, 'lolMANFREDIeff04ok@gmail.com', 'lol', ''),
(10, 'lolMANFREDffsI04ok@gmail.com', 'lol_of_king', ''),
(11, '', '', ''),
(12, 'ciafeso@gmail.com', 'confirmPass', 'Coccodrillo.7'),
(13, 'francesco@gmail.com', 'ciicio pasticcio', '19Agosto$'),
(14, 'lolMANFREDI04hhok@gmail.com', 'Coccodrillo', 'Coccodrillo.00'),
(15, 'lol@gmail.com', 'lol_of_king', 'Lollica.00'),
(16, 'dgsrfh@hd.vopj', 'd5ujh.gdP08', 'd5ujh.gdP08'),
(17, 'wd@gg.ff', 'Coccodrillo', 'isValid.00');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
