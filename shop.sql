-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 17, 2021 at 04:52 PM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(6) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordering` int(11) DEFAULT NULL,
  `Visibilty` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Comment` tinyint(4) NOT NULL DEFAULT 0,
  `Allow_Ads` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordering`, `Visibilty`, `Allow_Comment`, `Allow_Ads`) VALUES
(13, 'Hand Made', 'Hand Made Items ', 0, 1, 1, 1, 1),
(14, 'Computers', 'Computer Item', 0, 2, 0, 0, 0),
(15, 'Cell Phones', 'Cell Phones', 0, 3, 0, 0, 0),
(16, 'Clothing', 'Clothing And Fashion', 0, 4, 0, 0, 0),
(17, 'Tools', 'Home Tools', 0, 5, 0, 0, 0),
(19, 'blackpary', 'blackpary phone for all ', 17, 3, 0, 0, 0),
(20, 'Hammers', 'Hammers Desc', 17, 4, 0, 0, 0),
(21, 'Games', 'New for kids', 17, 5, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(12, 'HEllo World HEllo World HEllo World ', 1, '2020-11-03', 20, 25),
(13, 'Nice Item Thanks s', 1, '2020-11-18', 20, 25),
(35, 'test comment', 1, '2020-11-30', 20, 25),
(36, 'test comment', 1, '2020-11-30', 20, 25),
(37, 'test comment', 1, '2020-11-30', 20, 25),
(38, 'This is second comment', 1, '2020-11-30', 20, 25),
(39, 'This is second comment', 1, '2020-11-30', 20, 25),
(40, 'Hello world', 1, '2021-01-04', 32, 25),
(41, 'Hello world', 1, '2021-01-04', 32, 25);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `Item_ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Price` varchar(255) NOT NULL,
  `Add_Date` date NOT NULL,
  `Country_Made` varchar(255) NOT NULL,
  `Image` varchar(255) NOT NULL DEFAULT '0',
  `Status` varchar(255) NOT NULL,
  `Rating` smallint(6) NOT NULL DEFAULT 0,
  `Approve` tinyint(4) NOT NULL DEFAULT 0,
  `Cat_ID` int(11) NOT NULL,
  `Member_ID` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`Item_ID`, `Name`, `Description`, `Price`, `Add_Date`, `Country_Made`, `Image`, `Status`, `Rating`, `Approve`, `Cat_ID`, `Member_ID`, `tags`) VALUES
(19, 'Speaker', 'A good Spaker For Computer', '100', '2020-11-24', 'china', '0', '1', 0, 1, 14, 9, ''),
(20, 'Yeti Blue Mic', 'Very Good Micreophone', '28', '2020-11-24', 'sudan', '0', '1', 0, 1, 14, 25, ''),
(21, 'IPhone 6s', 'Apple IPhone 6s', '100', '2020-11-24', 'Tchad', '0', '1', 0, 1, 15, 4, ''),
(22, 'Magic Mouse', 'The New Magic Mouse For You', '10', '2020-11-24', 'china', '0', '1', 0, 1, 14, 4, ''),
(25, 'Canon D610', 'Camera For Photographer', '150', '2020-11-30', 'sudan', '0', '1', 0, 1, 15, 25, ''),
(27, 'Ludo Game 4', 'Hand Made Items D', '20', '2020-11-30', 'Tchad', '0', '3', 0, 1, 14, 25, ''),
(28, 'Speaker 4', 'Computer Item For DC', '44', '2020-11-30', 'USA', '0', '2', 0, 1, 17, 25, ''),
(29, 'My Item', 'This Is Description For My Item', '45', '2020-12-14', 'china', '0', '2', 0, 1, 16, 25, 'Test,Elzero,Discount'),
(30, 'Wooden Game', 'New PS4 Game', '44', '2020-12-16', 'sudan', '0', '1', 0, 1, 13, 28, 'Elzero,Hand,Discount,Gurantee'),
(32, 'Daiblo III', 'New PS4 Game', '70', '2020-12-16', 'USA', '0', '1', 0, 1, 14, 25, 'RPG,Online,Game'),
(33, 'Super Hero', 'New PS4 Game', '90', '2020-12-17', 'Eroup', '0', '3', 0, 1, 14, 25, 'RPG,Online,Game'),
(34, 'Iphone 6s', 'a good phone ', '34', '2021-03-08', 'eroup', '0', '3', 0, 0, 15, 25, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `GroupID` int(11) NOT NULL DEFAULT 0,
  `TrustStatus` int(11) NOT NULL DEFAULT 0,
  `RegStatus` int(11) NOT NULL DEFAULT 0,
  `Date` date NOT NULL,
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `FullName`, `GroupID`, `TrustStatus`, `RegStatus`, `Date`, `avatar`) VALUES
(1, 'maati', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'maati@gmail.com', 'Maati Mohammed', 1, 0, 1, '0000-00-00', ''),
(4, 'Albraa', '403d9917c3e950798601addf7ba82cd3c83f344b', 'Albraa@hotmail.com', 'Albraa Altegani', 0, 0, 1, '0000-00-00', ''),
(9, 'Hamouda', '37e6767616538c4f67a08eb854ee7510b926d032', 'Hamouda@gmail.com', 'Mohamed Hamed Hamouda', 0, 0, 1, '0000-00-00', ''),
(17, 'Noon Cool', '32109cd6ea137e587a46880f54d8838f476c0b04', 'Noon@gmail.com', 'Noon Mohamed', 0, 0, 1, '2020-10-09', ''),
(24, 'Apple', '51eac6b471a284d3341d8c0c63d0f1a286262a18', 'Apple@gmail.com', 'Apple ', 0, 0, 1, '2020-11-25', ''),
(25, 'majdy', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', 'majdy@gmail.com', 'Majdy Adam', 0, 0, 1, '2020-11-19', ''),
(26, 'mona', '63ab910cb3a7bc89faae5a46aa337aa22f5f4d30', 'gh@gmail.com', NULL, 0, 0, 1, '2020-11-27', ''),
(27, 'ahmed', 'f2231d2871e690a2995704f7a297bd7bc64be720', 'gjgh@gmail.com', NULL, 0, 0, 1, '2020-11-27', ''),
(28, 'faisal', '63ab910cb3a7bc89faae5a46aa337aa22f5f4d30', 'fff@gmail.com', ' faisal faisal ', 0, 0, 1, '2020-12-15', ''),
(29, 'maghdd', 'bf9c01699b0ef9ea9d7287126c20b8ce52836021', 'jdjdj@gmail.com', 'mohamd maiadd', 0, 0, 1, '2020-12-17', '58551_a12cf6b870ec453bb26de6a750ffe1d9.jpg'),
(30, 'aliss', '12d860be3734010a62e9b1015e75471d61dbceb5', 'aki@gmail.com', NULL, 0, 0, 0, '2021-02-22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Name` (`Name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `items_comment` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`Item_ID`),
  ADD KEY `member_1` (`Member_ID`),
  ADD KEY `cat_1` (`Cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`),
  ADD UNIQUE KEY `Username` (`Username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `Item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_comment` FOREIGN KEY (`item_id`) REFERENCES `items` (`Item_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`Cat_ID`) REFERENCES `categories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`Member_ID`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
