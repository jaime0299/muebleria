<?php

require "Conector.php";
include ("PHPMailer/src/PHPMailer.php");
include ("PHPMailer/src/OAuth.php");
include ("PHPMailer/src/SMTP.php");
include ("PHPMailer/src/POP3.php");
include ("PHPMailer/src/Exception.php");

$conexion->begin_Transaction();

$query="SELECT email FROM correo WHERE nombre='Matriz'";
$result = $mysqli->query($query);
$row = mysqli_fetch_array($result);

$correo_matriz = $row["email"];
if($correo_matriz == ""){
    echo "Error updating record: " . $mysqli->error;
    $mysqli->rollBack();
    ?>
    <?php
        include "index.php";
    ?>
    <link rel="stylesheet" href="css/estilos.css">
    <body>
        <div class="container">
            <div class="row justify-content-center mr-1">
                <div class='form-group mx-sm-4 pt-3'>
                    <h1 class="bad">
                        No exite ningun correo electrónico asociado al usuario maestro
                    </h1>  
                </div>  
            </div>
        </div>
    </body>
    <?php        
        //header("Refresh:3; url=Index.php"); 
        die();
    ?>
    <?php
}    
else{
    $token = md5(uniqid(mt_rand(), false));	
    $query="UPDATE correo SET tokenpass='$token' WHERE nombre = 'Matriz'";
    if ($mysqli->query($query) === TRUE) {
        //echo "Record updated successfully";      
    } else {
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        ?>
        <?php
            include "index.php";
        ?>
        <link rel="stylesheet" href="css/estilos.css">
        <body>
            <div class="container">
                <div class="row justify-content-center mr-1">
                    <div class='form-group mx-sm-4 pt-3'>
                        <h1 class="">
                            Ha ocurrido un error
                        </h1>  
                    </div>  
                </div>
            </div>
        </body>
        <?php        
            //header("Refresh:2; url=index.php"); 
            die();
        ?>
        <?php
    }
    $mysqli->commit();

    //echo $correo_matriz;
    //echo $token;
    
    $user_id = "Matriz";

    $url = "http://".$_SERVER["SERVER_NAME"]."/recuperacion/Recupera.php?user_id=".$user_id."&token=".$token;//"www.google.com";
    $emailTo = $correo_matriz;
    $subject = "Recuperar Password - Cuenta Maestra (Matriz)";
    $BodyEmail = "Hola Administrador: <br /><br /> Ha solicitado restablecer su contrase&ntilde;a. 
    <br /><br /> Para poder restaurar la contrase&ntilde;a, entre a la siguiente direcci&oacute;n: 
    <br /><br />
    <div class='form-group mx-sm-4 pb-2'>
        <a href='$url' style='text-decoration:none;'>
            <p href='$url' style='font-size: 16px;'>RESTABLECER CONTRASE&Ntilde;A</p>
        </a>
    </div> 
    <br />Si usted no ha solicitado la recuperaci&oacute;n de la contrase&ntilde;a, ignore este mensaje.";
    
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->isSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;//"login";
    $mail->SMTPSecure = "tls"; //Modificar
    $mail->Host = "smtp.gmail.com";//"smtp.live.com"; //Modificar
    $mail->Port = 587; //Modificar
    
    $mail->Username = "muebleria.el.porvenir.2020@gmail.com"; //Modificar
    $mail->Password = "MuEbleri@_El*P0rven1r_2020"; //Modificar
    
    //$mail->Username = "ada_michel_12@hotmail.com"; //Modificar
    //$mail->Password = "Elguille1890"; //Modificar

    $mail->setFrom("muebleria.el.porvenir.2020@gmail.com", "Mueblerias El Porvenir"); //Modificar
    //$mail->setFrom("ada_michel_12@hotmail.com", "Mueblerías El Porvenir"); //Modificar
    $mail->addAddress($correo_matriz, "Matriz");
    
    $mail->Subject = $subject;
    $mail->Body    = $BodyEmail;
    $mail->IsHTML(true);

    if(!$mail->send()){
        //echo "NO";
        ?>
        <?php        
            include "index.php";
        ?>
        <link rel="stylesheet" href="css/estilos.css">
        <body>
            <div class="container">
                <div class="row justify-content-center mr-1">
                    <div class='form-group mx-sm-4 pt-3'>
                        <h1 class='bad'>Ha ocurrido un problema al enviar el mensaje</h1>  
                    </div>  
                </div>
            </div>
        </body>
        <?php 
            //header ("Location: index.php");       
            //header("Refresh:2; url=index.php"); 
            //echo "NO";
            die();
    }    
    else{
        //echo "SI";
        ?>
        <?php
            include "index.php";
        ?>
        <link rel="stylesheet" href="css/estilos.css">
        <body>
            <div class="container">
                <div class="row justify-content-center mr-1">
                    <div class='form-group mx-sm-4 pt-3'>
                        <h1 style="text-align: center; border-radius: 10px; font-size: 20; width: 100%; 
                            padding: 12px; background-color: rgb(21, 255, 0); color: #fff">
                            Cheque la bandeja de entrada de su correo electrónico
                        </h1>
                    </div>  
                </div>
            </div> 
        </body>
        <?php
            //header("Location: index.php");        
            //header("Refresh:2; url=index.php"); 
            //echo "SI";
            die();
    }
}
?>
