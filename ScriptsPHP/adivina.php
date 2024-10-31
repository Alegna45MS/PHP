<?php
session_start(); // Iniciar la sesión

// Generar el número aleatorio solo si no existe ya en la sesión
if (!isset($_SESSION['numAleatorio'])) { //if es null
    $_SESSION['numAleatorio'] = rand(0, 10);
}

$numAleatorio = $_SESSION['numAleatorio'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adivina</title>
</head>
<body>
    <form action="" method="get">
        <div>
            <label for="numeroUsuario">Introduce un numero (0-10)</label>
            <input type="text" name="numeroUsuario" id="numeroUsuario">
            <button type="submit">Comprobar</button>
            <a href="adivinaV2.php"><button>Volver a jugar</button></a>
        </div>
    </form>
</body>
</html>

<?php
if (isset($_REQUEST["numeroUsuario"])) { // if no es null
    $numeroUsuario = $_REQUEST["numeroUsuario"];

    if ($numeroUsuario == $numAleatorio) {
        echo "¡Has acertado!";
        $_SESSION['numAleatorio']=null;//para que genere ota sesion
    } elseif ($numeroUsuario > $numAleatorio) {
        echo "El número introducido es mayor";
    } else {
        echo "El número introducido es menor";
    }
}
?>
