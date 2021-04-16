<?php
         //Paginador
         if(isset($_SESSION['sucursal_actual'])){
             $s=$_SESSION['sucursal_actual'];
         }else{
             $s="Todas";
         }
         if(isset($_SESSION['ordena'])){
             $o=$_SESSION['ordena'];
         }else{
             $o="codigo";
         }
         


         if(!empty($s) and empty($_REQUEST['pagina'])){
          if($s=="Todas"){
            $extra="";
            $where="";
          }
          else{
            $extra="where v.sucursal='$s'";
            $where="where sucursal='$s'";
          }        
         }
         elseif(!empty($_REQUEST['pagina'])){
            if($s=="Todas"){
              $extra="";
              $where="";
            }
            else{
              $extra="where v.sucursal='$s'";
              $where="where sucursal='$s'";
            }
            
         }
         else{
          $sucursal="";
          $extra="";
          $where="";
         }

         $consultar="SELECT COUNT(*) as total_registro from ventas $where;";
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
         $consulta_01="SELECT DISTINCT  v.id ,v.codigo,p.clave,p.nombre,p.marca, v.cantidad, v.total, v.sucursal, v.fecha, v.tipo_pago FROM ventas v inner join inventarios inv on v.codigo=inv.codigo  inner join productos p on inv.clave=p.clave "."".$extra." ORDER BY "."$orden"."  LIMIT $desde,$por_pagina;";
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
                       <td><?php echo $fila["cantidad"];?></td>
                       <td><?php echo "$".$fila["total"];?></td>
                       <td><?php echo $fila["sucursal"];?></td>
                       <td><?php echo $fila["fecha"];?></td>
                       <td><?php echo $fila["tipo_pago"];?></td>
                   </tr>
         <?php
         
              }
         }
?>