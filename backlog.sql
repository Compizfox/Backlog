-- phpMyAdmin SQL Dump
-- version 4.2.1deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 24 mei 2014 om 23:51
-- Serverversie: 5.5.37-1
-- PHP-versie: 5.5.12-2

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
`dlc_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `note` varchar(255) CHARACTER SET latin1 NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `game`
--

CREATE TABLE IF NOT EXISTS `game` (
`game_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `notes` varchar(255) CHARACTER SET latin1 NOT NULL,
  `appid` int(11) DEFAULT NULL,
  `playtime` int(11) NOT NULL,
  `img_icon_url` varchar(40) DEFAULT NULL,
  `img_logo_url` varchar(40) DEFAULT NULL,
  `appid_lock` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=280 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `history`
--

CREATE TABLE IF NOT EXISTS `history` (
`history_id` int(11) NOT NULL,
  `game_id` int(11) DEFAULT NULL,
  `dlc_id` int(11) DEFAULT NULL,
  `old_status` int(11) NOT NULL,
  `new_status` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `library`
--

CREATE TABLE IF NOT EXISTS `library` (
`library_id` int(11) NOT NULL,
  `css_url` varchar(255) NOT NULL,
  `js_url` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `page` varchar(255) CHARACTER SET latin1 NOT NULL,
  `scope` varchar(25) NOT NULL,
  `options` varchar(25) NOT NULL,
  `title` varchar(255) CHARACTER SET latin1 NOT NULL,
  `glyphicon` varchar(255) NOT NULL,
  `library_id` int(11) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=76 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
`purchase_id` int(11) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `valuta` char(1) NOT NULL,
  `date` date NOT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`status_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `color` varchar(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `xref_purchase_game`
--

CREATE TABLE IF NOT EXISTS `xref_purchase_game` (
  `purchase_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `dlc`
--
ALTER TABLE `dlc`
 ADD PRIMARY KEY (`dlc_id`), ADD KEY `status_id` (`status_id`), ADD KEY `game_id` (`game_id`);

--
-- Indexen voor tabel `game`
--
ALTER TABLE `game`
 ADD PRIMARY KEY (`game_id`), ADD KEY `status_id` (`status_id`);

--
-- Indexen voor tabel `history`
--
ALTER TABLE `history`
 ADD PRIMARY KEY (`history_id`), ADD KEY `game_id` (`game_id`), ADD KEY `dlc_id` (`dlc_id`), ADD KEY `old_status` (`old_status`), ADD KEY `new_status` (`new_status`);

--
-- Indexen voor tabel `library`
--
ALTER TABLE `library`
 ADD PRIMARY KEY (`library_id`);

--
-- Indexen voor tabel `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`), ADD KEY `parent_id` (`parent_id`), ADD KEY `libraries` (`library_id`);

--
-- Indexen voor tabel `purchase`
--
ALTER TABLE `purchase`
 ADD PRIMARY KEY (`purchase_id`);

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`status_id`);

--
-- Indexen voor tabel `xref_purchase_game`
--
ALTER TABLE `xref_purchase_game`
 ADD KEY `purchase_id` (`purchase_id`,`game_id`), ADD KEY `game_id` (`game_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `dlc`
--
ALTER TABLE `dlc`
MODIFY `dlc_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `game`
--
ALTER TABLE `game`
MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=280;
--
-- AUTO_INCREMENT voor een tabel `history`
--
ALTER TABLE `history`
MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT voor een tabel `library`
--
ALTER TABLE `library`
MODIFY `library_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT voor een tabel `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=76;
--
-- AUTO_INCREMENT voor een tabel `purchase`
--
ALTER TABLE `purchase`
MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
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
-- Beperkingen voor tabel `menu`
--
ALTER TABLE `menu`
ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`);

--
-- Beperkingen voor tabel `xref_purchase_game`
--
ALTER TABLE `xref_purchase_game`
ADD CONSTRAINT `xref_purchase_game_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`),
ADD CONSTRAINT `xref_purchase_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
