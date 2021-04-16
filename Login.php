<?php

require "Conector.php"; //'or'1'='1

session_start();

$usuario = $mysqli->real_escape_string($_POST['usuario']);
$pass = $mysqli->real_escape_string($_POST['password']);


$query="SELECT nombre,pass FROM sucursales as total WHERE nombre='$usuario'";
$result = $mysqli->query($query);
$row = mysqli_fetch_array($result);

$user = $row["nombre"];
$password = $row["pass"];
if (empty($user))
{
    ?>
    <?php        
        include 'index.php'; 
    ?>
    <body>
        <div class="container">
            <div class="row justify-content-center mr-1">
                <div class='form-group mx-sm-4 pt-3'>
                    <h1 class='bad'>Sucursal inexistente</h1>.</h1>  
                </div>  
            </div>
        </div>
    </body>
    <?php
}
else
{    
    if (password_verify($pass,$password))
    {
        $_SESSION['username'] = $usuario;
        header('Location: Principal.php');
    }
    else
    {
        ?>
        <?php        
            include 'index.php'; 
        ?>
        <body>
            <div class="container">
                <div class="row justify-content-center mr-1">
                    <div class='form-group mx-sm-4 pt-3'>
                        <h1 class='bad'>Contraseña incorrecta</h1>.</h1>  
                    </div>  
                </div>
            </div>
        </body>
        <?php
    }
}

/*
$query="SELECT * FROM sucursales as total WHERE nombre='$usuario' and pass='$pass'";
$result = $mysqli->query($query);
$data=mysqli_num_rows($result);
echo $data;
if ($data>0){
    $_SESSION['username'] = $usuario;
    header('Location: Principal.php');
}else{
    #?>
    <?php        
        include 'Index.php'; 
    #?>
    <body>
        <div class="container">
            <div class="row justify-content-center mr-1">
                <div class='form-group mx-sm-4 pt-3'>
                    <h1 class='bad'>Los datos introducidos son incorrectos.</h1>  
                </div>  
            </div>
        </div>
    </body>
    <?php    
    #header('Location: ' . $_SERVER['HTTP_REFERER']);
}

#mysqli_free_result($result);
#mysqli_close($mysqli);
*/
?>