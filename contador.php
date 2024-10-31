
<html>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>contador</title>
    </head>
    <body>

        <?php
        session_start();
        define('RUTA_FICHERO',"/var/www/html/");
        if(file_exists('RUTA_FICHERO')){
            $cuentaGlobal=file_get_contents('RUTA_FICHERO');
            $cuentaGlobal++;
        }else{
            $cuentaGlobal=1;
        }
        file_put_contents('RUTA_FICHERO',$cuentaGlobal);

        if(!isset($_SESSION['contador'])){
            $_SESSION['contador']=1;
        }else{
            $_SESSION['contador']=$_SESSION['contador']+1;
        }
        echo "VISITAS GLOBALES:".$cuentaGlobal."<br>";

        /*if(!isset($_SESSION['contador'])){
            $_SESSION['contador']=1;
        }
        else {
            $_SESSION['contador']=$_SESSION['contador']+1;
        }
        echo "<p>Tus visitas:".$_SESSION['contador']."</p>";
        echo "<p><a href=>volver></a></p>";*/
        
        /*if(isset($_GET['contador'])){
            $contador=$_GET['contador']+1;
        }else{
            $contador=1;
        }
        echo "<p>Tus visitas:$contador</p>";*/

        /*if(isset($_SESSION['contador'])){
            $contador=$_SESSION['contador']=1;
        }
        else {
            $contador=1;
        }
        echo "<p>Tus visitas:$contador</p>";*/
        ?>
    </body>
        
    </html>
</html>