-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 04, 2020 at 01:56 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `musfan`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `user_id`, `title`, `article`, `date`) VALUES
(3, 33, 7, 'hii', 'whatsapp???????', '2020-03-20 13:47:31'),
(7, 5, 6, 'hgfd', 'cvbgfdsx', '2020-03-20 15:03:23'),
(8, 3, 3, 'fedfds', 'fdscfvds', '2020-03-20 15:03:38'),
(9, 6, 6, 'hgfds', 'cvbhgfds', '2020-03-20 15:46:13'),
(45, 33, 1, 'hii', 'my name is Shlomo Shalev', '2020-03-27 15:34:58'),
(81, 33, 1, 'gfdews', 'gtrfde', '2020-03-31 20:07:45'),
(82, 44, 1, 'jhtgrfe', 'juhgrf', '2020-03-31 20:08:30'),
(85, 46, 9, 'whatsapp man??', 'hahaha', '2020-03-31 22:57:48'),
(87, 8, 1, '×¢×¢×¢', '× ×¢×”×›×’×“×¡×’×›×¢×™×˜', '2020-04-02 10:47:46');

-- --------------------------------------------------------

--
-- Table structure for table `img_profile`
--

CREATE TABLE `img_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name_file_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `img_profile`
--

INSERT INTO `img_profile` (`id`, `user_id`, `name_file_img`) VALUES
(4, 1, 'default_profile.png'),
(5, 2, 'default_profile.png'),
(6, 3, 'default_profile.png'),
(7, 5, '2020.03.13.21.12.28-20190520_222319 (2).jpg'),
(14, 6, 'default_profile.png'),
(15, 7, 'default_profile.png'),
(34, 8, 'default_profile.png'),
(35, 9, 'default_profile.png');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`) VALUES
(2, 2, 22),
(3, 2, 8),
(5, 3, 22),
(13, 3, 8),
(266, 1, 6),
(294, 1, 3),
(337, 9, 46),
(340, 9, 44),
(342, 9, 33),
(343, 9, 22),
(344, 9, 8),
(345, 9, 6),
(346, 9, 5),
(347, 9, 3),
(359, 1, 8),
(361, 1, 5),
(364, 1, 22),
(365, 1, 46),
(369, 1, 33),
(370, 1, 44);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `article` text NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `article`, `date`) VALUES
(3, 2, 'Hello friends blog!', 'my name is mosh and I have a wonderful family', '2020-02-20 13:22:57'),
(5, 5, 'my name is shlomo shalev', 'I am new here!!!!', '2020-03-10 10:44:46'),
(6, 5, 'hii', 'hello world!!!', '2020-03-10 11:51:39'),
(8, 2, 'hii', 'what?!', '2020-03-10 21:43:51'),
(22, 5, 'fdscvg', 'fdsdcvfd', '2020-03-14 14:57:17'),
(33, 3, 'Hello the blog world!', 'my name is mosh and I have a wonderful family', '2020-03-14 21:09:33'),
(44, 1, 'demo avi', 'demo post', '2020-03-31 20:08:13'),
(46, 9, 'hii', 'my name is hii', '2020-03-31 22:57:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'Avi Cohen', 'avi@gmail.com', '$2y$10$8Jvz6MXcg11.FvWG7.Xz3efc2QPo3YwIYo8X3A8YaXHKc9x9Nm2Rq'),
(2, 'moshe levi', 'mosh@gmail.com', '$2y$10$8Jvz6MXcg11.FvWG7.Xz3efc2QPo3YwIYo8X3A8YaXHKc9x9Nm2Rq'),
(3, 'Vered Bitun', 'vered@gmail.com', '$2y$10$8Jvz6MXcg11.FvWG7.Xz3efc2QPo3YwIYo8X3A8YaXHKc9x9Nm2Rq'),
(5, 'shlomo shalev', 'yeledkesem770@gmail.com', '$2y$10$tH1Dnw8r6SGwl.qlaURdd./Y6AK6elJy8vfgeenXJFgFIjonkB2gm'),
(6, 'shlomo', 'shlomo@gmail.com', '$2y$10$XvTj8E1vqtnEP73JUWWO0.2usPI8pew2.UCbHT./.ASzPFm55eXP.'),
(7, 'shlomee', 'aaa@gmail.com', '$2y$10$REmr6SSuM9AVcPdvoCtxculk8KFGSAWd/kpdsFAEtQW858BeoqOq.'),
(8, 'shlomi', 'shlomi@gmail.com', '$2y$10$t.xfERpfVvRjZO/CLSrSeOcHQHLmy8Pzv6AOIe.RqroEQ1JRzOVQe'),
(9, 'hii', 'hii@gmail.com', '$2y$10$CdVOQ5ocRuHi0ZVDhaSQPuFWMPVVNXXdvCILD9Pcrup5OxJZLIAYG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `img_profile`
--
ALTER TABLE `img_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `img_profile`
--
ALTER TABLE `img_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `img_profile`
--
ALTER TABLE `img_profile`
  ADD CONSTRAINT `img_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
