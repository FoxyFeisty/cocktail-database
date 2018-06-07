-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 07. Jun 2018 um 15:02
-- Server Version: 5.5.33
-- PHP-Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `cocktails`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `basis`
--

CREATE TABLE `basis` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `basis`
--

INSERT INTO `basis` (`id`, `name`) VALUES
(1, 'Rum'),
(2, 'Whiskey'),
(3, 'Gin'),
(4, 'Wodka'),
(5, 'Champagner'),
(6, 'Sonstige');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `cocktail`
--

CREATE TABLE `cocktail` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `basis_id` varchar(25) NOT NULL,
  `kategorie_id` int(10) unsigned NOT NULL,
  `geschmack_id` int(10) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `bild` varchar(150) DEFAULT NULL,
  `hintergrund` text,
  `rezept` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zutaten_sammlung` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `zutat_id_2` (`basis_id`),
  UNIQUE KEY `kategorie_id` (`kategorie_id`),
  UNIQUE KEY `geschmack_id` (`geschmack_id`),
  KEY `zutat_id` (`basis_id`),
  KEY `basis_id` (`basis_id`),
  KEY `basis_id_2` (`basis_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `cocktail`
--

INSERT INTO `cocktail` (`id`, `basis_id`, `kategorie_id`, `geschmack_id`, `name`, `bild`, `hintergrund`, `rezept`, `created_at`, `zutaten_sammlung`) VALUES
(1, '6', 7, 2, 'Pisco Sour', 'pisco-sour-1.jpg', 'Genau wie beim Pisco selbst, so streiten sich auch beim Signature Drink der Spirituosen-Kategorie Chile und Peru um den Ursprung. So behaupten noch heute einige Chilenen, dass Elliot Stubb den Drink 1872 in Iquique erfunden hat. Das beruht allerdings auf einem Übersetzungsfehler – zwar war Elliot Stubb um diese Zeit tatsächlich in Iquique, erfunden hat er allerdings den Whiskey Sour. Und selbst wenn er schon damals die Idee für den Twist gehabt hätte: Iquique fiel erst 1879 an Chile, davor gehörte es zu Peru. Nach einhelliger Expertenmeinung entwickelte der Bartender Victor Morris den Pisco Sour in den 1920er Jahren in seiner Morris Bar in Lima. Wohlgemerkt aber als Twist auf den Whiskey Sour von Elliot Stubb, die Verwandschaft lässt sich nicht wegdiskutieren. Morris‘ Version war jedoch noch eine sehr simple, die ohne Eiweiß und Cocktail Bitters auskam. Beides fügte erst sein Angestellter Mario Bruiget einige Jahre später dem Rezept hinzu. ', '1. Limette in zwei Hälften teilen und den Saft auspressen. 30 ml Limettensaft entspricht in etwa dem Saft einer Limette.\r\n2. Den Pisco (peruanischer Traubenbrand), Limettensaft, Zuckersirup und das Eiweiß in einen Cocktailshaker geben.\r\n3. Eine Handvoll Eiswürfel dazugeben, und den Inhalt kräftig mind. 30 Sekunden lang schütteln.\r\n4. Den Inhalt in ein Cocktailglas abseihen (alternativ auch gerne z.B. ein Weißweinglas nehmen).\r\n5. Ein paar Spritzer des Cocktail Bitters auf den Eischaum geben, um dem Pisco Sour eine würzige Dimension zu verleihen.', '2018-05-31 10:23:57', '60, 2, 7 / 30, 2, 8 / 20, 2, 9 / 0.5, 5, 10 / 3, 6, 11'),
(4, '3', 1, 5, 'Bramble', NULL, 'Der Bramble wurde in den 1980ern in London von Dick Bradsell erfunden. Er war das Resultat einer Cocktail-Trendwelle, welche durch die damalige Barszene rollte. Der erste Bramble wurde damals 1984 im Freds Club, einer Bar in Downtown, serviert.\r\n', '1. Zunächst die Brombeeren in den Tumbler geben und mit einem Stößel leicht zerdrücken.\r\n2. Anschließend den Tumbler mit Crushed Ice oder Eiswürfeln auffüllen\r\n3. Alle flüssigen Zutaten, also Gin, Zitronensaft & Zuckersirup in den Tumbler füllen und mit einem Barlöffel umrühren.\r\n4. Nach Belieben mit 1-2 Brombeeren dekorieren und fertig.', '2018-06-04 09:30:04', '5, 1, 15 / 2, 1, 12 / 1, 1, 9 / , 7, 14 / 6-8, 5, 13');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheiten`
--

CREATE TABLE `einheiten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `einheiten`
--

INSERT INTO `einheiten` (`id`, `name`) VALUES
(1, 'cl'),
(2, 'ml'),
(3, 'l'),
(4, 'g'),
(5, 'Stk.'),
(6, 'Spr.'),
(7, '');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `geschmack`
--

CREATE TABLE `geschmack` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Daten für Tabelle `geschmack`
--

INSERT INTO `geschmack` (`id`, `name`) VALUES
(1, 'Süß'),
(2, 'Sour'),
(3, 'Würzig'),
(4, 'Trocken'),
(5, 'Fruchtig');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`id`, `name`) VALUES
(1, 'Aperitif'),
(2, 'Digestif'),
(3, 'Longdrink'),
(4, 'Tropical'),
(5, 'Sonstige'),
(6, 'Shortdrink'),
(7, 'Sour');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `rezepte`
--

CREATE TABLE `rezepte` (
  `cocktail_id` int(10) unsigned NOT NULL,
  `menge` varchar(10) NOT NULL,
  `einheit_id` int(10) unsigned NOT NULL,
  `zutat_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `rezepte`
--

INSERT INTO `rezepte` (`cocktail_id`, `menge`, `einheit_id`, `zutat_id`) VALUES
(1, '60', 2, 7),
(1, '30', 2, 8),
(1, '20', 2, 9),
(1, '0.5', 5, 10),
(1, '3', 6, 11);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zutaten`
--

CREATE TABLE `zutaten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Daten für Tabelle `zutaten`
--

INSERT INTO `zutaten` (`id`, `name`) VALUES
(7, 'Pisco'),
(8, 'Limettensaft'),
(9, 'Zuckersirup'),
(10, 'Eiweiß'),
(11, 'Bitters'),
(12, 'Zitronensaft'),
(13, 'Brombeeren'),
(14, 'Crushed Ice'),
(15, 'Gin');

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `cocktail`
--
ALTER TABLE `cocktail`
  ADD CONSTRAINT `cocktail_ibfk_2` FOREIGN KEY (`kategorie_id`) REFERENCES `kategorie` (`id`),
  ADD CONSTRAINT `cocktail_ibfk_3` FOREIGN KEY (`geschmack_id`) REFERENCES `geschmack` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
