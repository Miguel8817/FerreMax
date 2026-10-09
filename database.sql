-- ===================================================
-- SCRIPT DE BASE DE DATOS MYSQL PARA FERREMAX
-- Desarrollado por Emeli (Gris y Azul Oscuro)
-- Compatible con XAMPP (Local) y Railway / MySQL Cloud
-- ===================================================

CREATE DATABASE IF NOT EXISTS ferremax CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ferremax;

-- 1. Tabla de Usuarios con Soporte de Roles (Admin / Empleado)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'empleado') NOT NULL DEFAULT 'empleado',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabla de Productos e Inventario
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50) NOT NULL UNIQUE,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    stock_minimo INT NOT NULL DEFAULT 5,
    categoria ENUM('plomeria', 'herramientas', 'ofertas', 'general') NOT NULL DEFAULT 'general',
    imagen VARCHAR(255) DEFAULT 'img/bomba_agua_hd.jpg',
    badge VARCHAR(50) DEFAULT 'En Tienda',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabla de Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    documento VARCHAR(40) UNIQUE,
    telefono VARCHAR(30),
    email VARCHAR(100),
    direccion TEXT,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabla de Ventas / Facturación
CREATE TABLE IF NOT EXISTS ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cliente_id INT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    metodo_pago ENUM('efectivo', 'tarjeta', 'transferencia') NOT NULL DEFAULT 'efectivo',
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Detalle de Ventas
CREATE TABLE IF NOT EXISTS detalle_ventas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    venta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (venta_id) REFERENCES ventas(id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserción de Usuarios por defecto (Password: admin123 y emp123 en hash o plano para demo)
INSERT INTO usuarios (nombre, email, password, rol) VALUES
('Emeli Administradora', 'admin@ferremax.com', '$2y$10$e8w.xQ.9hXvLpWv0YfCg/eLg7kQz.L4/K2tK9.uJ5lJ5Z5Z5Z5Z5Z', 'admin'),
('Carlos Empleado', 'empleado@ferremax.com', '$2y$10$e8w.xQ.9hXvLpWv0YfCg/eLg7kQz.L4/K2tK9.uJ5lJ5Z5Z5Z5Z5Z', 'empleado')
ON DUPLICATE KEY UPDATE id=id;

-- Inserción de Productos Iniciales con Control de Stock
INSERT INTO productos (codigo, nombre, descripcion, precio, stock, stock_minimo, categoria, imagen, badge) VALUES
('PROD-001', 'Bomba de Agua Periférica', 'Sistema de alta presión para movimiento continuo de agua.', 89.99, 15, 3, 'plomeria', 'img/bomba_agua_hd.jpg', 'Destacado'),
('PROD-002', 'Adaptador Rosca PVC 1/2"', 'Conecta tuberías de alta presión herméticamente.', 15.99, 4, 10, 'plomeria', 'img/Adaptador.jpg', 'PVC Heavy Duty'),
('PROD-003', 'Juego de Llaves Combinadas', 'Set profesional de llaves cromo vanadio de alta resistencia.', 45.00, 20, 5, 'herramientas', 'img/bomba_agua_hd.jpg', 'Industrial'),
('PROD-004', 'Pintura Vinil Acrílica Premium', 'Pintura lavable para interiores y exteriores.', 800.00, 2, 5, 'ofertas', 'img/pintura_acrilica_hd.jpg', 'Oferta'),
('PROD-005', 'Pintura Dura Látex Profesional', 'Excelente resistencia al lavado frecuente y acabado satinado.', 450.00, 8, 4, 'ofertas', 'img/pintura_latex_hd.jpg', 'Popular')
ON DUPLICATE KEY UPDATE id=id;

-- Inserción de Clientes Iniciales
INSERT INTO clientes (nombre, documento, telefono, email, direccion) VALUES
('Juan Pérez', 'V-18239401', '0414-1234567', 'juan.perez@email.com', 'Av. Bolivar Edif 4'),
('Maria Rodriguez', 'V-20192834', '0412-7654321', 'maria.rod@email.com', 'Calle Comercio Casa 12')
ON DUPLICATE KEY UPDATE id=id;
