<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->
<?php
require "Conector.php";

session_start();
$sucursal = $_SESSION["username"];

#sucursal="Matriz"; /*valor por defecto asignado de tipo de sucursal*/

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
    <link rel="stylesheet" href="css/estilos_inventario.css?=b9">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="lib/alertify/css/themes/default.css">
    <script src="lib/alertify/alertify.js"></script>

    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/push.min.js"></script>
    <title>Inventario</title>
</head>

<body>
    <!--INICIO DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->
    <?php
        include('header.php');
    ?>
    <!--FIN DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->

    <!--INICIO DEL CONTENIDO DE INVENTARIO-->
    <main>
       <div class="contenedor-externo">
        <div class="contenedor-sr">
            <div class="boton-registrar">
            <?php
             if($resultado[0]=='Almacen' or $resultado[0]=='Matriz'){?>
                <button type="button" class="btn btn-success" id='registro' data-toggle="modal" data-target="#agregaModal">Nuevo producto <span
                        class="fas fa-plus-circle" style="padding-left:2px;"></span>
                </button>
                <?php
             }
            ?>
            </div>

           
            <div class="boton-verificar">
            <?php
            if($resultado[0]!='Almacen' and $resultado[0]!='Matriz'){ ?>
                <button type="button" class="btn btn-primary" id='existencias' onclick="abre_v1()">Verificar existencias<span
                        class="fas fa-check-circle" style="padding-left:4px; width: 1.1em !important;"></span>
                </button>
            <?php
             }
            ?>
            </div>
            <div class="input-buscar">
                <input type="text" class="form-control" placeholder="Búsqueda" id="input_buscar" onkeyup="Actualizar_Tabla(Tabla_Inventario, 0)">
                <img class="search-icon" src="img/buscar.png">
            </div>
         </div>
         </div>
        <div class="col-12">
            <?php
                include('inventario/index.php');
            ?>
        </div>
    </main>
    <!--FIN DEL CONTENIDO DE INVENTARIO-->

    <?php
        include('Alerta.php');
        include('inventario/verifica.php');
        include('producto.php');
        include('edita_producto.php');
    ?>
    
    
    <script src="js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script src="inventario/public/js/verificar_e.js"></script>
    <script>
        let form= new FormData();
        var a="a";
        form.append("id",a);
        fetch('get_sucursales.php',{method:'POST',body:form})
        .then(res=>res.json())
        .then(data=>{
            datos=data['datos'];
            var l=datos.length;
            var i=0;
            for(i=0;i<l;i++){
                let a = datos[i];
                var x = document.getElementById("sucu");
                var option = document.createElement("option");
                option.text = a['nombre'];
                x.add(option);
            }
        });
        function abremodal(e){
            var btn = e
            var currow = $(btn).closest('tr');
            
            
            //var codigo = currow.find('td:eq(0)').text();
            var codigo = e.codigo;

            //var clave = currow.find('td:eq(1)').text();
            var clave = e.clave;

            //var nombre = currow.find('td:eq(2)').text();
            var nombre = e.nombre;

            //var canti = currow.find('td:eq(7)').text();
            var canti = e.stock;

            
            //Sucursal en la que se encuentra el producto
            var sucursal_actual = e.sucursal;
            

            //Desactiva opción de sucursal original
            
            let sucu_select = document.getElementById("sucu");
            let options = sucu_select.options;
            let first_option = true;
            for(let i = 0; i < options.length; i++) {
                console.log(options[i].value);
                if(options[i].value == sucursal_actual) {
                    options[i].style.display = 'none';
                    
                }
                else {
                    options[i].style.display = 'block';
                    if(first_option) {
                        sucu_select.selectedIndex = i;
                        first_option = false;
                    }
                }   
            }
            document.getElementById("sucursal_actual").value = sucursal_actual;
            document.getElementById("codigo").value=codigo;
            document.getElementById("clave").value=clave;
            document.getElementById("nombre").value=nombre;
            document.getElementById("codigo").readOnly=true;
            document.getElementById("clave").readOnly=true;
            document.getElementById("nombre").readOnly=true;
            if(canti > 0) {
                document.getElementById("canti").max = canti;
                document.getElementById("canti").min = 1;
                document.getElementById("canti").placeholder = "";
                document.getElementById("canti").readOnly = false;
                document.getElementById("submit").disabled = false;
            }
            else{
                document.getElementById("canti").max = 0;
                document.getElementById("canti").min = 0;
                document.getElementById("canti").placeholder = "Sin stock";
                document.getElementById("canti").readOnly = true;
                document.getElementById("submit").disabled = true;
            }
            $("#exampleModal").modal('toggle'); //see here usage     
        }
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Dar salida a producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="salida.php" method="POST">
                <div class="form-group">
                    <label for="codigo" class="col-form-label">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo">
                </div>
                <div class="form-group">
                    <label for="clave" class="col-form-label">Clave:</label>
                    <input type="text" class="form-control" id="clave" name="clave">
                </div>
                <div class="form-group">
                    <label for="nombre" class="col-form-label">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre">
                </div>
                <div class="form-group">
                    <label for="sucu" class="col-form-label">Sucursal destino:</label>
                    <select name="sucu" id="sucu" class="form-control">
                    </select>
                </div>
                <div class="form-group">
                    <label for="canti" class="col-form-label">Cantidad que sale:</label>
                    <input type="number" min="1" max="5" required class="form-control" id="canti" name="canti">
                </div>
                <input type="hidden" id="sucursal_actual" name="sucursal_actual" />
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" id="submit" name="salida" class="btn btn-primary">Aceptar</button>
            </form>
        </div>
        </div>
    </div>
    </div>


</body>
<script src="js/all.js"></script>
</html>


<?php
mysqli_close($mysqli);
?>