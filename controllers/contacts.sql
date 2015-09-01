-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Φιλοξενητής: 127.0.0.1:8631
-- Χρόνος δημιουργίας: 01 Σεπ 2015 στις 18:38:56
-- Έκδοση διακομιστή: 5.6.25
-- Έκδοση PHP: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `contacts`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `addressid` int(11) NOT NULL,
  `countryid` int(11) DEFAULT NULL,
  `cityid` int(11) DEFAULT NULL,
  `regionid` int(11) DEFAULT NULL,
  `locationid` int(11) DEFAULT NULL,
  `comments` text,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `aliases`
--

CREATE TABLE IF NOT EXISTS `aliases` (
  `aliasid` int(11) NOT NULL,
  `alias` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `cityid` int(11) NOT NULL,
  `city` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `countryid` int(11) NOT NULL,
  `country` varchar(15) NOT NULL,
  `phonecode` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `locations`
--

CREATE TABLE IF NOT EXISTS `locations` (
  `locationid` int(11) NOT NULL,
  `location` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `userid` int(11) NOT NULL,
  `REMOTE_ADDR` varchar(100) DEFAULT NULL,
  `REMOTE_PORT` varchar(10) DEFAULT NULL,
  `HTTP_USER_AGENT` varchar(255) DEFAULT NULL,
  `REQUEST_URI` varchar(100) NOT NULL,
  `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `persons`
--

CREATE TABLE IF NOT EXISTS `persons` (
  `personid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) DEFAULT NULL,
  `imgFileId` int(11) unsigned NOT NULL COMMENT 'Image file id',
  `sex` varchar(6) NOT NULL,
  `birthday` date DEFAULT NULL,
  `comments` text,
  `number_of_childs` int(11) NOT NULL DEFAULT '0',
  `motherid` int(11) DEFAULT NULL,
  `fatherid` int(11) DEFAULT NULL,
  `added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `got_alias` bit(1) NOT NULL,
  `got_address` bit(1) NOT NULL DEFAULT b'0',
  `got_phone` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `phones`
--

CREATE TABLE IF NOT EXISTS `phones` (
  `phoneid` int(11) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `type` int(1) NOT NULL,
  `personid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `regions`
--

CREATE TABLE IF NOT EXISTS `regions` (
  `regionid` int(11) NOT NULL,
  `region` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `relationid` int(11) NOT NULL,
  `table1` varchar(10) NOT NULL,
  `table2` varchar(10) NOT NULL,
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `relations_reltype`
--

CREATE TABLE IF NOT EXISTS `relations_reltype` (
  `relationid` int(11) NOT NULL,
  `reltypeid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `reltypes`
--

CREATE TABLE IF NOT EXISTS `reltypes` (
  `reltypeid` int(11) NOT NULL,
  `reltype` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `userid` int(11) NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `option_value` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `streets`
--

CREATE TABLE IF NOT EXISTS `streets` (
  `streetid` int(11) NOT NULL,
  `street` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `streetsnum`
--

CREATE TABLE IF NOT EXISTS `streetsnum` (
  `relationid` int(11) NOT NULL,
  `streetnum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `upload`
--

CREATE TABLE IF NOT EXISTS `upload` (
  `fileId` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `type` varchar(30) NOT NULL,
  `size` int(11) NOT NULL,
  `content` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpass` varchar(32) NOT NULL,
  `confid` varchar(35) DEFAULT NULL,
  `register_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `REGISTER_REMOTE_ADDR` varchar(100) NOT NULL,
  `REGISTER_REMOTE_PORT` varchar(10) NOT NULL,
  `REGISTER_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `CURRENT_REMOTE_ADDR` varchar(100) NOT NULL,
  `CURRENT_HTTP_USER_AGENT` varchar(255) NOT NULL,
  `lastactive` varchar(35) DEFAULT NULL,
  `active` varchar(35) NOT NULL,
  `got_person` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`addressid`);

--
-- Ευρετήρια για πίνακα `aliases`
--
ALTER TABLE `aliases`
  ADD PRIMARY KEY (`aliasid`);

--
-- Ευρετήρια για πίνακα `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`cityid`),
  ADD UNIQUE KEY `city` (`city`) USING BTREE;

--
-- Ευρετήρια για πίνακα `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`countryid`),
  ADD UNIQUE KEY `country` (`country`);

--
-- Ευρετήρια για πίνακα `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`locationid`),
  ADD UNIQUE KEY `location` (`location`);

--
-- Ευρετήρια για πίνακα `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`personid`);

--
-- Ευρετήρια για πίνακα `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`phoneid`,`personid`),
  ADD KEY `PHONE` (`phone`) USING BTREE;

--
-- Ευρετήρια για πίνακα `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`regionid`),
  ADD UNIQUE KEY `region` (`region`);

--
-- Ευρετήρια για πίνακα `relations`
--
ALTER TABLE `relations`
  ADD PRIMARY KEY (`relationid`);

--
-- Ευρετήρια για πίνακα `reltypes`
--
ALTER TABLE `reltypes`
  ADD PRIMARY KEY (`reltypeid`);

--
-- Ευρετήρια για πίνακα `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`userid`,`option_name`);

--
-- Ευρετήρια για πίνακα `streets`
--
ALTER TABLE `streets`
  ADD PRIMARY KEY (`streetid`),
  ADD UNIQUE KEY `street` (`street`);

--
-- Ευρετήρια για πίνακα `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`fileId`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `addresses`
--
ALTER TABLE `addresses`
  MODIFY `addressid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `aliases`
--
ALTER TABLE `aliases`
  MODIFY `aliasid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `cities`
--
ALTER TABLE `cities`
  MODIFY `cityid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `countries`
--
ALTER TABLE `countries`
  MODIFY `countryid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `locations`
--
ALTER TABLE `locations`
  MODIFY `locationid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `persons`
--
ALTER TABLE `persons`
  MODIFY `personid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `phones`
--
ALTER TABLE `phones`
  MODIFY `phoneid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `regions`
--
ALTER TABLE `regions`
  MODIFY `regionid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `relations`
--
ALTER TABLE `relations`
  MODIFY `relationid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `reltypes`
--
ALTER TABLE `reltypes`
  MODIFY `reltypeid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `streets`
--
ALTER TABLE `streets`
  MODIFY `streetid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `upload`
--
ALTER TABLE `upload`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
