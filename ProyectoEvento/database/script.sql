CREATE DATABASE IF NOT EXISTS parcial_itech;
USE parcial_itech;

CREATE TABLE IF NOT EXISTS paises (
  id_pais INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS areas_interes (
  id_area INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS inscriptores (
  id_inscriptor INT AUTO_INCREMENT PRIMARY KEY,
  identidad VARCHAR(20) NOT NULL UNIQUE,
  nombre VARCHAR(100) NOT NULL,
  apellido VARCHAR(100) NOT NULL,
  edad INT NOT NULL,
  sexo VARCHAR(20) NOT NULL,
  id_pais_residencia INT NOT NULL,
  id_nacionalidad INT NOT NULL,
  correo VARCHAR(150) NOT NULL UNIQUE,
  celular VARCHAR(30) NOT NULL,
  observaciones TEXT NOT NULL,
  firma_openssl TEXT NOT NULL,
  fecha_registro DATETIME NOT NULL,
  FOREIGN KEY (id_pais_residencia) REFERENCES paises(id_pais),
  FOREIGN KEY (id_nacionalidad) REFERENCES paises(id_pais)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS inscriptor_area (
  id_inscriptor INT NOT NULL,
  id_area INT NOT NULL,
  PRIMARY KEY (id_inscriptor, id_area),
  FOREIGN KEY (id_inscriptor) REFERENCES inscriptores(id_inscriptor) ON DELETE CASCADE,
  FOREIGN KEY (id_area) REFERENCES areas_interes(id_area)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO paises (nombre) VALUES
('Colombia'),
('México'),
('Argentina'),
('España'),
('Perú'),
('Chile')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);

INSERT INTO areas_interes (nombre) VALUES
('Inteligencia Artificial'),
('Desarrollo Web'),
('Ciberseguridad'),
('Datos'),
('Automatización'),
('IoT')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre);
