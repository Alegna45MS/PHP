<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Euros a Otras Monedas</title>
</head>
<body>
    <h1>Conversor de Euros a Otras Monedas</h1>
    <form method="post" action="">
        <label for="euros">Introduce la cantidad en euros:</label>
        <input type="number" name="euros" id="euros" required>

        <label for="moneda">Selecciona la moneda a la que deseas convertir:</label>
        <select name="moneda" id="moneda" required>
            <option value="dolares">Dólares USA</option>
            <option value="libras">Libras Esterlinas</option>
            <option value="yenes">Yenes Japoneses</option>
            <option value="francos">Francos Suizos</option>
        </select>
        <input type="submit" value="Convertir">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $euros = $_POST['euros'];
        $moneda = $_POST['moneda'];

        // Definir las tasas de conversión
        $tasas_conversion = [
            "dolares" => 1.325,
            "libras" => 0.927,
            "yenes" => 118.232,
            "francos" => 1.515
        ];

        // Realizar la conversión
        if (array_key_exists($moneda, $tasas_conversion)) {
            $conversion = $euros * $tasas_conversion[$moneda];
            // Mostrar el resultado
            echo "<h2>$euros euros son equivalentes a " . number_format($conversion, 2) . " $moneda.</h2>";
        } else {
            echo "<h2>Moneda no válida.</h2>";
        }
    }
    ?>
</body>
</html>