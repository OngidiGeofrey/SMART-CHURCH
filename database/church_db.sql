-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2021 at 09:55 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `church_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_request`
--

CREATE TABLE `appointment_request` (
  `id` int(30) NOT NULL,
  `sched_type_id` int(30) NOT NULL,
  `fullname` text NOT NULL,
  `contact` text NOT NULL,
  `address` text NOT NULL,
  `schedule` datetime NOT NULL,
  `remarks` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointment_request`
--

INSERT INTO `appointment_request` (`id`, `sched_type_id`, `fullname`, `contact`, `address`, `schedule`, `remarks`, `status`, `date_created`, `date_updated`) VALUES
(1, 2, 'John Smith', '09123456789', '23rd St., Sample Address, Here City', '2021-09-24 09:00:00', 'Sample Only', 1, '2021-09-16 14:10:37', '2021-09-16 14:52:47'),
(2, 1, 'Claire Blake', '09445122988', 'Sampel Address', '2021-09-20 10:00:00', 'Vehicle Blessing', 0, '2021-09-16 14:12:13', NULL),
(3, 1, 'Sample', '1231654', 'Sample', '2021-09-17 16:00:00', 'Sample', 2, '2021-09-16 14:13:19', '2021-09-16 14:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `topic_id` int(30) DEFAULT NULL,
  `content` text NOT NULL,
  `keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `banner_path` text NOT NULL,
  `upload_dir_code` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = unpublished ,1= published',
  `blog_url` text NOT NULL,
  `author_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `topic_id`, `content`, `keywords`, `meta_description`, `banner_path`, `upload_dir_code`, `status`, `blog_url`, `author_id`, `date_created`, `date_updated`) VALUES
(1, 'Sample 101', 1, '&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae massa quis tellus ullamcorper auctor at in mi. Vestibulum euismod, nulla sit amet rhoncus iaculis, sapien justo sodales purus, nec finibus massa massa eget ante. Maecenas vitae eros in purus dictum porttitor. Integer arcu dui, dictum ac tellus et, ultricies condimentum est. Maecenas rutrum erat tincidunt dui rutrum fermentum. Nullam pretium molestie gravida. Sed mi justo, porta id justo ac, ornare aliquam est. Cras porta nisi eu eleifend tincidunt. Donec malesuada interdum orci sit amet sollicitudin. Maecenas sed augue condimentum justo vulputate interdum vel in lacus.&lt;/span&gt;&lt;/p&gt;&lt;p&gt;&lt;span style=\\&quot;text-align: justify;\\&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/p&gt;&lt;div style=\\&quot;text-align: center;\\&quot;&gt;&lt;img style=\\&quot;width: 625px; height: 416.667px;\\&quot; src=\\&quot;http://localhost/charity/uploads/blog_uploads/Zk1pDmHIo2/1629176073_1.jpg\\&quot;&gt;&lt;/div&gt;&lt;div style=\\&quot;\\&quot;&gt;&lt;span style=\\&quot;text-align: justify;\\\\\\&quot;&gt;Quisque sagittis varius magna ac pharetra. Nunc lobortis sapien nisl, ac fringilla enim pellentesque vitae. Vestibulum congue lorem non sapien lobortis iaculis. Sed commodo sit amet turpis sed porta. Phasellus arcu nulla, facilisis in nulla at, pharetra lobortis ligula. Nullam dignissim, nunc eget consectetur facilisis, tortor felis lacinia diam, a vestibulum magna mauris eget mi. Donec tellus ipsum, euismod at hendrerit a, consequat viverra tellus.&lt;/span&gt;&lt;br&gt;&lt;/div&gt;&lt;p&gt;&lt;/p&gt;', 'Sample Keyword, 101, 102, 103', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae massa quis tellus ullamcorper auctor at in mi. Vestibulum euismod, nulla sit amet rhoncus iaculis, sapien justo sodales purus, nec finibus massa massa eget ante.', 'uploads/blog_uploads/banners/1_banner.jpg', 'Zk1pDmHIo2', 1, 'pages/sample_101.php', 1, '2021-08-17 12:56:54', '2021-08-17 13:17:35'),
(2, 'Sample 102', 1, '&lt;h3 style=\\&quot;text-align: center; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\\&quot;&gt;Sample Content Only&lt;/h3&gt;&lt;p style=\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\\&quot;&gt;Nullam pulvinar libero id justo faucibus elementum. Donec euismod ante tellus, et pulvinar ipsum tincidunt ac. Proin efficitur eros eu orci imperdiet fringilla. Sed ullamcorper luctus lacus, in varius sapien tincidunt gravida. Praesent elit massa, accumsan a purus id, hendrerit tincidunt risus. Nam luctus dictum ante in pellentesque. Proin eget eros in nisl lacinia semper at faucibus risus. Cras sit amet sagittis risus, non tempus neque. Proin aliquam dignissim augue, eget semper eros ultrices id. In consequat lorem mattis lobortis scelerisque. Fusce lorem arcu, condimentum iaculis nisl sed, mollis commodo nibh. Suspendisse convallis at libero id fermentum.&lt;/p&gt;&lt;p style=\\&quot;margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\\&quot;&gt;Etiam ac dolor tincidunt, tincidunt erat vitae, tempor sem. Nulla auctor lectus nisi, non dictum tortor hendrerit at. Proin ultricies aliquam ex, eu facilisis dolor lobortis a. Aenean varius vitae ante at pharetra. Praesent rutrum metus et tellus condimentum sollicitudin. Aenean et euismod risus, vitae tincidunt enim. Cras nec augue massa. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean facilisis semper sapien. Curabitur sem purus, blandit rutrum urna ac, pharetra finibus massa. Morbi pharetra efficitur faucibus. Vivamus scelerisque sem eu nunc vulputate efficitur. Vestibulum porttitor nisi dolor, ut pharetra dui consequat quis.&lt;/p&gt;', 'Sample, Content, Sample 102, keyword', 'Nullam pulvinar libero id justo faucibus elementum. Donec euismod ante tellus, et pulvinar ipsum tincidunt ac. Proin efficitur eros eu orci imperdiet fringilla. Sed ullamcorper luctus lacus, in varius sapien tincidunt gravida', 'uploads/blog_uploads/banners/2_banner.jpg', '', 1, 'pages/sample_102.php', 1, '2021-08-17 13:57:56', '2021-08-17 13:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `daily_verses`
--

CREATE TABLE `daily_verses` (
  `id` int(30) NOT NULL,
  `verse` text NOT NULL,
  `verse_from` text NOT NULL,
  `image_path` text NOT NULL,
  `display_date` date NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `daily_verses`
--

INSERT INTO `daily_verses` (`id`, `verse`, `verse_from`, `image_path`, `display_date`, `date_created`, `date_updated`) VALUES
(1, 'I have set the LORD always before me; because he is at my right hand, I shall not be shaken.', 'Psalm 16:8', 'uploads/verse_bg/1.jpg', '2021-09-16', '2021-09-16 09:40:32', '2021-09-16 09:42:40'),
(2, 'You keep him in perfect peace whose mind is stayed on you, because he trusts in you.', 'Isaiah 26:3', 'uploads/verse_bg/2.jpg', '2021-09-17', '2021-09-16 15:45:29', '2021-09-16 15:45:29');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `schedule` date NOT NULL,
  `img_path` text DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `schedule`, `img_path`, `date_created`) VALUES
(1, 'Sample Event', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae massa quis tellus ullamcorper auctor at in mi. Vestibulum euismod, nulla sit amet rhoncus iaculis, sapien justo sodales purus, nec finibus massa massa eget ante. Maecenas vitae eros in purus dictum porttitor. Integer arcu dui, dictum ac tellus et, ultricies condimentum est. Maecenas rutrum erat tincidunt dui rutrum fermentum. Nullam pretium molestie gravida. Sed mi justo, porta id justo ac, ornare aliquam est. Cras porta nisi eu eleifend tincidunt. Donec malesuada interdum orci sit amet sollicitudin. Maecenas sed augue condimentum justo vulputate interdum vel in lacus.', '2021-10-13', 'uploads/events/1.jpg', '2021-08-17 15:16:11'),
(3, 'Event 102', 'Sample Only', '2021-10-05', 'uploads/events/3.jpg', '2021-08-17 15:17:52'),
(4, 'Sample Event 3', 'Sample Event only', '2021-10-05', 'uploads/events/4.jpg', '2021-08-17 15:55:38');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_type`
--

CREATE TABLE `schedule_type` (
  `id` int(11) NOT NULL,
  `sched_type` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule_type`
--

INSERT INTO `schedule_type` (`id`, `sched_type`, `description`, `status`) VALUES
(1, 'Blessing', 'Sample Schedule Request Type', 1),
(2, 'Baptism', 'Sample Schedule Type Request 2', 1),
(3, 'Sample 103', 'Sample Schedule Request 3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Church Management System - PHP'),
(6, 'short_name', 'CMS - PHP'),
(11, 'logo', 'uploads/1631753220_church_logo.jpg'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/1631753220_church-bg-3.jpg'),
(15, 'welcome_content', '<p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae massa quis tellus ullamcorper auctor at in mi. Vestibulum euismod, nulla sit amet rhoncus iaculis, sapien justo sodales purus, nec finibus massa massa eget ante. Maecenas vitae eros in purus dictum porttitor. Integer arcu dui, dictum ac tellus et, ultricies condimentum est. Maecenas rutrum erat tincidunt dui rutrum fermentum. Nullam pretium molestie gravida. Sed mi justo, porta id justo ac, ornare aliquam est. Cras porta nisi eu eleifend tincidunt. Donec malesuada interdum orci sit amet sollicitudin. Maecenas sed augue condimentum justo vulputate interdum vel in lacus.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Quisque sagittis varius magna ac pharetra. Nunc lobortis sapien nisl, ac fringilla enim pellentesque vitae. Vestibulum congue lorem non sapien lobortis iaculis. Sed commodo sit amet turpis sed porta. Phasellus arcu nulla, facilisis in nulla at, pharetra lobortis ligula. Nullam dignissim, nunc eget consectetur facilisis, tortor felis lacinia diam, a vestibulum magna mauris eget mi. Donec tellus ipsum, euismod at hendrerit a, consequat viverra tellus.</p><p style=\"margin-right: 0px; margin-bottom: 15px; margin-left: 0px; padding: 0px;\">Pellentesque auctor nunc in pulvinar dignissim. Mauris tempus fringilla ligula, ut facilisis felis euismod ut. Quisque nec sollicitudin felis, ac venenatis elit. Suspendisse at tortor ac leo rutrum maximus. Nulla viverra purus quis arcu suscipit, vitae suscipit orci accumsan. Aliquam sodales, justo vel interdum sodales, nibh libero facilisis lorem, in elementum ex odio non sem. Curabitur vitae blandit felis. In auctor velit eget maximus placerat. Donec quis tellus vestibulum, malesuada magna quis, ultrices lorem.</p>'),
(16, 'home_quote', '“Everything should be done in love.” — 1 Corinthians 16:14'),
(17, 'contact', '0978945612 / 456-7899-789'),
(18, 'email', 'info@churchname.com'),
(19, 'address', '23rd St., Sample Address, Here City, 7777');

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0=Inactive, 1=Active',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `name`, `description`, `status`, `date_created`, `date_updated`) VALUES
(1, 'Sample 101', 'This is a sample topic only.', 1, '2021-08-17 08:51:41', '2021-09-16 08:51:30'),
(2, 'Test 101', '&lt;p&gt;Sample Only&lt;/p&gt;', 1, '2021-08-17 08:53:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `uploads`
--

CREATE TABLE `uploads` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `file_path` text NOT NULL,
  `dir_code` varchar(50) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `uploads`
--

INSERT INTO `uploads` (`id`, `user_id`, `file_path`, `dir_code`, `date_created`) VALUES
(1, 1, 'uploads/blog_uploads/gInV4MOSIc/1629172196_1.jpg', 'gInV4MOSIc', '2021-08-17 11:49:56'),
(2, 1, 'uploads/blog_uploads/gInV4MOSIc/1629172196_download.jpg', 'gInV4MOSIc', '2021-08-17 11:49:56'),
(3, 1, 'uploads/blog_uploads/qI8ZJiELzQ/1629172988_1.jpg', 'qI8ZJiELzQ', '2021-08-17 12:03:08'),
(4, 1, 'uploads/blog_uploads/qI8ZJiELzQ/1629172988_download.jpg', 'qI8ZJiELzQ', '2021-08-17 12:03:08'),
(5, 1, 'uploads/blog_uploads/vLLU8CyJZd/1629174024_1.jpg', 'vLLU8CyJZd', '2021-08-17 12:20:24'),
(6, 1, 'uploads/blog_uploads/Zk1pDmHIo2/1629176073_1.jpg', 'Zk1pDmHIo2', '2021-08-17 12:54:33'),
(7, 1, 'uploads/blog_uploads/K1dZZqq4SO/1629176614_warehouse-portrait.jpg', 'K1dZZqq4SO', '2021-08-17 13:03:34'),
(8, 1, 'uploads/blog_uploads/YSzqldklKk/1629176691_warehouse-portrait.jpg', 'YSzqldklKk', '2021-08-17 13:04:51'),
(10, 1, 'uploads/blog_uploads/Zk1pDmHIo2/1629176847_warehouse-portrait.jpg', 'Zk1pDmHIo2', '2021-08-17 13:07:27'),
(11, 1, 'uploads/blog_uploads/causes_uploads/1629190918_dark-bg.jpg', 'causes_uploads', '2021-08-17 17:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/1624240500_avatar.png', NULL, 1, '2021-01-20 14:02:37', '2021-06-21 09:55:07'),
(9, 'Staff', '1', 'staff1', '4d7d719ac0cf3d78ea8a94701913fe47', 'uploads/1631778840_avatar_.png', NULL, 0, '2021-09-16 15:54:58', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_request`
--
ALTER TABLE `appointment_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`),
  ADD KEY `topic_id_2` (`topic_id`);

--
-- Indexes for table `daily_verses`
--
ALTER TABLE `daily_verses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule_type`
--
ALTER TABLE `schedule_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_request`
--
ALTER TABLE `appointment_request`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `daily_verses`
--
ALTER TABLE `daily_verses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule_type`
--
ALTER TABLE `schedule_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blogs`
--
ALTER TABLE `blogs`
  ADD CONSTRAINT `blogs_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
