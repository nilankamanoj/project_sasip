--user : newuser
--password : password
--host : localhost

CREATE DATABASE dblogin;

use dblogin;

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `user_email` varchar(40) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `joining_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_level` int(1) NOT NULL,
  `permission` int(1) NOT NULL,

  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

ALTER TABLE `users` ADD `active` INT NULL DEFAULT NULL AFTER `permission`;

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_pass`, `joining_date`, `user_level`, `permission`) VALUES
(1, 'user1', 'user1@com.com', '$2y$10$Z3Uh0MHp.JuiYaRom8zn1uCXRH0iFMnGpwPAJv0ZTwn0XdmanVzH6', '2017-06-12 16:37:56', 1, 1),
(2, 'user2', 'user2@com.com', '$2y$10$DV3vCjGruh5K5crdLR7jbOjKesnsPVoYv/RctTYaKOzi.S2sKCRcO', '2017-06-12 17:03:50', 2, 1),
(7, 'user3', 'user3@com.com', '$2y$10$D.kAi1DoPTX5qQXSvvcY7OuAP4NbW4zezY6F7NVPMBCij9yCjtaoW', '2017-06-14 09:21:41', 3, 1),
(8, 'teacher1', 'teacher1@com.com', '$2y$10$zbWSBArgiV3PpFNdk/5Uc.wWBYsmMDtBFuYppToxGWT20dlv8mQim', '2017-06-15 12:19:11', 4, 1),
(17, 'user5', 'user5@com.com', '$2y$10$T4xdjGcSw5D5jfQNIqWVV.7KWNR6jCOSW5ry/Z/IHrs2Y/NihJBpe', '2017-06-28 07:19:43', 5, NULL);

---------------------------------------------------------------------------------------------------------------------------------------

CREATE DATABASE dbclasses;

use dbclasses;

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(12) NOT NULL,
  `class_day` varchar(12) NOT NULL,
  `class_time_hour` varchar(2) NOT NULL,
  `class_time_minit` varchar(2) NOT NULL,
  `duration` varchar(2) NOT NULL,
  `teacher_name` varchar(12) NOT NULL,
  `stu_count` INT(4) NOT NULL,
  `hall` varchar(8),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pointers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` varchar(6) NOT NULL,
  `class` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

----------------------------------------------------------------------------------------------------------------------------------------------

CREATE DATABASE dbsyslog;

use dbsyslog;

CREATE TABLE IF NOT EXISTS `syslog` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(15) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_description` varchar(50) NOT NULL,
PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

---------------------------------------------------------------------------------------------------------------------------------------------
