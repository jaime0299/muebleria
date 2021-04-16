<?php
    require "Conector.php";
    $con="SELECT nombre FROM sucursales";
    $result=$mysqli->query($con);
    $num=$result->num_rows;

    $rows = array();
    while($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }

    echo json_encode(['datos' => $rows]);

?>