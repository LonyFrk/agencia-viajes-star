<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

/**
 * Redirige al formulario mostrando un mensaje.
 */
function redireccionar(
    string $tipo,
    string $mensaje
): void {
    $parametros = http_build_query([
        "tipo" => $tipo,
        "mensaje" => $mensaje
    ]);

    header(
        "Location: formulario_reserva.php?" .
        $parametros
    );

    exit;
}

/*
 * El archivo solamente acepta solicitudes POST.
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    redireccionar(
        "error",
        "La solicitud para registrar la reserva no es válida."
    );
}

/*
 * Recepción y validación de valores enteros.
 */
$idCliente = filter_input(
    INPUT_POST,
    "id_cliente",
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1
        ]
    ]
);

$idVuelo = filter_input(
    INPUT_POST,
    "id_vuelo",
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1
        ]
    ]
);

$idHotel = filter_input(
    INPUT_POST,
    "id_hotel",
    FILTER_VALIDATE_INT,
    [
        "options" => [
            "min_range" => 1
        ]
    ]
);

$fechaReserva = trim(
    $_POST["fecha_reserva"] ?? ""
);

if (
    $idCliente === false ||
    $idCliente === null
) {
    redireccionar(
        "error",
        "El identificador del cliente no es válido."
    );
}

if (
    $idVuelo === false ||
    $idVuelo === null
) {
    redireccionar(
        "error",
        "Debe seleccionar un vuelo válido."
    );
}

if (
    $idHotel === false ||
    $idHotel === null
) {
    redireccionar(
        "error",
        "Debe seleccionar un hotel válido."
    );
}

/*
 * Validación de la fecha.
 */
$fecha = DateTimeImmutable::createFromFormat(
    "!Y-m-d",
    $fechaReserva
);

$fechaEsValida =
    $fecha !== false &&
    $fecha->format("Y-m-d") === $fechaReserva;

if (!$fechaEsValida) {
    redireccionar(
        "error",
        "La fecha de reserva no es válida."
    );
}

try {
    /*
     * Comprueba que el vuelo seleccionado exista.
     */
    $verificarVuelo = $conexion->prepare(
        "SELECT id_vuelo
         FROM VUELO
         WHERE id_vuelo = ?"
    );

    $verificarVuelo->bind_param(
        "i",
        $idVuelo
    );

    $verificarVuelo->execute();
    $verificarVuelo->store_result();

    if ($verificarVuelo->num_rows === 0) {
        redireccionar(
            "error",
            "El vuelo seleccionado no existe."
        );
    }

    $verificarVuelo->close();

    /*
     * Comprueba que el hotel seleccionado exista.
     */
    $verificarHotel = $conexion->prepare(
        "SELECT id_hotel
         FROM HOTEL
         WHERE id_hotel = ?"
    );

    $verificarHotel->bind_param(
        "i",
        $idHotel
    );

    $verificarHotel->execute();
    $verificarHotel->store_result();

    if ($verificarHotel->num_rows === 0) {
        redireccionar(
            "error",
            "El hotel seleccionado no existe."
        );
    }

    $verificarHotel->close();

    /*
     * Inserta la reserva mediante una consulta preparada.
     */
    $consulta = $conexion->prepare(
        "INSERT INTO RESERVA (
            id_cliente,
            fecha_reserva,
            id_vuelo,
            id_hotel
        ) VALUES (?, ?, ?, ?)"
    );

    $consulta->bind_param(
        "isii",
        $idCliente,
        $fechaReserva,
        $idVuelo,
        $idHotel
    );

    $consulta->execute();

    $consulta->close();
    $conexion->close();

    redireccionar(
        "exito",
        "La reserva fue registrada correctamente."
    );

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al registrar la reserva: " .
        $error->getMessage()
    );

    redireccionar(
        "error",
        "No fue posible registrar la reserva."
    );
}