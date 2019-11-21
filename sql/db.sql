CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id`         VARCHAR(128)               NOT NULL,
  `ip_address` VARCHAR(45)                NOT NULL,
  `timestamp`  INT(10) UNSIGNED DEFAULT 0 NOT NULL,
  `data`       BLOB                       NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `user` (
  `userId`      INT(128)     NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username`    VARCHAR(16)  NOT NULL UNIQUE,
  `password`    VARCHAR(255) NOT NULL,
  `profileName` VARCHAR(32),
  `userEmail`   VARCHAR(128),
  `avatarUrl`   VARCHAR(2083),
  `likedGenres` VARCHAR(255),
  `followersId` MEDIUMTEXT,
  `followingId` MEDIUMTEXT
);

CREATE TABLE IF NOT EXISTS `genre` (
  `userId`      INT(128) NOT NULL,
  `likedGenres` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `post` (
  `postId`      INT(128)   NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `postContent` MEDIUMTEXT NOT NULL,
  `dateTime`    TIMESTAMP  NOT NULL,
  `userId`      INT(128)   NOT NULL
);

CREATE TABLE IF NOT EXISTS `connection` (
  `currentUserId` INT(128) NOT NULL ,
  `followingId`   INT(128) NOT NULL
);