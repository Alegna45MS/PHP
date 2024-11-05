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
    define('RUTA_FICHERO', "usuarios.data");
    if(isset($_POST['registro'])){
        header("Location: registrar.php"); // Redirige al carrito
        exit();
    }else{
        // Cargar el archivo de usuarios
    if (file_exists(RUTA_FICHERO)) {
        $usuarios = unserialize(file_get_contents(RUTA_FICHERO));
    } else {
        $usuarios = [];
    }
    $usuarioCorrecto=false;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $contrasena = $_POST['contrasena'];

        // Comprobar que el usuario existe y la contraseña es correcta
        if (isset($usuarios[$nombre]) && password_verify($contrasena, $usuarios[$nombre])) {
            $_SESSION['nombre'] = $nombre;
            $usuarioCorrecto=true;
            if (isset($_POST['carrito'])) {
                header("Location: carrito.php"); // Redirige al carrito
                exit();
            }
            if (isset($_POST['admin'])) {
                header("Location: admin.php"); // Redirige al administracion
                exit();
            }
        }else{
            echo "<p style='color:red'>Usuario y/o contraseña no correcto</p>";
        }
    }
    }
    
    ?>
    <form method="POST">
        <label>Por favor, ingresa tu nombre y contraseña para comenzar:</label>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena">
        <br>
        <input type="submit" name="carrito" value="Ir al carrito">
        <input type="submit" name="admin" value="Administracion">
        <br>
        <br>
        <label for="registro">Si no tienes usuario,registrate aqui</label>
        <input type="submit" name="registro" value="Registrarse">
    </form>
</body>
</html>
