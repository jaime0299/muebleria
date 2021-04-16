
<?php
    include('filtrado_ordenamiento.php');
?>
<div class="table-responsive" style="line-height: 1 !important;">
    <table class="table" id="Tabla_Inventario">
        <thead>
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Clave</th>
                <th scope="col">Producto</th>
                <th scope="col">Marca</th>
                <th scope="col">Descripción</th>
                <th scope="col">Estrella</th> 
                <th scope="col">Precio</th>
                <th scope="col">Stock</th>
            </tr>
        </thead>
        <tbody id="Tabla_Inventario">
        </tbody>
    </table>
</div>


<!--Paginación-->
<nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center" id="Botones_Paginacion">
    </ul>
</nav>

<script>
//Se pasa el valor de la sucursal almacenado en sesión a javascript
var Sucursal = "<?php echo $sucursal; ?>";
</script>
<!-- Archivo javascript para control de la página-->
<script src="./inventario/public/js/global_vars.js"></script>
<script src="./inventario/public/js/global_functions.js"></script>
<script src="./inventario/public/js/ordena.js"></script>
<script src="./inventario/public/js/filtrado.js"></script>
<script src="./inventario/public/js/paginacion.js"></script>
<script src="./inventario/public/js/mostrar.js"></script>
