<?php
    
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(!isset($_SESSION["username"])){
            echo json_encode(["sucursales" => []]);
            return;
        }    
        include('../../Conector.php');
        $Sucursales = [];
        $Query = "SELECT nombre FROM sucursales";
        if ($Resultado = $mysqli->query($Query)) {
            /* obtener un array asociativo */
            while ($Fila = $Resultado->fetch_assoc()) {
                array_push($Sucursales, $Fila);
            }
            /* liberar el conjunto de resultados */
            $Resultado->free();
        }
        echo json_encode($Sucursales);
        $mysqli->close();
    }
?>