-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2018-06-03 13:18:29
-- 服务器版本： 5.5.60-log
-- PHP Version: 7.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wnz`
--

-- --------------------------------------------------------

--
-- 表的结构 `hy_user_style`
--

CREATE TABLE IF NOT EXISTS `hy_user_style` (
  `img` varchar(225) NOT NULL,
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `hy_user_style`
--

INSERT INTO `hy_user_style` (`img`, `id`, `uid`) VALUES
('http://wnz.com/upload/userfile/1/21232f297a57a5a743894a0e4a801fc3.jpg', 6, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hy_user_style`
--
ALTER TABLE `hy_user_style`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hy_user_style`
--
ALTER TABLE `hy_user_style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
