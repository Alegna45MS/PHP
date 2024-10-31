<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de la Tienda</title>
</head>
<body>
    <h1>Bienvenido a la Tienda de Consolas</h1>
    <?php session_start();

$hash=password_hash("alegna123", PASSWORD_DEFAULT);
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
    if(isset($_POST['nombre'])){
        if(($_POST['nombre']=='alegnams') && password_verify($_POST['contrasena'],$hash)){
            $_SESSION['nombre'] = $_POST['nombre'];
            if(isset($_POST['carrito'])){
                header("Location: carrito.php"); // Redirige al carrito
                exit();
            }
            if(isset($_POST['admin'])){
                $_SESSION['nombre'] = $_POST['nombre'];
                header("Location: admin.php"); // Redirige al admin
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
