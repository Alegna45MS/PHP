<?php
session_start();

mostrarDatosServidor();
mostrarCabecerasPeticion();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de mascotas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    const FECHA_MIN_NAC = "01/01/2000"; // Fecha mínima para la fecha de nacimiento
    
    if (!isset($_REQUEST["confirmar"])) {
        if (!isset($_REQUEST["enviar"])) {
            // Primera vez solo muestro el formulario
            mostrarFormulario(true);
        } else {
            // Veces siguientes muestro el formulario y los mensajes de error o el resultado
            mostrarFormulario(false);
        }
    } else {
        echo "Datos enviados correctamente";
        echo "<p><a href=\"index.php\">Volver</a></p>";
    }
    ?>
</body>

</html>

<?php
function mostrarFormulario($primerEnvio)
{
    $campoObligatorio = "<span id=\"campoObligatorio\">*</span>";
    $especies = ["", "Gato", "Perro", "Hámster", "Pájaro", "Pez"];
    // ¿Diferencia entre usar $_REQUEST["especie"] y $_SESSION["especie"]?
    $especieGuardada = $_REQUEST["especie"] ?? "";
    ?>

    <h2>Registro de mascotas</h2>

    <?php mostrarReglas($campoObligatorio); ?>

    <form action="" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Datos mascota</legend>
            <?php if (!$primerEnvio) {
                echo validarCampoVacio($_REQUEST["nombre"]);
            } ?>
            <div>
                <label for="nombre">Nombre:<?= $campoObligatorio ?></label>
                <?php
                if (!$primerEnvio && !empty($_REQUEST["nombre"]))
                    echo "<input type=\"text\" name=\"nombre\" id=\"nombre\" value=\"" . $_REQUEST["nombre"] . "\">";
                else
                    echo "<input type=\"text\" name=\"nombre\" id=\"nombre\">";
                ?>
            </div>
            <?php if (!$primerEnvio) {
                echo validarCampoVacio($_REQUEST["especie"]);
            } ?>
            <div>
                <label for="especie">Especie:<?= $campoObligatorio ?></label>
                <select name="especie" id="especie">
                    <?php
                    // Generar los option con un array de sus valores y contenido
                    foreach ($especies as $especie) {
                        if ($especie == $especieGuardada)
                            echo "<option selected>$especie</option>";
                        else
                            echo "<option>$especie</option>";
                    }
                    ?>
                </select>
            </div>
            <div>
                <label for="raza">Raza:</label>
                <?php
                if (!empty($_REQUEST["raza"]))
                    echo "<input type=\"text\" name=\"raza\" id=\"raza\" value=\"" . $_REQUEST["raza"] . "\">";
                else
                    echo "<input type=\"text\" name=\"raza\" id=\"raza\">";
                ?>
            </div>
            <?php
            $fechaCorrecta = false;
            if (!$primerEnvio) {
                $mensajeError = validarFecha($_REQUEST["fechaNac"]);
                if (empty($mensajeError))
                    $fechaCorrecta = true;
                echo $mensajeError;
            } ?>
            <div>
                <label for="fechaNac">Fecha nacimiento:<?= $campoObligatorio ?></label>
                <?php
                if (!$primerEnvio && $fechaCorrecta)
                    echo "<input type=\"text\" name=\"fechaNac\" id=\"fechaNac\" value=\"" . $_REQUEST["fechaNac"] . "\">";
                else
                    echo "<input type=\"text\" name=\"fechaNac\" id=\"fechaNac\">";
                ?>
            </div>
            <?php if (!$primerEnvio) {
                echo validarSexo(); // No puedo pasarle $_REQUEST["sexo"] pq si no se ha seleccionado ninguna no se envía nada
            } ?>
            <div>
                <span>Sexo:<?= $campoObligatorio ?></span>
                <label for="sexoM">M</label>
                <?= mostrarInputSexo("sexo", "M") ?>
                <label for="sexoF">F</label>
                <?= mostrarInputSexo("sexo", "F") ?>
            </div>
            <!-- ¿Cómo podría mostrar esto solo si escoge gato o perro como especie sin necesidad de enviar primero el form? -->
            <?php
            $vacunasCorrectas = false;
            if (!$primerEnvio) {
                $mensajeError = validarVacunas(); // No puedo pasarle $_REQUEST["vacunas"] pq si no se ha seleccionado ninguna no se envía nada
                if (empty($mensajeError))
                    $vacunasCorrectas = true;
                echo $mensajeError;
            }
            ?>
            <div>
                <span>Vacunas (Solo gatos y perros):</span>
                <?php mostrarInputVacuna($vacunasCorrectas, "Rabia") ?>
                <label for="vacunaRabia">Rabia</label>
                <?php mostrarInputVacuna($vacunasCorrectas, "Leucemia") ?>
                <label for="vacunaLeucemia">Leucemia (G)</label>
                <?php mostrarInputVacuna($vacunasCorrectas, "Herpesvirus") ?>
                <label for="vacunaHerpesvirus">Herpesvirus (G)</label>
                <?php mostrarInputVacuna($vacunasCorrectas, "Hepatitis") ?>
                <label for="vacunaHepatitis">Hepatitis vírica (P)</label>
                <?php mostrarInputVacuna($vacunasCorrectas, "Leptospirosis") ?>
                <label for="vacunaLeptospirosis">Leptospirosis (P)</label>
            </div>
            <?php
            if (!$primerEnvio)
                echo validarArchivoFoto();
            ?>
            <!-- ¿Cómo guardar el archivo si el formulario está mal? -->
            <div>
                <label for="archivoFoto">Foto: <?= $campoObligatorio ?></label>
                <input type="file" name="archivoFoto" id="archivoFoto">
            </div>
            <?php
            if (!$primerEnvio && formularioValido()) {
                // Si guardo el archivo en una subcarpeta al descargalo me da un error porque se descarga como .htm
                $ruta = $_FILES['archivoFoto']['name'];
                echo $ruta;
                move_uploaded_file($_FILES['archivoFoto']['tmp_name'], $ruta);
                echo "<p><a href=\"" . urlencode($ruta) . "\" download>Descargar foto enviada</a></p>";
            }
            ?>
        </fieldset>

        <div id="botones">
            <button type="submit" name="enviar">Enviar</button>
            <button type="reset" name="borrar">Borrar</button>
        </div>
        <?php if (!$primerEnvio) {
            mostrarDatos();
        } ?>
    </form>
    <?php
}

function mostrarReglas($campoObligatorio)
{
    ?>
    <div>
        <span>Reglas:</span>
        <ul>
            <li>Campos obligatorios (<?= $campoObligatorio ?>), no pueden enviarse vacíos.</li>
            <li>La fecha debe ser válida: no puede ser inferior al <?= FECHA_MIN_NAC ?> superior a
                <?= date("d/m/Y") ?> y el
                formato debe ser <b>dd/mm/aaaa</b>
            </li>
            <li>Las vacunas solo son para los gatos y perros y son obligatorias. No se pueden seleccionar vacunas de
                ambas especies, en
                cada una viene indicado si es para gatos (G) o perros (P). La rabia es común a los dos.</li>
            <li>La foto debe ser en formato JPG, JPEG o PNG</li>
        </ul>
    </div>
    <?php
}

function validarCampoVacio($campo)
{
    if (empty($campo)) {
        return "<span id=\"mensajeError\">Debes completar el campo</span>";
    }
    return "";
}

function validarSexo()
{
    if (empty($_REQUEST["sexo"])) {
        return "<span id=\"mensajeError\">Debes completar el campo</span>";
    }
    return "";
}

function validarFecha($fecha): string
{
    if (empty($fecha)) {
        return "<span id=\"mensajeError\">Debes completar el campo</span>";
    } else {
        // A veces acepta cadenas que no son fechas y otras veces no. Solo pasa cuando es una letra, por eso la segunda parte de la condición
        if (DateTime::createFromFormat("d/m/Y", $fecha) && strlen($fecha) > 1 && !is_numeric($fecha)) {
            // Creo los objetos de tipo fecha con el formato d/m/Y.
            // Si no le indico el formato me los crea con el formato m/d/Y, a no ser que introduzca la fecha con el formato Y/m/d
            $fechaNac = DateTime::createFromFormat("d/m/Y", $fecha);
            $fechaNacMin = DateTime::createFromFormat("d/m/Y", FECHA_MIN_NAC);
            $fechaNacMax = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));

            if ($fechaNac < $fechaNacMin || $fechaNac > $fechaNacMax) {
                return "<span id=\"mensajeError\">La fecha no se encuentra en el rango aceptable</span>";
            }

        } else {
            return "<span id=\"mensajeError\">El dato introducido no es una fecha</span>";
        }
    }
    return "";
}

function validarVacunas(): string
{
    if (empty($_REQUEST["vacunas"])) {
        if ($_REQUEST["especie"] == "Gato" || $_REQUEST["especie"] == "Perro") {
            return "<span id=\"mensajeError\">Debes completar el campo</span>";
        }
    } else {
        if ($_REQUEST["especie"] == "Gato" || $_REQUEST["especie"] == "Perro") {
            $vacunas = $_REQUEST["vacunas"];
            if (($_REQUEST["especie"] == "Gato") && (in_array("Hepatitis", $vacunas) || in_array("Leptospirosis", $vacunas)))
                return "<span id=\"mensajeError\">Alguna de las vacunas elegidas no es para gatos</span>";

            if (($_REQUEST["especie"] == "Perro") && (in_array(needle: "Leucemia", haystack: $vacunas) || in_array("Herpesvirus", $vacunas)))
                return "<span id=\"mensajeError\">Alguna de las vacunas elegidas no es para perros</span>";
        } else {
            return "<span id=\"mensajeError\">No puedes rellenar este campo (solo para gatos y perros)</span>";
        }
    }
    return "";
}

function validarArchivoFoto()
{
    $tiposPermitidos = ["image/jpg", "image/jpeg", "image/png"];

    if (empty($_FILES['archivoFoto']['size']))
        return "<span id=\"mensajeError\">Debes completar el campo</span>";

    if (!empty($_FILES['archivoFoto']['error']))
        return "<span id=\"mensajeError\">El archivo no se ha enviado correctamente</span>";

    if (!in_array($_FILES["archivoFoto"]["type"], $tiposPermitidos))
        return "<span id=\"mensajeError\">El tipo del archivo no es correcto</span>";

    return "";
}

function formularioValido(): bool
{
    if (!empty(validarCampoVacio($_REQUEST["nombre"])))
        return false;

    if (!empty(validarCampoVacio($_REQUEST["especie"])))
        return false;

    if (!empty(validarSexo()))
        return false;

    if (!empty(validarFecha($_REQUEST["fechaNac"])))
        return false;

    if (!empty(validarVacunas()))
        return false;

    if (!empty(validarArchivoFoto()))
        return false;

    return true;
}

function mostrarDatos(): void
{
    if (formularioValido()) {
        ?>
        <fieldset>
            <legend>Datos procesados</legend>
            <?php
            mostrarDatosMascota();
            mostrarDatosArchivo();
            ?>
        </fieldset>
        <button type="submit" name="confirmar" id="botonConfirmar">Confirmar datos</button>
        <?php
    }
}

function mostrarDatosMascota()
{
    echo "<i>Datos mascota:</i>";
    echo "<ul>";
    echo "<li>Nombre: " . $_REQUEST["nombre"] . "</li>";
    echo "<li>Especie: " . $_REQUEST["especie"] . "</li>";
    echo "<li>Raza: " . $_REQUEST["raza"] . "</li>";
    echo "<li>Fecha nacimiento: " . $_REQUEST["fechaNac"] . "</li>";
    echo "<li>Edad: " . calcularEdad();
    echo "<li>Sexo: " . $_REQUEST["sexo"] . "</li>";
    $vacunas = $_REQUEST["vacunas"] ?? [];
    if (!empty($vacunas)) {
        echo "<li>Vacunas: ";
        for ($i = 0; $i < count($vacunas); $i++) {
            if ($i == count($vacunas) - 1)
                echo $vacunas[$i];
            else
                echo "$vacunas[$i], ";
        }
        echo "</li>";
    }
    echo "</ul>";
}

function mostrarInputSexo($nombre, $valor)
{
    if (!empty($_REQUEST[$nombre]) && $_REQUEST[$nombre] == $valor)
        return "<input type=\"radio\" name=\"$nombre\" id=\"$nombre$valor\" value=\"$valor\" checked>";
    return "<input type=\"radio\" name=\"$nombre\" id=\"$nombre$valor\" value=\"$valor\">";
}

function vacunaSeleccionada($vacunasCorrectas, $vacuna)
{
    if (!$vacunasCorrectas)
        return false;
    if (empty($_REQUEST["vacunas"]))
        return false;
    if (!in_array($vacuna, $_REQUEST["vacunas"]))
        return false;
    return true;
}

function mostrarInputVacuna($vacunasCorrectas, $vacuna)
{
    if (vacunaSeleccionada($vacunasCorrectas, $vacuna))
        echo "<input type=\"checkbox\" name=\"vacunas[]\" id=\"vacuna$vacuna\" value=\"$vacuna\" checked>";
    else
        echo "<input type=\"checkbox\" name=\"vacunas[]\" id=\"vacuna$vacuna\" value=\"$vacuna\">";
}

function calcularEdad()
{
    $fechaNac = DateTime::createFromFormat("d/m/Y", $_REQUEST["fechaNac"]);
    $fechaActual = DateTime::createFromFormat("d/m/Y", date("d/m/Y"));

    return $fechaNac->diff($fechaActual)->format("%y años");
}

function mostrarDatosServidor()
{
    echo "<p>Datos del servidor:</p>";
    echo "<ul>";
    echo "<li>Nombre del script ejecutándose: " . $_SERVER["PHP_SELF"] . "</li>";
    echo "<li>IP remota: " . $_SERVER["REMOTE_ADDR"] . "</li>";
    echo "<li>Puerto usado por el servidor: " . $_SERVER["SERVER_PORT"] . "</li>"; // Dependiendo del navegador usa uno u otro
    echo "<li>Directorio raíz del documento en el que se ejecuta el script: " . $_SERVER["DOCUMENT_ROOT"] . "</li>";
    echo "<li>Método usado por la petición: " . $_SERVER["REQUEST_METHOD"] . "</li>";
    echo "<li>Protocolo y versión: " . $_SERVER["SERVER_PROTOCOL"] . "</li>";
    echo "</ul><hr>";
}

function mostrarCabecerasPeticion()
{
    $cabeceras = apache_request_headers();

    echo "<p>Cabeceras de petición:</p>";
    echo "<ol>";
    foreach ($cabeceras as $cabecera => $valor) {
        echo "<li>$cabecera: $valor</li>";
    }
    echo "<br><hr><hr>";
}

function mostrarDatosArchivo()
{
    if (isset($_FILES['archivoFoto']) && empty($_FILES['archivoFoto']['error'])) {
        // Mostrar datos archivo
        echo "<i>Datos archivo:</i>";
        echo "<ul>";
        echo "<li>Tamaño: " . $_FILES['archivoFoto']['size'] . " bytes</li>";
        echo "<li>Nombre: " . $_FILES['archivoFoto']['name'] . "</li>";
        echo "<li>Tipo: " . $_FILES['archivoFoto']['type'] . "</li>";
        echo "<li>Ubicación temporal en el servidor: " . $_FILES['archivoFoto']['tmp_name'] . "</li>";
    }
}
?>