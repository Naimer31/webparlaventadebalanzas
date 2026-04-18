-- Script de Inicialización de Base de Datos para el Sistema de Balanzas
CREATE DATABASE IF NOT EXISTS balanzas_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE balanzas_db;

-- Tabla de Usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'cliente') DEFAULT 'cliente',
    telefono VARCHAR(50),
    direccion VARCHAR(255),
    empresa_ruc VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de Categorías (Balanzas comerciales, digitales, industriales, etc.)
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
);

-- Tabla de Productos (Balanzas)
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    marca VARCHAR(100) NOT NULL,
    modelo VARCHAR(100),
    capacidad VARCHAR(50), -- Ej: '30 kg', '500 kg'
    precio DECIMAL(10,2) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    stock INT DEFAULT 0,
    categoria_id INT,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE SET NULL
);

-- Tabla de Carrito (Persistencia en base de datos para usuarios registrados)
CREATE TABLE IF NOT EXISTS carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Tabla de Ventas (Pedidos)
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Pendiente', 'Pagado', 'Entregado', 'Cancelado') DEFAULT 'Pendiente',
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla Detalle_Venta (Productos dentro de cada pedido)
CREATE TABLE IF NOT EXISTS detalle_venta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio INT NOT NULL, -- Precio al momento de la venta
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE RESTRICT
);

-- Inserción de un Usuario Administrador por defecto (contraseña: admin123)
-- hash: $2y$10$wE8a.G1R3.c.hDItO05DkO0c2zX7Q3u//k/Ue4/uXz0QJ.5lM4iP2
INSERT INTO usuarios (nombre, correo, contrasena, rol) VALUES 
('Administrador', 'admin@balanzas.com', '$2y$10$wE8a.G1R3.c.hDItO05DkO0c2zX7Q3u//k/Ue4/uXz0QJ.5lM4iP2', 'admin')
ON DUPLICATE KEY UPDATE correo = correo;

-- Inserción de Categorías Base
INSERT INTO categorias (nombre) VALUES 
('Balanzas Comerciales'),
('Balanzas Digitales'),
('Balanzas Industriales'),
('Balanzas de Precisión'),
('Balanzas con Impresora')
ON DUPLICATE KEY UPDATE nombre = nombre;

-- Inserción de Productos de Ejemplo
INSERT INTO productos (nombre, marca, modelo, capacidad, precio, descripcion, imagen, stock, categoria_id) VALUES
('Balanza de Excell', 'Excell', 'EX-200', '30 kg', 150.00, 'Balanza ideal para comercios pequeños.', 'assets/img/Balanza%20de%20%20Excell.png', 10, 1),
('Balanza de Tallímetro', 'HealthScale', 'HT-100', '200 kg', 250.00, 'Balanza con tallímetro para hospitales y clínicas.', 'assets/img/Balanza%20de%20tallimetro.png', 5, 2),
('Balanza EXELTOR 150KG', 'Exeltor', 'EX-150', '150 kg', 300.00, 'Balanza digital industrial de 150kg.', 'assets/img/EXELTOR%20-%20150KG.jpg', 8, 3),
('Balanza EXELTOR 300KG', 'Exeltor', 'EX-300', '300 kg', 450.00, 'Equipo de pesaje robusto para uso industrial.', 'assets/img/EXELTOR%20-%20300KG.png', 4, 3);