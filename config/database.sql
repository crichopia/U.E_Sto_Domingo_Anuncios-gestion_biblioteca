-- Base de datos para U.E. Sto. Domingo - anuncios y biblioteca
-- Compatible con config/db.php: db_paginaescuela

CREATE DATABASE IF NOT EXISTS `db_paginaescuela`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `db_paginaescuela`;

-- Usuarios utilizados por login.php y crud_register.php
CREATE TABLE IF NOT EXISTS `user_data` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(30) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_data_username` (`username`)
) ENGINE=InnoDB;

-- Anuncios utilizados por crud_news.php y las vistas de noticias
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` TEXT NOT NULL,
  `importance` VARCHAR(20) NOT NULL DEFAULT 'normal',
  `author` VARCHAR(100) NOT NULL,
  `announcement_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_announcements_date` (`announcement_date`),
  KEY `idx_announcements_importance` (`importance`)
) ENGINE=InnoDB;

-- Libros mostrados por biblioteca.php y bibliotecaControl.php
CREATE TABLE IF NOT EXISTS `books` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `img_url` VARCHAR(500) DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) DEFAULT NULL,
  `publisher` VARCHAR(255) DEFAULT NULL,
  `year` VARCHAR(10) DEFAULT 'n/a',
  `materia` VARCHAR(100) DEFAULT 'n/a',
  `status` VARCHAR(30) NOT NULL DEFAULT 'disponible',
  `num_copies` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `idx_books_title` (`title`)
) ENGINE=InnoDB;

-- Tablas de apoyo para préstamos de biblioteca.
CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_name` VARCHAR(32) NOT NULL,
  `student_last_name` VARCHAR(32) DEFAULT NULL,
  `identification` VARCHAR(32) DEFAULT NULL,
  `section` VARCHAR(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_students_identification` (`identification`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `copies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` INT UNSIGNED NOT NULL,
  `status` VARCHAR(30) NOT NULL DEFAULT 'disponible',
  PRIMARY KEY (`id`),
  KEY `idx_copies_book_id` (`book_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `loans` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `copy_id` INT UNSIGNED NOT NULL,
  `student_id` INT UNSIGNED NOT NULL,
  `loan_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expected_return_date` TIMESTAMP NULL DEFAULT NULL,
  `loan_status` VARCHAR(30) NOT NULL DEFAULT 'activo',
  PRIMARY KEY (`id`),
  KEY `idx_loans_copy_id` (`copy_id`),
  KEY `idx_loans_student_id` (`student_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `configuration` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_password` VARCHAR(255) NOT NULL,
  `max_active_loans` INT UNSIGNED NOT NULL DEFAULT 3,
  `loan_days` INT UNSIGNED NOT NULL DEFAULT 15,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- Usuario administrador inicial. Cambia esta contraseña al instalar el sistema.
INSERT INTO `user_data` (`username`, `password`, `role`)
SELECT 'admin', 'admin', 'admin'
WHERE NOT EXISTS (
  SELECT 1 FROM `user_data` WHERE `username` = 'admin'
);
