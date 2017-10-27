-- phpMyAdmin SQL Dump
-- version 4.0.10.19
-- https://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-10-24 23:52:25
-- 服务器版本: 5.5.54-log
-- PHP 版本: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `soarteam_cn`
--

-- --------------------------------------------------------

--
-- 表的结构 `img`
--

CREATE TABLE IF NOT EXISTS `img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class` varchar(20) NOT NULL COMMENT '班级',
  `img` int(11) NOT NULL DEFAULT '0' COMMENT '是否进行投票',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '总票数',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `img`
--

INSERT INTO `img` (`id`, `class`, `img`, `count`) VALUES
(1, '工管6班', 1, 0),
(2, '会计10班', 0, 0),
(3, '人力2班', 1, 0),
(4, '会计5班', 1, 0),
(5, '工管2班', 1, 0),
(6, '人力4班,会计4, 6班', 1, 0),
(7, '市营1, 2班', 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_user` varchar(50) NOT NULL COMMENT '管理员账号',
  `admin_pw` varchar(50) NOT NULL COMMENT '管理员密码',
  `admin_time` varchar(50) NOT NULL COMMENT '管理员登录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `admin_user`, `admin_pw`, `admin_time`) VALUES
(1, 'xingkongbest', '2642c2f7168f57a81e14a6743f40fc1d', ' 1508573166');

-- --------------------------------------------------------

--
-- 表的结构 `vote`
--

CREATE TABLE IF NOT EXISTS `vote` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) NOT NULL COMMENT '微信用户openid',
  `flag` int(11) NOT NULL DEFAULT '0' COMMENT '是否投票',
  `ip` varchar(50) DEFAULT NULL COMMENT '客户端IP',
  `class` varchar(50) DEFAULT NULL COMMENT '班级',
  `time` varchar(50) DEFAULT NULL COMMENT '时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
