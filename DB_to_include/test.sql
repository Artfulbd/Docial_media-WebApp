-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2019 at 04:24 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.6

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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `startdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `startdate`) VALUES
(3, 'Salman Meem sahel', '2019-04-12 15:27:50'),
(5, 'Chotolok Adib', '2019-04-12 15:41:18'),
(4, 'Gorib Seyam', '2019-04-12 15:42:17'),
(6, 'Saria Tasfia', '2019-04-12 20:26:17');

-- --------------------------------------------------------

--
-- Table structure for table `alluser`
--

CREATE TABLE `alluser` (
  `id` int(11) DEFAULT NULL,
  `nid` int(11) NOT NULL,
  `email` varchar(15) DEFAULT NULL,
  `pass` varchar(30) DEFAULT NULL,
  `name` varchar(40) DEFAULT NULL,
  `fname` varchar(40) DEFAULT NULL,
  `mname` varchar(40) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `bday` date DEFAULT NULL,
  `addr` varchar(70) DEFAULT NULL,
  `ac_post` int(11) NOT NULL,
  `re_post` int(11) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `admin_req` tinyint(1) NOT NULL DEFAULT '0',
  `reqTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alluser`
--

INSERT INTO `alluser` (`id`, `nid`, `email`, `pass`, `name`, `fname`, `mname`, `gender`, `bday`, `addr`, `ac_post`, `re_post`, `is_admin`, `admin_req`, `reqTime`) VALUES
(7, 1111, 'a@b.c', 'Ab12', 'Kowshin Apu', 'cvghcfhcf', 'hcmfhkcf', 'female', '2019-04-13', ';p.;[.l', 0, 0, 0, 0, NULL),
(4, 1222, 'sdlkjb@kjh.com', 'Aa12', 'Gorib Seyam', 'Asdf', 'Lkj', 'female', '2019-04-10', 'NatunBazar, Dhaka', 0, 0, 1, 0, NULL),
(1, 1234, 's@b.com', 'Aa12', 'Uff', 'dfa', 'asdf', 'male', '2019-05-05', 'sfdgs addr', 0, 0, 0, 0, NULL),
(2, 1722, 'md.artful.bd@gm', 'Aa12', 'Md Ariful Haque', 'sdfasd sdf', 'sdfasd sdf', 'male', '2019-04-05', '5\r\nHahahehhoho', 2, 1, 0, 0, NULL),
(5, 1733, 'adib7ctg@gmail.', 'Aa12', 'Chotolok Adib', 'lkjb', 'lkjb', 'female', '2019-04-10', 'Bashundhara bosti', 0, 0, 1, 0, NULL),
(3, 1813, 'a@g.com', 'Abc123', 'Salman Meem sahel', 'A', 'A', 'male', '2018-04-08', 'Nsu', 1, 3, 1, 0, NULL),
(6, 9876, 'saria@gmail.com', 'Saria81', 'Saria Tasfia', 'asdf', 'wqe sdfs', 'female', '1996-10-29', 'dhanmondi', 1, 0, 1, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) DEFAULT NULL,
  `p_id` int(11) NOT NULL,
  `post_titel` varchar(50) NOT NULL,
  `post_text` varchar(1000) DEFAULT NULL,
  `likee` int(11) DEFAULT '0',
  `dislike` int(11) DEFAULT '0',
  `has_cmnt` tinyint(1) NOT NULL DEFAULT '0',
  `post_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `p_id`, `post_titel`, `post_text`, `likee`, `dislike`, `has_cmnt`, `post_time`) VALUES
(2, 1, 'Hudai', 'Hi I am MD. Ariful Haque Shipu, This is the very first post of this platform.', 6, 3, 1, '2019-04-09 09:50:00'),
(2, 2, 'Kaj onek', 'Uff onek jhor tufan hocche, Allah maf koruk', 6, 1, 1, '0000-00-00 00:00:00'),
(3, 3, 'Kisuu na', 'Amnei test kore dekhlam r ki', 1, 2, 1, '2019-04-09 05:56:32'),
(4, 4, 'Eita Seyam er post', 'Hi post kore dekhlam j kaj kore ki na ..', 0, 0, 0, '2019-04-12 15:57:37'),
(4, 5, 'Jaba?', 'Banani khaite jabo, kew jabi?', 0, 0, 0, '2019-04-12 19:19:01'),
(6, 6, 'LOVE:-)', 'I am very glad to see this .. ', 0, 0, 1, '2019-04-12 20:29:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alluser`
--
ALTER TABLE `alluser`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`p_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
