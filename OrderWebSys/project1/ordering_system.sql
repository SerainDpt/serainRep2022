-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2019 年 03 月 13 日 17:13
-- 伺服器版本: 10.1.37-MariaDB
-- PHP 版本： 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- 資料表的匯出資料 `guest`
--

INSERT INTO `guest` (`guest_id`, `guset_password`, `guest_email`, `guest_phone`, `guest_address`, `guest_name`) VALUES
('abc', '123', 'abc@a.b.c', '0800956956', '地球村北半球東亞洲台灣國', ''),
('admin', 'admin123456', 'admin@123.125', '031222', 'USA', ''),
('cap', '1234567', 'capusa@shields.com', '0911956956', '台北市大安區天龍城天龍路天龍巷999號', ''),
('ironman', '123', 'tony@avenger.com', '225146584', 'newyork', ''),
('PeterParker', 'spiderman', 'spiderman@sony.com', '0900956956', '台北市信義區忠孝東路六段', ''),
('spiderman', '123', '123@1.2.3.1.5', '09875555555', 'Queen', ''),
('thor', '12345678', 'thor@asiga.com', '0911956955', '阿斯嘉中正區彩虹橋阿姆羅薩諾斯卡羅丹佛', 'God of Thunder');

-- --------------------------------------------------------

--
-- 資料表結構 `meal`
--

CREATE TABLE `meal` (
  `meal_id` smallint(2) NOT NULL,
  `meal_name` varchar(10) NOT NULL,
  `price` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- 資料表的匯出資料 `meal`
--

INSERT INTO `meal` (`meal_id`, `meal_name`, `price`) VALUES
(1, '漢堡', 50),
(2, '薯條', 30),
(3, '霜淇淋', 25),
(4, '仙草凍', 40),
(99, 'initialmal', 9999999);

-- --------------------------------------------------------

--
-- 資料表結構 `orderlist`
--

CREATE TABLE `orderlist` (
  `ordernum` int(2) NOT NULL,
  `meal_id` smallint(2) NOT NULL,
  `guest_id` varchar(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `stack_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- 資料表的匯出資料 `orderlist`
--

INSERT INTO `orderlist` (`ordernum`, `meal_id`, `guest_id`, `order_id`, `stack_number`) VALUES
(1, 1, 'abc', 201903110002, 1),
(1, 1, 'abc', 201903110003, 1),
(1, 2, 'abc', 201903110003, 2),
(1, 1, 'peterparker', 201903110004, 1),
(1, 1, 'abc', 201903120005, 1),
(1, 1, 'abc', 201903120005, 2),
(1, 1, 'abc', 201903120005, 3),
(1, 1, 'abc', 201903120005, 4),
(1, 1, 'abc', 201903120005, 5),
(1, 1, 'abc', 201903120005, 6),
(1, 1, 'abc', 201903120005, 7),
(1, 1, 'abc', 201903120005, 8),
(1, 3, 'abc', 201903120006, 1),
(1, 4, 'abc', 201903120007, 1),
(5, 3, 'abc', 201903120007, 2),
(1, 1, 'abc', 201903120008, 1),
(1, 1, 'abc', 201903120008, 2),
(1, 1, 'abc', 201903120009, 1),
(1, 2, 'abc', 201903120009, 2),
(1, 3, 'abc', 201903120009, 3),
(1, 4, 'abc', 201903120009, 4),
(1, 1, 'abc', 201903130010, 1),
(1, 2, 'abc', 201903130010, 2),
(1, 3, 'abc', 201903130010, 3),
(6, 4, 'abc', 201903130010, 5);

-- --------------------------------------------------------

--
-- 資料表結構 `takeinfomation`
--

CREATE TABLE `takeinfomation` (
  `takeway` varchar(5) NOT NULL,
  `takedate` varchar(20) NOT NULL,
  `taketime` varchar(10) NOT NULL,
  `totalsum` int(20) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `delivery_add` varchar(30) NOT NULL,
  `delivery_pho` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=big5;

--
-- 資料表的匯出資料 `takeinfomation`
--

INSERT INTO `takeinfomation` (`takeway`, `takedate`, `taketime`, `totalsum`, `order_id`, `delivery_add`, `delivery_pho`) VALUES
('initi', 'initial', 'initial', 9999999, 0, '', ''),
('外送', '2019-03-13', '12:00', 50, 201903110002, '地球村北半球東亞洲台灣國天龍城99號', ''),
('外送', '2019-03-12', '11:30', 80, 201903110003, '地球村北半球東亞洲台灣國天龍區', '0900956956'),
('外帶', '2019-03-11', '11:30', 50, 201903110004, '', ''),
('外帶', '2019-03-12', '11:30', 400, 201903120005, '', '0800956956'),
('外帶', '2019-03-12', '12:00', 25, 201903120006, '', '0800956956'),
('外送', '2019-03-26', '12:30', 165, 201903120007, '地球村北半球東亞洲台灣國', '0800956956'),
('外帶', '2019-03-12', '11:30', 100, 201903120008, '', '0800956956'),
('外帶', '2019-03-12', '11:30', 145, 201903120009, '', '0800956956'),
('外帶', '2019-03-13', '11:30', 345, 201903130010, '', '0800956956');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guest_id`),
  ADD UNIQUE KEY `guest_id` (`guest_id`),
  ADD UNIQUE KEY `guest_email` (`guest_email`);

--
-- 資料表索引 `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`meal_id`),
  ADD UNIQUE KEY `meal_id` (`meal_id`);

--
-- 資料表索引 `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`order_id`,`stack_number`),
  ADD KEY `meal_id` (`meal_id`,`guest_id`),
  ADD KEY `meal_id_2` (`meal_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- 資料表索引 `takeinfomation`
--
ALTER TABLE `takeinfomation`
  ADD PRIMARY KEY (`order_id`),
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `orderlist`
--
ALTER TABLE `orderlist`
  ADD CONSTRAINT `orderlist_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guest` (`guest_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orderlist_ibfk_4` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`meal_id`),
  ADD CONSTRAINT `orderlist_ibfk_5` FOREIGN KEY (`order_id`) REFERENCES `takeinfomation` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
