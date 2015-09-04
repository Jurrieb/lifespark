CREATE TABLE `lifespark`.`users` ( `id` INT(11) NOT NULL AUTO_INCREMENT ,  `email` VARCHAR(255) NOT NULL ,  `password` VARCHAR(255) NOT NULL ,    PRIMARY KEY  (`id`)) ENGINE = InnoDB;
ALTER TABLE `users` ADD `name` VARCHAR(255) NOT NULL AFTER `id`;
ALTER TABLE `users` ADD `modified_at` DATETIME NOT NULL AFTER `password`, ADD `created_at` DATETIME NOT NULL AFTER `modified_at`;
ALTER TABLE `users` ADD `password_salt` VARCHAR(64) NOT NULL AFTER `password`;
