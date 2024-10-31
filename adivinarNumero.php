<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
        
        $numero_intentos=0;
        $numero_adivinar=rand(1,10);
        
        $numero = $_REQUEST["num"];
        $numero_intentos++;
        
        if($numero == $numero_adivinar){
            echo "Lo has adivinado"."<br>";
            echo "Numero de intentos:".$numero_intentos;
        }if($numero < $numero_adivinar){
            echo "EL numero a adivinar es menor";
            $numero_intentos++;
        }if($numero == $numero_adivinar){
            echo "EL numero a adivinar es menor";
        }

    ?>
    <form method="post">
    <label for="numero">Adivina numero</label>
    <input type="number" id="numero" name="num"/>
    <INPUT TYPE='hidden' NAME='numero_adivinar' VALUE="<?php echo $numero_adivinar; ?>">
    <INPUT TYPE='hidden' NAME='intentos' VALUE="<?php echo $numero_intentos; ?>">
    <button type="submit">Enviar</button>
    
    </form>
</body>
</html>