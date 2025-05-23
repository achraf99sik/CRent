<?php

/**
 * Database config
 */
define('DBHOST', 'localhost');
define('DBNAME', 'CRent');
define('DBUSER', 'root');
define('DBPASS', '');
define('DB', 'mysql');

define('APP_NAME', value: 'CRent');

define('ROOT', 'http://localhost/CRent');

const TABLES = "
    CREATE TABLE IF NOT exists users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(150) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        phone VARCHAR(20),
        role ENUM('admin', 'customer') DEFAULT 'customer',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT exists cars (
        id INT AUTO_INCREMENT PRIMARY KEY,
        brand VARCHAR(100) NOT NULL,
        model VARCHAR(100) NOT NULL,
        year YEAR NOT NULL,
        registration_number VARCHAR(50) UNIQUE NOT NULL,
        price_per_day DECIMAL(10, 2) NOT NULL,
        status ENUM('available', 'rented', 'maintenance') DEFAULT 'available',
        image VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE IF NOT exists rentals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        car_id INT NOT NULL,
        rental_date DATE NOT NULL,
        return_date DATE,
        total_price DECIMAL(10, 2),
        status ENUM('ongoing', 'completed', 'cancelled') DEFAULT 'ongoing',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT exists payments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        rental_id INT NOT NULL,
        amount DECIMAL(10, 2) NOT NULL,
        payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        method ENUM('card', 'cash', 'paypal') NOT NULL,
        status ENUM('paid', 'failed', 'pending') DEFAULT 'pending',
        FOREIGN KEY (rental_id) REFERENCES rentals(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT exists maintenance_records (
        id INT AUTO_INCREMENT PRIMARY KEY,
        car_id INT NOT NULL,
        description TEXT,
        cost DECIMAL(10, 2),
        maintenance_date DATE NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    );

    CREATE TABLE IF NOT exists reviews (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        car_id INT NOT NULL,
        rating INT CHECK (rating BETWEEN 1 AND 5),
        comment TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
    )

";