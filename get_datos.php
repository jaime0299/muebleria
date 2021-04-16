<?php
    require_once "Conector.php";
    if(isset($_POST['codigo'])){
        $codigo=$_POST['codigo'];
        $sucursal=$_POST['sucu'];
        $query="SELECT i.codigo,p.clave,p.nombre,p.marca,p.precio,i.stock FROM productos p,inventarios i 
        WHERE i.codigo='$codigo' and p.clave=i.clave and i.sucursal='$sucursal';";
        $result=$mysqli->query($query);
        $data=mysqli_fetch_assoc($result);
        echo json_encode(['datos' => $data]);
        
    }else if(isset($_POST['codigo_venta'])){
        $error="no";
        $codigo=$_POST['codigo_venta'];
        $sucursal=$_POST['sucu'];
        $cantidad=$_POST['canti'];
        $total=$_POST['total'];
        $tipo=$_POST['tipo'];
        date_default_timezone_set("America/Mexico_City");
        $fecha=date("Y-m-d");
        $mysqli->begin_Transaction();
        $query="INSERT INTO ventas(codigo,cantidad,total,sucursal,fecha,tipo_pago) VALUES('$codigo',$cantidad,$total,'$sucursal','$fecha','$tipo')";
        if ($mysqli->query($query) === TRUE) {
            //echo "Record updated successfully";
        } else {
            $mysqli->rollBack();
            $error="si";
        }
        $query="UPDATE inventarios SET stock=stock-$cantidad WHERE codigo='$codigo' and sucursal='$sucursal'";
        if ($mysqli->query($query) === TRUE) {
            //echo "Record updated successfully";
        } else {
            $mysqli->rollBack();
            $error="si";
        }
        if($error=="no"){
            $mysqli->commit();
        }
        echo json_encode(['datos' => $error]);
    }
?>