-- init.sql

CREATE TABLE `clients` (
  `id` INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `added` DATETIME NOT NULL,
  `status` ENUM('new', 'registered', 'unavailable', 'rejected'),
  `phone` VARCHAR(50),
  INDEX `name` (`last_name`, `first_name`)
);

