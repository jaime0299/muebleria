<?php

require "../Conector.php";

if(empty($_GET['user_id']) or empty($_GET['token'])){
    header("Location: ../index.php");
}

$user_id = $mysqli->real_escape_string($_GET['user_id']);
$token = $mysqli->real_escape_string($_GET['token']);

$conexion->begin_Transaction();

$query="SELECT nombre,tokenpass FROM correo WHERE nombre='$user_id' AND tokenpass='$token'";
$result = $mysqli->query($query);
$row = mysqli_fetch_array($result);

$nombre = $row["nombre"];
$token_rec = $row["tokenpass"];

if ($nombre == "" or $token_rec == ""){
    $mysqli->rollBack();
    header("Location: ../index.php");    
    die();
}
else{
    
    $nombre = $row["nombre"];
    $token_rec = $row["tokenpass"];
    $mysqli->commit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Recuperar Cuenta Maestra (Matriz) </title>
    <link rel="shortcut icon" href="../img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="../css/estilos.css">

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="../lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="../lib/alertify/css/themes/default.css">
    <script src="../lib/alertify/alertify.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>
<body style="background-image: url(../img/Fondo.jpg);">
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 mr-1">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 formulario">
                    <fiv class="form-group text-center">
                        <h1 class="titulo">RECUPERACIÓN</h1>
                    </fiv>
                    <div class="form-group mx-sm-4 pt-3" id="contrasena-group">
                        <input type="password" id="contra_rec1" name="contra_rec1" class="form-control" pattern="[A-Za-z0-9_-]{8,100}" required 
                        placeholder="Ingrese nueva contraseña (minimo 8 caracteres)">
                    </div>
                    <div class="form-group mx-sm-4 pb-3" id="contrasena-group">
                        <input type="password" id="contra_rec2" name="contra_rec2" class="form-control" pattern="[A-Za-z0-9_-]{8,100}" required 
                        placeholder="Confirme nueva contraseña (minimo 8 caracteres)">
                    </div>
                    <div class="form-group mx-sm-4 pb-2">
                        <button onclick="recupera()" class="btn btn-primary btn-block ingresar"><i class="fas fa-check-square"></i>  MODIFICAR </button>
                    </div>
            </div>
        </div>
    </div>
</body>
<script src="../js/jquery.js"></script>
<script src="../lib/bootstrap/js/bootstrap.js"></script>
<script>
    function recupera(){
        var con1=document.getElementById("contra_rec1").value;
        var con2=document.getElementById("contra_rec2").value;
        if(con1!=con2){
            alertify.alert("Alerta","Las contraseñas no coinciden.");
        }else{
            let form= new FormData();
            form.append("contra_rec1",con1);
            form.append("contra_rec2",con2);
            fetch('Cambio.php',{method:'POST',body:form})
            .then(res=>res.json())
            .then(data=>{
                if(data["datos"]!=null){
                    var error=data["datos"];
                    if(error=="si"){
                        alertify.error("Ha ocurrido un error");
                    }else{
                        alertify.success("La contraseña se ha cambiado con éxito.");
                        setTimeout(recarga,1500);
                    }
                }else{
                    alertify.error("Ha ocurrido un error. Datos JSON nulos");
                }
            })
        }
    }
    function recarga(){
        window.location="https://muebleriaselporvenir.com";
    }
</script>
</html>