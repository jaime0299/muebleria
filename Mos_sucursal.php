<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" href="/css/estilos_mos_sucursales.css"> -->

    <title>Registro Sucursal</title>    
  </head>
<body>

    <!-- Modal --> 
    <div class="modal fade bd-example-modal-lg" id="muestraModal" tabindex="-1" role="dialog" aria-labelledby="mostrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal_tabla" style="display:block;">
        <div class="modal-header">
            <h1 class="modal-title" id="mostrarModalLabel">Sucursales</h1>
            <button type="button" class="close" data-dismiss="modalmostrar" aria-label="Close">
            <!--
              <span aria-hidden="true">&times;</span>
            -->
            </button>
        </div>
        <div class="modal-body">
          <!-- <form action="Registro_sucursal.php" method="post" class="form-register"> -->
          <div class="contenedor-inputs">
          <div class="col">
            <div class="table-responsive" style="line-height: 1 !important;">
            <div style="overflow-y:scroll; height:300px;">
              <table  id="tabla" class="table">
                <thead>
                  <tr class="d-flex">
                    <th class="col-5">Sucursal</th>
                    <th class="col-3">Acción</th>
                    <th class="col-4">Acción</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              <script>
                let tabla = document.getElementById("tabla");
                let tbody = tabla.getElementsByTagName("tbody")[0];
                fetch('get_sucursales.php')
                .then(res=> res.json())
                .then(data=> {
                  let datos = data["datos"];
                  datos.forEach(el => {
                    let a = el.nombre;
                    console.log(a);
                    if (a != 'Matriz' && a != 'Master'){ 
                      let fila = tbody.insertRow();
                      fila.className="d-flex";                                
                      let columna = fila.insertCell();
                      columna.className="col-5";
                      columna.innerHTML = `${a}`;

                      columna = fila.insertCell();
                      fila.className="d-flex"; 
                      columna.className="col-3";
                      if (a != 'Almacen'){                                  
                        let boton_Editar = document.createElement('button');
                        boton_Editar.type="button";
                        boton_Editar.className = "btn btn-primary btn-block";
                        boton_Editar.innerText = "Cambiar nombre";
                        boton_Editar.style.fontSize="small";
                        boton_Editar.type="button";
                        boton_Editar.onclick = function() {
                          let input_nombre = document.getElementById('sucursal0')
                          input_nombre.value = a;
                          let elemento = document.getElementById('modal_tabla'); 
                          elemento.style.display = 'none';
                          let elemento2 = document.getElementById('modal_editar');
                          elemento2.style.display = 'block';
                        }//{alert('Boton de editar nombre\n\n'+a);}  
                        columna.appendChild(boton_Editar);
                      }
                            
                      columna = fila.insertCell();                                
                      fila.className="d-flex"; 
                      columna.className="col-4";
                      let boton_Recuperar = document.createElement('button');
                      boton_Recuperar.type="button"; 
                      boton_Recuperar.className = "btn btn-primary btn-block";
                      boton_Recuperar.innerText = "Restablecer contraseña";
                      boton_Recuperar.style.fontSize="small";
                      boton_Recuperar.onclick = function() {
                        let input_nombre = document.getElementById('sucursal3')
                        input_nombre.value = a;
                        let elemento = document.getElementById('modal_tabla'); 
                        elemento.style.display = 'none';
                        let elemento2 = document.getElementById('modal_restablecer');
                        elemento2.style.display = 'block';
                      } //{alert('Boton de restablecer contraseña\n\n'+a);}
                      columna.appendChild(boton_Recuperar);
                    }
                  });
                });
              </script>
            </div>
            </div>
          </div>          
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-danger btn-lg" data-dismiss="modal">Salir</button>
          </div>
          <!-- </form> -->
        </div>
        </div>
        
        <div class="modal-content" id="modal_editar" style="display:none;">
        <div class="modal-header">
            <h1 class="modal-title" id="mostrarModalLabel">Cambiar de nombre</h1>
            <button type="button" class="close" data-dismiss="modalmostrar" aria-label="Close">
            <!--
              <span aria-hidden="true">&times;</span>
            -->
            </button>
        </div>
        <div class="modal-body">
          <form action="Editar_Name.php" method="post" class="form-register">
          <div class="contenedor-inputs">
            <div class="col">
              <input type="hidden" id="sucursal0" name="sucursal0" class="input-100">
              <input autofocus type="text" id="sucursal1" name="sucursal1" placeholder="Nuevo nombre de sucursal" class="input-100" required 
              pattern="[A-zÀ-ž]{1}[A-zÀ-ž0-9 _-]{0,99}" title="Ejemplo: Sucursal o Sucursal1 o Sucursal_1 o Sucursal-1">
            </div>
            <br>         
          </div>
          <div class="modal-footer">
            <button type="submit" name="registrar" class="btn btn-primary"> Aceptar </button>
            <button type="button" class="btn btn-danger" onclick="regresar_tabla_E()"> Cancelar </button>
          </div>
          </form>
        </div>
        </div>
        
        <div class="modal-content" id="modal_restablecer" style="display:none;">
        <div class="modal-header">
            <h1 class="modal-title" id="mostrarModalLabel">Restablecer contraseña</h1>
            <button type="button" class="close" data-dismiss="modalmostrar" aria-label="Close">
            <!--
              <span aria-hidden="true">&times;</span>
            -->
            </button>
        </div>
        <div class="modal-body">
          <form action="Remplazar_Password.php" method="post" class="form-register">
          <div class="contenedor-inputs">
            <div class="col">
              <input type="hidden" id="sucursal3" name="sucursal3" class="input-100">
              <input autofocus type="password" id="contra1" name="contra1" placeholder="Escribe nueva contraseña" class="input-100" required pattern="[A-Za-z0-9_-]{8,100}" 
              title="La contraseña debe contener más de 8 caracteres y menos de 100 caracteres">
              <input type="password" id="contra2" name="contra2" placeholder="Confirma nueva contraseña" class="input-100" required pattern="[A-Za-z0-9_-]{8,100}" 
              title="La contraseña debe contener más de 8 caracteres y menos de 100 caracteres">
            </div>
            <br>         
          </div>
          <div class="modal-footer">
            <button type="submit" name="registrar" class="btn btn-primary"> Aceptar </button>
            <button type="button" class="btn btn-danger" onclick="regresar_tabla_R()"> Cancelar </button>
          </div>
          </form>
        </div>
        </div>

    <script>
      function regresar_tabla_E(){
        let elemento = document.getElementById('modal_editar'); 
        elemento.style.display = 'none';
                
        let elemento2 = document.getElementById('modal_tabla'); 
        elemento2.style.display = 'block';
      }
      function regresar_tabla_R(){
        let elemento = document.getElementById('modal_restablecer'); 
        elemento.style.display = 'none';
                
        let elemento2 = document.getElementById('modal_tabla'); 
        elemento2.style.display = 'block';
      }
    </script>
    </div>
    </div>
 </body>
</html>