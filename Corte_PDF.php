<?php
require "Conector.php";
require 'lib/fpdf/fpdf.php';

///------------------------------------ VARIABLES POST ---------------------------------------
$bandera=False;
if(isset($_GET['usuario'])){
    $usuario=$_GET['usuario'];
}
else{
    $usuario="";
}

if(isset($_GET['sucursal'])){
    $sucursal=$_GET['sucursal'];
}
else{
    $sucursal="";
}

//------------------------------------- VARIABLES DE USO -------------------------------------
date_default_timezone_set('America/Mexico_City');
//VARIABLE A REMPLAZAR POR LA DE POST
if(isset($_GET['fecha_inicial_fi'])){
    $fecha_inicial_fi =$_GET['fecha_inicial_fi'];
    
}
else{
    $fecha_inicial_fi="";
    $bandera=True;
}

$day_fi=date('d', strtotime($fecha_inicial_fi));
$mes_fi=date('m', strtotime($fecha_inicial_fi));
$year_fi=date('Y', strtotime($fecha_inicial_fi));



if(isset($_GET['fecha_final_ff'])){
    $fecha_final_ff =$_GET['fecha_final_ff'];
}
else{
    $fecha_final_ff="";
}


$day_ff=date('d', strtotime($fecha_final_ff));
$mes_ff=date('m', strtotime($fecha_final_ff));
$year_ff=date('Y', strtotime($fecha_final_ff));

$num_meses=array('01','02','03','04','05','06','07','08','09','10','11','12');
$meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");

for($i = 0; $i < count($num_meses); $i++){
    if ($mes_fi==$num_meses[$i]){
        $mes_fi=$meses[$i];
    }
}
for($j = 0; $j < count($num_meses); $j++){
        if ($mes_ff==$num_meses[$j]){
            $mes_ff=$meses[$j];
        }
    }
$fecha_corte_v1="CORTE DEL ".$day_fi." DE ".$mes_fi." AL ".$day_ff." DE ".$mes_ff." ".$year_ff;
$fecha_corte_v2=$day_fi." DE ".$mes_fi." AL ".$day_ff." DE ".$mes_ff." ".$year_ff;


//------------------------------------- REGISTRAR CORTE DE VENTA------------------------------------------


//-------------------------------------------------------------------------------------------------------

class ConductPDF extends FPDF { 
    function vcell($c_width,$c_height,$x_axis,$tam,$text){ 
    $w_w=$c_height/2; 
    $w_w_1=$w_w+2; 
    $w_w1=$w_w+$w_w+$w_w+1; 
    $len=strlen($text);
    if($len>$tam){ 
    $w_text=str_split($text,$tam); 
    $this->SetX($x_axis); 
    $this->Cell($c_width,$w_w_1,$w_text[0],'','',''); 
    $this->SetX($x_axis); 
    $this->Cell($c_width,$w_w1,$w_text[1],'','',''); 
    $this->SetX($x_axis); 
    $this->Cell($c_width,$c_height,'','LTRB',0,'L',0); 
    } 
    else{ 
        $this->SetX($x_axis); 
        $this->Cell($c_width,$c_height,$text,'LTRB',0,'L',0);} 
        } 
    } 


$pdf=new ConductPDF(); 
$pdf->AddPage();

//PRIMERA FILA
$x_axis=$pdf->getx();
$pdf->SetFont('Arial','B',15);
$pdf->SetTextColor(58,93,156);
$pdf->vcell(70,10,$x_axis,50,'RECIBO DE PAGO');

$x_axis=$pdf->getx();
$pdf->SetFont('Arial','',11);
$pdf->SetTextColor(255,16,42);
$pdf->vcell(119,10,$x_axis,50,utf8_decode($fecha_corte_v1));


//SEGUNDA FILA
$pdf->Ln(); 
$pdf->SetFont('Arial','B',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(25,6,'Recibi de:',1,0,'R');
$pdf->SetFont('Arial','',10);
$pdf->Cell(164,6,utf8_decode($usuario),1,1);

//TERCERA FILA
$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'Fecha:',1,0,'R');
$pdf->Cell(164,6,utf8_decode($fecha_corte_v2),1,1);

//CREAR HEADER DE LA TABLA  DE VENTAS
$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(16,10,'CANT',1,0,'C',1);
$pdf->Cell(65,10,' '.'ARTICULO',1,0,'L',1); 
$pdf->Cell(25,10,'PAGO',1,0,'C',1); 
$x_axis=$pdf->getx();
$pdf->vcell(31,10,$x_axis,15,'PRECIO MERCADO UNITARIO'); 
$pdf->Cell(28,10,'TOTAL',1,0,'C',1); 
$x_axis=$pdf->getx();
$pdf->vcell(24,10,$x_axis,9,'PRECIO A PAGAR'); 
$pdf->Ln(); 

//--------------------------------------CONTENIDO DE TABLA------------------------------------
// FALTA AGREGAR EL RANGO DE FECHAS A LA CONSULTA
$consultar_ventas="SELECT DISTINCT  v.id ,v.codigo,p.clave,p.nombre,p.marca,p.precio,p.descripcion, v.cantidad, v.total,v.tipo_pago, v.sucursal, v.fecha FROM ventas v inner join inventarios inv on v.codigo=inv.codigo  inner join productos p on inv.clave=p.clave where v.sucursal='$sucursal' AND v.fecha BETWEEN  '$fecha_inicial_fi' AND '$fecha_final_ff'";
$resultado_ventas=$mysqli -> query($consultar_ventas);
$c=1;
while ($row = mysqli_fetch_assoc($resultado_ventas)){
     $pdf->SetFont('Arial','',8.5);

     //COLUMNA CANTIDAD
     $pdf->Cell(16,10,$row['cantidad'],1,0,'C',1);

     //COLUMNA ARTICULO
     $x_axis=$pdf->getx();
     $nombre_p=$row['nombre']." ".$row['marca']."".$row['descripcion'];
     $pdf->vcell(65,10,$x_axis,33 ,$nombre_p);
    

     //COLUMNA PAGO
     $pdf->SetFont('Arial','',7.5);
     $tipo_pago=strtoupper($row['tipo_pago']);
     $pdf->Cell(25,10,$tipo_pago,1,0,'C',1);

     //COLUMNA PRECIO UNITARIO
     $pdf->SetFont('Arial','',10);
     $precio=$row['precio'];
     $pdf->Cell(5,10,'$',1,0,'C',1);
     $pdf->Cell(26,10,$precio,1,0,'R',1);
     

     //COLUMNA DE TOTAL
     $pdf->SetFont('Arial','',10);
     $pdf->Cell(5,10,'$',1,0,'C',1);
     $total=$row['total'];
     $pdf->Cell(23,10,$total,1,0,'R',1);

     //PRECIO A PAGAR
     $pdf->SetFont('Arial','',10);
     $pdf->Cell(24,10,'',1,0,'R',1,1);
     $pdf->Ln();
     $c++;
}

//------------------------------------------------------------------------------------------------
//SEPARACION
$pdf->Cell(189,5,'',0,0,'R',1);
$pdf->Ln();

//TOTAL
$consulta_total_venta="SELECT sum(total) as total_venta FROM ventas where sucursal='$sucursal' AND fecha BETWEEN '$fecha_inicial_fi' AND '$fecha_final_ff'";
$resultado_consulta_total_venta=$mysqli -> query($consulta_total_venta);
$total_venta= mysqli_fetch_array($resultado_consulta_total_venta);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(106,7,'TOTAL DE VENTAS',1,0,'R',1);

// TOTAL PRECIO
$pdf->SetFont('Arial','',10);
$total_venta_sum="$ ".$total_venta['total_venta'];
$pdf->Cell(59,7,$total_venta_sum,1,0,'R',1);

//FORMA DE PAGO
$pdf->Ln();
$pdf->SetFont('Arial','B',9);
$pdf->Cell(81,7,'FORMA DE PAGO',1,1);

//FORMA DE PAGO FILA EFECTIVO
$consulta_total_efectivo="SELECT sum(total) as total_efectivo FROM ventas where sucursal='$sucursal' and tipo_pago='Efectivo' and fecha BETWEEN '$fecha_inicial_fi' AND '$fecha_final_ff'";
$result_ventas_efect=$mysqli -> query($consulta_total_efectivo);
$tot_ventas_efectivo= mysqli_fetch_array($result_ventas_efect);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(10,7,'X',1,0,'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(20,7,'Efectivo',1,0,'L');

$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(255,16,42);
$efectivo_ventas="$ ".$tot_ventas_efectivo['total_efectivo'];
$pdf->Cell(51,7,$efectivo_ventas,1,0,'R');



//FORMA DE PAGO FILA TRANSFERENCIA
$consulta_total_transf="SELECT sum(total) as total_transf FROM ventas where sucursal='$sucursal' and tipo_pago='Transferencia' and fecha BETWEEN '$fecha_inicial_fi' AND '$fecha_final_ff'";
$result_ventas_transf=$mysqli -> query($consulta_total_transf);
$tot_ventas_transf= mysqli_fetch_array($result_ventas_transf);

$pdf->Ln();
$pdf->SetFont('Arial','B',8);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(10,7,'X',1,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(20,7,'Transferencia',1,0,'L');

$pdf->SetFont('Arial','B',11);
$pdf->SetTextColor(255,16,42);
$transf_ventas="$ ".$tot_ventas_transf['total_transf'];
$pdf->Cell(51,7,$transf_ventas,1,0,'R');

//TRANSFERENCIAS HEADER
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(106,7,'TRANSFERENCIAS',1,1,'C');
$pdf->Cell(43,7,'FECHA',1,0,'C');
$pdf->Cell(63,7,'CANTIDAD DEPOSITADA',1,1,'C');

//TRANSFERENCIAS PAGO Y FECHA
$consulta_transf_indiv="SELECT total,fecha FROM ventas where sucursal='$sucursal' and tipo_pago='Transferencia' and fecha BETWEEN '$fecha_inicial_fi' AND '$fecha_final_ff'";
$ventas_transf_indiv=$mysqli -> query($consulta_transf_indiv);

while($fil=mysqli_fetch_array($ventas_transf_indiv)){
    $pdf->SetFont('Arial','',9);
    $fecha_t1=$fil['fecha'];
    $pdf->Cell(43,7,$fecha_t1,1,0,'C');
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(5,7,"$",1,0,'C');
    $transfer=$fil['total'];
    $pdf->Cell(58,7,$transfer,1,1,'R');
}



//TOTAL DE DEPOSITOS
$consulta_depositos="SELECT sum(total) as total_deposito FROM ventas where sucursal='$sucursal' and tipo_pago='Transferencia' and fecha BETWEEN '$fecha_inicial_fi' AND '$fecha_final_ff'";
$resultado_depositos=$mysqli -> query($consulta_depositos);
$deposito=mysqli_fetch_array($resultado_depositos);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(43,7,'TOTAL DE DEPOSITOS',1,0,'C');
$pdf->SetTextColor(255,16,42);
$pdf->SetFont('Arial','B',11);
$dep=$deposito['total_deposito'];
$pdf->Cell(5,7,"$",1,0,'C');
$pdf->Cell(58,7,$dep,1,1,'R');

//FCEHA DE CORTE
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(255,16,42);
$pdf->Cell(106,7,$fecha_corte_v1,1,1,'C');

//RECIBIDO POR
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(43,7,'Recibido por:',0,0,'R');
$pdf->Cell(63,7,'_______________________________',0,1,'L');


$modo="I";
$nombre_archivo="Corte_".$sucursal."_".$fecha_inicial_fi."_al_".$fecha_final_ff;
$pdf->Output($nombre_archivo,$modo);
//$pdf->Output();
?>





