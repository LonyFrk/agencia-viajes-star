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

/*
 * Solo se permite acceder mediante el método POST.
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redireccionar(
        "error",
        "La solicitud para registrar el vuelo no es válida."
    );
}

/*
 * Recepción y limpieza de los datos.
 */
$origen = trim($_POST["origen"] ?? "");
$destino = trim($_POST["destino"] ?? "");
$fecha = trim($_POST["fecha"] ?? "");

$plazas = filter_input(
    INPUT_POST,
    "plazas_disponibles",
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1
        ]
    ]
);

$precioRecibido = $_POST["precio"] ?? "";

/*
 * Validación de los campos de texto.
 */
if ($origen === "" || $destino === "") {
    redireccionar(
        "error",
        "Debe ingresar el origen y el destino del vuelo."
    );
}

if (strlen($origen) > 100 || strlen($destino) > 100) {
    redireccionar(
        "error",
        "El origen o el destino supera la longitud permitida."
    );
}

if (strcasecmp($origen, $destino) === 0) {
    redireccionar(
        "error",
        "El origen y el destino deben ser diferentes."
    );
}

/*
 * Validación de la fecha.
 */
$fechaVuelo = DateTimeImmutable::createFromFormat(
    "!Y-m-d",
    $fecha
);

$fechaValida =
    $fechaVuelo !== false &&
    $fechaVuelo->format("Y-m-d") === $fecha;

if (!$fechaValida) {
    redireccionar(
        "error",
        "La fecha ingresada no tiene un formato válido."
    );
}

$fechaActual = new DateTimeImmutable("today");

if ($fechaVuelo < $fechaActual) {
    redireccionar(
        "error",
        "La fecha del vuelo no puede estar en el pasado."
    );
}

/*
 * Validación de plazas y precio.
 */
if ($plazas === false || $plazas === null) {
    redireccionar(
        "error",
        "Las plazas deben ser un número entero mayor que cero."
    );
}

if (
    !is_numeric($precioRecibido) ||
    (float) $precioRecibido <= 0
) {
    redireccionar(
        "error",
        "El precio debe ser un número mayor que cero."
    );
}

$precio = (float) $precioRecibido;

try {
    /*
     * Consulta preparada para insertar el vuelo.
     */
    $consulta = $conexion->prepare(
        "INSERT INTO VUELO (
            origen,
            destino,
            fecha,
            plazas_disponibles,
            precio
        ) VALUES (?, ?, ?, ?, ?)"
    );

    /*
     * s: string
     * i: integer
     * d: double
     */
    $consulta->bind_param(
        "sssid",
        $origen,
        $destino,
        $fecha,
        $plazas,
        $precio
    );

    $consulta->execute();

    $consulta->close();
    $conexion->close();

    redireccionar(
        "exito",
        "El vuelo fue registrado correctamente."
    );

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al registrar el vuelo: " .
        $error->getMessage()
    );

    redireccionar(
        "error",
        "No fue posible registrar el vuelo."
    );
}