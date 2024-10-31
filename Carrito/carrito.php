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
    <title>Carrito de la compra</title>
</head>
<body>
    <h1>Tienda de consolas</h1>
    <h2>¡Hola, <?php echo htmlspecialchars($_SESSION['nombre']); ?>! Bienvenido a tu carrito:</h2>
    <h2>Carrito:</h2>
    <form method="POST">
    <?php 
    $pagoTotal=0;
    $precios = ["Playstation5" => 700, "Xbox360" => 200, "Switch" => 400, "Nintendo3DS" => 150];
    define('RUTA_FICHERO', "stock.data");

    // Cargar stock desde el archivo o crear uno por defecto
    if (file_exists(RUTA_FICHERO)) {
        $stock = unserialize(file_get_contents(RUTA_FICHERO));
    } else {
        $stock = ["Playstation5" => 50, "Xbox360" => 30, "Switch" => 60, "Nintendo3DS" => 10];
        file_put_contents(RUTA_FICHERO, serialize($stock));
    }
    $cantidades = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(isset($_POST['actualizar'])){
            foreach($_POST['cantidad'] as $producto => $cantidad){
                if ($cantidad >= 0 && $cantidad <= $stock[$producto]) {
                    $pagoTotal=$pagoTotal+($cantidad * $precios[$producto]);
                    $cantidades[$producto] = $cantidad;
                }else{
                    echo "<p style=color:red>No hay suficiente stock de $producto</p>";
                    $cantidades[$producto] = $stock[$producto];
                }
            }
        }
        $exito="true";
        if(isset($_POST['finalizar'])){
            foreach ($_POST['cantidad'] as $producto => $cantidad) {
                // Restar del stock solo si hay suficiente stock
                if ($cantidad >= 0 && $cantidad <= $stock[$producto]) {
                    $stock[$producto] -= $cantidad;
                }else{
                    echo "<p style=color:red>No hay suficiente stock de $producto</p>";
                    $exito="false";
                }
            }
            if($exito=="true"){
                echo "Compra realizada con exito";
                // Guardar el stock actualizado
                file_put_contents(RUTA_FICHERO, serialize($stock));
                
            }
            
            
        }

    }
    // Mostrar productos
    echo "<ul>";
    foreach ($precios as $producto => $precio) {
        if (isset($cantidades[$producto])) {
            $valorCantidad = $cantidades[$producto];
        } else {
            $valorCantidad = 0;
        }
        echo "<li>";
        echo "<label for=\"$producto\">$producto - Precio: $precio € - Stock: {$stock[$producto]}</label>";
        echo "<input type=\"number\" name=\"cantidad[$producto]\" value=\"$valorCantidad\">";
        echo "</li>";
    }
    echo "</ul>";
    echo "<label for=total>Pago total:$pagoTotal</label><br><br>";
    ?>
    <input type="submit" name="actualizar" value="Actualizar compra">
    <input type="submit" name="finalizar" value="Finalizar compra">
    <a href="logout.php">Cerrar sesión</a>
    </form>
</body>
</html>
