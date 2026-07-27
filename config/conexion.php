<?php

declare(strict_types=1);

/*
 * Convierte los errores de MySQLi en excepciones
 * para poder controlarlos mediante try y catch.
 */
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

/*
 * Parámetros de conexión con MySQL.
 */
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$baseDatos = "AGENCIA";
$puerto = 3306;

try {
    /*
     * Se crea una nueva conexión utilizando MySQLi.
     */
    $conexion = new mysqli(
        $servidor,
        $usuario,
        $contrasena,
        $baseDatos,
        $puerto
    );

    /*
     * Permite trabajar correctamente con tildes,
     * la letra ñ y otros caracteres.
     */
    $conexion->set_charset("utf8mb4");

} catch (mysqli_sql_exception $error) {
    /*
     * El error técnico se guarda internamente.
     */
    error_log(
        "Error de conexión con MySQL: " .
        $error->getMessage()
    );

    /*
     * Se envía un código de error al navegador.
     */
    http_response_code(500);

    /*
     * Se muestra un mensaje comprensible sin revelar
     * los datos técnicos de la conexión.
     */
    exit(
        "No fue posible establecer la conexión " .
        "con la base de datos."
    );
}