-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 05. Jun 2018 um 14:46
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
(1, '6', 5, 2, 'Pisco Sour', 'pisco-sour-1.jpg', 'Aus Peru und halt einfach ein Klassiker.\r\nKann man gut in Delft trinken.', '60 ml Pisco\r\n30 ml Limettensaft\r\n20 ml Zuckersirup\r\n0.5 Stk. Eiweiß\r\n3 Spr. Amargo Chuncho Bitters\r\n\r\n', '2018-05-31 10:23:57', '[60, 2, 7], [30, 2, 8], [20, 2, 9], [0.5, 5, 10], [3, 6, 11]'),
(4, '3', 1, 5, 'Bramble', NULL, 'Der Bramble wurde in den 1980ern in London von Dick Bradsell erfunden. Er war das Resultat einer Cocktail-Trendwelle, welche durch die damalige Barszene rollte. Der erste Bramble wurde damals 1984 im Freds Club, einer Bar in Downtown, serviert.\r\n', '5cl Gin\r\n2cl Zitronensaft\r\n1cl Zuckersirup\r\nCrushed Eis oder Eiswürfel\r\n5-6 Brombeeren zum Zerstampfen\r\n1-2 Brombeeren zur Dekoration', '2018-06-04 09:30:04', '[5, 1, 15], [2, 1, 12], [1, 1, 9], ['''', '''', 14], [6-8, 5, 13]');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `einheiten`
--

CREATE TABLE `einheiten` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `einheit` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `einheiten`
--

INSERT INTO `einheiten` (`id`, `einheit`) VALUES
(1, 'cl'),
(2, 'ml'),
(3, 'l'),
(4, 'g'),
(5, 'Stk.'),
(6, 'Spr.');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Daten für Tabelle `kategorie`
--

INSERT INTO `kategorie` (`id`, `name`) VALUES
(1, 'Aperitif'),
(2, 'Digestif'),
(3, 'Longdrink'),
(4, 'Tropical'),
(5, 'Sonstige'),
(6, 'Shortdrink');

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
