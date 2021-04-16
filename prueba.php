<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css"/>
    <script src="lib/bootstrap/js/jquery.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
 
        <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Dar salida a producto
    </button>

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
                var a=datos[i];
                if (a['nombre']!="Almacen"){
                    var x = document.getElementById("sucu");
                    var option = document.createElement("option");
                    option.text = a['nombre'];
                    x.add(option); 
                    console.log(a['nombre']);
                }
            }
        });
    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                    <label for="sucu" class="col-form-label">Sucursal a donde sale:</label>
                    <select name="sucu" id="sucu" class="form-control">
                    </select>
                </div>
                <div class="form-group">
                    <label for="canti" class="col-form-label">Cantidad que sale:</label>
                    <input type="number" min="1" max="5" required class="form-control" id="canti" name="canti">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" id="submit" name="salida" class="btn btn-primary">Save changes</button>
            </form>
        </div>
        </div>
    </div>
    </div>
</body>
</html>