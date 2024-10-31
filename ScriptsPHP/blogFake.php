<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Fake</title>
    <style>
        /* Estilo para los mensajes */
        #mensajes {
            border: 1px solid;
            width: 400px;
            height: 450px;
            padding: 1em;

        }
    </style>
</head>
<body>
    <form action="" method="get">
        <label for="mensaje">Nuevo mensaje:</label>
        <input type="text" name="mensaje" id="mensaje">
        <button type="submit">Enviar</button>
        
        <!-- Enviamos los mensajes anteriores como un campo oculto -->
        <input type="hidden" name="mensajes" value="<?php echo isset($_GET['mensajes']) ? htmlspecialchars($_GET['mensajes']) : ''; ?>">
    </form>

    <h3>Mensajes:</h3>
    <div id="mensajes">
        <?php
            // Si hay mensajes anteriores, los mostramos como párrafos
            if (isset($_GET['mensajes'])) {
                $mensajes = explode("\n", htmlspecialchars($_GET['mensajes']));
                foreach ($mensajes as $mensaje) {
                    echo "<p>" . $mensaje . "</p>";
                }
            }
        ?>
    </div>

    <?php
    // Encadenamos los mensajes con los anteriores
    if (isset($_GET['mensaje'])) {
        $nuevoMensaje = $_GET['mensaje'];
        $mensajesAnteriores = isset($_GET['mensajes']) ? $_GET['mensajes'] . "\n" : "";
        $mensajesAnteriores .= $nuevoMensaje; //concatena los anteriores con el nuevo

        // Refrescamos la página con los mensajes concatenados
        header("Location: ?mensajes=" . urlencode($mensajesAnteriores));
        exit();
    }
    ?>
</body>
</html>
