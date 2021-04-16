<?php 
include "Conector.php";
            if(isset($_SESSION['sucursal_actual_ent'])){
                $s=$_SESSION['sucursal_actual_ent'];
            }else{
                $s="Todas";
            }
            if(isset($_SESSION['ordena_ent'])){
                $o=$_SESSION['ordena_ent'];
            }else{
                $o="codigo";
            }
            if(isset($_SESSION['fechaI'])){
                $FechaI=$_SESSION['fechaI'];
            }else{
                $FechaI="";
            }
            if(isset($_SESSION['fechaD'])){
                $FechaD=$_SESSION['fechaD'];
            }else{
                $FechaD="";
            }
            if(isset($_SESSION['sucursal_origen'])){
                $Sucursal_Origen=$_SESSION['sucursal_origen'];
            }else{
                $Sucursal_Origen="Todas";
            }


            $FechaWhere = "";
            $ExtraFechaWhere = "";
            if(!empty($FechaI)) {
                if(!empty($FechaD)) {
                    $FechaWhere = " fecha BETWEEN '$FechaI' AND '$FechaD' ";
                    $ExtraFechaWhere = " v.fecha BETWEEN '$FechaI' AND '$FechaD' ";
                } else {
                    $FechaWhere = " fecha >= '$FechaI' ";
                    $ExtraFechaWhere = " v.fecha >= '$FechaI' ";
                }
            }
            elseif(!empty($FechaD)) {
                $FechaWhere = " fecha <= '$FechaD' ";
                $ExtraFechaWhere = " v.fecha <= '$FechaD' ";
            }

            if(!empty($s) and empty($_REQUEST['pagina'])){
                  if($s=="Todas"){
                    $extra="";
                    $where="";
                  }
                  else{
                    $extra="where v.sucur_ent='$s'";
                    $where="where sucur_ent='$s'";
                  }        
                 }
                 elseif(!empty($_REQUEST['pagina'])){
                    if($s=="Todas"){
                      $extra="";
                      $where="";
                    }
                    else{
                      $extra="where v.sucur_ent='$s'";
                      $where="where sucur_ent='$s'";
                    }
                    
                 }
                 else{
                  $s="";
                  $extra="";
                  $where="";
                 }

        if($FechaWhere != "") {
            if($extra == "" && $sucursal == "Matriz") {
                $extra .= " WHERE $ExtraFechaWhere ";
                $where .= " WHERE $FechaWhere ";
            } else {
                $extra .= " AND $ExtraFechaWhere ";
                $where .= " AND $FechaWhere ";
            }
        }

        if($Sucursal_Origen != "Todas" && $Sucursal_Origen != "") {
          if($extra == "") {
            $extra .= " WHERE ";
            $where .= " WHERE ";
          }
          else {
            $extra .= " AND ";
            $where .= " AND ";
          }
          $extra .= " v.sucur_sal = '$Sucursal_Origen' ";
          $where .= " sucur_sal = '$Sucursal_Origen' ";
        }
        if($sucursal!="Matriz"){
          $extra .= " OR v.sucur_sal = '$sucursal' ";
          $where .= " OR sucur_sal = '$sucursal' ";
        }
         //Paginador
         if($sucursal=="Matriz"){
            $consultar="SELECT COUNT(*) as total_registro from entradas $where;";
         }else{
               $consultar="SELECT COUNT(*) as total_registro from entradas $where;";
         }
         $resultado=$mysqli->query($consultar);
         $total_r= mysqli_fetch_array($resultado);
         $total_registro=$total_r["total_registro"];
         $por_pagina=10;
         if(empty($_GET['pagina'])){
             $pagina=1;
         }else{
              $pagina=$_GET['pagina'];
 
         }


         if(!empty($o)){
            if ($o=="nombre" or $o=="marca" or $o=="clave"){
              $orden="p."."$o"." ASC";
            }
            else{
              $orden="v."."$o"." ASC";
            }
            }
      elseif(empty($o)){
          $orden="v.fecha DESC";
      }


         $desde=($pagina-1)* $por_pagina;
         $total_paginas=ceil($total_registro/$por_pagina);
         if($sucursal=="Matriz"){
               $consulta_01="SELECT DISTINCT  v.id ,v.codigo,p.clave,p.nombre,p.marca, v.cantidad, v.sucur_sal, v.sucur_ent, v.fecha FROM entradas v inner join inventarios inv on v.codigo=inv.codigo  inner join productos p on inv.clave=p.clave ".$extra." ORDER BY "."$orden"." LIMIT $desde,$por_pagina;";
               //$consulta_01="SELECT codigo,sucur_sal,sucur_ent,fecha,cantidad FROM entradas LIMIT $desde,$por_pagina";
         }else{
            $consulta_01="SELECT DISTINCT  v.id ,v.codigo,p.clave,p.nombre,p.marca, v.cantidad, v.sucur_sal, v.sucur_ent, v.fecha FROM entradas v inner join inventarios inv on v.codigo=inv.codigo  inner join productos p on inv.clave=p.clave "."$extra"." ORDER BY "."$orden"." LIMIT $desde,$por_pagina;";
               //$consulta_01="SELECT codigo,sucur_sal,sucur_ent,fecha,cantidad FROM entradas WHERE sucur_ent='$sucursal' LIMIT $desde,$por_pagina";
         }
         $resultado_01=$mysqli->query($consulta_01);
         $num=mysqli_num_rows($resultado_01);
         if($num>0){
              while($fila= mysqli_fetch_array($resultado_01)){
         ?>
                   <tr>
                       <td><?php echo $fila["codigo"];?></td>
                       <td><?php echo $fila["clave"];?></td>
                       <td><?php echo $fila["nombre"];?></td>
                       <td><?php echo $fila["marca"];?></td>
                       <td><?php echo $fila["sucur_sal"];?></td>
                       <td><?php echo $fila["sucur_ent"];?></td>
                       <td><?php echo $fila["fecha"];?></td>
                       <td><?php echo $fila["cantidad"];?></td>
                   </tr>
         <?php
         
              }
         }
?>