-- phpMyAdmin SQL Dump
-- version 3.4.9deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Erstellungszeit: 14. Feb 2012 um 21:34
-- Server Version: 5.1.58
-- PHP-Version: 5.3.10-1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `es-matrix`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `environment`
--

CREATE TABLE IF NOT EXISTS `environment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) NOT NULL,
  `version_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_agent` (`user_agent`),
  UNIQUE KEY `name` (`name`),
  KEY `version_id` (`version_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `feature`
--

CREATE TABLE IF NOT EXISTS `feature` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(512) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `edition` varchar(3) DEFAULT NULL,
  `section` varchar(25) DEFAULT NULL,
  `section_urn` varchar(25) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=266 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `implementation`
--

CREATE TABLE IF NOT EXISTS `implementation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sortorder` int(10) unsigned DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `acronym` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `testcase_id` int(10) unsigned NOT NULL,
  `env_id` int(10) unsigned NOT NULL COMMENT 'Host environment ID',
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `testcase_id` (`testcase_id`,`env_id`),
  KEY `environment_id` (`env_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Test results' AUTO_INCREMENT=16930 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `testcase`
--

CREATE TABLE IF NOT EXISTS `testcase` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` int(10) unsigned NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `code` text NOT NULL,
  `quoted` tinyint(1) DEFAULT NULL,
  `alt_type` varchar(50) DEFAULT NULL COMMENT 'alternative type attribute value',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `feature_id` (`feature_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2091 ;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `version`
--

CREATE TABLE IF NOT EXISTS `version` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `impl_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(25) NOT NULL,
  `safe` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `implementation_id` (`impl_id`,`name`),
  KEY `fk_version_implementation1` (`impl_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `environment`
--
ALTER TABLE `environment`
  ADD CONSTRAINT `environment_ibfk_1` FOREIGN KEY (`version_id`) REFERENCES `version` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `result`
--
ALTER TABLE `result`
  ADD CONSTRAINT `result_ibfk_4` FOREIGN KEY (`env_id`) REFERENCES `environment` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `result_ibfk_3` FOREIGN KEY (`testcase_id`) REFERENCES `testcase` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `testcase`
--
ALTER TABLE `testcase`
  ADD CONSTRAINT `testcase_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `version`
--
ALTER TABLE `version`
  ADD CONSTRAINT `version_ibfk_2` FOREIGN KEY (`impl_id`) REFERENCES `implementation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
