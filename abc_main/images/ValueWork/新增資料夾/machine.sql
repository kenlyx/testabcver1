-- phpMyAdmin SQL Dump
-- version 2.10.2
-- http://www.phpmyadmin.net
-- 
-- 主機: localhost
-- 建立日期: Aug 25, 2012, 11:18 AM
-- 伺服器版本: 5.0.45
-- PHP 版本: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 資料庫: `abc_main`
-- 
CREATE DATABASE `abc_main` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `abc_main`;

-- --------------------------------------------------------

-- 
-- 資料表格式： `machine`
-- 

CREATE TABLE `machine` (
  `CompanyName` varchar(25) collate utf8_unicode_ci NOT NULL,
  `purchase_month` int(11) NOT NULL,
  `sell_month` int(11) NOT NULL,
  `machine_name` varchar(10) collate utf8_unicode_ci NOT NULL,
  `purchase_year` int(11) NOT NULL,
  `sell_year` int(11) NOT NULL,
  FULLTEXT KEY `CompanyName` (`CompanyName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `machine`
-- 

INSERT INTO `machine` VALUES ('Test', 1, 0, 'cp1_A', 1, 0);
INSERT INTO `machine` VALUES ('Test', 1, 0, 'cut_mB', 1, 0);
INSERT INTO `machine` VALUES ('Test', 1, 0, 'cp1_A', 0, 2);

-- --------------------------------------------------------

-- 
-- 資料表格式： `process_improvement`
-- 

CREATE TABLE `process_improvement` (
  `CompanyName` varchar(255) collate utf8_unicode_ci NOT NULL,
  `year` int(25) NOT NULL,
  `month` int(25) NOT NULL,
  `process` varchar(255) collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `process_improvement`
-- 


-- --------------------------------------------------------

-- 
-- 資料表格式： `production`
-- 

CREATE TABLE `production` (
  `CompanyName` varchar(25) collate utf8_unicode_ci NOT NULL,
  `year` text collate utf8_unicode_ci NOT NULL,
  `month` int(11) NOT NULL,
  `SupA_Monitor` int(11) NOT NULL default '0',
  `SupA_Kernel` int(11) NOT NULL default '0',
  `SupA_KeyBoard` int(11) NOT NULL default '0',
  `SupB_Monitor` int(11) NOT NULL default '0',
  `SupB_Kernel` int(11) NOT NULL default '0',
  `SupB_KeyBoard` int(11) NOT NULL default '0',
  `SupC_Monitor` int(11) NOT NULL default '0',
  `SupC_Kernel` int(11) NOT NULL default '0',
  `SupC_KeyBoard` int(11) NOT NULL default '0',
  `Sum_SupABC_Monitor` int(11) NOT NULL default '0',
  `Sum_SupABC_Kernel` int(11) NOT NULL default '0',
  `Sum_SupABC_KeyBoard` int(11) NOT NULL default '0',
  `SupA_ProductA` int(11) default '0',
  `SupB_ProductA` int(11) default '0',
  `SupC_ProductA` int(11) default '0',
  `SupA_ProductB` int(11) default '0',
  `SupB_ProductB` int(11) default '0',
  `SupC_ProductB` int(11) default '0',
  PRIMARY KEY  (`CompanyName`),
  FULLTEXT KEY `CompanyName` (`CompanyName`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `production`
-- 

INSERT INTO `production` VALUES ('Test', '1', 1, 2000, 1500, 1300, 850, 700, 3000, 200, 150, 20, 3050, 2350, 4320, 0, 0, 0, 0, 0, 0);
INSERT INTO `production` VALUES ('', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 100, 200, 300);

-- --------------------------------------------------------

-- 
-- 資料表格式： `production_`
-- 

CREATE TABLE `production_` (
  `CompanyName` varchar(25) collate utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `SupA_Monitor` int(11) NOT NULL,
  `SupA_Kernel` int(11) NOT NULL,
  `SupA_KeyBoard` int(11) NOT NULL,
  `SupB_Monitor` int(11) NOT NULL,
  `SupB_Kernel` int(11) NOT NULL,
  `SupB_KeyBoard` int(11) NOT NULL,
  `SupC_Monitor` int(11) NOT NULL,
  `SupC_Kernel` int(11) NOT NULL,
  `SupC_KeyBoard` int(11) NOT NULL,
  `Sum_SupABC_Monitor` int(11) NOT NULL,
  `Sum_SupABC_Kernel` int(11) NOT NULL,
  `Sum_SupABC_KeyBoard` int(11) NOT NULL,
  `SupA_ProductA` int(11) NOT NULL,
  `SupB_ProductA` int(11) NOT NULL,
  `SupC_ProductA` int(11) NOT NULL,
  `SupA_ProductB` int(11) NOT NULL,
  `SupB_ProductB` int(11) NOT NULL,
  `SupC_ProductB` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `production_`
-- 

INSERT INTO `production_` VALUES ('Test', 1, 1, 2000, 3000, 4000, 100, 135, 120, 2939, 12345, 45634, 5039, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

-- 
-- 資料表格式： `production_plan`
-- 

CREATE TABLE `production_plan` (
  `CompanyName` varchar(25) collate utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `monitor` varchar(15) collate utf8_unicode_ci NOT NULL,
  `kernel` varchar(15) collate utf8_unicode_ci NOT NULL,
  `keyboard` varchar(15) collate utf8_unicode_ci NOT NULL,
  `cut` varchar(15) collate utf8_unicode_ci NOT NULL,
  `combine1` varchar(15) collate utf8_unicode_ci NOT NULL,
  `check_s` varchar(15) collate utf8_unicode_ci NOT NULL,
  `combine2` varchar(15) collate utf8_unicode_ci NOT NULL,
  `check` varchar(15) collate utf8_unicode_ci NOT NULL,
  `production_plan` varchar(15) collate utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- 列出以下資料庫的數據： `production_plan`
-- 

INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '鍵盤原料檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '在製品檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '成品檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '螢幕原料檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '在製品檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', '', '', '', '', '', '成品檢驗');
INSERT INTO `production_plan` VALUES ('公司名稱', 0, 0, '', '', '', 'machineA', '', '', '', '', '');
