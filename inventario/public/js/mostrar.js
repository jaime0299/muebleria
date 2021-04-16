

//Una vez cargue la página, se ejecuta la función
window.onload = Cargar_Inventario;
var Tabla_Inventario = null;
function Cargar_Inventario() {
    Tabla_Inventario = document.getElementById("Tabla_Inventario");
    Agrega_Boton_Entrada(Tabla_Inventario);
    Actualizar_Tabla(Tabla_Inventario, 0);
}

function Actualizar_Tabla(Tabla, Indice) {
    Traer_Inventario(Indice)
    .then(Datos => {
        //Si ocurre un problema en la carga
        if(Datos === null || Datos === undefined) {
            return Actualizar_Tabla(Tabla, 0);
        }

        //Cambia la paginación
        Agregar_Numeracion(Datos["total"], Indice);

        //Agrega los datos a la tabla
        Agregar_Datos(Tabla, Datos);
    });

}

function Agrega_Boton_Entrada(Tabla) {
    let Cabecera = Tabla.rows[0];
    //Añade el nombre de la sucursal en caso de ser de Matriz
    if(Permisos_Vista_Sucursales()) {
      let Celda_Sucursal = Cabecera.insertCell();
      Celda_Sucursal.outerHTML = "<th>Sucursal</th>";
    }
    let Celda = Cabecera.insertCell();
    if(Permisos_Sucursal()) {
        Celda.outerHTML = "<th>Acción</th>";
    }else if(!Permisos_Vista_Sucursales()){
        Celda.outerHTML = "<th>Existencias</th>";
    }
}



if(Permisos_Vista_Sucursales()) {
  Orden_Columnas.push("sucursal");
  //Carga sucursales en select
  Cargar_Sucursales();
}

InicializarSelectores(
    { nombre: "SelectOrdenamiento", claves: Orden_Columnas}
)

var Input_Buscar = document.getElementById("input_buscar");

let Longitud_Columnas = Orden_Columnas.length;
function Agregar_Datos(Tabla, Datos) {
    //Limpia el contenido de la tabla (tbody)
    Eliminar_Contenido_Tabla(Tabla);


    //Obtiene el cuerpo de la tabla
    let Tbody = Tabla.getElementsByTagName('tbody')[0];
    Datos = Datos["inventario"];

    //Agrega cada fila de datos a la tabla
    Datos.forEach(Fila => {
        let Fila_HTML = Tbody.insertRow();
        Orden_Columnas.forEach(Columna => {
            let Columna_HTML = Fila_HTML.insertCell();
            if(Columna === "precio"){
                Columna_HTML.innerText = "$"+Fila[Columna];
            }else{
                Columna_HTML.innerText = Fila[Columna];
            }
            Columna_HTML.className = "text-break";
        });

        //Verifica que la sucursal tenga permitido realizar movimientos de inventario
        
        //Crea y añade el botón
        let Columna_HTML = Fila_HTML.insertCell();
        let Boton = document.createElement('BUTTON');
        Boton.className= "btn btn-primary";
        Boton.innerText = "Dar salida";
        Boton.onclick = function(){abremodal(Fila)};
        Columna_HTML.appendChild(Boton);
            
        if(!Permisos_Vista_Sucursales()){
            //Crea y añade el botón
            let Columna_HTML = Fila_HTML.insertCell();
            let Boton = document.createElement('BUTTON');
            Boton.className= "btn btn-primary";
            Boton.innerText = "Verificar existencias";
            Boton.onclick = function(){verifica2(this)};
            Columna_HTML.appendChild(Boton);
        }else if(Permisos_Vista_Sucursales()){
            let Columna_HTML = Fila_HTML.insertCell();
            let Boton = document.createElement('BUTTON');
            Boton.className= "btn btn-primary";
            Boton.innerText = "Editar";
            Boton.onclick = function(){edita(this)};
            Columna_HTML.appendChild(Boton);
        }
    });


}

function Eliminar_Contenido_Tabla(Tabla) {
    let cant = Tabla.rows.length;
    //Comienza en 1 para no eliminar las cabeceras
    for(let i = 1; i < cant; i++) {
        Tabla.deleteRow(1);
    }
}

async function Traer_Inventario(Indice) {

    //Obtiene el seleccionado y si es ascendente o descendente
    let Orden_Vars = Obtener_Orden();
    let Datos = new FormData();
    Datos.append("indice", Indice);
    Datos.append("orden", Orden_Vars.value);
    Datos.append("orden_tipo", Orden_Vars.type);
    Datos.append("filtro_stock", Obtener_Filtro_Stock());
    Datos.append("filtro_estrella", Obtener_Filtro_Estrella());
    Datos.append("filtro_sucursal", Obtener_Filtro_Sucursal());
    Datos.append("search", Input_Buscar.value);
    let res = await fetch(`${Api_Url}/index.php`, {
        method: 'POST',
        body: Datos,
        credentials: 'include'
    });
    let inventario = await res.json();
    return inventario;
}
