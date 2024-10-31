<?php
// Inicializar variables para almacenar los resultados y la consulta de búsqueda
$resultados = "";

// Verificar si se ha enviado el formulario
if (isset($_GET['buscar']) && isset($_GET['opcion']) && isset($_GET['genero'])) {
    // Obtener los valores de búsqueda
    $textoBusqueda = $_GET['buscar'];
    $opcionBusqueda = $_GET['opcion'];
    $generoMusical = $_GET['genero'];

    // Simulación de una base de datos de canciones
    $canciones = [
        ['titulo' => 'Imagine', 'album' => 'Imagine', 'genero' => 'rock'],
        ['titulo' => 'Bohemian Rhapsody', 'album' => 'A Night at the Opera', 'genero' => 'rock'],
        ['titulo' => 'Thriller', 'album' => 'Thriller', 'genero' => 'pop'],
        ['titulo' => 'Rolling in the Deep', 'album' => '21', 'genero' => 'pop'],
    ];

    // Filtrar canciones según la opción de búsqueda y el género seleccionado
    foreach ($canciones as $cancion) {
        // Filtrar por género y realizar la búsqueda en título, álbum o ambos
        if (($generoMusical == 'todos' || $cancion['genero'] == $generoMusical) && 
            ($opcionBusqueda == 'titulo' && stripos($cancion['titulo'], $textoBusqueda) !== false ||
             $opcionBusqueda == 'album' && stripos($cancion['album'], $textoBusqueda) !== false ||
             $opcionBusqueda == 'ambos' && (stripos($cancion['titulo'], $textoBusqueda) !== false || stripos($cancion['album'], $textoBusqueda) !== false))) {
            
            // Si hay coincidencia, agregarlo a los resultados
            $resultados .= "Título: " . htmlspecialchars($cancion['titulo']) . " - Álbum: " . htmlspecialchars($cancion['album']) . " - Género: " . htmlspecialchars(ucfirst($cancion['genero'])) . "<br>";
        }
    }
    
    // Si no hay coincidencias
    if (empty($resultados)) {
        $resultados = "No se encontraron resultados para tu búsqueda.";
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Canciones</title>
</head>
<body>
    <h1>Buscar Canciones</h1>
    <form action="" method="get">
        <label for="buscar">Texto a buscar:</label>
        <input type="text" id="buscar" name="buscar" required>
        <br><br>

        <label>Buscar en:</label><br>
        <input type="radio" id="titulo" name="opcion" value="titulo" required>
        <label for="titulo">Títulos de canción</label><br>

        <input type="radio" id="album" name="opcion" value="album">
        <label for="album">Nombres de álbum</label><br>

        <input type="radio" id="ambos" name="opcion" value="ambos">
        <label for="ambos">Ambos</label><br><br>

        <label for="genero">Género musical:</label>
        <select id="genero" name="genero" required>
            <option value="todos">Todos</option>
            <option value="pop">Pop</option>
            <option value="rock">Rock</option>
        </select><br><br>

        <button type="submit">Buscar</button>
    </form>

    <?php
    // Mostrar resultados
    if ($resultados) {
        echo "<h2>Resultados:</h2>";
        echo $resultados;
    }
    ?>
</body>
</html>
