SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS login;
CREATE TABLE login (
  id int(11) NOT NULL,
  email varchar(30) NOT NULL,
  username varchar(30) NOT NULL,
  passworld varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE login;
INSERT INTO login (id, email, username, passworld) VALUES
(1, 'fortnitesciopp@gmail.com', 'lol_of_king', 'CucinottaCoglione.00'),
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

DROP TABLE IF EXISTS post;
CREATE TABLE post (
  id int(11) NOT NULL,
  titolo varchar(30) NOT NULL,
  descrizione varchar(255) DEFAULT NULL,
  media varchar(255) DEFAULT NULL,
  id_utente int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE post;
INSERT INTO post (id, titolo, descrizione, media, id_utente) VALUES
(1, 'sgsg', 'sgsg', 'sgsgs', 1);

DROP TABLE IF EXISTS userdata;
CREATE TABLE userdata (
  id int(11) NOT NULL,
  banner varchar(255) DEFAULT NULL,
  descrizione varchar(255) DEFAULT NULL,
  idUser int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

TRUNCATE TABLE userdata;
INSERT INTO userdata (id, banner, descrizione, idUser) VALUES
(1, 'banner/lol_of_king-logo.png', 'no', 1),
(2, 'banner/test.jpg', '', 3),
(3, 'banner/lol_of_king-logo.png', 'no', 15);


ALTER TABLE login
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY email (email);

ALTER TABLE post
  ADD PRIMARY KEY (id),
  ADD KEY id_utente (id_utente);

ALTER TABLE userdata
  ADD PRIMARY KEY (id),
  ADD KEY idUser (idUser);


ALTER TABLE login
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE post
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE userdata
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE post
  ADD CONSTRAINT post_ibfk_1 FOREIGN KEY (id_utente) REFERENCES login (id);

ALTER TABLE userdata
  ADD CONSTRAINT userdata_ibfk_1 FOREIGN KEY (idUser) REFERENCES login (id);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
