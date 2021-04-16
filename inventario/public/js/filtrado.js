var SelFiltroStock = document.getElementById('select_filtro_stock');
var SelFiltroEstrella = document.getElementById('select_filtro_estrella');
var SelFiltroSucursal = document.getElementById('select_filtro_sucursal');

async function Cargar_Sucursales() {
  if(!SelFiltroSucursal) return;
  let res = await fetch(`${Api_Url}/cargar_sucursales.php`, {
      method: 'POST',
      credentials: 'include'
  });
  let Sucursales = await res.json();

  //Agrega las opciones de sucursal al select
  Sucursales.forEach(el => {
    let option = document.createElement('option');
    option.value = el.nombre;
    option.text = el.nombre;
    SelFiltroSucursal.add(option);
  });
}
function Obtener_Filtro_Stock() {
  return SelFiltroStock.options[SelFiltroStock.selectedIndex].value;
}

function Obtener_Filtro_Estrella() {
  return SelFiltroEstrella.options[SelFiltroEstrella.selectedIndex].value;
}
function Obtener_Filtro_Sucursal() {
  if(SelFiltroSucursal) {
    return SelFiltroSucursal.options[SelFiltroSucursal.selectedIndex].value;
  }
  return Sucursal;
}