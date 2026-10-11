CREATE DATABASE IF NOT EXISTS `ferremax` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ferremax`;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `detalle_ventas`;
DROP TABLE IF EXISTS `ventas`;
DROP TABLE IF EXISTS `clientes`;
DROP TABLE IF EXISTS `productos`;
DROP TABLE IF EXISTS `usuarios`;
SET FOREIGN_KEY_CHECKS = 1;
CREATE TABLE `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `rol` ENUM('admin', 'empleado', 'cliente') DEFAULT 'empleado',
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `productos` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `codigo` VARCHAR(50) NOT NULL UNIQUE,
    `nombre` VARCHAR(150) NOT NULL,
    `descripcion` TEXT,
    `precio` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `stock` INT NOT NULL DEFAULT 0,
    `stock_minimo` INT NOT NULL DEFAULT 5,
    `categoria` VARCHAR(50) DEFAULT 'general',
    `imagen` VARCHAR(255) DEFAULT 'img/bomba_agua_hd.jpg',
    `badge` VARCHAR(50) DEFAULT NULL,
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `clientes` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nombre` VARCHAR(150) NOT NULL,
    `documento` VARCHAR(30) UNIQUE,
    `telefono` VARCHAR(30),
    `email` VARCHAR(150),
    `direccion` TEXT,
    `creado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `ventas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `cliente_id` INT NULL,
    `total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `metodo_pago` VARCHAR(50) DEFAULT 'efectivo',
    `fecha` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_ventas_usuarios` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_ventas_clientes` FOREIGN KEY (`cliente_id`) REFERENCES `clientes`(`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE `detalle_ventas` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `venta_id` INT NOT NULL,
    `producto_id` INT NOT NULL,
    `cantidad` INT NOT NULL DEFAULT 1,
    `precio_unitario` DECIMAL(10,2) NOT NULL,
    `subtotal` DECIMAL(10,2) NOT NULL,
    CONSTRAINT `fk_detalle_ventas_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_detalle_ventas_producto` FOREIGN KEY (`producto_id`) REFERENCES `productos`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
INSERT INTO `usuarios` (`id`, `nombre`, `email`, `password`, `rol`) VALUES
(1, 'Emely Administradora', 'admin@ferreteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
(2, 'Carlos Empleado', 'empleado@ferreteria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'empleado');
INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `precio`, `stock`, `stock_minimo`, `categoria`, `imagen`, `badge`) VALUES
(1, 'PROD-001', 'Bomba de Agua Periférica', 'Sistema de alta presión para movimiento continuo y eficiente de líquidos en instalaciones residenciales e industriales.', 89.99, 15, 3, 'plomeria', 'img/bomba_agua_hd.jpg', 'Destacado'),
(2, 'PROD-002', 'Adaptador Rosca PVC 1/2"', 'Conecta partes con extremos de diferente diámetro en sistemas de tuberías de presión con empaque hermético.', 15.99, 2, 10, 'plomeria', 'img/Adaptador.jpg', 'PVC Heavy Duty'),
(3, 'PROD-003', 'Juego de Llaves Combinadas', 'Set profesional de llaves cromo vanadio de alta resistencia para trabajo pesado.', 45.00, 20, 5, 'herramientas', 'img/bomba_agua_hd.jpg', 'Grado Industrial');
INSERT INTO `clientes` (`id`, `nombre`, `documento`, `telefono`, `email`, `direccion`) VALUES
(1, 'Juan Pérez', 'V-18239401', '0414-1234567', 'juan.perez@email.com', 'Av. Bolívar Edif 4'),
(2, 'María Rodríguez', 'V-20192834', '0412-7654321', 'maria.rod@email.com', 'Calle Comercio Casa 12');
INSERT INTO `ventas` (`id`, `usuario_id`, `cliente_id`, `total`, `metodo_pago`) VALUES
(1, 1, 1, 89.99, 'efectivo');
INSERT INTO `detalle_ventas` (`venta_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 1, 89.99, 89.99);
SELECT 'Base de datos ferremax configurada exitosamente' AS estado;
