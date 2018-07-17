-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2018 at 10:05 AM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.0.30-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `wId` int(11) NOT NULL,
  `tId` int(11) NOT NULL,
  `tName` varchar(255) NOT NULL,
  `tContactPhone` varchar(16) NOT NULL,
  `tDescription` varchar(255) NOT NULL,
  `tPhoto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`wId`, `tId`, `tName`, `tContactPhone`, `tDescription`, `tPhoto`) VALUES
(10, 2, 'Help me!', '+7123456789', 'i don\'t know how to start the computer', NULL),
(1, 3, 'System Testing in progress', '+7999999999', 'Just for Admin, don\'t forget to do smthg!', '/lib/taskPhotos/perf.jpg'),
(1, 4, 'Coffee machine is not working', '+7091111111', 'I cant drink a cup of morning coffee', NULL),
(11, 5, 'anotherTask', '89158508585', 'Description or Описание 12345', NULL),
(10, 16, 'Фотография', '+7915555555', 'проверка загрузки фотографий', '/lib/taskPhotos/perf.jpg'),
(11, 18, 'Фотография', '+7915555555', '2222222222222222222222222', '/lib/taskPhotos/perf2.jpg'),
(10, 19, 'Проверка', '8919123456', 'Проверка подсвечивания последнего добавленного задания (заявки)', ''),
(10, 20, 'проверка 2', '+7915555555', 'еще одна проверка выделения последней добавленной записи', '/lib/taskPhotos/phone.png'),
(11, 21, 'проверка 3', '+7915555555', 'йййййййййййййййййййййййййййййййййййй', ''),
(10, 22, 'еще одна проверка', '+7915555555', 'проверяем загрузку фото с переписанной функцией', '/lib/taskPhotos/cd354fa959097725a7a83f9c5b32b78e'),
(11, 23, 'еще одна заявка', '84742888888', 'что-то не работает и это что-то надо починить', '/lib/taskPhotos/b5fb50d43d60cdafc8c41ae8f9e785f1'),
(10, 24, 'Фотография', '+7915555555', 'qweeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', ''),
(10, 25, 'еще одна проверка 4', '8919123456', 'qqqqqqqqqqqqqqqqqqqqqqqq', ''),
(12, 26, 'Абракадабра', '84742888888', 'адракадабра проверка нового таска', ''),
(14, 27, 'Моя заявка', '+7915555555', 'В очередной раз засорился унитаз в мужском туалете', '');

-- --------------------------------------------------------

--
-- Table structure for table `worker`
--

DROP TABLE IF EXISTS `worker`;
CREATE TABLE `worker` (
  `wId` int(11) NOT NULL,
  `wLogin` varchar(255) NOT NULL,
  `wPasswordHash` varchar(255) NOT NULL,
  `wEmail` varchar(255) NOT NULL,
  `wRole` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `worker`
--

INSERT INTO `worker` (`wId`, `wLogin`, `wPasswordHash`, `wEmail`, `wRole`) VALUES
(1, 'Admin', '$2y$10$LlmVN/Yt9blamOrBfj9Ed.w9y1DHm/wG3NTRWmnLTjGRHYEKDe41G', 'admin@admin.com', 1),
(10, 'sergey', '$2y$10$K7bvO0TUJKRtJGQKYpKzteMnXBDOSE.G9ZkCr8/HlxAzapJWXXute', 'kozadaev@intaro.email', NULL),
(11, 'Sigismund', '$2y$10$C2QNb31sQL4CbCTLuzmDEuCha7XYNsiKcvxkf3aDdBBfLa5S/POoC', 'sigismund@mail.com', NULL),
(12, 'Abracadabra', '$2y$10$LnrFSUcHzOUuKHljZzANU.yhzkhtY0ytk1ZvVcyWsHeq/RtZmRkK6', 'abra@cada.bra', NULL),
(14, 'newuser', '$2y$10$ZVWlc2EAeUKqfJ5/ywahe.ezXXTyR1Q9bdDcvJnjWKZquhqrl83gy', 'newuser@mail.com', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`tId`),
  ADD KEY `wId` (`wId`);

--
-- Indexes for table `worker`
--
ALTER TABLE `worker`
  ADD PRIMARY KEY (`wId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `tId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `worker`
--
ALTER TABLE `worker`
  MODIFY `wId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `FK_Task_Add_By_Worker` FOREIGN KEY (`wId`) REFERENCES `worker` (`wId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
