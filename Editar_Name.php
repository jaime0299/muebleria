<?php

require "Conector.php";

session_start();

$Id_Sucursal = $_POST['sucursal0'];
$New_Sucursal = $_POST['sucursal1'];

$mysqli->begin_Transaction();

$query="SELECT * FROM sucursales WHERE nombre = '$New_Sucursal'";
$result = $mysqli->query($query);
$num=mysqli_num_rows($result);
echo $num;
if($num==0){
    $query = "UPDATE sucursales SET nombre = '$New_Sucursal' WHERE nombre = '$Id_Sucursal'";
}else{
    echo "Error updating record: " . $mysqli->error;
    $mysqli->rollBack();
    $_SESSION['message']="Error";
    $_SESSION['content']="Nombre de la sucursal ya esta registrada.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

if ($mysqli->query($query) === TRUE) {
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
$_SESSION['content']="El nombre de la sucursal ha sido cambido correctamente.";
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>