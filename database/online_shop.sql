-- ---------------------------------------------------------------------------
-- Database Haikal Frozen Food
--
-- Cara pakai (XAMPP / phpMyAdmin):
--   1. Buka phpMyAdmin -> tab "Import" -> pilih file ini -> Go.
--   atau lewat terminal:  mysql -u root < database/online_shop.sql
--
-- Login admin bawaan:  username "admin", password "admin123"
-- (segera ganti lewat menu Admin -> Pengaturan).
--
-- Catatan harga: harga disimpan dalam RIBUAN rupiah.
--   contoh: 25 = Rp25.000, 12.5 = Rp12.500
--
-- Kalau database lama sudah ada, cukup jalankan bagian "MIGRASI" di bawah.
-- ---------------------------------------------------------------------------

CREATE DATABASE IF NOT EXISTS online_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE online_shop;

CREATE TABLE IF NOT EXISTS admin_account (
  id INT AUTO_INCREMENT PRIMARY KEY,
  admin_name VARCHAR(100) NOT NULL,
  admin_password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_ip VARCHAR(64) NOT NULL DEFAULT '',
  username VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  password VARCHAR(255) NOT NULL,
  user_image VARCHAR(255) NOT NULL DEFAULT '',
  user_block TINYINT(1) NOT NULL DEFAULT 0,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS category (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_name VARCHAR(100) NOT NULL,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL DEFAULT 0,
  category_name VARCHAR(100) NOT NULL DEFAULT '',
  product_name VARCHAR(150) NOT NULL,
  product_price DECIMAL(12,3) NOT NULL DEFAULT 0,
  product_desc TEXT,
  product_image VARCHAR(255) NOT NULL DEFAULT '',
  product_image1 VARCHAR(255) NOT NULL DEFAULT '',
  product_image2 VARCHAR(255) NOT NULL DEFAULT '',
  product_image3 VARCHAR(255) NOT NULL DEFAULT '',
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS jenis (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  jenis_rand INT NOT NULL DEFAULT 0,
  jenis_name VARCHAR(100) NOT NULL,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS sizes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  size_rand INT NOT NULL DEFAULT 0,
  product_size VARCHAR(100) NOT NULL,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip_add VARCHAR(64) NOT NULL,
  product_id INT NOT NULL,
  product_size VARCHAR(100) NOT NULL DEFAULT '',
  product_jenis VARCHAR(100) NOT NULL DEFAULT '',
  product_quantity INT NOT NULL DEFAULT 1,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS wish (
  id INT AUTO_INCREMENT PRIMARY KEY,
  ip_add VARCHAR(64) NOT NULL,
  product_id INT NOT NULL,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_ip VARCHAR(64) NOT NULL,
  invoice_no BIGINT NOT NULL,
  product_id INT NOT NULL,
  product_name VARCHAR(150) NOT NULL DEFAULT '',
  product_price DECIMAL(12,3) NOT NULL DEFAULT 0,
  total_price DECIMAL(14,3) NOT NULL DEFAULT 0,
  product_jenis VARCHAR(100) NOT NULL DEFAULT '',
  product_size VARCHAR(100) NOT NULL DEFAULT '',
  product_quantity INT NOT NULL DEFAULT 1,
  user_name VARCHAR(150) NOT NULL DEFAULT '',
  user_email VARCHAR(150) NOT NULL DEFAULT '',
  user_phone VARCHAR(50) NOT NULL DEFAULT '',
  user_address TEXT,
  date DATETIME NULL,
  KEY idx_invoice (invoice_no)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  review_product_id INT NOT NULL,
  review_product_name VARCHAR(150) NOT NULL DEFAULT '',
  review_rate DECIMAL(3,1) NOT NULL DEFAULT 0,
  review_message TEXT,
  review_name VARCHAR(150) NOT NULL DEFAULT '',
  review_image VARCHAR(255) NOT NULL DEFAULT '',
  review_email VARCHAR(150) NOT NULL DEFAULT '',
  review_date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS opinion (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_ip VARCHAR(64) NOT NULL DEFAULT '',
  user_name VARCHAR(150) NOT NULL DEFAULT '',
  user_image VARCHAR(255) NOT NULL DEFAULT '',
  user_message TEXT,
  date DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal -----------------------------------------------------------------
INSERT INTO admin_account (admin_name, admin_password)
SELECT 'admin', MD5('admin123') FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM admin_account);

INSERT INTO category (category_name, date)
SELECT * FROM (SELECT 'Nugget', NOW()) AS t
WHERE NOT EXISTS (SELECT 1 FROM category);
INSERT INTO category (category_name, date)
SELECT 'Gorengan', NOW() FROM DUAL
WHERE (SELECT COUNT(*) FROM category) = 1;

-- MIGRASI untuk database lama ---------------------------------------------
-- Jalankan baris di bawah ini SEKALI saja jika tabel `products` belum punya
-- kolom category_id (filter kategori di halaman Toko membutuhkannya):
--
--   ALTER TABLE products ADD COLUMN category_id INT NOT NULL DEFAULT 0 AFTER id;
--   UPDATE products p JOIN category c ON c.category_name = p.category_name
--      SET p.category_id = c.id;
