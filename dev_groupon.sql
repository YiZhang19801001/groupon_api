-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2019-01-31 07:18:25
-- 服务器版本： 10.1.36-MariaDB
-- PHP 版本： 7.0.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `dev_groupon`
--

-- --------------------------------------------------------

--
-- 表的结构 `oc_address`
--

CREATE TABLE `oc_address` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `company` varchar(40) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) NOT NULL DEFAULT '0',
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `custom_field` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_advertise_google_target`
--

CREATE TABLE `oc_advertise_google_target` (
  `advertise_google_target_id` int(11) UNSIGNED NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `campaign_name` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(2) NOT NULL DEFAULT '',
  `budget` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `feeds` text NOT NULL,
  `status` enum('paused','active') NOT NULL DEFAULT 'paused'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_api`
--

CREATE TABLE `oc_api` (
  `api_id` int(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `key` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_api_ip`
--

CREATE TABLE `oc_api_ip` (
  `api_ip_id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_api_session`
--

CREATE TABLE `oc_api_session` (
  `api_session_id` int(11) NOT NULL,
  `api_id` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_attribute`
--

CREATE TABLE `oc_attribute` (
  `attribute_id` int(11) NOT NULL,
  `attribute_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_attribute_description`
--

CREATE TABLE `oc_attribute_description` (
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_attribute_group`
--

CREATE TABLE `oc_attribute_group` (
  `attribute_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_attribute_group_description`
--

CREATE TABLE `oc_attribute_group_description` (
  `attribute_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_banner`
--

CREATE TABLE `oc_banner` (
  `banner_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_banner_image`
--

CREATE TABLE `oc_banner_image` (
  `banner_image_id` int(11) NOT NULL,
  `banner_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_cart`
--

CREATE TABLE `oc_cart` (
  `cart_id` int(11) UNSIGNED NOT NULL,
  `api_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `session_id` varchar(32) NOT NULL,
  `product_id` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `option` text NOT NULL,
  `quantity` int(5) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_category`
--

CREATE TABLE `oc_category` (
  `category_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `top` tinyint(1) NOT NULL,
  `column` int(3) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_category`
--

INSERT INTO `oc_category` (`category_id`, `image`, `parent_id`, `top`, `column`, `sort_order`, `status`, `date_added`, `date_modified`) VALUES
(1, NULL, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, NULL, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, NULL, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, NULL, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_description`
--

CREATE TABLE `oc_category_description` (
  `category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_category_description`
--

INSERT INTO `oc_category_description` (`category_id`, `language_id`, `name`, `description`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(1, 1, '汤面', '', '', '', ''),
(2, 1, '米粉', '', '', '', ''),
(3, 1, '套餐', '', '', '', ''),
(4, 1, '饮料', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_filter`
--

CREATE TABLE `oc_category_filter` (
  `category_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_path`
--

CREATE TABLE `oc_category_path` (
  `category_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_to_google_product_category`
--

CREATE TABLE `oc_category_to_google_product_category` (
  `google_product_category` varchar(10) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_to_layout`
--

CREATE TABLE `oc_category_to_layout` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_category_to_store`
--

CREATE TABLE `oc_category_to_store` (
  `category_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_country`
--

CREATE TABLE `oc_country` (
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `address_format` text NOT NULL,
  `postcode_required` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_coupon`
--

CREATE TABLE `oc_coupon` (
  `coupon_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(20) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,4) NOT NULL,
  `logged` tinyint(1) NOT NULL,
  `shipping` tinyint(1) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00',
  `uses_total` int(11) NOT NULL,
  `uses_customer` varchar(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_coupon_category`
--

CREATE TABLE `oc_coupon_category` (
  `coupon_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_coupon_history`
--

CREATE TABLE `oc_coupon_history` (
  `coupon_history_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_coupon_product`
--

CREATE TABLE `oc_coupon_product` (
  `coupon_product_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_currency`
--

CREATE TABLE `oc_currency` (
  `currency_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `code` varchar(3) NOT NULL,
  `symbol_left` varchar(12) NOT NULL,
  `symbol_right` varchar(12) NOT NULL,
  `decimal_place` char(1) NOT NULL,
  `value` double(15,8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer`
--

CREATE TABLE `oc_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `language_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `cart` text,
  `wishlist` text,
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `address_id` int(11) NOT NULL DEFAULT '0',
  `custom_field` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `safe` tinyint(1) NOT NULL,
  `token` text NOT NULL,
  `code` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_activity`
--

CREATE TABLE `oc_customer_activity` (
  `customer_activity_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `key` varchar(64) NOT NULL,
  `data` text NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_affiliate`
--

CREATE TABLE `oc_customer_affiliate` (
  `customer_id` int(11) NOT NULL,
  `company` varchar(40) NOT NULL,
  `website` varchar(255) NOT NULL,
  `tracking` varchar(64) NOT NULL,
  `commission` decimal(4,2) NOT NULL DEFAULT '0.00',
  `tax` varchar(64) NOT NULL,
  `payment` varchar(6) NOT NULL,
  `cheque` varchar(100) NOT NULL,
  `paypal` varchar(64) NOT NULL,
  `bank_name` varchar(64) NOT NULL,
  `bank_branch_number` varchar(64) NOT NULL,
  `bank_swift_code` varchar(64) NOT NULL,
  `bank_account_name` varchar(64) NOT NULL,
  `bank_account_number` varchar(64) NOT NULL,
  `custom_field` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_approval`
--

CREATE TABLE `oc_customer_approval` (
  `customer_approval_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `type` varchar(9) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_group`
--

CREATE TABLE `oc_customer_group` (
  `customer_group_id` int(11) NOT NULL,
  `approval` int(1) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_group_description`
--

CREATE TABLE `oc_customer_group_description` (
  `customer_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_history`
--

CREATE TABLE `oc_customer_history` (
  `customer_history_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_ip`
--

CREATE TABLE `oc_customer_ip` (
  `customer_ip_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_login`
--

CREATE TABLE `oc_customer_login` (
  `customer_login_id` int(11) NOT NULL,
  `email` varchar(96) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `total` int(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_online`
--

CREATE TABLE `oc_customer_online` (
  `ip` varchar(40) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `referer` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_reward`
--

CREATE TABLE `oc_customer_reward` (
  `customer_reward_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `order_id` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `points` int(8) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_search`
--

CREATE TABLE `oc_customer_search` (
  `customer_search_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `sub_category` tinyint(1) NOT NULL,
  `description` tinyint(1) NOT NULL,
  `products` int(11) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_transaction`
--

CREATE TABLE `oc_customer_transaction` (
  `customer_transaction_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_customer_wishlist`
--

CREATE TABLE `oc_customer_wishlist` (
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_custom_field`
--

CREATE TABLE `oc_custom_field` (
  `custom_field_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `value` text NOT NULL,
  `validation` varchar(255) NOT NULL,
  `location` varchar(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_custom_field_customer_group`
--

CREATE TABLE `oc_custom_field_customer_group` (
  `custom_field_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `required` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_custom_field_description`
--

CREATE TABLE `oc_custom_field_description` (
  `custom_field_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_custom_field_value`
--

CREATE TABLE `oc_custom_field_value` (
  `custom_field_value_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_custom_field_value_description`
--

CREATE TABLE `oc_custom_field_value_description` (
  `custom_field_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `custom_field_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_download`
--

CREATE TABLE `oc_download` (
  `download_id` int(11) NOT NULL,
  `filename` varchar(160) NOT NULL,
  `mask` varchar(128) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_download_description`
--

CREATE TABLE `oc_download_description` (
  `download_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_event`
--

CREATE TABLE `oc_event` (
  `event_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `trigger` text NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_extension`
--

CREATE TABLE `oc_extension` (
  `extension_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_extension_install`
--

CREATE TABLE `oc_extension_install` (
  `extension_install_id` int(11) NOT NULL,
  `extension_download_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_extension_path`
--

CREATE TABLE `oc_extension_path` (
  `extension_path_id` int(11) NOT NULL,
  `extension_install_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_filter`
--

CREATE TABLE `oc_filter` (
  `filter_id` int(11) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_filter_description`
--

CREATE TABLE `oc_filter_description` (
  `filter_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `filter_group_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_filter_group`
--

CREATE TABLE `oc_filter_group` (
  `filter_group_id` int(11) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_filter_group_description`
--

CREATE TABLE `oc_filter_group_description` (
  `filter_group_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_geo_zone`
--

CREATE TABLE `oc_geo_zone` (
  `geo_zone_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_information`
--

CREATE TABLE `oc_information` (
  `information_id` int(11) NOT NULL,
  `bottom` int(1) NOT NULL DEFAULT '0',
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_information_description`
--

CREATE TABLE `oc_information_description` (
  `information_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(64) NOT NULL,
  `description` mediumtext NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_information_to_layout`
--

CREATE TABLE `oc_information_to_layout` (
  `information_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_information_to_store`
--

CREATE TABLE `oc_information_to_store` (
  `information_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_language`
--

CREATE TABLE `oc_language` (
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(5) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `image` varchar(64) NOT NULL,
  `directory` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_layout`
--

CREATE TABLE `oc_layout` (
  `layout_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_layout_module`
--

CREATE TABLE `oc_layout_module` (
  `layout_module_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `position` varchar(14) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_layout_route`
--

CREATE TABLE `oc_layout_route` (
  `layout_route_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_length_class`
--

CREATE TABLE `oc_length_class` (
  `length_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_length_class_description`
--

CREATE TABLE `oc_length_class_description` (
  `length_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_location`
--

CREATE TABLE `oc_location` (
  `location_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `address` text NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `geocode` varchar(32) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `open` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_location`
--

INSERT INTO `oc_location` (`location_id`, `name`, `address`, `telephone`, `fax`, `geocode`, `image`, `open`, `comment`) VALUES
(1, '天府川菜馆 Yarra', '176 Toorak Road , South Yarra , VIC 3141', '(03)9078 1686', '', '', 'shop_1.jpg', '[\"2019-03-05\",\"2019-03-06\"]', ''),
(2, '天府川菜馆 Box hill', 'Level 1, 2A Cambridge Street, Box hill, VIC 3128', '(03)9041 4318', '', '', 'shop_2.jpg', '[\"2019-03-05\",\"2019-03-06\"]', ''),
(3, '天府川菜馆 Lonsdale Street', '149-155 Lonsdale Street, Melbourne VIC 3000', '(03)9662 2019', '', '', 'shop_3.jpg', '[\"2019-03-05\",\"2019-03-06\"]', '');

-- --------------------------------------------------------

--
-- 表的结构 `oc_manufacturer`
--

CREATE TABLE `oc_manufacturer` (
  `manufacturer_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_manufacturer_to_store`
--

CREATE TABLE `oc_manufacturer_to_store` (
  `manufacturer_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_marketing`
--

CREATE TABLE `oc_marketing` (
  `marketing_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `code` varchar(64) NOT NULL,
  `clicks` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_modification`
--

CREATE TABLE `oc_modification` (
  `modification_id` int(11) NOT NULL,
  `extension_install_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(64) NOT NULL,
  `author` varchar(64) NOT NULL,
  `version` varchar(32) NOT NULL,
  `link` varchar(255) NOT NULL,
  `xml` mediumtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_module`
--

CREATE TABLE `oc_module` (
  `module_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `code` varchar(32) NOT NULL,
  `setting` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_option`
--

CREATE TABLE `oc_option` (
  `option_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_option`
--

INSERT INTO `oc_option` (`option_id`, `type`, `sort_order`) VALUES
(1, 'radio', 1),
(2, 'checkbox', 2);

-- --------------------------------------------------------

--
-- 表的结构 `oc_option_description`
--

CREATE TABLE `oc_option_description` (
  `option_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_option_description`
--

INSERT INTO `oc_option_description` (`option_id`, `language_id`, `name`) VALUES
(1, 1, 'How Spicy'),
(1, 2, '辣度'),
(2, 1, 'Etra'),
(2, 2, '加料');

-- --------------------------------------------------------

--
-- 表的结构 `oc_option_value`
--

CREATE TABLE `oc_option_value` (
  `option_value_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_option_value`
--

INSERT INTO `oc_option_value` (`option_value_id`, `option_id`, `image`, `sort_order`) VALUES
(1, 1, 'spicy_1.jpg', 1),
(2, 1, 'spicy_2.jpg', 2),
(3, 1, 'spicy_3.jpg', 3),
(4, 2, '', 1),
(5, 2, '', 2),
(6, 2, '', 2);

-- --------------------------------------------------------

--
-- 表的结构 `oc_option_value_description`
--

CREATE TABLE `oc_option_value_description` (
  `option_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_option_value_description`
--

INSERT INTO `oc_option_value_description` (`option_value_id`, `language_id`, `option_id`, `name`) VALUES
(1, 1, 1, 'Hot'),
(1, 2, 1, '辣'),
(2, 1, 1, 'Medium'),
(2, 2, 1, '中辣'),
(3, 1, 1, 'Mild'),
(3, 2, 1, '微辣'),
(4, 1, 2, 'Etra Meat'),
(4, 2, 2, '加肉'),
(5, 1, 2, 'Etra Noodle'),
(5, 2, 2, '加面'),
(6, 1, 2, 'Extra Veg.'),
(6, 2, 2, '加菜蔬');

-- --------------------------------------------------------

--
-- 表的结构 `oc_order`
--

CREATE TABLE `oc_order` (
  `order_id` int(11) NOT NULL,
  `invoice_no` int(11) NOT NULL DEFAULT '0',
  `invoice_prefix` varchar(26) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `store_name` varchar(64) NOT NULL,
  `store_url` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `custom_field` text NOT NULL,
  `payment_firstname` varchar(32) NOT NULL,
  `payment_lastname` varchar(32) NOT NULL,
  `payment_company` varchar(60) NOT NULL,
  `payment_address_1` varchar(128) NOT NULL,
  `payment_address_2` varchar(128) NOT NULL,
  `payment_city` varchar(128) NOT NULL,
  `payment_postcode` varchar(10) NOT NULL,
  `payment_country` varchar(128) NOT NULL,
  `payment_country_id` int(11) NOT NULL,
  `payment_zone` varchar(128) NOT NULL,
  `payment_zone_id` int(11) NOT NULL,
  `payment_address_format` text NOT NULL,
  `payment_custom_field` text NOT NULL,
  `payment_method` varchar(128) NOT NULL,
  `payment_code` varchar(128) NOT NULL,
  `shipping_firstname` varchar(32) NOT NULL,
  `shipping_lastname` varchar(32) NOT NULL,
  `shipping_company` varchar(40) NOT NULL,
  `shipping_address_1` varchar(128) NOT NULL,
  `shipping_address_2` varchar(128) NOT NULL,
  `shipping_city` varchar(128) NOT NULL,
  `shipping_postcode` varchar(10) NOT NULL,
  `shipping_country` varchar(128) NOT NULL,
  `shipping_country_id` int(11) NOT NULL,
  `shipping_zone` varchar(128) NOT NULL,
  `shipping_zone_id` int(11) NOT NULL,
  `shipping_address_format` text NOT NULL,
  `shipping_custom_field` text NOT NULL,
  `shipping_method` varchar(128) NOT NULL,
  `shipping_code` varchar(128) NOT NULL,
  `comment` text NOT NULL,
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `order_status_id` int(11) NOT NULL DEFAULT '0',
  `affiliate_id` int(11) NOT NULL,
  `commission` decimal(15,4) NOT NULL,
  `marketing_id` int(11) NOT NULL,
  `tracking` varchar(64) NOT NULL,
  `language_id` int(11) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_value` decimal(15,8) NOT NULL DEFAULT '1.00000000',
  `ip` varchar(40) NOT NULL,
  `forwarded_ip` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `accept_language` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_order`
--

INSERT INTO `oc_order` (`order_id`, `invoice_no`, `invoice_prefix`, `store_id`, `store_name`, `store_url`, `customer_id`, `customer_group_id`, `firstname`, `lastname`, `email`, `telephone`, `fax`, `custom_field`, `payment_firstname`, `payment_lastname`, `payment_company`, `payment_address_1`, `payment_address_2`, `payment_city`, `payment_postcode`, `payment_country`, `payment_country_id`, `payment_zone`, `payment_zone_id`, `payment_address_format`, `payment_custom_field`, `payment_method`, `payment_code`, `shipping_firstname`, `shipping_lastname`, `shipping_company`, `shipping_address_1`, `shipping_address_2`, `shipping_city`, `shipping_postcode`, `shipping_country`, `shipping_country_id`, `shipping_zone`, `shipping_zone_id`, `shipping_address_format`, `shipping_custom_field`, `shipping_method`, `shipping_code`, `comment`, `total`, `order_status_id`, `affiliate_id`, `commission`, `marketing_id`, `tracking`, `language_id`, `currency_id`, `currency_code`, `currency_value`, `ip`, `forwarded_ip`, `user_agent`, `accept_language`, `date_added`, `date_modified`) VALUES
(1, 12345678, 'MELTIANFU', 1, '', '', 1, 1, '', '', '', '', '2019-03-21', '', '', '', '', '', '', '', '', '', 1, '', 1, '', '', 'alipay', '1', '', '', '', '', '', '', '', '', 1, '', 1, '', '', '', '1', '', '12.8000', 1, 1, '1.0000', 1, 'abc', 1, 1, 'AUD', '1.10000000', '', '', '', '', '2019-01-31 00:00:00', '2019-01-31 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_history`
--

CREATE TABLE `oc_order_history` (
  `order_history_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_option`
--

CREATE TABLE `oc_order_option` (
  `order_option_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_product_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_option_value_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_product`
--

CREATE TABLE `oc_order_product` (
  `order_product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `model` varchar(64) NOT NULL,
  `quantity` int(4) NOT NULL,
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `total` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `tax` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `reward` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_recurring`
--

CREATE TABLE `oc_order_recurring` (
  `order_recurring_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `recurring_name` varchar(255) NOT NULL,
  `recurring_description` varchar(255) NOT NULL,
  `recurring_frequency` varchar(25) NOT NULL,
  `recurring_cycle` smallint(6) NOT NULL,
  `recurring_duration` smallint(6) NOT NULL,
  `recurring_price` decimal(10,4) NOT NULL,
  `trial` tinyint(1) NOT NULL,
  `trial_frequency` varchar(25) NOT NULL,
  `trial_cycle` smallint(6) NOT NULL,
  `trial_duration` smallint(6) NOT NULL,
  `trial_price` decimal(10,4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_recurring_transaction`
--

CREATE TABLE `oc_order_recurring_transaction` (
  `order_recurring_transaction_id` int(11) NOT NULL,
  `order_recurring_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `amount` decimal(10,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_shipment`
--

CREATE TABLE `oc_order_shipment` (
  `order_shipment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `shipping_courier_id` varchar(255) NOT NULL DEFAULT '',
  `tracking_number` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_status`
--

CREATE TABLE `oc_order_status` (
  `order_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_total`
--

CREATE TABLE `oc_order_total` (
  `order_total_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `sort_order` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_order_voucher`
--

CREATE TABLE `oc_order_voucher` (
  `order_voucher_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `code` varchar(10) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `from_email` varchar(96) NOT NULL,
  `to_name` varchar(64) NOT NULL,
  `to_email` varchar(96) NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `amount` decimal(15,4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product`
--

CREATE TABLE `oc_product` (
  `product_id` int(11) NOT NULL,
  `model` varchar(64) NOT NULL,
  `sku` varchar(64) NOT NULL,
  `upc` varchar(12) NOT NULL,
  `ean` varchar(14) NOT NULL,
  `jan` varchar(13) NOT NULL,
  `isbn` varchar(17) NOT NULL,
  `mpn` varchar(64) NOT NULL,
  `location` varchar(128) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `stock_status_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `manufacturer_id` int(11) NOT NULL,
  `shipping` tinyint(1) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `points` int(8) NOT NULL DEFAULT '0',
  `tax_class_id` int(11) NOT NULL,
  `date_available` date NOT NULL DEFAULT '0000-00-00',
  `weight` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `weight_class_id` int(11) NOT NULL DEFAULT '0',
  `length` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `width` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `height` decimal(15,8) NOT NULL DEFAULT '0.00000000',
  `length_class_id` int(11) NOT NULL DEFAULT '0',
  `subtract` tinyint(1) NOT NULL DEFAULT '1',
  `minimum` int(11) NOT NULL DEFAULT '1',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `viewed` int(5) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_product`
--

INSERT INTO `oc_product` (`product_id`, `model`, `sku`, `upc`, `ean`, `jan`, `isbn`, `mpn`, `location`, `quantity`, `stock_status_id`, `image`, `manufacturer_id`, `shipping`, `price`, `points`, `tax_class_id`, `date_available`, `weight`, `weight_class_id`, `length`, `width`, `height`, `length_class_id`, `subtract`, `minimum`, `sort_order`, `status`, `viewed`, `date_added`, `date_modified`) VALUES
(7, '', '', '', '', '', '', '', '', 99, 150, '/images/products/7.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(8, '', '', '', '', '', '', '', '', 99, 150, '/images/products/8.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(9, '', '', '', '', '', '', '', '', 99, 150, '/images/products/9.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(10, '', '', '', '', '', '', '', '', 99, 150, '/images/products/10.jpeg', 0, 1, '7.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(11, '', '', '', '', '', '', '', '', 99, 150, '/images/products/11.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(12, '', '', '', '', '', '', '', '', 99, 150, '/images/products/12.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(13, '', '', '', '', '', '', '', '', 99, 150, '/images/products/13.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(14, '', '', '', '', '', '', '', '', 99, 150, '/images/products/14.jpeg', 0, 1, '3.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(15, '', '', '', '', '', '', '', '', 99, 150, '/images/products/15.jpeg', 0, 1, '3.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(16, '', '', '', '', '', '', '', '', 99, 150, '/images/products/16.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(17, '', '', '', '', '', '', '', '', 99, 150, '/images/products/17.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(18, '', '', '', '', '', '', '', '', 99, 150, '/images/products/18.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(1, '', '', '', '', '', '', '', '', 99, 150, '/images/products/1.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(2, '', '', '', '', '', '', '', '', 99, 150, '/images/products/2.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(3, '', '', '', '', '', '', '', '', 99, 150, '/images/products/3.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(4, '', '', '', '', '', '', '', '', 99, 150, '/images/products/4.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(5, '', '', '', '', '', '', '', '', 99, 150, '/images/products/5.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(6, '', '', '', '', '', '', '', '', 99, 150, '/images/products/6.jpeg', 0, 1, '12.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(19, '', '', '', '', '', '', '', '', 99, 150, '/images/products/19.jpeg', 0, 1, '10.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(20, '', '', '', '', '', '', '', '', 99, 150, '/images/products/20.jpeg', 0, 1, '3.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(23, '', '', '', '', '', '', '', '', 99, 150, '/images/products/23.jpeg', 0, 1, '2.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00'),
(24, '', '', '', '', '', '', '', '', 99, 150, '/images/products/24.jpeg', 0, 1, '2.8000', 0, 0, '0000-00-00', '0.00000000', 0, '0.00000000', '0.00000000', '0.00000000', 0, 1, 1, 0, 0, 0, '2019-01-22 00:00:00', '2019-01-22 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_advertise_google`
--

CREATE TABLE `oc_product_advertise_google` (
  `product_advertise_google_id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `has_issues` tinyint(1) DEFAULT NULL,
  `destination_status` enum('pending','approved','disapproved') NOT NULL DEFAULT 'pending',
  `impressions` int(11) NOT NULL DEFAULT '0',
  `clicks` int(11) NOT NULL DEFAULT '0',
  `conversions` int(11) NOT NULL DEFAULT '0',
  `cost` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `conversion_value` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `google_product_category` varchar(10) DEFAULT NULL,
  `condition` enum('new','refurbished','used') DEFAULT NULL,
  `adult` tinyint(1) DEFAULT NULL,
  `multipack` int(11) DEFAULT NULL,
  `is_bundle` tinyint(1) DEFAULT NULL,
  `age_group` enum('newborn','infant','toddler','kids','adult') DEFAULT NULL,
  `color` int(11) DEFAULT NULL,
  `gender` enum('male','female','unisex') DEFAULT NULL,
  `size_type` enum('regular','petite','plus','big and tall','maternity') DEFAULT NULL,
  `size_system` enum('AU','BR','CN','DE','EU','FR','IT','JP','MEX','UK','US') DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `is_modified` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_advertise_google_status`
--

CREATE TABLE `oc_product_advertise_google_status` (
  `product_id` int(11) NOT NULL DEFAULT '0',
  `store_id` int(11) NOT NULL DEFAULT '0',
  `product_variation_id` varchar(64) NOT NULL DEFAULT '',
  `destination_statuses` text NOT NULL,
  `data_quality_issues` text NOT NULL,
  `item_level_issues` text NOT NULL,
  `google_expiration_date` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_advertise_google_target`
--

CREATE TABLE `oc_product_advertise_google_target` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `advertise_google_target_id` int(11) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_attribute`
--

CREATE TABLE `oc_product_attribute` (
  `product_id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_description`
--

CREATE TABLE `oc_product_description` (
  `product_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `tag` text NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_product_description`
--

INSERT INTO `oc_product_description` (`product_id`, `language_id`, `name`, `description`, `tag`, `meta_title`, `meta_description`, `meta_keyword`) VALUES
(23, 1, 'spirit', '', '', '', '', ''),
(24, 2, '芬达', '', '', '', '', ''),
(24, 1, 'fanta', '', '', '', '', ''),
(20, 2, '可乐', '', '', '', '', ''),
(20, 1, 'coke', '', '', '', '', ''),
(23, 2, '雪碧', '', '', '', '', ''),
(18, 1, 'prok chitterlings and peas with rice', '', '', '', '', ''),
(19, 2, '竹笋烧鸡套饭', '', '', '', '', ''),
(19, 1, 'chiken with bamboo shots with rice', '', '', '', '', ''),
(16, 1, 'spicy beef with rice', '', '', '', '', ''),
(17, 2, '红焖羊排套饭', '', '', '', '', ''),
(17, 1, 'lamb ribs with rice', '', '', '', '', ''),
(18, 2, '豌豆烧肥肠套饭', '', '', '', '', ''),
(16, 2, '红烧牛肉面套饭', '', '', '', '', ''),
(14, 1, 'sichuan cold noodle', '', '', '', '', ''),
(15, 2, '川北凉粉', '', '', '', '', ''),
(15, 1, 'spicy green-bean jelly noodles', '', '', '', '', ''),
(13, 1, 'beef potato noodles', '', '', '', '', ''),
(14, 2, '风味凉面', '', '', '', '', ''),
(12, 2, '杂酱酸辣粉', '', '', '', '', ''),
(12, 1, 'miniced pork potato noodles', '', '', '', '', ''),
(13, 2, '牛肉酸辣粉', '', '', '', '', ''),
(11, 1, 'pork chitterlings potato noodels', '', '', '', '', ''),
(10, 2, '酸辣粉', '', '', '', '', ''),
(10, 1, 'potato noodle', '', '', '', '', ''),
(11, 2, '肥肠酸辣粉', '', '', '', '', ''),
(7, 1, 'fish with pickled vegetable', '', '', '', '', ''),
(8, 2, '菌王鸡汤面', '', '', '', '', ''),
(8, 1, 'mountain mushrooms', '', '', '', '', ''),
(9, 2, '重庆麻辣小面', '', '', '', '', ''),
(9, 1, 'chongqing spicky noodle', '', '', '', '', ''),
(6, 1, 'pork balls with tomato', '', '', '', '', ''),
(7, 2, '酸菜鱼面', '', '', '', '', ''),
(6, 2, '番茄丸子面', '', '', '', '', ''),
(4, 2, '竹笋烧鸡面', '', '', '', '', ''),
(5, 2, '豌豆肥肠面', '', '', '', '', ''),
(5, 1, 'Pork chitterlings with peas', '', '', '', '', ''),
(4, 1, 'Chicken With Bamboo Shoots', '', '', '', '', ''),
(3, 2, '豌豆杂酱面', '', '', '', '', ''),
(3, 1, 'Minced Pork With Peas', '', '', '', '', ''),
(2, 2, '红焖羊肉面', '', '', '', '', ''),
(2, 1, 'Stewed Lamb Ribs Noodle', '', '', '', '', ''),
(1, 1, 'Spicy Stewed Beef Noodles Soup', '', '', '', '', ''),
(1, 2, '麻辣牛肉面', '', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_discount`
--

CREATE TABLE `oc_product_discount` (
  `product_discount_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `quantity` int(4) NOT NULL DEFAULT '0',
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_filter`
--

CREATE TABLE `oc_product_filter` (
  `product_id` int(11) NOT NULL,
  `filter_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_image`
--

CREATE TABLE `oc_product_image` (
  `product_image_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(3) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_option`
--

CREATE TABLE `oc_product_option` (
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value` text NOT NULL,
  `required` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_product_option`
--

INSERT INTO `oc_product_option` (`product_option_id`, `product_id`, `option_id`, `value`, `required`) VALUES
(1, 1, 1, '', 0),
(2, 1, 2, '', 0);

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_option_value`
--

CREATE TABLE `oc_product_option_value` (
  `product_option_value_id` int(11) NOT NULL,
  `product_option_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `quantity` int(3) NOT NULL,
  `subtract` tinyint(1) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `price_prefix` varchar(1) NOT NULL,
  `points` int(8) NOT NULL,
  `points_prefix` varchar(1) NOT NULL,
  `weight` decimal(15,8) NOT NULL,
  `weight_prefix` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_product_option_value`
--

INSERT INTO `oc_product_option_value` (`product_option_value_id`, `product_option_id`, `product_id`, `option_id`, `option_value_id`, `quantity`, `subtract`, `price`, `price_prefix`, `points`, `points_prefix`, `weight`, `weight_prefix`) VALUES
(1, 1, 1, 1, 1, 1, 1, '0.0000', '$', 1, 'P', '0.00000000', 'K'),
(2, 1, 1, 1, 2, 1, 1, '0.0000', '1', 1, '1', '1.00000000', '1'),
(3, 1, 1, 1, 3, 1, 1, '0.0000', '1', 1, '1', '1.00000000', '1'),
(4, 2, 1, 2, 4, 1, 1, '2.0000', '$', 1, 'P', '0.00000000', 'K'),
(5, 2, 1, 2, 5, 1, 1, '1.0000', '1', 1, '1', '1.00000000', '1'),
(6, 2, 1, 2, 6, 1, 1, '3.0000', '1', 1, '1', '1.00000000', '1');

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_recurring`
--

CREATE TABLE `oc_product_recurring` (
  `product_id` int(11) NOT NULL,
  `recurring_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_related`
--

CREATE TABLE `oc_product_related` (
  `product_id` int(11) NOT NULL,
  `related_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_reward`
--

CREATE TABLE `oc_product_reward` (
  `product_reward_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT '0',
  `customer_group_id` int(11) NOT NULL DEFAULT '0',
  `points` int(8) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_special`
--

CREATE TABLE `oc_product_special` (
  `product_special_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1',
  `price` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `date_start` date NOT NULL DEFAULT '0000-00-00',
  `date_end` date NOT NULL DEFAULT '0000-00-00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_to_category`
--

CREATE TABLE `oc_product_to_category` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_product_to_category`
--

INSERT INTO `oc_product_to_category` (`product_id`, `category_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 3),
(17, 3),
(18, 3),
(19, 3),
(20, 4),
(23, 4),
(24, 4);

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_to_download`
--

CREATE TABLE `oc_product_to_download` (
  `product_id` int(11) NOT NULL,
  `download_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_to_layout`
--

CREATE TABLE `oc_product_to_layout` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_product_to_store`
--

CREATE TABLE `oc_product_to_store` (
  `product_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_recurring`
--

CREATE TABLE `oc_recurring` (
  `recurring_id` int(11) NOT NULL,
  `price` decimal(10,4) NOT NULL,
  `frequency` enum('day','week','semi_month','month','year') NOT NULL,
  `duration` int(10) UNSIGNED NOT NULL,
  `cycle` int(10) UNSIGNED NOT NULL,
  `trial_status` tinyint(4) NOT NULL,
  `trial_price` decimal(10,4) NOT NULL,
  `trial_frequency` enum('day','week','semi_month','month','year') NOT NULL,
  `trial_duration` int(10) UNSIGNED NOT NULL,
  `trial_cycle` int(10) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL,
  `sort_order` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_recurring_description`
--

CREATE TABLE `oc_recurring_description` (
  `recurring_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_return`
--

CREATE TABLE `oc_return` (
  `return_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `product` varchar(255) NOT NULL,
  `model` varchar(64) NOT NULL,
  `quantity` int(4) NOT NULL,
  `opened` tinyint(1) NOT NULL,
  `return_reason_id` int(11) NOT NULL,
  `return_action_id` int(11) NOT NULL,
  `return_status_id` int(11) NOT NULL,
  `comment` text,
  `date_ordered` date NOT NULL DEFAULT '0000-00-00',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_return_action`
--

CREATE TABLE `oc_return_action` (
  `return_action_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(64) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_return_history`
--

CREATE TABLE `oc_return_history` (
  `return_history_id` int(11) NOT NULL,
  `return_id` int(11) NOT NULL,
  `return_status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_return_reason`
--

CREATE TABLE `oc_return_reason` (
  `return_reason_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(128) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_return_status`
--

CREATE TABLE `oc_return_status` (
  `return_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_review`
--

CREATE TABLE `oc_review` (
  `review_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `author` varchar(64) NOT NULL,
  `text` text NOT NULL,
  `rating` int(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_seo_url`
--

CREATE TABLE `oc_seo_url` (
  `seo_url_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `query` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_session`
--

CREATE TABLE `oc_session` (
  `session_id` varchar(32) NOT NULL,
  `data` text NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_setting`
--

CREATE TABLE `oc_setting` (
  `setting_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(128) NOT NULL,
  `key` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_shipping_courier`
--

CREATE TABLE `oc_shipping_courier` (
  `shipping_courier_id` int(11) NOT NULL,
  `shipping_courier_code` varchar(255) NOT NULL DEFAULT '',
  `shipping_courier_name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_statistics`
--

CREATE TABLE `oc_statistics` (
  `statistics_id` int(11) NOT NULL,
  `code` varchar(64) NOT NULL,
  `value` decimal(15,4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_stock_status`
--

CREATE TABLE `oc_stock_status` (
  `stock_status_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_store`
--

CREATE TABLE `oc_store` (
  `store_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `url` varchar(255) NOT NULL,
  `ssl` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_tax_class`
--

CREATE TABLE `oc_tax_class` (
  `tax_class_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_tax_rate`
--

CREATE TABLE `oc_tax_rate` (
  `tax_rate_id` int(11) NOT NULL,
  `geo_zone_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(32) NOT NULL,
  `rate` decimal(15,4) NOT NULL DEFAULT '0.0000',
  `type` char(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_tax_rate_to_customer_group`
--

CREATE TABLE `oc_tax_rate_to_customer_group` (
  `tax_rate_id` int(11) NOT NULL,
  `customer_group_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_tax_rule`
--

CREATE TABLE `oc_tax_rule` (
  `tax_rule_id` int(11) NOT NULL,
  `tax_class_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `based` varchar(10) NOT NULL,
  `priority` int(5) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_theme`
--

CREATE TABLE `oc_theme` (
  `theme_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `theme` varchar(64) NOT NULL,
  `route` varchar(64) NOT NULL,
  `code` mediumtext NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_translation`
--

CREATE TABLE `oc_translation` (
  `translation_id` int(11) NOT NULL,
  `store_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `route` varchar(64) NOT NULL,
  `key` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_upload`
--

CREATE TABLE `oc_upload` (
  `upload_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_user`
--

CREATE TABLE `oc_user` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `api_token` text NOT NULL,
  `salt` varchar(9) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `image` varchar(255) NOT NULL,
  `code` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `oc_user`
--

INSERT INTO `oc_user` (`user_id`, `user_group_id`, `username`, `password`, `api_token`, `salt`, `firstname`, `lastname`, `email`, `image`, `code`, `ip`, `status`, `date_added`) VALUES
(1, 1, 'admin', '$2y$10$2fIZANKxK9OWfPYsAHTC6OCCzCH.nY1FtzH/.azL3yO0QEsvM7wz2', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTU0ODkxMzU1NiwiZXhwIjoxNTQ4OTE3MTU2LCJuYmYiOjE1NDg5MTM1NTYsImp0aSI6IktkR0JuazI3R2xTelJlcDgiLCJzdWIiOjEsInBydiI6Ijg3ZTBhZjFlZjlmZDE1ODEyZmRlYzk3MTUzYTE0ZTBiMDQ3NTQ2YWEifQ.1LXHuFq2inKAT4oCVcVkZw5b3BVt_r9MLzerIYqO3uo', '', '', '', 'admin@admin.com', '', '', '', 0, '1900-10-10 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `oc_user_group`
--

CREATE TABLE `oc_user_group` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_voucher`
--

CREATE TABLE `oc_voucher` (
  `voucher_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `from_email` varchar(96) NOT NULL,
  `to_name` varchar(64) NOT NULL,
  `to_email` varchar(96) NOT NULL,
  `voucher_theme_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_voucher_history`
--

CREATE TABLE `oc_voucher_history` (
  `voucher_history_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(15,4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_voucher_theme`
--

CREATE TABLE `oc_voucher_theme` (
  `voucher_theme_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_voucher_theme_description`
--

CREATE TABLE `oc_voucher_theme_description` (
  `voucher_theme_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_weight_class`
--

CREATE TABLE `oc_weight_class` (
  `weight_class_id` int(11) NOT NULL,
  `value` decimal(15,8) NOT NULL DEFAULT '0.00000000'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_weight_class_description`
--

CREATE TABLE `oc_weight_class_description` (
  `weight_class_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `unit` varchar(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_zone`
--

CREATE TABLE `oc_zone` (
  `zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `oc_zone_to_geo_zone`
--

CREATE TABLE `oc_zone_to_geo_zone` (
  `zone_to_geo_zone_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `zone_id` int(11) NOT NULL DEFAULT '0',
  `geo_zone_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `oc_address`
--
ALTER TABLE `oc_address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- 表的索引 `oc_advertise_google_target`
--
ALTER TABLE `oc_advertise_google_target`
  ADD PRIMARY KEY (`advertise_google_target_id`),
  ADD KEY `store_id` (`store_id`);

--
-- 表的索引 `oc_api`
--
ALTER TABLE `oc_api`
  ADD PRIMARY KEY (`api_id`);

--
-- 表的索引 `oc_api_ip`
--
ALTER TABLE `oc_api_ip`
  ADD PRIMARY KEY (`api_ip_id`);

--
-- 表的索引 `oc_api_session`
--
ALTER TABLE `oc_api_session`
  ADD PRIMARY KEY (`api_session_id`);

--
-- 表的索引 `oc_attribute`
--
ALTER TABLE `oc_attribute`
  ADD PRIMARY KEY (`attribute_id`);

--
-- 表的索引 `oc_attribute_description`
--
ALTER TABLE `oc_attribute_description`
  ADD PRIMARY KEY (`attribute_id`,`language_id`);

--
-- 表的索引 `oc_attribute_group`
--
ALTER TABLE `oc_attribute_group`
  ADD PRIMARY KEY (`attribute_group_id`);

--
-- 表的索引 `oc_attribute_group_description`
--
ALTER TABLE `oc_attribute_group_description`
  ADD PRIMARY KEY (`attribute_group_id`,`language_id`);

--
-- 表的索引 `oc_banner`
--
ALTER TABLE `oc_banner`
  ADD PRIMARY KEY (`banner_id`);

--
-- 表的索引 `oc_banner_image`
--
ALTER TABLE `oc_banner_image`
  ADD PRIMARY KEY (`banner_image_id`);

--
-- 表的索引 `oc_cart`
--
ALTER TABLE `oc_cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cart_id` (`api_id`,`customer_id`,`session_id`,`product_id`,`recurring_id`);

--
-- 表的索引 `oc_category`
--
ALTER TABLE `oc_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- 表的索引 `oc_category_description`
--
ALTER TABLE `oc_category_description`
  ADD PRIMARY KEY (`category_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- 表的索引 `oc_category_filter`
--
ALTER TABLE `oc_category_filter`
  ADD PRIMARY KEY (`category_id`,`filter_id`);

--
-- 表的索引 `oc_category_path`
--
ALTER TABLE `oc_category_path`
  ADD PRIMARY KEY (`category_id`,`path_id`);

--
-- 表的索引 `oc_category_to_google_product_category`
--
ALTER TABLE `oc_category_to_google_product_category`
  ADD PRIMARY KEY (`google_product_category`,`store_id`),
  ADD KEY `category_id_store_id` (`category_id`,`store_id`);

--
-- 表的索引 `oc_category_to_layout`
--
ALTER TABLE `oc_category_to_layout`
  ADD PRIMARY KEY (`category_id`,`store_id`);

--
-- 表的索引 `oc_category_to_store`
--
ALTER TABLE `oc_category_to_store`
  ADD PRIMARY KEY (`category_id`,`store_id`);

--
-- 表的索引 `oc_country`
--
ALTER TABLE `oc_country`
  ADD PRIMARY KEY (`country_id`);

--
-- 表的索引 `oc_coupon`
--
ALTER TABLE `oc_coupon`
  ADD PRIMARY KEY (`coupon_id`);

--
-- 表的索引 `oc_coupon_category`
--
ALTER TABLE `oc_coupon_category`
  ADD PRIMARY KEY (`coupon_id`,`category_id`);

--
-- 表的索引 `oc_coupon_history`
--
ALTER TABLE `oc_coupon_history`
  ADD PRIMARY KEY (`coupon_history_id`);

--
-- 表的索引 `oc_coupon_product`
--
ALTER TABLE `oc_coupon_product`
  ADD PRIMARY KEY (`coupon_product_id`);

--
-- 表的索引 `oc_currency`
--
ALTER TABLE `oc_currency`
  ADD PRIMARY KEY (`currency_id`);

--
-- 表的索引 `oc_customer`
--
ALTER TABLE `oc_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- 表的索引 `oc_customer_activity`
--
ALTER TABLE `oc_customer_activity`
  ADD PRIMARY KEY (`customer_activity_id`);

--
-- 表的索引 `oc_customer_affiliate`
--
ALTER TABLE `oc_customer_affiliate`
  ADD PRIMARY KEY (`customer_id`);

--
-- 表的索引 `oc_customer_approval`
--
ALTER TABLE `oc_customer_approval`
  ADD PRIMARY KEY (`customer_approval_id`);

--
-- 表的索引 `oc_customer_group`
--
ALTER TABLE `oc_customer_group`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- 表的索引 `oc_customer_group_description`
--
ALTER TABLE `oc_customer_group_description`
  ADD PRIMARY KEY (`customer_group_id`,`language_id`);

--
-- 表的索引 `oc_customer_history`
--
ALTER TABLE `oc_customer_history`
  ADD PRIMARY KEY (`customer_history_id`);

--
-- 表的索引 `oc_customer_ip`
--
ALTER TABLE `oc_customer_ip`
  ADD PRIMARY KEY (`customer_ip_id`),
  ADD KEY `ip` (`ip`);

--
-- 表的索引 `oc_customer_login`
--
ALTER TABLE `oc_customer_login`
  ADD PRIMARY KEY (`customer_login_id`),
  ADD KEY `email` (`email`),
  ADD KEY `ip` (`ip`);

--
-- 表的索引 `oc_customer_online`
--
ALTER TABLE `oc_customer_online`
  ADD PRIMARY KEY (`ip`);

--
-- 表的索引 `oc_customer_reward`
--
ALTER TABLE `oc_customer_reward`
  ADD PRIMARY KEY (`customer_reward_id`);

--
-- 表的索引 `oc_customer_search`
--
ALTER TABLE `oc_customer_search`
  ADD PRIMARY KEY (`customer_search_id`);

--
-- 表的索引 `oc_customer_transaction`
--
ALTER TABLE `oc_customer_transaction`
  ADD PRIMARY KEY (`customer_transaction_id`);

--
-- 表的索引 `oc_customer_wishlist`
--
ALTER TABLE `oc_customer_wishlist`
  ADD PRIMARY KEY (`customer_id`,`product_id`);

--
-- 表的索引 `oc_custom_field`
--
ALTER TABLE `oc_custom_field`
  ADD PRIMARY KEY (`custom_field_id`);

--
-- 表的索引 `oc_custom_field_customer_group`
--
ALTER TABLE `oc_custom_field_customer_group`
  ADD PRIMARY KEY (`custom_field_id`,`customer_group_id`);

--
-- 表的索引 `oc_custom_field_description`
--
ALTER TABLE `oc_custom_field_description`
  ADD PRIMARY KEY (`custom_field_id`,`language_id`);

--
-- 表的索引 `oc_custom_field_value`
--
ALTER TABLE `oc_custom_field_value`
  ADD PRIMARY KEY (`custom_field_value_id`);

--
-- 表的索引 `oc_custom_field_value_description`
--
ALTER TABLE `oc_custom_field_value_description`
  ADD PRIMARY KEY (`custom_field_value_id`,`language_id`);

--
-- 表的索引 `oc_download`
--
ALTER TABLE `oc_download`
  ADD PRIMARY KEY (`download_id`);

--
-- 表的索引 `oc_download_description`
--
ALTER TABLE `oc_download_description`
  ADD PRIMARY KEY (`download_id`,`language_id`);

--
-- 表的索引 `oc_event`
--
ALTER TABLE `oc_event`
  ADD PRIMARY KEY (`event_id`);

--
-- 表的索引 `oc_extension`
--
ALTER TABLE `oc_extension`
  ADD PRIMARY KEY (`extension_id`);

--
-- 表的索引 `oc_extension_install`
--
ALTER TABLE `oc_extension_install`
  ADD PRIMARY KEY (`extension_install_id`);

--
-- 表的索引 `oc_extension_path`
--
ALTER TABLE `oc_extension_path`
  ADD PRIMARY KEY (`extension_path_id`);

--
-- 表的索引 `oc_filter`
--
ALTER TABLE `oc_filter`
  ADD PRIMARY KEY (`filter_id`);

--
-- 表的索引 `oc_filter_description`
--
ALTER TABLE `oc_filter_description`
  ADD PRIMARY KEY (`filter_id`,`language_id`);

--
-- 表的索引 `oc_filter_group`
--
ALTER TABLE `oc_filter_group`
  ADD PRIMARY KEY (`filter_group_id`);

--
-- 表的索引 `oc_filter_group_description`
--
ALTER TABLE `oc_filter_group_description`
  ADD PRIMARY KEY (`filter_group_id`,`language_id`);

--
-- 表的索引 `oc_geo_zone`
--
ALTER TABLE `oc_geo_zone`
  ADD PRIMARY KEY (`geo_zone_id`);

--
-- 表的索引 `oc_information`
--
ALTER TABLE `oc_information`
  ADD PRIMARY KEY (`information_id`);

--
-- 表的索引 `oc_information_description`
--
ALTER TABLE `oc_information_description`
  ADD PRIMARY KEY (`information_id`,`language_id`);

--
-- 表的索引 `oc_information_to_layout`
--
ALTER TABLE `oc_information_to_layout`
  ADD PRIMARY KEY (`information_id`,`store_id`);

--
-- 表的索引 `oc_information_to_store`
--
ALTER TABLE `oc_information_to_store`
  ADD PRIMARY KEY (`information_id`,`store_id`);

--
-- 表的索引 `oc_language`
--
ALTER TABLE `oc_language`
  ADD PRIMARY KEY (`language_id`),
  ADD KEY `name` (`name`);

--
-- 表的索引 `oc_layout`
--
ALTER TABLE `oc_layout`
  ADD PRIMARY KEY (`layout_id`);

--
-- 表的索引 `oc_layout_module`
--
ALTER TABLE `oc_layout_module`
  ADD PRIMARY KEY (`layout_module_id`);

--
-- 表的索引 `oc_layout_route`
--
ALTER TABLE `oc_layout_route`
  ADD PRIMARY KEY (`layout_route_id`);

--
-- 表的索引 `oc_length_class`
--
ALTER TABLE `oc_length_class`
  ADD PRIMARY KEY (`length_class_id`);

--
-- 表的索引 `oc_length_class_description`
--
ALTER TABLE `oc_length_class_description`
  ADD PRIMARY KEY (`length_class_id`,`language_id`);

--
-- 表的索引 `oc_location`
--
ALTER TABLE `oc_location`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `name` (`name`);

--
-- 表的索引 `oc_manufacturer`
--
ALTER TABLE `oc_manufacturer`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- 表的索引 `oc_manufacturer_to_store`
--
ALTER TABLE `oc_manufacturer_to_store`
  ADD PRIMARY KEY (`manufacturer_id`,`store_id`);

--
-- 表的索引 `oc_marketing`
--
ALTER TABLE `oc_marketing`
  ADD PRIMARY KEY (`marketing_id`);

--
-- 表的索引 `oc_modification`
--
ALTER TABLE `oc_modification`
  ADD PRIMARY KEY (`modification_id`);

--
-- 表的索引 `oc_module`
--
ALTER TABLE `oc_module`
  ADD PRIMARY KEY (`module_id`);

--
-- 表的索引 `oc_option`
--
ALTER TABLE `oc_option`
  ADD PRIMARY KEY (`option_id`);

--
-- 表的索引 `oc_option_description`
--
ALTER TABLE `oc_option_description`
  ADD PRIMARY KEY (`option_id`,`language_id`);

--
-- 表的索引 `oc_option_value`
--
ALTER TABLE `oc_option_value`
  ADD PRIMARY KEY (`option_value_id`);

--
-- 表的索引 `oc_option_value_description`
--
ALTER TABLE `oc_option_value_description`
  ADD PRIMARY KEY (`option_value_id`,`language_id`);

--
-- 表的索引 `oc_order`
--
ALTER TABLE `oc_order`
  ADD PRIMARY KEY (`order_id`);

--
-- 表的索引 `oc_order_history`
--
ALTER TABLE `oc_order_history`
  ADD PRIMARY KEY (`order_history_id`);

--
-- 表的索引 `oc_order_option`
--
ALTER TABLE `oc_order_option`
  ADD PRIMARY KEY (`order_option_id`);

--
-- 表的索引 `oc_order_product`
--
ALTER TABLE `oc_order_product`
  ADD PRIMARY KEY (`order_product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- 表的索引 `oc_order_recurring`
--
ALTER TABLE `oc_order_recurring`
  ADD PRIMARY KEY (`order_recurring_id`);

--
-- 表的索引 `oc_order_recurring_transaction`
--
ALTER TABLE `oc_order_recurring_transaction`
  ADD PRIMARY KEY (`order_recurring_transaction_id`);

--
-- 表的索引 `oc_order_shipment`
--
ALTER TABLE `oc_order_shipment`
  ADD PRIMARY KEY (`order_shipment_id`);

--
-- 表的索引 `oc_order_status`
--
ALTER TABLE `oc_order_status`
  ADD PRIMARY KEY (`order_status_id`,`language_id`);

--
-- 表的索引 `oc_order_total`
--
ALTER TABLE `oc_order_total`
  ADD PRIMARY KEY (`order_total_id`),
  ADD KEY `order_id` (`order_id`);

--
-- 表的索引 `oc_order_voucher`
--
ALTER TABLE `oc_order_voucher`
  ADD PRIMARY KEY (`order_voucher_id`);

--
-- 表的索引 `oc_product`
--
ALTER TABLE `oc_product`
  ADD PRIMARY KEY (`product_id`);

--
-- 表的索引 `oc_product_advertise_google`
--
ALTER TABLE `oc_product_advertise_google`
  ADD PRIMARY KEY (`product_advertise_google_id`),
  ADD UNIQUE KEY `product_id_store_id` (`product_id`,`store_id`);

--
-- 表的索引 `oc_product_advertise_google_status`
--
ALTER TABLE `oc_product_advertise_google_status`
  ADD PRIMARY KEY (`product_id`,`store_id`,`product_variation_id`);

--
-- 表的索引 `oc_product_advertise_google_target`
--
ALTER TABLE `oc_product_advertise_google_target`
  ADD PRIMARY KEY (`product_id`,`advertise_google_target_id`);

--
-- 表的索引 `oc_product_attribute`
--
ALTER TABLE `oc_product_attribute`
  ADD PRIMARY KEY (`product_id`,`attribute_id`,`language_id`);

--
-- 表的索引 `oc_product_description`
--
ALTER TABLE `oc_product_description`
  ADD PRIMARY KEY (`product_id`,`language_id`),
  ADD KEY `name` (`name`);

--
-- 表的索引 `oc_product_discount`
--
ALTER TABLE `oc_product_discount`
  ADD PRIMARY KEY (`product_discount_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `oc_product_filter`
--
ALTER TABLE `oc_product_filter`
  ADD PRIMARY KEY (`product_id`,`filter_id`);

--
-- 表的索引 `oc_product_image`
--
ALTER TABLE `oc_product_image`
  ADD PRIMARY KEY (`product_image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `oc_product_option`
--
ALTER TABLE `oc_product_option`
  ADD PRIMARY KEY (`product_option_id`);

--
-- 表的索引 `oc_product_option_value`
--
ALTER TABLE `oc_product_option_value`
  ADD PRIMARY KEY (`product_option_value_id`);

--
-- 表的索引 `oc_product_recurring`
--
ALTER TABLE `oc_product_recurring`
  ADD PRIMARY KEY (`product_id`,`recurring_id`,`customer_group_id`);

--
-- 表的索引 `oc_product_related`
--
ALTER TABLE `oc_product_related`
  ADD PRIMARY KEY (`product_id`,`related_id`);

--
-- 表的索引 `oc_product_reward`
--
ALTER TABLE `oc_product_reward`
  ADD PRIMARY KEY (`product_reward_id`);

--
-- 表的索引 `oc_product_special`
--
ALTER TABLE `oc_product_special`
  ADD PRIMARY KEY (`product_special_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `oc_product_to_category`
--
ALTER TABLE `oc_product_to_category`
  ADD PRIMARY KEY (`product_id`,`category_id`),
  ADD KEY `category_id` (`category_id`);

--
-- 表的索引 `oc_product_to_download`
--
ALTER TABLE `oc_product_to_download`
  ADD PRIMARY KEY (`product_id`,`download_id`);

--
-- 表的索引 `oc_product_to_layout`
--
ALTER TABLE `oc_product_to_layout`
  ADD PRIMARY KEY (`product_id`,`store_id`);

--
-- 表的索引 `oc_product_to_store`
--
ALTER TABLE `oc_product_to_store`
  ADD PRIMARY KEY (`product_id`,`store_id`);

--
-- 表的索引 `oc_recurring`
--
ALTER TABLE `oc_recurring`
  ADD PRIMARY KEY (`recurring_id`);

--
-- 表的索引 `oc_recurring_description`
--
ALTER TABLE `oc_recurring_description`
  ADD PRIMARY KEY (`recurring_id`,`language_id`);

--
-- 表的索引 `oc_return`
--
ALTER TABLE `oc_return`
  ADD PRIMARY KEY (`return_id`);

--
-- 表的索引 `oc_return_action`
--
ALTER TABLE `oc_return_action`
  ADD PRIMARY KEY (`return_action_id`,`language_id`);

--
-- 表的索引 `oc_return_history`
--
ALTER TABLE `oc_return_history`
  ADD PRIMARY KEY (`return_history_id`);

--
-- 表的索引 `oc_return_reason`
--
ALTER TABLE `oc_return_reason`
  ADD PRIMARY KEY (`return_reason_id`,`language_id`);

--
-- 表的索引 `oc_return_status`
--
ALTER TABLE `oc_return_status`
  ADD PRIMARY KEY (`return_status_id`,`language_id`);

--
-- 表的索引 `oc_review`
--
ALTER TABLE `oc_review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `product_id` (`product_id`);

--
-- 表的索引 `oc_seo_url`
--
ALTER TABLE `oc_seo_url`
  ADD PRIMARY KEY (`seo_url_id`),
  ADD KEY `query` (`query`),
  ADD KEY `keyword` (`keyword`);

--
-- 表的索引 `oc_session`
--
ALTER TABLE `oc_session`
  ADD PRIMARY KEY (`session_id`);

--
-- 表的索引 `oc_setting`
--
ALTER TABLE `oc_setting`
  ADD PRIMARY KEY (`setting_id`);

--
-- 表的索引 `oc_shipping_courier`
--
ALTER TABLE `oc_shipping_courier`
  ADD PRIMARY KEY (`shipping_courier_id`);

--
-- 表的索引 `oc_statistics`
--
ALTER TABLE `oc_statistics`
  ADD PRIMARY KEY (`statistics_id`);

--
-- 表的索引 `oc_stock_status`
--
ALTER TABLE `oc_stock_status`
  ADD PRIMARY KEY (`stock_status_id`,`language_id`);

--
-- 表的索引 `oc_store`
--
ALTER TABLE `oc_store`
  ADD PRIMARY KEY (`store_id`);

--
-- 表的索引 `oc_tax_class`
--
ALTER TABLE `oc_tax_class`
  ADD PRIMARY KEY (`tax_class_id`);

--
-- 表的索引 `oc_tax_rate`
--
ALTER TABLE `oc_tax_rate`
  ADD PRIMARY KEY (`tax_rate_id`);

--
-- 表的索引 `oc_tax_rate_to_customer_group`
--
ALTER TABLE `oc_tax_rate_to_customer_group`
  ADD PRIMARY KEY (`tax_rate_id`,`customer_group_id`);

--
-- 表的索引 `oc_tax_rule`
--
ALTER TABLE `oc_tax_rule`
  ADD PRIMARY KEY (`tax_rule_id`);

--
-- 表的索引 `oc_theme`
--
ALTER TABLE `oc_theme`
  ADD PRIMARY KEY (`theme_id`);

--
-- 表的索引 `oc_translation`
--
ALTER TABLE `oc_translation`
  ADD PRIMARY KEY (`translation_id`);

--
-- 表的索引 `oc_upload`
--
ALTER TABLE `oc_upload`
  ADD PRIMARY KEY (`upload_id`);

--
-- 表的索引 `oc_user`
--
ALTER TABLE `oc_user`
  ADD PRIMARY KEY (`user_id`);

--
-- 表的索引 `oc_user_group`
--
ALTER TABLE `oc_user_group`
  ADD PRIMARY KEY (`user_group_id`);

--
-- 表的索引 `oc_voucher`
--
ALTER TABLE `oc_voucher`
  ADD PRIMARY KEY (`voucher_id`);

--
-- 表的索引 `oc_voucher_history`
--
ALTER TABLE `oc_voucher_history`
  ADD PRIMARY KEY (`voucher_history_id`);

--
-- 表的索引 `oc_voucher_theme`
--
ALTER TABLE `oc_voucher_theme`
  ADD PRIMARY KEY (`voucher_theme_id`);

--
-- 表的索引 `oc_voucher_theme_description`
--
ALTER TABLE `oc_voucher_theme_description`
  ADD PRIMARY KEY (`voucher_theme_id`,`language_id`);

--
-- 表的索引 `oc_weight_class`
--
ALTER TABLE `oc_weight_class`
  ADD PRIMARY KEY (`weight_class_id`);

--
-- 表的索引 `oc_weight_class_description`
--
ALTER TABLE `oc_weight_class_description`
  ADD PRIMARY KEY (`weight_class_id`,`language_id`);

--
-- 表的索引 `oc_zone`
--
ALTER TABLE `oc_zone`
  ADD PRIMARY KEY (`zone_id`);

--
-- 表的索引 `oc_zone_to_geo_zone`
--
ALTER TABLE `oc_zone_to_geo_zone`
  ADD PRIMARY KEY (`zone_to_geo_zone_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `oc_address`
--
ALTER TABLE `oc_address`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_api`
--
ALTER TABLE `oc_api`
  MODIFY `api_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_api_ip`
--
ALTER TABLE `oc_api_ip`
  MODIFY `api_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_api_session`
--
ALTER TABLE `oc_api_session`
  MODIFY `api_session_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_attribute`
--
ALTER TABLE `oc_attribute`
  MODIFY `attribute_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_attribute_group`
--
ALTER TABLE `oc_attribute_group`
  MODIFY `attribute_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_banner`
--
ALTER TABLE `oc_banner`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_banner_image`
--
ALTER TABLE `oc_banner_image`
  MODIFY `banner_image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_cart`
--
ALTER TABLE `oc_cart`
  MODIFY `cart_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_category`
--
ALTER TABLE `oc_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `oc_country`
--
ALTER TABLE `oc_country`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_coupon`
--
ALTER TABLE `oc_coupon`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_coupon_history`
--
ALTER TABLE `oc_coupon_history`
  MODIFY `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_coupon_product`
--
ALTER TABLE `oc_coupon_product`
  MODIFY `coupon_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_currency`
--
ALTER TABLE `oc_currency`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer`
--
ALTER TABLE `oc_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_activity`
--
ALTER TABLE `oc_customer_activity`
  MODIFY `customer_activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_approval`
--
ALTER TABLE `oc_customer_approval`
  MODIFY `customer_approval_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_group`
--
ALTER TABLE `oc_customer_group`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_history`
--
ALTER TABLE `oc_customer_history`
  MODIFY `customer_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_ip`
--
ALTER TABLE `oc_customer_ip`
  MODIFY `customer_ip_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_login`
--
ALTER TABLE `oc_customer_login`
  MODIFY `customer_login_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_reward`
--
ALTER TABLE `oc_customer_reward`
  MODIFY `customer_reward_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_search`
--
ALTER TABLE `oc_customer_search`
  MODIFY `customer_search_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_customer_transaction`
--
ALTER TABLE `oc_customer_transaction`
  MODIFY `customer_transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_custom_field`
--
ALTER TABLE `oc_custom_field`
  MODIFY `custom_field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_custom_field_value`
--
ALTER TABLE `oc_custom_field_value`
  MODIFY `custom_field_value_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_download`
--
ALTER TABLE `oc_download`
  MODIFY `download_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_event`
--
ALTER TABLE `oc_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_extension`
--
ALTER TABLE `oc_extension`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_extension_install`
--
ALTER TABLE `oc_extension_install`
  MODIFY `extension_install_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_extension_path`
--
ALTER TABLE `oc_extension_path`
  MODIFY `extension_path_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_filter`
--
ALTER TABLE `oc_filter`
  MODIFY `filter_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_filter_group`
--
ALTER TABLE `oc_filter_group`
  MODIFY `filter_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_geo_zone`
--
ALTER TABLE `oc_geo_zone`
  MODIFY `geo_zone_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_information`
--
ALTER TABLE `oc_information`
  MODIFY `information_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_language`
--
ALTER TABLE `oc_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_layout`
--
ALTER TABLE `oc_layout`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_layout_module`
--
ALTER TABLE `oc_layout_module`
  MODIFY `layout_module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_layout_route`
--
ALTER TABLE `oc_layout_route`
  MODIFY `layout_route_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_length_class`
--
ALTER TABLE `oc_length_class`
  MODIFY `length_class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_location`
--
ALTER TABLE `oc_location`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `oc_manufacturer`
--
ALTER TABLE `oc_manufacturer`
  MODIFY `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_marketing`
--
ALTER TABLE `oc_marketing`
  MODIFY `marketing_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_modification`
--
ALTER TABLE `oc_modification`
  MODIFY `modification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_module`
--
ALTER TABLE `oc_module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_option`
--
ALTER TABLE `oc_option`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `oc_option_value`
--
ALTER TABLE `oc_option_value`
  MODIFY `option_value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `oc_order`
--
ALTER TABLE `oc_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `oc_order_history`
--
ALTER TABLE `oc_order_history`
  MODIFY `order_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_option`
--
ALTER TABLE `oc_order_option`
  MODIFY `order_option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_product`
--
ALTER TABLE `oc_order_product`
  MODIFY `order_product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_recurring`
--
ALTER TABLE `oc_order_recurring`
  MODIFY `order_recurring_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_recurring_transaction`
--
ALTER TABLE `oc_order_recurring_transaction`
  MODIFY `order_recurring_transaction_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_shipment`
--
ALTER TABLE `oc_order_shipment`
  MODIFY `order_shipment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_status`
--
ALTER TABLE `oc_order_status`
  MODIFY `order_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_total`
--
ALTER TABLE `oc_order_total`
  MODIFY `order_total_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_order_voucher`
--
ALTER TABLE `oc_order_voucher`
  MODIFY `order_voucher_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_product`
--
ALTER TABLE `oc_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- 使用表AUTO_INCREMENT `oc_product_discount`
--
ALTER TABLE `oc_product_discount`
  MODIFY `product_discount_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_product_image`
--
ALTER TABLE `oc_product_image`
  MODIFY `product_image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_product_option`
--
ALTER TABLE `oc_product_option`
  MODIFY `product_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `oc_product_option_value`
--
ALTER TABLE `oc_product_option_value`
  MODIFY `product_option_value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `oc_product_reward`
--
ALTER TABLE `oc_product_reward`
  MODIFY `product_reward_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_product_special`
--
ALTER TABLE `oc_product_special`
  MODIFY `product_special_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_recurring`
--
ALTER TABLE `oc_recurring`
  MODIFY `recurring_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_return`
--
ALTER TABLE `oc_return`
  MODIFY `return_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_return_action`
--
ALTER TABLE `oc_return_action`
  MODIFY `return_action_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_return_history`
--
ALTER TABLE `oc_return_history`
  MODIFY `return_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_return_reason`
--
ALTER TABLE `oc_return_reason`
  MODIFY `return_reason_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_return_status`
--
ALTER TABLE `oc_return_status`
  MODIFY `return_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_review`
--
ALTER TABLE `oc_review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_seo_url`
--
ALTER TABLE `oc_seo_url`
  MODIFY `seo_url_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_setting`
--
ALTER TABLE `oc_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_statistics`
--
ALTER TABLE `oc_statistics`
  MODIFY `statistics_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_stock_status`
--
ALTER TABLE `oc_stock_status`
  MODIFY `stock_status_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_store`
--
ALTER TABLE `oc_store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_tax_class`
--
ALTER TABLE `oc_tax_class`
  MODIFY `tax_class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_tax_rate`
--
ALTER TABLE `oc_tax_rate`
  MODIFY `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_tax_rule`
--
ALTER TABLE `oc_tax_rule`
  MODIFY `tax_rule_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_theme`
--
ALTER TABLE `oc_theme`
  MODIFY `theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_translation`
--
ALTER TABLE `oc_translation`
  MODIFY `translation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_upload`
--
ALTER TABLE `oc_upload`
  MODIFY `upload_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_user`
--
ALTER TABLE `oc_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `oc_user_group`
--
ALTER TABLE `oc_user_group`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_voucher`
--
ALTER TABLE `oc_voucher`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_voucher_history`
--
ALTER TABLE `oc_voucher_history`
  MODIFY `voucher_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_voucher_theme`
--
ALTER TABLE `oc_voucher_theme`
  MODIFY `voucher_theme_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_weight_class`
--
ALTER TABLE `oc_weight_class`
  MODIFY `weight_class_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_zone`
--
ALTER TABLE `oc_zone`
  MODIFY `zone_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `oc_zone_to_geo_zone`
--
ALTER TABLE `oc_zone_to_geo_zone`
  MODIFY `zone_to_geo_zone_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
