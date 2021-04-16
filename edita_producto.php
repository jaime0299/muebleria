<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Editar</title>
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
     <div class="modal fade bd-example-modal-lg" id="editamodal" tabindex="-1" role="dialog" aria-labelledby="editaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editaModalLabel">Editar producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <form action="edita_guarda.php" method="post" class="form-register" onsubmit="return validar_edita();">
            <div class="contenedor-inputs">
                <div class="col">
                <label>Codigo:</label>
                <input type="text" id="codigo3" name="codigo3" placeholder="Código"  class="input-100" >
                <label>Clave:</label>
                <input type="text" id="clave3" name="clave3" placeholder="Clave"  class="input-100" >
                <label>Nombre:</label>
                <input type="text" id="nombre3" name="nombre3" placeholder="Nombre"  class="input-100" >
                <label>Marca:</label>
                <input type="text" id="marca3" name="marca3" placeholder="Marca"  class="input-100" >
                <label>Precio(Modificable):</label>
                <div class="input-group">
                  
                  <span class="input-group-addon">$</span>
                  <input type="number" step=".01" min="1" id="precio3" name="precio3" placeholder="Precio" class="input-100 currency form-control">
                </div>
                </div>
                <div class="col">             
                <label>Stock(Modificable):</label>
                <input type="number" min="1" id="stock3" name="stock3" placeholder="Stock" min="1" class="input-100">
                <label>Sucursal:</label>
                <input type="text" id="sucursal3" name="sucursal3" value="Almacen" placeholder="Almacen"  class="input-100" >
                <label>Fecha:</label>
                <input type="date" id="fecha3" name="fecha3" value="<?=$fecha_actual?>" readonly class="input-100">
                
                <label for="descripcion3">Descripción(Modificable):</label>
                <textarea rows="4" cols="50" id="descripcion3" name="descripcion3" class="textinput"> </textarea>
                <!--<input type="checkbox" id="chec3" name="estrella3" value="1">Estrella -->
                </div>              
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" name="edita_guarda" class="btn btn-primary">Aceptar</button>
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