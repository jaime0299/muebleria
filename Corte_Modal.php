<?php
$sucursal = $_SESSION["username"];


if ($sucursal==''){
    header("Location: index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container modal-container">
        <div class="modal fade" tabindex="-1" id="Modal_corte" style="padding-left:0 !important;">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">Corte de caja</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </div>
                    <form action="registrar_corte.php" method="post" name="formula" class="form-corte" target="_blank">
                        <div class="modal-body">

                            <?php
                               require "Conector.php";

//-----------------------------------------------FECHA INICIAL------------------------------------------------
                               
                               $sucursal = $_SESSION["username"];
                              
                               

//-------------------------------------------------ULTIMA FECHA----------------------------------------------
                               
                               //$fecha_ini = date("d/m/Y", strtotime($fecha_ini));
                               //$fecha_fin=date("d/m/Y", strtotime($fecha_fin));
                               
                            

                             ?>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Sucursal </label>
                                        <input type="text" class="form-control" name="n_sucursal"
                                            value="<?php echo $sucursal;?>" readonly="readonly">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Desde:</label>
                                        <input type="date" class="form-control" name="f_inicial"
                                            value=""  id="bd-desde" name="Desde" max="<?php $hoy=date("Y-m-d"); $hoy2=strtotime($hoy."- 0 days"); echo date("Y-m-d",$hoy2);?>" onchange="fecha_n()" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Hasta: </label>
                                        <input type="date" class="form-control" name="f_final"
                                            value=""  id="bd-hasta" name="Hasta"  max="<?php $hoy=date("Y-m-d"); $hoy2=strtotime($hoy."- 0 days"); echo date("Y-m-d",$hoy2);?>"  onchange="fecha_d()" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Nombre del encargado</label>
                                        <input type="text" class="form-control" pattern="^[a-zA-Z\sñáéíóúÁÉÍÓÚ .]*$"
                                            name="usuario" maxlength="79" required>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">

                            <button type="submit" id="id_generar_corte" name="registrar" class="btn btn-success">
                                Generar PDF </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>










    <div class="container modal-container">
        <div class="modal fade" tabindex="-1" id="Modal_visual" style="padding-left:0 !important;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="agregaModalLabel">Cortes de sucursales</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">
                    <?php
                      require "Conector.php";
                    ?>  
                        <style type="text/css">
                            thead tr th {
                                position: sticky;
                                top: 0;
                                z-index: 10;
                               

                            }


                        </style>
                        <div class="table-responsive " style="line-height: 1 !important; overflow:auto;height:250px;">
                            <table class="table"  id="Tabla_cortes">
                                <thead style="background-color: #ffff;">
                                    <tr style="background-color: #ffff;">
                                        <th style="background-color: #ffff;" scope="col">Sucursal</th>
                                        <th style="background-color: #ffff;" scope="col">Realizó</th>
                                        <th style="background-color: #ffff;" scope="col">Desde</th>
                                        <th style="background-color: #ffff;" scope="col">Hasta</th>
                                        <th style="background-color: #ffff;" scope="col">Ver reporte</th>
                                
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $consulta_corte="SELECT * from cortes";
                                $resul_corte=$mysqli->query($consulta_corte);
                                $num=mysqli_num_rows($resul_corte);
                                if($num>0){
                                   while($fila= mysqli_fetch_array($resul_corte)){
                                    ?>
                                     <tr>
                                      <td><?php echo $fila["Sucursal"];?></td>
                                      <td><?php echo $fila["usuario"];?></td>
                                      <td><?php echo $fila["fecha_ini"];?></td>
                                      <td><?php echo $fila["fecha_fin"];?></td>
                                      <td><?php echo "<div> <a class='' style='background: #1d57c2; padding:5px; border-radius:4px; text-decoration: none; color:white;' cursor:default; href='Visualizar_cortes.php?id=".$fila['id']."' target='_blank'>Visualizar</a></div>";?></td>
                                     
                                     </tr>
                                    <?php
         
                                   }
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Cerrar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>
<script>
        function fecha_n(){
            var min = document.getElementById("bd-desde").value;
            if (min==""){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                 if(dd<10){
                        dd='0'+dd
                    } 
                    if(mm<10){
                        mm='0'+mm
                    } 
                
                today = yyyy+'-'+mm+'-'+dd;
                document.getElementById("bd-hasta").setAttribute("max", today);
            }
            document.getElementById("bd-hasta").setAttribute("min", min);
            
            
        }
        function fecha_d(){
            var max = document.getElementById("bd-hasta").value;
            if (max==""){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                 if(dd<10){
                        dd='0'+dd
                    } 
                    if(mm<10){
                        mm='0'+mm
                    } 
                
                today = yyyy+'-'+mm+'-'+dd;
                document.getElementById("bd-desde").setAttribute("max", today);
            }else{
                document.getElementById("bd-desde").setAttribute("max", max);
            }
            
        }

</script>