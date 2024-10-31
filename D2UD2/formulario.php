<?php
$ip_remota = $_SERVER['REMOTE_ADDR'];

// Mostrar la URL solicitada
$url_solicitada = $_SERVER['REQUEST_URI'];

// Mostrar el método HTTP utilizado (GET, POST, etc.)
$metodo_http = $_SERVER['REQUEST_METHOD'];
$cabeceras = apache_request_headers();

echo "<p><strong>IP Remota:</strong> $ip_remota</p>";
echo "<p><strong>URL Solicitada:</strong> $url_solicitada</p>";
echo "<p><strong>Método HTTP:</strong> $metodo_http</p>";
foreach ($cabeceras as $clave => $valor) {
    echo "<li><strong>$clave:</strong> $valor</li>";
}

$nombre = $genero = $instrumentos = $artistas = $experiencia = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar Nombre
    if (empty($_POST["nombre"])) {
        $errores['nombre'] = "El nombre es obligatorio."; // Guardar el error específico
    } else {
        $nombre = $_POST["nombre"];
    }

    // Validar Género Musical
    if (empty($_POST["genero"])) {
        $errores['genero'] = "Debe seleccionar un género musical.";
    } else {
        $genero = $_POST['genero'];
    }

    // Validar Instrumentos
    if (empty($_POST["instrumentos"])) {
        $errores['instrumentos'] = "Debe seleccionar al menos una opción.";
    } else {
        $instrumentos = $_POST['instrumentos'];
        
        // Verificar si "Ninguno" está seleccionado
        if (in_array("Ninguno", $instrumentos)) {
            // Comprobar que no haya otros instrumentos seleccionados
            if (count($instrumentos) > 1) {
                $errores['instrumentos'] = "Si seleccionaste 'Ninguno', no puedes seleccionar otras.";
            }
        } else {
            $instrumentos = implode(", ", $instrumentos);
        }
    }

    // Validar Artistas
    if (empty($_POST["artistas"])) {
        $errores['artistas'] = "Por favor, selecciona al menos un artista.";
    } else {
        $artistas = $_POST['artistas'];
        $artistas = implode(", ", $artistas);
    }

    // Validar Años de experiencia 
    if (empty($_POST["experiencia"])) {
        $errores['experiencia'] = "El campo de años de experiencia es obligatorio.";
    } elseif (!is_numeric($_POST["experiencia"])) {
        $errores['experiencia'] = "El campo de años de experiencia debe ser un número.";
    } else {
        $experiencia = $_POST['experiencia'];
    }

    if (empty($errores)) {
        echo "<h2>Resultados</h2>";
        echo "<p><strong>Nombre:</strong> " . $nombre . "</p>";
        echo "<p><strong>Género Musical Favorito:</strong> " . $genero . "</p>";
        echo "<p><strong>Instrumentos que tocas:</strong> " . $instrumentos. "</p>";
        echo "<p><strong>Artistas Favoritos:</strong> " . $artistas . "</p>";
        echo "<p><strong>Años de experiencia en música:</strong> " . $experiencia . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Preferencias Musicales</title>
</head>
<body>
    <h1>Encuesta de Preferencias Musicales</h1>

    <form method="POST" action="">
        <label for="nombre">Nombre completo:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $nombre ?>">
        <br>
        <span style="color:red"><?php echo $errores['nombre']?></span>
        <br>
        <br>

        <label>Género Musical Favorito:</label><br>
        <input type="radio" id="rock" name="genero" value="Rock" >
        <label for="rock">Rock</label><br>
        <input type="radio" id="pop" name="genero" value="Pop" >
        <label for="pop">Pop</label><br>
        <input type="radio" id="jazz" name="genero" value="Jazz" >
        <label for="jazz">Jazz</label><br>
        <input type="radio" id="clasica" name="genero" value="Clásica" >
        <label for="clasica">Clásica</label><br>
        <input type="radio" id="electronica" name="genero" value="Electrónica" >
        <label for="electronica">Electrónica</label>
        <br>
        <span style="color:red"><?php echo $errores['genero']?></span>
        <br>
        <br>

        <label>Instrumentos que tocas:</label><br>
        <input type="checkbox" id="guitarra" name="instrumentos[]" value="Guitarra" >
        <label for="guitarra">Guitarra</label><br>
        <input type="checkbox" id="piano" name="instrumentos[]" value="Piano" >
        <label for="piano">Piano</label><br>
        <input type="checkbox" id="bateria" name="instrumentos[]" value="Batería" >
        <label for="bateria">Batería</label><br>
        <input type="checkbox" id="violin" name="instrumentos[]" value="Violín" >
        <label for="violin">Violín</label><br>
        <input type="checkbox" id="ninguno" name="instrumentos[]" value="Ninguno" >
        <label for="ninguno">Ninguno</label>
        <br>
        <span style="color:red"><?php echo $errores['instrumentos']?></span>
        <br>
        <br>

        <label for="artistas">Artistas Favoritos (puedes seleccionar varios):</label><br>
        <select id="artistas" name="artistas[]" multiple>
            <option value="The Beatles">The Beatles</option>
            <option value="Beyoncé">Beyoncé</option>
            <option value="Coldplay">Coldplay</option>
            <option value="Mozart">Mozart</option>
            <option value="Daft Punk">Daft Punk</option>
        </select>
        <br>
        <span style="color:red"><?php echo $errores['artistas']?></span>
        <br><br>
        <label for="experiencia">Años de experiencia en música:</label>
        <input type="text" id="experiencia" name="experiencia" value="<?php echo $experiencia ?>">
        <br>
        <span style="color:red"><?php echo $errores['experiencia']?></span>
        <br>
        <br>
        <button type="submit">Enviar</button>
        <button type="reset">Borrar</button>
    </form>
</body>
</html>

