CREATE DATABASE dolphin_crm;

USE dolphin_crm;

CREATE TABLE USERS(
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    email VARCHAR(50),
    password VARCHAR(50),
    role VARCHAR(50)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE CUSTOMERS(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(20),
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    telephone VARCHAR(20),
    company VARCHAR(255),
    type VARCHAR(50),
    assigned_to INT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Notes(
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    contact_id INTEGER,
    comment TEXT,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
);

INSERT INTO Users(first_name, last_name, email, password, role, created_at) VALUES
('Admin', 'User', 'admin@project2.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW());