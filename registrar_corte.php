<?php
include "Conector.php";
if(isset($_POST['usuario'])){
    $usuario=$_POST['usuario'];
}
else{
    $usuario="";
}

if(isset($_POST['n_sucursal'])){
    $sucursal=$_POST['n_sucursal'];
}
else{
    $sucursal="";
}

//------------------------------------- VARIABLES DE USO -------------------------------------
date_default_timezone_set('America/Mexico_City');
//VARIABLE A REMPLAZAR POR LA DE POST
if(isset($_POST['f_inicial'])){
    $fecha_inicial_fi =$_POST['f_inicial'];
    
}
else{
    $fecha_inicial_fi="";
    $bandera=True;
}


if(isset($_POST['f_final'])){
    $fecha_final_ff =$_POST['f_final'];
}
else{
    $fecha_final_ff="";
}

if($bandera==False){
    $insertar_corte="INSERT INTO cortes(id, fecha_ini, fecha_fin, usuario,sucursal) VALUES (0,'$fecha_inicial_fi','$fecha_final_ff','$usuario','$sucursal')";
    $res_fech=$mysqli -> query($insertar_corte);
    if($res_fech){
        header("location:Corte_PDF.php?usuario=$usuario&sucursal=$sucursal&fecha_inicial_fi=$fecha_inicial_fi&fecha_final_ff=$fecha_final_ff");
    }
    else{
        echo "Fail";
    }
}
else{
    $pass="";
}
?>