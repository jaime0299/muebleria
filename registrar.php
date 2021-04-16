<?php
$contador=0;
include 'Conector.php';
//Recibir los datos y almacenarlos en las variables
$clave= $_POST["clave2"];
$nombre= $_POST["nombre2"];
$marca= $_POST["marca2"];
$descripcion= $_POST["descripcion2"];
$precio= $_POST["precio2"];
$proveedor= $_POST["proveedor2"]; 
#$estrella=$_POST["estrella"];

date_default_timezone_set("America/Mexico_City");
$fecha=date("Y-m-d");

echo $descripcion;
echo $precio;

if(isset($_POST['estrella2'])){
    $estrella="SI";
}else{
    $estrella="NO";
}

$ban=true;
//Consulta para insertar
//echo $_POST["estrella"];
//echo "estrella";

session_start();
$conexion->begin_Transaction();

$des=$mysqli->real_escape_string($descripcion);
$insertar = "INSERT INTO productos(clave,nombre,marca,descripcion,precio,proveedor,estrella) VALUES 
('$clave','$nombre','$marca','$des',$precio,'$proveedor','$estrella')";
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

$clave= $_POST["clave2"];
$codigo= $_POST["codigo2"];
$stock= $_POST["stock2"];
$fecha= $_POST["fecha2"];
$sucur=$_POST["sucursal2"];
//Consulta para insertar
$insertar2 = "INSERT INTO inventarios(codigo, sucursal, stock, clave, entrada) VALUES ('$codigo','$sucur',$stock,'$clave','$fecha')";

//ejecutar la consulta
if ($conexion->query($insertar2) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $mysqli->error;
    $_SESSION['message']="Error";
    $_SESSION['content']="Ha ocurrido un error. ".$conexion->error;
    $mysqli->rollBack();
    $ban=false;
}

$query4="INSERT INTO entradas(codigo,sucur_sal,sucur_ent,fecha,cantidad) VALUES('$codigo','$proveedor','$sucur','$fecha',$stock)";
if ($conexion->query($query4) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
    $_SESSION['message']="Error";
    $_SESSION['content']="Ha ocurrido un error. ".$conexion->error;
    $conexion->rollBack();
    $ban=false;
}

if($ban===true){
    echo "Sale";
    $conexion->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="El producto ha sido registrado con éxito";
}else{
    echo "NO sale";
}

mysqli_close($conexion);

if (isset($_SERVER['HTTP_REFERER'])){
    header("location:".$_SERVER['HTTP_REFERER']);
}else{
    echo "NO";
}