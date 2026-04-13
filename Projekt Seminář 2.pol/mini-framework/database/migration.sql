-- database/migration.sql
-- Spusťte tento soubor v MySQL pro vytvoření databáze a tabulky.

CREATE DATABASE IF NOT EXISTS mini_framework CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE mini_framework;

CREATE TABLE IF NOT EXISTS users (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(120)  NOT NULL,
    email      VARCHAR(255)  NOT NULL UNIQUE,
    created_at DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ukázková data
INSERT INTO users (name, email) VALUES
    ('Admin Ukázkový', 'admin@example.com'),
    ('Jana Nováková',  'jana@example.com'),
    ('Petr Svoboda',   'petr@example.com');
