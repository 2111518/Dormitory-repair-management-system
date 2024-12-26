-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3307
-- 產生時間： 2024-12-26 07:55:14
-- 伺服器版本： 10.4.25-MariaDB
-- PHP 版本： 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `final_project`
--

-- --------------------------------------------------------

--
-- 資料表結構 `application`
--

CREATE TABLE `application` (
  `AID` int(10) NOT NULL,
  `ItemID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `UID1` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `Reason` text COLLATE utf8_unicode_ci NOT NULL,
  `AStatue` enum('未審核','採購中','維修中','已完成') COLLATE utf8_unicode_ci NOT NULL,
  `UID2` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Time` datetime NOT NULL DEFAULT current_timestamp(),
  `PS` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `application`
--

INSERT INTO `application` (`AID`, `ItemID`, `UID1`, `Reason`, `AStatue`, `UID2`, `Time`, `PS`) VALUES
(1, 'item003', 'uid001', '腳斷了', '未審核', 'uid002', '2024-12-14 00:00:00', 'NAN');

-- --------------------------------------------------------

--
-- 資料表結構 `item`
--

CREATE TABLE `item` (
  `ItemID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ItemName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ItemStatue` enum('使用中','備用中','維修中') COLLATE utf8_unicode_ci NOT NULL,
  `LID` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `item`
--

INSERT INTO `item` (`ItemID`, `ItemName`, `ItemStatue`, `LID`) VALUES
('item001', '椅子', '使用中', 'loc001'),
('item002', '椅子', '備用中', 'loc002'),
('item003', '床', '維修中', 'loc002');

-- --------------------------------------------------------

--
-- 資料表結構 `location`
--

CREATE TABLE `location` (
  `LID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `LName` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `location`
--

INSERT INTO `location` (`LID`, `LName`) VALUES
('loc001', '301room'),
('loc002', 'depot');

-- --------------------------------------------------------

--
-- 資料表結構 `type`
--

CREATE TABLE `type` (
  `TID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TypeName` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `type`
--

INSERT INTO `type` (`TID`, `TypeName`) VALUES
('tid001', 'student'),
('tid002', 'admin');

-- --------------------------------------------------------

--
-- 資料表結構 `user`
--

CREATE TABLE `user` (
  `UID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `TID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `UName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Account` char(9) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `user`
--

INSERT INTO `user` (`UID`, `TID`, `UName`, `Password`, `Account`) VALUES
('uid001', 'tid001', '王曉明', '1111', '113753208'),
('uid002', 'tid002', '林淑芬', '2222', '113753209');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `application`
--
ALTER TABLE `application`
  ADD PRIMARY KEY (`AID`),
  ADD KEY `ItemID` (`ItemID`),
  ADD KEY `UID1` (`UID1`),
  ADD KEY `UID2` (`UID2`);

--
-- 資料表索引 `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `LID` (`LID`);

--
-- 資料表索引 `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LID`);

--
-- 資料表索引 `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`TID`);

--
-- 資料表索引 `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UID`),
  ADD KEY `TID` (`TID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `application`
--
ALTER TABLE `application`
  MODIFY `AID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`),
  ADD CONSTRAINT `application_ibfk_2` FOREIGN KEY (`UID1`) REFERENCES `user` (`UID`),
  ADD CONSTRAINT `application_ibfk_3` FOREIGN KEY (`UID2`) REFERENCES `user` (`UID`);

--
-- 資料表的限制式 `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`LID`) REFERENCES `location` (`LID`);

--
-- 資料表的限制式 `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`TID`) REFERENCES `type` (`TID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
