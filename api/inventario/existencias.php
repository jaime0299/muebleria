<?php
include('../../Conector.php');

$clave=$_POST['clave'];

$con="SELECT * FROM productos WHERE clave='$clave'";
$res=$mysqli->query($con);

$num=mysqli_num_rows($res);

$con2="SELECT * FROM inventarios WHERE clave='$clave' and sucursal='Almacen'";
$res2=$mysqli->query($con2);
$num2=mysqli_num_rows($res2);

$con3="SELECT productos.clave,productos.nombre,productos.marca,inventarios.codigo,
        inventarios.stock FROM productos,inventarios WHERE productos.clave='$clave' 
        and inventarios.clave='$clave' and inventarios.sucursal='Almacen'";
$res3=$mysqli->query($con3);

if($num==0){
    $error="error";
    echo json_encode(['datos' => $error]);
}else if($num2==0){
    $error="error2";
    echo json_encode(['datos' => $error]);
}else{
    $row=mysqli_fetch_assoc($res3);
    echo json_encode(['datos' => $row]);
}

?>