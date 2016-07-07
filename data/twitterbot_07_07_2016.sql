-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 07, 2016 at 12:41 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `twitterbot`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `username` varchar(120) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `active` int(11) NOT NULL,
  `last_message` varchar(140) DEFAULT NULL,
  `response` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `username`, `password`, `active`, `last_message`, `response`, `created`, `updated`) VALUES
(1, 'Asahitechnologies', 'Test@123', 1, 'This is test tweet', 'O:8:"stdClass":23:{s:10:"created_at";s:30:"Thu Jul 07 10:19:21 +0000 2016";s:2:"id";i:750997626229665792;s:6:"id_str";s:18:"750997626229665792";s:4:"text";s:18:"This is test tweet";s:9:"truncated";b:0;s:8:"entities";O:8:"stdClass":4:{s:8:"hashtags";a:0:{}s:7:"symbols";a:0:{}s:13:"user_mentions";a:0:{}s:4:"urls";a:0:{}}s:6:"source";s:72:"<a href="http://www.twitterbots.dev" rel="nofollow">Twitterbot Asahi</a>";s:21:"in_reply_to_status_id";N;s:25:"in_reply_to_status_id_str";N;s:19:"in_reply_to_user_id";N;s:23:"in_reply_to_user_id_str";N;s:23:"in_reply_to_screen_name";N;s:4:"user";O:8:"stdClass":40:{s:2:"id";i:748075771244118016;s:6:"id_str";s:18:"748075771244118016";s:4:"name";s:7:"Krishna";s:11:"screen_name";s:13:"krishna_asahi";s:8:"location";s:0:"";s:11:"description";s:0:"";s:3:"url";N;s:8:"entities";O:8:"stdClass":1:{s:11:"description";O:8:"stdClass":1:{s:4:"urls";a:0:{}}}s:9:"protected";b:0;s:15:"followers_count";i:0;s:13:"friends_count";i:0;s:12:"listed_count";i:0;s:10:"created_at";s:30:"Wed Jun 29 08:48:57 +0000 2016";s:16:"favourites_count";i:0;s:10:"utc_offset";N;s:9:"time_zone";N;s:11:"geo_enabled";b:0;s:8:"verified";b:0;s:14:"statuses_count";i:8;s:4:"lang";s:2:"en";s:20:"contributors_enabled";b:0;s:13:"is_translator";b:0;s:22:"is_translation_enabled";b:0;s:24:"profile_background_color";s:6:"F5F8FA";s:28:"profile_background_image_url";N;s:34:"profile_background_image_url_https";N;s:23:"profile_background_tile";b:0;s:17:"profile_image_url";s:79:"http://abs.twimg.com/sticky/default_profile_images/default_profile_0_normal.png";s:23:"profile_image_url_https";s:80:"https://abs.twimg.com/sticky/default_profile_images/default_profile_0_normal.png";s:18:"profile_link_color";s:6:"2B7BB9";s:28:"profile_sidebar_border_color";s:6:"C0DEED";s:26:"profile_sidebar_fill_color";s:6:"DDEEF6";s:18:"profile_text_color";s:6:"333333";s:28:"profile_use_background_image";b:1;s:20:"has_extended_profile";b:0;s:15:"default_profile";b:1;s:21:"default_profile_image";b:1;s:9:"following";b:0;s:19:"follow_request_sent";b:0;s:13:"notifications";b:0;}s:3:"geo";N;s:11:"coordinates";N;s:5:"place";N;s:12:"contributors";N;s:15:"is_quote_status";b:0;s:13:"retweet_count";i:0;s:14:"favorite_count";i:0;s:9:"favorited";b:0;s:9:"retweeted";b:0;s:4:"lang";s:2:"en";}', '2016-06-30 08:49:47', '2016-07-07 12:19:01');

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `pid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `displayname` varchar(50) NOT NULL,
  `access_key` text,
  `access_secret` text,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `providers`
--

INSERT INTO `providers` (`pid`, `name`, `displayname`, `access_key`, `access_secret`, `status`) VALUES
(1, 'aol', 'AOL', NULL, NULL, 0),
(2, 'google', 'Google', '170207017050-j09054st517ilf373357o5oakapiou8o.apps.googleusercontent.com', 'K8PVlkJPAVj1zB_x8wTgH42g', 1),
(3, 'facebook', 'Facebook', '1741961699393453', '77af73a852375379863a5e1c261ee605', 1),
(4, 'twitter', 'Twitter', 'KsNZXPk138cRE5LOaW8I5oSln', '8AulntgwzuxkQAznMIPs4MQjxsWlEfjJandKpy4JfMdOAqSXwO', 1),
(5, 'yahoo', 'Yahoo', NULL, NULL, 0),
(6, 'linkedin', 'LinkedIn', NULL, NULL, 0),
(7, 'live', 'Live', NULL, NULL, 0),
(8, 'myspace', 'MySpace', NULL, NULL, 0),
(9, 'foursquare', 'Foursquare', NULL, NULL, 0),
(10, 'openid', 'OpenID', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `rid` int(11) NOT NULL,
  `role_name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rid`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` bigint(20) NOT NULL,
  `username` varchar(200) DEFAULT NULL,
  `firstname` varchar(200) DEFAULT NULL,
  `lastname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `email_verified` int(11) NOT NULL,
  `displayname` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `gender` varchar(10) NOT NULL,
  `language` varchar(20) NOT NULL,
  `age` int(11) NOT NULL,
  `birthday` int(11) NOT NULL,
  `birthmonth` int(11) NOT NULL,
  `birthyear` int(11) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `country` varchar(50) DEFAULT NULL,
  `region` varchar(50) DEFAULT NULL,
  `city` text,
  `zip` int(11) NOT NULL,
  `provider` varchar(20) NOT NULL,
  `identifier` varchar(250) NOT NULL,
  `websiteurl` text,
  `profileurl` text,
  `photo` text,
  `status` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `login_type` varchar(10) DEFAULT NULL,
  `access_token` text,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `firstname`, `lastname`, `email`, `email_verified`, `displayname`, `description`, `gender`, `language`, `age`, `birthday`, `birthmonth`, `birthyear`, `phone`, `address`, `country`, `region`, `city`, `zip`, `provider`, `identifier`, `websiteurl`, `profileurl`, `photo`, `status`, `rid`, `login_type`, `access_token`, `created`, `updated`) VALUES
(3, '', 'Krishna', 'Moorthy', 'krishna.asahi@gmail.com', 0, 'Krishna Moorthy', '', 'male', '', 0, 0, 0, 0, '', 'Chennai, Tamil Nadu 600033, India', '', '', 'Chennai, Tamil Nadu 600033, India', 0, 'Google', '109766919013638871489', '', 'https://plus.google.com/109766919013638871489', 'https://lh5.googleusercontent.com/-bd0XUQyvF7g/AAAAAAAAAAI/AAAAAAAAAHw/euc846GJCsU/photo.jpg?sz=200', 0, 2, 'social', 'a7df892a7d9ce2ca11f5b568e16277b0', '2016-07-07 06:36:16', '2016-07-07 08:36:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `rid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
