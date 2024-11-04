<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de la Tienda</title>
</head>
<body>
    <h1>Bienvenido a la Tienda de Consolas</h1>
    <?php 
    session_start();

    // Definición de usuarios y contraseñas
    $usuarios = [
        [
            'nombre' => 'alegnams',
            'contrasena' => password_hash("alegna123", PASSWORD_DEFAULT),
            'admin' => true // Este usuario tiene acceso administrativo
        ],
        [
            'nombre' => 'user1',
            'contrasena' => password_hash("password1", PASSWORD_DEFAULT),
            'admin' => false // Este usuario no tiene acceso administrativo
        ],
        [
            'nombre' => 'user2',
            'contrasena' => password_hash("password2", PASSWORD_DEFAULT),
            'admin' => true // Este usuario tiene acceso administrativo
        ]
    ];

    if (isset($_SESSION['nombre'])) { // Si el usuario ya está autenticado, redirige a la página correcta
        if (isset($_POST['carrito'])) {
            header("Location: carrito.php");
            exit();
        }
        if (isset($_POST['admin'])) {
            header("Location: admin.php");
            exit();
        }
        echo "Autenticación correcta";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        foreach ($usuarios as $usuario) {
            if ($usuario['nombre'] === $nombre && password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['nombre'] = $nombre;
                $_SESSION['admin'] = $usuario['admin']; // Guardamos si el usuario tiene acceso administrativo

                if (isset($_POST['carrito'])) {
                    header("Location: carrito.php"); // Redirige al carrito
                    exit();
                }
                if (isset($_POST['admin'])) {
                    if ($_SESSION['admin']) { // Verificamos si el usuario tiene acceso administrativo
                        header("Location: admin.php"); // Redirige al admin
                        exit();
                    } else {
                        echo "<p style='color:red'>No tienes permiso para acceder a la administración.</p>";
                    }
                }
                echo "<p>Autenticación correcta</p>";
                exit();
            }
        }
        echo "<p style='color:red'>Usuario y/o contraseña no correcto</p>";
    }
    ?>
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
