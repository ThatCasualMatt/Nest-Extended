-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2014 at 09:01 AM
-- Server version: 5.1.73-cll
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `matth41_nestdb`
--
CREATE DATABASE IF NOT EXISTS `matth41_nestdb` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `matth41_nestdb`;

-- --------------------------------------------------------

--
-- Table structure for table `energy_reports`
--

CREATE TABLE IF NOT EXISTS `energy_reports` (
  `date` date NOT NULL,
  `total_heating_time` int(11) NOT NULL,
  `heating_degree_days` int(11) NOT NULL,
  `total_cooling_time` int(11) NOT NULL,
  `cooling_degree_days` int(11) NOT NULL,
  `total_fan_time` int(11) NOT NULL,
  `total_humidifier_time` int(11) NOT NULL,
  `total_dehumidifier_time` int(11) NOT NULL,
  `leafs` int(11) NOT NULL,
  `recent_avg_used` int(11) NOT NULL,
  `usage_over_avg` int(11) NOT NULL,
  UNIQUE KEY `date` (`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `nest`
--

CREATE TABLE IF NOT EXISTS `nest` (
  `log_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `location` int(5) NOT NULL,
  `outside_temp` decimal(4,1) NOT NULL,
  `outside_humidity` tinyint(3) NOT NULL,
  `away_status` tinyint(1) NOT NULL,
  `leaf_status` tinyint(1) NOT NULL,
  `current_temp` decimal(4,1) NOT NULL,
  `current_humidity` tinyint(2) NOT NULL,
  `temp_mode` varchar(50) NOT NULL,
  `low_target_temp` decimal(4,1) NOT NULL,
  `high_target_temp` decimal(4,1) NOT NULL,
  `time_to_target` int(11) NOT NULL,
  `target_humidity` tinyint(2) NOT NULL,
  `heat_on` tinyint(1) NOT NULL,
  `humidifier_on` tinyint(1) NOT NULL,
  `ac_on` tinyint(1) NOT NULL,
  `fan_on` tinyint(1) NOT NULL,
  `battery_level` decimal(4,3) NOT NULL,
  `is_online` tinyint(1) NOT NULL,
  UNIQUE KEY `log_datetime` (`log_datetime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
