-- Schema for "restaurantes" database used by the Reservas project
-- Compatible with MySQL/MariaDB

CREATE DATABASE IF NOT EXISTS restaurantes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE restaurantes;

-- Tables
DROP TABLE IF EXISTS Reservations;
DROP TABLE IF EXISTS Mesas;
DROP TABLE IF EXISTS Customers;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS restaurants;

CREATE TABLE restaurants (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  image_url VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Customers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(30),
  pass VARCHAR(255) NOT NULL,
  last_ip VARCHAR(45) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(120) NOT NULL UNIQUE,
  pass VARCHAR(255) NOT NULL,
  ip VARCHAR(45) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Mesas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  restaurant_id INT NOT NULL,
  table_number INT NOT NULL,
  CONSTRAINT fk_mesas_restaurant
    FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE Reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reservation_date DATETIME NOT NULL,
  number_of_people INT NOT NULL,
  customer_id INT NOT NULL,
  mesa_id INT NOT NULL,
  restaurant_id INT NOT NULL,
  CONSTRAINT fk_res_customer FOREIGN KEY (customer_id) REFERENCES Customers(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_res_mesa FOREIGN KEY (mesa_id) REFERENCES Mesas(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_res_restaurant FOREIGN KEY (restaurant_id) REFERENCES restaurants(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed basic data
INSERT INTO restaurants (name, description, image_url) VALUES
('Restaurante Italiano', 'Auténtica cocina italiana en ambiente acogedor.', 'https://st2.depositphotos.com/3690537/5231/i/450/depositphotos_52318349-stock-photo-dining-out.jpg'),
('Restaurante Mexicano', 'Platillos mexicanos en ambiente festivo.', 'https://st2.depositphotos.com/3386033/6930/i/450/depositphotos_69308469-stock-photo-elegant-restaurant-interior.jpg');

-- Create some tables per restaurant
INSERT INTO Mesas (restaurant_id, table_number)
SELECT r.id, n.num
FROM restaurants r
JOIN (SELECT 1 AS num UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5) n;

-- Add a default admin (email: admin@example.com, pass: admin)
INSERT INTO admins (email, pass, ip) VALUES ('admin@example.com', 'admin', NULL);
