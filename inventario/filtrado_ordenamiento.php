<!-- Ordenamiento -->
<div class="">
  <div class="form-group row align-items-center justify-content-center mb-0">
    <label class="col-3 col-md-2 col-form-label text-center pt-0 py-1" for="SelectOrdenamiento" style="font-size:13px;">Ordenar</label>
    <div class="row col-9 col-md-4 justify-content-center"> 
      <select id="SelectOrdenamiento" onchange="Actualizar_Tabla(Tabla_Inventario, 0)" class="form-control"></select>
    </div>
  <label class="col-3 col-md-2 col-form-label text-center pt-0 py-1" for="select_filtro_estrella" style="font-size:13px;">Estrella</label>
    <div class="row col-9 col-md-4 justify-content-center">
      <select id="select_filtro_estrella" onchange="Actualizar_Tabla(Tabla_Inventario, 0)" class="form-control">
        <option value="0">Todos</option>
        <option value="1">Sí</option>
        <option value="2">No</option>
      </select>
    </div>
    <label class="col-3 col-md-2 col-form-label text-center pt-0 py-1" for="select_filtro_stock" style="font-size:13px;">Stock</label>
    <div class="row col-9 col-md-4 justify-content-center">
      <select id="select_filtro_stock" onchange="Actualizar_Tabla(Tabla_Inventario, 0)" class="form-control">
        <option value="0">
          Todos
        </option>
        <option value="1">
          Sí
        </option>
        <option value="2">
          No
        </option>
      </select>
    </div>

  <!-- Filtrado en caso de sucursal igual que Matriz -->
  <?php if($sucursal == 'Matriz'): ?>
    <label class="col-3 col-md-2 col-form-label text-center pt-0 py-1" for="select_filtro_sucursal" style="font-size:13px;">Sucursal</label>
    <div class="row col-9 col-md-4 justify-content-center">
      <select id="select_filtro_sucursal" onchange="Actualizar_Tabla(Tabla_Inventario, 0)" class="form-control">
        <option value="0">
          Todas
        </option>
      </select>
    </div>
  <?php endif; ?>

</div>