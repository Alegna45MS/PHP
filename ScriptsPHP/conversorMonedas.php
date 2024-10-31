<?php
// Tasas de conversión fijas
$euros_a_pesetas = 166.386;
$euros_a_dolares = 1.09;
$euros_a_libras = 0.87;

// Inicializar resultados (es una cadena donde se concatenan todas las conversiones)
$resultados = "";

// Comprobar si se ha introducido una cantidad en euros y una opción de moneda
if (isset($_GET['euros']) && isset($_GET['monedas'])) {
    $euros = $_GET['euros'];
    $moneda = $_GET['monedas'];

    // Realizar la conversión dependiendo de la moneda seleccionada
    switch ($moneda) {
        case 'ptas':
            $conversion = $euros * $euros_a_pesetas;
            $resultado_moneda = "Pesetas";
            break;
        case 'dol':
            $conversion = $euros * $euros_a_dolares;
            $resultado_moneda = "Dólares";
            break;
        case 'lib':
            $conversion = $euros * $euros_a_libras;
            $resultado_moneda = "Libras";
            break;
        default:
            $conversion = 0;
            $resultado_moneda = "";
            break;
    }

    // Formatear resultados
    $resultados = "<br>Resultado:<br>
        " . number_format($conversion, 2) . " " . $resultado_moneda . "<br>";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Monedas</title>
</head>

<body>
    <h1>Conversor de Euros</h1>
    <form method="get">
        <label for="euros">Cantidad en Euros:</label>
        <input type="number" name="euros" step="0.01" required>

        <label for="monedas">Selecciona la moneda:</label>
        <select name="monedas" id="monedas" required>
            <option value="ptas">Pesetas</option>
            <option value="dol">Dólares</option>
            <option value="lib">Libras</option>
        </select>

        <button type="submit">Convertir</button>
    </form>

    <?php
    // Mostrar resultados
    if ($resultados) {
        echo $resultados;
    }
    ?>
</body>

</html>
