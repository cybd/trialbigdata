CREATE TABLE `trialbigdata` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `phone` VARCHAR(50) NOT NULL,
    `email` VARCHAR(50) NOT NULL,
    `address` VARCHAR(100) NOT NULL,
    `company` VARCHAR(50) NOT NULL,
    `position` VARCHAR(50) NULL DEFAULT NULL,
    `hobby` VARCHAR(50) NOT NULL,
    `card` VARCHAR(50) NOT NULL,
    `birthdate` VARCHAR(50) NULL DEFAULT NULL,
    `site` VARCHAR(50) NULL DEFAULT NULL,
    `gender` VARCHAR(10) NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
