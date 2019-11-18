CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `users` (
        `username` varchar(16) NOT NULL PRIMARY KEY,
        `password` varchar(255) NOT NULL,
        `profileName` varchar(32),
        `avatarUrl` VARCHAR(2083),
        `likedGenres` varchar(255)
);