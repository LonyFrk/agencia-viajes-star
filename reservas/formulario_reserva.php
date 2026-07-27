<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

$tipoMensaje = $_GET["tipo"] ?? "";
$mensaje = $_GET["mensaje"] ?? "";

try {
    /*
     * Recupera los vuelos previamente registrados.
     */
    $consultaVuelos = "
        SELECT
            id_vuelo,
            origen,
            destino,
            fecha,
            plazas_disponibles
        FROM VUELO
        ORDER BY fecha ASC
    ";

    $resultadoVuelos = $conexion->query($consultaVuelos);
    $vuelos = $resultadoVuelos->fetch_all(MYSQLI_ASSOC);

    /*
     * Recupera los hoteles previamente registrados.
     */
    $consultaHoteles = "
        SELECT
            id_hotel,
            nombre,
            ubicacion,
            habitaciones_disponibles
        FROM HOTEL
        ORDER BY nombre ASC
    ";

    $resultadoHoteles = $conexion->query($consultaHoteles);
    $hoteles = $resultadoHoteles->fetch_all(MYSQLI_ASSOC);

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al cargar vuelos y hoteles: " .
        $error->getMessage()
    );

    exit(
        "No fue posible cargar los servicios turísticos."
    );
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrar reserva</title>

    <link
        rel="stylesheet"
        href="../assets/css/estilos.css"
    >
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>Registrar reserva</h1>

            <p>
                Selección de vuelos y hoteles disponibles
            </p>
        </div>
    </header>

    <main class="contenedor">

        <?php if ($mensaje !== ""): ?>

            <div
                class="mensaje
                <?= $tipoMensaje === "exito"
                    ? "mensaje-exito"
                    : "mensaje-error" ?>"
            >
                <?= htmlspecialchars(
                    $mensaje,
                    ENT_QUOTES,
                    "UTF-8"
                ) ?>
            </div>

        <?php endif; ?>

        <section class="seccion-tabla">

            <form
                action="registrar_reserva.php"
                method="post"
            >

                <div class="campo">
                    <label for="id_cliente">
                        Identificador del cliente
                    </label>

                    <input
                        type="number"
                        id="id_cliente"
                        name="id_cliente"
                        min="1"
                        step="1"
                        placeholder="Ejemplo: 1001"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="fecha_reserva">
                        Fecha de la reserva
                    </label>

                    <input
                        type="date"
                        id="fecha_reserva"
                        name="fecha_reserva"
                        value="<?= date("Y-m-d") ?>"
                        max="<?= date("Y-m-d") ?>"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="id_vuelo">
                        Vuelo seleccionado
                    </label>

                    <select
                        id="id_vuelo"
                        name="id_vuelo"
                        required
                    >
                        <option value="">
                            Seleccione un vuelo
                        </option>

                        <?php foreach ($vuelos as $vuelo): ?>

                            <option
                                value="<?= (int) $vuelo["id_vuelo"] ?>"
                            >
                                <?= htmlspecialchars(
                                    $vuelo["origen"] .
                                    " → " .
                                    $vuelo["destino"] .
                                    " | " .
                                    $vuelo["fecha"] .
                                    " | Plazas: " .
                                    $vuelo["plazas_disponibles"],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="id_hotel">
                        Hotel seleccionado
                    </label>

                    <select
                        id="id_hotel"
                        name="id_hotel"
                        required
                    >
                        <option value="">
                            Seleccione un hotel
                        </option>

                        <?php foreach ($hoteles as $hotel): ?>

                            <option
                                value="<?= (int) $hotel["id_hotel"] ?>"
                            >
                                <?= htmlspecialchars(
                                    $hotel["nombre"] .
                                    " | " .
                                    $hotel["ubicacion"] .
                                    " | Habitaciones: " .
                                    $hotel[
                                        "habitaciones_disponibles"
                                    ],
                                    ENT_QUOTES,
                                    "UTF-8"
                                ) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit">
                    Registrar reserva
                </button>

            </form>

            <a
                class="boton-volver"
                href="listar_reservas.php"
            >
                Consultar reservas registradas
            </a>

            <a
                class="boton-volver"
                href="reservas_por_hotel.php"
            >
                Consultar reservas por hotel
            </a>

            <a
                class="boton-volver"
                href="../index.php"
            >
                Volver a la página principal
            </a>

        </section>

    </main>

</body>

</html>

<?php

$resultadoVuelos->free();
$resultadoHoteles->free();
$conexion->close();