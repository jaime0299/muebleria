function validar(){
    var codigo,clave,nombre,marca,descripcion,precio,stock,proveedor,sucursal,fecha,estrella;
    codigo=document.getElementById("codigo3").value;
    clave=document.getElementById("clave3").value;
    nombre=document.getElementById("nombre3").value;
    marca=document.getElementById("marca3").value;
    descripcion=document.getElementById("descripcion3").value;
    precio=document.getElementById("precio3").value;
    stock=document.getElementById("stock3").value;
    proveedor=document.getElementById("proveedor3").value;
    sucursal=document.getElementById("sucursal3".value);
    fecha=document.getElementById("fecha3").value;
    estrella=document.getElementById("chec3");
    
    if(codigo===""){
        alert("El campo codigo esta vacío");
        return false;
    }
    else if(clave===""){
        alert("El campo clave esta vacío");
        return false;
    }
    else if(nombre===""){
        alert("El campo nombre esta vacío");
        return false;
    }
    
    else if(marca===""){
        alert("El campo marca esta vacío");
        return false;
    }
    else if(descripcion===""){
        alert("El campo descripción esta vacío");
        return false;
    }
    else if(precio===""){
        alert("El campo precio esta vacío");
        return false;
    }
    else if(stock===""){
        alert("El campo stock esta vacío");
        return false;
    }
    else if(fecha===""){
        alert("El campo fecha esta vacío");
        return false;
    }

    else if(clave.length>50){
        alert("La clave es muy larga");
        return false;
    }
    else if(nombre.length>50){
        alert("El nombre es muy largo");
        return false;
    }
    else if(marca.length>50){
        alert("La marca es muy larga");
        return false;
    }
    else if(descripcion.length>100){
        alert("La descripción es muy larga");
        return false;
    }

    else if(isNaN(precio)){
        alert("El precio ingresado no es una cantidad");
        return false;
    }
    else if(codigo.length>50){
        alert("El codigo sobrepasa la longitud");
        return false;
    }
    else if(stock.length>11){
        alert("El stock sobrepasa la longitud");
        return false;
    }
    else if(isNaN(stock)){
        alert("El stock no es una cantidad");
        return false;
    }



}