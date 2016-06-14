-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2016-06-14 13:46:42
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `star`
--

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `uid` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) CHARACTER SET utf8 NOT NULL,
  `sex` varchar(2) CHARACTER SET utf8 NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone` varchar(11) CHARACTER SET utf8 NOT NULL,
  `grade` varchar(4) CHARACTER SET utf8 NOT NULL,
  `school` varchar(20) CHARACTER SET utf8 NOT NULL,
  `company` varchar(20) CHARACTER SET utf8 NOT NULL,
  `major` varchar(20) CHARACTER SET utf8 NOT NULL,
  `location` varchar(20) CHARACTER SET utf8 NOT NULL,
  `imgname` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `words` text CHARACTER SET utf8,
  `token` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `reg_time` varchar(40) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
