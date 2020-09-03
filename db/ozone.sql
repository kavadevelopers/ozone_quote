-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 03, 2020 at 08:40 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.2.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ozone`
--

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `df` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `df`) VALUES
(1, 'Bosch', '');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `manufacturer` text NOT NULL,
  `manu_name` text NOT NULL,
  `brand` text NOT NULL,
  `main_class` text NOT NULL,
  `sub_class` text NOT NULL,
  `group` text NOT NULL,
  `part_no` text NOT NULL,
  `description` text NOT NULL,
  `gross_prod` text NOT NULL,
  `price` decimal(40,2) NOT NULL,
  `discount` decimal(40,2) NOT NULL,
  `hs_code` text NOT NULL,
  `country` text NOT NULL,
  `moq` text NOT NULL,
  `s_or_qty` text NOT NULL,
  `warranty` text NOT NULL,
  `gross_weight` text NOT NULL,
  `net_weight` text NOT NULL,
  `length` text NOT NULL,
  `width` text NOT NULL,
  `height` text NOT NULL,
  `unit_of_dimention` text NOT NULL,
  `volume` text NOT NULL,
  `volume_unit` text NOT NULL,
  `update_date` date NOT NULL,
  `df` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `manufacturer`, `manu_name`, `brand`, `main_class`, `sub_class`, `group`, `part_no`, `description`, `gross_prod`, `price`, `discount`, `hs_code`, `country`, `moq`, `s_or_qty`, `warranty`, `gross_weight`, `net_weight`, `length`, `width`, `height`, `unit_of_dimention`, `volume`, `volume_unit`, `update_date`, `df`) VALUES
(1, '1', 'Bosch', 'Bosch', 'Commercial Systems', 'Commercial Systems Electronics', 'Microphones Accessories Bosch', 'LBC1081/00', 'Microphone cable, 4-core, 100m', '1', '5000.00', '10.00', '8544499390', 'CN', '1.16', '6', '36', '4.150', '3.730', '0.308', '0.300', '0.168', 'M', '15.523', 'CD3', '2020-08-28', '');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

DROP TABLE IF EXISTS `quotation`;
CREATE TABLE IF NOT EXISTS `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quote` text NOT NULL,
  `name` text NOT NULL,
  `date` date NOT NULL,
  `year` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `quote`, `name`, `date`, `year`) VALUES
(3, '2020_1', 'ABC', '2020-08-13', '2020');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_detail`
--

DROP TABLE IF EXISTS `quotation_detail`;
CREATE TABLE IF NOT EXISTS `quotation_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `manufacturer` text NOT NULL,
  `product` text NOT NULL,
  `price` decimal(40,2) NOT NULL,
  `discount` decimal(40,2) NOT NULL,
  `margin` decimal(40,2) NOT NULL,
  `unit_price` decimal(40,2) NOT NULL,
  `qty` decimal(40,2) NOT NULL,
  `total` decimal(40,2) NOT NULL,
  `udate` date NOT NULL,
  `quotation` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `quotation_detail`
--

INSERT INTO `quotation_detail` (`id`, `manufacturer`, `product`, `price`, `discount`, `margin`, `unit_price`, `qty`, `total`, `udate`, `quotation`) VALUES
(9, '1', '1', '4000.00', '10.00', '0.00', '3600.00', '15.00', '54000.00', '2020-08-28', '3'),
(8, '1', '1', '5000.00', '10.00', '0.00', '4500.00', '10.00', '45000.00', '2020-08-28', '3');

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

DROP TABLE IF EXISTS `setting`;
CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `ref_amount` text NOT NULL,
  `cunstruction` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `name`, `ref_amount`, `cunstruction`) VALUES
(1, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_type` text NOT NULL COMMENT '0 = super admin,1 = admin,2 = back office,3 = sales person',
  `branch` text NOT NULL,
  `name` text NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `mobile` text NOT NULL,
  `gender` text NOT NULL,
  `type` text NOT NULL,
  `sidebar_isopen` tinyint(1) NOT NULL DEFAULT 1,
  `df` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_type`, `branch`, `name`, `username`, `password`, `email`, `mobile`, `gender`, `type`, `sidebar_isopen`, `df`) VALUES
(1, '0', '', 'Super User', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'kavadevelopers@gmail.com', '9898375981', 'Male', '', 1, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
