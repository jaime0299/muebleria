<?php

    function Obtener_Sucursal($Sucursal) {
        //Para permitir el acceso a inventario de más de una sucursal
        $Sucursales_General = ["Matriz"];
        if(in_array($Sucursal, $Sucursales_General)) {
            $Sucursal = "";
        }
        return $Sucursal;
    }
    function Traer_Inventario_BD($Sucursal, $Indice, $Orden, $Filtros, $Search) {
        include('../../Conector.php');
        $Cantidad_Indice = 10;
        $Indice_Inicio = $Cantidad_Indice * $Indice;
        $Sucursal = Obtener_Sucursal($Sucursal);
        
        $Orden_Clave = $Orden["orden"];
        $Tipo_Orden = $Orden["tipo"] == 1 ? 'desc' : 'asc';
        $Campos = "
        inventarios.clave as clave,
        inventarios.codigo as codigo,
        inventarios.stock as stock,
        inventarios.entrada as entrada,
        inventarios.sucursal as sucursal,
        productos.nombre as nombre,
        productos.marca as marca,
        productos.descripcion as descripcion,
        productos.estrella as estrella,
        productos.precio as precio
        ";
        $Query =
            "SELECT $Campos
            FROM inventarios
            INNER JOIN productos
            ON inventarios.clave = productos.clave
            WHERE $Filtros
            AND CONCAT(nombre, marca, descripcion) LIKE '%$Search%' 
            ORDER BY $Orden_Clave $Tipo_Orden
            LIMIT $Indice_Inicio, $Cantidad_Indice
        ";


        $Inventario = [];
        if ($Resultado = $mysqli->query($Query)) {
            /* obtener un array asociativo */
            while ($Fila = $Resultado->fetch_assoc()) {
                array_push($Inventario, $Fila);
            }
            /* liberar el conjunto de resultados */
            $Resultado->free();
        }
        $mysqli->close();
        return $Inventario;
    }

    function Traer_Total($Sucursal, $Filtros, $Search) {
        include('../../Conector.php');
        $Sucursal = Obtener_Sucursal($Sucursal);
        $Query =
        "SELECT COUNT(DISTINCT codigo, sucursal) as conteo
        FROM inventarios
        INNER JOIN productos
        ON inventarios.clave = productos.clave
        WHERE $Filtros
        AND CONCAT(nombre, marca, descripcion) LIKE '%$Search%' 
        ";
        $Total = 0;
        if($Resultado = $mysqli->query($Query)) {
            $Fila = $Resultado->fetch_assoc();
            $Total = $Fila["conteo"];
        }
        $mysqli->close();
        return $Total;
    }

    //Crea las query con los datos del frontend
    function Procesar_Filtros($Filtros, $Sucursal) {
        $Filtros_Procesados = "";
        if($Filtros["stock"] == "1") {
            $Filtros_Procesados .= " AND stock > 0";
        }
        else if($Filtros["stock"] == "2") {
            $Filtros_Procesados .= " AND stock = 0";
        }
        

        if($Filtros["estrella"] == "1") {
            $Filtros_Procesados .= " AND LOWER(estrella) IN ('sí','si')";
        }
        else if($Filtros["estrella"] == "2") {
            $Filtros_Procesados .= " AND LOWER(estrella) = 'no'";
        }
        
        
        if($Filtros["sucursal"] == "0") {
            $Filtros_Procesados = "sucursal LIKE '%" . Obtener_Sucursal($Sucursal) . "%'" . $Filtros_Procesados;
        }
        else {
            $Filtros_Procesados = "sucursal = '" . $Filtros["sucursal"] . "'" . $Filtros_Procesados;
        }

        return $Filtros_Procesados;
    }

    function Cargar_Inventario($Sucursal, $Indice, $Orden, $Filtros, $Search) {
        $Filtros_Procesados = Procesar_Filtros($Filtros, $Sucursal);
        $Inventario = Traer_Inventario_BD($Sucursal, $Indice, $Orden, $Filtros_Procesados, $Search);
        $Total = Traer_Total($Sucursal, $Filtros_Procesados, $Search);
        $Inventario = array_merge(["inventario" => $Inventario], ["total" => $Total]);
        return $Inventario;
    }
?>
