<?php
    require "Conector.php";
    session_start();
    if (!isset($_SESSION['username'])){
        header("index.php");
    }else{
        $sucursal=$_SESSION['username'];
        $valores_sucursal = $mysqli->query("SELECT * FROM sucursales WHERE nombre='$sucursal'");
        $resultado = (mysqli_fetch_row($valores_sucursal));
        if($resultado[0]!="Matriz"){?>
        <style>
            div.contenedor {
                width: 19.92%!important;}
        </style>
        <?php
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Punto de venta</title>
    <link rel="shortcut icon" href="img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="css/estilos_inventario.css?=vn">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">

    <!-- ALERTIFY -->
    <link rel="stylesheet" href="lib/alertify/css/alertify.css">
    <link rel="stylesheet" href="lib/alertify/css/themes/default.css">
    <script src="lib/alertify/alertify.js"></script>
</head>
<body>
    <?php
        include('header.php');
    ?>
    <main>
       
        <div class="row" style="text-align:left;padding:10px;max-width:2000px;">

            <div class="col-11" style="display:grid; grid-template-columns: 75% 25%; justify-content:left; align-items:left;">
                <div class="table-responsive" style="line-height: 1 !important;">
                    <table class="table" id="caja">
                        <thead>
                            <tr>
                                <th scope="col">Código</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col">Precio unitario</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Total</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="caja_body">
                        </tbody>
                    </table>
                </div>
                
              
                <div class="Agrega" style='margin-left:20%; margin-top:20%;'>
                    <div style="display:flex; align-items:right; justify-content:right;"><div style="padding-bottom:5px;"><button type="button" class="btn btn-primary" id='mostrar' data-toggle="modal" data-target="#Modal_corte">Generar corte de caja </button></div></div>
                    <h3>Agrega a caja</h3>
                    <label class="col-form-label" for="codigo">Código del producto</label>
                    <input class="form-control" type="text" name="codigo" id="codigo">
                    <label class="col-form-label" style="margin-top:10px;" for="canti">Cantidad del producto</label>
                    <input class="form-control" type="number" min="1" name="canti" id="canti">
                    <button style="margin-top:10px;" onclick="agrega()" class="btn btn-primary">Agrega</button>
                    <h2 style="margin-top:20px;" id="total">Total:</h2>
                    <h5>Tipo de pago:</h5>
                    <div class="custom-control custom-radio">
                    <input class="custom-control-input" type="radio" name="tipo" id="efec" value="Efectivo" checked>
                    <label class="custom-control-label" for="efec">Efectivo</label>
                    </div>
                    <div class="custom-control custom-radio"">
                    <input class="custom-control-input" type="radio" name="tipo" id="tran" value="Transferencia">
                    <label class="custom-control-label" for="tran">Transferencia</label>
                    </div>
                    <button style="margin-top:20px;font-size:24px;" onclick="confirma_V()" class="btn btn-success">Vender caja</button>
                </div>
            </div>
        </div>
    </main>
</body>
<?php
include('Corte_Modal.php');
?>
<script src="js/jquery.js"></script>
<script src="lib/bootstrap/js/bootstrap.js"></script>
<script>
    var articulos=[];
    var cantidades=[];
    var totales=[];
    var con=0;
    var total_f=0;
    let Tbody = document.getElementById("caja_body");
    var suc='<?php echo $sucursal; ?>';
    function agrega(){
        var codigo = document.getElementById("codigo").value;
        var canti = document.getElementById("canti").value;
        if(articulos.includes(codigo)){
            var repetido=true;
            var index_repe=articulos.indexOf(codigo);
            console.log(articulos);
            canti=parseInt(canti);
            canti=canti+cantidades[index_repe];
        }else{
            var repetido=false;
        }
        if(codigo=="" || canti==""){
            alertify.alert("Error","Favor de llenar todos los datos.");
        }else{
            let form= new FormData();
            form.append("codigo",codigo);
            form.append("sucu",suc);
            fetch('get_datos.php',{method:'POST',body:form})
            .then(res=>res.json())
            .then(data=>{
                if(data['datos']!=null){
                    datos=data['datos'];
                    if(repetido==true){
                        var stock=parseInt(datos['stock']);
                        if (stock<canti){
                            alertify.alert("Error","No hay suficiente producto.");
                        }else{
                            var tabla=document.getElementById("caja");
                            tabla.rows[index_repe+1].cells[5].innerHTML=canti;
                            cantidades[index_repe]=canti;
                            canti=parseInt(canti);
                            var total=canti*datos['precio'];
                            tabla.rows[index_repe+1].cells[6].innerHTML="$"+total;
                            total_f=total_f-totales[index_repe];
                            totales[index_repe]=total;
                            total_f=total_f+total;
                            document.getElementById("total").innerText="Total: $"+total_f;
                        }
                    }else{
                        canti=parseInt(canti);
                        var stock=parseInt(datos['stock']);
                        if (stock<canti){
                            alertify.alert("Error","No hay suficiente producto.");
                        }else{
                            articulos[con]=codigo;
                            cantidades[con]=canti;
                            let Fila_HTML = Tbody.insertRow();
                            for(var key in datos){
                                if(key!="stock"){
                                    var obj = datos[key];
                                    let Columna_HTML = Fila_HTML.insertCell();
                                    if(key === "precio"){
                                        Columna_HTML.innerText = "$"+datos[key];
                                    }else{
                                        Columna_HTML.innerText = datos[key];
                                    }
                                    Columna_HTML.className = "text-break";
                                }
                            }
                            Columna_HTML = Fila_HTML.insertCell();
                            Columna_HTML.innerText = canti;
                            Columna_HTML = Fila_HTML.insertCell();
                            var total=canti*datos["precio"];
                            totales[con]=total;
                            con++;
                            Columna_HTML.innerText = "$"+total;
                            Columna_HTML = Fila_HTML.insertCell();
                            let Boton = document.createElement('BUTTON');
                            Boton.className= "btn btn-danger";
                            Boton.innerText = "Quitar";
                            Boton.onclick = function(){quita(this)};
                            Columna_HTML.appendChild(Boton);
                            total_f=total_f+total;
                            document.getElementById("total").innerText="Total: $"+total_f;
                        }
                    }
                }else{
                    alertify.alert("Error","No se encontró el producto.");
                }
            });
        }
    }

    function confirma_V(){
        if(articulos.length==0){
            alertify.alert('Error','No hay productos en caja.');
        }else{
            alertify.confirm('Confirmar venta', '¿Desea realizar esta venta', function(){ vende(); }
                , function(){ alertify.error('No se ha realizado la venta')});
        }
    }

    function vende(){
        if(articulos.length==0){
            alertify.alert('No hay productos en caja.');
        }else{
            if(document.getElementById("efec").checked){
                var tipo="Efectivo";
            }else{
                var tipo="Transferencia";
            }
            for(var i=0;i<con;i++){
                let form= new FormData();
                form.append("codigo_venta",articulos[i]);
                form.append("sucu",suc);
                form.append("canti",cantidades[i]);
                form.append("total",totales[i]);
                form.append("tipo",tipo);
                fetch('get_datos.php',{method:'POST',body:form})
                .then(res=>res.json())
                .then(data=>{
                    datos=data['datos'];
                    console.log(datos);
                    if(datos=="no"){
                        alertify.success('Se ha realizado con éxito la venta.');
                    }else{
                        alertify.error('Ha ocurrido un error.');
                    }
                });
            }
            //Las siguientes lineas sirven para limpiar la tabla y las variables que usa
            //Si llega a causar problemas borren eso y pongan que se recargue la página
            $("#caja_body").empty();
            articulos=[];
            cantidades=[];
            totales=[];
            con=0;
            document.getElementById("total").innerText="Total:";
            document.getElementById("codigo").value="";
            document.getElementById("canti").value="";
            total_f=0;
            //Aqui termina
        }
    }

    function quita(e){
        var i = e.parentNode.parentNode.rowIndex;
        document.getElementById("caja").deleteRow(i);
        articulos.splice(i-1,1);
        cantidades.splice(i-1,1);
        total_f=total_f-totales[i-1];
        totales.splice(i-1,1);
        con--;
        if(total_f==0){
            document.getElementById("total").innerText="Total:";
        }else{
            document.getElementById("total").innerText="Total: $"+total_f;
        }
    }
</script>
</html>