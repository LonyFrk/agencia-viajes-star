<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

try {
    /*
     * Consulta avanzada:
     * une HOTEL y RESERVA,
     * agrupa los resultados por hotel,
     * cuenta las reservas
     * y muestra únicamente los hoteles
     * con más de dos reservas.
     */
    $sql = "
        SELECT
            h.id_hotel,
            h.nombre,
            h.ubicacion,
            COUNT(r.id_reserva) AS total_reservas
        FROM HOTEL AS h
        INNER JOIN RESERVA AS r
            ON h.id_hotel = r.id_hotel
        GROUP BY
            h.id_hotel,
            h.nombre,
            h.ubicacion
        HAVING COUNT(r.id_reserva) > 2
        ORDER BY
            total_reservas DESC,
            h.nombre ASC
    ";

    $resultado = $conexion->query($sql);

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error en la consulta avanzada: " .
        $error->getMessage()
    );

    exit(
        "No fue posible consultar las reservas por hotel."
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

    <title>Reservas por hotel</title>

    <link
        rel="stylesheet"
        href="../assets/css/estilos.css"
    >
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>Hoteles con más de dos reservas</h1>

            <p>
                Consulta avanzada entre HOTEL y RESERVA
            </p>
        </div>
    </header>

    <main class="contenedor">

        <section class="seccion-tabla">

            <?php if ($resultado->num_rows > 0): ?>

                <div class="tabla-contenedor">

                    <table>
                        <thead>
                            <tr>
                                <th>ID hotel</th>
                                <th>Hotel</th>
                                <th>Ubicación</th>
                                <th>Total de reservas</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while (
                                $hotel =
                                $resultado->fetch_assoc()
                            ): ?>

                                <tr>
                                    <td>
                                        <?= (int)
                                            $hotel["id_hotel"] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $hotel["nombre"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $hotel["ubicacion"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int)
                                            $hotel[
                                                "total_reservas"
                                            ] ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>

                </div>

            <?php else: ?>

                <p class="sin-registros">
                    No existen hoteles con más de dos reservas.
                </p>

            <?php endif; ?>

            <a
                class="boton-volver"
                href="listar_reservas.php"
            >
                Ver todas las reservas
            </a>

            <a
                class="boton-volver"
                href="formulario_reserva.php"
            >
                Registrar reserva
            </a>

        </section>

    </main>

</body>

</html>

<?php

$resultado->free();
$conexion->close();