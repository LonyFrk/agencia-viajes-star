CREATE DATABASE IF NOT EXISTS AGENCIA
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE AGENCIA;

CREATE TABLE IF NOT EXISTS VUELO (
    id_vuelo INT UNSIGNED NOT NULL AUTO_INCREMENT,
    origen VARCHAR(100) NOT NULL,
    destino VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    plazas_disponibles INT UNSIGNED NOT NULL,
    precio DECIMAL(10, 2) UNSIGNED NOT NULL,

    PRIMARY KEY (id_vuelo)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS HOTEL (
    id_hotel INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    habitaciones_disponibles INT UNSIGNED NOT NULL,
    tarifa_noche DECIMAL(10, 2) UNSIGNED NOT NULL,

    PRIMARY KEY (id_hotel)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS RESERVA (
    id_reserva INT UNSIGNED NOT NULL AUTO_INCREMENT,
    id_cliente INT UNSIGNED NOT NULL,
    fecha_reserva DATE NOT NULL,
    id_vuelo INT UNSIGNED NOT NULL,
    id_hotel INT UNSIGNED NOT NULL,

    PRIMARY KEY (id_reserva),

    CONSTRAINT fk_reserva_vuelo
        FOREIGN KEY (id_vuelo)
        REFERENCES VUELO(id_vuelo)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,

    CONSTRAINT fk_reserva_hotel
        FOREIGN KEY (id_hotel)
        REFERENCES HOTEL(id_hotel)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE = InnoDB;