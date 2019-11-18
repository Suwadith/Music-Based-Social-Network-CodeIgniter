CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` VARCHAR(128) NOT NULL,
        `ip_address` VARCHAR(45) NOT NULL,
        `timestamp` INT(10) UNSIGNED DEFAULT 0 NOT NULL,
        `data` BLOB NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `users` (
        `userId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(16) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `profileName` VARCHAR(32),
        `avatarUrl` VARCHAR(2083),
        `likedGenres` VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS `posts` (
        `postId` INT(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `postContent` MEDIUMTEXT NOT NULL,
        `dateTime` TIMESTAMP NOT NULL,
        `userId` INT(128) NOT NULL
)