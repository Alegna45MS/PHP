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
            'nombre' => 'carlos',
            'contrasena' => password_hash("1234", PASSWORD_DEFAULT),
            'admin' => false // Este usuario no tiene acceso administrativo
        ],
        [
            'nombre' => 'yoli',
            'contrasena' => password_hash("5678", PASSWORD_DEFAULT),
            'admin' => true // Este usuario tiene acceso administrativo
        ]
    ];
    $usuarioCorrecto=false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        foreach ($usuarios as $usuario) {
            if ($usuario['nombre'] === $nombre && password_verify($contrasena, $usuario['contrasena'])) {
                $_SESSION['nombre'] = $nombre;
                $_SESSION['admin'] = $usuario['admin']; // Guardamos si el usuario tiene acceso administrativo
                $usuarioCorrecto=true;
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
            }
        }
        if($usuarioCorrecto==false){
            echo "<p style='color:red'>Usuario y/o contraseña no correcto</p>";
        }
        
    }
    ?>

    <form method="POST">
        <label>Por favor, ingresa tu nombre y contraseña para comenzar:</label>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <br>
        <input type="submit" name="carrito" value="Ir al carrito">
        <input type="submit" name="admin" value="Administracion">
    </form>
</body>
</html>