<?php

declare(strict_types=1);

/*
 * Se incorpora el archivo que establece
 * la conexión con MySQL.
 */
require_once __DIR__ . "/config/conexion.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Prueba de conexión</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #eef3f7;
        }

        .contenedor {
            width: 90%;
            max-width: 550px;
            padding: 35px;
            text-align: center;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.15);
        }

        h1 {
            margin-top: 0;
            color: #174b70;
        }

        p {
            color: #333333;
            line-height: 1.6;
        }

        .estado {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 22px;
            color: #ffffff;
            background-color: #198754;
            border-radius: 6px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <main class="contenedor">
        <h1>Agencia de viajes</h1>

        <p>
            La aplicación PHP se comunicó correctamente
            con la base de datos AGENCIA.
        </p>

        <span class="estado">
            Conexión exitosa
        </span>
    </main>

</body>

</html>

<?php

/*
 * La conexión se cierra después de generar la página.
 */
$conexion->close();