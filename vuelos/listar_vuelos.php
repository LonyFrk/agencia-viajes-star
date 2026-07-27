<?php

declare(strict_types=1);

require_once __DIR__ . "/../config/conexion.php";

try {
    $sql = "
        SELECT
            id_vuelo,
            origen,
            destino,
            fecha,
            plazas_disponibles,
            precio
        FROM VUELO
        ORDER BY id_vuelo ASC
    ";

    $resultado = $conexion->query($sql);

} catch (mysqli_sql_exception $error) {
    error_log(
        "Error al consultar vuelos: " .
        $error->getMessage()
    );

    exit("No fue posible consultar los vuelos.");
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

    <title>Vuelos registrados</title>

    <link
        rel="stylesheet"
        href="../assets/css/estilos.css"
    >
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>Vuelos registrados</h1>

            <p>
                Consulta simple de la tabla VUELO
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
                                <th>ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha</th>
                                <th>Plazas</th>
                                <th>Precio</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php while (
                                $vuelo = $resultado->fetch_assoc()
                            ): ?>

                                <tr>
                                    <td>
                                        <?= (int) $vuelo["id_vuelo"] ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $vuelo["origen"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars(
                                            $vuelo["destino"],
                                            ENT_QUOTES,
                                            "UTF-8"
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= date(
                                            "d-m-Y",
                                            strtotime($vuelo["fecha"])
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= (int)
                                            $vuelo[
                                                "plazas_disponibles"
                                            ] ?>
                                    </td>

                                    <td>
                                        $<?= number_format(
                                            (float) $vuelo["precio"],
                                            0,
                                            ",",
                                            "."
                                        ) ?>
                                    </td>
                                </tr>

                            <?php endwhile; ?>

                        </tbody>
                    </table>

                </div>

            <?php else: ?>

                <p class="sin-registros">
                    No existen vuelos registrados.
                </p>

            <?php endif; ?>

            <a
                class="boton-volver"
                href="../index.php"
            >
                Volver a los formularios
            </a>

        </section>

    </main>

</body>

</html>

<?php

$resultado->free();
$conexion->close();