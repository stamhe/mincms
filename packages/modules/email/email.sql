 

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
-- 表的结构 `email_config`
--

CREATE TABLE IF NOT EXISTS `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_email` varchar(200) NOT NULL,
  `from_name` varchar(200) NOT NULL,
  `smtp` varchar(200)  NULL,
  `from_password` varchar(200)  NULL,
  `type` int(11) NOT NULL,
  `port` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `email_send`
--

CREATE TABLE IF NOT EXISTS `email_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_email` varchar(200) NOT NULL,
  `to_name` varchar(200) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `attach` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE `email_template` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `slug` varchar(200) NOT NULL,
  `memo` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL, 
  `body` text NOT NULL
) COMMENT='' ENGINE='MyISAM' COLLATE 'utf8_general_ci';
INSERT INTO `email_template` (`id`, `slug`, `memo`, `body`, `title`) VALUES
(1,	'admin_forgot_password',	'后台找回密码',	'<p>您的用户名是 &nbsp;{username}&nbsp;</p><p>请点击以下链接找回密码 &nbsp;</p><p>{link}</p>\r\n',	'感谢使用找回密码功能 '),
(2,	'admin_reset_password',	'管理员重置密码',	'<p>感谢您 {username} 使用重置密码功能</p><p>请牢记您现在的密码 {password}</p><p><br></p>',	'重置您的密码');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
