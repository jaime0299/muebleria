<?php

require "../Conector.php";

session_start();

$correo_ver = $_POST['correoverificacion'];

$mysqli->begin_Transaction();

if($correo_ver == "AGREGAR_CORREO")
{   /*
    $_SESSION['message']="success";
    $_SESSION['content']="AGREGAR";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
    */
    $correo0 = $_POST['correo0'];
    $correo1 = $_POST['correo1'];
    echo $correo0." - ".$correo1;

    if (filter_var($correo0,FILTER_VALIDATE_EMAIL) and filter_var($correo1,FILTER_VALIDATE_EMAIL)){
        //echo "PASA";
        if($correo0 == $correo1){
            //UPDATE correo SET email='adainguillermomagallanes@gmail.com' WHERE nombre = 'Matriz'
            $query =  "UPDATE correo SET email='$correo0' WHERE nombre='Matriz'";

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
            $_SESSION['content']="El correo electronico ha sido agregado correctamente.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else{
            echo "Error updating record: " . $mysqli->error;
            $mysqli->rollBack();
            $_SESSION['message']="Error";
            $_SESSION['content']="Los correos introducidos no coinciden";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }
    else{
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="Introduce un correo electronico valido";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}
else if($correo_ver == "CAMBIAR_CORREO"){
    /*
    $_SESSION['message']="success";
    $_SESSION['content']="CAMBIAR";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die();
    */
    $correo3 = $_POST['correo3'];
    $correo4 = $_POST['correo4'];
    echo $correo3." - ".$correo4;
    if(filter_var($correo3,FILTER_VALIDATE_EMAIL) and filter_var($correo4,FILTER_VALIDATE_EMAIL)){
        if($correo3 == $correo4){
            //UPDATE correo SET email='adainguillermomagallanes@gmail.com' WHERE nombre = 'Matriz'
            $query =  "UPDATE correo SET email='$correo3' WHERE nombre='Matriz'";

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
            $_SESSION['content']="El correo electronico ha sido cambiado correctamente.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else{
            echo "Error updating record: " . $mysqli->error;
            $mysqli->rollBack();
            $_SESSION['message']="Error";
            $_SESSION['content']="Los correos introducidos no coinciden";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die();
        }
    }
    else{
        echo "Error updating record: " . $mysqli->error;
        $mysqli->rollBack();
        $_SESSION['message']="Error";
        $_SESSION['content']="Introduce un correo electronico valido";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}
?>