<?php

require "Conector.php";

session_start();

$Id_Proveedor = $_POST['proveedor0'];
//$Id_E_Proveedor = $_POST['proveedor3'];

if(isset($Id_Proveedor)){
    /*
    $mysqli->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="EDITAR";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
    */

    $New_Proveedor = $_POST['proveedor2'];
    $Tel_Proveedor = $_POST['telefono2'];

    $mysqli->begin_Transaction(); 

    $query="SELECT * FROM proveedores WHERE nombre = '$New_Proveedor'";
    $result = $mysqli->query($query);
    $num=mysqli_num_rows($result);
    echo $num;
    if($num==0 or $New_Proveedor == $Id_Proveedor){
        $query = "UPDATE proveedores SET nombre = '$New_Proveedor', telefono = '$Tel_Proveedor' WHERE nombre = '$Id_Proveedor'";
    }else{
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="El proveedor $New_Proveedor ya esta registrado.";
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
    $_SESSION['content']="La información del proveedor ha sido modificada correctamente.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
elseif(!isset($Id_Proveedor) and !isset($Id_E_Proveedor)){
    /*
    $mysqli->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="AGREGAR";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
    */
    
    $N_Proveedor = $_POST['proveedor1'];
    $T_Proveedor = $_POST['telefono1'];

    $mysqli->begin_Transaction(); 

    $query="SELECT * FROM proveedores WHERE nombre = '$N_Proveedor'";
    $result = $mysqli->query($query);
    $num=mysqli_num_rows($result);
    echo $num;
    if($num==0){
        $query = "INSERT INTO `proveedores`(`nombre`, `telefono`) VALUES ('$N_Proveedor','$T_Proveedor')";
    }else{
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="El proveedor $N_Proveedor ya esta registrado.";
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
    $_SESSION['content']="El proveedor ha sido registrado correctamente.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
/*elseif(isset($Id_E_Proveedor)){
    
    $mysqli->commit();
    $_SESSION['message']="success";
    $_SESSION['content']="ELIMINAR";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
    

    $query="SELECT * FROM productos WHERE proveedor = '$Id_E_Proveedor'";
    $result = $mysqli->query($query);
    $num=mysqli_num_rows($result);
    echo $num;
    if($num>0){
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="El proveedor $Id_E_Proveedor no se puede eliminar ya que hay productos relacionados con él.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }

    $query = "DELETE FROM proveedores WHERE nombre = '$Id_E_Proveedor'";

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
    $_SESSION['content']="El proveedor ha sido eliminado correctamente.";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}*/
?>