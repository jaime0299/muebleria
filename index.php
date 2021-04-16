<?php
if(!isset($_SESSION))
{
    session_start();
    if (isset($_SESSION['username']))
    {
        header('Location: Principal.php');
    }
    else
    {
        if(isset($_POST['submit']))
        {
            $usuario = $_POST['usuario'];
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Login Mueblerías El Porvenir </title>
    <link rel="shortcut icon" href="img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="css/estilos.css">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
</head>
<body style="background-image: url(/img/Fondo.jpg);">
    <div class="container">
        <div class="row justify-content-center pt-5 mt-5 mr-1">
            <div class="col-md-6 col-sm-8 col-xl-4 col-lg-4 formulario">
                <form action="Login.php" method="POST">
                    <fiv class="form-group text-center">
                        <h1 class="titulo">INICIAR SESIÓN</h1>
                    </fiv>
                    <div class="form-group mx-sm-4 pt-3" id="user-group">
                        <input type="text" class="form-control" pattern="[A-Za-z0-9_-]{1,100}" required placeholder="Ingrese su usuario" name="usuario" value="<?php if(isset($usuario)) echo $usuario;?>">
                    </div>
                    <div class="form-group mx-sm-4 pb-3" id="contrasena-group">
                        <input type="password" class="form-control" pattern="[A-Za-z0-9_-]{8,100}" required placeholder="Ingrese su contraseña" name="password">
                    </div>
                    <div class="form-group mx-sm-4 pb-2">
                        <button type="submit" class="btn btn-primary btn-block ingresar" name='Login'><i class="fas fa-sign-in-alt"></i>  INGRESAR </button>
                    </div>
                    <div class="form-group text-right mx-sm-4">
                        <span class=""><a href="Enviar_correo.php" class="olvide">¿Olvide mi contraseña?</a:href></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>