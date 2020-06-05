-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 05, 2020 at 08:19 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `todo`
--

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `todo_id` int(11) NOT NULL,
  `todo` varchar(2048) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `completed` int(11) NOT NULL DEFAULT '0',
  `completed_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `tag` varchar(24) NOT NULL DEFAULT 'white',
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`todo_id`, `todo`, `created_at`, `completed`, `completed_at`, `tag`, `user_id`) VALUES
(3, 'Ciao di nuovo', '2020-06-01 19:34:40', 0, NULL, '', 1),
(4, 'grandeeeee', '2020-06-01 20:11:08', 0, NULL, '', 1),
(5, 'ramboooo', '2020-06-01 20:15:33', 0, NULL, '', 1),
(9, 'Sono io', '2020-06-02 01:47:49', 0, NULL, 'purple', 2),
(10, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Donec elementum ligula eu sapien consequat eleifend. Donec nec dolor erat, condimentum sagittis sem. Praesent porttitor porttitor risus, dapibus rutrum ipsum gravida et. Integer lectus nisi, facilisis sit amet eleifend nec, pharetra ut augue. Integer quam nunc, consequat nec egestas ac, volutpat ac nisi. Sed consectetur dignissim dignissim.', '2020-06-02 01:50:08', 0, NULL, 'yellow', 2),
(12, 'test test', '2020-06-03 01:17:10', 0, NULL, '', 2),
(13, '#Lorem Ipsum Dolor Sit Amet Consectetur Adipisicing Elit Se', '2020-06-03 01:55:51', 0, NULL, '', 2),
(18, '!@£$%^&*()_+vv', '2020-06-03 02:10:32', 0, NULL, '', 2),
(19, 'rrrrr', '2020-06-03 15:03:59', 0, NULL, '', 2),
(20, 'gfsbsfg', '2020-06-03 20:02:45', 0, NULL, '', 2),
(21, 'I got color color red\r\n', '2020-06-03 23:51:00', 0, NULL, 'red', 2),
(22, 'Hellooooo', '2020-06-04 11:48:03', 0, NULL, 'purple', 2),
(23, 'toop tooop', '2020-06-04 12:53:48', 0, NULL, 'blue', 2),
(24, 'Check status', '2020-06-04 22:50:12', 0, NULL, 'orange', 2),
(25, 'last one', '2020-06-04 23:08:18', 0, NULL, 'yellow', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `created_at`) VALUES
(1, 'user', '$2y$10$V2.x1s.H0Eqp/T/EbTvov.lNctpGg/DnPm3IT8gMdzYsb4nfA26sG', '2020-06-01 18:58:46'),
(2, 'user2', '$2y$10$NSkXfF.PVP83YBTo2KrS/.kXx93pCCAZPOgNWGh1h8o9LyJsocGLu', '2020-06-02 01:33:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`todo_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `todo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
