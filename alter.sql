-- execute it after importing data from csv file
ALTER TABLE `trialbigdata`
    ADD INDEX `phone` (`phone`),
    ADD INDEX `email` (`email`),
    ADD INDEX `card` (`card`);
