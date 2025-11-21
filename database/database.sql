-- ===========================================
-- CREATE DATABASE
-- ===========================================
CREATE DATABASE IF NOT EXISTS perpustakaan_db;
USE perpustakaan_db;

-- ===========================================
-- TABLE: users
-- ===========================================
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('administrator','peminjam') NOT NULL DEFAULT 'peminjam',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================
-- TABLE: books
-- ===========================================
CREATE TABLE `books` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(150) DEFAULT NULL,
  `isbn` VARCHAR(50) DEFAULT NULL,
  `stock` INT DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ===========================================
-- TABLE: borrows
-- ===========================================
CREATE TABLE `borrows` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `book_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `borrow_date` DATE NOT NULL,
  `due_date` DATE NOT NULL,
  `return_date` DATE DEFAULT NULL,
  `status` ENUM('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (`book_id`) REFERENCES books(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES users(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ===========================================
-- INSERT DEFAULT ADMIN (password: admin123)
-- ===========================================
INSERT INTO `users` (`name`, `email`, `password`, `role`)
VALUES ('Administrator', 'admin@local', MD5('admin123'), 'administrator');