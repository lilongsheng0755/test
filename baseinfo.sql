-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 2018-06-20 17:23:01
-- 服务器版本： 5.5.48-log
-- PHP Version: 5.6.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- 表的结构 `baseinfo`
--

CREATE TABLE `baseinfo` (
  `id` int(10) UNSIGNED NOT NULL COMMENT '自增ID',
  `uid` int(10) UNSIGNED NOT NULL COMMENT '用户ID',
  `realname` varchar(20) NOT NULL DEFAULT ' ' COMMENT '真实姓名',
  `idcard` varchar(18) NOT NULL DEFAULT ' ' COMMENT '身份证号码',
  `gender` tinyint(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT '性别',
  `nickname` varchar(40) NOT NULL COMMENT '昵称',
  `icon` varchar(255) NOT NULL DEFAULT ' ' COMMENT '头像',
  `phone` varchar(11) NOT NULL DEFAULT ' ' COMMENT '手机号',
  `vip` tinyint(2) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'VIP等级',
  `area` varchar(100) NOT NULL DEFAULT ' ' COMMENT '所在地区',
  `register` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '注册时间',
  `lastlogin` int(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '最后一次登录时间（包括不走登录，直接打开应用）'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户基本信息表';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `baseinfo`
--
ALTER TABLE `baseinfo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uid` (`uid`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `baseinfo`
--
ALTER TABLE `baseinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
