-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2019 at 07:14 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `avatars`
--

CREATE TABLE `avatars` (
  `avatar_id` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `avatar_date` date NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `avatars`
--

INSERT INTO `avatars` (`avatar_id`, `avatar`, `avatar_date`, `user_id`) VALUES
(5, '558_Koala.jpg', '2018-03-20', 1),
(6, '225_Koala.jpg', '2018-03-20', 1),
(7, '950_Desert.jpg', '2018-03-20', 1),
(8, '319_Desert.jpg', '2018-03-20', 1),
(9, '812_Desert.jpg', '2018-03-20', 1),
(10, '269_Desert.jpg', '2018-03-20', 1),
(11, '854_guins.jpg', '2018-03-20', 1),
(13, '214_20140146_1420965904653545_3480904898740986951_n.jpg', '2018-03-20', 1),
(14, '821_Lighthouse.jpg', '2018-03-20', 1),
(17, '844_27544743_2163523333877833_5501341055882406433_n.jpg', '2018-03-21', 1),
(18, '44_Chrysanthemum.jpg', '2018-03-21', 1),
(19, '784_27544743_2163523333877833_5501341055882406433_n.jpg', '2018-03-21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `msg` text NOT NULL,
  `time` time NOT NULL,
  `date` date NOT NULL,
  `seen` tinyint(9) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `date` varchar(255) CHARACTER SET utf16 NOT NULL,
  `time` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `post` int(11) NOT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`like_id`, `post`, `user`) VALUES
(18, 95, 28),
(19, 95, 25);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `user` int(11) DEFAULT NULL,
  `url` text,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user`, `url`, `content`) VALUES
(2, 23, 'post.php?id95', 'mohamed Has liked your post'),
(3, 23, 'post.php?id95', 'Nora  Has liked your post');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `img_id` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `day` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`post_id`, `user_id`, `content`, `img_id`, `date`, `time`, `day`) VALUES
(92, 23, '<p>منشور رقم 1</p>\r\n', 0, '19 May,09', '11:15', 190509),
(93, 23, '<p>منشور رقم 2</p>\r\n', 0, '19 May,09', '11:21', 190509),
(94, 23, '<p>منشور</p>\r\n', 0, '19 May,09', '11:23', 190509),
(95, 23, '<p>منشور</p>\r\n', 0, '19 May,09', '11:24', 190509);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `birthDay` date NOT NULL,
  `age` int(11) NOT NULL,
  `town` varchar(255) NOT NULL,
  `rel_status` varchar(255) NOT NULL,
  `user_status` int(11) NOT NULL,
  `Online` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `f_name`, `l_name`, `sex`, `email`, `pass`, `birthDay`, `age`, `town`, `rel_status`, `user_status`, `Online`) VALUES
(1, 'mohamed', 'elshafiy', 'ذكر', 'm@gmail.com', '123123', '0000-00-00', 24, 'القاهرة', 'اعزب', 0, 1),
(3, 'بلال', 'احمد ', '', 'belall@gmail.com', '123456', '0000-00-00', 23, 'cairo', 'اعزب', 0, 0),
(23, 'ali ', 'ibrahem ', 'ذكر', 'ali@gmail.com', '123123', '1997-09-20', 21, 'ismalila ', 'اعزب', 0, 0),
(24, 'reham ', 'mohamed ', 'أنثى', 'reham97@gmail.com', '123123', '1997-09-20', 21, '', '', 0, 0),
(25, 'Nora ', 'moagdy', 'ذكر', 'nora@gmail.com', '123123', '1993-12-31', 25, '', '', 0, 0),
(26, 'hala ', 'mahmoud', 'أنثى', 'hala@gmail.com', '123123', '1993-12-03', 25, '', '', 0, 0),
(28, 'mohamed', 'elshafiy', 'أنثى', 'engelshafiy6@gmail.com', '123123', '2019-03-27', 0, '', '', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `avatars`
--
ALTER TABLE `avatars`
  ADD PRIMARY KEY (`avatar_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender` (`sender`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user` (`user`),
  ADD KEY `post` (`post`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `avatars`
--
ALTER TABLE `avatars`
  MODIFY `avatar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_post` FOREIGN KEY (`post`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
