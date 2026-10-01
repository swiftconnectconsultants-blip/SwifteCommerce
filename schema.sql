CREATE DATABASE IF NOT EXISTS db_acd491_ecommcdropshipping CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_acd491_ecommcdropshipping;

CREATE TABLE IF NOT EXISTS products (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 sku VARCHAR(80) NOT NULL UNIQUE,
 name VARCHAR(180) NOT NULL,
 category VARCHAR(80) NOT NULL,
 description TEXT NULL,
 price DECIMAL(12,2) NOT NULL DEFAULT 0,
 cost DECIMAL(12,2) NOT NULL DEFAULT 0,
 stock INT NOT NULL DEFAULT 0,
 sizes VARCHAR(255) NULL,
 colors VARCHAR(255) NULL,
 status ENUM('active','draft','archived') NOT NULL DEFAULT 'active',
 featured TINYINT(1) NOT NULL DEFAULT 0,
 image VARCHAR(255) NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX(category), INDEX(status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_number VARCHAR(80) NOT NULL UNIQUE,
 customer_name VARCHAR(180) NOT NULL,
 email VARCHAR(190) NOT NULL,
 phone VARCHAR(60) NOT NULL,
 address VARCHAR(255) NOT NULL,
 city VARCHAR(100) NOT NULL,
 province VARCHAR(100) NOT NULL,
 postal_code VARCHAR(20) NOT NULL,
 payment_method ENUM('payfast','ozow') NOT NULL,
 gateway_reference VARCHAR(190) NULL,
 status ENUM('pending','paid','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
 subtotal DECIMAL(12,2) NOT NULL,
 shipping DECIMAL(12,2) NOT NULL,
 total DECIMAL(12,2) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 INDEX(email), INDEX(status)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_items (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 order_id INT UNSIGNED NOT NULL,
 product_id INT UNSIGNED NULL,
 sku VARCHAR(80) NOT NULL,
 name VARCHAR(180) NOT NULL,
 qty INT NOT NULL,
 unit_price DECIMAL(12,2) NOT NULL,
 total DECIMAL(12,2) NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 INDEX(order_id)
) ENGINE=InnoDB;

INSERT INTO products (sku,name,category,description,price,cost,stock,sizes,colors,status,featured)
VALUES
('TS-BLK-001','Essential Black Tee','T-Shirts','Heavyweight everyday T-shirt with a clean monochrome finish.',299,120,50,'S,M,L,XL','Black','active',1),
('TS-WHT-001','Essential White Tee','T-Shirts','Minimal white T-shirt designed for everyday wear.',299,120,60,'S,M,L,XL','White','active',1),
('SH-BLK-001','Urban Shorts','Shorts','Relaxed fit shorts with a clean utility silhouette.',349,150,35,'S,M,L,XL','Black','active',1),
('CP-BLK-001','Classic Logo Cap','Caps','Structured six-panel cap with minimal branding.',199,80,100,'One Size','Black','active',1)
ON DUPLICATE KEY UPDATE sku=sku;
