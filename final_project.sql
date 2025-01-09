-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- 主機： localhost:3307
-- 產生時間： 2025-01-09 18:17:00
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
  `AState` enum('未審核','採購中','維修中','已完成') COLLATE utf8_unicode_ci NOT NULL,
  `UID2` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'uid003',
  `Time` datetime NOT NULL DEFAULT current_timestamp(),
  `PS` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `application`
--

INSERT INTO `application` (`AID`, `ItemID`, `UID1`, `Reason`, `AState`, `UID2`, `Time`, `PS`) VALUES
(1, 'item003', 'uid001', '腳斷了', '維修中', 'uid002', '2024-12-14 00:00:00', '2'),
(2, 'item004', 'uid001', 'test', '已完成', 'uid002', '2024-12-27 00:28:02', 'TEST'),
(3, 'item006', 'uid001', '', '採購中', 'uid003', '2024-12-27 00:33:29', NULL),
(5, 'item007', 'uid001', 'test2', '維修中', 'uid002', '2024-12-27 01:08:02', NULL),
(11, 'item011', 'uid001', '', '未審核', 'uid003', '2024-12-27 00:33:29', NULL),
(15, 'item023', 'uid011', '漏水', '維修中', 'uid002', '2024-09-19 01:08:02', '零件購買中'),
(16, 'item017', 'uid013', '故障', '採購中', 'uid003', '2024-09-19 01:08:02', '零件不夠'),
(17, 'item024', 'uid007', '故障', '維修中', 'uid003', '2024-09-19 01:08:02', '零件購買中'),
(18, 'item021', 'uid010', '故障test', '維修中', 'uid003', '2024-09-09 01:08:02', '零件不夠'),
(19, 'item025', 'uid001', 'test', '已完成', 'uid002', '2024-12-02 00:28:02', 'TEST'),
(20, 'item009', 'uid001', 'test', '已完成', 'uid002', '2024-10-15 00:28:02', 'TEST'),
(21, 'item024', 'uid007', '故障', '採購中', 'uid003', '2024-09-19 01:08:02', '零件購買中'),
(22, 'item029', 'uid004', 'test', '已完成', 'uid002', '2024-10-04 00:28:02', 'TEST'),
(23, 'item010', 'uid007', 'test', '已完成', 'uid002', '2024-09-11 00:28:02', 'TEST'),
(24, 'item032', 'uid013', 'test', '已完成', 'uid003', '2024-09-11 00:28:02', 'TEST'),
(25, 'item016', 'uid015', 'test', '已完成', 'uid003', '2024-09-15 00:28:02', 'TEST'),
(26, 'item032', 'uid009', 'test', '已完成', 'uid002', '2024-09-30 00:28:02', 'TEST'),
(27, 'item014', 'uid014', 'test', '已完成', 'uid003', '2024-08-19 00:28:02', 'TEST'),
(28, 'item029', 'uid004', 'test', '已完成', 'uid003', '2024-07-15 00:28:02', 'TEST'),
(29, 'item023', 'uid013', 'test', '已完成', 'uid003', '2024-07-23 00:28:02', 'TEST'),
(30, 'item016', 'uid015', 'test', '已完成', 'uid002', '2024-09-15 00:28:02', 'TEST'),
(31, 'item016', 'uid015', 'test', '已完成', 'uid002', '2024-09-05 00:28:02', 'TEST'),
(32, 'item016', 'uid015', 'test', '已完成', 'uid002', '2024-09-22 00:28:02', 'TEST');

-- --------------------------------------------------------

--
-- 資料表結構 `item`
--

CREATE TABLE `item` (
  `ItemID` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ItemName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ItemState` enum('使用中','備用中','維修中') COLLATE utf8_unicode_ci NOT NULL,
  `LID` varchar(10) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 傾印資料表的資料 `item`
--

INSERT INTO `item` (`ItemID`, `ItemName`, `ItemState`, `LID`) VALUES
('item001', '桌', '使用中', 'loc004'),
('item002', '椅子', '備用中', 'loc002'),
('item003', '床', '維修中', 'loc002'),
('item004', '床', '使用中', 'loc003'),
('item005', '床', '使用中', 'loc004'),
('item006', '椅子', '使用中', 'loc003'),
('item007', '椅子', '維修中', 'loc004'),
('item008', '桌子', '使用中', 'loc008'),
('item009', '書櫃', '使用中', 'loc006'),
('item010', '冷氣', '使用中', 'loc009'),
('item011', '椅子', '使用中', 'loc012'),
('item012', '椅子', '使用中', 'loc012'),
('item013', '椅子', '使用中', 'loc004'),
('item014', '冷氣', '維修中', 'loc012'),
('item015', '冷氣', '備用中', 'loc001'),
('item016', '冷氣', '使用中', 'loc001'),
('item017', '書櫃', '維修中', 'loc007'),
('item019', '書櫃', '使用中', 'loc002'),
('item020', '書櫃', '維修中', 'loc003'),
('item021', '書櫃', '使用中', 'loc004'),
('item022', '冷氣', '使用中', 'loc005'),
('item023', '馬桶', '維修中', 'loc002'),
('item024', '馬桶', '維修中', 'loc003'),
('item025', '馬桶', '使用中', 'loc004'),
('item026', '馬桶', '', 'loc005'),
('item027', '馬桶', '使用中', 'loc006'),
('item028', '馬桶', '使用中', 'loc007'),
('item029', '馬桶', '使用中', 'loc007'),
('item030', '馬桶', '使用中', 'loc008'),
('item031', '書櫃', '使用中', 'loc007'),
('item032', '書櫃', '備用中', 'loc002'),
('item033', '冷氣', '備用中', 'loc002'),
('item034', '書櫃', '備用中', 'loc002'),
('item035', '椅子', '使用中', 'loc001');

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
('loc002', 'depot'),
('loc003', '302room'),
('loc004', '303room'),
('loc005', '304room'),
('loc006', '305room'),
('loc007', '405room'),
('loc008', '404room'),
('loc009', '403room'),
('loc010', '402room'),
('loc011', '401room'),
('loc012', 'office');

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
('uid002', 'tid002', '林淑芬', '2222', '113753209'),
('uid003', 'tid002', '野原新', '2222', '113753210'),
('uid004', 'tid001', '小丸子', '1111', '113753212'),
('uid005', 'tid001', '宇智波', '1111', '113753213'),
('uid006', 'tid001', '毛利蘭', '1111', '113753214'),
('uid007', 'tid001', '李里維', '1111', '113753216'),
('uid008', 'tid001', '夏由杰', '1111', '113753217'),
('uid009', 'tid001', '林靜香', '1111', '113753218'),
('uid010', 'tid001', '沈花輪', '1111', '113753219'),
('uid011', 'tid001', '野比雄', '1111', '113753220'),
('uid012', 'tid001', '工藤新', '1111', '113753221'),
('uid013', 'tid001', '潔世一', '1111', '113753222'),
('uid014', 'tid001', '蜂樂迴', '1111', '113753223'),
('uid015', 'tid001', '吳條物', '1111', '113753224');

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
  ADD UNIQUE KEY `ItemID` (`ItemID`),
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
  ADD UNIQUE KEY `UID` (`UID`,`Account`),
  ADD KEY `TID` (`TID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `application`
--
ALTER TABLE `application`
  MODIFY `AID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `application`
--
ALTER TABLE `application`
  ADD CONSTRAINT `application_ibfk_1` FOREIGN KEY (`ItemID`) REFERENCES `item` (`ItemID`) ON DELETE CASCADE,
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
