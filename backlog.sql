-- phpMyAdmin SQL Dump
-- version 4.1.14deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 18 mei 2014 om 03:03
-- Serverversie: 5.5.37-1
-- PHP-versie: 5.5.12-1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `backlog`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `dlc`
--

CREATE TABLE IF NOT EXISTS `dlc` (
  `dlc_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `note` varchar(255) CHARACTER SET latin1 NOT NULL,
  `game_id` int(11) NOT NULL,
  PRIMARY KEY (`dlc_id`),
  KEY `status_id` (`status_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `game_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `notes` varchar(255) CHARACTER SET latin1 NOT NULL,
  `appid` int(11) DEFAULT NULL,
  `playtime` int(11) NOT NULL,
  `img_icon_url` varchar(40) DEFAULT NULL,
  `img_logo_url` varchar(40) DEFAULT NULL,
  `appid_lock` tinyint(4) NOT NULL,
  PRIMARY KEY (`game_id`),
  KEY `status_id` (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `history_id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) DEFAULT NULL,
  `dlc_id` int(11) DEFAULT NULL,
  `old_status` int(11) NOT NULL,
  `new_status` int(11) NOT NULL,
  PRIMARY KEY (`history_id`),
  KEY `game_id` (`game_id`),
  KEY `dlc_id` (`dlc_id`),
  KEY `old_status` (`old_status`),
  KEY `new_status` (`new_status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `page` varchar(255) CHARACTER SET latin1 NOT NULL,
  `scope` varchar(25) NOT NULL,
  `options` varchar(25) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `glyphicon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `purchase_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `valuta` char(1) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) NOT NULL,
  PRIMARY KEY (`purchase_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `color` varchar(6) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `xref_purchase_game`
--

CREATE TABLE IF NOT EXISTS `xref_purchase_game` (
  `purchase_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  KEY `purchase_id` (`purchase_id`,`game_id`),
  KEY `game_id` (`game_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `dlc`
--
ALTER TABLE `dlc`
  ADD CONSTRAINT `dlc_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `dlc_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);

--
-- Beperkingen voor tabel `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `status` (`status_id`);

--
-- Beperkingen voor tabel `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`),
  ADD CONSTRAINT `history_ibfk_2` FOREIGN KEY (`dlc_id`) REFERENCES `dlc` (`dlc_id`),
  ADD CONSTRAINT `history_ibfk_3` FOREIGN KEY (`old_status`) REFERENCES `status` (`status_id`),
  ADD CONSTRAINT `history_ibfk_4` FOREIGN KEY (`new_status`) REFERENCES `status` (`status_id`);

--
-- Beperkingen voor tabel `xref_purchase_game`
--
ALTER TABLE `xref_purchase_game`
  ADD CONSTRAINT `xref_purchase_game_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`),
  ADD CONSTRAINT `xref_purchase_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
