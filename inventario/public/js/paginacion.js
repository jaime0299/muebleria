let Boton_Anterior = document.getElementById("Boton_Paginacion_Anterior");
let Boton_Siguiente = document.getElementById("Boton_Paginacion_Siguiente");
let Botones_Paginacion = document.getElementById("Botones_Paginacion");


function Crear_Elemento_Boton(Texto) {
    let Elemento = document.createElement("LI");
    let Boton = document.createElement("button");
    Boton.className= "page-link";
    Boton.innerText = Texto;
    Elemento.appendChild(Boton);
    return [Elemento, Boton];
}
function Agregar_Numeracion(Cantidad, Actual) {
    
    //Cantidad de filas a mostrar
    let Divisor = 10;
    Cantidad = Math.ceil(Cantidad / Divisor);
    Botones_Paginacion.innerHTML = "";


    //Crea el botón de Anterior
    let [Elemento, Boton] = Crear_Elemento_Boton("Anterior");
    let Elemento_Desactivado = "";
    Boton.onclick = ()=>Actualizar_Tabla(Tabla_Inventario, Actual - 1);
    if(Actual === 0) Elemento_Desactivado = " disabled";
    Elemento.className = `page-item ${Elemento_Desactivado}`;
    //Añade el botón Anterior
    Botones_Paginacion.appendChild(Elemento);
    //Crea el botón de Siguiente
    [Elemento_Siguiente, Boton] = Crear_Elemento_Boton("Siguiente");
    Elemento_Desactivado = "";
    Boton.onclick = ()=>Actualizar_Tabla(Tabla_Inventario, Actual + 1);
    if(Actual + 1 === Cantidad || Cantidad === 0) Elemento_Desactivado = " disabled";
    Elemento_Siguiente.className = `page-item ${Elemento_Desactivado}`;
    


    for(let i = 0; i < Cantidad; i++) {
        let [Elemento, Boton] = Crear_Elemento_Boton(`${i + 1}`);
        let Elemento_Desactivado = "";
        if(Actual === i) {
            Elemento_Desactivado = " disabled";
        }
        Boton.onclick = ()=>Actualizar_Tabla(Tabla_Inventario, i);
        Elemento.className = `page-item ${Elemento_Desactivado}`;
        Botones_Paginacion.appendChild(Elemento);
    }
    //Añade el botón siguiente
    Botones_Paginacion.appendChild(Elemento_Siguiente);
}
