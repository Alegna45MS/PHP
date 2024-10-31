<html>
    <head>
        <title>Prueba de PHP</title>
    </head>
    <body>
        <?php 
            if (isset($_GET["nombre"]) && !empty($_GET["nombre"])){
                echo "Hola ",$_GET["nombre"];
            }else{
                echo "hola mundo";
            }
        ?>
        
 

    </body>
</html>
