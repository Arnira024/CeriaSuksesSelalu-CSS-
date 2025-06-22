
DROP DATABASE IF EXISTS tiket_kereta;
CREATE DATABASE tiket_kereta;
USE tiket_kereta;

-- Tabel Users (user dan admin)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    role ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabel Stations
CREATE TABLE stations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(10) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    city VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabel Schedules
CREATE TABLE schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    train_name VARCHAR(100) NOT NULL,
    train_type ENUM('Ekonomi', 'Bisnis', 'Eksekutif') NOT NULL,
    departure_station_id INT NOT NULL,
    arrival_station_id INT NOT NULL,
    departure_time DATETIME NOT NULL,
    arrival_time DATETIME NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (departure_station_id) REFERENCES stations(id),
    FOREIGN KEY (arrival_station_id) REFERENCES stations(id)
) ENGINE=InnoDB;

-- Tabel Tickets (dengan tracking_status)
CREATE TABLE tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    schedule_id INT NOT NULL,
    seat_number VARCHAR(10),
    status ENUM('booked', 'cancelled', 'paid') DEFAULT 'booked',
    tracking_status ENUM('pending', 'confirmed', 'paid', 'used', 'expired') DEFAULT 'pending',
    booked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (schedule_id) REFERENCES schedules(id)
) ENGINE=InnoDB;

-- Tabel Payments
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ticket_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    method VARCHAR(50),
    status ENUM('pending', 'success', 'failed') DEFAULT 'pending',
    paid_at DATETIME,
    FOREIGN KEY (ticket_id) REFERENCES tickets(id)
) ENGINE=InnoDB;
