--
-- Database: `artists`
--

-- --------------------------------------------------------
--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Nature'),
(2, 'Sport'),
(3, 'Fun'),
(4, 'Music');

--
-- Table structure for table `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `created_date` DATE NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_albums_users_idx` (`user_id`),
  KEY `fk_albums_categories_idx` (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `name`, `created_date`, `user_id`, `category_id`) VALUES
(1, 'Album1', '2015-04-02', 1, 1),
(2, 'Album2', '2015-04-03', 1,1),
(3, 'Album3', '2015-04-04', 1,1),
(4, 'Album1', '2015-04-05', 2,1),
(5, 'Album2', '2015-04-06', 2,1),
(6, 'Album3', '2015-04-07', 2,1),
(7, 'Album4', '2015-04-08', 2,1)
;

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `picture` LONGBLOB DEFAULT NULL,
  `created_date` DATE NOT NULL,
  `is_public` TINYINT NOT NULL,
  `album_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pictures_albums_idx` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `pictures` (`id`, `name`, `picture`, `created_date`, `is_public`, `album_id`) VALUES
(1, 'Pic1', null, '2015-04-02', true, 1),
(2, 'Pic2', null, '2015-05-02', true, 1),
(3, 'Pic3', null, '2015-06-02', true, 1),
(4, 'Pic4', null, '2015-08-02', true, 1),
(5, 'Pic5', null, '2015-04-20', true, 1),
(6, 'Pic6', null, '2015-04-02', true, 1),
(7, 'Pic7', null, '2015-04-02', true, 1),
(8, 'Pic1', null, '2015-04-02', true, 2),
(9, 'Pic2', null, '2015-04-02', true, 2),
(10, 'Pic3', null, '2015-04-02', true, 2),
(11, 'Pic4', null, '2015-04-02', true, 2),
(12, 'Pic5', null, '2015-04-02', true, 2),
(13, 'Pic6', null, '2015-04-02', true, 2),
(14, 'Pic7', null, '2015-04-02', true, 2),
(15, 'Pic1', null, '2015-04-02', true, 3),
(16, 'Pic2', null, '2015-04-02', true, 3),
(17, 'Pic3', null, '2015-04-02', true, 3),
(18, 'Pic4', null, '2015-04-02', true, 3),
(19, 'Pic5', null, '2015-04-02', true, 3),
(20, 'Pic6', null, '2015-04-02', true, 3),
(21, 'Pic7', null, '2015-04-02', true, 3)
;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,  
  `is_admin` TINYINT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`) VALUES
(1, 'test', '098f6bcd4621d373cade4e832627b4f6', false),
(2, 'admin', '098f6bcd4621d373cade4e832627b4f6', true),
(3, 'ceco', '098f6bcd4621d373cade4e832627b4f6', false);


CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,  
  `album_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ratings_users_idx` (`user_id`), 
  KEY `fk_ratings_albums_idx` (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(450) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pic_id` int(11) DEFAULT NULL,
  `created_date` DATE NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_users_idx` (`user_id`),
  KEY `fk_comments_albums_idx` (`album_id`),
  KEY `fk_comments_pictures_idx` (`pic_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `albums`
--
ALTER TABLE `albums`
  ADD CONSTRAINT `fk_albums_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
  
ALTER TABLE `albums`
  ADD CONSTRAINT `fk_albums_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `fk_pictures_albums` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
--
-- Constraints for table `ratings`
--
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_ratings_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
  
ALTER TABLE `ratings`
  ADD CONSTRAINT `fk_ratings_albums` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
  
--
-- Constraints for table `comments``
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
  
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_pictures` FOREIGN KEY (`pic_id`) REFERENCES `pictures` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
  
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comments_albums` FOREIGN KEY (`album_id`) REFERENCES `albums` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

