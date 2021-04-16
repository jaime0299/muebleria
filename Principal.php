<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->
<?php
require "Conector.php";

session_start();
$sucursal = $_SESSION["username"];


#$sucursal="Almacen"; /*valor por defecto asignado de tipo de sucursal*/

if ($sucursal==''){
    header("Location: index.php");
  }

$valores_sucursal = $mysqli->query("SELECT * FROM sucursales WHERE nombre='$sucursal'");
$resultado = (mysqli_fetch_row($valores_sucursal));
if($resultado[0]!="Matriz"){?>
<style>
    div.contenedor {
        width: 19.92% !important;
    }
</style>
<?php
}
?>
<!------ FIN DE LA CONSULTA DE SUCURSAL LOGEADA-->


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="img/logo_01.png" type="image/png">
    <link rel="stylesheet" href="css/estilos_inventario.css?=vnh">
    <link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
    <title>Mueblerías El Porvenir</title>
</head>
<script language="JavaScript">
    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        console.log(hr);
        if (hr <= 6 || hr >= 19) {
            document.body.style.background = "linear-gradient(0deg, #4C867E 0%, #38093C 70%)";
        }
        ap = (hr < 12) ? "<span>AM</span>" : "<span>PM</span>";
        hr = (hr == 0) ? 12 : hr;
        hr = (hr > 12) ? hr - 12 : hr;
        //Add a zero in front of numbers<10
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

        var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
            'Noviembre', 'Diciembre'
        ];
        var days = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        var curWeekDay = days[today.getDay()];
        var curDay = today.getDate();
        var curMonth = months[today.getMonth()];
        var curYear = today.getFullYear();
        var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
        document.getElementById("date").innerHTML = date;

        var time = setTimeout(function () {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
</script>

<body onload="startTime()">
    <!--INICIO DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->
    <?php
        include('header.php');
    ?>
    <!--FIN DE ENCABEZADO DEL MENU DE NAVEGACIÓN-->

    <main>
        <div class="user_log" style="padding:10px; display:flex;flex-direction:row; justify-content:flex-end;"><img  style="width:45px;height:auto; background:#AFACCA; border-radius:10px 0 0 10px;" src="img/user.png" alt=""><div style="background:#AFACCA; border-radius:0 10px 10px 0;"><h5 style="padding-top:5px;padding-left:10px;padding-right:10px; margin-top:5px; color:white;">Usuario: <?php echo $sucursal;?></h5></div></div>
        <div style="display:flex;justify-content:center;align-items:center;padding-bottom:20px;"><img class="img-principal" style="width:43%;height:auto;"
                src="img/Principal_logo.png" alt=""></div>
        <div id="clockdate" style=" padding-top: 20px; padding-left:30px;">
                <div class="clockdate-wrapper" style="display:flex; flex-direction:column;">
                    <div class="s-clock" id="clock"style="font-weight:bold; font-size:30px; color:#1A1553;" ></div>
                    <div class="s-date"  id="date" style="font-size:25px;"></div>
                </div>
        </div>
    </main>


</body>
<script src="js/all.js"></script>
<script src="js/jquery.js"></script>

</html>
<style>
@media(max-width:575px) and (max-width:767px) {
.s-clock{
  padding:30px;
}
.img-principal{
    width:70% !important;
}

.s-clock{
font-size: 20px!important;
}

.s-date{
    font-size: 15px!important;
}
}
</style>

<?php
mysqli_close($mysqli);
?>