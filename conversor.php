<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Euros a Pesetas</title>
</head>
<body>
    <h1>Conversor de Euros a Pesetas</h1>
    <form method="post">
        <label for="euros">Cantidad en euros:</label>
        <input type="number" name="euros" id="euros" required>
        <input type="submit" value="Convertir">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $euros = $_POST['euros'];
        $tasa_conversion = 166.386;
        $pesetas = $euros * $tasa_conversion;
        echo "$euros euros equivalen a:" . number_format($pesetas, 2) . " pesetas.</h2>";
    }
    ?>
</body>
</html>
