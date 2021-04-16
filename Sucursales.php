<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->
<?php
require "Conector.php";

session_start();
$sucursal = $_SESSION["username"];

if ($sucursal==''){
    header("Location: index.php");
  }

$valores_sucursal = $mysqli->query("SELECT * FROM sucursales WHERE nombre='$sucursal'");
$resultado = (mysqli_fetch_row($valores_sucursal));
if($resultado[0]!="Matriz"){?>
<style>
    div.contenedor {
        width: 19.92% !important;
    }
</style>
<?php
}
?>
<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="css/estilos_inventario.css?=bg">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="lib/alertify/css/themes/default.css">
    <script src="lib/alertify/alertify.js"></script>

    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/push.min.js"></script>
    

    <title>Sucursales</title>
</head>

<body>
    <!--INICIO DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->
    <?php
        include('header.php');
    ?>

    <main>
        <!----TABLA DE VENTAS DE SUCURSALES---->
        <div style="display:flex; justify-content:center; align-items:center; font-size:15px;">
            <div class="col-11">

                <div style="text-align:center;padding:5px;">
                    <h3 style="margin-bottom:3px; color:#131a39; margin-top:3px;" class="titulo-sv"> Movimiento de ventas de sucursales</h3>
                    <hr style="margin-bottom:0 !important; margin-top:2px !important;">
                </div>

            
                    <div class="col-12 responsive-btns" style="display:flex;align-items:end;justify-content:center;flex-direction: row;flex-wrap: nowrap;padding:5px;">
                        <div class="fil_sucursal" style="padding:5px; ">
                            <label for="" class="text-sucursal" style="padding:0 5px;"><div class="text-sucursal" style="padding:3px;">Sucursal:</div></label>
    
    
    <!--CODIGO DE LOS SELECT DE LAS OPCIONES DE MOSTRAR POR SUCURSAL----------------------------->
                               <?php
                               //$pro=0;
                               if(empty($_REQUEST)){
                                $_SESSION['sucursal_actual']="Todas";
                                $_SESSION['ordena']="codigo";

                               }
                            
                               if(!empty($_REQUEST['sucursal'])){
                                   $pro=$_REQUEST['sucursal'];
                                   $_SESSION['sucursal_actual']=$pro;
                               }
                               elseif(!empty($_SESSION['sucursal_actual'])){
                                   $pro=$_SESSION['sucursal_actual'];

                               }
                               elseif(empty($_SESSION['sucursal_actual'])){
                                    $pro="";
                               }
   // -----------------------VARIABLES DE ORDEN------------------------------------------
                               if(!empty($_REQUEST['orden'])){
                                   $orden=$_REQUEST['orden'];
                                   $_SESSION['ordena']=$orden;
                               }
                               elseif(!empty($_SESSION['ordena'])){
                                   $orden=$_SESSION['ordena'];
                               }

                               elseif(empty($_SESSION['$ordena'])){
                                   $orden="";
                               }
                               
   //-------------------------------------------------------------------------
                               $sucursal_consulta="SELECT * from sucursales where nombre not in ('Almacen')";
                               $sucursal_consulta_sql=$mysqli->query($sucursal_consulta);
                               $num=mysqli_num_rows($sucursal_consulta_sql);
             
                               ?>
                                <select class="browser-default custom-select select-resp" name="sucursal" id="search_sucursal" style="height:calc(1.4em + .6rem + 3px)!important;font-size:15px;">
                               
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

                        <div class="fil_ordenar" style="padding:5px;">
                            <label for="" class="text-ordenar" style="padding:0 5px;"><div style="padding:3px;">Ordenar:</div></label>
                            <select class="browser-default custom-select select-resp" name=""
                                style="height:calc(1.4em + .6rem + 3px)!important; font-size:15px;" id="Orden">
                                <?php $array=array('codigo','clave','nombre','marca','fecha','tipo_pago');
                                      $arrayA=array('Código','Clave','Nombre','Marca','Fecha','Pago');
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

                        <div class="fil_mostrar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-primary" id='mostrar' data-toggle="modal" data-target="#muestraModal">Mostrar sucursales</button>
                        </div>

                        <div class="fil_agregar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-success" id='registro' data-toggle="modal" data-target="#agregaModal">Agregar sucursal
                               
                            </button>

                        </div>
                        <div class="fil_agregar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-primary" id="cortes_v" data-toggle="modal"data-target="#Modal_visual">Visualizar cortes</button>
                        </div>
                        
                        <div class="fil_agregar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-primary" id='correo' data-toggle="modal" data-target="#correoModal">Correo electrónico</button>
                        </div> 
                        
                    </div>
                    <?php
                    include('Corte_Modal.php');
                    ?>

                

                <div class="table-responsive" style="line-height: 1 !important;">
                    <table class="table" id="Tabla_Inventario">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                                <th scope="col">Sucursal</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Pago</th>

                            </tr>

                            <?php
                             include "get_ventas.php";
                             
                            ?>
                    </table>

                </div>

                <div class="paginador">
                    <ul>
                        <?php
                          if(($pagina!=1)and ($num!=0)){
                        ?>
                        <li class="p-item-a"><a class="" href="?pagina=<?php echo 1;?>">◄</a> </li> 
                        <li class="p-item-s"><a class="" href="?pagina=<?php echo $pagina-1;?>">Anterior</a></li>
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
                        <li class="p-item-a"><a class="" href="?pagina=<?php echo $total_paginas;?>">►</a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </div>

            </div>
        </div>


    </main>
    <?php
        include('Alerta.php');
        include('Reg_sucursal.php');
        include('Mos_sucursal.php');
    ?>   
    
    <link rel="stylesheet" href="estiloregistro.css">
    <!-- Modal -->
    <div class="modal bd-example-modal-lg" id="correoModal" tabindex="-1" role="dialog" aria-labelledby="correoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="correoModalLabel">Correo</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            </button>
        </div>
            <div class="modal-body" style="font-size:20px;">
              <form action="correo/Correo.php" method="post" class="form-register">
                <div class="contenedor-inputs">
                    <div class="col">
                      <?php
                      $query="SELECT email FROM correo WHERE nombre='Matriz'";
                      $result = $mysqli->query($query);
                      $row = mysqli_fetch_array($result);
                      $correo_matriz = $row["email"];

                      if($correo_matriz == ""){
                      ?>
                      <input type="hidden" id="correoverificacion" name="correoverificacion" value="AGREGAR_CORREO" class="input-100">
                      <input type="email" id="correo0" name="correo0" placeholder="Introduce un correo electrónico" class="input-100" required
                      title="Ejemplo: candy@ejemplo.com">
                      <input type="email" id="correo1" name="correo1" placeholder="Confirma correo electrónico" class="input-100" required
                      title="Ejemplo: candy@ejemplo.com">
                      </div>     
                    <br>     
                </div>
                <div class="modal-footer">
                    <button type="submit" name="registrar" class="btn btn-primary"> Agregar correo </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                </div>
                      <?php
                      }
                      else{
                      ?>
                      <input type="hidden" id="correoverificacion" name="correoverificacion" value="CAMBIAR_CORREO" class="input-100">
                      <label>Correo actual:</label>
                      <fieldset disabled>                    
                        <input type="text" id="correo2" name="correo2" value="<?php echo $correo_matriz;?>" class="input-100">
                      </fieldset>
                      <input type="email" id="correo3" name="correo3" placeholder="Nuevo correo electrónico" class="input-100" required
                      title="Ejemplo: candy@ejemplo.com">
                      <input type="email" id="correo4" name="correo4" placeholder="Confirma nuevo correo electrónico" class="input-100" required
                      title="Ejemplo: candy@ejemplo.com">
                    </div>     
                    <br>     
                </div>
                <div class="modal-footer">
                    <button type="submit" name="registrar" onclick="return clicked()" class="btn btn-primary"> Cambiar correo </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                </div>
                <?php
                      }
                ?>
              </form>
            </div>
        </div>
    </div>
    </div>  
    
    <script>
        function clicked() {
            return confirm('¿Estas seguro de que quieres cambiar el correo eletrónico?');
        }
    </script> 


</body>
<script src="js/jquery.min.js"></script>
<script src="js/all.js"></script>
<script src="js/jquery.js"></script>
<script src="js/functions.js"></script>
</html>

<?php
mysqli_close($mysqli);
?>