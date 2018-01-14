-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2018 at 09:46 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notes`
--

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `user_id`, `text`, `updated_date`, `created_date`) VALUES
(1, 1, 'Its my first comment', '2018-01-11 13:35:09', '2018-01-02 08:41:48'),
(2, 2, 'The second note pre-inserted in database manually', '2018-01-02 08:41:48', '2018-01-02 08:41:48'),
(35, 1, 'Here is another testing note written', '2018-01-03 16:03:35', '2018-01-03 16:03:35'),
(39, 1, 'its for another test', '2018-01-06 14:19:08', '2018-01-06 14:19:08'),
(40, 1, 'I am adding this note', '2018-01-09 15:38:04', '2018-01-09 15:38:04'),
(41, 1, 'its just a minute ago', '2018-01-09 16:17:49', '2018-01-09 16:17:49'),
(54, 1, 'Here is something wrong', '2018-01-09 16:40:06', '2018-01-09 16:40:06'),
(63, 4, 'So now i Did ', '2018-01-09 16:54:16', '2018-01-09 16:54:16'),
(64, 4, 'So what dear ', '2018-01-09 16:54:24', '2018-01-09 16:54:24'),
(65, 4, 'Here is my another one', '2018-01-09 16:55:07', '2018-01-09 16:55:07'),
(66, 4, 'Her is another one', '2018-01-09 17:00:05', '2018-01-09 17:00:05'),
(67, 17, 'Its my first comment in this ', '2018-01-09 18:23:48', '2018-01-09 18:23:48'),
(68, 19, 'its my first comment', '2018-01-09 18:26:21', '2018-01-09 18:26:21'),
(74, 20, 'its my new one', '2018-01-14 15:01:42', '2018-01-14 15:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(140) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `salt`, `active`) VALUES
(1, 'ziabzu@gmail.com', 'test', '', b'1'),
(2, 'morten@test.com', 'test', '', b'1'),
(3, 'khalid@test.com', 'test', '', b'1'),
(4, 'test@test.com', 'test', '7332605465a4b9fa15dee87.39994112', b'1'),
(5, 'test2@test.com', 'test', '7', b'1'),
(6, 'kiran@test.com', 'test', '8', b'1'),
(17, 'try@test.com', 'test', '5', b'1'),
(18, 'new@test.com', 'test', '10', b'1'),
(19, 'test123@test.com', 'test', '6', b'1'),
(20, 'jee@test.com', 'test', '', b'1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `active` (`active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
