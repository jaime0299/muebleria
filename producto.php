<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="stylesheet" href="estiloregistro.css">
    <script src="validar.js"></script>
  </head>
<body>
    <?php
    date_default_timezone_set('America/Mexico_City');
    $fecha_actual=date("Y-m-d")
    ?>
    <?php
    require "Conector.php";
    $link=$mysqli;
    if($link){
      mysqli_select_db($link,"u481968222_muebleria");
      mysqli_query($link,"SET NAMES utf8");
     }
    ?>

     <!-- Modal -->
     <div class="modal fade bd-example-modal-lg" id="agregaModal" tabindex="-1" role="dialog" aria-labelledby="agregaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="agregaModalLabel">Agregar producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form action="registrar.php" method="post" class="form-register" onsubmit="return validar();">
            <div class="contenedor-inputs">
                <div class="col">
                <input type="text" id="codigo2" name="codigo2" placeholder="Código" class="input-100" >
                <input type="text" id="clave2" name="clave2" placeholder="Clave" class="input-100" >
                <input type="text" id="nombre2" name="nombre2" placeholder="Nombre" class="input-100" >
                <input type="text" id="marca2" name="marca2" placeholder="Marca" class="input-100" >
                <div class="input-group">
                  <span class="input-group-addon">$</span>
                  <input type="number" step=".01" min="1" id="precio2" name="precio2" placeholder="Precio" class="input-100 currency form-control">
                </div>
                <input type="number" min="1" id="stock2" name="stock2" placeholder="Stock" class="input-100">
                </div>
                <div class="col">             
                <select name="proveedor2" id="proveedor2" style="height:3em;" class="browser-default custom-select input-100"  required>
                  <option value="">Proveedor</option>
                  <?php
                    $v=$link->query("SELECT * FROM proveedores");
                    while($proveedor=mysqli_fetch_row($v)){
                  ?>
                    <option value="<?php echo $proveedor[0]?>"><?php echo $proveedor[0]?></option>
                  <?php } ?>
                </select>

                <input style="margin-top:10px;" type="text" id="sucursal2" name="sucursal2" value="<?php echo $sucursal; ?>" placeholder="Almacen" readonly class="input-100" >
                <input type="date" id="fecha2" name="fecha2" value="<?=$fecha_actual?>" class="input-100" readonly>
                <br>
                <label for="descripcion2">Descripción:</label>
                <textarea rows="4" id="descripcion2" name="descripcion2" class="textinput"> </textarea>
                <br>
                <input type="checkbox" id="chec2" name="estrella2" value="1">Estrella 
                </div>              
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="registrar" class="btn btn-primary">Aceptar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </form>
        </div>
        </div>
    </div>
    </div>
    
 </body>

 <style>
.textinput {
            float: left;
            width: 100%;
            min-height: 75px;
            outline: none;
            resize: none;
            border: 1px solid grey;
        }
</style>
</html>