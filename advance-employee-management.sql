-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 07:29 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `advance-employee-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE IF NOT EXISTS `profiles` (
`no` int(11) NOT NULL,
  `userid` varchar(55) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `position` varchar(50) NOT NULL,
  `contactno` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `incomeperhour` int(10) NOT NULL,
  `hiredate` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`no`, `userid`, `usertype`, `username`, `position`, `contactno`, `address`, `incomeperhour`, `hiredate`) VALUES
(1, '657634785', 'admin', 'Rimu Najrul', 'System Administrator', '+8801715743693', 'Hamdhao , Jhenidha , Khulna , Bangladesh', 400, '2021-05-13'),
(3, '1160872454', 'admin', 'Argha', 'Web developer', '+8801710962748', 'America', 500, '2020-01-30'),
(6, '624526760', 'admin', 'Argha', 'Web developer', '+8801710962748', 'America', 500, '2020-01-30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`no` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(20) NOT NULL,
  `createdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(200) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`no`, `userid`, `password`, `email`, `createdate`, `token`) VALUES
(1, 657634785, 'd35cceb8a98589ba5ca123678538fd25152f755a3eeaddabda7f70de36be806d', 'admin@gmail.com', '2021-05-12 16:38:06', 'dd225a8cb1556ba965f9f39da3db92f7edd5dc593026ea72ddc41158dbb8d415'),
(3, 1160872454, 'c797b0dbdaa4fee9c4f5c1e4d83c8634b0dcff3790b4bced7a3e0ea12a0c3508', 'user@gmail.com', '2021-05-15 03:06:44', '94ad6bb68fc3c374384ade6ed47454b9ece77dfce71919ef2762522c6117771f'),
(6, 624526760, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'user11@gmail.com', '2021-05-15 03:34:52', 'b91716bfbe8eb77bdb6fb7e7a29d8f40c32b145ab4e02f0575fb83d2866848cd');

-- --------------------------------------------------------

--
-- Table structure for table `workhours`
--

CREATE TABLE IF NOT EXISTS `workhours` (
`no` int(8) NOT NULL,
  `userid` varchar(55) NOT NULL,
  `workdate` date NOT NULL,
  `incomeperhour` int(11) NOT NULL,
  `checkin` time NOT NULL,
  `checkout` time NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `workhours`
--

INSERT INTO `workhours` (`no`, `userid`, `workdate`, `incomeperhour`, `checkin`, `checkout`) VALUES
(1, '6675645', '2021-05-04', 400, '09:59:59', '23:57:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
 ADD PRIMARY KEY (`no`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`no`);

--
-- Indexes for table `workhours`
--
ALTER TABLE `workhours`
 ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
MODIFY `no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `no` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `workhours`
--
ALTER TABLE `workhours`
MODIFY `no` int(8) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
