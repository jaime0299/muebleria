
<?php
$contador=0;
include 'Conector.php';

$S = $_POST["sucursal1"];
$P = $_POST["contrasena1"];

echo $S;
echo $P;

$pass_cifrado = password_hash($P,PASSWORD_DEFAULT,array("cost"=>15));

$ban=true;
//Consulta para insertar

session_start();
$conexion->begin_Transaction();

$des=$mysqli->real_escape_string($descripcion);
$insertar = "INSERT INTO sucursales(nombre,pass) VALUES ('$S','$pass_cifrado')";
//ejecutar la consulta

if ($conexion->query($insertar) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqli->error;
    $_SESSION['message']="Error";
    $_SESSION['content']="Ha ocurrido un error. ".$conexion->error;
    $mysqli->rollBack();
    $ban=false;
}
//Cerrar conexion

if($ban===true){
    echo "Sale";
    $conexion->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="La sucursal ha sido registrada con éxito";
}else{
    echo "NO sale";
}

mysqli_close($conexion);

if (isset($_SERVER['HTTP_REFERER'])){
    header("location:".$_SERVER['HTTP_REFERER']);
}else{
    echo "NO";
}