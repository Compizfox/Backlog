SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `dlc` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `note` varchar(255) CHARACTER SET latin1 NOT NULL,
  `game_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `dlc_purchase` (
  `purchase_id` int(11) NOT NULL,
  `dlc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status_id` int(11) NOT NULL,
  `note` varchar(255) CHARACTER SET latin1 NOT NULL,
  `appid` int(11) DEFAULT NULL,
  `playtime` int(11) NOT NULL,
  `img_icon_url` varchar(40) DEFAULT NULL,
  `img_logo_url` varchar(40) DEFAULT NULL,
  `appid_lock` tinyint(4) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `game_purchase` (
  `purchase_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `playthroughs` (
  `id` int(11) NOT NULL,
  `playable_id` int(11) NOT NULL,
  `playable_type` varchar(25) NOT NULL,
  `started_at` date DEFAULT NULL,
  `ended_at` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `note` varchar(255) NOT NULL,
  `ended` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `shop` varchar(255) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `valuta` char(1) NOT NULL,
  `note` varchar(255) NOT NULL,
  `purchased_at` date DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `color` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `statuses` (`id`, `name`, `completed`, `color`) VALUES
(1, 'Untouched', 0, '#c0392b'),
(2, 'Started playing', 0, '#f1c40f'),
(3, 'Finished', 1, '#2ecc71'),
(4, 'Finished campaign', 1, '#27ae60'),
(5, 'Multiplayer/AI only', 1, '#f39c12'),
(6, 'Gave up', 0, '#e74c3c'),
(7, 'Prequel not finished yet', 0, '#e67e22'),
(8, 'Savegame lost/corrupt', 0, '#000000');


ALTER TABLE `dlc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `game_id` (`game_id`);

ALTER TABLE `dlc_purchase`
  ADD KEY `purchase_id` (`purchase_id`),
  ADD KEY `dlc_id` (`dlc_id`);

ALTER TABLE `games`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD UNIQUE KEY `appid` (`appid`),
  ADD KEY `status_id` (`status_id`);

ALTER TABLE `game_purchase`
  ADD KEY `purchase_id` (`purchase_id`,`game_id`),
  ADD KEY `game_id` (`game_id`);

ALTER TABLE `playthroughs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `playable_id` (`playable_id`,`playable_type`);

ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `dlc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `playthroughs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `dlc`
  ADD CONSTRAINT `dlc_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`),
  ADD CONSTRAINT `dlc_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`);

ALTER TABLE `dlc_purchase`
  ADD CONSTRAINT `dlc_purchase_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dlc_purchase_ibfk_2` FOREIGN KEY (`dlc_id`) REFERENCES `dlc` (`id`) ON DELETE CASCADE;

ALTER TABLE `games`
  ADD CONSTRAINT `games_ibfk_2` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`);

ALTER TABLE `game_purchase`
  ADD CONSTRAINT `game_purchase_ibfk_1` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `game_purchase_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
