<?php

require "../Conector.php";
$mysqli->begin_Transaction(); 
$error="no";
$P1 = $_POST['contra_rec1'];
$P2 = $_POST['contra_rec2'];

if ($P1 == $P2){

    $pass_cifrado = password_hash($P1,PASSWORD_DEFAULT,array("cost"=>15));
    $query1 = "UPDATE sucursales SET pass = '$pass_cifrado' WHERE nombre = 'Matriz'";

    if ($mysqli->query($query1) === TRUE) {
        //echo "Record updated successfully";
    } else {
        //echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack(); 
        $error="si";       
            //header("Refresh:1; url=Recupera.php");
    }

    $query1 = "UPDATE correo SET tokenpass = '' WHERE nombre = 'Matriz'";

    if ($mysqli->query($query1) === TRUE) {
        //echo "Record updated successfully";
    } else {
        //echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $error="si";      
            //header("Refresh:1; url=Recupera.php");
    }
    if($error=="no"){
        $mysqli->commit();
    }
    echo json_encode(['datos' => $error]);
}
?>