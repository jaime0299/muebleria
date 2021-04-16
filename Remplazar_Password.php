<?php

require "Conector.php";

session_start();

$Id_Sucursal = $_POST['sucursal3'];
$P1 = $_POST['contra1'];
$P2 = $_POST['contra2'];

if ($P1 == $P2 && !empty($Id_Sucursal)){
    $mysqli->begin_Transaction(); 

    $pass_cifrado = password_hash($P1,PASSWORD_DEFAULT,array("cost"=>15));

    $query1 = "UPDATE sucursales SET pass = '$pass_cifrado' WHERE nombre = '$Id_Sucursal'";

    if ($mysqli->query($query1) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="Ha ocurrido un error";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
    
    $mysqli->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="La contraseña ha sido cambiada correctamente.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else{
    $_SESSION['message']="Error";
    $_SESSION['content']="Las contraseñas no coinciden.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>