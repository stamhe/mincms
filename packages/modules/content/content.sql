-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 08 月 01 日 03:50
-- 服务器版本: 5.5.8-log
-- PHP 版本: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `mincms`
--

-- --------------------------------------------------------

--
-- 表的结构 `content_float`
--

CREATE TABLE IF NOT EXISTS `content_float` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_i18n`
--

CREATE TABLE IF NOT EXISTS `content_i18n` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `nid` int(11) NOT NULL,
  `field` varchar(200) NOT NULL,
  `body` text NOT NULL,
  `lang` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_int`
--

CREATE TABLE IF NOT EXISTS `content_int` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_text`
--

CREATE TABLE IF NOT EXISTS `content_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_type_field`
--

CREATE TABLE IF NOT EXISTS `content_type_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(200) NOT NULL,
  `name` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  `pid` int(11) NOT NULL,
  `created` int(11) NOT NULL,
  `updated` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `relate` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_type_field_view`
--

CREATE TABLE IF NOT EXISTS `content_type_field_view` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) NOT NULL,
  `list` text NOT NULL,
  `search` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_type_plugin`
--

CREATE TABLE IF NOT EXISTS `content_type_plugin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `memo` varchar(255) NOT NULL,
  `field_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_type_validate`
--

CREATE TABLE IF NOT EXISTS `content_type_validate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_type_widget`
--

CREATE TABLE IF NOT EXISTS `content_type_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `memo` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `content_varchar`
--

CREATE TABLE IF NOT EXISTS `content_varchar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `content_type_field` (`id`, `slug`, `name`, `memo`, `pid`, `created`, `updated`, `uid`, `sort`, `relate`) VALUES
(1,	'taxonomy',	'taxonomy',	'',	0,	0,	0,	0,	0,	NULL),
(2,	'name',	'name',	'',	1,	0,	0,	0,	0,	NULL),
(3,	'pid',	'pid',	'',	1,	0,	0,	0,	0,	'node_taxonomy');

INSERT INTO `content_type_validate` (`id`, `field_id`, `value`) VALUES
(1,	1,	'a:0:{}'),
(2,	2,	'a:1:{s:8:\"required\";i:1;}'),
(3,	3,	'a:0:{}');

INSERT INTO `content_type_widget` (`id`, `field_id`, `name`, `memo`) VALUES
(1,	2,	'input',	''),
(2,	3,	'relationOne',	'');


CREATE TABLE IF NOT EXISTS `node_taxonomy` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `created` int(11) NOT NULL,
		  `updated` int(11) NOT NULL,
		  `uid` int(11) NOT NULL,
		  `admin` tinyint(1) NOT NULL DEFAULT '1',
		  `display` tinyint(1) NOT NULL DEFAULT '1',
		  `sort` int(11) NOT NULL DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ; 
CREATE TABLE IF NOT EXISTS `node_taxonomy_relate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nid` int(11) NOT NULL,
  `fid` int(11) NOT NULL, 
  `value` int(11) NOT NULL, 
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
