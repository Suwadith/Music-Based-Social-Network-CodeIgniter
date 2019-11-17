CREATE TABLE IF NOT EXISTS `ci_sessions` (
        `id` varchar(128) NOT NULL,
        `ip_address` varchar(45) NOT NULL,
        `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
        `data` blob NOT NULL,
        KEY `ci_sessions_timestamp` (`timestamp`)
);

CREATE TABLE IF NOT EXISTS `users` (
        `user_id` int(128) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `username` varchar(16) NOT NULL,
        `password` varchar(255) NOT NULL,
        `profile_name` varchar(32),
        `avatar_ulr` VARCHAR(2083),
        `liked_genres` varchar(255)
);