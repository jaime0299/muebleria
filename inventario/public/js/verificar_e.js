function edita(e){
    var btn = e
    var currow = $(btn).closest('tr');
    var codigo = currow.find('td:eq(0)').text();
    var clave = currow.find('td:eq(1)').text();
    var nombre = currow.find('td:eq(2)').text();
    var marca = currow.find('td:eq(3)').text();
    var descripcion = currow.find('td:eq(4)').text();
    var estrella = currow.find('td:eq(5)').text();
    var precio=currow.find('td:eq(6)').text();
    precio=precio.substring(1)
    var canti = currow.find('td:eq(7)').text();
    var sucursal = currow.find('td:eq(8)').text();
    document.getElementById("codigo3").value=codigo;
    document.getElementById("clave3").value=clave;
    document.getElementById("nombre3").value=nombre;
    document.getElementById("marca3").value=marca;
    document.getElementById("descripcion3").value=descripcion;
    
    document.getElementById("codigo3").readOnly=true;
    document.getElementById("clave3").readOnly=true;
    document.getElementById("nombre3").readOnly=true;
    document.getElementById("marca3").readOnly=true;
    
    
    document.getElementById("sucursal3").readOnly=true;
    document.getElementById("stock3").min=canti;
    document.getElementById("stock3").value=canti;
    document.getElementById("precio3").value=precio;
    document.getElementById("sucursal3").value=sucursal;

    $("#editamodal").modal('toggle'); //see here usage
    
}



function abre_v1(){
    $("#existenciasModal").modal('toggle'); //see here usage
}

function verifica(){
    let form= new FormData();
    var a=document.getElementById("clave_v").value;
    if (a==""){
        var alert=document.getElementById("alerta1");
        alert.style.display="block";
    }else{
        console.log(a)
        form.append("clave",a);
        fetch('api/inventario/existencias.php',{method:'POST',body:form})
        .then(res=>res.json())
        .then(data=>{
            datos=data['datos'];
            console.log(datos);
            if(datos=="error"){
                var alert=document.getElementById("alerta2");
                alert.style.display="block";
            }else if(datos=="error2"){
                var alert=document.getElementById("alerta3");
                alert.style.display="block";
            }
            else{
                document.getElementById("clave_v2").innerHTML="Clave: "+datos['clave'];
                document.getElementById("codigo_v").innerHTML="Código: "+datos['codigo'];
                document.getElementById("nombre_v").innerHTML="Nombre: "+datos['nombre'];
                document.getElementById("marca_v").innerHTML="Marca: "+datos['marca'];
                document.getElementById("cantidad_v").innerHTML="Existencias en almacén: "+datos['stock'];
                $("#existenciasModal2").modal('toggle'); //see here usage
            }
        });   
    }
}

function cierraA(){
    var alert=document.getElementById("alerta1");
        alert.style.display="none";
}

function cierraB(){
    var alert=document.getElementById("alerta2");
    alert.style.display="none";
}

function cierraC(){
    var alert=document.getElementById("alerta3");
    alert.style.display="none";
}

function verifica2(e){
    var btn = e
    var currow = $(btn).closest('tr');
    var clave = currow.find('td:eq(1)').text();

    let form= new FormData();
    form.append("clave",clave);
        fetch('api/inventario/existencias.php',{method:'POST',body:form})
        .then(res=>res.json())
        .then(data=>{
            datos=data['datos'];
            console.log(datos);
            if(datos=="error"){
                var alert=document.getElementById("alerta2");
                alert.style.display="block";
            }else if(datos=="error2"){
                var alert=document.getElementById("alerta3");
                alert.style.display="block";
            }
            else{
                document.getElementById("clave_v2").innerHTML="Clave: "+datos['clave'];
                document.getElementById("codigo_v").innerHTML="Código: "+datos['codigo'];
                document.getElementById("nombre_v").innerHTML="Nombre: "+datos['nombre'];
                document.getElementById("marca_v").innerHTML="Marca: "+datos['marca'];
                document.getElementById("cantidad_v").innerHTML="Existencias en almacén: "+datos['stock'];
                $("#existenciasModal2").modal('toggle'); //see here usage
            }
        }); 
}
