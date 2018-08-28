
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `nssc`
--

-- --------------------------------------------------------

--
-- Table structure for table `manufacturer`
--

CREATE TABLE IF NOT EXISTS `manufacturer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `featured` int(2) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `manufacturer`
--

INSERT INTO `manufacturer` (`id`, `name`, `featured`) VALUES
(1, 'ABB', 0),
(2, 'ABB (Power-One)', 0),
(3, 'Amphanol', 0),
(4, 'AXITEC', 0),
(5, 'BURNDY', 0),
(6, 'Canadian Solar', 0),
(7, 'CHINT Power Systems (CPS) America', 0),
(8, 'COOPER B-Line', 0),
(9, 'Cooper Industries (Bussmann)', 0),
(10, 'CSUN', 0),
(11, 'DARFON', 0),
(12, 'Deka', 0),
(13, 'Eaton Cutler-Hammer', 0),
(14, 'Ecolibrium Solar', 0),
(15, 'eGauge', 0),
(16, 'EGAUGE', 0),
(17, 'Enphase Energy', 0),
(19, 'SSR', 9),
(20, 'Lightway', 0),
(21, 'HYUNDAI', 0),
(22, 'LG', 0),
(23, 'ReneSola', 0),
(24, 'SolarWorld', 0),
(25, 'Suniva', 0),
(26, 'SIEMENS', 0),
(27, 'NEP', 0),
(28, 'SolarEdge Technologies', 0),
(29, 'Fronius', 0),
(30, 'KACO New Energy', 0),
(31, 'Schneider Electric', 0),
(32, 'IronRidge', 0),
(33, 'Quick Mount PV', 0),
(34, 'QuickMount', 0),
(35, 'SunEdison', 0),
(36, 'Amphenol', 0),
(37, 'Multi-Contact', 0),
(38, 'Rennsteig Tools, Inc.', 0),
(39, 'MERSEN-FERRAZ', 0),
(40, 'Schneider Electric (Square-D)', 0),
(41, 'SOL-BARE', 0),
(42, 'TITAN WIRE AND CABLE', 0),
(43, 'SolaDeck', 0),
(44, 'Hellermann Tyton', 0),
(45, 'Seaward', 0),
(46, 'OMG', 7),
(47, 'WINAICO', 8),
(48, 'Trina Solar', 0),
(49, 'Talesun', 0),
(50, 'Sollega', 8),
(51, 'Hallermann Tyton', 0),
(52, 'UNIRAC ', 0),
(53, 'Huawei', 0),
(54, 'Wiley', 0),
(55, 'Oatey', 0),
(56, 'Hanwha Q-Cells', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `manufacturer`
--
ALTER TABLE `manufacturer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `manufacturer`
--
ALTER TABLE `manufacturer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=57;