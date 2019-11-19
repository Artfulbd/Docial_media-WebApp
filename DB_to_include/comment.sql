-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 19, 2019 at 04:26 PM
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
-- Database: `comment`
--

-- --------------------------------------------------------

--
-- Table structure for table `cmnt1`
--

CREATE TABLE `cmnt1` (
  `cmnt_text` varchar(300) DEFAULT NULL,
  `likee` int(11) DEFAULT NULL,
  `dislike` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `cmnt_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cmnt1`
--

INSERT INTO `cmnt1` (`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES
('Khub valo kaj korecho', 2, 2, 'Salman Meem sahel', 3, '0000-00-00 00:00:00'),
('R ekta cmnt korlam', 1, 2, 'Salman Meem sahel', 3, '0000-00-00 00:00:00'),
('Ki re vai somossa ki tomar', 4, 0, 'Md Ariful Haque', 2, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cmnt2`
--

CREATE TABLE `cmnt2` (
  `cmnt_text` varchar(300) DEFAULT NULL,
  `likee` int(11) DEFAULT NULL,
  `dislike` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `cmnt_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cmnt2`
--

INSERT INTO `cmnt2` (`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES
('First cmnt form Onek kaj', 1, 1, 'Salman Meem sahel', 3, '2019-04-10 10:09:22'),
('Alhamdulillah All ok ..', 2, 0, 'Md Ariful Haque', 2, '2019-04-10 10:16:01'),
('HUm jani na kmne asho vrcty ..', 0, 0, 'Gorib Seyam', 4, '2019-04-10 10:17:30'),
('amin', 0, 0, 'Saria Tasfia', 6, '2019-04-12 20:23:48');

-- --------------------------------------------------------

--
-- Table structure for table `cmnt3`
--

CREATE TABLE `cmnt3` (
  `cmnt_text` varchar(300) DEFAULT NULL,
  `likee` int(11) DEFAULT NULL,
  `dislike` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `cmnt_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cmnt3`
--

INSERT INTO `cmnt3` (`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES
('Ohhh', 0, 0, 'Salman Meem sahel', 3, '2019-04-09 10:28:06'),
('This is second one..', 0, 0, 'Salman Meem sahel', 3, '2019-04-09 10:28:50'),
('Ki khbr salman ..', 0, 0, 'Md Ariful Haque', 2, '2019-04-10 10:14:48');

-- --------------------------------------------------------

--
-- Table structure for table `cmnt6`
--

CREATE TABLE `cmnt6` (
  `cmnt_text` varchar(300) DEFAULT NULL,
  `likee` int(11) DEFAULT NULL,
  `dislike` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  `cmnt_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cmnt6`
--

INSERT INTO `cmnt6` (`cmnt_text`, `likee`, `dislike`, `name`, `id`, `cmnt_time`) VALUES
('Hii jan', 0, 0, 'Md Ariful Haque', 2, '2019-04-12 20:36:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
