-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Erstellungszeit: 24. Jun 2021 um 16:08
-- Server-Version: 10.4.18-MariaDB
-- PHP-Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `greenroom`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `description`, `crdate`, `tstamp`, `deleted_at`) VALUES
(1, 'Fleischfressende Pflanzen', 'fleischfressende-pflanzen', 'Fleischfressende Pflanzen (Karnivoren) sind ganz außergewöhnlich, denn sie nehmen die zum Wachstum notwendigen Nährstoffe nicht aus dem Substrat auf, sondern durch das Fangen und Verdauen von Kleinstlebewesen, wie z.B. Mücken, Ameisen und Fliegen. Fleischfressende Pflanzen lassen sich durch ihre verschiedenen Fallentypen unterscheiden: Es gibt Klappfallen wie bei der Venusfliegenfalle (Dionaea muscipula). Diese exotische Zimmerpflanze hat ihre Blätter zu einer Klappfalle umgebildet, die bei Berührung der Kontakthärchen zuschnappt. Klebfallen wie bei Sonnentau (Drosera) und Fallgruben wie bei den Schlauchpflanzen (Sarracenia) und Kannenpflanzen (Nepenthes) sind weitere Fallentypen.', '2021-06-06 21:00:43', '2021-06-06 21:00:43', NULL),
(2, 'Luftreinigende Pflanzen', 'luftreinigende-pflanzen', 'Luftreinigende Pflanzen sehen nicht nur dekorativ aus, sie haben noch weitere, positive Auswirkungen. Diese Zimmerpflanzen filtern schädliche Umweltstoffe aus der Luft, produzieren Sauerstoff und und unterstützen so das Raumklima. Die Dieffenbachia Camilla gehört zu den luftreinigenden Pflanzen und schmückt mit ihren 2-farbigen Blättern Wohnräume und Büros. Sie ist so beliebt, weil sie anspruchslos gedeiht und zum perfekten Begleiter im Alltag wird. ', '2021-06-06 21:13:16', '2021-06-06 21:13:16', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `secondname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `zip` varchar(255) NOT NULL,
  `alt_firstname` varchar(255) DEFAULT NULL,
  `alt_secondname` varchar(255) DEFAULT NULL,
  `alt_phone` varchar(255) DEFAULT NULL,
  `alt_address` varchar(255) DEFAULT NULL COMMENT 'Lieferadresse falls die Rechnungsadresse anders ist',
  `alt_city` varchar(255) DEFAULT NULL COMMENT 'Lieferadresse falls die Rechnungsadresse anders ist',
  `alt_zip` varchar(255) DEFAULT NULL COMMENT 'Lieferadresse falls die Rechnungsadresse anders ist',
  `products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'Produkte werden in ein JSON gespeichert, um den derzeitigen Stand der Produkte zu speichern sprich Preis, usw' CHECK (json_valid(`products`)),
  `status` enum('offen','bezahlt','in Bearbeitung','versandbereit','abgeschlossen','storniert','Storno beantragt') DEFAULT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `firstname`, `secondname`, `email`, `phone`, `address`, `city`, `zip`, `alt_firstname`, `alt_secondname`, `alt_phone`, `alt_address`, `alt_city`, `alt_zip`, `products`, `status`, `crdate`, `tstamp`, `deleted_at`) VALUES
(18, 4, 'Admin', 'test', 'admin@greenroom.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2}]', 'offen', '2021-06-22 19:39:21', '2021-06-22 19:39:21', NULL),
(19, NULL, 'Lorenzs', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2}]', 'abgeschlossen', '2021-06-22 20:19:16', '2021-06-22 21:04:38', NULL),
(20, 4, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2}]', 'offen', '2021-06-22 20:36:38', '2021-06-22 20:54:48', NULL),
(21, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'Storno beantragt', '2021-06-22 21:16:46', '2021-06-22 22:00:42', NULL),
(22, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 16:43:54', '2021-06-23 16:43:54', NULL),
(23, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'versandbereit', '2021-06-23 16:45:51', '2021-06-23 18:58:39', NULL),
(24, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 16:47:11', '2021-06-23 16:47:11', NULL),
(25, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 16:47:37', '2021-06-23 17:51:09', NULL),
(26, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'Storno beantragt', '2021-06-23 16:55:45', '2021-06-23 16:59:09', NULL),
(27, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":4},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 16:59:22', '2021-06-23 21:23:35', NULL),
(28, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":4},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'in Bearbeitung', '2021-06-23 17:00:00', '2021-06-23 18:59:03', NULL),
(29, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":4},{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 17:10:00', '2021-06-23 17:10:00', NULL),
(30, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', NULL, NULL, NULL, NULL, NULL, NULL, '[{\"id\":12,\"name\":\"Aloe Vera\",\"price\":400,\"quantity\":2}]', 'offen', '2021-06-23 19:10:48', '2021-06-23 19:10:48', NULL),
(31, 5, 'Lorenz', 'Windisch', 'lorenz.windisch@chello.at', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', '[{\"id\":11,\"name\":\"Jutathip Soper\",\"price\":300,\"quantity\":2}]', 'offen', '2021-06-23 20:08:20', '2021-06-23 20:08:20', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `pictures`
--

CREATE TABLE `pictures` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `path` text NOT NULL,
  `alttext` text DEFAULT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tstamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `pictures`
--

INSERT INTO `pictures` (`id`, `name`, `path`, `alttext`, `crdate`, `tstamp`, `deleted_at`) VALUES
(1, 'Juthatip-Soper-12cm-etiket.jpg', 'pictures/products', NULL, '2021-06-08 18:54:26', '2021-06-08 18:54:26', NULL),
(2, 'Juthatip_soper_Sarracenia_square_1500_1200x1200.jpg', 'pictures/products', NULL, '2021-06-08 20:58:05', '2021-06-08 20:58:05', NULL),
(4, '1181_Juthatip_soper_Sarracenia_square_1500_1200x1200.jpg', 'pictures/products', NULL, '2021-06-08 20:58:05', '2021-06-08 20:58:05', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `highlight_picture` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(9,2) NOT NULL,
  `category` int(11) NOT NULL,
  `watering` enum('gering','mittel','oft') NOT NULL COMMENT 'Wasserbedarf der Pflanze',
  `sun_location` enum('Sonne','Halber Schatten','Voller Schatten') NOT NULL COMMENT 'Bedarf der Sonne anhand des Standortes der Pflanze',
  `size` int(11) NOT NULL COMMENT 'maximale Wachstumsgröße in cm',
  `stock` int(11) DEFAULT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`id`, `name`, `slug`, `highlight_picture`, `description`, `price`, `category`, `watering`, `sun_location`, `size`, `stock`, `crdate`, `tstamp`, `deleted_at`) VALUES
(11, 'Jutathip Soper', 'jutathip-sopers', 1, 'Eine fleischfressende Pflanze der Extraklasse für Haus oder Büro! Die winterharte Schlauchpflanze Jutathip Soper (Sarracenia), auch Trompetenpflanzen oder Trompetenblatt, stammt aus der Gattung fleischfressender Pflanzen. Bei dieser sehr seltenen Art werden die Blätter zu bizarren und leuchtend rosa Schläuchen umgewandelt. Am oberen Schlauchrand befindet sich eine glatte Oberfläche mit kleinen Rippen, die senkrecht nach unten verlaufen. Wenn die Insekten auf diese Fläche geraten, können sie nicht mehr entwischen und fallen in den Schlauch. Die Insekten werden durch die stacheligen Fühlborsten immer weiter in das Falleninnere gedrängt und letztendlich dort durch die Verdauungssäfte verdaut. So zieht sich die Schlauchpflanze Jutathip Soper alle wichtigsten Nährstoffe aus dem Insekt.\r\n\r\nStellen Sie die winterharte Schlauchpflanzen Jutathip Soper an einen warmen und hellen Platz, aber schützen Sie die Blätter vor direkten Sonnenstrahlen. Da diese Karnivoren ziemlich viel Kälte vertragen, können sie auch draußen im Freien stehen. Die Erde darf konstant recht feucht sein, denn Sarracenia wächst ursprünglich in sumpfigen Gebieten. Tipp: Stellen Sie den Topf auf einen Untersetzer, in dem ständig etwas Wasser steht. (Sarracenia Jutathip Soper)\r\n\r\nDie Lieferung erfolgt ohne Übertopf.', '300.00', 2, 'mittel', 'Halber Schatten', 71, 10, '2021-06-06 21:10:56', '2021-06-23 23:30:21', NULL),
(12, 'Aloe Vera', 'aloe-vera', 1, 'Die Aloe Vera ist eine dekorative, immergrüne Zierpflanze, die wegen ihres wertvollen Gels schon seit Jahrtausenden geschätzt wird. Auch heute ist sie noch wegen den natürlichen, gelartigen Substanzen, welche die dickfleischigen Blätter in sich tragen, voll im Trend. Das Aloe Vera-Gel besitzt wertvolle Inhaltsstoffe und wird u.a. zur Haut- und Haarpflege genutzt. Die sukkulente Pflanze, die ein wenig an Kakteen erinnert, wird weltweit in tropischen und subtropischen Regionen kultiviert. Als Zimmerpflanze ist die Aloe Vera (Aloe barbadensis Miller), die auch als Wüstenlilie bekannt ist, in unseren Breiten in der Wohnung und im Büro sehr leicht zu kultivieren.\r\n\r\nDie Aloe Vera bevorzugt einen gleichmäßig warmen Standort mit viel Licht & wenig Feuchtigkeit. Im Sommer steht sie gerne im Freien, wo sich Ihre Blätter unter der Sonneneinstrahlung rötlich-grau färben können. Im Winter müssen Sie die Pflanze ins Haus holen, denn Kälte und Frost toleriert sie nicht. Die Aloe-Vera-Pflanze bzw. Wüstenlilie ist durch ihren wertvollen Saft bekannt, wird aber auch als dekorative, exotische & pflegeleichte Pflanze im Topf & Kübel sehr geschätzt. (Aloe barbadensis Miller)\r\n\r\nDie Lieferung erfolgt ohne Übertopf.', '400.00', 2, 'gering', 'Voller Schatten', 50, 20, '2021-06-06 21:14:30', '2021-06-23 23:17:25', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products_pictures_map`
--

CREATE TABLE `products_pictures_map` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `picture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `products_pictures_map`
--

INSERT INTO `products_pictures_map` (`id`, `product_id`, `picture_id`) VALUES
(52, 12, 2),
(53, 12, 1),
(54, 11, 1),
(58, 11, 2);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `secondname` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT NULL,
  `crdate` timestamp NOT NULL DEFAULT current_timestamp(),
  `tstamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `secondname`, `phone`, `address`, `city`, `zip`, `is_admin`, `crdate`, `tstamp`, `deleted_at`) VALUES
(4, 'admin@greenroom.at', '$2y$10$Kz0FF2MgV./DsED7K.9cGuh38xrQ7C8.7iBdlJ5xKVkyRycNE4dOC', '', '', '', '', '', '', 1, '2021-06-09 20:24:06', '2021-06-20 09:33:12', NULL),
(5, 'lorenz.windisch@chello.at', '$2y$10$Kz0FF2MgV./DsED7K.9cGuh38xrQ7C8.7iBdlJ5xKVkyRycNE4dOC', 'Lorenz', 'Windisch', '06764201439', 'Heinrich Collin-Straße 8-14/14/3', 'Wien', '1140', 0, '2021-06-10 19:02:12', '2021-06-22 16:41:28', NULL);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indizes für die Tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `[slug]` (`slug`),
  ADD KEY `category` (`category`),
  ADD KEY `highlight_picture` (`highlight_picture`);

--
-- Indizes für die Tabelle `products_pictures_map`
--
ALTER TABLE `products_pictures_map`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT für Tabelle `pictures`
--
ALTER TABLE `pictures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `products_pictures_map`
--
ALTER TABLE `products_pictures_map`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`highlight_picture`) REFERENCES `pictures` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
