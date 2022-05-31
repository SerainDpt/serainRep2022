-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2022-05-31 07:30:12
-- 伺服器版本： 10.4.24-MariaDB
-- PHP 版本： 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `ordering_system`
--

-- --------------------------------------------------------

--
-- 資料表結構 `guest`
--

CREATE TABLE `guest` (
  `guest_id` varchar(20) NOT NULL,
  `guset_password` varchar(30) NOT NULL,
  `guest_email` varchar(20) NOT NULL,
  `guest_phone` varchar(20) NOT NULL,
  `guest_address` text NOT NULL,
  `guest_name` char(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- 傾印資料表的資料 `guest`
--

INSERT INTO `guest` (`guest_id`, `guset_password`, `guest_email`, `guest_phone`, `guest_address`, `guest_name`) VALUES
('pikachu', '1111111', '11@11.11.11', '0911111111', '台北市北投區馬路巷11樓', 'PIKACHU');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `guest_email` (`guest_email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
