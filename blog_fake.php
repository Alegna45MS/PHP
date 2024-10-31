<?php

$mensajes="";

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nuevo_mensaje = $_POST['mensaje'];
    // Añadir el nuevo mensaje al área de texto acumulada
    if (!empty($nuevo_mensaje)) {
        $mensajes =$nuevo_mensaje . "\n";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog fake</title>
</head>
<body>
    <h2>Blog Fake</h2>

    <form method="post">
        <label for="mensaje">Escribe lo que quieras añadir:</label><br>
        <input type="text" id="mensaje" name="mensaje" required><br><br>
        <input type="submit" value="Enviar">
    </form>

    <h3>Textarea</h3>
    
    <textarea readonly rows="10" cols="50"><?php echo $mensajes ?></textarea>
</body>
</html>
