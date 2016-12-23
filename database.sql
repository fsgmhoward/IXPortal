-- WARNING: table `user` and `session` will be DROPPED IF EXISTS!
-- Please remember to backup your table before import this sql file!

DROP TABLE IF EXISTS `user`;
DROP TABLE IF EXISTS `session`;

CREATE TABLE `user` (
  `id` SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(255) NOT NULL,
  `password` CHAR(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `session` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` CHAR(32) NOT NULL,
  `uid` SMALLINT UNSIGNED NOT NULL,
  `gw_id` VARCHAR(255) NOT NULL,
  `mac` CHAR(17) NOT NULL,
  `url` TEXT NULL DEFAULT NULL,
  `createtime` SMALLINT UNSIGNED NOT NULL,
  `updatetime` SMALLINT UNSIGNED NOT NULL,
  `status` BOOLEAN NOT NULL DEFAULT TRUE,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;