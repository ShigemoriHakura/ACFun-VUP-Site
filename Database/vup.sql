-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-09-13 08:33:40
-- 服务器版本： 5.6.49-log
-- PHP 版本： 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `vup`
--

-- --------------------------------------------------------

--
-- 表的结构 `vup_site_admin`
--

CREATE TABLE `vup_site_admin` (
  `id` int(11) NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `reg_date` date NOT NULL,
  `last_login_date` date NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vup_site_log`
--

CREATE TABLE `vup_site_log` (
  `id` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `level` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vup_up_data`
--

CREATE TABLE `vup_up_data` (
  `uperid` int(11) NOT NULL,
  `up_date` date NOT NULL,
  `rawdata` text NOT NULL,
  `followers` int(11) NOT NULL,
  `following` int(11) NOT NULL,
  `name` text NOT NULL,
  `signature` text NOT NULL,
  `contentCount` int(11) NOT NULL,
  `headUrl` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vup_up_list`
--

CREATE TABLE `vup_up_list` (
  `id` int(11) NOT NULL,
  `uperid` int(11) NOT NULL,
  `registerTime` text NOT NULL,
  `name` text NOT NULL,
  `add_date` date NOT NULL,
  `last_date` text NOT NULL,
  `enabled` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `vup_up_log`
--

CREATE TABLE `vup_up_log` (
  `id` int(11) NOT NULL,
  `uperid` int(11) NOT NULL,
  `add_date` date NOT NULL,
  `before_data_id` int(11) NOT NULL,
  `after_data_id` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转储表的索引
--

--
-- 表的索引 `vup_site_admin`
--
ALTER TABLE `vup_site_admin`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `vup_up_list`
--
ALTER TABLE `vup_up_list`
  ADD PRIMARY KEY (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
