<?php
require "Conector.php";

session_start();

$codigo=$_POST['codigo'];
$clave=$_POST['clave'];
$canti=$_POST['canti'];
$sucu=$_POST['sucu'];
$sucursal_actual = $_POST['sucursal_actual'];

$mysqli->begin_Transaction();

$query="SELECT * FROM inventarios WHERE codigo='$codigo' and sucursal='$sucu'";
$result = $mysqli->query($query);
$num=mysqli_num_rows($result);
echo $num;
if($num==0){
    $query="INSERT INTO inventarios VALUES('$codigo','$sucu',$canti,'$clave',CURDATE())";
}else{
    $query="UPDATE inventarios SET stock=stock+$canti WHERE sucursal='$sucu' and codigo='$codigo'";
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


$query3="UPDATE inventarios SET stock=stock-$canti WHERE sucursal='$sucursal_actual' and codigo='$codigo'";
if ($mysqli->query($query3) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqli->error;
    $mysqli->rollBack();
    $_SESSION['message']="Error";
    $_SESSION['content']="Ha ocurrido un error";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
}

$query4="INSERT INTO entradas(codigo,sucur_sal,sucur_ent,fecha,cantidad) VALUES('$codigo','$sucursal_actual','$sucu',CURDATE(),$canti)";
if ($mysqli->query($query4) === TRUE) {
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
$_SESSION['content']="El producto ha sido transferido con éxito";
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>