<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->
<?php
require "Conector.php";

session_start();
//$sucursal = $_SESSION["username"];
$sucursal="Matriz";

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
    <link rel="stylesheet" href="css/estilos_inventario.css?=fr7">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="lib/alertify/css/themes/default.css">
    <script src="lib/alertify/alertify.js"></script>

    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/push.min.js"></script>
    

    <title>Proveedores</title>
</head>

<body>
    <!--INICIO DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->
    <?php
        include('header.php');
    ?>

    <main>
        <!----TABLA DE VENTAS DE SUCURSALES---->
        <div style="display:flex; justify-content:center; align-items:center;">
            <div class="col-11">

                <div style="text-align:center;padding:7px;">
                    <h1 style="margin-bottom:3px; color:#131a39;" class="titulo-sv"> Tabla de proveedores</h1>
                    <hr style="margin-bottom:0 !important; margin-top:2px !important;">
                </div>

                <div>
                    <div class="elementos" style="display:flex;align-items:end;justify-content:center;flex-direction: row;flex-wrap: nowrap;padding:5px;">
                        <!--
                        <div class="fil_mostrar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-primary" id='mostrar' data-toggle="modal" data-target="#muestraModal">Mostrar sucursales</button>
                        </div>
                        -->
                        <div class="fil_agregar_sucursal" style="padding:5px;">
                            <button type="button" class="btn btn-success" id='registro' data-toggle="modal" data-target="#agregaModal">Agregar proveedor</button>
                        </div>
                    </div>
                </div>
                <div class="table-responsive" style="line-height: 1 !important;">
                    <div style="overflow-y:scroll; height:400px;">
                        <table id="tabla" class="table">
                            <thead>
                            <tr class="d-flex">
                                <th class="col-6">Proveedor</th>
                                <th class="col-3">Telefono</th>
                                <th class="col-3">Acción</th>
                                <!-- <th class="col-3">Acción</th> -->
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <script>
                            let tabla = document.getElementById("tabla");
                            let tbody = tabla.getElementsByTagName("tbody")[0];
                            fetch('get_proveedores.php')
                            .then(res=> res.json())
                            .then(data=> {
                            let datos = data["datos"];
                            datos.forEach(el => {
                                let a = el.nombre;
                                //console.log(a);
                                let fila = tbody.insertRow();
                                fila.className="d-flex";                                
                                let columna = fila.insertCell();
                                columna.className="col-6";
                                columna.innerHTML = `${a}`;

                                let b = el.telefono;
                                //console.log(b);
                                columna = fila.insertCell();
                                fila.className="d-flex"; 
                                columna.className="col-3";
                                columna.innerHTML = `${b}`;

                                columna = fila.insertCell();
                                fila.className="d-flex"; 
                                columna.className="col-3";                               
                                let boton_Editar = document.createElement('button');
                                boton_Editar.type="button";
                                boton_Editar.className = "btn btn-warning btn-block";
                                boton_Editar.innerText = "Editar";
                                boton_Editar.type="button";
                                boton_Editar.onclick = function() {
                                    let input_nombre = document.getElementById('proveedor0')
                                    input_nombre.value = a;
                                    let input_telefono = document.getElementById('telefono0')
                                    input_telefono.value = b;

                                    let input_nombre2 = document.getElementById('proveedor2')
                                    input_nombre2.value = a;
                                    let input_telefono2 = document.getElementById('telefono2')
                                    input_telefono2.value = b;

                                    $("#editarModal").modal('toggle'); //see here usage  
                                }//{alert('Boton de editar\n\n'+a);}  
                                columna.appendChild(boton_Editar);
                                        
                                /*columna = fila.insertCell();                                
                                fila.className="d-flex"; 
                                columna.className="col-3";
                                let boton_Recuperar = document.createElement('button');
                                boton_Recuperar.type="button"; 
                                boton_Recuperar.className = "btn btn-danger btn-block";
                                boton_Recuperar.innerText = "Eliminar";
                                boton_Recuperar.onclick = function() {
                                    let input_nombre3 = document.getElementById('proveedor3')
                                    input_nombre3.value = a;

                                    let input_nombre4 = document.getElementById('proveedor4')
                                    input_nombre4.value = a;
                                    let input_telefono4 = document.getElementById('telefono4')
                                    input_telefono4.value = b;

                                    $("#eliminarModal").modal('toggle'); //see here usage  
                                }//{alert('Boton de eliminar\n\n'+a);}
                                columna.appendChild(boton_Recuperar);  */                              
                            });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <?php
        include('Alerta.php');
    ?> 

    <link rel="stylesheet" href="estiloregistro.css">
    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="agregaModal" tabindex="-1" role="dialog" aria-labelledby="agregaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="agregaModalLabel">Agregar proveedor</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            </button>
        </div>
            <div class="modal-body">
              <form action="Proveedor.php" method="post" class="form-register"">
                <div class="contenedor-inputs">
                    <div class="col">
                      <input autofocus type="text" id="proveedor1" name="proveedor1" placeholder="Proveedor" class="input-100" required 
                      pattern="[A-zÀ-ž]{1}[A-zÀ-ž0-9 _-]{0,99}" title="Ejemplo: Proveedor o Proveedor1 o Proveedor_1 o Proveedor-1">
                      <input type="text" id="telefono1" name="telefono1" placeholder="Telefono" class="input-100" required 
                      pattern="[0-9]{10}" title="Ejemplo: 4371008854">
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="editarModalLabel">Editar proveedor</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            </button>
        </div>
        <div class="modal-body">
            <form action="Proveedor.php" method="post" class="form-register"">
            <div class="contenedor-inputs">
                <div class="col">
                    <input type="hidden" id="proveedor0" name="proveedor0" class="input-100">
                    <input type="hidden" id="telefono0" name="telefono0" class="input-100">
                    <label for="N_P" class="col-form-label">Proveedor:</label>
                    <input autofocus type="text" id="proveedor2" name="proveedor2" placeholder="Nuevo nombre de proveedor" class="input-100" required 
                    pattern="[A-zÀ-ž]{1}[A-zÀ-ž0-9 _-]{0,99}" title="Ejemplo: Proveedor o Proveedor1 o Proveedor_1 o Proveedor-1">
                    <label for="T_P" class="col-form-label">Telefono:</label>
                    <input type="text" id="telefono2" name="telefono2" placeholder="Nuevo numero telefonico" class="input-100" required 
                    pattern="[0-9]{10}" title="Ejemplo: 4371008854">
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
    </div>  <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="editarModal" tabindex="-1" role="dialog" aria-labelledby="editarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="editarModalLabel">Editar proveedor</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            </button>
        </div>
        <div class="modal-body">
            <form action="Proveedor.php" method="post" class="form-register"">
            <div class="contenedor-inputs">
                <div class="col">
                    <input type="hidden" id="proveedor0" name="proveedor0" class="input-100">
                    <input type="hidden" id="telefono0" name="telefono0" class="input-100">
                    <label for="N_P" class="col-form-label">Proveedor:</label>
                    <input autofocus type="text" id="proveedor2" name="proveedor2" placeholder="Nuevo nombre de proveedor" class="input-100" required 
                    pattern="[A-zÀ-ž]{1}[A-zÀ-ž0-9 _-]{0,99}" title="Ejemplo: Proveedor o Proveedor1 o Proveedor_1 o Proveedor-1">
                    <label for="T_P" class="col-form-label">Telefono:</label>
                    <input type="text" id="telefono2" name="telefono2" placeholder="Nuevo numero telefonico" class="input-100" required 
                    pattern="[0-9]{10}" title="Ejemplo: 4371008854">
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

    <!-- Modal -->
    <!-- <div class="modal fade bd-example-modal-lg" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="eliminarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title" id="eliminarModalLabel">Eliminar proveedor</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <!--  
            <span aria-hidden="true">&times;</span>
             -->
            <!-- </button>
        </div>
        <div class="modal-body">
            <form action="Proveedor.php" method="post" class="form-register"">
            <div class="contenedor-inputs">
                <div class="col">
                <input type="hidden" id="proveedor3" name="proveedor3" class="input-100">
                    <fieldset disabled>
                        <input type="text" id="proveedor4" name="proveedor4" class="input-100">
                        <input type="text" id="telefono4" name="telefono4" class="input-100">
                    </fieldset>
                </div>     
                <br>     
            </div>
            <div class="modal-footer">
                <button type="submit" name="registrar" onclick="return clicked();" class="btn btn-primary"> Confirmar </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
            </div>
            </form>
        </div>
        </div>
    </div>
    </div> -->

    <script>
        function clicked(Pro) {
            return confirm('¿Estas seguro de que quieres eliminar el proveedor?');
        }
    </script>

</body>
<scrip src="js/all.js"></scrip>
<script src="js/functions.js"></script>
</html>

<?php
mysqli_close($mysqli);
?>