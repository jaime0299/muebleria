
<?php
$contador=0;

include 'Conector.php';
//Recibir los datos y almacenarlos en las variables
$clave= $_POST["clave3"];
$codigo=$_POST["codigo3"];
$nombre= $_POST["nombre3"];
$marca= $_POST["marca3"];
$descripcion= $_POST["descripcion3"];
$precio= $_POST["precio3"];

$stock= $_POST["stock3"];
$fecha= $_POST["fecha3"];
$sucur=$_POST["sucursal3"];
#$estrella=$_POST["estrella"];


if(isset($_POST['estrella3'])){
    $estrella="SI";
}else{
    $estrella="NO";
}

$ban=true;
//Consulta para insertar
//echo $_POST["estrella"];
//echo "estrella";

$consult="SELECT sucur_sal FROM entradas WHERE codigo='$codigo'";
$resultado=$conexion->query($consult);

$row=$resultado->fetch_array();
$proveedor=$row['sucur_sal'];

$consult="SELECT stock FROM inventarios WHERE codigo='$codigo' and sucursal='$sucur'";
$resultado=$conexion->query($consult);

$row=$resultado->fetch_array();
$stock_actual=$row['stock'];

$stock_ent=$stock-$stock_actual;

session_start();
$conexion->begin_Transaction();

$des=$mysqli->real_escape_string($descripcion);
$insertar = "UPDATE productos SET descripcion='$descripcion',precio='$precio' WHERE clave='$clave'";
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
$insertar2 = "UPDATE inventarios SET  stock='$stock' WHERE clave='$clave' and sucursal='$sucur'";

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

if($stock_ent>0){
    $query4="INSERT INTO entradas(codigo,sucur_sal,sucur_ent,fecha,cantidad) VALUES('$codigo','$proveedor','$sucur',CURDATE(),$stock_ent)";
    if ($conexion->query($query4) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conexion->error;
        $_SESSION['message']="Error";
        $_SESSION['content']="Ha ocurrido un error. ".$conexion->error;
        $conexion->rollBack();
        $ban=false;
    }
}




if($ban===true){
    echo "Sale";
    $conexion->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="El producto ha sido modificado con éxito";
}else{
    echo "NO sale";
}

mysqli_close($conexion);

if (isset($_SERVER['HTTP_REFERER'])){
    header("location:".$_SERVER['HTTP_REFERER']);
}else{
    echo "NO";
}