-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT = @@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS = @@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS = 0 */;
/*!40101 SET @OLD_SQL_MODE = @@SQL_MODE, SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES = @@SQL_NOTES, SQL_NOTES = 0 */;


-- Dumping database structure for library
CREATE DATABASE IF NOT EXISTS `library` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `library`;

-- Dumping structure for table library.books
CREATE TABLE IF NOT EXISTS `books`
(
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `name`        varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `author`      varchar(100) NOT NULL,
  `category_id` int(11)      NOT NULL DEFAULT '0',
  `file`        varchar(255)          DEFAULT NULL,
  `cover`       varchar(255)          DEFAULT NULL,
  `publish_at`  date                  DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `books category` (`category_id`),
  CONSTRAINT `books category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 25
  DEFAULT CHARSET = latin1;

-- Data exporting was unselected.

-- Dumping structure for table library.categories
CREATE TABLE IF NOT EXISTS `categories`
(
  `id`         int(11)   NOT NULL AUTO_INCREMENT,
  `category`   varchar(60)    DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 4
  DEFAULT CHARSET = latin1;

INSERT INTO categories (category)
VALUES ('Action'),
       ('Fiksi'),
       ('Comedy'),
       ('History');

-- Data exporting was unselected.

-- Dumping structure for table library.collections
CREATE TABLE IF NOT EXISTS `collections`
(
  `id`         int(11)   NOT NULL AUTO_INCREMENT,
  `user_id`    int(11)        DEFAULT NULL,
  `book_id`    int(11)        DEFAULT NULL,
  `expired_at` date           DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `userFK` (`user_id`),
  KEY `bookFK` (`book_id`),
  CONSTRAINT `bookFK` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userFK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 20
  DEFAULT CHARSET = latin1;

-- Data exporting was unselected.

-- Dumping structure for table library.penalties
CREATE TABLE IF NOT EXISTS `penalties`
(
  `id`         int(11)   NOT NULL AUTO_INCREMENT,
  `user_id`    int(11)            DEFAULT NULL,
  `book_id`    int(11)            DEFAULT NULL,
  `count_days` int(11)   NOT NULL DEFAULT '1',
  `proof`      varchar(255)       DEFAULT '',
  `status`     varchar(50)        DEFAULT '',
  `created_at` timestamp NULL     DEFAULT CURRENT_TIMESTAMP,
  `expired_at` date               DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userFK_NEW` (`user_id`),
  KEY `bookFK_NEW` (`book_id`),
  CONSTRAINT `bookFK_NEW` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `userFK_NEW` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 73
  DEFAULT CHARSET = latin1;

-- Data exporting was unselected.

-- Dumping structure for table library.users
CREATE TABLE IF NOT EXISTS `users`
(
  `id`         int(11)                        NOT NULL AUTO_INCREMENT,
  `name`       varchar(80)                    NOT NULL,
  `email`      varchar(80)                    NOT NULL,
  `address`    varchar(500)                   NOT NULL,
  `gender`     enum ('Laki-Laki','Perempuan') NOT NULL,
  `password`   varchar(150)                   NOT NULL,
  `is_admin`   int(11)                        NOT NULL DEFAULT '0',
  `created_at` timestamp                      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB
  AUTO_INCREMENT = 11
  DEFAULT CHARSET = latin1;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE = IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS = IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT = @OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES = IFNULL(@OLD_SQL_NOTES, 1) */;
