$(document).ready(function(){
$('#search_sucursal').change(function(e){
    e.preventDefault();
    var sistema=getUrl();
    
    location.href=sistema+'Sucursales.php?sucursal='+$(this).val();//se modificoel archivo

})



////
$('#Orden').change(function(e){
    e.preventDefault();
    var sistem=getUrl()
    location.href=sistem+'Sucursales.php?orden='+$(this).val();
}
)

$('#search_sucursal_ent').change(function(e){
    e.preventDefault();
    var sistema=getUrl();
    
    location.href=sistema+'entradas.php?sucursal='+$(this).val();//se modificoel archivo

})




////
$('#Orden_ent').change(function(e){
    e.preventDefault();
    var sistem=getUrl()
    location.href=sistem+'entradas.php?orden='+$(this).val();
}
)

//Nuevos filtros entradas
$('#Fecha_ent_I').change(function(e) {
    e.preventDefault();
    var sistem=getUrl()
    location.href=sistem+'entradas.php?fechaI='+$(this).val();
});

$('#Fecha_ent_D').change(function(e) {
    e.preventDefault();
    var sistem=getUrl()
    location.href=sistem+'entradas.php?fechaD='+$(this).val();
});
$('#search_sucursal_ori').change(function(e){
    e.preventDefault();
    var sistema=getUrl();
    location.href=sistema+'entradas.php?sucursal_origen='+$(this).val();
});
//Nuevos filtros entradas


});


function getUrl(){

    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
}