<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->
<?php
require "Conector.php";

session_start();
$sucursal = $_SESSION["username"];


#$sucursal="Almacen"; /*valor por defecto asignado de tipo de sucursal*/

if ($sucursal==''){
    header("Location: index.php");
  }

$valores_sucursal = $mysqli->query("SELECT * FROM sucursales WHERE nombre='$sucursal'");
$resultado = (mysqli_fetch_row($valores_sucursal));
if($resultado[0]!="Matriz"){?>
   <style>
    div.contenedor {
          width: 19.92%!important;}
   </style>
<?php
}
?>
<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="css/estilos_inventario.css?=hu226">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    
    <title>Entradas</title>

</head>

<body>
    <!--INICIO DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->
    <?php
        include('header.php');
    ?>
    <!--FIN DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->

    <main> 
 
    <div>
    <div style="text-align:center;padding:10px;">
                    <h4>Entradas de productos</h4>
                </div>
                <div>
                    <div class="elementos" style="display:flex;align-items:end;justify-content:center;flex-direction: row;flex-wrap: wrap;padding:5px;">
                        <?php 
                            if(empty($_REQUEST)){
                                $_SESSION['fechaI'] = "";
                                $_SESSION['fechaD'] = "";
                                $_SESSION['sucursal_origen'] = "";
                            }
                            $FechaI = "";
                            $FechaD = "";
                            if(!empty($_REQUEST["fechaI"])) {
                                $_SESSION["fechaI"] = $_REQUEST["fechaI"];
                                $FechaI = $_SESSION["fechaI"];
                            }
                            elseif(!empty($_SESSION["fechaI"])) {
                            $FechaI = $_SESSION["fechaI"];
                            }
                            if(!empty($_REQUEST["fechaD"])) {
                                $_SESSION["fechaD"] = $_REQUEST["fechaD"];
                                $FechaD = $_SESSION["fechaD"];
                            }
                            elseif(!empty($_SESSION["fechaD"])) {
                                $FechaD = $_SESSION["fechaD"];
                            }
                            if(!empty($_REQUEST['sucursal_origen'])) {
                                $_SESSION['sucursal_origen'] = $_REQUEST['sucursal_origen'];
                                $Sucursal_Origen = $_SESSION['sucursal_origen'];
                            }
                            elseif(!empty($_SESSION['sucursal_origen'])) {
                                $Sucursal_Origen = $_SESSION['sucursal_origen'];
                            }
                        ?>

<?php if($sucursal=="Matriz"){ ?>
                        <div class="fil_sucursal" style="display:block;padding:5px; ">
                            <label for="" class="text-sucursal" style="padding:0 5px;"><div class="text-sucursal">Salió de:</div></label>
    
    
                            <!--CODIGO DE LOS SELECT DE LAS OPCIONES DE MOSTRAR POR SUCURSAL---------------------------->
                               <?php
                               $sucursal_consulta="SELECT * from sucursales";
                               $sucursal_consulta_sql=$mysqli->query($sucursal_consulta);
                               $num=mysqli_num_rows($sucursal_consulta_sql);
             
                               ?>
                               <?php
                               $proveedor_consulta="SELECT * from proveedores";
                               $proveedor_consulta_sql=$mysqli->query($proveedor_consulta);
                               $num_prov=mysqli_num_rows($proveedor_consulta_sql);
             
                               ?>
                                <select class="browser-default custom-select select-resp" name="sucursal" id="search_sucursal_ori" style="height:calc(1.4em + .6rem + 3px)!important;">
                               
                                <?php
                                if($num>0){
                                    
                                $dir = array();
                                $cont = 0;
                                while ($row = mysqli_fetch_array($sucursal_consulta_sql)) {
                                       $dir[$cont] = $row['nombre'];
                                       $cont++;
                                    }
                                
                                $dir[]="Todas";
                                $dir=array_reverse($dir);
                                $cont++;
                                if($num_prov > 0) {
                                    while ($row = mysqli_fetch_array($proveedor_consulta_sql)) {
                                        $dir[$cont] = $row['nombre'];
                                        $cont++;
                                    }
                                }
                                

                                foreach($dir as $valor){
                                     if($Sucursal_Origen==$valor){
                                ?>
                                    <option value="<?php echo $valor;?>" selected><?php echo $valor;?></option>
                                <?php
                                 }
                                 else{
                                ?>
                                    <option value="<?php echo $valor;?>"><?php echo $valor;?></option>
                                <?php
                                 }
                                }
                               } 
                            ?>
                            </select>
                        <!--CODIGO  FINAL DE LOS SELECT-------------------------------------------------------------->
                        </div>
                        
                        
                        <div class="fil_sucursal" style="display:block;padding:5px; ">
                            <label for="" class="text-sucursal" style="padding:0 5px;"><div class="text-sucursal">Entró a:</div></label>
    
    
    <!--CODIGO DE LOS SELECT DE LAS OPCIONES DE MOSTRAR POR SUCURSAL----------------------------->
                               <?php
                               //$pro=0;
                               if(empty($_REQUEST)){
                                $_SESSION['sucursal_actual_ent']="Todas";
                                $_SESSION['ordena_ent']="codigo";

                               }
                               
                            
                               if(!empty($_REQUEST['sucursal'])){
                                   $pro=$_REQUEST['sucursal'];
                                   $_SESSION['sucursal_actual_ent']=$pro;
                               }
                               elseif(!empty($_SESSION['sucursal_actual_ent'])){
                                   $pro=$_SESSION['sucursal_actual_ent'];

                               }
                               elseif(empty($_SESSION['sucursal_actual_ent'])){
                                    $pro="";
                               }
   // -----------------------VARIABLES DE ORDEN------------------------------------------
                               if(!empty($_REQUEST['orden'])){
                                   $orden=$_REQUEST['orden'];
                                   $_SESSION['ordena_ent']=$orden;
                               }
                               elseif(!empty($_SESSION['ordena_ent'])){
                                   $orden=$_SESSION['ordena_ent'];
                               }

                               elseif(empty($_SESSION['$ordena_ent'])){
                                   $orden="";
                               }


                               
                                
   //-------------------------------------------------------------------------
                               $sucursal_consulta="SELECT * from sucursales";
                               $sucursal_consulta_sql=$mysqli->query($sucursal_consulta);
                               $num=mysqli_num_rows($sucursal_consulta_sql);
             
                               ?>
                                <select class="browser-default custom-select select-resp" name="sucursal" id="search_sucursal_ent" style="height:calc(1.4em + .6rem + 3px)!important;">
                               
                                <?php
                                if($num>0){
                                    
                                $dir = array();
                                $cont = 0;
                                while ($row = mysqli_fetch_array($sucursal_consulta_sql)) {
                                       $dir[$cont] = $row['nombre'];
                                       $cont++;
                                    }
                                $dir[]="Todas";
                                $dir=array_reverse($dir);

                                foreach($dir as $valor){
                                     if($pro==$valor){
                                ?>
                                    <option value="<?php echo $valor;?>" selected><?php echo $valor;?></option>
                                <?php
                                 }
                                 else{
                                ?>
                                    <option value="<?php echo $valor;?>"><?php echo $valor;?></option>
                                <?php
                                 }
                                }
                               }
                            ?>
                                </select>
    <!--CODIGO  FINAL DE LOS SELECT-------------------------------------------------------------->
                        </div>

                            <?php }else{
                                $_SESSION['sucursal_actual_ent']=$sucursal;
                                if(empty($_REQUEST)){
                                    $_SESSION['ordena_ent']="codigo";
                                   }
                                if(!empty($_REQUEST['orden'])){
                                    $orden=$_REQUEST['orden'];
                                    $_SESSION['ordena_ent']=$orden;
                                }
                                elseif(!empty($_SESSION['ordena_ent'])){
                                    $orden=$_SESSION['ordena_ent'];
                                }
                                elseif(empty($_SESSION['$ordena_ent'])){
                                    $orden="";
                                }
                            } ?>
                        <div class="fil_ordenar" style="display:block;padding:5px; ">
                            <label for="" class="text-ordenar" style="padding:0 5px;"><div>Ordenar por:</div></label>
                            <select class="browser-default custom-select select-resp" name=""
                                style="height:calc(1.4em + .6rem + 3px)!important;" id="Orden_ent">
                                <?php $array=array('codigo','clave','nombre','marca','fecha');
                                      $arrayA=array('Código','Clave','Nombre','Marca','Fecha');
                                for($i = 0; $i < count($array); $i++){
                                    if ($orden==$array[$i]){
                                ?>
                                     <option value="<?php echo $array[$i];?>" selected><?php echo $arrayA[$i];?></option>
                                <?php
                                    }else{
                                    ?>
                                     <option value="<?php echo $array[$i];?>"><?php echo $arrayA[$i];?></option>
                                <?php
                                    }
                                
                            }
                                ?>
                                
                               
                            </select>

                        </div>
                        <div style="display: block;padding:5px; justify-content: center;text-align: center;">
                            <label style="display:block;">Rango de fechas</label>
                            <div class="">
                                <input <?php if($FechaI != "") echo "value=\"$FechaI\""; ?> max=<?php if($FechaD != "") { echo $FechaD; } else { echo date("Y-m-d"); } ?> id="Fecha_ent_I" type="date" onkeydown="return false" style="line-height: 1.5; height:calc(1.4em + .6rem + 3px);" class="browser-default select-resp"/>
                                <input <?php if($FechaD != "") echo "value=\"$FechaD\""; ?> <?php if($FechaI != "") echo "min=\"$FechaI\""; ?> max="<?php echo date("Y-m-d"); ?>" id="Fecha_ent_D" type="date" onkeydown="return false" style="line-height: 1.5; height:calc(1.4em + .6rem + 3px);" class="browser-default select-resp"/>
                            </div>
                        </div>
                    </div>
                </div>


        <!----TABLA DE VENTAS DE SUCURSALES---->
        <div style="display:flex; justify-content:center; align-items:center;">
            <div class="col-10">
                <div class="table-responsive" style="line-height: 1 !important;">
                    <table class="table" id="Tabla_Inventario">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Salió de</th>
                                <th scope="col">Entro a</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Cantidad</th>

                            </tr>
                            <?php
                             include "get_entradas.php";
                            ?>
                    </table>

                </div>

                <div class="paginador">
                    <ul>
                        <?php
                          if(($pagina!=1)and ($num!=0)){
                        ?>
                        <li class="p-item"><a class="" href="?pagina=<?php echo 1;?>">I<</a></li>
                        <li class="p-item-a"><a class="" href="?pagina=<?php echo $pagina-1;?>">Anterior</a></li>
                        <?php
                            }
                            for ($i=1;$i<=$total_paginas;$i++){
                                if($i==$pagina){
                                    echo "<li class='pageSelected' >".$i."</li>"; 
                                }else{
                                    echo "<li ><a href='?pagina=".$i."'>".$i."</a></li>";
                                }
                                
                            }
                            if(($pagina!=$total_paginas)and ($num!=0)){
                        ?>
                        <li class="p-item-s"><a class="" href="?pagina=<?php echo $pagina+1;?>">Siguiente</a></li>
                        <li class="p-item-a"><a class="" href="?pagina=<?php echo $total_paginas;?>">>I</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>

            </div>
        </div>
    </main>


</body>
<script src="js/jquery.js"></script>
<script src="lib/bootstrap/js/bootstrap.js"></script>
<script src="js/functions.js"></script>
<script src="js/all.js"></script>
</html>


<?php
mysqli_close($mysqli);
?>