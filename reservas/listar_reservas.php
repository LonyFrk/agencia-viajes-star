<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

try {
    /*
     * Consulta simple de la tabla RESERVA.
     */
    $sql = "
        SELECT
            id_reserva,
            id_cliente,
            fecha_reserva,
            id_vuelo,
            id_hotel
        FROM RESERVA
        ORDER BY id_reserva ASC
    ";

    $resultado = $conexion->query($sql);

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al consultar reservas: " .
        $error->getMessage()
    );

    exit(
        "No fue posible consultar las reservas."
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

    <title>Reservas registradas</title>

    <link
        rel="stylesheet"
        href="../assets/css/estilos.css"
    >
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>Reservas registradas</h1>

            <p>
                Consulta simple de la tabla RESERVA
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
                                <th>ID reserva</th>
                                <th>ID cliente</th>
                                <th>Fecha</th>
                                <th>ID vuelo</th>
                                <th>ID hotel</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while (
                                $reserva =
                                $resultado->fetch_assoc()
                            ): ?>

                                <tr>
                                    <td>
                                        <?= (int)
                                            $reserva["id_reserva"] ?>
                                    </td>

                                    <td>
                                        <?= (int)
                                            $reserva["id_cliente"] ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            "d-m-Y",
                                            strtotime(
                                                $reserva[
                                                    "fecha_reserva"
                                                ]
                                            )
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int)
                                            $reserva["id_vuelo"] ?>
                                    </td>

                                    <td>
                                        <?= (int)
                                            $reserva["id_hotel"] ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>

                </div>

            <?php else: ?>

                <p class="sin-registros">
                    No existen reservas registradas.
                </p>

            <?php endif; ?>

            <a
                class="boton-volver"
                href="formulario_reserva.php"
            >
                Registrar otra reserva
            </a>

            <a
                class="boton-volver"
                href="reservas_por_hotel.php"
            >
                Consultar reservas por hotel
            </a>

        </section>

    </main>

</body>

</html>

<?php

$resultado->free();
$conexion->close();