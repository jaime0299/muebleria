<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <title>Registro Sucursal</title>
    <!-- <link rel="stylesheet" href="/css/estilos_reg_sucursales.css"> -->
    <link rel="stylesheet" href="estiloregistro.css">
  </head>
<body>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="agregaModal" tabindex="-1" role="dialog" aria-labelledby="agregaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="agregaModalLabel">Agregar sucursal</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            </button>
        </div>
            <div class="modal-body">
              <form action="registrar_sucursal.php" method="post" class="form-register"">
                <div class="contenedor-inputs">
                    <div class="col">
                      <input autofocus type="text" id="sucursal1" name="sucursal1" placeholder="Sucursal" class="input-100" required 
                      pattern="[A-zÀ-ž]{1}[A-zÀ-ž0-9 _-]{0,99}" title="Ejemplo: Sucursal o Sucursal1 o Sucursal_1 o Sucursal-1">
                      <input type="password" id="contrasena1" name="contrasena1" placeholder="Contraseña (Mínimo 8 caracteres)" class="input-100" required pattern="[A-Za-z0-9_-]{8,100}"
                      title="La contraseña debe contener más de 8 caracteres y menos de 100 caracteres">
                    </div>     
                    <br>     
                </div>
                <div class="modal-footer">
                    <button type="submit" name="registrar" class="btn btn-primary"> Aceptar </button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
                </div>
              </form>
            </div>
        </div>
    </div>
    </div>
 </body>
</html>