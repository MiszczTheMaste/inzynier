SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `app` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `app`;

CREATE TABLE `chores` (
                          `id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `room_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `icon_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `user_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `days_interval` smallint(6) NOT NULL,
                          `name` varchar(126) COLLATE utf8_polish_ci NOT NULL,
                          `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
                          `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `chores_fulfilments` (
                                      `id` char(36) COLLATE utf8_polish_ci NOT NULL,
                                      `chore_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                                      `rate` tinyint(126) UNSIGNED NOT NULL,
                                      `finished` tinyint(1) NOT NULL DEFAULT 0,
                                      `deadline` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `houses` (
                          `id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `icon_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `owner_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                          `name` varchar(126) COLLATE utf8_polish_ci NOT NULL,
                          `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
                          `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `houses_users` (
                                `house_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                                `user_id` char(36) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `icons` (
                         `icon_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                         `src` varchar(126) COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `rooms` (
                         `id` char(36) COLLATE utf8_polish_ci NOT NULL,
                         `house_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                         `name` varchar(126) COLLATE utf8_polish_ci NOT NULL,
                         `icon_id` char(36) COLLATE utf8_polish_ci NOT NULL,
                         `creation_date` timestamp NOT NULL DEFAULT current_timestamp(),
                         `removed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

CREATE TABLE `users` (
                         `id` char(36) COLLATE utf8_polish_ci NOT NULL,
                         `username` varchar(16) COLLATE utf8_polish_ci NOT NULL,
                         `password` varchar(126) COLLATE utf8_polish_ci NOT NULL,
                         `creation_date` datetime NOT NULL,
                         `removed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

ALTER TABLE `chores`
    ADD PRIMARY KEY (`id`),
    ADD KEY `room_id` (`room_id`),
    ADD KEY `icon_id` (`icon_id`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `chores_fulfilments`
    ADD PRIMARY KEY (`id`),
    ADD KEY `chore_id` (`chore_id`),
    ADD KEY `deadline` (`deadline`);

ALTER TABLE `houses`
    ADD PRIMARY KEY (`id`),
    ADD KEY `icon_id` (`icon_id`),
    ADD KEY `owner_id` (`owner_id`);

ALTER TABLE `houses_users`
    ADD PRIMARY KEY (`house_id`,`user_id`),
    ADD KEY `house_id` (`house_id`),
    ADD KEY `user_id` (`user_id`);

ALTER TABLE `icons`
    ADD PRIMARY KEY (`icon_id`);

ALTER TABLE `rooms`
    ADD PRIMARY KEY (`id`),
    ADD KEY `house_id` (`house_id`),
    ADD KEY `icon_id` (`icon_id`) USING BTREE;

ALTER TABLE `users`
    ADD UNIQUE KEY `id` (`id`),
    ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `chores`
    ADD CONSTRAINT `chores_ibfk_1` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`icon_id`),
    ADD CONSTRAINT `chores_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`),
    ADD CONSTRAINT `chores_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `chores_fulfilments`
    ADD CONSTRAINT `chores_fulfilments_ibfk_1` FOREIGN KEY (`chore_id`) REFERENCES `chores` (`id`);

ALTER TABLE `houses`
    ADD CONSTRAINT `houses_ibfk_1` FOREIGN KEY (`icon_id`) REFERENCES `icons` (`icon_id`),
    ADD CONSTRAINT `houses_ibfk_2` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

ALTER TABLE `houses_users`
    ADD CONSTRAINT `houses_users_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`),
    ADD CONSTRAINT `houses_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `rooms`
    ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `houses` (`id`);

INSERT INTO icons VALUES ('a06478fe-92fa-4cd9-a583-03f308e36f60', 'test');
COMMIT;
