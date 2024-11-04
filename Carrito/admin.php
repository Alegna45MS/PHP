<?php
session_start();
if (!isset($_SESSION['nombre'])) {
    header("Location: inicioSesion.php"); // Redirige al formulario si no hay nombre en sesión
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reponer Stock</title>
</head>
<body>
    <h1>Reponer Stock de Consolas</h1>
    <h2>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! Es hora de reponer</h2>
    <form method="POST">
    <?php 
    define('RUTA_FICHERO', "stock.data");

    // Cargar stock desde el archivo o crear uno por defecto
    if (file_exists(RUTA_FICHERO)) {
        $stock = unserialize(file_get_contents(RUTA_FICHERO));
    } else {
        $stock = ["Playstation5" => 50, "Xbox360" => 30, "Switch" => 60, "Nintendo3DS" => 10];
        file_put_contents(RUTA_FICHERO, serialize($stock));
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['reponer'])){
            foreach($_POST['cantidad'] as $producto => $cantidad){
                if ($cantidad >= 0) {
                    $stock[$producto] += $cantidad; // Aumentar el stock
                }
            }
            // Guardar el stock actualizado
            file_put_contents(RUTA_FICHERO, serialize($stock));
            echo "<p>Stock actualizado correctamente.</p>";
        }
    }

    // Mostrar productos
    echo "<ul>";
    foreach ($stock as $producto => $cantidad) {
        echo "<li>";
        echo "<label for=\"$producto\">$producto - Stock actual: $cantidad</label>";
        echo "<input type=\"number\" name=\"cantidad[$producto]\" min=\"0\" placeholder=\"Cantidad a reponer\">";
        echo "</li>";
    }
    echo "</ul>";
    ?>
    <input type="submit" name="reponer" value="Reponer Stock">
    <a href="logout.php">Cerrar sesión</a>
    </form>
</body>
</html>
