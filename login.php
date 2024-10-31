<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php session_start()
    $hash="";
    if(isset($_SESSION['authok'])){
        echo " autenticacion correcta";
        exit();
    }
    $authok=false
    if(isset($_POST['usuario'])){
        if(($_POST['usuario']=='pepita') && password_verify($_POST['contrasena'],$hash)){
            echo "autenticacion correcta";
            $_SESSION['authok']=true;
            $authok=true;
        }else{
            echo "usuario y/o contraseña no correcto"
        }
    }
    ?>
    <form method="Post"> 
        <p>Usuario<input type="text" name="usuario" value=""></p>
        <p>Contraseña<input type="text" name="contrasena" value=""></p>
        <<button type="submit"></button>
    </form>
</body>
</html>