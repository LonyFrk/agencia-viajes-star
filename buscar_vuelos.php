<?php
$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $origen = trim($_POST["origen"] ?? "");
    $destino = trim($_POST["destino"] ?? "");
    $fecha = trim($_POST["fecha"] ?? "");

    if ($origen === "" || $destino === "" || $fecha === "") {
        $mensaje = "Debe completar todos los campos.";
    } else {
        $mensaje = "Búsqueda realizada desde $origen hacia $destino para el día $fecha.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de vuelos</title>
</head>

<body>
    <h1>Buscar vuelos</h1>

    <form method="POST">
        <label for="origen">Origen:</label>
        <input type="text" id="origen" name="origen" required>

        <br><br>

        <label for="destino">Destino:</label>
        <input type="text" id="destino" name="destino" required>

        <br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" id="fecha" name="fecha" required>

        <br><br>

        <button type="submit">Buscar vuelos</button>
    </form>

    <?php if ($mensaje !== ""): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
</body>
</html>
