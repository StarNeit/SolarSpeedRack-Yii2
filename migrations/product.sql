
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `nssc`
--

-- --------------------------------------------------------

--
-- Table structure for table `price`
--

CREATE TABLE IF NOT EXISTS `price` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `min` int(4) NOT NULL DEFAULT '1',
  `max` int(4) NOT NULL DEFAULT '0',
  `price` decimal(14,2) NOT NULL,
  `sale_price` decimal(14,2) DEFAULT NULL,
  `pro_percent` int(3) DEFAULT '8',
  `elite_percent` int(3) DEFAULT '5'
) ENGINE=InnoDB AUTO_INCREMENT=6913 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `features` text,
  `specifications` text,
  `videos` text,
  `downloads` text,
  `estimated_handling_time` varchar(50) DEFAULT NULL,
  `minimum_order` int(4) NOT NULL DEFAULT '1',
  `manufacturer_id` int(11) DEFAULT NULL,
  `manufacturer_product_code` varchar(100) DEFAULT NULL,
  `code` varchar(100) DEFAULT NULL,
  `shared_compatible` tinyint(1) NOT NULL DEFAULT '1',
  `standard_compatible` tinyint(1) NOT NULL DEFAULT '1',
  `on_sale` tinyint(1) NOT NULL DEFAULT '0',
  `sale_start` date DEFAULT NULL,
  `sale_end` date DEFAULT NULL,
  `msrp` varchar(20) DEFAULT NULL,
  `nmfc` varchar(20) DEFAULT NULL,
  `package_type` varchar(20) NOT NULL DEFAULT 'Boxes',
  `category_id` int(11) DEFAULT NULL,
  `sub_category_id` int(11) DEFAULT NULL,
  `is_inverter` tinyint(1) DEFAULT '0',
  `is_roof_attachment` tinyint(1) DEFAULT '0',
  `calculate_per_foot` tinyint(1) DEFAULT '0',
  `free_shipping` tinyint(1) DEFAULT '1',
  `pdf` varchar(255) DEFAULT NULL,
  `pdf2` varchar(255) DEFAULT NULL,
  `pdf3` varchar(255) DEFAULT NULL,
  `cad` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `rating` decimal(4,2) NOT NULL DEFAULT '0.00',
  `class` varchar(6) NOT NULL DEFAULT '50',
  `hazardous` tinyint(1) NOT NULL DEFAULT '0',
  `commodity_type` varchar(32) NOT NULL DEFAULT 'GeneralMerchandise',
  `content_type` varchar(32) NOT NULL DEFAULT 'NewCommercialGoods',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `current_stock` int(11) DEFAULT '0',
  `handling_id` int(11) DEFAULT '1',
  `reference_url` text,
  `product_link` text,
  `need_shipping` tinyint(1) DEFAULT '1',
  `need_tax` tinyint(1) DEFAULT '1',
  `order` int(2) DEFAULT '0',
  `available_stock` int(6) NOT NULL DEFAULT '999999'
) ENGINE=InnoDB AUTO_INCREMENT=2626 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `extension` varchar(250) DEFAULT NULL,
  `file_name` varchar(250) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2841 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_metadata`
--

CREATE TABLE IF NOT EXISTS `product_metadata` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `length` varchar(20) DEFAULT NULL,
  `width` varchar(20) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `quantity_per_box` varchar(20) DEFAULT NULL,
  `box_weight` varchar(20) DEFAULT NULL,
  `rated_power` varchar(20) DEFAULT NULL,
  `cell_technology_id` int(11) DEFAULT NULL,
  `frame_color` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2626 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_category`
--

CREATE TABLE IF NOT EXISTS `product_sub_category` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `price`
--
ALTER TABLE `price`
  ADD PRIMARY KEY (`id`), ADD KEY `price_product_id` (`product_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`), ADD KEY `product_category_id` (`category_id`), ADD KEY `product_create_user_id` (`created_by`), ADD KEY `product_update_user_id` (`updated_by`), ADD KEY `product_scompany_id` (`company_id`), ADD KEY `product_handling_config_id` (`handling_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`), ADD KEY `image_product_id` (`product_id`), ADD KEY `product_image_create_user_id` (`created_by`), ADD KEY `product_image_update_user_id` (`updated_by`);

--
-- Indexes for table `product_metadata`
--
ALTER TABLE `product_metadata`
  ADD PRIMARY KEY (`id`), ADD KEY `meta_product_id` (`product_id`);

--
-- Indexes for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  ADD PRIMARY KEY (`id`), ADD KEY `sub_cat_id` (`category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `price`
--
ALTER TABLE `price`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6913;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2626;
--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2841;
--
-- AUTO_INCREMENT for table `product_metadata`
--
ALTER TABLE `product_metadata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2626;
--
-- AUTO_INCREMENT for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `price`
--
ALTER TABLE `price`
ADD CONSTRAINT `price_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_metadata`
--
ALTER TABLE `product_metadata`
ADD CONSTRAINT `meta_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `product_sub_category`
--
ALTER TABLE `product_sub_category`
ADD CONSTRAINT `sub_cat_id` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`);
