<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    </head>
    <body>
        <h2>Datos</h2>
        <?php
          echo "Nombre: ". $_REQUEST["nombre"]."<br>";
          echo "Correo Electronico: ".$_REQUEST["correo"]."<br>";
          echo "Contraseña: ".$_REQUEST["pass"]."<br>";
          echo "Tu color favorito es: ".$_REQUEST["color"]
            
        ?>
    </body>
</html>