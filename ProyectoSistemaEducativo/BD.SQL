/*
CREATE DATABASE IF NOT EXISTS sistema_educativo;
USE sistema_educativo;

-- -- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);
*/

USE appdb;

-- Tabla Usuarios
CREATE TABLE IF NOT EXISTS eduambiente_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('usuario', 'admin') DEFAULT 'usuario',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Centros de Acopio
CREATE TABLE IF NOT EXISTS centros_acopio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    provincia VARCHAR(50) NOT NULL,
    materiales TEXT NOT NULL,
    horario VARCHAR(100) NOT NULL
);

-- Tabla de Educación Ambiental
CREATE TABLE IF NOT EXISTS educacion_ambiental (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    enlace VARCHAR(255)
);

-- Tabla de Recursos Educativos
CREATE TABLE IF NOT EXISTS recursos_educativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    enlace VARCHAR(255)
);

-- Tabla de Rutas de Reciclaje
CREATE TABLE IF NOT EXISTS rutas_reciclaje (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT NOT NULL,
    enlace VARCHAR(255)
);
