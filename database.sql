-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2018 at 04:56 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+08:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zibeline`
--

-- --------------------------------------------------------

--
-- Table structure for table `mp_journal`
--

CREATE TABLE `mp_journal` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `eissn` varchar(255) DEFAULT NULL,
  `issn` varchar(255) DEFAULT NULL,
  `publishername` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `startingyear` varchar(255) DEFAULT NULL,
  `discipline` varchar(255) DEFAULT NULL,
  `frequency` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `countries` varchar(255) DEFAULT NULL,
  `accessingmethod` varchar(255) DEFAULT NULL,
  `licensetype` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mp_journal`
--
-- --------------------------------------------------------

--
-- Table structure for table `mp_pages`
--

CREATE TABLE `mp_pages` (
  `page_id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_desc` text,
  `meta_keywords` varchar(255) DEFAULT NULL,
  `meta_desc` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `parent` varchar(255) NOT NULL DEFAULT '0',
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `page_alias` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mp_pages`
--

INSERT INTO `mp_pages` (`page_id`, `page_title`, `page_desc`, `meta_keywords`, `meta_desc`, `sort_order`, `parent`, `status`, `page_alias`) VALUES
(1, 'Welcome to Zibeline International Publishing', 'ZIBELINE publish journals presenting the latest research by leading Malaysian and overseas scientists and covering a broad range of subjects. Browse one of our journals from the list below. Each journal home page provides specific information for potential authors and subscribers.<br><br>Our open access journals offer the opportunity to publish works of unrestricted size as special issues, bearing ISBN number, in addition to the print and e-ISSN numbers of the journals. In this way, authors of monographs will benefit from Web of Science listing and, at the same time, from the distribution and dissemination network of the book industry. Advocating for open science, at ZIBELINE we take it as our duty to make the research published with us openly available to everyone. This is why upon publication both online journal articles and special issues are immediately archived and distributed worldwide, free to read, download and print.<br><br>All of this is possible with the Creative Commons Attribution License 4.0, which we have adopted as default for all publications in any Pensoft journal. What this means in practice, is that any published work is available for distribution as long as the original publication source is acknowledged. Again in the spirit of open and collaborative research, authors are encouraged to post their work online (e.g., institutional repositories or their website). Such practices trigger productive exchange, as well as earlier and greater citation of published work.<br><br>We are always keen to discuss new publishing projects. If you wish to publish a special issue, conference proceedings or a book, please contact us at info@zibelinepub.com', 'tags', 'descsds', 0, '-1', 'A', 'index'),
(2, 'About Us', '', 'tags', 'dasdasd', 1, '-1', 'A', 'about-us'),
(4, 'Contact Us', '', 'dasd', 'asdasd', 3, '-1', 'A', 'contact-us'),
(5, 'Journals', 'free academic journals online', 'dasd', 'asdasd', 4, '-2', 'A', 'journals'),
(6, 'Books', '<div class=\"wpb_wrapper\"><div id=\"bruno-custom-5bc13fd92de6b\" class=\"dpr-headline big  headline-align-left subtitle-size-small\"><span class=\"subtitle\">Academic book</span><h3><span>Zibeline Books Publishing</span></h3></div><div class=\"wpb_text_column wpb_content_element  vc_custom_1515485824014\"><div class=\"wpb_wrapper\"><p style=\"text-align: justify;\"><strong>Founded in 2015, the Zibeline books publishing arm is dedicated to discovering brilliant works by talented authors from around the world. At ZIBELINE we are changing the nature of the traditional academic book. Our books are published in hardback, paperback, pdf and ebook editions, but they also include a online edition that can be read via our website, downloaded, reused or embedded anywhere</strong></p><p style=\"text-align: justify;\">In addition, our digital publishing model allows us to extend our books well beyond the printed page. We are creating interactive books, and works that incorporate moving images, links and sound into the fabric of the text. More traditional titles are equipped with digital resources available on our website, including extra chapters, reviews, links and image galleries — these can be found on the individual product page for each book.</p><p style=\"text-align: justify;\">We are a small group of dedicated and academically-oriented individuals, working with a distinguished editorial board to make research available to everyone in the world. Our backgrounds are diverse, but our aim is shared</p><p style=\"text-align: justify;\">Our Science and Technology book authors and editors represent a broad range of specialty areas and are among the most well-respected and authoritative professionals in their communities. As your publishing partner, ZIBELINE seeks to drive the advancement and application of science and technology through the delivery of targeted and reputable information that supports research, learning and professional practice. We invite you to join a community of world-renowned thought leaders who have published books with ZIBELINE.</p></div></div></div>', 'dasdf', 'asdasdf', 5, '-3', 'A', 'books'),
(7, 'Accaunt', NULL, NULL, NULL, 6, '', 'A', 'accaunt'),
(11, 'Add Journal', '', '', '', 2, '5', 'A', 'add-journal'),
(12, 'Edit Journal', '', '', '', 7, '5', 'I', 'edit-journal'),
(13, 'Login', 'Please fill in your credentials to login.', NULL, NULL, 0, '-1', 'A', 'login'),
(14, 'Sign Up', 'Please fill this form to create an account.', NULL, NULL, -1, '-1', 'A', 'register'),
(15, 'Change Password', 'Please fill out this form to change your password.', NULL, NULL, 0, '7', 'A', 'reset-password');

-- --------------------------------------------------------

--
-- Table structure for table `mp_tagline`
--

CREATE TABLE `mp_tagline` (
  `id` int(11) NOT NULL,
  `tagline1` varchar(255) DEFAULT NULL,
  `tagline2` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `mp_tagline`
--

INSERT INTO `mp_tagline` (`id`, `tagline1`, `tagline2`) VALUES
(1, 'www.zibeline.com', 'Zibeline International Publishing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `picture` varchar(25555) DEFAULT NULL,
  `given_name` varchar(255) DEFAULT NULL,
  `family_name` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

-- --------------------------------------------------------

--
-- Table structure for table `validation`
--

CREATE TABLE `validation` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `validation`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mp_journal`
--
ALTER TABLE `mp_journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mp_pages`
--
ALTER TABLE `mp_pages`
  ADD PRIMARY KEY (`page_id`),
  ADD UNIQUE KEY `page_name` (`page_alias`);

--
-- Indexes for table `mp_tagline`
--
ALTER TABLE `mp_tagline`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `validation`
--
ALTER TABLE `validation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mp_journal`
--
ALTER TABLE `mp_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `mp_pages`
--
ALTER TABLE `mp_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `mp_tagline`
--
ALTER TABLE `mp_tagline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `validation`
--
ALTER TABLE `validation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
