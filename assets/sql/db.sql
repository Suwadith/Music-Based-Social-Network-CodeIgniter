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
  `userEmail`   VARCHAR(64) NOT NULL,
  `profileName` VARCHAR(32),
  `avatarUrl`   VARCHAR(2083)
);

CREATE TABLE IF NOT EXISTS `genre` (
  `genreId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userId`      INT(128) NOT NULL UNIQUE,
  `likedGenres` VARCHAR(255),
  FOREIGN KEY (`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `post` (
  `postId`      INT(128)   NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userId`      INT(128)   NOT NULL,
  `postContent` MEDIUMTEXT NOT NULL,
  `dateTime`    TIMESTAMP  NOT NULL,
  FOREIGN KEY (`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `connection` (
  `connectionId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `currentUserId`   INT(128) NOT NULL,
  `followingUserId` INT(128) NOT NULL,
  FOREIGN KEY (`currentUserId`) REFERENCES `user`(`userId`) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `contact_user` (
  `contactId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `userId`      INT(128) NOT NULL,
  `firstName` VARCHAR(30) NOT NULL,
  `lastName` VARCHAR(30) NOT NULL,
  `emailAddress` VARCHAR(90) NOT NULL,
  `telephoneNumber` VARCHAR(16) NOT NULL,
  FOREIGN KEY (`userId`) REFERENCES `user`(`userId`) ON DELETE CASCADE ON UPDATE RESTRICT
);

CREATE TABLE IF NOT EXISTS `contact_tag` (
  `tagId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `contactId` INT(128) NOT NULL UNIQUE,
  `relationalTag` VARCHAR(32),
  FOREIGN KEY (`contactId`) REFERENCES `contact_user`(`contactId`) ON DELETE CASCADE ON UPDATE RESTRICT
);