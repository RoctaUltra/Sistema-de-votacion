
CREATE DATABASE IF NOT EXISTS sistema_votacion_cepea;
USE sistema_votacion_cepea;

CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    identificacion VARCHAR(50) UNIQUE NOT NULL,
    codigo_estudiante VARCHAR(50) UNIQUE NOT NULL,
    contrasena_hash VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    activo BOOLEAN DEFAULT TRUE
);

CREATE TABLE IF NOT EXISTS votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    candidato_elegido VARCHAR(100) NOT NULL,
    fecha_voto TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE,
    UNIQUE KEY unique_voto_estudiante (estudiante_id)
);


CREATE TABLE IF NOT EXISTS candidatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave_voto VARCHAR(100) UNIQUE NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    carrera VARCHAR(100) NOT NULL,
    activo BOOLEAN DEFAULT TRUE
);


INSERT IGNORE INTO candidatos (clave_voto, nombre, carrera) VALUES
('raul_pineda_admin', 'Raúl Pineda', 'Administración'),
('maria_palacios_sistemas', 'María Palacios', 'Sistemas'),
('jorge_choque_enfermeria', 'Jorge Choque', 'Enfermería');


CREATE INDEX idx_estudiantes_codigo ON estudiantes(codigo_estudiante);
CREATE INDEX idx_estudiantes_identificacion ON estudiantes(identificacion);
CREATE INDEX idx_votos_estudiante ON votos(estudiante_id);
CREATE INDEX idx_votos_candidato ON votos(candidato_elegido);

-- Usuario para la base de datos (opcional, para mayor seguridad)
-- CREATE USER 'usuario_cepea'@'localhost' IDENTIFIED BY 'contraseña_segura';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON sistema_votacion_cepea.* TO 'usuario_cepea'@'localhost';
-- FLUSH PRIVILEGES;