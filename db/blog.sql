SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+01:00";

CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `blog`;

CREATE TABLE `commenti` (
  `id` int(11) NOT NULL,
  `testo` varchar(255) NOT NULL,
  `data_commento` varchar(255) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `commenti`;
INSERT INTO `commenti` (`id`, `testo`, `data_commento`, `id_utente`, `id_post`) VALUES
(6, 'Sono Prova2 ciao Prova1', '2024-05-23 04:10:33', 31, 36),
(7, 'Ciao', '2024-05-23 04:13:46', 32, 36),
(8, 'Ciao', '2024-05-23 04:13:51', 32, 37),
(9, 'per me è un 8', '2024-05-23 04:26:47', 30, 39),
(10, 'no è almeno un 9', '2024-05-23 04:27:14', 31, 39),
(11, 'ma a sto punto facciamo 10', '2024-05-23 04:27:57', 32, 39);

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `likes`;
INSERT INTO `likes` (`id`, `id_utente`, `id_post`) VALUES
(67, 31, 36),
(68, 32, 36),
(69, 32, 37),
(70, 32, 38),
(71, 33, 39),
(72, 30, 39),
(73, 31, 39),
(74, 32, 39);

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `passworld` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `login`;
INSERT INTO `login` (`id`, `email`, `username`, `passworld`) VALUES
(30, 'prova1@gmail.com', 'Prova1', 'Proviamolo.1'),
(31, 'prova2@gmail.com', 'Prova2', 'Proviamolo.2'),
(32, 'prova3@gmail.com', 'Prova3', 'Proviamolo.3'),
(33, 'prova4@gmail.com', 'Prova4', 'Proviamolo.4');

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `titolo` varchar(30) NOT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `media` varchar(255) DEFAULT NULL,
  `id_utente` int(11) NOT NULL,
  `data_post` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `post`;
INSERT INTO `post` (`id`, `titolo`, `descrizione`, `media`, `id_utente`, `data_post`) VALUES
(36, 'Prova1', 'Proviamolo\'1', 'media/discord-banner-discord-profile.gif', 30, '2024-05-23 04:08:01'),
(37, 'Prova2', 'Proviaml\'2', 'media/equazioni differenziali.png', 31, '2024-05-23 04:11:38'),
(38, 'Prova3', 'non la prenda a male per favore professore è un test', 'media/video0_45.mp4', 32, '2024-05-23 04:14:22'),
(39, 'LEGGA TUTTO PER FAVORE', 'Allora professore per stanchezza e altro, all\'ultima verifica ho preso un 4 e 1/2 e ora mi tocca recuperarlo all\'ultimo quindi speravo in un voto alto come può vedere dall\'orario di creazione dei post e commenti per finire solo le limitate funzioni attual', '', 33, '2024-05-23 04:24:43');

CREATE TABLE `userdata` (
  `id` int(11) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE `userdata`;
INSERT INTO `userdata` (`id`, `banner`, `descrizione`, `idUser`) VALUES
(10, 'banner/cd864f8bface494eba853c3bb43180b0.webp', 'Proviamolo1', 30),
(11, 'banner/picX.png', 'Sono Prova2 ciao', 31),
(12, 'banner/Screenshot 2022-12-10 at 18-05-38 Iruma Shocks Bachiko Welcome to Demon School! Iruma-kun Season 3 - YouTube.png', 'un account particolare mi scusi e tutto fatto per la scienza', 32),
(13, 'banner/default.png', NULL, 33);


ALTER TABLE `commenti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_post` (`id_post`);

ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`),
  ADD KEY `id_post` (`id_post`);

ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_utente` (`id_utente`);

ALTER TABLE `userdata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idUser` (`idUser`);


ALTER TABLE `commenti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

ALTER TABLE `userdata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;


ALTER TABLE `commenti`
  ADD CONSTRAINT `commenti_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `commenti_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `login` (`id`);

ALTER TABLE `userdata`
  ADD CONSTRAINT `userdata_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `login` (`id`);
