-- phpMyAdmin SQL Dump
-- version 4.2.1deb1
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 28 mei 2014 om 21:44
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
-- Tabelstructuur voor tabel `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `index` varchar(25) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
  `appid_lock` tinyint(4) NOT NULL,
  `hidden` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `library`
--

CREATE TABLE IF NOT EXISTS `library` (
`library_id` int(11) NOT NULL,
  `css_url` varchar(255) NOT NULL,
  `js_url` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Gegevens worden geëxporteerd voor tabel `library`
--

INSERT INTO `library` (`library_id`, `css_url`, `js_url`) VALUES
(1, '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/css/jquery-ui.min.css', '//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js'),
(2, '', '//cdnjs.cloudflare.com/ajax/libs/Chart.js/0.2.0/Chart.min.js'),
(3, '', 'js/autocorrect.php'),
(4, '', 'js/add.js'),
(5, '', 'js/checkall.js'),
(6, '', 'js/statuses.js');

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
  `glyphicon` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=79 ;

--
-- Gegevens worden geëxporteerd voor tabel `menu`
--

INSERT INTO `menu` (`id`, `parent_id`, `page`, `scope`, `options`, `title`, `glyphicon`) VALUES
(50, 1, 'overzicht', '', '', 'Summary', 'glyphicon-stats'),
(51, 1, 'history', '', '', 'History', 'fa fa-history'),
(54, 1, 'purchases', '', '', 'Purchases', 'glyphicon-shopping-cart'),
(57, 61, 'games', 'uncompleted', '', 'Uncompleted games', 'glyphicon-exclamation-sign'),
(58, 61, 'games', 'completed', '', 'Completed games', 'glyphicon-ok-sign'),
(59, 0, 'add', '', '', 'Add', 'glyphicon-plus'),
(61, 1, 'games', 'all', '', 'Games', 'glyphicon-play'),
(62, 1, 'dlc', 'all', '', 'DLC', 'glyphicon-download'),
(63, -1, 'modifygame', '', '', 'Modify game', ''),
(64, -1, 'games', 'purchase', '', 'Games in purchase', ''),
(66, -1, 'modifypurchase', '', '', 'Modify purchase', ''),
(67, -1, 'modifydlc', '', '', 'Modify DLC', ''),
(68, 62, 'dlc', 'uncompleted', '', 'Uncompleted DLC', 'glyphicon-exclamation-sign'),
(69, 62, 'dlc', 'completed', '', 'Completed DLC', 'glyphicon-ok-sign'),
(70, -1, 'dlc', 'game', '', 'DLC in game', ''),
(71, 0, 'steam', '', '', 'Steam', 'fa fa-steam'),
(72, 71, 'steam', '', '&amp;syncappids', 'Link games with Steam', 'glyphicon-link'),
(73, 71, 'steam', '', '&amp;syncplaytime', 'Sync playtime with Steam', 'glyphicon-time'),
(74, 71, 'steam', '', '&amp;syncicons', 'Retrieve icons/logos', 'glyphicon-picture'),
(75, 71, 'steam', '', '&amp;addgames', 'Import games from Steam', 'glyphicon-import'),
(76, 0, 'settings', '', '', 'Settings', 'glyphicon-wrench'),
(77, 61, 'games', 'orphaned', '', 'Orphaned games', 'fa fa-chain-broken'),
(78, 71, 'steam', '', '&amp;refreshuserstats', 'Refresh user stats', 'glyphicon-refresh');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
`purchase_id` int(11) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `valuta` char(1) NOT NULL,
  `date` date DEFAULT NULL,
  `note` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`status_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Gegevens worden geëxporteerd voor tabel `status`
--

INSERT INTO `status` (`status_id`, `name`, `completed`, `color`) VALUES
(1, 'Untouched', 0, '#c0392b'),
(2, 'Started playing', 0, '#f1c40f'),
(3, 'Finished', 1, '#2ecc71'),
(4, 'Finished campaign', 1, '#27ae60'),
(5, 'Multiplayer/AI only', 1, '#f39c12'),
(6, 'Gave up', 0, '#e74c3c'),
(7, 'Prequel not finished yet', 0, '#e67e22');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `xref_menu_library`
--

CREATE TABLE IF NOT EXISTS `xref_menu_library` (
  `menu_id` int(11) NOT NULL,
  `library_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `xref_menu_library`
--

INSERT INTO `xref_menu_library` (`menu_id`, `library_id`) VALUES
(50, 2),
(59, 1),
(59, 3),
(59, 4),
(54, 5),
(57, 5),
(58, 5),
(61, 5),
(62, 5),
(68, 5),
(69, 5),
(70, 5),
(64, 5),
(76, 5),
(76, 6);

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
-- Indexen voor tabel `cache`
--
ALTER TABLE `cache`
 ADD PRIMARY KEY (`index`);

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
 ADD PRIMARY KEY (`id`), ADD KEY `parent_id` (`parent_id`);

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
-- Indexen voor tabel `xref_menu_library`
--
ALTER TABLE `xref_menu_library`
 ADD KEY `library_id` (`library_id`), ADD KEY `menu_id` (`menu_id`);

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
MODIFY `dlc_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `game`
--
ALTER TABLE `game`
MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `history`
--
ALTER TABLE `history`
MODIFY `history_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT voor een tabel `library`
--
ALTER TABLE `library`
MODIFY `library_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT voor een tabel `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT voor een tabel `purchase`
--
ALTER TABLE `purchase`
MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;
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
-- Beperkingen voor tabel `xref_menu_library`
--
ALTER TABLE `xref_menu_library`
ADD CONSTRAINT `xref_menu_library_ibfk_2` FOREIGN KEY (`library_id`) REFERENCES `library` (`library_id`),
ADD CONSTRAINT `xref_menu_library_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`id`);

--
-- Beperkingen voor tabel `xref_purchase_game`
--
ALTER TABLE `xref_purchase_game`
ADD CONSTRAINT `xref_purchase_game_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchase` (`purchase_id`),
ADD CONSTRAINT `xref_purchase_game_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `game` (`game_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
