<?php
session_start();
session_destroy(); // Destruye la sesión
header("Location: inicioSesion.php"); // Redirige al inicio de sesión
exit();
?>