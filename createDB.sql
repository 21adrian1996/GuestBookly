REATE DATABASE IF NOT EXISTS `guestbookly`;
USE `guestbookly`;

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `titel` varchar(100) DEFAULT NULL,
  `content` text,
  `user_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `firstname` varchar(75) DEFAULT NULL,
  `lastname` varchar(75) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
);
