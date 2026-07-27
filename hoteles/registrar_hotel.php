<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

/**
 * Regresa a la página principal mostrando un mensaje.
 */
function redireccionar(
    string $tipo,
    string $mensaje
): void {
    $parametros = http_build_query([
        "tipo" => $tipo,
        "mensaje" => $mensaje
    ]);

    header("Location: ../index.php?" . $parametros);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redireccionar(
        "error",
        "La solicitud para registrar el hotel no es válida."
    );
}

/*
 * Recepción y limpieza de los datos.
 */
$nombre = trim($_POST["nombre"] ?? "");
$ubicacion = trim($_POST["ubicacion"] ?? "");

$habitaciones = filter_input(
    INPUT_POST,
    "habitaciones_disponibles",
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1
        ]
    ]
);

$tarifaRecibida = $_POST["tarifa_noche"] ?? "";

/*
 * Validaciones del lado del servidor.
 */
if ($nombre === "" || $ubicacion === "") {
    redireccionar(
        "error",
        "Debe ingresar el nombre y la ubicación del hotel."
    );
}

if (strlen($nombre) > 100) {
    redireccionar(
        "error",
        "El nombre del hotel supera la longitud permitida."
    );
}

if (strlen($ubicacion) > 150) {
    redireccionar(
        "error",
        "La ubicación supera la longitud permitida."
    );
}

if (
    $habitaciones === false ||
    $habitaciones === null
) {
    redireccionar(
        "error",
        "Las habitaciones deben ser un número entero " .
        "mayor que cero."
    );
}

if (
    !is_numeric($tarifaRecibida) ||
    (float) $tarifaRecibida <= 0
) {
    redireccionar(
        "error",
        "La tarifa por noche debe ser mayor que cero."
    );
}

$tarifa = (float) $tarifaRecibida;

try {
    /*
     * Consulta preparada para insertar el hotel.
     */
    $consulta = $conexion->prepare(
        "INSERT INTO HOTEL (
            nombre,
            ubicacion,
            habitaciones_disponibles,
            tarifa_noche
        ) VALUES (?, ?, ?, ?)"
    );

    $consulta->bind_param(
        "ssid",
        $nombre,
        $ubicacion,
        $habitaciones,
        $tarifa
    );

    $consulta->execute();

    $consulta->close();
    $conexion->close();

    redireccionar(
        "exito",
        "El hotel fue registrado correctamente."
    );

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al registrar el hotel: " .
        $error->getMessage()
    );

    redireccionar(
        "error",
        "No fue posible registrar el hotel."
    );
}