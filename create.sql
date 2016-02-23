CREATE TABLE `trialbigdata` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(25) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `company` VARCHAR(50) NOT NULL,
    `position` VARCHAR(50) NOT NULL DEFAULT '',
    `hobby` VARCHAR(75) NOT NULL,
    `card` VARCHAR(25) NOT NULL,
    `birthdate` VARCHAR(25) NOT NULL DEFAULT '',
    `site` VARCHAR(50) NOT NULL DEFAULT '',
    `gender` VARCHAR(6) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
