<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
</head>
<body>
    <form method="POST">
        <h1>Bienvenido a la Tienda de Consolas</h1>
        <?php
        define('RUTA_FICHERO', "usuarios.data");

        if (file_exists(RUTA_FICHERO)) {
        $usuarios = unserialize(file_get_contents(RUTA_FICHERO));
        } else {
        $usuarios = [];
        }

        // Registro de nuevos usuarios
        if (isset($_POST['registro'])) {
            $nuevoNombre = $_POST['nombre'];
            $nuevaContrasena = $_POST['contrasena'];
            // Agregar el nuevo usuario y guardar
            $usuarios[$nuevoNombre] = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
            file_put_contents(RUTA_FICHERO, serialize($usuarios));
            echo "<p>Usuario registrado exitosamente. Ahora puedes iniciar sesión.</p>";
        }
        ?>

        <label>Por favor, ingresa el nombre y contraseña que quiera</label>
        <br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena">
        <br>
        <input type="submit" name="registro" value="Registrarse">
        <a href="inicioSesion3.php">Volver a iniciar sesion</a>
    </form>
</body>
</html>