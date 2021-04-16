 <!-- Modal -->
 <div class="modal fade" id="existenciasModal" tabindex="-1" role="dialog" aria-labelledby="existenciasModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="existenciasModalLabel">Verificar existencias de producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="/api/inventario/existencias.php" method="POST">
                <div class="form-group">
                    <label for="codigo" class="col-form-label">Clave:</label>
                    <input type="text" class="form-control" id="clave_v" name="clave_v">
                </div>
            </form>
        </div>
        <div id="alerta1" class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
            <strong>Error!</strong> Debe ingresar una clave.
            <button type="button" class="close" aria-label="Close" onclick="cierraA()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="alerta2" class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
            <strong>Aviso!</strong> No hay productos registrados con este código.
            <button type="button" class="close" aria-label="Close" onclick="cierraB()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div id="alerta3" class="alert alert-warning alert-dismissible fade show" role="alert" style="display:none;">
            <strong>Aviso!</strong> Este producto no se encuentra en almacén.
            <button type="button" class="close" aria-label="Close" onclick="cierraC()">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" id="acepta_ver" class="btn btn-primary" onclick="verifica()">Verificar</button>
        </div>
        </div>
    </div>
 </div>

    <div class="modal fade" id="existenciasModal2" tabindex="-1" role="dialog" aria-labelledby="existenciasModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="existenciasModalLabel2">Verificar existencias de producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 id="clave_v2"></h3>
                <h3 id="codigo_v"></h3>
                <h3 id="nombre_v"></h3>
                <h3 id="marca_v"></h3>
                <h3 id="cantidad_v"></h3>
                <h3 id="msj_error"></h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
            </div>
        </div>
    </div>