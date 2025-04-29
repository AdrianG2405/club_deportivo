-- Crear la base de datos si no existe
CREATE DATABASE IF NOT EXISTS club_deportivo;
USE club_deportivo;

-- Tabla de usuarios
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_usuario VARCHAR(50) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('entrenador', 'padre') NOT NULL
);

-- Usuarios de prueba
INSERT INTO usuarios (nombre_usuario, contrasena, rol) VALUES
('admin', '123', 'entrenador'),
('juanpadre', '1234', 'padre');

-- Tabla de jugadores
DROP TABLE IF EXISTS jugadores;
CREATE TABLE jugadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    edad INT,
    posicion VARCHAR(50)
);

-- Tabla de asistencia
DROP TABLE IF EXISTS asistencia;
CREATE TABLE asistencia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugador_id INT,
    fecha DATE,
    presente BOOLEAN,
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
);

-- Tabla de pagos
DROP TABLE IF EXISTS pagos;
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jugador_id INT,
    fecha_pago DATE,
    monto DECIMAL(10,2),
    pagado BOOLEAN,
    FOREIGN KEY (jugador_id) REFERENCES jugadores(id)
);

-- Tabla de partidos
DROP TABLE IF EXISTS partidos;
CREATE TABLE partidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipo_contrario VARCHAR(100),
    fecha DATE,
    lugar VARCHAR(100)
);
