CREATE DATABASE dolphin_crm;

USE dolphin_crm;

CREATE TABLE Users (


    id INTEGER AUTO_INCREMENT PRIMARY KEY,

    firstname VARCHAR(255),
    lastname VARCHAR(255),

    password VARCHAR(255),

    email VARCHAR(255),


    role VARCHAR(50),


);

CREATE TABLE Contacts (

    id INTEGER AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(20),
    firstname VARCHAR(255),


    lastname VARCHAR(255),
    email VARCHAR(255),
    telephone VARCHAR(20),

    company VARCHAR(255),


    type VARCHAR(50),
    assigned_to INTEGER,
    created_by INTEGER,
    
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Notes (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,

    contact_id INTEGER,


    comment TEXT,
    created_by INTEGER,

);

-- Initaila password for me to log in 
--I had to hash it using PHP password_hash function to find out what the hash of
--password123 is

INSERT INTO Users (firstname, lastname, password, email, role) 
VALUES ('Admin', 'User', '$2y$10$asdfghjkl1234567890...', 'admin@project2.com', 'Admin');