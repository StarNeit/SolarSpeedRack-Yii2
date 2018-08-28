-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2017 at 10:23 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `nssc`
--

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` int(1) NOT NULL DEFAULT '1',
  `company_id` int(11) NOT NULL,
  `requested_categories` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `access` text
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `user_id`, `type`, `company_id`, `requested_categories`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`, `access`) VALUES
(5, 21, 1, 7, 'PV Panel', 21, NULL, 1443648981, 1443648981, 1, NULL),
(6, 24, 1, 8, 'Racking', 24, NULL, 1444754679, 1444754679, 1, NULL),
(13, 36, 1, 14, 'PV Panel, Racking', 36, NULL, 1450718217, 1450718217, 1, NULL),
(14, 54, 1, 18, NULL, 54, NULL, 1462225455, 1462225455, 1, ';;'),
(16, 57, 1, 20, NULL, 57, NULL, 1462562675, 1462562675, 1, ';;'),
(17, 156, 1, 22, 'Permit Packages', 156, NULL, 1465944737, 1465944737, 1, ';;'),
(18, 166, 1, 23, NULL, 166, NULL, 1468632544, 1468632544, 1, ';;'),
(19, 170, 1, 24, 'Racking, Modules, Inverters, BOS (Balance of System)', 170, NULL, 1468854743, 1468854743, 1, ';;');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_logo`
--

CREATE TABLE IF NOT EXISTS `supplier_logo` (
  `id` int(11) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `supplier_logo`
--

INSERT INTO `supplier_logo` (`id`, `link`, `title`, `status`) VALUES
(1, '#', 'SSR', 1),
(2, '#', 'Sollega', 1),
(3, '#', 'SnakeTray', 1),
(5, '#', 'EcoFasten', 2),
(7, '#', 'S-5', 1),
(8, '#', 'SnakeTray2', 1),
(9, '#', 'SolarWorld', 1),
(10, '#', 'OMG', 1),
(12, '#', 'ABB ', 1),
(14, '', 'Amphenol', 1),
(15, '#', 'AXITEC', 1),
(16, '#', 'Cooper Industries (Bussmann)', 1),
(17, '#', 'CSUN', 1),
(18, '#', 'DARFON', 1),
(19, '#', 'Eaton', 1),
(20, '#', 'EGAUGE', 1),
(21, '#', 'enphase', 1),
(22, '#', 'Falcon Fine Wire', 1),
(23, '#', 'Fronius', 1),
(24, '#', 'Hellermann Tyton', 1),
(25, '#', 'Hyundai', 1),
(26, '#', 'LG', 1),
(27, '#', 'Hyundai', 1),
(28, '#', 'MERSEN-Ferraz Shawmut', 1),
(29, '#', 'NEP', 1),
(30, '#', 'POWER-ONE', 1),
(31, '#', 'QuickMount', 1),
(32, '#', 'ReneSola', 1),
(33, '#', 'IronRidge', 1),
(34, '#', 'SunEdison', 1),
(35, '#', 'TITAN WIRE', 1),
(36, '#', 'SEAWARD', 1),
(37, '', 'WINAICO', 1);

-- --------------------------------------------------------

--
-- Table structure for table `s_address`
--

CREATE TABLE IF NOT EXISTS `s_address` (
  `id` int(11) NOT NULL,
  `is_default` int(1) DEFAULT '0',
  `company_id` int(11) NOT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address1` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `office_number` varchar(20) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `s_address`
--

INSERT INTO `s_address` (`id`, `is_default`, `company_id`, `first_name`, `last_name`, `address1`, `address2`, `office_number`, `contact_number`, `city`, `state`, `zip_code`, `country`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(3, 1, 5, 'renvu', 'klkhj', 'lbnm', '', '', '1121212', 'bn', 'mn', '5400', 'Brunei', NULL, 1, 1443019837, 1460319765, 1),
(5, 1, 7, 'Fisrt', 'Last', 'A', '', '', '123456', 'Santa Ana', 'CA', '1111', 'United States', NULL, NULL, 1443648981, 1443648981, 1),
(6, 1, 8, 'Shane', 'Shamloo', '2615 Orange Ave', '', '714-966-2551', '949-395-6227', 'Santa Ana', 'California', '92707', 'USA', NULL, 1, 1444754679, 1461008806, 1),
(7, 1, 9, 'William', 'Sien', '117 East Colorado Blvd.', 'Suite 600', '626-219-1600', '626-703-6247', 'Pasadena', 'California', '91105', '', NULL, 1, 1444756834, 1459889145, 1),
(13, 1, 15, 'Joseph', 'DiSanto', '153 Bowles Rd, Agawam Ma 01001', '', '413-326-1112', NULL, NULL, NULL, NULL, NULL, 1, 1, 1459797279, 1460320049, 1),
(14, 1, 1, 'Nekibur', 'R', '', '', '', NULL, NULL, NULL, NULL, NULL, 1, 1, 1460319875, 1460320323, 1),
(15, 1, 17, 'Bill Dougherty, ', 'Devon Doles', '505 Keystone Road, Southampton, PA 18966', '', '610-203-9277', NULL, NULL, NULL, NULL, NULL, 1, 16, 1460739277, 1460739277, 1),
(16, 1, 18, 'joe', 'kozicki', '27635 diaz', '', '951 206 5588', '', 'Temecula', 'ca', '92590', 'usa', NULL, 1, 1462225455, 1468635352, 1),
(17, 1, 19, 'joe', 'kozicki', '27635 diaz', '', '951 206 5588', '', 'Temecula', 'ca', '92590', 'usa', NULL, 1, 1462225517, 1468635334, 1),
(18, 1, 20, 'David', 'Bakus', '1 San Raphael', '', '9492997645', '9492997645', 'Dana Point', 'CA', '92629', '', NULL, 1, 1462562675, 1468635470, 1),
(19, 1, 21, 'Elie', 'Rothschild', '2480 Mission Street, Suite 107B ', 'San Francisco, CA 94110', '415.648.1299', NULL, NULL, NULL, NULL, NULL, 1, 16, 1463500073, 1463500073, 1),
(20, 1, 22, 'Nekibur', 'Rahman', 'A-521, Logix Technova', 'Sector-132', '+91-981-048-6837', '', 'Paris', 'VA', '201301', 'IN', NULL, NULL, 1465944737, 1465944737, 1),
(21, 1, 23, 'David', 'George', '8 UNF Drive #123', '', '', '404-312-7155', 'Jacksonville', 'FL', '32224', 'USA', NULL, 1, 1468632544, 1468635187, 1),
(22, 1, 24, 'Zachary', 'Mathie', '1007 Industrial Blvd', '', '5176299292', '5178126633', 'Albion', 'Michigan', '49224', 'United States', NULL, NULL, 1468854743, 1468854743, 1);

-- --------------------------------------------------------

--
-- Table structure for table `s_company`
--

CREATE TABLE IF NOT EXISTS `s_company` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `s_company`
--

INSERT INTO `s_company` (`id`, `name`, `email`, `created_by`, `updated_by`, `created_at`, `updated_at`, `status`) VALUES
(5, 'Renvu', 'info@renvu.com', NULL, 1, 1443019837, 1460319765, 1),
(7, 'Supplier Company', NULL, NULL, NULL, 1443648981, 1443648981, 1),
(8, 'SSR', 'info@solarspeedrack.com', NULL, 1, 1444754679, 1461008806, 1),
(9, 'Lightway Solar America, Inc.', '', NULL, 1, 1444756834, 1459889145, 2),
(15, 'OMG Roofing Products', 'JDiSanto@olyfast.com', 1, 1, 1459797279, 1460320049, 1),
(16, 'p', '', 1, 1, 1460319875, 1460320323, 2),
(17, 'WINAICO USA', 'usa@winaico.us', 1, 1, 1460739277, 1460739277, 1),
(18, 'aa solar', 'joeaasolar@msn.com', NULL, 1, 1462225455, 1468635352, 2),
(19, 'aa solar', 'joeaasolar@msn.com', NULL, 1, 1462225517, 1468635334, 2),
(20, 'Go solar Pros', 'david@gosolarpros.com', NULL, 1, 1462562675, 1468635470, 2),
(21, 'Sollega', 'elie@sollega.com', 1, 1, 1463500073, 1463500073, 1),
(22, 'Pentadesk Technologies LLP', 'info@pentadesk.com', NULL, NULL, 1465944737, 1465944737, 1),
(23, 'Intown Electric', 'David@intownelectric.com', NULL, 1, 1468632544, 1468635187, 2),
(24, 'Patriot Solar Group ', 'info@patriotsolargroup.com', NULL, NULL, 1468854743, 1468854743, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`), ADD KEY `supplier_create_user_id` (`created_by`), ADD KEY `supplier_update_user_id` (`updated_by`);

--
-- Indexes for table `supplier_logo`
--
ALTER TABLE `supplier_logo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `s_address`
--
ALTER TABLE `s_address`
  ADD PRIMARY KEY (`id`), ADD KEY `s_address_company_id` (`company_id`), ADD KEY `s_address_create_user_id` (`created_by`), ADD KEY `s_address_update_user_id` (`updated_by`);

--
-- Indexes for table `s_company`
--
ALTER TABLE `s_company`
  ADD PRIMARY KEY (`id`), ADD KEY `s_company_create_user_id` (`created_by`), ADD KEY `s_company_update_user_id` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `supplier_logo`
--
ALTER TABLE `supplier_logo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `s_address`
--
ALTER TABLE `s_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `s_company`
--
ALTER TABLE `s_company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;