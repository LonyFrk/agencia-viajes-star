<?php

declare(strict_types=1);

$tipoMensaje = $_GET["tipo"] ?? "";
$mensaje = $_GET["mensaje"] ?? "";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Administración de servicios turísticos</title>

    <link
        rel="stylesheet"
        href="assets/css/estilos.css"
    >

    <script
        src="assets/js/validaciones.js"
        defer
    ></script>
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>Agencia de viajes</h1>

            <p>
                Registro y consulta de vuelos y hoteles
                disponibles.
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

        <section class="formularios">

            <!-- Formulario para registrar vuelos -->
            <article class="tarjeta">

                <h2>Registrar vuelo</h2>

                <form
                    id="formularioVuelo"
                    action="vuelos/registrar_vuelo.php"
                    method="post"
                    autocomplete="off"
                >

                    <div class="campo">
                        <label for="origen">
                            Ciudad de origen
                        </label>

                        <input
                            type="text"
                            id="origen"
                            name="origen"
                            maxlength="100"
                            placeholder="Ejemplo: Santiago"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="destino">
                            Ciudad de destino
                        </label>

                        <input
                            type="text"
                            id="destino"
                            name="destino"
                            maxlength="100"
                            placeholder="Ejemplo: Puerto Montt"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="fecha">
                            Fecha del vuelo
                        </label>

                        <input
                            type="date"
                            id="fecha"
                            name="fecha"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="plazas_disponibles">
                            Plazas disponibles
                        </label>

                        <input
                            type="number"
                            id="plazas_disponibles"
                            name="plazas_disponibles"
                            min="1"
                            step="1"
                            placeholder="Ejemplo: 40"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="precio">
                            Precio del vuelo
                        </label>

                        <input
                            type="number"
                            id="precio"
                            name="precio"
                            min="1"
                            step="0.01"
                            placeholder="Ejemplo: 89990"
                            required
                        >
                    </div>

                    <button type="submit">
                        Registrar vuelo
                    </button>

                </form>

                <a
                    class="enlace-consulta"
                    href="vuelos/listar_vuelos.php"
                >
                    Consultar vuelos registrados
                </a>

            </article>

            <!-- Formulario para registrar hoteles -->
            <article class="tarjeta">

                <h2>Registrar hotel</h2>

                <form
                    id="formularioHotel"
                    action="hoteles/registrar_hotel.php"
                    method="post"
                    autocomplete="off"
                >

                    <div class="campo">
                        <label for="nombre_hotel">
                            Nombre del hotel
                        </label>

                        <input
                            type="text"
                            id="nombre_hotel"
                            name="nombre"
                            maxlength="100"
                            placeholder="Ejemplo: Hotel Austral"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="ubicacion">
                            Ubicación
                        </label>

                        <input
                            type="text"
                            id="ubicacion"
                            name="ubicacion"
                            maxlength="150"
                            placeholder="Ejemplo: Puerto Montt"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="habitaciones_disponibles">
                            Habitaciones disponibles
                        </label>

                        <input
                            type="number"
                            id="habitaciones_disponibles"
                            name="habitaciones_disponibles"
                            min="1"
                            step="1"
                            placeholder="Ejemplo: 20"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="tarifa_noche">
                            Tarifa por noche
                        </label>

                        <input
                            type="number"
                            id="tarifa_noche"
                            name="tarifa_noche"
                            min="1"
                            step="0.01"
                            placeholder="Ejemplo: 74990"
                            required
                        >
                    </div>

                    <button type="submit">
                        Registrar hotel
                    </button>

                </form>

                <a
                    class="enlace-consulta"
                    href="hoteles/listar_hoteles.php"
                >
                    Consultar hoteles registrados
                </a>

            </article>

        </section>

    </main>

    <footer class="pie-pagina">
        <p>
            Sistema de administración de servicios turísticos
        </p>
    </footer>

</body>

</html>