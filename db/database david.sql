-- Generado por Tecnopraxis — Diseñador de BD

CREATE TABLE `students` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(32) NOT NULL,
  `student_last_name` VARCHAR(32),
  `identification` INT,
  `section` VARCHAR(32),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_students_identification` (`identification`)
);

CREATE TABLE `books` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255),
  `author` VARCHAR(255),
  `category` VARCHAR(255),
  `num_copies` INT,
  PRIMARY KEY (`id`)
);

CREATE TABLE `loans` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `copy_id` INT,
  `student_id` INT,
  `loan_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expected_return_date` TIMESTAMP,
  `loan_status` VARCHAR(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `announcements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` TEXT NOT NULL,
  `content` TEXT NOT NULL,
  `announcement_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expiration_date` TIMESTAMP,
  `admin_author` VARCHAR(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `copies` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `book_id` VARCHAR(255),
  `status` VARCHAR(255),
  PRIMARY KEY (`id`)
);

CREATE TABLE `configuration` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `admin_password` TEXT NOT NULL,
  `max_active_loans` INT DEFAULT 3,
  `loan_days` INT DEFAULT 15,
  PRIMARY KEY (`id`)
);

ALTER TABLE `copies` ADD CONSTRAINT `fk_rel_22` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `loans` ADD CONSTRAINT `fk_rel_31` FOREIGN KEY (`copy_id`) REFERENCES `copies` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `loans` ADD CONSTRAINT `fk_rel_32` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;