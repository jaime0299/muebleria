<?php
    //Archivo con las funciones necesarias para la carga
    include('carga_inventario.php');
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        if(!isset($_SESSION["username"])){
            echo json_encode(["inventario" => [[]], "total" => 0]);
            return;
        }
        $Sucursal = $_SESSION["username"];
        $Indice = $_POST["indice"];
        $Orden = ["orden" => $_POST["orden"], "tipo" => $_POST["orden_tipo"]];
        $Filtros = [
            "estrella" => $_POST["filtro_estrella"],
            "stock" => $_POST["filtro_stock"],
            "sucursal" => $_POST["filtro_sucursal"]
        ];
        $Search = $_POST["search"];
        $INVENTARIO = Cargar_Inventario($Sucursal, $Indice, $Orden, $Filtros, $Search);
        echo json_encode($INVENTARIO);
    }
?>