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

-- About the status of the session:
-- 0 - Destroyed: Logged out by the user him/herself, and this kind of token stored in cookie is invalid for re-login
-- 1 - Active : User is still using the network
-- 2 - Inactive : Auto logged out by the cron script
CREATE TABLE `session` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` CHAR(32) NOT NULL,
  `uid` SMALLINT UNSIGNED NOT NULL,
  `gw_id` VARCHAR(255) NOT NULL,
  `mac` CHAR(17) NOT NULL,
  `createtime` INT UNSIGNED NOT NULL,
  `lastlogintime` INT UNSIGNED NOT NULL,
  `updatetime` INT UNSIGNED NOT NULL,
  `status` TINYINT UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;