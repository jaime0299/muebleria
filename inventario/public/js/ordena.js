String.prototype.capitalize = function() {
  return this.charAt(0).toUpperCase() + this.slice(1);
}
var SelOrden = null;
var SelOrden = null;

//Muestra de texto
let Texto_Claves = {
  "codigo": "Código",
  "descripcion": "Descripción",
  "estrella": "Producto estrella"
};
//["codigo", "clave", "nombre", "marca", "descripcion", "estrella", "precio", "stock"];
function Obtener_Texto_Clave(clave) {
  if(clave in Texto_Claves) {
    return Texto_Claves[clave];
  }
  return clave;
}

function InicializarSelectores(Selector) {
  SelOrden = document.getElementById(Selector.nombre);
  Selector.claves.forEach(el => {
    let Texto = Obtener_Texto_Clave(el).capitalize();
    let option = document.createElement('option');
    option.value = el;
    option.text = `${Texto} Ascendente`;
    option.typeOrder = 0;
    SelOrden.add(option);


    option = document.createElement('option');
    option.value = el;
    option.text = `${Texto} Descendente`;
    option.typeOrder = 1;
    SelOrden.add(option);
  });
}

function Obtener_Orden() {
  if(SelOrden !== null){
    let Selected = SelOrden.options[SelOrden.selectedIndex];
    return {
      value: Selected.value,
      type: Selected.typeOrder
    }
  }
  return null;
}
